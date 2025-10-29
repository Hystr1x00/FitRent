<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Booking;
use App\Models\Slot;
use App\Models\SlotParticipant;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function create(Venue $venue)
    {
        $venue->load(['courts.availableDates']);
        $availableDates = $venue->courts
            ->flatMap(fn($c) => $c->availableDates->pluck('date'))
            ->filter()
            ->map(fn($d) => \Carbon\Carbon::parse($d)->startOfDay())
            ->unique(fn($d) => $d->toDateString())
            ->sort()
            ->values();
        return view('bookings.create', compact('venue', 'availableDates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'booking_type' => 'required|in:private,shared',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'max_participants' => 'required_if:booking_type,shared|integer|min:2|max:20',
            'notes' => 'nullable|string|max:500',
        ]);

        $venue = Venue::findOrFail($request->venue_id);
        $user = auth()->user();

        if ($request->booking_type === 'private') {
            // Private booking - create slot for private use
            $slot = Slot::create([
                'venue_id' => $venue->id,
                'creator_id' => $user->id,
                'sport' => $venue->sport,
                'date' => $request->date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'max_participants' => 1,
                'current_participants' => 1,
            ]);

            $booking = Booking::create([
                'user_id' => $user->id,
                'slot_id' => $slot->id,
                'status' => 'confirmed',
            ]);
        } else {
            // Shared booking - create slot
            $slot = Slot::create([
                'venue_id' => $venue->id,
                'creator_id' => $user->id,
                'sport' => $venue->sport,
                'date' => $request->date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'max_participants' => $request->max_participants,
                'current_participants' => 1,
            ]);

            $booking = Booking::create([
                'user_id' => $user->id,
                'slot_id' => $slot->id,
                'status' => 'confirmed',
            ]);

            // Create slot participant for creator
            SlotParticipant::create([
                'slot_id' => $slot->id,
                'user_id' => $user->id,
            ]);
        }

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully!');
    }

    public function index()
    {
        $user = auth()->user();
        
        $bookings = $user->bookings()
            ->with('slot.venue')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        // Ensure the authenticated user owns the booking
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }
        
        $booking->load('slot.venue', 'slot.participants');
        return view('bookings.show', compact('booking'));
    }

    public function submitReturn(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'return_photo' => 'required|image|max:4096',
            'return_note' => 'nullable|string|max:500',
            'returned_at' => 'required|date',
        ]);

        $path = $request->file('return_photo')->store('returns', 'public');

        // Compute overtime vs scheduled end + 15 minutes
        $slotEnd = Carbon::parse($booking->slot->date->toDateString() . ' ' . $booking->slot->end_time);
        $bufferEnd = $slotEnd->copy()->addMinutes(15);
        $actual = Carbon::parse($request->returned_at);
        $overtime = $actual->greaterThan($bufferEnd) ? $bufferEnd->diffInMinutes($actual) : 0;

        $booking->update([
            'return_photo' => $path,
            'return_note' => $request->return_note,
            'returned_at' => $actual,
            'overtime_minutes' => $overtime,
            'return_status' => 'pending',
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'Pengembalian terkirim. Menunggu konfirmasi admin.');
    }
}