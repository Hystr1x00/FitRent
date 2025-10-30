<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Booking Details
            </h2>
            <a href="{{ route('bookings.index') }}" class="text-indigo-600 hover:text-indigo-800">
                ← Back to Bookings
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <div class="pt-24 pb-16 px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Back Button -->
                <a href="{{ route('bookings.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 mb-6 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="font-medium">Kembali ke My Booking</span>
                </a>
                
                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Booking Details -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <!-- Venue Header Image -->
                            <div class="relative h-48 bg-gradient-to-r from-blue-600 to-blue-800">
                                @if($booking->slot->venue->image)
                                    <img src="{{ asset('storage/' . $booking->slot->venue->image) }}" 
                                         alt="{{ $booking->slot->venue->name }}" 
                                         class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                                @endif
                                <div class="absolute bottom-4 left-6 right-6">
                                    <h3 class="text-2xl font-bold text-white mb-1">{{ $booking->slot->venue->name }}</h3>
                                    <p class="text-white/90 text-sm">{{ $booking->slot->venue->location }}</p>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <!-- Court & Type Info -->
                                <div class="flex flex-wrap gap-2 mb-6">
                                    <span class="inline-flex items-center bg-blue-100 text-blue-800 px-3 py-1.5 rounded-full text-sm font-semibold">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                        </svg>
                                            {{ $booking->slot->sport }}
                                    </span>
                                    @if($booking->slot->court_name)
                                        <span class="inline-flex items-center bg-purple-100 text-purple-800 px-3 py-1.5 rounded-full text-sm font-semibold">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            {{ $booking->slot->court_name }}
                                        </span>
                                    @endif
                                    <span class="inline-flex items-center {{ $booking->type === 'private' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }} px-3 py-1.5 rounded-full text-sm font-semibold">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($booking->type === 'private')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            @endif
                                        </svg>
                                        {{ $booking->type === 'private' ? 'Private Booking' : 'Open Slot' }}
                                    </span>
                                </div>
                                
                                <!-- Booking Info -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-3">Booking Information</h4>
                                        <div class="space-y-2">
                                            <div class="flex items-center text-sm">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span class="text-gray-600">Date:</span>
                                                <span class="ml-2 font-medium">{{ $booking->slot->date->format('d M Y') }}</span>
                                            </div>
                                            <div class="flex items-center text-sm">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="text-gray-600">Time:</span>
                                                <span class="ml-2 font-medium">{{ $booking->slot->time }}</span>
                                            </div>
                                            <div class="flex items-center text-sm">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                <span class="text-gray-600">Participants:</span>
                                                <span class="ml-2 font-medium">{{ $booking->slot->current_participants }}/{{ $booking->slot->max_participants }}</span>
                                            </div>
                                            <div class="flex items-center text-sm">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="text-gray-600">Status:</span>
                                                <span class="ml-2 font-medium">
                                                    @if($booking->status === 'confirmed')
                                                        <span class="text-green-600">Confirmed</span>
                                                    @elseif($booking->status === 'pending')
                                                        <span class="text-yellow-600">Pending</span>
                                                    @else
                                                        <span class="text-red-600">Cancelled</span>
                                                    @endif
                                                </span>
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
                                                <p class="font-medium text-gray-900">{{ $booking->slot->creator->name }}</p>
                                                <p class="text-sm text-gray-600">{{ $booking->slot->creator->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Participants List -->
                                @if($booking->slot->participants->count() > 0)
                                    <div class="mb-6">
                                        <h4 class="font-semibold text-gray-900 mb-3">Participants</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            @foreach($booking->slot->participants as $participant)
                                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <p class="font-medium text-gray-900">{{ $participant->name }}</p>
                                                        <p class="text-sm text-gray-600">{{ $participant->email }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Return (Pengembalian) -->
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <h4 class="font-semibold text-gray-900 mb-3">Pengembalian Lapangan</h4>
                                    @if(!$booking->returned_at)
                                        @if($isCreator)
                                        <form action="{{ route('bookings.return', $booking) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                            @csrf
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Kondisi Akhir</label>
                                                    <input type="file" name="return_photo" accept="image/*" required class="w-full text-sm border border-gray-300 rounded-lg p-2">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Pengembalian</label>
                                                    <input type="datetime-local" name="returned_at" required class="w-full text-sm border border-gray-300 rounded-lg p-2">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                                                <textarea name="return_note" rows="3" class="w-full border border-gray-300 rounded-lg p-3" placeholder="Catatan kondisi, kejadian, dll (opsional)"></textarea>
                                            </div>
                                            
                                            <div class="flex items-start gap-3 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <div class="text-sm text-blue-800">
                                                    <p class="font-semibold mb-1">Informasi Pengembalian:</p>
                                                    <ul class="list-disc list-inside space-y-1 text-xs">
                                                        <li>Toleransi keterlambatan: <strong>15 menit gratis</strong></li>
                                                        <li>Denda: <strong>Rp 50,000 per 5 menit</strong> setelah toleransi</li>
                                                        <li>Upload foto kondisi akhir lapangan untuk verifikasi</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            
                                            <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-xl font-semibold text-lg hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-lg hover:shadow-xl transition-all">
                                                <div class="flex items-center justify-center gap-2">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Submit Pengembalian Lapangan
                                                </div>
                                            </button>
                                        </form>
                                        @else
                                        <!-- Not Creator Message -->
                                        <div class="p-4 bg-gray-50 border-2 border-gray-200 rounded-lg">
                                            <div class="flex items-start gap-3">
                                                <svg class="w-6 h-6 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                </svg>
                                                <div>
                                                    <p class="font-semibold text-gray-800 mb-1">Pengembalian Lapangan</p>
                                                    <p class="text-sm text-gray-600">Hanya <strong>creator slot</strong> yang dapat mengembalikan lapangan dan mengupload foto kondisi akhir.</p>
                                                    <p class="text-xs text-gray-500 mt-2">Creator: <strong>{{ $booking->slot->creator->name }}</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @else
                                        <div class="p-4 bg-green-50 rounded-lg border-2 border-green-200">
                                            <div class="flex items-start gap-3 mb-3">
                                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-semibold text-green-800 mb-1">Pengembalian Berhasil</p>
                                                    <p class="text-sm text-green-700">Dikembalikan pada: <span class="font-medium">{{ $booking->returned_at->format('d M Y H:i') }}</span></p>
                                                    
                                                @if($booking->return_photo)
                                                        <a href="{{ asset('storage/' . $booking->return_photo) }}" target="_blank" class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800 font-medium mt-2">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                            Lihat Foto Kondisi Akhir
                                                        </a>
                                                    @endif
                                                    
                                                    @if($booking->return_note)
                                                        <div class="mt-2 p-2 bg-white rounded border border-green-200">
                                                            <p class="text-xs text-gray-600 font-semibold mb-1">Catatan:</p>
                                                            <p class="text-xs text-gray-700">{{ $booking->return_note }}</p>
                                                        </div>
                                                @endif
                                                </div>
                                            </div>
                                            
                                            @if($booking->penalty_amount > 0)
                                                <div class="mt-3 p-4 {{ $booking->penalty_paid_at ? 'bg-gray-50 border-gray-200' : 'bg-red-50 border-red-200' }} border-2 rounded-lg">
                                                    <div class="flex items-start justify-between gap-3">
                                                        <div class="flex items-start gap-3 flex-1">
                                                            <svg class="w-6 h-6 {{ $booking->penalty_paid_at ? 'text-gray-600' : 'text-red-600' }} flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                            <div class="flex-1">
                                                                <p class="font-semibold {{ $booking->penalty_paid_at ? 'text-gray-800' : 'text-red-800' }} mb-1">Denda Keterlambatan</p>
                                                                <p class="text-2xl font-bold {{ $booking->penalty_paid_at ? 'text-gray-900' : 'text-red-600' }} mb-2">
                                                                    Rp {{ number_format($booking->penalty_amount, 0, ',', '.') }}
                                                                </p>
                                                                @if($booking->penalty_paid_at)
                                                                    <div class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-sm font-medium">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                        </svg>
                                                                        Sudah Dibayar - {{ $booking->penalty_paid_at->format('d M Y H:i') }}
                                                                    </div>
                                                                @else
                                                                    <p class="text-xs text-red-600 mb-3">Ditetapkan oleh admin • Rp 50,000 per 5 menit</p>
                                                                    <form action="{{ route('bookings.payPenalty', $booking) }}" method="POST">
                                                                        @csrf
                                                                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-lg font-semibold text-sm hover:from-red-700 hover:to-red-600 transition-all shadow-lg hover:shadow-xl">
                                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                                            </svg>
                                                                            Bayar Denda Sekarang
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            @if($booking->return_status)
                                                <div class="mt-3 flex items-center justify-between">
                                                    <p class="text-sm text-gray-700">Status Verifikasi:</p>
                                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $booking->return_status === 'approved' ? 'bg-green-100 text-green-800' : ($booking->return_status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                        {{ $booking->return_status === 'approved' ? 'Disetujui' : ($booking->return_status === 'rejected' ? 'Ditolak' : 'Menunggu Verifikasi Admin') }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl shadow-md sticky top-6">
                            <div class="p-6">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4">Payment Summary</h4>
                                
                                @php
                                    $venuePrice = $booking->total_price ?? $booking->slot->price_per_person ?? 0;
                                    $serviceFee = 5000;
                                    $tax = 5000;
                                    $totalAmount = $venuePrice + $serviceFee + $tax;
                                @endphp
                                
                                <div class="space-y-3">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Venue Price</span>
                                        <span class="font-medium">Rp {{ number_format($venuePrice, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Service Fee</span>
                                        <span class="font-medium">Rp {{ number_format($serviceFee, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Tax</span>
                                        <span class="font-medium">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="border-t pt-3">
                                        <div class="flex justify-between font-semibold text-base">
                                            <span>Total</span>
                                            <span class="text-blue-600">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <h5 class="font-semibold text-gray-900 mb-2">Payment Method</h5>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-8 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                        Credit Card ending in 4242
                                    </div>
                                </div>
                                
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <h5 class="font-semibold text-gray-900 mb-2">Booking ID</h5>
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm text-gray-600 font-mono">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
                                        <button onclick="navigator.clipboard.writeText('{{ $booking->id }}')" class="text-xs text-blue-600 hover:text-blue-800">
                                            Copy
                                        </button>
                                    </div>
                                </div>
                                
                                @if($booking->payment_status)
                                    <div class="mt-4 pt-4 border-t border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600">Payment Status</span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $booking->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ ucfirst($booking->payment_status) }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>