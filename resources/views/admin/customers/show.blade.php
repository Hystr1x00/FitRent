@extends('admin.layouts.app')

@section('title', 'Detail Pelanggan')
@section('subtitle', 'Profil pelanggan dan riwayat booking')

@section('content')
<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg text-white font-bold flex items-center justify-center">
                    {{ strtoupper(substr($user->name,0,1)) }}
                </div>
                <div>
                    <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                    <div class="text-sm text-gray-600">{{ $user->email }}</div>
                    @if($user->phone)
                        <div class="text-sm text-gray-600">{{ $user->phone }}</div>
                    @endif
                </div>
            </div>
            <div class="text-sm text-gray-600">
                <div class="flex items-center justify-between py-2 border-t"><span>Total Booking</span><span class="font-semibold text-gray-900">{{ $user->bookings_count }}</span></div>
            </div>
        </div>
    </div>
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow p-6 overflow-x-auto">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Riwayat Booking</h3>
            </div>
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="py-3 pr-6">Tanggal</th>
                        <th class="py-3 pr-6">Lapangan</th>
                        <th class="py-3 pr-6">Jam</th>
                        <th class="py-3 pr-6">Total</th>
                        <th class="py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr class="border-b last:border-0">
                        <td class="py-3 pr-6">{{ $booking->date ? $booking->date->format('d M Y') : '-' }}</td>
                        <td class="py-3 pr-6">{{ $booking->slot->venue->name ?? '-' }}</td>
                        <td class="py-3 pr-6">{{ $booking->time ?? ($booking->slot->time ?? '-') }}</td>
                        <td class="py-3 pr-6">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        <td class="py-3">
                            <span class="px-2.5 py-1 rounded-full bg-gray-50 text-gray-700">{{ ucfirst($booking->status) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">Belum ada booking</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @if($bookings->hasPages())
                <div class="mt-4">{{ $bookings->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection


