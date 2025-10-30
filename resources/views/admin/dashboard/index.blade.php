@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan performa dan aktivitas terbaru')

@section('content')
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6">
        <div class="bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium opacity-90">Total Booking</span>
                <i class="fas fa-calendar-check text-2xl opacity-80"></i>
            </div>
            <p class="text-3xl font-bold mb-1">{{ number_format($totalBookings) }}</p>
            <p class="text-xs opacity-75">{{ $bookingGrowth > 0 ? '+' : '' }}{{ number_format($bookingGrowth, 1) }}% vs bulan lalu</p>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-600">Pendapatan</span>
                <i class="fas fa-money-bill-trend-up text-2xl text-green-500"></i>
            </div>
            <p class="text-3xl font-bold text-gray-800 mb-1">
                @if($totalRevenue < 1000000)
                    Rp {{ number_format($totalRevenue / 1000, 0) }}rb
                @else
                    Rp {{ number_format($totalRevenue / 1000000, 1) }}jt
                @endif
            </p>
            <p class="text-xs {{ $revenueGrowth >= 0 ? 'text-green-600' : 'text-red-600' }}">{{ $revenueGrowth > 0 ? '+' : '' }}{{ number_format($revenueGrowth, 1) }}% vs bulan lalu</p>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-600">Lapangan Aktif</span>
                <i class="fas fa-layer-group text-2xl text-primary-500"></i>
            </div>
            <p class="text-3xl font-bold text-gray-800 mb-1">{{ $activeCourts }}</p>
            <p class="text-xs text-gray-500">dari {{ $totalCourts }} total</p>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-600">Rating Rata-rata</span>
                <i class="fas fa-star text-2xl text-yellow-400"></i>
            </div>
            <p class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($avgRating, 1) }}</p>
            <p class="text-xs text-gray-500">dari {{ $totalReviews }} ulasan</p>
        </div>
    </div>

    <!-- Charts + Top Venues -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Trend Pendapatan</h3>
                <form method="GET" action="{{ route('admin.dashboard') }}" id="periodForm">
                    <select name="period" onchange="this.form.submit()" class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Harian</option>
                        <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                        <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Tahunan</option>
                </select>
                </form>
            </div>
            <div class="h-56 relative">
                <canvas id="revenueTrendChart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <h3 class="font-semibold text-gray-900 mb-4">Lapangan Teratas</h3>
            <div class="space-y-3">
                @forelse ($topCourts as $court)
                <div class="p-3 border border-gray-100 rounded-lg flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-800">{{ $court->name }}</p>
                        <p class="text-xs text-gray-500">{{ $court->bookings_count ?? 0 }} booking</p>
                    </div>
                    <a href="{{ route('admin.fields.edit', $court) }}" class="px-3 py-1.5 bg-primary-50 text-primary-600 rounded-lg text-sm hover:bg-primary-100">Detail</a>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-inbox text-3xl mb-2"></i>
                    <p class="text-sm">Belum ada data</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Bookings Table -->
    <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100 overflow-x-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">Booking Terbaru</h3>
            <a href="{{ route('admin.bookings.index') }}" class="text-primary-600 text-sm hover:text-primary-700">Lihat semua</a>
        </div>
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left text-gray-500 border-b">
                    <th class="py-3 pr-6">Tanggal</th>
                    <th class="py-3 pr-6">Pelanggan</th>
                    <th class="py-3 pr-6">Lapangan</th>
                    <th class="py-3 pr-6">Jam</th>
                    <th class="py-3 pr-6">Total</th>
                    <th class="py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentBookings as $booking)
                <tr class="border-b last:border-0">
                    <td class="py-3 pr-6 text-gray-800">{{ $booking->date ? $booking->date->format('d M Y') : '-' }}</td>
                    <td class="py-3 pr-6 text-gray-800">{{ $booking->user->name ?? '-' }}</td>
                    <td class="py-3 pr-6 text-gray-800">{{ $booking->slot->venue->name ?? '-' }}</td>
                    <td class="py-3 pr-6 text-gray-800">{{ $booking->time ?? '-' }}</td>
                    <td class="py-3 pr-6 text-gray-800">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    <td class="py-3">
                        @php 
                            $statusColors = [
                                'confirmed' => 'blue',
                                'completed' => 'green',
                                'cancelled' => 'red',
                                'pending' => 'yellow',
                            ];
                            $color = $statusColors[$booking->status] ?? 'gray';
                            $statusLabels = [
                                'confirmed' => 'Dikonfirmasi',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                                'pending' => 'Menunggu',
                            ];
                            $label = $statusLabels[$booking->status] ?? $booking->status;
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-{{ $color }}-700 bg-{{ $color }}-50">{{ $label }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-3xl mb-2"></i>
                        <p class="text-sm">Belum ada booking</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Trend Chart
    const ctx = document.getElementById('revenueTrendChart');
    if (ctx) {
        const chartData = {!! json_encode($revenueTrend) !!};
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.map(item => item.label),
                datasets: [{
                    label: 'Pendapatan',
                    data: chartData.map(item => item.revenue),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        borderColor: 'rgba(59, 130, 246, 0.5)',
                        borderWidth: 1,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            title: function(context) {
                                return context[0].label;
                            },
                            label: function(context) {
                                const dataIndex = context.dataIndex;
                                const revenue = context.parsed.y;
                                const sports = chartData[dataIndex].sports;
                                
                                const lines = ['Pendapatan: Rp ' + revenue.toLocaleString('id-ID')];
                                
                                if (Object.keys(sports).length > 0) {
                                    lines.push(''); // Empty line
                                    lines.push('Olahraga:');
                                    Object.entries(sports).forEach(([sport, data]) => {
                                        lines.push(`• ${sport}: ${data.count}x (Rp ${data.revenue.toLocaleString('id-ID')})`);
                                    });
                                } else {
                                    lines.push('Tidak ada transaksi');
                                }
                                
                                return lines;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp ' + (value / 1000000).toFixed(1) + 'jt';
                                } else if (value >= 1000) {
                                    return 'Rp ' + (value / 1000).toFixed(0) + 'rb';
                                }
                                return 'Rp ' + value;
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
</script>
@endpush


