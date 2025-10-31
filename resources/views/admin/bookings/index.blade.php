@extends('admin.layouts.app')

@section('title', 'Booking')
@section('subtitle', 'Kelola data booking')

@section('content')
    <!-- Filters -->
    <form method="GET" action="{{ route('admin.bookings.index') }}" class="bg-white rounded-xl p-4 md:p-6 shadow-md border border-gray-100 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <input type="date" name="date" value="{{ request('date') }}" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Tanggal">
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            <select name="venue" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                <option value="">Semua Lapangan</option>
                <option value="Futsal" {{ request('venue') == 'Futsal' ? 'selected' : '' }}>Futsal</option>
                <option value="Basket" {{ request('venue') == 'Basket' ? 'selected' : '' }}>Basket</option>
                <option value="Badminton" {{ request('venue') == 'Badminton' ? 'selected' : '' }}>Badminton</option>
            </select>
            <div class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Cari nama/no. invoice">
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Filter</button>
            </div>
        </div>
    </form>

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
                    <td class="py-3 pr-6">
                        @php
                            $timeParts = explode(' - ', $r->slot->time);
                            $endTime = trim($timeParts[1] ?? '');
                        @endphp
                        {{ $endTime }}
                    </td>
                    <td class="py-3 pr-6">{{ optional($r->returned_at)->format('H:i d M') }}</td>
                    <td class="py-3 pr-6">{{ $r->overtime_minutes ?? 0 }} mnt</td>
                    <td class="py-3 pr-6">
                        @if($r->return_photo)
                        <a href="{{ asset('storage/' . $r->return_photo) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium">Lihat</a>
                        @endif
                    </td>
                    <td class="py-3">
                        <form action="{{ route('admin.bookings.confirmReturn', $r) }}" method="POST" class="flex flex-col sm:flex-row gap-2 items-start">
                            @csrf
                            <div class="flex flex-col">
                                <input type="number" name="fine_amount" step="1" min="0" placeholder="Denda (Rp)" class="w-40 px-3 py-2 border border-gray-300 rounded-lg text-sm" value="{{ $r->suggested_penalty ?? 0 }}">
                                @if($r->overtime_minutes > 0)
                                    <span class="text-xs text-red-600 font-semibold mt-1">⚠️ Telat {{ $r->overtime_minutes }} menit</span>
                                    <span class="text-xs text-gray-500">Saran: Rp {{ number_format($r->suggested_penalty ?? 0, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-xs text-green-600 mt-1">✓ Tepat waktu</span>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <button name="decision" value="approved" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition">Setuju</button>
                                <button name="decision" value="rejected" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition">Tolak</button>
                            </div>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- Unpaid Penalties Section -->
        @if(isset($unpaidPenalties) && $unpaidPenalties->count())
        <h3 class="font-semibold text-gray-900 mb-4 mt-8 flex items-center gap-2">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Denda Belum Dibayar ({{ $unpaidPenalties->count() }})
        </h3>
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-8">
            <div class="space-y-3">
                @foreach ($unpaidPenalties as $p)
                <div class="flex items-center justify-between bg-white p-3 rounded-lg border border-red-100">
                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            <span class="font-semibold text-gray-900">#{{ $p->id }}</span>
                            <span class="text-sm text-gray-600">{{ $p->user->name }}</span>
                            <span class="text-sm text-gray-500">• {{ $p->slot->venue->name }}</span>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            Booking: {{ $p->slot->date->format('d M Y') }} - {{ $p->slot->time }}
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-bold text-red-600">Rp {{ number_format($p->penalty_amount, 0, ',', '.') }}</div>
                        <div class="text-xs text-gray-500">Menunggu pembayaran user</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <h3 class="font-semibold text-gray-900 mb-4">Semua Booking</h3>
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left text-gray-500 border-b">
                    <th class="py-3 pr-6">Invoice</th>
                    <th class="py-3 pr-6">Tanggal</th>
                    <th class="py-3 pr-6">Pelanggan</th>
                    <th class="py-3 pr-6">Lapangan</th>
                    <th class="py-3 pr-6">Jenis</th>
                    <th class="py-3 pr-6">Jam</th>
                    <th class="py-3 pr-6">Total</th>
                    <th class="py-3 pr-6">Status</th>
                    <th class="py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bookings as $booking)
                <tr class="border-b last:border-0">
                    <td class="py-3 pr-6 font-medium text-gray-800">#{{ $booking->id }}</td>
                    <td class="py-3 pr-6 text-gray-800">{{ $booking->date ? $booking->date->format('d M Y') : '-' }}</td>
                    <td class="py-3 pr-6 text-gray-800">{{ $booking->user->name ?? '-' }}</td>
                    <td class="py-3 pr-6 text-gray-800">{{ $booking->slot->venue->name ?? $booking->venue->name ?? '-' }}</td>
                    <td class="py-3 pr-6 text-gray-800">{{ $booking->type ?? '-' }}</td>
                    <td class="py-3 pr-6 text-gray-800">{{ $booking->time ?? '-' }}</td>
                    <td class="py-3 pr-6 text-gray-800">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    <td class="py-3 pr-6">
                        @php 
                            $statusColors = [
                                'confirmed' => 'blue',
                                'completed' => 'green',
                                'cancelled' => 'red',
                                'pending' => 'yellow',
                            ];
                            $color = $statusColors[$booking->status] ?? 'gray';
                            $statusLabels = [
                                'confirmed' => 'Dikonfirmasi',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                                'pending' => 'Menunggu',
                            ];
                            $label = $statusLabels[$booking->status] ?? $booking->status;
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-{{ $color }}-700 bg-{{ $color }}-50">{{ $label }}</span>
                    </td>
                    <td class="py-3">
                        <a href="{{ route('admin.bookings.show', $booking) }}" class="px-3 py-1.5 border rounded-lg text-gray-700 hover:bg-gray-50">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-3xl mb-2"></i>
                        <p class="text-sm">Tidak ada data booking</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($bookings->hasPages())
        <div class="flex items-center justify-between mt-4 text-sm text-gray-600">
            <span>Menampilkan {{ $bookings->firstItem() }}-{{ $bookings->lastItem() }} dari {{ $bookings->total() }}</span>
            <div class="flex gap-2">
                {{ $bookings->links() }}
            </div>
        </div>
        @endif
    </div>
@endsection


