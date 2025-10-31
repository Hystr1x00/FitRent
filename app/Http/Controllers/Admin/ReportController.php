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

        // Date range based on period (calendar boundaries)
        $dateRange = $this->getDateRange($period);
        
        // Build query with filters (use booking date for reports)
        $query = Booking::whereBetween('date', $dateRange);
        
        if ($sport) {
            $query->whereHas('slot.venue', function($q) use ($sport) {
                $q->where('sport', $sport);
            });
        }

        // Total bookings
        $totalBookings = $query->count();

        // Total revenue
        $totalRevenue = (clone $query)->sum('total_price');

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
            'week' => [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()],
            'month' => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
            '3months' => [$now->copy()->subMonths(2)->startOfMonth(), $now->copy()->endOfMonth()],
            'year' => [$now->copy()->startOfYear(), $now->copy()->endOfYear()],
            default => [$now->copy()->subMonth(), $now],
        };
    }

    private function getRevenuePerDay($dateRange, $sport = '')
    {
        $query = Booking::select(
                DB::raw('bookings.date as d'),
                DB::raw('SUM(bookings.total_price) as revenue')
            )
            ->whereBetween('bookings.date', $dateRange);

        if ($sport) {
            $query->whereHas('slot.venue', function($q) use ($sport) {
                $q->where('sport', $sport);
            });
        }

        $revenues = $query->groupBy(DB::raw('bookings.date'))
            ->orderBy('d')
            ->get()
            ->pluck('revenue', 'd')
            ->toArray();

        // Fill missing dates with 0
        $result = [];
        $start = Carbon::parse($dateRange[0]);
        $end = Carbon::parse($dateRange[1]);
        
        while ($start <= $end) {
            $dateKey = $start->format('Y-m-d');
            $revenueValue = isset($revenues[$dateKey]) ? (float)$revenues[$dateKey] : 0.0;
            $result[] = [
                'date' => $start->format('M d'),
                'revenue' => $revenueValue,
            ];
            $start->addDay();
        }

        return $result;
    }
}


