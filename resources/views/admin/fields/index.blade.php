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
            <p class="text-3xl font-bold mb-1">12</p>
            <p class="text-xs opacity-75">8 aktif, 4 maintenance</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-600">Booking Hari Ini</span>
                <i class="fas fa-calendar-check text-2xl text-green-500"></i>
            </div>
            <p class="text-3xl font-bold text-gray-800 mb-1">24</p>
            <p class="text-xs text-green-600">+12% dari kemarin</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-600">Pendapatan Bulan Ini</span>
                <i class="fas fa-money-bill-wave text-2xl text-yellow-500"></i>
            </div>
            <p class="text-3xl font-bold text-gray-800 mb-1">Rp 45.2jt</p>
            <p class="text-xs text-yellow-600">Target 70%</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-600">Rating Rata-rata</span>
                <i class="fas fa-star text-2xl text-yellow-400"></i>
            </div>
            <p class="text-3xl font-bold text-gray-800 mb-1">4.8</p>
            <p class="text-xs text-gray-500">dari 156 ulasan</p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 mb-6">
        <div class="flex flex-wrap gap-2">
            <button class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition font-medium flex items-center justify-center gap-2 shadow-md">
                <i class="fas fa-plus"></i>
                <span>Tambah Lapangan</span>
            </button>
            <button class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium flex items-center justify-center gap-2">
                <i class="fas fa-download"></i>
                <span class="hidden sm:inline">Ekspor</span>
            </button>
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

    <!-- Lapangan Cards Grid (static demo) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @include('admin.fields.partials.card', [
            'title' => 'Lapangan Futsal A',
            'sport' => 'Futsal',
            'status' => 'Aktif',
            'statusColor' => 'green',
            'img' => 'https://images.unsplash.com/photo-1529900748604-07564a03e7a6?w=400',
            'bgFrom' => 'from-green-400',
            'bgTo' => 'to-green-600',
            'price' => 'Rp 150.000',
            'bookings' => '32 kali',
            'rating' => '4.9',
            'ratingCount' => '(28)'
        ])

        @include('admin.fields.partials.card', [
            'title' => 'Lapangan Basket 1',
            'sport' => 'Basket',
            'status' => 'Aktif',
            'statusColor' => 'green',
            'img' => 'https://images.unsplash.com/photo-1594623930572-300a3011d9ae?w=400',
            'bgFrom' => 'from-orange-400',
            'bgTo' => 'to-orange-600',
            'price' => 'Rp 100.000',
            'bookings' => '24 kali',
            'rating' => '4.7',
            'ratingCount' => '(19)'
        ])

        @include('admin.fields.partials.card', [
            'title' => 'Lapangan Badminton 2',
            'sport' => 'Badminton',
            'status' => 'Maintenance',
            'statusColor' => 'yellow',
            'img' => 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?w=400',
            'bgFrom' => 'from-blue-400',
            'bgTo' => 'to-blue-600',
            'price' => 'Rp 80.000',
            'bookings' => '18 kali',
            'rating' => '4.8',
            'ratingCount' => '(15)'
        ])
    </div>

    <!-- Pagination -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8">
        <p class="text-sm text-gray-600">Menampilkan 1-6 dari 12 lapangan</p>
        <div class="flex gap-2">
            <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="px-4 py-2 bg-primary-600 text-white rounded-lg font-medium">1</button>
            <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition">2</button>
            <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
@endsection


