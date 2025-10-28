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
        $query = Slot::with(['venue', 'creator'])
            ->where('date', '>=', Carbon::today())
            ->where('current_participants', '<', 'max_participants')
            ->orderBy('date')
            ->orderBy('start_time');

        if ($request->filled('sport')) {
            $query->where('sport', $request->sport);
        }

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        if ($request->filled('location')) {
            $query->whereHas('venue', function($q) use ($request) {
                $q->where('location', $request->location);
            });
        }

        $slots = $query->get();

        return view('slots.index', compact('slots'));
    }

    public function join(Request $request, Slot $slot)
    {
        $user = auth()->user();

        // Check if user already joined this slot
        $existingParticipant = SlotParticipant::where('slot_id', $slot->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingParticipant) {
            return back()->with('error', 'You have already joined this slot.');
        }

        // Check if slot is full
        if ($slot->current_participants >= $slot->max_participants) {
            return back()->with('error', 'Slot is full.');
        }

        // Create booking
        $booking = Booking::create([
            'user_id' => $user->id,
            'slot_id' => $slot->id,
            'status' => 'confirmed',
        ]);

        // Create slot participant
        SlotParticipant::create([
            'slot_id' => $slot->id,
            'user_id' => $user->id,
        ]);

        // Update slot participants count
        $slot->increment('current_participants');

        return redirect()->route('bookings.index')->with('success', 'Successfully joined the slot!');
    }
}