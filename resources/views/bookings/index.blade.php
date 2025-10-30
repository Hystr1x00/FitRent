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
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
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
                                <p class="text-3xl font-bold text-green-600 mt-1">{{ $totalConfirmed }}</p>
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
                                <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $totalPending }}</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-between">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md p-6 cursor-pointer hover:shadow-lg transition" onclick="openPenaltyModal()">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Total Denda</p>
                                <p class="text-2xl font-bold {{ $totalPenalty > 0 ? 'text-red-600' : 'text-gray-900' }} mt-1">
                                    Rp {{ number_format($totalPenalty, 0, ',', '.') }}
                                </p>
                                @if($bookingsWithPenalty->count() > 0)
                                    <p class="text-xs text-red-500 mt-1">{{ $bookingsWithPenalty->count() }} booking</p>
                                @endif
                            </div>
                            <div class="w-12 h-12 {{ $totalPenalty > 0 ? 'bg-red-100' : 'bg-gray-100' }} rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 {{ $totalPenalty > 0 ? 'text-red-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
                                        @if($booking->slot->court_name)
                                            <div class="text-xs text-purple-600 font-medium mt-1">
                                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                                {{ $booking->slot->court_name }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">{{ $booking->slot->date->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $booking->slot->time }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 {{ $booking->type === 'private' ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600' }} rounded-full text-xs font-semibold">
                                            {{ $booking->type === 'private' ? 'Private' : 'Open Slot' }}
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

    <!-- Success Modal -->
    @if(session('booking_success'))
    <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all animate-scale-in">
            <div class="p-8">
                <!-- Success Animation Icon -->
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6 animate-bounce-in">
                    <svg class="h-10 w-10 text-green-600 animate-check" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">🎉 Booking Berhasil!</h3>
                    <p class="text-gray-600 text-lg">Booking Anda telah dikonfirmasi dan siap digunakan</p>
                    <div class="mt-4 p-4 bg-green-50 rounded-lg">
                        <p class="text-sm text-green-800">
                            <span class="font-semibold">✓ Pembayaran dikonfirmasi</span><br>
                            <span class="text-xs">Data booking sudah tersimpan di sistem</span>
                        </p>
                    </div>
                </div>
                
                <!-- Button -->
                <button onclick="closeSuccessModal()" class="w-full py-4 bg-gradient-to-r from-green-600 to-green-500 text-white rounded-xl font-bold hover:from-green-700 hover:to-green-600 transition-all shadow-lg text-lg">
                    Lihat Riwayat Booking
                </button>
            </div>
        </div>
    </div>

    <script>
        function closeSuccessModal() {
            const modal = document.getElementById('successModal');
            if (modal) {
                modal.style.opacity = '0';
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 300);
            }
        }

        // Auto show modal on page load
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('successModal');
            if (modal) {
                setTimeout(() => {
                    modal.style.opacity = '1';
                }, 100);
            }
        });
    </script>

    <style>
        @keyframes scale-in {
            from {
                transform: scale(0.9);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes bounce-in {
            0% {
                transform: scale(0);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }

        @keyframes check {
            0% {
                stroke-dasharray: 0 100;
            }
            100% {
                stroke-dasharray: 100 0;
            }
        }

        .animate-scale-in {
            animation: scale-in 0.3s ease-out;
        }

        .animate-bounce-in {
            animation: bounce-in 0.5s ease-out;
        }

        .animate-check {
            animation: check 0.5s ease-out 0.3s;
        }

        #successModal {
            transition: opacity 0.3s ease-out;
        }
    </style>
    @endif
    
    <!-- Modal Denda -->
    <div id="penaltyModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto animate-scale-in">
            <!-- Header -->
            <div class="bg-gradient-to-r from-red-600 to-red-500 p-6 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">Rincian Denda Keterlambatan</h3>
                            <p class="text-red-100 text-sm mt-1">Toleransi: 15 menit | Denda: Rp 50,000 per 5 menit</p>
                        </div>
                    </div>
                    <button onclick="closePenaltyModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Content -->
            <div class="p-6">
                @if($bookingsWithPenalty->count() > 0)
                    <div class="space-y-4 mb-6">
                        @foreach($bookingsWithPenalty as $booking)
                            <div class="border-2 border-red-100 rounded-xl p-5 hover:border-red-300 transition bg-white">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-3">
                                            <h4 class="font-bold text-gray-900 text-lg">{{ $booking->slot->venue->name }}</h4>
                                            <span class="text-xs bg-red-100 text-red-600 px-2.5 py-1 rounded-full font-semibold">
                                                #{{ $booking->id }}
                                            </span>
                                        </div>
                                        <div class="grid grid-cols-2 gap-x-4 gap-y-3 text-sm mb-4">
                                            <div class="flex items-center text-gray-600">
                                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}
                                            </div>
                                            <div class="flex items-center text-gray-600">
                                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $booking->time }}
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between bg-red-50 rounded-lg p-3 mb-3">
                                            <div>
                                                <p class="text-xs text-red-600 font-medium mb-1">Denda Keterlambatan</p>
                                                <p class="text-2xl font-bold text-red-600">Rp {{ number_format($booking->penalty_amount, 0, ',', '.') }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs text-gray-500">Ditetapkan Admin</p>
                                                <p class="text-xs text-red-500 font-medium">Rp 50k per 5 menit</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <form action="{{ route('bookings.payPenalty', $booking) }}" method="POST" class="flex-1">
                                                @csrf
                                                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-lg font-semibold text-sm hover:from-red-700 hover:to-red-600 transition-all shadow-md hover:shadow-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                    </svg>
                                                    Bayar Denda
                                                </button>
                                            </form>
                                            <a href="{{ route('bookings.show', $booking) }}" class="inline-flex items-center justify-center px-4 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold text-sm hover:bg-gray-50 transition-all whitespace-nowrap">
                                                Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Total -->
                    <div class="border-t-2 border-red-200 pt-4">
                        <div class="flex items-center justify-between bg-red-50 rounded-xl p-4">
                            <div>
                                <p class="text-sm text-red-600 font-medium">Total Denda Keterlambatan</p>
                                <p class="text-xs text-red-500 mt-1">{{ $bookingsWithPenalty->count() }} booking terlambat</p>
                            </div>
                            <p class="text-3xl font-bold text-red-600">
                                Rp {{ number_format($totalPenalty, 0, ',', '.') }}
                            </p>
                        </div>
                        
                        <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex gap-2">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="text-sm text-yellow-800">
                                    <p class="font-semibold mb-1">Informasi Penting:</p>
                                    <ul class="list-disc list-inside space-y-1 text-xs">
                                        <li>Toleransi keterlambatan: <strong>15 menit gratis</strong></li>
                                        <li>Denda: <strong>Rp 50,000 per menit</strong> setelah toleransi</li>
                                        <li>Denda akan ditambahkan ke tagihan Anda</li>
                                        <li>Hubungi admin untuk informasi lebih lanjut</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-2">Tidak Ada Denda</h4>
                        <p class="text-gray-600">Selamat! Anda tidak memiliki denda keterlambatan.</p>
                    </div>
                @endif
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 rounded-b-2xl flex justify-end">
                <button onclick="closePenaltyModal()" class="px-6 py-2.5 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    
    <script>
        function openPenaltyModal() {
            const modal = document.getElementById('penaltyModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        
        function closePenaltyModal() {
            const modal = document.getElementById('penaltyModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        
        // Auto-open modal jika ada penalty dari session
        @if(session('penalty'))
            document.addEventListener('DOMContentLoaded', function() {
                openPenaltyModal();
            });
        @endif
    </script>
</x-app-layout>