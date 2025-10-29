@extends('admin.layouts.app')

@section('title', 'Pelanggan')
@section('subtitle', 'Manajemen pelanggan')

@section('content')
    <!-- Toolbar -->
    <div class="bg-white rounded-xl p-4 md:p-6 shadow-md border border-gray-100 mb-6">
        <div class="flex flex-col md:flex-row gap-3 md:items-center md:justify-between">
            <div class="flex gap-2">
                <input type="text" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Cari nama/email/telepon">
                <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option>Semua Status</option>
                    <option>Aktif</option>
                    <option>Nonaktif</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Tambah Pelanggan</button>
                <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Ekspor</button>
            </div>
        </div>
    </div>

    <!-- List -->
    <div class="bg-white rounded-xl p-4 md:p-6 shadow-md border border-gray-100 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left text-gray-500 border-b">
                    <th class="py-3 pr-6">Nama</th>
                    <th class="py-3 pr-6">Email</th>
                    <th class="py-3 pr-6">Telepon</th>
                    <th class="py-3 pr-6">Total Booking</th>
                    <th class="py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach (range(1,10) as $i)
                <tr class="border-b last:border-0">
                    <td class="py-3 pr-6 text-gray-800">Pelanggan {{ $i }}</td>
                    <td class="py-3 pr-6 text-gray-800">pelanggan{{ $i }}@mail.com</td>
                    <td class="py-3 pr-6 text-gray-800">0812-34{{ $i }}-5678</td>
                    <td class="py-3 pr-6 text-gray-800">{{ rand(1, 40) }}</td>
                    <td class="py-3">
                        <span class="px-2.5 py-1 rounded-full text-green-700 bg-green-50">Aktif</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex items-center justify-between mt-4 text-sm text-gray-600">
            <span>Menampilkan 1-10 dari 120</span>
            <div class="flex gap-2">
                <button class="px-3 py-1.5 border border-gray-300 rounded-lg hover:bg-gray-50">Prev</button>
                <button class="px-3 py-1.5 bg-primary-600 text-white rounded-lg">1</button>
                <button class="px-3 py-1.5 border border-gray-300 rounded-lg hover:bg-gray-50">2</button>
                <button class="px-3 py-1.5 border border-gray-300 rounded-lg hover:bg-gray-50">Next</button>
            </div>
        </div>
    </div>
@endsection


