<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Court;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Determine period
        $period = $request->get('period', 'month');
        $sport = $request->get('sport', '');
        
        // Date range based on period (calendar boundaries)
        $dateRange = $this->getDateRange($period);
        
        // Debug: Log date range (can be removed after debugging)
        if (config('app.debug')) {
            \Log::info('Report Date Range', [
                'period' => $period,
                'dateRange' => [
                    'start' => $dateRange[0] instanceof Carbon ? $dateRange[0]->format('Y-m-d') : $dateRange[0],
                    'end' => $dateRange[1] instanceof Carbon ? $dateRange[1]->format('Y-m-d') : $dateRange[1],
                ],
                'user_id' => $user->id ?? null,
                'user_role' => $user->role ?? null,
            ]);
        }
        
        // Build query with filters (use booking date for reports)
        // Convert Carbon to date string for whereBetween with date field
        $dateStart = $dateRange[0] instanceof Carbon ? $dateRange[0]->format('Y-m-d') : $dateRange[0];
        $dateEnd = $dateRange[1] instanceof Carbon ? $dateRange[1]->format('Y-m-d') : $dateRange[1];
        $query = Booking::whereBetween('date', [$dateStart, $dateEnd]);
        
        // Filter by admin if not superadmin
        if ($user && $user->role === 'field_admin') {
            $adminVenueIds = Venue::where('admin_id', $user->id)->pluck('id')->toArray();
            
            // Debug: Log venue IDs (can be removed after debugging)
            if (config('app.debug')) {
                \Log::info('Admin Venues', [
                    'user_id' => $user->id,
                    'venue_ids' => $adminVenueIds,
                    'venue_count' => count($adminVenueIds),
                ]);
            }
            
            if (empty($adminVenueIds)) {
                // If admin has no venues, return zero results
                $query->whereRaw('1 = 0'); // Force empty result
            } else {
                $query->whereIn('venue_id', $adminVenueIds);
            }
        }
        
        // Debug: Log query (can be removed after debugging)
        if (config('app.debug')) {
            $allBookingsInRange = Booking::whereBetween('date', [$dateStart, $dateEnd])->count();
            \Log::info('Report Query Debug', [
                'all_bookings_in_range' => $allBookingsInRange,
                'date_start' => $dateStart,
                'date_end' => $dateEnd,
                'filtered_query_sql' => $query->toSql(),
                'filtered_query_bindings' => $query->getBindings(),
            ]);
        }
        
        // Filter by sport if specified
        if ($sport) {
            $query->whereHas('venue', function($q) use ($sport) {
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
        $revenuePerDay = $this->getRevenuePerDay($dateRange, $sport, $user);

        // Sport distribution (for pie chart)
        $sportDistributionQuery = Booking::select('venues.sport', DB::raw('COUNT(*) as count'))
            ->join('slots', 'bookings.slot_id', '=', 'slots.id')
            ->join('venues', 'slots.venue_id', '=', 'venues.id')
            ->whereBetween('bookings.date', [$dateStart, $dateEnd]); // Use 'date' instead of 'created_at' for consistency
        
        // Filter by admin if not superadmin
        if ($user && $user->role === 'field_admin') {
            $adminVenueIds = Venue::where('admin_id', $user->id)->pluck('id')->toArray();
            if (empty($adminVenueIds)) {
                // If admin has no venues, return empty result
                $sportDistribution = collect();
            } else {
                $sportDistributionQuery->whereIn('bookings.venue_id', $adminVenueIds);
            }
        }
        
        // Filter by sport if specified
        if ($sport) {
            $sportDistributionQuery->where('venues.sport', $sport);
        }
        
        // Execute query
        if (isset($sportDistribution)) {
            // Already set to empty collection above
        } else {
            $sportDistribution = $sportDistributionQuery->groupBy('venues.sport')
                ->get();
        }

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
            'week' => [
                $now->copy()->startOfWeek()->startOfDay(),
                $now->copy()->endOfWeek()->endOfDay()
            ],
            'month' => [
                $now->copy()->startOfMonth()->startOfDay(),
                $now->copy()->endOfMonth()->endOfDay()
            ],
            '3months' => [
                $now->copy()->subMonths(2)->startOfMonth()->startOfDay(),
                $now->copy()->endOfMonth()->endOfDay()
            ],
            'year' => [
                $now->copy()->startOfYear()->startOfDay(),
                $now->copy()->endOfYear()->endOfDay()
            ],
            default => [
                $now->copy()->startOfMonth()->startOfDay(),
                $now->copy()->endOfMonth()->endOfDay()
            ],
        };
    }

    private function getRevenuePerDay($dateRange, $sport = '', $user = null)
    {
        if (!$user) {
            $user = Auth::user();
        }
        
        // Convert Carbon to date string for whereBetween with date field
        $dateStart = $dateRange[0] instanceof Carbon ? $dateRange[0]->format('Y-m-d') : $dateRange[0];
        $dateEnd = $dateRange[1] instanceof Carbon ? $dateRange[1]->format('Y-m-d') : $dateRange[1];
        
        $query = Booking::select(
                DB::raw('bookings.date as d'),
                DB::raw('SUM(bookings.total_price) as revenue')
            )
            ->whereBetween('bookings.date', [$dateStart, $dateEnd]);

        // Filter by admin if not superadmin
        if ($user && $user->role === 'field_admin') {
            $adminVenueIds = Venue::where('admin_id', $user->id)->pluck('id')->toArray();
            if (empty($adminVenueIds)) {
                // If admin has no venues, return empty result
                $query->whereRaw('1 = 0'); // Force empty result
            } else {
                $query->whereIn('bookings.venue_id', $adminVenueIds);
            }
        }

        // Filter by sport if specified
        if ($sport) {
            $query->whereHas('venue', function($q) use ($sport) {
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


