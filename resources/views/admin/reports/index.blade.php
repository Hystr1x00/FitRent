@extends('admin.layouts.app')

@section('title', 'Laporan')
@section('subtitle', 'Analitik dan laporan kinerja')

@section('content')
    <!-- Header Filters -->
    <form method="GET" action="{{ route('admin.reports.index') }}" class="bg-white rounded-xl p-4 md:p-6 shadow-md border border-gray-100 mb-6">
        <div class="flex flex-col md:flex-row gap-3 md:items-center md:justify-between">
            <div class="flex gap-2">
                <select name="period" onchange="this.form.submit()" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="week" {{ $period == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                    <option value="month" {{ $period == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="3months" {{ $period == '3months' ? 'selected' : '' }}>3 Bulan</option>
                    <option value="year" {{ $period == 'year' ? 'selected' : '' }}>1 Tahun</option>
                </select>
                <select name="sport" onchange="this.form.submit()" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="">Semua Cabang Olahraga</option>
                    <option value="Futsal" {{ $sport == 'Futsal' ? 'selected' : '' }}>Futsal</option>
                    <option value="Basket" {{ $sport == 'Basket' ? 'selected' : '' }}>Basket</option>
                    <option value="Badminton" {{ $sport == 'Badminton' ? 'selected' : '' }}>Badminton</option>
                    <option value="Padel" {{ $sport == 'Padel' ? 'selected' : '' }}>Padel</option>
                </select>
            </div>
        </div>
    </form>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6">
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-600">Total Booking</span>
                <i class="fas fa-calendar-check text-2xl text-primary-500"></i>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalBookings) }}</p>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-600">Pendapatan</span>
                <i class="fas fa-coins text-2xl text-yellow-500"></i>
            </div>
            <p class="text-2xl font-bold text-gray-800">
                @if($totalRevenue >= 1000000)
                    Rp {{ number_format($totalRevenue / 1000000, 1) }} jt
                @else
                    Rp {{ number_format($totalRevenue / 1000, 0) }} rb
                @endif
            </p>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-600">Cancel Rate</span>
                <i class="fas fa-ban text-2xl text-red-500"></i>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($cancelRate, 1) }}%</p>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-600">ARPU</span>
                <i class="fas fa-user text-2xl text-green-500"></i>
            </div>
            <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($arpu, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <h3 class="font-semibold text-gray-900 mb-4">Pendapatan per Hari</h3>
            <div class="h-64 relative">
                @if(count($revenuePerDay) > 0)
                    <canvas id="revenueChart"></canvas>
                    <div id="revenueEmptyStateReports" class="hidden absolute inset-0 flex items-center justify-center text-gray-500 text-sm">Belum ada data pada periode ini.</div>
                @else
                    <div class="h-full flex items-center justify-center text-gray-500">
                        <div class="text-center">
                            <i class="fas fa-chart-bar text-3xl mb-2"></i>
                            <p class="text-sm">Belum ada data pendapatan</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <h3 class="font-semibold text-gray-900 mb-4">Distribusi Olahraga</h3>
            <div class="h-64 relative flex items-center justify-center">
                @if($sportDistribution->count() > 0)
                    <canvas id="sportChart"></canvas>
                @else
                    <div class="text-center text-gray-500">
                        <i class="fas fa-chart-pie text-3xl mb-2"></i>
                        <p class="text-sm">Belum ada data</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Helper function to format currency
    function formatRupiah(value) {
        if (value >= 1000000) {
            return 'Rp ' + (value / 1000000).toFixed(1) + ' jt';
        } else if (value >= 1000) {
            return 'Rp ' + (value / 1000).toFixed(0) + ' rb';
        } else {
            return 'Rp ' + value.toLocaleString('id-ID');
        }
    }

    // Revenue per day chart (modern line)
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        const chartData = {!! json_encode($revenuePerDay) !!};
        const gctx = revenueCtx.getContext('2d');
        const containerH = (revenueCtx.parentElement && revenueCtx.parentElement.offsetHeight) ? revenueCtx.parentElement.offsetHeight : 256;
        const gradient = gctx.createLinearGradient(0, 0, 0, containerH);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.25)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

        const sumRevenue = chartData.reduce((s, it) => s + (parseFloat(it.revenue) || 0), 0);
        const hasData = sumRevenue > 0;
        const emptyEl = document.getElementById('revenueEmptyStateReports');
        if (emptyEl && !hasData) {
            emptyEl.classList.remove('hidden');
        } else {
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: chartData.map(item => item.date),
                datasets: [{
                    label: 'Pendapatan',
                    data: chartData.map(item => parseFloat(item.revenue) || 0),
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 3,
                    backgroundColor: gradient,
                    tension: 0.35,
                    fill: true,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: 'rgb(59, 130, 246)',
                    pointBorderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#e2e8f0',
                        bodyColor: '#cbd5e1',
                        padding: 12,
                        borderColor: '#1e293b',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                return 'Pendapatan: ' + formatRupiah(context.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(148, 163, 184, 0.15)' },
                        ticks: {
                            callback: function(value) { return formatRupiah(value); }
                        }
                    },
                    x: { grid: { display: false } }
                },
                animation: { duration: 900, easing: 'easeOutQuart' }
            }
        });
        }
    }

    // Sport distribution chart
    const sportCtx = document.getElementById('sportChart');
    if (sportCtx) {
        const sportData = {!! json_encode($sportDistribution) !!};
        console.log('Sport Chart Data:', sportData); // Debug
        
        const colors = [
            'rgba(59, 130, 246, 0.8)',
            'rgba(16, 185, 129, 0.8)',
            'rgba(251, 146, 60, 0.8)',
            'rgba(236, 72, 153, 0.8)',
            'rgba(168, 85, 247, 0.8)'
        ];
        
        new Chart(sportCtx, {
            type: 'doughnut',
            data: {
                labels: sportData.map(s => s.sport),
                datasets: [{
                    data: sportData.map(s => s.count),
                    backgroundColor: colors.slice(0, sportData.length),
                    borderWidth: 3,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return label + ': ' + value + ' booking (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }
</script>
@endpush


