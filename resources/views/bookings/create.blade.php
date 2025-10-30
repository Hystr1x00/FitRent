<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Book {{ $venue->name }}
            </h2>
            <a href="{{ route('venues.show', $venue) }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Venue
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <div class="pt-8 pb-16 px-4">
            <div class="max-w-7xl mx-auto">
                <!-- Breadcrumb -->
                <nav class="flex items-center gap-2 text-sm mb-6">
                    <a href="{{ route('venues.index') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <a href="{{ route('venues.index') }}" class="text-gray-500 hover:text-gray-700">Sewa Lapangan</a>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-gray-900 font-medium">{{ $venue->name }}</span>
                </nav>

                <!-- Venue Header Card -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-6">
                    <div class="relative h-48 md:h-64 bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900">
                        <img src="{{ $venue->image_url ?? 'https://images.unsplash.com/photo-1589487391730-58f20eb2c308?w=1200' }}" 
                             alt="{{ $venue->name }}" 
                             class="w-full h-full object-cover mix-blend-overlay opacity-50">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <h1 class="text-4xl md:text-5xl font-bold text-white text-center px-4">{{ $venue->name }}</h1>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex flex-wrap items-center gap-3 md:gap-4">
                            <span class="px-4 py-1.5 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">🎾 {{ $venue->sport }}</span>
                            @php
                                $labels = ($venue->courts ?? collect())
                                    ->flatMap(function($c){ return $c->labels ?? []; })
                                    ->unique()
                                    ->take(4);
                                $mapsUrl = optional($venue->courts->first())->maps_url ?? ( 'https://www.google.com/maps/search/?api=1&query=' . urlencode($venue->address ?? $venue->location) );
                            @endphp
                            @foreach($labels as $lb)
                                <span class="px-4 py-1.5 bg-blue-50 text-blue-700 rounded-full text-sm font-semibold flex items-center gap-1">
                                    @if($lb==='Indoor') 🏠 @elseif($lb==='Outdoor') 🌳 @else 🔖 @endif
                                    {{ $lb }}
                                </span>
                            @endforeach
                            <a href="{{ $mapsUrl }}" target="_blank" class="flex items-center text-gray-600 hover:text-blue-700 transition">
                                <svg class="w-5 h-5 mr-1.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="text-sm underline decoration-dotted">{{ $venue->location }}</span>
                            </a>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <span class="ml-1 font-semibold text-gray-900">{{ $venue->rating ?? 4.5 }}</span>
                            </div>
                            <div class="ml-auto">
                                <div class="text-right">
                                    <div class="text-sm text-gray-500">Mulai dari</div>
                                    <div class="text-2xl font-bold text-blue-600">Rp {{ number_format($venue->price, 0, ',', '.') }}</div>
                                    <div class="text-xs text-gray-500">per sesi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="bookingForm" action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="venue_id" value="{{ $venue->id }}">
                    <input type="hidden" name="court_id" id="selected_court_id">
                    <input type="hidden" name="time_slot" id="selected_time_slot">

                    <div class="grid lg:grid-cols-3 gap-6">
                        <!-- Left Column - Booking Form -->
                        <div class="lg:col-span-2 space-y-6">

                            <!-- Court Information (from DB) -->
                            @php $firstCourt = optional($venue->courts)->first(); @endphp
                            @if($firstCourt)
                            <div class="bg-white rounded-2xl shadow-sm p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v5h6v-5c0-1.657-1.343-3-3-3z"/></svg>
                                    </div>
                                    <h2 class="text-xl font-bold text-gray-900">Informasi Lapangan</h2>
                                </div>
                                <div class="grid grid-cols-1 gap-6">
                                    @if($firstCourt->about)
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900 mb-1">Tentang</div>
                                        <p class="text-sm text-gray-700 whitespace-pre-line">{{ $firstCourt->about }}</p>
                                    </div>
                                    @endif
                                    @if($firstCourt->rules)
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900 mb-1">Aturan</div>
                                        <p class="text-sm text-gray-700 whitespace-pre-line">{{ $firstCourt->rules }}</p>
                                    </div>
                                    @endif
                                    @if($firstCourt->facilities)
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900 mb-2">Fasilitas</div>
                                        <div class="grid grid-cols-2 gap-2">
                                            @foreach($firstCourt->facilities as $f)
                                            <div class="flex items-center gap-2 text-gray-700 text-sm">
                                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                <span>{{ $f }}</span>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                    @if($firstCourt->refund_policy)
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900 mb-1">Kebijakan Refund & Reschedule</div>
                                        <p class="text-sm text-gray-700 whitespace-pre-line">{{ $firstCourt->refund_policy }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                            
                            <!-- Booking Type Section -->
                            <div class="bg-white rounded-2xl shadow-sm p-6">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <h2 class="text-xl font-bold text-gray-900">Pilih Tipe Booking</h2>
                                </div>
                                
                                <div class="grid sm:grid-cols-2 gap-4">
                                    <label class="cursor-pointer group">
                                        <input type="radio" name="booking_type" value="private" checked class="peer sr-only">
                                        <div class="p-5 border-2 border-gray-200 peer-checked:border-blue-600 peer-checked:bg-blue-50 rounded-xl transition-all hover:border-blue-300">
                                            <div class="flex items-center justify-between mb-3">
                                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                                    </svg>
                                                </div>
                                                <div class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-blue-600 peer-checked:bg-blue-600 flex items-center justify-center transition">
                                                    <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="font-bold text-gray-900 text-lg mb-1">Sewa Pribadi</div>
                                            <div class="text-sm text-gray-600">Sewa lapangan untuk tim Anda sendiri</div>
                                        </div>
                                    </label>

                                    <label class="cursor-pointer group">
                                        <input type="radio" name="booking_type" value="shared" class="peer sr-only">
                                        <div class="p-5 border-2 border-gray-200 peer-checked:border-blue-600 peer-checked:bg-blue-50 rounded-xl transition-all hover:border-blue-300">
                                            <div class="flex items-center justify-between mb-3">
                                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                    </svg>
                                                </div>
                                                <div class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-blue-600 peer-checked:bg-blue-600 flex items-center justify-center transition">
                                                    <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="font-bold text-gray-900 text-lg mb-1">Buat Open Slot</div>
                                            <div class="text-sm text-gray-600">Buka slot untuk pemain lain bergabung</div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Date Selection -->
                            <div class="bg-white rounded-2xl shadow-sm p-6">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <h2 class="text-xl font-bold text-gray-900">Pilih Tanggal & Lapangan</h2>
                                </div>

                                <!-- Date Selector -->
                                <div class="mb-6">
                                    <div class="flex items-center gap-2 overflow-x-auto pb-2 date-scroll">
                                        @php $hasDates = isset($availableDates) && count($availableDates) > 0; @endphp
                                        @if($hasDates)
                                            @foreach($availableDates as $i => $d)
                                                @php $date = \Carbon\Carbon::parse($d); $isFirst = $i === 0; @endphp
                                                <label class="flex-shrink-0 cursor-pointer">
                                                    <input type="radio" name="date" value="{{ $date->format('Y-m-d') }}" {{ $isFirst ? 'checked' : '' }} class="peer sr-only date-radio" required onchange="updateCourtAvailability()">
                                                    <div class="px-4 py-3 border-2 border-gray-200 peer-checked:border-red-600 peer-checked:bg-red-600 rounded-xl transition-all hover:border-red-300 text-center min-w-[80px]">
                                                        <div class="text-xs font-semibold text-gray-500 peer-checked:text-white uppercase mb-1">
                                                            {{ $date->locale('id')->isoFormat('ddd') }}
                                                        </div>
                                                        <div class="text-2xl font-bold text-gray-900 peer-checked:text-white">
                                                            {{ $date->format('d') }}
                                                        </div>
                                                        <div class="text-xs text-gray-500 peer-checked:text-white">
                                                            {{ $date->locale('id')->isoFormat('MMM') }}
                                                        </div>
                                                    </div>
                                                </label>
                                            @endforeach
                                        @else
                                            <div class="text-sm text-gray-500">Belum ada tanggal tersedia untuk venue ini.</div>
                                        @endif
                                        <button type="button" class="flex-shrink-0 px-4 py-3 border-2 border-gray-200 rounded-xl hover:border-blue-300 transition-all min-w-[80px] flex items-center justify-center" onclick="openDatePicker(event)">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </button>
                                        <!-- hidden radio for datepicker selection -->
                                        <input type="radio" name="date" id="datepicker-date-radio" class="sr-only" value="">
                                    </div>
                                    <!-- Datepicker popup (modal) -->
                                    <div id="datepicker-popover" class="hidden fixed inset-0 z-50 flex items-center justify-center">
                                        <div class="absolute inset-0 bg-black/40" onclick="closeDatePicker()"></div>
                                        <div class="relative w-full max-w-sm bg-white border border-gray-200 rounded-xl shadow-2xl p-4 mx-4">
                                        <div class="flex items-center justify-between mb-3 pr-10">
                                            <button type="button" class="p-2 rounded hover:bg-gray-100" onclick="navigateCalendar(-1)">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                            </button>
                                            <div id="calendar-title" class="font-semibold text-gray-900"></div>
                                            <button type="button" class="p-2 rounded hover:bg-gray-100" onclick="navigateCalendar(1)">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </button>
                                        </div>
                                        <div class="grid grid-cols-7 gap-1 text-xs text-gray-500 mb-1">
                                            <div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div><div>Min</div>
                                        </div>
                                        <div id="calendar-grid" class="grid grid-cols-7 gap-1"></div>
                                        <button type="button" class="absolute top-2 right-2 p-2 rounded hover:bg-gray-100 z-10" onclick="closeDatePicker()">
                                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Filter & Sort -->
                                <div class="flex flex-wrap items-center gap-3 mb-6">
                                    <div class="flex items-center gap-2 relative">
                                        <span class="text-sm text-gray-600">Filter Waktu:</span>
                                        <div class="relative">
                                            <button type="button" class="text-sm px-3 py-2 border-2 border-gray-200 rounded-lg bg-white flex items-center gap-2 hover:border-blue-300" onclick="toggleDropdown('time-filter-dropdown')">
                                                <span id="time-filter-selected">Semua Waktu</span>
                                                <svg id="time-filter-icon" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                            </button>
                                            <input type="hidden" id="time-filter-input" value="all">
                                            <div id="time-filter-dropdown" class="hidden absolute z-50 mt-2 w-56 bg-white rounded-lg shadow-xl border border-gray-100 overflow-hidden">
                                                <a href="#" class="block px-4 py-3 text-sm hover:bg-blue-50 hover:text-blue-600" onclick="selectDropdown('time-filter','all','Semua Waktu');filterTimeSlots('all');return false;">Semua Waktu</a>
                                                <a href="#" class="block px-4 py-3 text-sm hover:bg-blue-50 hover:text-blue-600" onclick="selectDropdown('time-filter','morning','Pagi (06:00-12:00)');filterTimeSlots('morning');return false;">Pagi (06:00-12:00)</a>
                                                <a href="#" class="block px-4 py-3 text-sm hover:bg-blue-50 hover:text-blue-600" onclick="selectDropdown('time-filter','afternoon','Siang (12:00-18:00)');filterTimeSlots('afternoon');return false;">Siang (12:00-18:00)</a>
                                                <a href="#" class="block px-4 py-3 text-sm hover:bg-blue-50 hover:text-blue-600" onclick="selectDropdown('time-filter','evening','Malam (18:00-24:00)');filterTimeSlots('evening');return false;">Malam (18:00-24:00)</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 ml-auto relative">
                                        <span class="text-sm text-gray-600">Gabor:</span>
                                        <div class="relative">
                                            <button type="button" class="text-sm px-3 py-2 border-2 border-gray-200 rounded-lg bg-white flex items-center gap-2 hover:border-blue-300" onclick="toggleDropdown('grouping-dropdown')">
                                                <span id="grouping-selected">Per Lapangan</span>
                                                <svg id="grouping-icon" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                            </button>
                                            <input type="hidden" id="grouping-input" value="court">
                                            <div id="grouping-dropdown" class="hidden absolute z-50 mt-2 w-44 bg-white rounded-lg shadow-xl border border-gray-100 overflow-hidden">
                                                <a href="#" class="block px-4 py-3 text-sm hover:bg-blue-50 hover:text-blue-600" onclick="selectDropdown('grouping','court','Per Lapangan');return false;">Per Lapangan</a>
                                                <a href="#" class="block px-4 py-3 text-sm hover:bg-blue-50 hover:text-blue-600" onclick="selectDropdown('grouping','time','Per Waktu');return false;">Per Waktu</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Courts List -->
                                <div class="space-y-4" id="courts-container">
                                    @php $dbCourts = $venue->courts ?? collect(); @endphp
                                    @forelse($dbCourts as $court)
                                    <div class="border-2 border-gray-200 rounded-xl overflow-hidden hover:border-blue-300 transition court-item" data-court-id="{{ $court->id }}">
                                        <!-- Court Header -->
                                        <div class="bg-gradient-to-r from-blue-900 to-blue-800 p-4 flex items-center gap-4">
                                            <div class="relative w-20 h-20 bg-white rounded-lg overflow-hidden flex-shrink-0">
                                                <img src="{{ $court->image ? asset('storage/'.$court->image) : 'https://images.unsplash.com/photo-1554068865-24cecd4e34b8?w=200' }}" alt="{{ $court->name }}" class="w-full h-full object-cover">
                                                @if($court->gallery)
                                                <button type="button" onclick="openCourtGallery({{ $court->id }})" class="absolute bottom-1 right-1 bg-white bg-opacity-90 rounded px-2 py-1 text-xs text-gray-700 hover:bg-opacity-100 transition">Lihat</button>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-lg font-bold text-white mb-1">{{ $court->name }} <span class="text-sm font-normal">›</span></h3>
                                                <p class="text-sm text-blue-200 mb-2">{{ $court->sport }}</p>
                                                <div class="flex flex-wrap gap-2">
                                                    @if($court->labels)
                                                        @foreach($court->labels as $feature)
                                                        <span class="text-xs px-2 py-1 bg-white bg-opacity-20 text-white rounded">
                                                            @if($feature === 'Indoor') 🏠 @elseif($feature === 'Outdoor') 🌳 @endif
                                                            {{ $feature }}
                                                        </span>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <button type="button" onclick="toggleCourtSlots({{ $court->id }})" class="text-white hover:text-blue-200 transition flex-shrink-0">
                                                <svg class="w-6 h-6 transform transition-transform court-toggle-{{ $court->id }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Time Slots -->
                                        <div class="p-4 bg-gray-50 hidden court-slots-{{ $court->id }}">
                                            <div class="mb-3">
                                                <span class="text-sm font-semibold text-gray-700">Pilih Jadwal</span>
                                            </div>
                                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                                @php 
                                                    // Sort timeslots by start_time (jam terkecil di kiri)
                                                    $tsFromDb = ($court->timeslots ?? collect())->sortBy('start_time'); 
                                                @endphp
                                                @forelse($tsFromDb as $ts)
                                                    @php 
                                                        $startTime = \Carbon\Carbon::parse($ts->start_time);
                                                        $endTime = \Carbon\Carbon::parse($ts->end_time);
                                                        $timeSlot = $startTime->format('H:i') . ' - ' . $endTime->format('H:i');
                                                        $durationMinutes = $startTime->diffInMinutes($endTime);
                                                    @endphp
                                                    <div class="time-slot-wrapper" data-court-id="{{ $court->id }}" data-time="{{ $timeSlot }}">
                                                        <label class="cursor-pointer time-slot-item time-slot-available" data-period="{{ (int)substr($ts->start_time,0,2) < 12 ? 'morning' : ((int)substr($ts->start_time,0,2) < 18 ? 'afternoon' : 'evening') }}">
                                                            <input type="checkbox" value="{{ $court->id }}|{{ $court->name }}|{{ $timeSlot }}|{{ (int)$ts->price }}" class="peer sr-only time-slot-checkbox" onchange="toggleTimeSlot(this)">
                                                            <div class="p-3 border-2 border-gray-300 peer-checked:border-blue-600 peer-checked:bg-blue-50 rounded-lg transition-all hover:border-blue-400 text-center">
                                                                <div class="text-xs text-gray-500 mb-1">{{ $durationMinutes }} menit</div>
                                                                <div class="text-sm font-bold text-gray-900">{{ $timeSlot }}</div>
                                                                <div class="text-xs font-semibold text-blue-600 mt-1">Rp {{ number_format($ts->price, 0, ',', '.') }}</div>
                                                            </div>
                                                        </label>
                                                        <div class="time-slot-booked hidden p-3 border-2 border-gray-100 bg-gray-50 rounded-lg text-center opacity-50 cursor-not-allowed">
                                                            <div class="text-xs text-gray-400 mb-1">{{ $durationMinutes }} menit</div>
                                                            <div class="text-sm font-bold text-gray-400">{{ $timeSlot }}</div>
                                                            <div class="text-xs font-semibold text-red-500 mt-1">Booked</div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="col-span-full text-sm text-gray-500">Belum ada jadwal untuk lapangan ini.</div>
                                                @endforelse
                                            </div>
                                            
                                            <!-- Jadwal Tersedia Info -->
                                            <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg court-available-info" data-court-id="{{ $court->id }}">
                                                <div class="flex items-center gap-2 text-sm text-green-800">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <span><strong class="court-available-count">{{ $court->timeslots ? $court->timeslots->count() : 0 }}</strong> Jadwal untuk {{ $court->name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @if($court->gallery)
                                        <!-- Court Gallery Modal -->
                                        <div id="gallery-modal-{{ $court->id }}" class="fixed inset-0 z-50 hidden items-center justify-center">
                                            <div class="absolute inset-0 bg-black/50" onclick="closeCourtGallery({{ $court->id }})"></div>
                                            <div class="relative bg-white rounded-xl shadow-2xl max-w-3xl w-full mx-4 overflow-hidden">
                                                <div class="flex items-center justify-between px-5 py-3 border-b">
                                                    <h4 class="font-semibold text-gray-900">Galeri - {{ $court->name }}</h4>
                                                    <button type="button" class="text-gray-500 hover:text-gray-700" onclick="closeCourtGallery({{ $court->id }})">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    </button>
                                                </div>
                                                <div class="p-5 grid grid-cols-2 md:grid-cols-3 gap-3">
                                                    @foreach($court->gallery as $g)
                                                        <img src="{{ asset('storage/'.$g) }}" class="w-full h-36 object-cover rounded" alt="gallery">
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @empty
                                        <div class="text-sm text-gray-500">Belum ada lapangan terdaftar.</div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Participants (for shared booking) -->
                            <div class="bg-white rounded-2xl shadow-sm p-6 hidden" id="max_participants_section">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <h2 class="text-xl font-bold text-gray-900">Jumlah Peserta</h2>
                                </div>
                                
                                <div class="flex items-center gap-4">
                                    <button type="button" onclick="decrementParticipants()" class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center hover:bg-gray-200 transition">
                                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                        </svg>
                                    </button>
                                    <input type="number" name="max_participants" id="max_participants" min="2" max="20" value="10"
                                        class="flex-1 text-center text-3xl font-bold text-gray-900 border-0 focus:ring-0" readonly>
                                    <button type="button" onclick="incrementParticipants()" class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="mt-4 p-4 bg-green-50 rounded-lg">
                                    <div class="text-sm text-gray-700 mb-1">Biaya per orang:</div>
                                    <div class="text-2xl font-bold text-green-600">
                                        Rp <span id="costPerPerson">25,000</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Notes -->
                            <div class="bg-white rounded-2xl shadow-sm p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                        </svg>
                                    </div>
                                    <h2 class="text-xl font-bold text-gray-900">Catatan Tambahan (Opsional)</h2>
                                </div>
                                <textarea name="notes" rows="4"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                    placeholder="Tambahkan catatan khusus untuk booking Anda..."></textarea>
                            </div>
                        </div>

                        <!-- Right Column - Summary -->
                        <div class="lg:col-span-1">
                            <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                                <h3 class="text-xl font-bold text-gray-900 mb-6">Ringkasan Booking</h3>
                                
                                <div class="space-y-4 mb-6 pb-6 border-b">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Venue</span>
                                        <span class="font-semibold text-gray-900">{{ $venue->name }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Lapangan</span>
                                        <span class="font-semibold text-gray-900" id="courtDisplay">-</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Tipe</span>
                                        <span class="font-semibold text-gray-900" id="bookingTypeDisplay">Sewa Pribadi</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Tanggal</span>
                                        <span class="font-semibold text-gray-900" id="dateDisplay">-</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Waktu</span>
                                        <span class="font-semibold text-gray-900" id="timeDisplay">-</span>
                                    </div>
                                </div>

                                <div class="space-y-3 mb-6 pb-6 border-b">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Harga Sewa</span>
                                        <span class="font-semibold" id="priceDisplay">Rp 0</span>
                                    </div>
                                    <div id="sharedCostInfo" class="p-3 bg-green-50 rounded-lg hidden">
                                        <div class="flex justify-between text-sm text-green-700">
                                            <span>Dibagi <span id="participantCount">10</span> orang</span>
                                            <span class="font-bold">Rp <span id="costPerPersonDisplay">0</span>/orang</span>
                                        </div>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Biaya Layanan</span>
                                        <span class="font-semibold">Rp 5.000</span>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center mb-6">
                                    <span class="text-lg font-bold text-gray-900">Total Bayar</span>
                                    <span class="text-2xl font-bold text-blue-600" id="totalCost">
                                        Rp 0
                                    </span>
                                </div>

                                <button type="submit" id="submitBtn" disabled class="w-full py-4 bg-gray-300 text-gray-500 rounded-xl font-bold shadow-lg text-lg cursor-not-allowed transition" data-login-url="{{ route('login') }}">
                                    Pilih Jadwal Terlebih Dahulu
                                </button>

                                <p class="text-xs text-gray-500 text-center mt-4 leading-relaxed">
                                    Dengan melanjutkan, Anda setuju dengan <a href="#" class="text-blue-600 hover:underline">Syarat & Ketentuan</a> kami
                                </p>

                                <!-- Trust Badges -->
                                <div class="mt-6 pt-6 border-t">
                                    <div class="text-xs text-gray-500 mb-3 font-semibold">Booking lewat aplikasi lebih banyak keuntungan!</div>
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-2 text-xs text-gray-600">
                                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Opsi pembayaran down payment (DP)*</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-xs text-gray-600">
                                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Reschedule jadwal booking**</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-xs text-gray-600">
                                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Lebih banyak promo & voucher</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div id="errorModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeErrorModal()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
            <div class="p-6">
                <!-- Icon -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                    <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2" id="errorTitle">Oops!</h3>
                    <p class="text-gray-600" id="errorMessage">Terjadi kesalahan</p>
                </div>
                
                <!-- Button -->
                <button onclick="closeErrorModal()" class="w-full py-3 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-xl font-semibold hover:from-red-700 hover:to-red-600 transition-all shadow-lg">
                    Mengerti
                </button>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
            <div class="p-6">
                <!-- Icon -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                    <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Booking Berhasil!</h3>
                    <p class="text-gray-600">Booking Anda telah dikonfirmasi dan siap digunakan</p>
                </div>
                
                <!-- Button -->
                <a href="{{ route('bookings.index') }}" class="block w-full py-3 bg-gradient-to-r from-green-600 to-green-500 text-white rounded-xl font-semibold hover:from-green-700 hover:to-green-600 transition-all shadow-lg text-center">
                    Lihat Riwayat Booking
                </a>
            </div>
        </div>
    </div>

    <script>
        let selectedSlots = []; // [{courtId, courtName, time, price}]
        const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
        let calendarState = { month: new Date().getMonth(), year: new Date().getFullYear() };
        // Allowed dates from DB (YYYY-MM-DD)
        const allowedDates = new Set(@json(($availableDates ?? collect())->map(fn($d)=>\Carbon\Carbon::parse($d)->toDateString())));

        // Toggle court slots visibility
        function toggleCourtSlots(courtId) {
            const slotsDiv = document.querySelector(`.court-slots-${courtId}`);
            const toggleIcon = document.querySelector(`.court-toggle-${courtId}`);
            slotsDiv.classList.toggle('hidden');
            toggleIcon.classList.toggle('rotate-180');
        }

        // Toggle time slot selection (maks 2 lapangan berbeda, slot tak dibatasi)
        function toggleTimeSlot(checkbox) {
            const [courtId, courtName, time, priceStr] = checkbox.value.split('|');
            const price = parseInt(priceStr, 10);

            if (checkbox.checked) {
                // cek jumlah lapangan unik jika menambah pilihan ini
                const uniqueCourts = new Set(selectedSlots.map(s => s.courtId));
                uniqueCourts.add(courtId);
                if (uniqueCourts.size > 2) {
                    checkbox.checked = false;
                    animateShake(checkbox.nextElementSibling);
                    return;
                }
                selectedSlots.push({ courtId, courtName, time, price });
            } else {
                selectedSlots = selectedSlots.filter(s => !(s.courtId === courtId && s.time === time));
            }

            updateSummaryDisplay();
            updateSubmitState();
            syncHiddenInputs();
        }

        // Update summary display
        function updateSummaryDisplay() {
            const dateInput = document.querySelector('input[name="date"]:checked');
            if (dateInput) {
                const date = new Date(dateInput.value);
                const options = { day: 'numeric', month: 'short', year: 'numeric' };
                document.getElementById('dateDisplay').textContent = date.toLocaleDateString('id-ID', options);
            }

            if (selectedSlots.length === 0) {
                document.getElementById('courtDisplay').textContent = '-';
                document.getElementById('timeDisplay').textContent = '-';
                document.getElementById('priceDisplay').textContent = 'Rp 0';
            } else {
                // Group by court - kalau court sama cukup 1x saja
                const uniqueCourts = [...new Set(selectedSlots.map(s => s.courtName))];
                const courtText = uniqueCourts.length === 1 
                    ? uniqueCourts[0]  // Kalau sama: "Court King"
                    : uniqueCourts.join(' + ');  // Kalau beda: "Court King + Court Queen"
                
                const timeText = selectedSlots.map(s => `${s.time}`).join(' | ');
                const totalPrice = selectedSlots.reduce((sum, s) => sum + s.price, 0);
                document.getElementById('courtDisplay').textContent = courtText;
                document.getElementById('timeDisplay').textContent = timeText;
                document.getElementById('priceDisplay').textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
            }
            updateCostCalculation();
        }

        // Booking type toggle
        const bookingTypeRadios = document.querySelectorAll('input[name="booking_type"]');
        const maxParticipantsSection = document.getElementById('max_participants_section');
        const sharedCostInfo = document.getElementById('sharedCostInfo');
        const bookingTypeDisplay = document.getElementById('bookingTypeDisplay');

        function updateBookingType() {
            const selectedType = document.querySelector('input[name="booking_type"]:checked').value;
            if (selectedType === 'shared') {
                maxParticipantsSection.classList.remove('hidden');
                sharedCostInfo.classList.remove('hidden');
                bookingTypeDisplay.textContent = 'Open Slot';
            } else {
                maxParticipantsSection.classList.add('hidden');
                sharedCostInfo.classList.add('hidden');
                bookingTypeDisplay.textContent = 'Sewa Pribadi';
            }
            updateCostCalculation();
        }

        function updateCostCalculation() {
            const selectedType = document.querySelector('input[name="booking_type"]:checked').value;
            const participants = parseInt(document.getElementById('max_participants')?.value) || 10;
            const basePrice = selectedSlots.reduce((sum, s) => sum + s.price, 0);

            if (selectedType === 'shared' && basePrice > 0) {
                const costPer = Math.round(basePrice / participants);
                const total = costPer + 5000;
                document.getElementById('participantCount').textContent = participants;
                document.getElementById('costPerPersonDisplay').textContent = costPer.toLocaleString('id-ID');
                document.getElementById('costPerPerson').textContent = costPer.toLocaleString('id-ID');
                document.getElementById('totalCost').textContent = 'Rp ' + total.toLocaleString('id-ID');
            } else {
                const total = basePrice + 5000;
                document.getElementById('totalCost').textContent = 'Rp ' + total.toLocaleString('id-ID');
            }
        }

        function incrementParticipants() {
            const input = document.getElementById('max_participants');
            const currentValue = parseInt(input.value) || 10;
            if (currentValue < 20) { input.value = currentValue + 1; updateCostCalculation(); }
        }
        function decrementParticipants() {
            const input = document.getElementById('max_participants');
            const currentValue = parseInt(input.value) || 10;
            if (currentValue > 2) { input.value = currentValue - 1; updateCostCalculation(); }
        }

        // Filter time slots by period
        function filterTimeSlots(period) {
            const wrappers = document.querySelectorAll('.time-slot-wrapper');
            wrappers.forEach(wrapper => {
                const availableLabel = wrapper.querySelector('.time-slot-available');
                if (!availableLabel) return;
                
                const periodAttr = availableLabel.getAttribute('data-period');
                if (period === 'all' || periodAttr === period) {
                    wrapper.style.display = '';
                } else {
                    wrapper.style.display = 'none';
                }
            });
            
            // Update counter untuk setiap court
            updateAvailableSlotCounters();
        }
        
        // Update counter "X Jadwal untuk Court Y"
        function updateAvailableSlotCounters() {
            document.querySelectorAll('.court-item').forEach(courtItem => {
                const courtId = courtItem.getAttribute('data-court-id');
                
                // Hitung slot yang visible (tidak hidden) dan available (tidak booked)
                const visibleAvailableSlots = courtItem.querySelectorAll('.time-slot-wrapper:not([style*="display: none"]) .time-slot-available:not(.hidden)');
                const count = visibleAvailableSlots.length;
                
                // Update counter
                const infoBox = courtItem.querySelector('.court-available-info');
                const counterElement = infoBox?.querySelector('.court-available-count');
                if (counterElement) {
                    counterElement.textContent = count;
                }
                
                // Sembunyikan info box jika tidak ada slot tersedia
                if (infoBox) {
                    if (count === 0) {
                        infoBox.style.display = 'none';
                    } else {
                        infoBox.style.display = '';
                    }
                }
            });
        }

        // Dropdown helpers (mirroring venues filter)
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            const icon = document.getElementById(id.replace('-dropdown','-icon'));
            document.querySelectorAll('[id$="-dropdown"]').forEach(d => {
                if (d.id !== id) {
                    d.classList.add('hidden');
                    const otherIcon = document.getElementById(d.id.replace('-dropdown','-icon'));
                    if (otherIcon) otherIcon.style.transform = 'rotate(0deg)';
                }
            });
            dropdown.classList.toggle('hidden');
            if (icon) icon.style.transform = dropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
        }
        function selectDropdown(prefix, value, label) {
            document.getElementById(prefix + '-selected').textContent = label;
            document.getElementById(prefix + '-input').value = value;
            toggleDropdown(prefix + '-dropdown');
        }
        document.addEventListener('click', function(event) {
            if (!event.target.closest('button') && !event.target.closest('[id$="-dropdown"]')) {
                document.querySelectorAll('[id$="-dropdown"]').forEach(dropdown => {
                    dropdown.classList.add('hidden');
                    const icon = document.getElementById(dropdown.id.replace('-dropdown','-icon'));
                    if (icon) icon.style.transform = 'rotate(0deg)';
                });
            }
        });

        // Datepicker popover
        function openDatePicker(){
            const pop = document.getElementById('datepicker-popover');
            pop.classList.toggle('hidden');
            renderCalendar();
        }
        function closeDatePicker(){
            const pop = document.getElementById('datepicker-popover');
            pop.classList.add('hidden');
        }
        function navigateCalendar(delta){
            calendarState.month += delta;
            if (calendarState.month < 0) { calendarState.month = 11; calendarState.year--; }
            if (calendarState.month > 11) { calendarState.month = 0; calendarState.year++; }
            renderCalendar();
        }
        function renderCalendar(){
            const grid = document.getElementById('calendar-grid');
            const title = document.getElementById('calendar-title');
            if (!grid || !title) return;
            grid.innerHTML = '';
            const firstDay = new Date(calendarState.year, calendarState.month, 1);
            const startWeekday = (firstDay.getDay() + 6) % 7; // Monday first
            const daysInMonth = new Date(calendarState.year, calendarState.month + 1, 0).getDate();
            title.textContent = firstDay.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
            for (let i=0;i<startWeekday;i++){ const d = document.createElement('div'); d.className = 'h-9'; grid.appendChild(d); }
            const today = new Date(); today.setHours(0,0,0,0);
            for (let day=1; day<=daysInMonth; day++){
                const date = new Date(calendarState.year, calendarState.month, day);
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'h-9 rounded-md text-sm hover:bg-blue-50 hover:text-blue-600 transition';
                btn.textContent = day;
                const iso = `${date.getFullYear()}-${String(date.getMonth()+1).padStart(2,'0')}-${String(date.getDate()).padStart(2,'0')}`;
                const isPast = date.setHours(0,0,0,0) < today.getTime();
                const isAllowed = allowedDates.has(iso);
                if (isPast || !isAllowed) { btn.classList.add('text-gray-300','cursor-not-allowed'); btn.disabled = true; }
                btn.addEventListener('click', ()=>selectCalendarDate(date));
                grid.appendChild(btn);
            }
        }
        function selectCalendarDate(date){
            const val = `${date.getFullYear()}-${String(date.getMonth()+1).padStart(2,'0')}-${String(date.getDate()).padStart(2,'0')}`;
            const hiddenRadio = document.getElementById('datepicker-date-radio');
            hiddenRadio.value = val;
            hiddenRadio.checked = true;
            closeDatePicker();
            updateCourtAvailability();
        }

        // Update court availability - CHECK PER COURT!
        async function updateCourtAvailability() {
            const selectedDate = document.querySelector('input[name="date"]:checked')?.value;
            const venueId = {{ $venue->id }};
            
            if (!selectedDate) {
                return;
            }
            
            try {
                // Fetch booked slots for the selected date
                const response = await fetch(`/venues/${venueId}/booked-slots?date=${selectedDate}`);
                const data = await response.json();
                const bookedSlots = data.booked_slots || [];
                
                console.log('📅 Booked slots for', selectedDate, ':', bookedSlots);
                
                // Update UI for each time slot - CHECK PER COURT + TIME!
                document.querySelectorAll('.time-slot-wrapper').forEach(wrapper => {
                    const courtId = wrapper.getAttribute('data-court-id');
                    const time = wrapper.getAttribute('data-time');
                    const checkbox = wrapper.querySelector('input[type="checkbox"]');
                    
                    // Check if THIS SPECIFIC court + time combo is booked
                    const isBooked = bookedSlots.some(slot => 
                        slot.court_id == courtId && slot.time === time
                    );
                    
                    console.log(`Court ${courtId} @ ${time}: ${isBooked ? 'BOOKED' : 'AVAILABLE'}`);
                    
                    if (isBooked) {
                        // Slot is booked - SEMBUNYIKAN wrapper (jangan tampilkan)
                        wrapper.style.display = 'none';
                        if (checkbox) {
                            checkbox.checked = false;
                            checkbox.disabled = true;
                        }
                    } else {
                        // Slot is available - TAMPILKAN wrapper
                        wrapper.style.display = '';
                        if (checkbox) {
                            checkbox.disabled = false;
                        }
                    }
                });
                
                // Clear selected slots since date changed
                selectedSlots = [];
                updateSummaryDisplay();
                updateSubmitState();
                syncHiddenInputs();
                
                // Update counter setelah hide booked slots
                updateAvailableSlotCounters();
                
            } catch (error) {
                console.error('Error fetching booked slots:', error);
            }
        }

        function updateSubmitState(){
            const submitBtn = document.getElementById('submitBtn');
            const enabled = selectedSlots.length > 0;
            submitBtn.disabled = !enabled;
            if (enabled) {
                submitBtn.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
                submitBtn.classList.add('bg-gradient-to-r', 'from-red-600', 'to-red-500', 'text-white', 'hover:from-red-700', 'hover:to-red-600');
                submitBtn.textContent = 'Booking Sekarang';
            } else {
                submitBtn.classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
                submitBtn.classList.remove('bg-gradient-to-r','from-red-600','to-red-500','text-white','hover:from-red-700','hover:to-red-600');
                submitBtn.textContent = 'Pilih Jadwal Terlebih Dahulu';
            }
        }
        function syncHiddenInputs(){
            document.getElementById('selected_court_id').value = selectedSlots[0]?.courtId || '';
            document.getElementById('selected_time_slot').value = selectedSlots[0]?.time || '';
            const bookingForm = document.querySelector('form#bookingForm');
            if (!bookingForm) return;
            bookingForm.querySelectorAll('.selection-input').forEach(n => n.remove());
            selectedSlots.forEach(sel => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selections[]';
                input.value = `${sel.courtId}|${sel.courtName}|${sel.time}|${sel.price}`;
                input.className = 'selection-input';
                bookingForm.appendChild(input);
            });
        }
        function animateShake(el){ if (!el) return; el.classList.add('animate-shake'); setTimeout(()=>el.classList.remove('animate-shake'), 400); }

        // Gallery modal helpers
        function openCourtGallery(id){
            const el = document.getElementById('gallery-modal-' + id);
            if (el){ el.classList.remove('hidden'); el.classList.add('flex'); }
        }
        function closeCourtGallery(id){
            const el = document.getElementById('gallery-modal-' + id);
            if (el){ el.classList.add('hidden'); el.classList.remove('flex'); }
        }

        // Modal Functions
        function showErrorModal(title, message) {
            document.getElementById('errorTitle').textContent = title;
            document.getElementById('errorMessage').textContent = message;
            const modal = document.getElementById('errorModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeErrorModal() {
            const modal = document.getElementById('errorModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function showSuccessModal() {
            const modal = document.getElementById('successModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // Listeners
        bookingTypeRadios.forEach(radio => { radio.addEventListener('change', updateBookingType); });
        document.addEventListener('change', function(e) { if (e.target.name === 'date') { updateSummaryDisplay(); } });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 Page loaded, initializing...');
            updateBookingType();
            toggleCourtSlots(1);
            updateSubmitState();
            // Load booked slots for default selected date
            updateCourtAvailability();
            
            // Form submit validation - HANYA untuk form booking!
            const bookingForm = document.querySelector('form#bookingForm'); // Cari form dengan ID
            const submitBtn = document.getElementById('submitBtn');
            
            if (!bookingForm) {
                console.error('❌ Booking form not found!');
                return;
            }
            
            console.log('✅ Event listener attached to booking form');
            console.log('📝 Form element:', bookingForm);
            console.log('🔘 Submit button:', submitBtn);
            
            // Add click listener on button for debugging
            submitBtn.addEventListener('click', function(e) {
                console.log('=== BUTTON CLICKED ===');
                console.log('Button type:', submitBtn.type);
                console.log('Button disabled?', submitBtn.disabled);
                console.log('Selected slots count:', selectedSlots.length);
                console.log('Is authenticated:', isAuthenticated);
            });
            
            bookingForm.addEventListener('submit', function(e){
                console.log('🎯 BOOKING FORM SUBMIT EVENT TRIGGERED');
                
                // Check if user is authenticated
                if (!isAuthenticated) {
                    e.preventDefault();
                    window.location = document.getElementById('submitBtn').dataset.loginUrl;
                    return;
                }
                
                // Validate: Must select at least one time slot
                if (selectedSlots.length === 0) {
                    e.preventDefault();
                    showErrorModal('Belum Ada Jadwal Dipilih', 'Silakan pilih minimal 1 jadwal terlebih dahulu untuk melanjutkan booking.');
                    return;
                }
                
                // Validate: Must select date
                const selectedDate = document.querySelector('input[name="date"]:checked');
                if (!selectedDate) {
                    e.preventDefault();
                    showErrorModal('Belum Pilih Tanggal', 'Silakan pilih tanggal booking terlebih dahulu.');
                    return;
                }
                
                // Validate: Check max participants for shared booking
                const bookingType = document.querySelector('input[name="booking_type"]:checked')?.value;
                if (bookingType === 'shared') {
                    const maxParticipants = document.getElementById('max_participants')?.value;
                    if (!maxParticipants || maxParticipants < 2) {
                        e.preventDefault();
                        showErrorModal('Jumlah Peserta Tidak Valid', 'Untuk Open Slot, minimal 2 orang peserta.');
                        return;
                    }
                }
                
                // All validations passed - submit directly
                console.log('✅ All validations passed, submitting form...');
                
                // Make sure hidden inputs are synced
                syncHiddenInputs();
                
                // Show loading state
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-3 inline" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
                
                // Debug: Log form data
                const formData = new FormData(bookingForm);
                console.log('📋 Form Data:');
                for (let [key, value] of formData.entries()) {
                    console.log(`  ${key}:`, value);
                }
                
                // Update button state
                submitBtn.disabled = true;
                submitBtn.textContent = 'Memproses Booking...';
                submitBtn.classList.add('opacity-75');
                
                // Submit the form
                console.log('🚀 Submitting form to:', bookingForm.action);
                bookingForm.submit();
            });
        });
    </script>

    <style>
        /* Custom scrollbar */
        .date-scroll::-webkit-scrollbar {
            height: 6px;
        }
        
        .date-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .date-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        
        .date-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Date radio checked state */
        input[name="date"]:checked + div {
            border-color: #dc2626 !important;
            background-color: #dc2626 !important;
        }

        input[name="date"]:checked + div * {
            color: white !important;
        }

        /* Booking type checked state */
        input[name="booking_type"]:checked + div {
            border-color: #2563eb !important;
            background-color: #eff6ff !important;
        }

        input[name="booking_type"]:checked + div .peer-checked\:opacity-100 {
            opacity: 1 !important;
        }

        input[name="booking_type"]:checked + div .peer-checked\:border-blue-600 {
            border-color: #2563eb !important;
        }

        input[name="booking_type"]:checked + div .peer-checked\:bg-blue-600 {
            background-color: #2563eb !important;
        }

        /* Time slot checked state */
        .time-slot-checkbox:checked + div {
            border-color: #2563eb !important;
            background-color: #eff6ff !important;
        }

        /* Animation */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .court-slots-1,
        .court-slots-2,
        .court-slots-3,
        .court-slots-4 {
            animation: slideDown 0.3s ease-out;
        }

        /* Rotate transition */
        .transform {
            transition: transform 0.3s ease;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }

        /* Subtle shake when max selection reached */
        .animate-shake { animation: shake 0.3s ease; }
        @keyframes shake { 0%{transform:translateX(0)} 25%{transform:translateX(-3px)} 50%{transform:translateX(3px)} 75%{transform:translateX(-2px)} 100%{transform:translateX(0)} }
    </style>
</x-app-layout>