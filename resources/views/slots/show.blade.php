<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Open Slot Details
            </h2>
            <a href="{{ route('slots.index') }}" class="text-indigo-600 hover:text-indigo-800">
                ← Back to Open Slots
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <div class="pt-24 pb-16 px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Back Button -->
                <a href="{{ route('slots.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 mb-6 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="font-medium">Kembali ke Open Slots</span>
                </a>
                
                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Slot Details -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <!-- Venue Header Image -->
                            <div class="relative h-48 bg-gradient-to-r from-blue-600 to-blue-800">
                                @if($slot->venue->image)
                                    <img src="{{ asset('storage/' . $slot->venue->image) }}" 
                                         alt="{{ $slot->venue->name }}" 
                                         class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                                @endif
                                <div class="absolute bottom-4 left-6 right-6">
                                    <h3 class="text-2xl font-bold text-white mb-1">{{ $slot->venue->name }}</h3>
                                    <p class="text-white/90 text-sm">{{ $slot->venue->location }}</p>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <!-- Sport & Status Info -->
                                <div class="flex flex-wrap gap-2 mb-6">
                                    <span class="inline-flex items-center bg-blue-100 text-blue-800 px-3 py-1.5 rounded-full text-sm font-semibold">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                        </svg>
                                        {{ $slot->venue->sport }}
                                    </span>
                                    @if($slot->court_name)
                                        <span class="inline-flex items-center bg-purple-100 text-purple-800 px-3 py-1.5 rounded-full text-sm font-semibold">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            {{ $slot->court_name }}
                                        </span>
                                    @endif
                                    <span class="inline-flex items-center bg-orange-100 text-orange-800 px-3 py-1.5 rounded-full text-sm font-semibold">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Open Slot
                                    </span>
                                    @if($slot->status === 'open')
                                        <span class="inline-flex items-center bg-green-100 text-green-800 px-3 py-1.5 rounded-full text-sm font-semibold animate-pulse">
                                            🟢 Available
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Slot Info -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-3">Slot Information</h4>
                                        <div class="space-y-2">
                                            <div class="flex items-center text-sm">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span class="text-gray-600">Date:</span>
                                                <span class="ml-2 font-medium">{{ $slot->date->format('d M Y') }}</span>
                                            </div>
                                            <div class="flex items-center text-sm">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="text-gray-600">Time:</span>
                                                <span class="ml-2 font-medium">{{ $slot->time }}</span>
                                            </div>
                                            <div class="flex items-center text-sm">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                <span class="text-gray-600">Participants:</span>
                                                <span class="ml-2 font-medium">{{ $slot->current_participants }}/{{ $slot->max_participants }}</span>
                                            </div>
                                            <div class="flex items-center text-sm">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                                <span class="text-gray-600">Slots Remaining:</span>
                                                <span class="ml-2 font-medium text-green-600">{{ $slotsRemaining }} slot{{ $slotsRemaining > 1 ? 's' : '' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-3">Slot Creator</h4>
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $slot->creator->name }}</p>
                                                <p class="text-sm text-gray-600">{{ $slot->creator->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Participants List -->
                                @if($slot->participants->count() > 0)
                                    <div class="mb-6">
                                        <h4 class="font-semibold text-gray-900 mb-3">Participants</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            @foreach($slot->participants as $participant)
                                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <p class="font-medium text-gray-900">{{ $participant->user->name }}</p>
                                                        <p class="text-sm text-gray-600">{{ $participant->user->email }}</p>
                                                    </div>
                                                    @if($participant->user_id === $slot->creator_id)
                                                        <span class="ml-auto bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full font-semibold">Creator</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Payment Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden sticky top-6">
                            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                                <h3 class="text-lg font-bold text-white">Payment Summary</h3>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Biaya per orang</span>
                                        <span class="font-semibold text-gray-900">Rp {{ number_format($pricePerPerson, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Biaya layanan</span>
                                        <span class="font-semibold text-gray-900">Rp {{ number_format($serviceFee, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="border-t border-gray-200 pt-4">
                                        <div class="flex justify-between items-center">
                                            <span class="text-lg font-bold text-gray-900">Total</span>
                                            <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="mt-6">
                                    @auth
                                        @if(auth()->id() === $slot->creator_id)
                                            <div class="w-full py-3 bg-blue-100 text-blue-700 rounded-lg text-center font-semibold border-2 border-blue-200 flex items-center justify-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Ini Slot Anda (Creator)
                                            </div>
                                        @elseif($hasJoined)
                                            <div class="w-full py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-300 rounded-lg">
                                                <div class="flex items-center justify-center gap-3 mb-2">
                                                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center animate-pulse">
                                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <p class="text-center font-bold text-green-800 text-base mb-1">Sudah Tergabung!</p>
                                                <p class="text-center text-sm text-green-600">Anda adalah peserta slot ini</p>
                                            </div>
                                        @elseif($slot->current_participants >= $slot->max_participants)
                                            <div class="w-full py-3 bg-red-100 text-red-800 rounded-lg text-center font-bold border-2 border-red-200">
                                                ⛔ Slot Sudah Penuh
                                            </div>
                                        @elseif($slot->status !== 'open')
                                            <div class="w-full py-3 bg-gray-100 text-gray-600 rounded-lg text-center font-semibold border-2 border-gray-200">
                                                Slot Tidak Tersedia
                                            </div>
                                        @else
                                            <form action="{{ route('slots.join', $slot) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-full py-4 bg-gradient-to-r from-green-600 to-green-500 text-white rounded-lg hover:from-green-700 hover:to-green-600 transition font-bold text-lg shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                    </svg>
                                                    Join Slot
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="w-full py-4 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-bold text-center block shadow-lg flex items-center justify-center gap-2">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                            </svg>
                                            Login untuk Join
                                        </a>
                                    @endauth
                                </div>

                                <!-- Info Box -->
                                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                    <p class="text-xs text-blue-800">
                                        <strong>ℹ️ Info:</strong> Pembayaran otomatis diproses setelah join slot. Data booking akan tersimpan di riwayat Anda.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
