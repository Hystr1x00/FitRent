@extends('admin.layouts.app')

@section('title', 'Pelanggan')
@section('subtitle', 'Manajemen pelanggan')

@section('content')
    <!-- Toolbar -->
    <form method="GET" action="{{ route('admin.customers.index') }}" class="bg-white rounded-xl p-4 md:p-6 shadow-md border border-gray-100 mb-6">
        <div class="flex flex-col md:flex-row gap-3 md:items-center md:justify-between">
            <div class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Cari nama/email/telepon">
                <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Filter</button>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('register') }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Tambah Pelanggan</a>
            </div>
        </div>
    </form>

    <!-- List -->
    <div class="bg-white rounded-xl p-4 md:p-6 shadow-md border border-gray-100 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left text-gray-500 border-b">
                    <th class="py-3 pr-6">Nama</th>
                    <th class="py-3 pr-6">Email</th>
                    <th class="py-3 pr-6">Telepon</th>
                    <th class="py-3 pr-6">Total Booking</th>
                    <th class="py-3 pr-6">Status</th>
                    <th class="py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                <tr class="border-b last:border-0">
                    <td class="py-3 pr-6 text-gray-800">
                        <a href="{{ route('admin.customers.show', $customer) }}" class="text-primary-600 hover:text-primary-700 font-medium">{{ $customer->name }}</a>
                    </td>
                    <td class="py-3 pr-6 text-gray-800">{{ $customer->email }}</td>
                    <td class="py-3 pr-6 text-gray-800">{{ $customer->phone ?? '-' }}</td>
                    <td class="py-3 pr-6 text-gray-800">{{ $customer->bookings_count }}</td>
                    <td class="py-3 pr-6">
                        @php
                            $hasRecentBooking = $customer->bookings()->where('created_at', '>=', now()->subMonths(3))->exists();
                        @endphp
                        <span class="px-2.5 py-1 rounded-full {{ $hasRecentBooking ? 'text-green-700 bg-green-50' : 'text-gray-700 bg-gray-50' }}">
                            {{ $hasRecentBooking ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="py-3">
                        <a href="{{ route('admin.customers.show', $customer) }}" class="px-3 py-1.5 border rounded-lg text-gray-700 hover:bg-gray-50">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-gray-500">
                        <i class="fas fa-users text-3xl mb-2"></i>
                        <p class="text-sm">Tidak ada data pelanggan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($customers->hasPages())
        <div class="flex items-center justify-between mt-4 text-sm text-gray-600">
            <span>Menampilkan {{ $customers->firstItem() }}-{{ $customers->lastItem() }} dari {{ $customers->total() }}</span>
            <div class="flex gap-2">
                {{ $customers->links() }}
            </div>
        </div>
        @endif
    </div>
@endsection


