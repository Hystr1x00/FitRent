<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slot;
use App\Models\Booking;
use App\Models\SlotParticipant;
use Carbon\Carbon;

class SlotController extends Controller
{
    public function index(Request $request)
    {
        $query = Slot::with(['venue', 'creator', 'participants'])
            ->where('status', 'open')  // Only show open slots
            ->where('date', '>=', Carbon::today())
            ->where('current_participants', '<', 'max_participants')
            ->whereHas('venue', function($q) {
                $q->where('available', true);
            })
            ->orderBy('date')
            ->orderBy('time');

        // Filter by sport
        if ($request->filled('sport')) {
            $query->whereHas('venue', function($q) use ($request) {
                $q->where('sport', $request->sport);
            });
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->whereHas('venue', function($q) use ($request) {
                $q->where('location', 'like', '%' . $request->location . '%');
            });
        }

        $slots = $query->paginate(12);

        return view('slots.index', compact('slots'));
    }

    public function join(Request $request, Slot $slot)
    {
        $user = auth()->user();

        // Check if venue is available
        if (!$slot->venue || !$slot->venue->available) {
            return back()->with('error', 'Venue tidak tersedia.');
        }

        // Check if slot is open
        if ($slot->status !== 'open') {
            return back()->with('error', 'Slot ini sudah tidak tersedia.');
        }

        // Check if user already joined this slot
        $existingParticipant = SlotParticipant::where('slot_id', $slot->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingParticipant) {
            return back()->with('error', 'Anda sudah join slot ini.');
        }

        // Check if slot is full
        if ($slot->current_participants >= $slot->max_participants) {
            return back()->with('error', 'Slot sudah penuh.');
        }

        // Calculate total price (price per person + service fee)
        $pricePerPerson = $slot->price_per_person;
        $serviceFee = 5000;
        $totalPrice = $pricePerPerson + $serviceFee;

        // Create booking with complete data
        $booking = Booking::create([
            'user_id' => $user->id,
            'venue_id' => $slot->venue_id,
            'slot_id' => $slot->id,
            'type' => 'shared',
            'date' => $slot->date,
            'time' => $slot->time,
            'total_price' => $totalPrice,
            'status' => 'confirmed',
            'payment_status' => 'paid',  // Auto-paid for now
        ]);

        // Create slot participant
        SlotParticipant::create([
            'slot_id' => $slot->id,
            'user_id' => $user->id,
        ]);

        // Update slot participants count
        $slot->increment('current_participants');

        // If slot is now full, mark as confirmed
        if ($slot->current_participants >= $slot->max_participants) {
            $slot->update(['status' => 'confirmed']);
        }

        return redirect()->route('bookings.index')->with('success', 'Berhasil join slot! Pembayaran Rp ' . number_format($totalPrice, 0, ',', '.') . ' dikonfirmasi.');
    }
}