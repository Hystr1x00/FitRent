<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Available Slots') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <div class="pt-24 pb-16 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Open Slots</h1>
                    <p class="text-gray-600">Gabung dengan pemain lain dan hemat biaya!</p>
                </div>

                <!-- Filter Section -->
                <div class="bg-white p-6 rounded-xl shadow-md mb-8">
                    <form action="{{ route('slots.index') }}" method="GET">
                        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="relative">
                                <svg class="absolute left-3 top-3 text-gray-400 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari slot..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <select name="sport" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Semua Olahraga</option>
                                <option value="Futsal" {{ request('sport') == 'Futsal' ? 'selected' : '' }}>Futsal</option>
                                <option value="Basketball" {{ request('sport') == 'Basketball' ? 'selected' : '' }}>Basketball</option>
                                <option value="Badminton" {{ request('sport') == 'Badminton' ? 'selected' : '' }}>Badminton</option>
                                <option value="Voli" {{ request('sport') == 'Voli' ? 'selected' : '' }}>Voli</option>
                                <option value="Tennis" {{ request('sport') == 'Tennis' ? 'selected' : '' }}>Tennis</option>
                            </select>
                            <input type="date" name="date" value="{{ request('date') }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:from-blue-700 hover:to-blue-600 transition">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>

                <div class="grid lg:grid-cols-3 gap-6">
                    @forelse($slots as $slot)
                    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold">{{ $slot->sport }}</span>
                            <span class="text-green-600 font-semibold">
                                {{ $slot->max_participants - $slot->current_participants }} slot tersisa
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-4">{{ $slot->venue->name }}</h3>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>{{ $slot->date->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span>{{ $slot->current_participants }}/{{ $slot->max_participants }} peserta</span>
                            </div>
                        </div>

                        <div class="border-t pt-4 mb-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Biaya per orang</span>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-blue-600">Rp {{ number_format($slot->venue->price / $slot->max_participants, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>

                        @auth
                            @if($slot->current_participants < $slot->max_participants)
                                <form action="{{ route('slots.join', $slot) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:from-blue-700 hover:to-blue-600 transition font-semibold">
                                        Join Slot
                                    </button>
                                </form>
                            @else
                                <div class="w-full py-3 bg-red-100 text-red-800 rounded-lg text-center font-semibold">
                                    Slot Penuh
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="w-full py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-semibold text-center block">
                                Login to Join
                            </a>
                        @endauth
                    </div>
                    @empty
                    <div class="col-span-3 bg-white rounded-xl shadow-md p-12 text-center">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-gray-500 mb-4">Belum ada open slot tersedia</p>
                        <a href="{{ route('venues.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Buat Slot Baru
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>