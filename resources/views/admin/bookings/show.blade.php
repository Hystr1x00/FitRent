@extends('admin.layouts.app')

@section('title', 'Detail Booking')
@section('subtitle', 'Informasi lengkap booking dan riwayat pengguna')

@section('content')
<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Booking</h3>
            <div class="grid sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Invoice</p>
                    <p class="font-medium text-gray-900">#{{ $booking->id }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Tanggal</p>
                    <p class="font-medium text-gray-900">{{ $booking->date ? $booking->date->format('d M Y') : '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Jenis</p>
                    <p class="font-medium text-gray-900">{{ $booking->type ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Jam</p>
                    <p class="font-medium text-gray-900">{{ $booking->time ?? ($booking->slot->time ?? '-') }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Lapangan</p>
                    <p class="font-medium text-gray-900">{{ $booking->slot->venue->name ?? $booking->venue->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Total</p>
                    <p class="font-medium text-gray-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Status</p>
                    @php 
                        $statusColors = ['confirmed' => 'blue','completed' => 'green','cancelled' => 'red','pending' => 'yellow'];
                        $color = $statusColors[$booking->status] ?? 'gray';
                        $statusLabels = ['confirmed' => 'Dikonfirmasi','completed' => 'Selesai','cancelled' => 'Dibatalkan','pending' => 'Menunggu'];
                        $label = $statusLabels[$booking->status] ?? $booking->status;
                    @endphp
                    <span class="px-2.5 py-1 rounded-full text-{{ $color }}-700 bg-{{ $color }}-50">{{ $label }}</span>
                </div>
                <div>
                    <p class="text-gray-500">Pembayaran</p>
                    <p class="font-medium text-gray-900">{{ ucfirst($booking->payment_status ?? 'unpaid') }}</p>
                </div>
            </div>
        </div>

        @if($booking->notes || $booking->return_note)
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Catatan</h3>
            @if($booking->notes)
                <div class="mb-3">
                    <p class="text-xs text-gray-500">Catatan Pemesanan</p>
                    <p class="text-gray-800">{{ $booking->notes }}</p>
                </div>
            @endif
            @if($booking->return_note)
                <div>
                    <p class="text-xs text-gray-500">Catatan Pengembalian</p>
                    <p class="text-gray-800">{{ $booking->return_note }}</p>
                </div>
            @endif
        </div>
        @endif

        @if($booking->return_photo)
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Foto Pengembalian</h3>
            <a href="{{ asset('storage/' . $booking->return_photo) }}" target="_blank" class="inline-flex items-center px-4 py-2 border rounded-lg hover:bg-gray-50">Lihat Foto</a>
        </div>
        @endif
    </div>

    <div>
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pelanggan</h3>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center font-semibold text-gray-700">
                    {{ strtoupper(substr($booking->user->name ?? 'U',0,1)) }}
                </div>
                <div>
                    <p class="font-medium text-gray-900">{{ $booking->user->name ?? '-' }}</p>
                    <p class="text-sm text-gray-600">{{ $booking->user->email ?? '-' }}</p>
                </div>
            </div>

            <h4 class="text-sm font-semibold text-gray-900 mb-2">Riwayat Booking Pengguna</h4>
            <div class="space-y-3">
                @forelse($userHistory as $h)
                    <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                        <div>
                            <div class="font-medium text-gray-900">#{{ $h->id }} • {{ $h->slot->venue->name ?? '-' }}</div>
                            <div class="text-xs text-gray-600">{{ $h->date ? $h->date->format('d M Y') : '-' }} • {{ $h->time ?? ($h->slot->time ?? '-') }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-semibold">Rp {{ number_format($h->total_price, 0, ',', '.') }}</div>
                            <div class="text-xs text-gray-500">{{ ucfirst($h->status) }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Belum ada riwayat lain.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection


