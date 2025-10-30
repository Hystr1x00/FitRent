<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Court;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Total bookings
        $totalBookings = Booking::count();
        $lastMonthBookings = Booking::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $twoMonthsAgoBookings = Booking::whereBetween('created_at', [Carbon::now()->subMonths(2), Carbon::now()->subMonth()])->count();
        $bookingGrowth = $twoMonthsAgoBookings > 0 ? (($lastMonthBookings - $twoMonthsAgoBookings) / $twoMonthsAgoBookings * 100) : 0;

        // Total revenue
        $totalRevenue = Booking::where('payment_status', 'paid')->sum('total_price');
        $lastMonthRevenue = Booking::where('payment_status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subMonth())
            ->sum('total_price');
        $twoMonthsAgoRevenue = Booking::where('payment_status', 'paid')
            ->whereBetween('created_at', [Carbon::now()->subMonths(2), Carbon::now()->subMonth()])
            ->sum('total_price');
        $revenueGrowth = $twoMonthsAgoRevenue > 0 ? (($lastMonthRevenue - $twoMonthsAgoRevenue) / $twoMonthsAgoRevenue * 100) : 0;

        // Courts statistics
        $activeCourts = Court::where('status', 'active')->count();
        $totalCourts = Court::count();

        // Average rating
        $avgRating = Court::avg('rating') ?? 0;
        $totalReviews = 0; // Jika ada model Review, bisa dihitung dari sana

        // Top courts by bookings
        $topCourts = Court::select('courts.*', DB::raw('COUNT(bookings.id) as bookings_count'))
            ->leftJoin('venues', 'courts.venue_id', '=', 'venues.id')
            ->leftJoin('slots', 'venues.id', '=', 'slots.venue_id')
            ->leftJoin('bookings', 'slots.id', '=', 'bookings.slot_id')
            ->groupBy('courts.id')
            ->orderByDesc('bookings_count')
            ->limit(3)
            ->get();

        // Recent bookings
        $recentBookings = Booking::with(['user', 'slot.venue'])
            ->latest()
            ->limit(10)
            ->get();

        // Revenue trend based on period filter
        $period = $request->get('period', 'monthly');
        $revenueTrend = $this->getRevenueTrend($period);

        return view('admin.dashboard.index', compact(
            'totalBookings',
            'bookingGrowth',
            'totalRevenue',
            'revenueGrowth',
            'activeCourts',
            'totalCourts',
            'avgRating',
            'totalReviews',
            'topCourts',
            'recentBookings',
            'revenueTrend',
            'period'
        ));
    }

    private function getRevenueTrend($period)
    {
        $trend = [];
        
        switch ($period) {
            case 'daily':
                // Last 30 days
                for ($i = 29; $i >= 0; $i--) {
                    $date = Carbon::now()->subDays($i);
                    $revenue = Booking::where('payment_status', 'paid')
                        ->whereDate('created_at', $date)
                        ->with('slot.venue')
                        ->get();
                    
                    $sports = $revenue->groupBy(function($booking) {
                        return $booking->slot->venue->sport ?? 'Unknown';
                    })->map(function($group) {
                        return [
                            'count' => $group->count(),
                            'revenue' => $group->sum('total_price')
                        ];
                    })->toArray();
                    
                    $trend[] = [
                        'label' => $date->format('d M'),
                        'revenue' => $revenue->sum('total_price'),
                        'sports' => $sports
                    ];
                }
                break;
                
            case 'yearly':
                // Last 12 months
                for ($i = 11; $i >= 0; $i--) {
                    $date = Carbon::now()->subMonths($i);
                    $revenue = Booking::where('payment_status', 'paid')
                        ->whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month)
                        ->with('slot.venue')
                        ->get();
                    
                    $sports = $revenue->groupBy(function($booking) {
                        return $booking->slot->venue->sport ?? 'Unknown';
                    })->map(function($group) {
                        return [
                            'count' => $group->count(),
                            'revenue' => $group->sum('total_price')
                        ];
                    })->toArray();
                    
                    $trend[] = [
                        'label' => $date->format('M Y'),
                        'revenue' => $revenue->sum('total_price'),
                        'sports' => $sports
                    ];
                }
                break;
                
            case 'monthly':
            default:
                // Last 30 days
                for ($i = 29; $i >= 0; $i--) {
                    $date = Carbon::now()->subDays($i);
                    $revenue = Booking::where('payment_status', 'paid')
                        ->whereDate('created_at', $date)
                        ->with('slot.venue')
                        ->get();
                    
                    $sports = $revenue->groupBy(function($booking) {
                        return $booking->slot->venue->sport ?? 'Unknown';
                    })->map(function($group) {
                        return [
                            'count' => $group->count(),
                            'revenue' => $group->sum('total_price')
                        ];
                    })->toArray();
                    
                    $trend[] = [
                        'label' => $date->format('d M'),
                        'revenue' => $revenue->sum('total_price'),
                        'sports' => $sports
                    ];
                }
                break;
        }
        
        return $trend;
    }
}


