<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <div class="pt-12 pb-16 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Dashboard</h1>
                    <p class="text-gray-600">Selamat datang kembali, {{ Auth::user()->name }}!</p>
                </div>

                <!-- Quick Actions -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <a href="{{ route('venues.index') }}" class="p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition text-left">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Cari Lapangan</h3>
                        <p class="text-sm text-gray-600">Temukan lapangan favoritmu</p>
                    </a>

                    <a href="{{ route('slots.index') }}" class="p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition text-left">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Open Slots</h3>
                        <p class="text-sm text-gray-600">Gabung dengan pemain lain</p>
                    </a>

                    <a href="{{ route('bookings.index') }}" class="p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition text-left">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Riwayat Booking</h3>
                        <p class="text-sm text-gray-600">Lihat booking Anda</p>
                    </a>

                    <a href="{{ route('bookings.index') }}" class="p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition text-left">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Statistik</h3>
                        <p class="text-sm text-gray-600">Aktivitas bermain Anda</p>
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid sm:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Total Booking</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalBookings }}</p>
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
                                <p class="text-gray-600 text-sm">Pengeluaran Bulan Ini</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">Rp {{ number_format($monthlySpending, 0, ',', '.') }}</p>
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
                                <p class="text-gray-600 text-sm">Slot Akan Datang</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $upcomingSlots }}</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Recent Bookings -->
                    <div class="bg-white rounded-xl shadow-md">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Recent Bookings</h3>
                                <a href="{{ route('bookings.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                    View All
                                </a>
                            </div>
                            
                            <div class="space-y-4">
                                @forelse($bookings->take(3) as $booking)
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        @if($booking->slot && $booking->slot->venue)
                                            <img src="{{ $booking->slot->venue->image ?? 'https://images.unsplash.com/photo-1589487391730-58f20eb2c308?w=400' }}" alt="{{ $booking->slot->venue->name }}" 
                                                 class="w-12 h-12 object-cover rounded-lg mr-3">
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900">{{ $booking->slot->venue->name }}</h4>
                                                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($booking->slot->date)->format('d M Y') }} at {{ \Carbon\Carbon::parse($booking->slot->start_time)->format('H:i') }}</p>
                                            </div>
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded-lg mr-3 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900">Booking #{{ $booking->id }}</h4>
                                                <p class="text-sm text-gray-600">{{ $booking->created_at->format('d M Y H:i') }}</p>
                                            </div>
                                        @endif
                                        <div class="flex items-center">
                                            @if($booking->status === 'confirmed')
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">Confirmed</span>
                                            @elseif($booking->status === 'pending')
                                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">Pending</span>
                                            @else
                                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-semibold">Cancelled</span>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-6">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings yet</h3>
                                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new booking.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Created Slots -->
                    <div class="bg-white rounded-xl shadow-md">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">My Created Slots</h3>
                                <a href="{{ route('slots.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                    View All
                                </a>
                            </div>
                            
                            <div class="space-y-4">
                                @forelse($createdSlots->take(3) as $slot)
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        @if($slot->venue)
                                            <img src="{{ $slot->venue->image ?? 'https://images.unsplash.com/photo-1589487391730-58f20eb2c308?w=400' }}" alt="{{ $slot->venue->name }}" 
                                                 class="w-12 h-12 object-cover rounded-lg mr-3">
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900">{{ $slot->venue->name }}</h4>
                                                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($slot->date)->format('d M Y') }} at {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}</p>
                                                <p class="text-xs text-gray-500">{{ $slot->current_participants }}/{{ $slot->max_participants }} participants</p>
                                            </div>
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded-lg mr-3 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900">Slot #{{ $slot->id }}</h4>
                                                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($slot->date)->format('d M Y') }} at {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}</p>
                                                <p class="text-xs text-gray-500">{{ $slot->current_participants }}/{{ $slot->max_participants }} participants</p>
                                            </div>
                                        @endif
                                        <div class="flex items-center">
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold">
                                                {{ $slot->sport }}
                                            </span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-6">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No slots created</h3>
                                        <p class="mt-1 text-sm text-gray-500">Create your first slot to start playing.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>