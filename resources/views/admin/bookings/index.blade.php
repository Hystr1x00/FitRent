@extends('admin.layouts.app')

@section('title', 'Booking')
@section('subtitle', 'Kelola data booking')

@section('content')
    <!-- Filters -->
    <div class="bg-white rounded-xl p-4 md:p-6 shadow-md border border-gray-100 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <input type="date" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Tanggal">
            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option>Semua Status</option>
                <option>Dipesan</option>
                <option>Berjalan</option>
                <option>Selesai</option>
                <option>Dibatalkan</option>
            </select>
            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option>Semua Lapangan</option>
                <option>Futsal</option>
                <option>Basket</option>
                <option>Badminton</option>
            </select>
            <div class="flex gap-2">
                <input type="text" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Cari nama/no. invoice">
                <button class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Filter</button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl p-4 md:p-6 shadow-md border border-gray-100 overflow-x-auto">
        @if(isset($returns) && $returns->count())
        <h3 class="font-semibold text-gray-900 mb-4">Menunggu Konfirmasi Pengembalian</h3>
        <table class="min-w-full text-sm mb-8">
            <thead>
                <tr class="text-left text-gray-500 border-b">
                    <th class="py-3 pr-6">Booking</th>
                    <th class="py-3 pr-6">User</th>
                    <th class="py-3 pr-6">Lapangan</th>
                    <th class="py-3 pr-6">Selesai</th>
                    <th class="py-3 pr-6">Dikembalikan</th>
                    <th class="py-3 pr-6">Telat</th>
                    <th class="py-3 pr-6">Foto</th>
                    <th class="py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($returns as $r)
                <tr class="border-b last:border-0 align-top">
                    <td class="py-3 pr-6">#{{ $r->id }}</td>
                    <td class="py-3 pr-6">{{ $r->user->name }}</td>
                    <td class="py-3 pr-6">{{ $r->slot->venue->name }}</td>
                    <td class="py-3 pr-6">{{ \Carbon\Carbon::parse($r->slot->end_time)->format('H:i') }}</td>
                    <td class="py-3 pr-6">{{ optional($r->returned_at)->format('H:i d M') }}</td>
                    <td class="py-3 pr-6">{{ $r->overtime_minutes ?? 0 }} mnt</td>
                    <td class="py-3 pr-6">
                        @if($r->return_photo)
                        <a href="{{ Storage::url($r->return_photo) }}" target="_blank" class="text-primary-600">Lihat</a>
                        @endif
                    </td>
                    <td class="py-3">
                        <form action="{{ route('admin.bookings.confirmReturn', $r) }}" method="POST" class="flex flex-col sm:flex-row gap-2 items-start">
                            @csrf
                            <input type="number" name="fine_amount" step="0.01" min="0" placeholder="Denda (Rp)" class="w-36 px-3 py-2 border border-gray-300 rounded-lg" value="{{ $r->overtime_minutes ? 5000 : 0 }}">
                            <div class="flex gap-2">
                                <button name="decision" value="approved" class="px-3 py-2 bg-green-600 text-white rounded-lg">Setuju</button>
                                <button name="decision" value="rejected" class="px-3 py-2 bg-red-600 text-white rounded-lg">Tolak</button>
                            </div>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left text-gray-500 border-b">
                    <th class="py-3 pr-6">Invoice</th>
                    <th class="py-3 pr-6">Tanggal</th>
                    <th class="py-3 pr-6">Pelanggan</th>
                    <th class="py-3 pr-6">Lapangan</th>
                    <th class="py-3 pr-6">Jam</th>
                    <th class="py-3 pr-6">Total</th>
                    <th class="py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach (range(1,8) as $i)
                <tr class="border-b last:border-0">
                    <td class="py-3 pr-6 font-medium text-gray-800">INV-2025-00{{ $i }}</td>
                    <td class="py-3 pr-6 text-gray-800">03 Nov 2025</td>
                    <td class="py-3 pr-6 text-gray-800">User {{ $i }}</td>
                    <td class="py-3 pr-6 text-gray-800">Futsal A</td>
                    <td class="py-3 pr-6 text-gray-800">08:00-10:00</td>
                    <td class="py-3 pr-6 text-gray-800">Rp 200.000</td>
                    <td class="py-3">
                        <span class="px-2.5 py-1 rounded-full text-blue-700 bg-blue-50">Berjalan</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex items-center justify-between mt-4 text-sm text-gray-600">
            <span>Menampilkan 1-8 dari 80</span>
            <div class="flex gap-2">
                <button class="px-3 py-1.5 border border-gray-300 rounded-lg hover:bg-gray-50">Prev</button>
                <button class="px-3 py-1.5 bg-primary-600 text-white rounded-lg">1</button>
                <button class="px-3 py-1.5 border border-gray-300 rounded-lg hover:bg-gray-50">2</button>
                <button class="px-3 py-1.5 border border-gray-300 rounded-lg hover:bg-gray-50">Next</button>
            </div>
        </div>
    </div>
@endsection


