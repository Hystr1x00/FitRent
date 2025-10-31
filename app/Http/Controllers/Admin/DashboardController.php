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
        $totalReviews = 0; 

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
                // Last 7 days only
                // Aggregate by day using DB for reliability
                $start = Carbon::now()->subDays(6)->startOfDay();
                $end = Carbon::now()->endOfDay();
                $daily = Booking::selectRaw('DATE(created_at) as d, SUM(total_price) as total')
                    ->whereBetween('created_at', [$start, $end])
                    ->groupBy('d')
                    ->pluck('total', 'd');
                for ($i = 6; $i >= 0; $i--) {
                    $date = Carbon::now()->subDays($i)->toDateString();
                    $total = (float) ($daily[$date] ?? 0);
                    $trend[] = [
                        'label' => Carbon::parse($date)->format('d M'),
                        'revenue' => $total,
                        'sports' => []
                    ];
                }
                break;
                
            case 'yearly':
                // Last 12 months
                // Aggregate by month for last 12 months
                $start = Carbon::now()->subMonths(11)->startOfMonth();
                $monthly = Booking::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as ym, SUM(total_price) as total')
                    ->where('created_at', '>=', $start)
                    ->groupBy('ym')
                    ->pluck('total', 'ym');
                for ($i = 11; $i >= 0; $i--) {
                    $date = Carbon::now()->subMonths($i);
                    $key = $date->format('Y-m');
                    $total = (float) ($monthly[$key] ?? 0);
                    $trend[] = [
                        'label' => $date->format('M Y'),
                        'revenue' => $total,
                        'sports' => []
                    ];
                }
                break;
                
            case 'monthly':
            default:
                // Last 14 days (2 weeks)
                // Last 14 days aggregate
                $start = Carbon::now()->subDays(13)->startOfDay();
                $daily = Booking::selectRaw('DATE(created_at) as d, SUM(total_price) as total')
                    ->whereBetween('created_at', [$start, Carbon::now()->endOfDay()])
                    ->groupBy('d')
                    ->pluck('total', 'd');
                for ($i = 13; $i >= 0; $i--) {
                    $date = Carbon::now()->subDays($i)->toDateString();
                    $total = (float) ($daily[$date] ?? 0);
                    $trend[] = [
                        'label' => Carbon::parse($date)->format('d M'),
                        'revenue' => $total,
                        'sports' => []
                    ];
                }
                break;
        }
        
        return $trend;
    }
}


