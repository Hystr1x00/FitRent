<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Venues') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <div class="pt-24 pb-16 px-4">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8">Temukan Lapangan</h1>
                
                <!-- Filters -->
                <div class="bg-white p-6 rounded-xl shadow-md mb-8">
                    <form action="{{ route('venues.index') }}" method="GET">
                        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="relative">
                                <svg class="absolute left-3 top-3 text-gray-400 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari lapangan..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <select name="sport" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Semua Olahraga</option>
                                <option value="Futsal" {{ request('sport') == 'Futsal' ? 'selected' : '' }}>Futsal</option>
                                <option value="Basketball" {{ request('sport') == 'Basketball' ? 'selected' : '' }}>Basketball</option>
                                <option value="Badminton" {{ request('sport') == 'Badminton' ? 'selected' : '' }}>Badminton</option>
                                <option value="Voli" {{ request('sport') == 'Voli' ? 'selected' : '' }}>Voli</option>
                                <option value="Tennis" {{ request('sport') == 'Tennis' ? 'selected' : '' }}>Tennis</option>
                            </select>
                            <select name="location" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Semua Lokasi</option>
                                <option value="Jakarta Selatan" {{ request('location') == 'Jakarta Selatan' ? 'selected' : '' }}>Jakarta Selatan</option>
                                <option value="Jakarta Pusat" {{ request('location') == 'Jakarta Pusat' ? 'selected' : '' }}>Jakarta Pusat</option>
                                <option value="Jakarta Barat" {{ request('location') == 'Jakarta Barat' ? 'selected' : '' }}>Jakarta Barat</option>
                                <option value="Jakarta Timur" {{ request('location') == 'Jakarta Timur' ? 'selected' : '' }}>Jakarta Timur</option>
                                <option value="Jakarta Utara" {{ request('location') == 'Jakarta Utara' ? 'selected' : '' }}>Jakarta Utara</option>
                            </select>
                            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:from-blue-700 hover:to-blue-600 transition">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Venues Grid -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($venues as $venue)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition group">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $venue->image }}" alt="{{ $venue->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            @if($venue->available)
                            <span class="absolute top-4 right-4 px-3 py-1 bg-green-500 text-white text-sm rounded-full">
                                Tersedia
                            </span>
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm px-3 py-1 bg-blue-100 text-blue-600 rounded-full">{{ $venue->sport }}</span>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <span class="ml-1 text-sm font-semibold">{{ $venue->rating }}</span>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $venue->name }}</h3>
                            <div class="flex items-center text-gray-600 mb-4">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="text-sm">{{ $venue->location }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-2xl font-bold text-blue-600">Rp {{ number_format($venue->price, 0, ',', '.') }}</div>
                                    <div class="text-sm text-gray-500">per jam</div>
                                </div>
                                @auth
                                    <a href="{{ route('venues.booking', $venue) }}" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:from-blue-700 hover:to-blue-600 transition">
                                        Book
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                                        Login to Book
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-3 text-center py-12">
                        <p class="text-gray-500">Tidak ada lapangan ditemukan</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>