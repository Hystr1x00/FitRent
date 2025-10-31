<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('bookings')
            ->where('role', 'user')
            ->whereHas('bookings');

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
                $query->whereHas('bookings', function($q) {
                    $q->where('created_at', '>=', now()->subMonths(3));
                });
            } elseif ($request->status == 'inactive') {
                $query->whereDoesntHave('bookings', function($q) {
                    $q->where('created_at', '>=', now()->subMonths(3));
                });
            }
        }

        $customers = $query->latest()->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $user)
    {
        // Only allow viewing real customers with bookings
        abort_unless($user->role === 'user', 404);

        $user->loadCount('bookings');
        $bookings = $user->bookings()->with(['slot.venue'])->latest()->paginate(10);

        return view('admin.customers.show', compact('user', 'bookings'));
    }
}


