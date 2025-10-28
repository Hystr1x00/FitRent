<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Bookings') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <div class="pt-12 pb-16 px-4">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8">Riwayat Booking</h1>

                <!-- Stats Cards -->
                <div class="grid sm:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Total Booking</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $bookings->count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Confirmed</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $bookings->where('status', 'confirmed')->count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Pending</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $bookings->where('status', 'pending')->count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking List -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Lapangan</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Waktu</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tipe</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Status</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse($bookings as $booking)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">{{ $booking->slot->venue->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->slot->venue->location }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">{{ $booking->slot->date->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($booking->slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->slot->end_time)->format('H:i') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-semibold">
                                            {{ $booking->slot->max_participants == 1 ? 'Private' : 'Shared' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($booking->status === 'confirmed')
                                            <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-semibold">Confirmed</span>
                                        @elseif($booking->status === 'pending')
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-semibold">Pending</span>
                                        @else
                                            <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-semibold">Cancelled</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="mb-4">Belum ada riwayat booking</p>
                                        <a href="{{ route('venues.index') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                            Mulai Booking
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>