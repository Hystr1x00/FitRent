<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = User::withCount('bookings')
            ->where('role', 'user')
            ->whereHas('bookings', function($q) use ($user) {
                // Filter bookings by admin's venues if not superadmin
                if ($user && $user->role === 'field_admin') {
                    $adminVenueIds = Venue::where('admin_id', $user->id)->pluck('id')->toArray();
                    $q->whereIn('venue_id', $adminVenueIds);
                }
            });

        // Search by name, email, or phone
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by status (active users have recent bookings)
        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $query->whereHas('bookings', function($q) use ($user) {
                    $q->where('created_at', '>=', now()->subMonths(3));
                    // Filter by admin's venues if not superadmin
                    if ($user && $user->role === 'field_admin') {
                        $adminVenueIds = Venue::where('admin_id', $user->id)->pluck('id')->toArray();
                        $q->whereIn('venue_id', $adminVenueIds);
                    }
                });
            } elseif ($request->status == 'inactive') {
                $query->whereDoesntHave('bookings', function($q) use ($user) {
                    $q->where('created_at', '>=', now()->subMonths(3));
                    // Filter by admin's venues if not superadmin
                    if ($user && $user->role === 'field_admin') {
                        $adminVenueIds = Venue::where('admin_id', $user->id)->pluck('id')->toArray();
                        $q->whereIn('venue_id', $adminVenueIds);
                    }
                });
            }
        }

        $customers = $query->latest()->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        $admin = Auth::user();
        
        // Only allow viewing real customers with bookings
        if ($customer->role !== 'user') {
            abort(404, 'Customer tidak ditemukan.');
        }

        $customer->loadCount('bookings');
        
        $bookingsQuery = $customer->bookings()->with(['slot.venue']);
        
        // Filter by admin's venues if not superadmin
        if ($admin && $admin->role === 'field_admin') {
            $adminVenueIds = Venue::where('admin_id', $admin->id)->pluck('id')->toArray();
            
            // Check if customer has any bookings at admin's venues
            if (empty($adminVenueIds)) {
                return redirect()->route('admin.customers.index')->with('error', 'Anda tidak memiliki venue.');
            }
            
            // Verify customer has bookings at admin's venues BEFORE filtering query
            $hasBookingAtAdminVenues = $customer->bookings()
                ->whereIn('venue_id', $adminVenueIds)
                ->exists();
            
            if (!$hasBookingAtAdminVenues) {
                return redirect()->route('admin.customers.index')->with('error', 'Pelanggan tidak memiliki booking di venue Anda.');
            }
            
            $bookingsQuery->whereIn('venue_id', $adminVenueIds);
        }
        
        $bookings = $bookingsQuery->latest()->paginate(10);
        
        // If no bookings found for this admin, redirect back
        if ($bookings->total() === 0) {
            return redirect()->route('admin.customers.index')->with('error', 'Pelanggan tidak memiliki booking di venue Anda.');
        }

        return view('admin.customers.show', compact('customer', 'bookings'));
    }
}


