<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Court;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Determine period
        $period = $request->get('period', 'month');
        $sport = $request->get('sport', '');

        // Date range based on period
        $dateRange = $this->getDateRange($period);
        
        // Build query with filters
        $query = Booking::whereBetween('created_at', $dateRange);
        
        if ($sport) {
            $query->whereHas('slot.venue', function($q) use ($sport) {
                $q->where('sport', $sport);
            });
        }

        // Total bookings
        $totalBookings = $query->count();

        // Total revenue
        $totalRevenue = $query->where('payment_status', 'paid')->sum('total_price');

        // Cancel rate
        $cancelledCount = (clone $query)->where('status', 'cancelled')->count();
        $cancelRate = $totalBookings > 0 ? ($cancelledCount / $totalBookings * 100) : 0;

        // ARPU (Average Revenue Per User)
        $uniqueUsers = (clone $query)->distinct('user_id')->count('user_id');
        $arpu = $uniqueUsers > 0 ? ($totalRevenue / $uniqueUsers) : 0;

        // Revenue per day (for chart)
        $revenuePerDay = $this->getRevenuePerDay($dateRange, $sport);

        // Sport distribution (for pie chart)
        $sportDistribution = Booking::select('venues.sport', DB::raw('COUNT(*) as count'))
            ->join('slots', 'bookings.slot_id', '=', 'slots.id')
            ->join('venues', 'slots.venue_id', '=', 'venues.id')
            ->whereBetween('bookings.created_at', $dateRange)
            ->groupBy('venues.sport')
            ->get();

        return view('admin.reports.index', compact(
            'totalBookings',
            'totalRevenue',
            'cancelRate',
            'arpu',
            'revenuePerDay',
            'sportDistribution',
            'period',
            'sport'
        ));
    }

    private function getDateRange($period)
    {
        $now = Carbon::now();
        
        return match($period) {
            'week' => [$now->copy()->subWeek(), $now],
            'month' => [$now->copy()->subMonth(), $now],
            '3months' => [$now->copy()->subMonths(3), $now],
            'year' => [$now->copy()->subYear(), $now],
            default => [$now->copy()->subMonth(), $now],
        };
    }

    private function getRevenuePerDay($dateRange, $sport = '')
    {
        $query = Booking::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_price) as revenue')
            )
            ->whereBetween('created_at', $dateRange)
            ->where('payment_status', 'paid');

        if ($sport) {
            $query->whereHas('slot.venue', function($q) use ($sport) {
                $q->where('sport', $sport);
            });
        }

        $revenues = $query->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get()
            ->pluck('revenue', 'date')
            ->toArray();

        // Fill missing dates with 0
        $result = [];
        $start = Carbon::parse($dateRange[0]);
        $end = Carbon::parse($dateRange[1]);
        
        while ($start <= $end) {
            $dateKey = $start->format('Y-m-d');
            $result[] = [
                'date' => $start->format('M d'),
                'revenue' => $revenues[$dateKey] ?? 0
            ];
            $start->addDay();
        }

        return $result;
    }
}


