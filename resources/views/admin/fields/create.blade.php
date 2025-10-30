@extends('admin.layouts.app')

@section('title', 'Tambah Lapangan')
@section('subtitle', 'Buat lapangan/court baru')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Form Tambah Lapangan</h3>
            <p class="text-sm text-gray-500 mt-1">Lengkapi informasi di bawah untuk menambahkan lapangan baru</p>
        </div>
        
        <form action="{{ route('admin.fields.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <!-- Venue Information Section -->
            <div class="mb-8">
                <h4 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Informasi Venue</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Venue</label>
                        <input type="text" name="venue_name" value="{{ old('venue_name') }}" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="Tulis nama venue">
                        <p class="text-xs text-gray-500 mt-1.5">Opsional: nama yang ingin ditampilkan</p>
                        @error('venue_name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hubungkan ke Venue</label>
                        <select name="venue_id" id="venueSelect" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="" data-image="">— Tidak dihubungkan —</option>
                            @foreach($venues as $venue)
                                <option value="{{ $venue->id }}" data-image="{{ $venue->image_url }}" {{ old('venue_id') == $venue->id ? 'selected' : '' }}>
                                    {{ $venue->name }} ({{ $venue->sport }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1.5">Opsional</p>
                        <div id="venueImageContainer" class="mt-3 hidden">
                            <div class="text-xs text-gray-600 mb-1">Gambar Venue dari Database</div>
                            <img id="venueImagePreview" src="" alt="Venue Image" class="w-full max-w-xs rounded-lg border border-gray-200">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Cabor / Sport <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="sport" value="{{ old('sport') }}" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="e.g., Padel, Futsal, Tennis" required>
                        @error('sport')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Court <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="e.g., Court A, Court 1" required>
                        @error('name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                        <input type="text" name="location" value="{{ old('location') }}" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="e.g., Jakarta Timur">
                        @error('location')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link Google Maps</label>
                        <input type="url" name="maps_url" value="{{ old('maps_url') }}" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="https://maps.google.com/...">
                        @error('maps_url')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Images Section -->
            <div class="mb-8">
                <h4 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Gambar & Media</h4>
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Utama Venue</label>
                        <input type="file" name="venue_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 file:cursor-pointer cursor-pointer border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <p class="text-xs text-gray-500 mt-1.5">Format: JPG, PNG. Max 2MB</p>
                        
                        <!-- Preview Gambar Venue dari Database -->
                        <div id="venueMainImagePreview" class="mt-3 hidden">
                            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-blue-900 mb-2">Gambar Venue dari Database</p>
                                        <img id="venueMainImage" src="" alt="Venue Image" class="w-full max-w-md rounded-lg border-2 border-blue-300 shadow-sm">
                                        <p class="text-xs text-blue-700 mt-2">✓ Gambar ini akan digunakan sebagai gambar venue. Anda bisa upload gambar baru untuk menggantinya.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @error('venue_image')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Court</label>
                        <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 file:cursor-pointer cursor-pointer border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <p class="text-xs text-gray-500 mt-1.5">Format: JPG, PNG. Max 2MB</p>
                        @error('image')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Galeri Court (Opsional)</label>
                        <input type="file" name="gallery[]" multiple accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 file:cursor-pointer cursor-pointer border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <p class="text-xs text-gray-500 mt-1.5">Opsional. Bisa lebih dari 1 gambar. Format: JPG, PNG</p>
                        @error('gallery')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Description Section -->
            <div class="mb-8">
                <h4 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Deskripsi & Informasi</h4>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tentang Venue</label>
                        <textarea name="about" rows="4" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none" placeholder="Contoh: Padel Co. at Kiara Artha Park Bandung menawarkan pengalaman bermain padel terbaik dengan fasilitas modern...">{{ old('about') }}</textarea>
                        @error('about')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Aturan Venue</label>
                        <textarea name="rules" rows="4" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none" placeholder="Contoh: Non-Refundable and Reschedule. Harap datang 10 menit sebelum waktu booking...">{{ old('rules') }}</textarea>
                        @error('rules')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kebijakan Refund & Reschedule</label>
                        <textarea name="refund_policy" rows="4" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none" placeholder="Contoh: Reservasi tidak dapat dibatalkan dan tidak berlaku refund. Reschedule dapat dilakukan maksimal 24 jam sebelum waktu booking...">{{ old('refund_policy') }}</textarea>
                        @error('refund_policy')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Facilities Section -->
            <div class="mb-8">
                <h4 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Fasilitas</h4>
                @php $facilityOptions = ['Jual Minuman','Jual Makanan Ringan','Cafe & Resto','Musholla','Parkir Mobil','Parkir Motor','Toilet','Ruang Ganti','Shower','Hot Shower','Tribun Penonton','Toko Olahraga']; @endphp
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($facilityOptions as $f)
                        <label class="relative flex items-center gap-3 px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-blue-200 cursor-pointer transition group">
                            <input type="checkbox" name="facilities[]" value="{{ $f }}" {{ (is_array(old('facilities')) && in_array($f, old('facilities'))) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500">
                            <span class="text-sm text-gray-700 group-hover:text-gray-900 font-medium">{{ $f }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            
            <!-- Labels Section -->
            <div class="mb-8">
                <h4 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Keterangan Court</h4>
                @php $labelOptions = ['Indoor','Outdoor']; @endphp
                <div class="flex flex-wrap gap-3">
                    @foreach($labelOptions as $lb)
                        <label class="relative flex items-center gap-3 px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-blue-200 cursor-pointer transition group">
                            <input type="checkbox" name="labels[]" value="{{ $lb }}" {{ (is_array(old('labels')) && in_array($lb, old('labels'))) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500">
                            <span class="flex items-center gap-2 text-sm text-gray-700 group-hover:text-gray-900 font-medium">
                                @if($lb==='Indoor') 
                                    <i class="fas fa-house text-blue-600"></i>
                                @elseif($lb==='Outdoor') 
                                    <i class="fas fa-sun text-yellow-600"></i>
                                @endif
                                {{ $lb }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>
            
            <!-- Operating Hours & Pricing Section -->
            <div class="mb-8">
                <h4 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Jam Operasional & Harga</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Buka dari jam <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="open_time" value="{{ old('open_time') }}" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
                        @error('open_time')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Sampai jam <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="close_time" value="{{ old('close_time') }}" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
                        @error('close_time')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Durasi Booking (menit) <span class="text-red-500">*</span>
                        </label>
                        <select name="booking_duration_minutes" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
                            <option value="">Pilih durasi</option>
                            <option value="60" {{ old('booking_duration_minutes') == '60' ? 'selected' : '' }}>60 menit</option>
                            <option value="90" {{ old('booking_duration_minutes') == '90' ? 'selected' : '' }}>90 menit</option>
                            <option value="120" {{ old('booking_duration_minutes') == '120' ? 'selected' : '' }}>120 menit</option>
                        </select>
                        @error('booking_duration_minutes')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Harga per Sesi <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-500 font-medium">Rp</span>
                            <input type="number" step="1000" min="0" name="price_per_session" value="{{ old('price_per_session') }}" class="w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="200000" required>
                        </div>
                        @error('price_per_session')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Available Dates Section -->
            <div class="mb-8">
                <h4 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Tanggal Tersedia</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    <input type="date" id="c_availableStart" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg" placeholder="Mulai tanggal">
                    <input type="number" id="c_availableDays" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg" min="1" max="60" value="7" placeholder="Jumlah hari">
                    <button type="button" onclick="ca_generateDates()" class="px-4 py-2.5 text-sm bg-gray-100 rounded-lg hover:bg-gray-200">Generate</button>
                </div>
                <div class="mt-3 flex items-center gap-2">
                    <input type="date" id="c_manualDate" class="w-full md:w-auto px-3 py-2.5 text-sm border border-gray-300 rounded-lg">
                    <button type="button" onclick="ca_addManualDate()" class="px-4 py-2.5 text-sm bg-gray-100 rounded-lg hover:bg-gray-200">Tambah Tanggal</button>
                </div>
                <div id="c_availableDatesWrap" class="mt-3 flex flex-wrap gap-2"></div>
                <input type="hidden" name="available_start_date" id="c_available_start_date">
                <input type="hidden" name="available_days" id="c_available_days">
            </div>

            <!-- Timeslots Section -->
            <div class="mb-8">
                <h4 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Waktu Sesi & Harga Detail</h4>
                <p class="text-sm text-gray-600 mb-4">Tambahkan slot waktu spesifik dengan harga berbeda (opsional)</p>
                
                <div class="bg-gray-50 rounded-lg p-4 mb-3 border border-gray-200">
                    <div class="grid grid-cols-12 gap-2 text-xs font-medium text-gray-600 mb-3">
                        <div class="col-span-3">Mulai</div>
                        <div class="col-span-3">Selesai</div>
                        <div class="col-span-3">Harga (Rp)</div>
                        <div class="col-span-3">Status</div>
                    </div>
                    
                    <div id="timeslotRows" class="space-y-2">
                        <div class="grid grid-cols-12 gap-2 timeslot-row">
                            <div class="col-span-3">
                                <input type="time" name="timeslot_start[]" class="w-full px-2 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="08:00">
                            </div>
                            <div class="col-span-3">
                                <input type="time" name="timeslot_end[]" class="w-full px-2 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="10:00">
                            </div>
                            <div class="col-span-3">
                                <input type="number" step="1000" min="0" name="timeslot_price[]" class="w-full px-2 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="200000">
                            </div>
                            <div class="col-span-3">
                                <select name="timeslot_status[]" class="w-full px-2 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                    <option value="available">Available</option>
                                    <option value="booked">Booked</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="button" onclick="addTimeslotRow()" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                    <i class="fas fa-plus"></i>
                    Tambah Sesi
                </button>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.fields.index') }}" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                    <i class="fas fa-save mr-1.5"></i>
                    Simpan Lapangan
                </button>
            </div>
        </form>
    </div>

    <script>
        function addTimeslotRow(){
            const wrap = document.getElementById('timeslotRows');
            const row = wrap.querySelector('.timeslot-row').cloneNode(true);
            row.querySelectorAll('input, select').forEach(i => i.value = '');
            wrap.appendChild(row);
        }
        // Preview venue image from DB on select change
        (function initVenuePreview(){
            const select = document.getElementById('venueSelect');
            if (!select) return;
            const container = document.getElementById('venueImageContainer');
            const img = document.getElementById('venueImagePreview');
            
            async function update(){
                const opt = select.options[select.selectedIndex];
                const venueId = select.value;
                
                // Show/hide image in dropdown preview
                const src = opt?.dataset?.image || '';
                if (src) {
                    img.src = src;
                    container.classList.remove('hidden');
                } else {
                    img.src = '';
                    container.classList.add('hidden');
                }
                
                // Auto-populate venue data (SEMUA field dari venue/court pertama)
                if (venueId) {
                    try {
                        const response = await fetch(`/admin/venues/${venueId}`);
                        const venue = await response.json();
                        
                        // Informasi Venue
                        document.querySelector('input[name="venue_name"]').value = venue.name || '';
                        document.querySelector('input[name="sport"]').value = venue.sport || '';
                        document.querySelector('input[name="location"]').value = venue.location || '';
                        document.querySelector('input[name="maps_url"]').value = venue.maps_url || '';
                        
                        // Deskripsi & Informasi
                        document.querySelector('textarea[name="about"]').value = venue.description || '';
                        document.querySelector('textarea[name="rules"]').value = venue.rules || '';
                        document.querySelector('textarea[name="refund_policy"]').value = venue.refund_policy || '';
                        
                        // Fasilitas - check checkboxes
                        if (venue.facilities && Array.isArray(venue.facilities)) {
                            document.querySelectorAll('input[name="facilities[]"]').forEach(checkbox => {
                                checkbox.checked = venue.facilities.includes(checkbox.value);
                            });
                        }
                        
                        // Keterangan Court (Indoor/Outdoor)
                        if (venue.labels && Array.isArray(venue.labels)) {
                            document.querySelectorAll('input[name="labels[]"]').forEach(checkbox => {
                                checkbox.checked = venue.labels.includes(checkbox.value);
                            });
                        }
                        
                        // Jam Operasional & Harga
                        document.querySelector('input[name="open_time"]').value = venue.open_time || '08:00';
                        document.querySelector('input[name="close_time"]').value = venue.close_time || '22:00';
                        document.querySelector('select[name="booking_duration_minutes"]').value = venue.booking_duration_minutes || 90;
                        document.querySelector('input[name="price_per_session"]').value = venue.price_per_session || venue.price || 0;
                        
                        // Status
                        document.querySelector('select[name="status"]').value = venue.status || 'active';
                        
                        // Show venue main image preview
                        const mainImagePreview = document.getElementById('venueMainImagePreview');
                        const mainImageImg = document.getElementById('venueMainImage');
                        if (venue.image) {
                            mainImageImg.src = venue.image;
                            mainImagePreview.classList.remove('hidden');
                        } else {
                            mainImageImg.src = '';
                            mainImagePreview.classList.add('hidden');
                        }
                        
                        console.log('✅ Semua data venue berhasil dimuat:', venue.name);
                        console.log('💡 Anda bisa mengubah field apapun untuk membedakan court ini');
                    } catch (error) {
                        console.error('Error loading venue data:', error);
                    }
                } else {
                    // Clear all auto-filled fields if no venue selected
                    document.querySelector('input[name="venue_name"]').value = '';
                    document.querySelector('input[name="sport"]').value = '';
                    document.querySelector('input[name="location"]').value = '';
                    document.querySelector('input[name="maps_url"]').value = '';
                    document.querySelector('textarea[name="about"]').value = '';
                    document.querySelector('textarea[name="rules"]').value = '';
                    document.querySelector('textarea[name="refund_policy"]').value = '';
                    document.querySelectorAll('input[name="facilities[]"]').forEach(cb => cb.checked = false);
                    document.querySelectorAll('input[name="labels[]"]').forEach(cb => cb.checked = false);
                    
                    // Hide venue main image preview
                    const mainImagePreview = document.getElementById('venueMainImagePreview');
                    mainImagePreview.classList.add('hidden');
                }
            }
            
            select.addEventListener('change', update);
            update();
        })();
        function ca_pushDate(value){
            const wrap=document.getElementById('c_availableDatesWrap');
            const chip=document.createElement('span');
            chip.className='px-2 py-1 rounded bg-blue-50 text-blue-700 text-sm flex items-center gap-2';
            chip.innerHTML = value + '<button type="button" class="text-red-600" onclick="this.parentElement.nextElementSibling.remove(); this.parentElement.remove();">×</button>';
            const hidden=document.createElement('input');
            hidden.type='hidden'; hidden.name='available_dates[]'; hidden.value=value;
            wrap.appendChild(chip); wrap.appendChild(hidden);
        }
        function ca_generateDates(){
            const start=document.getElementById('c_availableStart').value;
            const days=document.getElementById('c_availableDays').value;
            if(!start||!days) return;
            document.getElementById('c_available_start_date').value=start;
            document.getElementById('c_available_days').value=days;
            const wrap=document.getElementById('c_availableDatesWrap');
            wrap.innerHTML='';
            for(let i=0;i<parseInt(days);i++){
                const d=new Date(start); d.setDate(d.getDate()+i);
                const iso=d.toISOString().slice(0,10); ca_pushDate(iso);
            }
        }
        function ca_addManualDate(){
            const val=document.getElementById('c_manualDate').value; if(!val) return; ca_pushDate(val);
        }
    </script>
@endsection