@extends('admin.layouts.app')

@section('title', 'Kelola Lapangan')
@section('subtitle', 'Kelola dan atur lapangan olahraga Anda')

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6 lg:mb-8">
        <div class="bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium opacity-90">Total Lapangan</span>
                <i class="fas fa-layer-group text-2xl opacity-80"></i>
            </div>
            <p class="text-3xl font-bold mb-1">{{ $totalCourts }}</p>
            <p class="text-xs opacity-75">{{ $activeCourts }} aktif, {{ $maintenanceCourts }} maintenance</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-600">Booking Hari Ini</span>
                <i class="fas fa-calendar-check text-2xl text-green-500"></i>
            </div>
            <p class="text-3xl font-bold text-gray-800 mb-1">{{ $bookingsToday }}</p>
            <p class="text-xs {{ $bookingGrowth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ $bookingGrowth > 0 ? '+' : '' }}{{ number_format($bookingGrowth, 0) }}% dari kemarin
            </p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-600">Pendapatan Bulan Ini</span>
                <i class="fas fa-money-bill-wave text-2xl text-yellow-500"></i>
            </div>
            <p class="text-3xl font-bold text-gray-800 mb-1">
                @if($revenueThisMonth < 1000000)
                    Rp {{ number_format($revenueThisMonth / 1000, 0) }}rb
                @else
                    Rp {{ number_format($revenueThisMonth / 1000000, 1) }}jt
                @endif
            </p>
            <p class="text-xs text-yellow-600">Bulan {{ now()->locale('id')->translatedFormat('F') }}</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-600">Rating Rata-rata</span>
                <i class="fas fa-star text-2xl text-yellow-400"></i>
            </div>
            <p class="text-3xl font-bold text-gray-800 mb-1">{{ number_format($avgRating, 1) }}</p>
            <p class="text-xs text-gray-500">dari semua lapangan</p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 mb-6">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.fields.create') }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition font-medium flex items-center justify-center gap-2 shadow-md">
                <i class="fas fa-plus"></i>
                <span>Tambah Lapangan</span>
            </a>
        </div>
        <div class="flex gap-2">
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white text-gray-700">
                <option>Semua Status</option>
                <option>Aktif</option>
                <option>Maintenance</option>
                <option>Nonaktif</option>
            </select>
        </div>
    </div>

    <!-- Lapangan Cards Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($courts as $court)
            @php
                // Use venue status if available, otherwise use court status
                $venueStatus = $court->venue?->available ?? true;
                $actualStatus = $venueStatus ? $court->status : 'inactive';
                
                $statusColor = $actualStatus === 'active' ? 'green' : ($actualStatus === 'maintenance' ? 'yellow' : 'gray');
                $statusLabel = $actualStatus === 'active' ? 'Active' : ($actualStatus === 'maintenance' ? 'Maintenance' : 'Inactive');
            @endphp
            @include('admin.fields.partials.card', [
                'title' => $court->name,
                'sport' => $court->sport,
                'status' => $statusLabel,
                'statusColor' => $statusColor,
                'img' => $court->image ? asset('storage/' . $court->image) : 'https://images.unsplash.com/photo-1529900748604-07564a03e7a6?w=400',
                'bgFrom' => 'from-slate-200',
                'bgTo' => 'to-slate-300',
                'price' => 'Rp ' . number_format($court->price_per_session, 0, ',', '.'),
                'bookings' => $court->venue?->bookings()->count() . ' kali',
                'rating' => $court->venue?->rating ?? '4.8',
                'ratingCount' => '',
                'court' => $court,
            ])

            <!-- Edit moved to its own page -->

        @empty
            <div class="col-span-full">
                <div class="border border-dashed rounded-xl p-10 text-center text-gray-500">
                    Belum ada lapangan. Klik "Tambah Lapangan" untuk menambahkan.
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8">
        <p class="text-sm text-gray-600">{{ $courts->total() }} lapangan</p>
        {{ $courts->links() }}
    </div>

    <!-- Create moved to its own page -->
@endsection


