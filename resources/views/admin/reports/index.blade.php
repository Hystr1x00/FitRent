@extends('admin.layouts.app')

@section('title', 'Laporan')
@section('subtitle', 'Analitik dan laporan kinerja')

@section('content')
    <!-- Header Filters -->
    <div class="bg-white rounded-xl p-4 md:p-6 shadow-md border border-gray-100 mb-6">
        <div class="flex flex-col md:flex-row gap-3 md:items-center md:justify-between">
            <div class="flex gap-2">
                <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option>Periode: Bulan Ini</option>
                    <option>Minggu Ini</option>
                    <option>3 Bulan</option>
                    <option>1 Tahun</option>
                </select>
                <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option>Semua Cabang Olahraga</option>
                    <option>Futsal</option>
                    <option>Basket</option>
                    <option>Badminton</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Ekspor CSV</button>
                <button class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Ekspor PDF</button>
            </div>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6">
        @foreach ([
            ['label'=>'Total Booking','value'=>'412','icon'=>'fa-calendar-check','color'=>'primary'],
            ['label'=>'Pendapatan','value'=>'Rp 125,4jt','icon'=>'fa-coins','color'=>'yellow'],
            ['label'=>'Cancel Rate','value'=>'3.1%','icon'=>'fa-ban','color'=>'red'],
            ['label'=>'ARPU','value'=>'Rp 152.400','icon'=>'fa-user','color'=>'green'],
        ] as $kpi)
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-600">{{ $kpi['label'] }}</span>
                <i class="fas {{ $kpi['icon'] }} text-2xl text-{{ $kpi['color'] }}-500"></i>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $kpi['value'] }}</p>
        </div>
        @endforeach
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <h3 class="font-semibold text-gray-900 mb-4">Pendapatan per Hari</h3>
            <div class="h-64 bg-gradient-to-br from-primary-50 to-white rounded-lg border border-dashed border-primary-200 flex items-center justify-center text-primary-600">
                <span class="text-sm">Placeholder Bar Chart</span>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <h3 class="font-semibold text-gray-900 mb-4">Distribusi Olahraga</h3>
            <div class="h-64 bg-gradient-to-br from-primary-50 to-white rounded-lg border border-dashed border-primary-200 flex items-center justify-center text-primary-600">
                <span class="text-sm">Placeholder Pie Chart</span>
            </div>
        </div>
    </div>
@endsection


