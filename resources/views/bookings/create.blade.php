<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Book {{ $venue->name }}
            </h2>
            <a href="{{ route('venues.show', $venue) }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Venue
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <div class="pt-24 pb-16 px-4">
            <div class="max-w-5xl mx-auto">
                <a href="{{ route('venues.index') }}" class="flex items-center text-blue-600 hover:text-blue-700 mb-6">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Daftar Lapangan
                </a>

                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Booking Form -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-md p-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Booking Lapangan</h2>
                            
                            <!-- Venue Info -->
                            <div class="mb-8 pb-8 border-b">
                                <div class="flex gap-4">
                                    <img src="{{ $venue->image ?? 'https://images.unsplash.com/photo-1589487391730-58f20eb2c308?w=400' }}" alt="{{ $venue->name }}" class="w-32 h-32 rounded-lg object-cover">
                                    <div class="flex-1">
                                        <span class="text-sm px-3 py-1 bg-blue-100 text-blue-600 rounded-full">{{ $venue->sport }}</span>
                                        <h3 class="text-xl font-bold text-gray-900 mt-2">{{ $venue->name }}</h3>
                                        <p class="text-gray-600 flex items-center mt-1">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $venue->location }}
                                        </p>
                                        <div class="flex items-center mt-2">
                                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            <span class="ml-1 font-semibold">{{ $venue->rating ?? 4.5 }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('bookings.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="venue_id" value="{{ $venue->id }}">

                                <!-- Booking Type -->
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Tipe Booking</label>
                                    <div class="grid sm:grid-cols-2 gap-4">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="booking_type" value="private" checked class="sr-only">
                                            <div class="p-4 border-2 border-blue-500 bg-blue-50 rounded-lg transition">
                                                <div class="font-semibold text-gray-900 mb-1">Sewa Pribadi</div>
                                                <div class="text-sm text-gray-600">Sewa lapangan untuk tim Anda sendiri</div>
                                            </div>
                                        </label>

                                        <label class="cursor-pointer">
                                            <input type="radio" name="booking_type" value="shared" class="sr-only">
                                            <div class="p-4 border-2 border-gray-300 rounded-lg transition">
                                                <div class="font-semibold text-gray-900 mb-1">Buat Open Slot</div>
                                                <div class="text-sm text-gray-600">Buka slot untuk pemain lain bergabung</div>
                                            </div>
                                        </label>
                                    </div>
                                    @error('booking_type')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Date & Time -->
                                <div class="grid sm:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
                                        <input type="date" name="date" required min="{{ date('Y-m-d') }}" 
                                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('date') border-red-500 @else border-gray-300 @enderror">
                                        @error('date')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Waktu Mulai</label>
                                        <select name="start_time" required class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('start_time') border-red-500 @else border-gray-300 @enderror">
                                            <option value="">Pilih Waktu</option>
                                            <option value="08:00">08:00</option>
                                            <option value="10:00">10:00</option>
                                            <option value="13:00">13:00</option>
                                            <option value="15:00">15:00</option>
                                            <option value="17:00">17:00</option>
                                            <option value="19:00">19:00</option>
                                            <option value="21:00">21:00</option>
                                        </select>
                                        @error('start_time')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- End Time -->
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Waktu Selesai</label>
                                    <select name="end_time" required class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('end_time') border-red-500 @else border-gray-300 @enderror">
                                        <option value="">Pilih Waktu</option>
                                        <option value="10:00">10:00</option>
                                        <option value="12:00">12:00</option>
                                        <option value="15:00">15:00</option>
                                        <option value="17:00">17:00</option>
                                        <option value="19:00">19:00</option>
                                        <option value="21:00">21:00</option>
                                        <option value="23:00">23:00</option>
                                    </select>
                                    @error('end_time')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Participants (for shared booking) -->
                                <div class="mb-6" id="max_participants_section" style="display: none;">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Jumlah Peserta Ideal
                                    </label>
                                    <input type="number" name="max_participants" min="2" max="20" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                        placeholder="10">
                                    <p class="text-sm text-gray-600 mt-2">
                                        Biaya akan dibagi rata: Rp <span id="costPerPerson">{{ number_format($venue->price / 10, 0, ',', '.') }}</span> per orang
                                    </p>
                                </div>

                                <!-- Additional Notes -->
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan (Opsional)</label>
                                    <textarea name="notes" rows="3"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                        placeholder="Tambahkan catatan khusus untuk booking Anda..."></textarea>
                                </div>

                                <button type="submit" class="w-full py-3 bg-linear-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:from-blue-700 hover:to-blue-600 transition font-semibold shadow-lg">
                                    Lanjut ke Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                    <!-- Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl shadow-md p-6 sticky top-24">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">Ringkasan Booking</h3>
                            
                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Lapangan</span>
                                    <span class="font-semibold text-gray-900">{{ $venue->name }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Tipe</span>
                                    <span class="font-semibold text-gray-900" id="bookingTypeDisplay">Sewa Pribadi</span>
                                </div>
                            </div>

                            <div class="border-t pt-4 mb-6">
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Harga Sewa</span>
                                    <span class="font-semibold">Rp {{ number_format($venue->price, 0, ',', '.') }}</span>
                                </div>
                                <div id="sharedCostInfo" class="flex justify-between mb-2 text-sm text-green-600" style="display: none;">
                                    <span>Dibagi <span id="participantCount">10</span> orang</span>
                                    <span>Rp <span id="costPerPersonDisplay">{{ number_format($venue->price / 10, 0, ',', '.') }}</span>/orang</span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Biaya Layanan</span>
                                    <span class="font-semibold">Rp 5.000</span>
                                </div>
                            </div>

                            <div class="border-t pt-4 mb-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-900">Total</span>
                                    <span class="text-2xl font-bold text-blue-600" id="totalCost">
                                        Rp {{ number_format($venue->price + 5000, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <p class="text-xs text-gray-500 text-center">
                                Dengan melanjutkan, Anda setuju dengan Syarat & Ketentuan kami
                            </p>
                        </div>
                    </div>
                </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bookingTypeRadios = document.querySelectorAll('input[name="booking_type"]');
            const maxParticipantsSection = document.getElementById('max_participants_section');
            const sharedCostInfo = document.getElementById('sharedCostInfo');
            const bookingTypeDisplay = document.getElementById('bookingTypeDisplay');
            const participantCount = document.getElementById('participantCount');
            const costPerPersonDisplay = document.getElementById('costPerPersonDisplay');
            const totalCost = document.getElementById('totalCost');
            const maxParticipantsInput = document.getElementById('max_participants');
            const venuePrice = {{ $venue->price }};
            
            function updateBookingType() {
                const selectedType = document.querySelector('input[name="booking_type"]:checked').value;
                
                if (selectedType === 'shared') {
                    maxParticipantsSection.style.display = 'block';
                    maxParticipantsInput.required = true;
                    sharedCostInfo.style.display = 'flex';
                    bookingTypeDisplay.textContent = 'Open Slot';
                    updateCostCalculation();
                } else {
                    maxParticipantsSection.style.display = 'none';
                    maxParticipantsInput.required = false;
                    sharedCostInfo.style.display = 'none';
                    bookingTypeDisplay.textContent = 'Sewa Pribadi';
                    totalCost.textContent = 'Rp ' + (venuePrice + 5000).toLocaleString('id-ID');
                }
            }
            
            function updateCostCalculation() {
                const participants = parseInt(maxParticipantsInput.value) || 10;
                const costPerPerson = Math.round(venuePrice / participants);
                const total = costPerPerson + 5000;
                
                participantCount.textContent = participants;
                costPerPersonDisplay.textContent = costPerPerson.toLocaleString('id-ID');
                totalCost.textContent = 'Rp ' + total.toLocaleString('id-ID');
            }
            
            bookingTypeRadios.forEach(radio => {
                radio.addEventListener('change', updateBookingType);
            });
            
            maxParticipantsInput.addEventListener('input', updateCostCalculation);
            
            // Initialize
            updateBookingType();
        });
    </script>
</x-app-layout>
