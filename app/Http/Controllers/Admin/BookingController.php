<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        // Pending returns (belum diverifikasi admin)
        $returns = Booking::with('slot.venue','user')
            ->where('return_status', 'pending')
            ->orderBy('returned_at','desc')
            ->take(10)
            ->get()
            ->map(function($booking) {
                // Calculate overtime minutes
                if ($booking->returned_at && $booking->slot && $booking->slot->time) {
                    // Parse end time from "HH:MM - HH:MM"
                    $timeParts = explode(' - ', $booking->slot->time);
                    if (count($timeParts) === 2) {
                        $endTime = trim($timeParts[1]);
                        
                        // Combine date with end time (format date as Y-m-d only)
                        $dateOnly = \Carbon\Carbon::parse($booking->date)->format('Y-m-d');
                        $scheduledEnd = \Carbon\Carbon::parse($dateOnly . ' ' . $endTime);
                        
                        // Add 15 minute tolerance
                        $toleranceEnd = $scheduledEnd->copy()->addMinutes(15);
                        
                        // Calculate overtime
                        $returnedAt = \Carbon\Carbon::parse($booking->returned_at);
                        
                        if ($returnedAt->greaterThan($toleranceEnd)) {
                            $booking->overtime_minutes = $toleranceEnd->diffInMinutes($returnedAt);
                            
                            // Calculate suggested penalty: Rp 50,000 per 5 minutes
                            $fiveMinuteBlocks = ceil($booking->overtime_minutes / 5);
                            $booking->suggested_penalty = $fiveMinuteBlocks * 50000;
                        } else {
                            $booking->overtime_minutes = 0;
                            $booking->suggested_penalty = 0;
                        }
                    } else {
                        $booking->overtime_minutes = 0;
                        $booking->suggested_penalty = 0;
                    }
                } else {
                    $booking->overtime_minutes = 0;
                    $booking->suggested_penalty = 0;
                }
                
                return $booking;
            });
        
        // Unpaid penalties (sudah disetujui admin, tapi user belum bayar)
        $unpaidPenalties = Booking::with('slot.venue','user')
            ->where('return_status', 'approved')
            ->where('penalty_amount', '>', 0)
            ->whereNull('penalty_paid_at')
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        // All bookings with filters
        $query = Booking::with(['user', 'slot.venue', 'venue']);

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by venue/sport
        if ($request->filled('venue')) {
            $query->whereHas('slot.venue', function($q) use ($request) {
                $q->where('sport', 'like', '%' . $request->venue . '%');
            });
        }

        // Search by name or ID
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('id', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q2) use ($request) {
                      $q2->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $bookings = $query->latest()->paginate(15);

        return view('admin.bookings.index', compact('returns', 'unpaidPenalties', 'bookings'));
    }

    public function confirmReturn(Request $request, Booking $booking)
    {
        $request->validate([
            'decision' => 'required|in:approved,rejected',
            'fine_amount' => 'nullable|numeric|min:0',
        ]);

        $update = [ 'return_status' => $request->decision ];
        
        // Admin sets penalty amount manually
        if ($request->decision === 'approved') {
            $penaltyAmount = $request->fine_amount ?? 0;
            $update['penalty_amount'] = $penaltyAmount;
            $update['fine_amount'] = $penaltyAmount; // Keep for backward compatibility
        }

        $booking->update($update);
        
        $message = $request->decision === 'approved' 
            ? 'Pengembalian disetujui. Denda: Rp ' . number_format($request->fine_amount ?? 0, 0, ',', '.')
            : 'Pengembalian ditolak.';
            
        return back()->with('success', $message);
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'slot.venue', 'venue']);
        $userHistory = Booking::with(['slot.venue'])
            ->where('user_id', $booking->user_id)
            ->where('id', '!=', $booking->id)
            ->latest()
            ->take(10)
            ->get();

        return view('admin.bookings.show', compact('booking', 'userHistory'));
    }
}


