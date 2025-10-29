<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $returns = Booking::with('slot.venue','user')
            ->where('return_status', 'pending')
            ->orderBy('returned_at','desc')
            ->take(10)
            ->get();
        return view('admin.bookings.index', compact('returns'));
    }

    public function confirmReturn(Request $request, Booking $booking)
    {
        $request->validate([
            'decision' => 'required|in:approved,rejected',
            'fine_amount' => 'nullable|numeric|min:0',
        ]);

        $update = [ 'return_status' => $request->decision ];
        if ($request->decision === 'approved') {
            $update['fine_amount'] = $request->fine_amount ?? 0;
        }

        $booking->update($update);
        return back()->with('success', 'Status pengembalian diperbarui.');
    }
}


