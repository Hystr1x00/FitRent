<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Slot;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get user's bookings with slot and venue data
        $bookings = $user->bookings()
            ->with(['slot.venue'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $totalBookings = $bookings->count();
        
        // Calculate monthly spending from bookings
        $monthlySpending = $bookings
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->where('created_at', '<=', Carbon::now()->endOfMonth())
            ->sum('total_price');
        
        // Get upcoming slots (slots user has joined)
        $upcomingSlots = $user->slotParticipants()
            ->whereHas('slot', function($query) {
                $query->where('date', '>=', Carbon::today());
            })
            ->count();
        
        // Get upcoming bookings
        $upcomingBookings = $bookings
            ->where('status', '!=', 'cancelled')
            ->where('created_at', '>=', Carbon::today())
            ->take(5);
        
        // Get created slots by user
        $createdSlots = $user->createdSlots()
            ->with('venue')
            ->orderBy('date', 'desc')
            ->get();
        
        // Get joined slots
        $joinedSlots = $user->slotParticipants()
            ->with('slot.venue')
            ->get();

        return view('dashboard.index', compact(
            'totalBookings',
            'monthlySpending', 
            'upcomingSlots',
            'upcomingBookings',
            'bookings',
            'createdSlots',
            'joinedSlots'
        ));
    }
}