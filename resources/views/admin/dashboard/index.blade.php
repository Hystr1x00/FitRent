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
            <p class="text-3xl font-bold mb-1">412</p>
            <p class="text-xs opacity-75">+8% vs bulan lalu</p>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-600">Pendapatan</span>
                <i class="fas fa-money-bill-trend-up text-2xl text-green-500"></i>
            </div>
            <p class="text-3xl font-bold text-gray-800 mb-1">Rp 125,4jt</p>
            <p class="text-xs text-green-600">+12% vs bulan lalu</p>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-600">Lapangan Aktif</span>
                <i class="fas fa-layer-group text-2xl text-primary-500"></i>
            </div>
            <p class="text-3xl font-bold text-gray-800 mb-1">8</p>
            <p class="text-xs text-gray-500">dari 12 total</p>
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

    <!-- Charts + Top Venues -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Trend Booking 30 Hari</h3>
                <select class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option>30 Hari</option>
                    <option>90 Hari</option>
                    <option>1 Tahun</option>
                </select>
            </div>
            <div class="h-56 bg-gradient-to-br from-primary-50 to-white rounded-lg border border-dashed border-primary-200 flex items-center justify-center text-primary-600">
                <span class="text-sm">Placeholder Chart</span>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <h3 class="font-semibold text-gray-900 mb-4">Lapangan Teratas</h3>
            <div class="space-y-3">
                @foreach ([
                    ['name' => 'Lapangan Futsal A', 'bookings' => 86],
                    ['name' => 'Lapangan Basket 1', 'bookings' => 74],
                    ['name' => 'Lapangan Badminton 2', 'bookings' => 63],
                ] as $v)
                <div class="p-3 border border-gray-100 rounded-lg flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-800">{{ $v['name'] }}</p>
                        <p class="text-xs text-gray-500">{{ $v['bookings'] }} booking</p>
                    </div>
                    <button class="px-3 py-1.5 bg-primary-50 text-primary-600 rounded-lg text-sm">Detail</button>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Bookings Table -->
    <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100 overflow-x-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">Booking Terbaru</h3>
            <a href="{{ route('admin.bookings.index') }}" class="text-primary-600 text-sm">Lihat semua</a>
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
                @foreach ([
                    ['date'=>'03 Nov 2025','user'=>'Farid G','court'=>'Futsal A','time'=>'08:00-10:00','total'=>'Rp 200.000','status'=>'Selesai'],
                    ['date'=>'03 Nov 2025','user'=>'Nadia','court'=>'Basket 1','time'=>'10:00-12:00','total'=>'Rp 150.000','status'=>'Berjalan'],
                    ['date'=>'02 Nov 2025','user'=>'Agus','court'=>'Badminton 2','time'=>'20:00-22:00','total'=>'Rp 100.000','status'=>'Dibatalkan'],
                ] as $b)
                <tr class="border-b last:border-0">
                    <td class="py-3 pr-6 text-gray-800">{{ $b['date'] }}</td>
                    <td class="py-3 pr-6 text-gray-800">{{ $b['user'] }}</td>
                    <td class="py-3 pr-6 text-gray-800">{{ $b['court'] }}</td>
                    <td class="py-3 pr-6 text-gray-800">{{ $b['time'] }}</td>
                    <td class="py-3 pr-6 text-gray-800">{{ $b['total'] }}</td>
                    <td class="py-3">
                        @php $color = match($b['status']){ 'Selesai'=>'green','Berjalan'=>'blue','Dibatalkan'=>'red', default=>'gray'}; @endphp
                        <span class="px-2.5 py-1 rounded-full text-{{ $color }}-700 bg-{{ $color }}-50">{{ $b['status'] }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection


