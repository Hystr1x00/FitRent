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
                        <input type="text" name="venue_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Tulis nama venue">
                        <p class="text-xs text-gray-500 mt-1.5">Opsional: nama yang ingin ditampilkan</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hubungkan ke Venue</label>
                        <select name="venue_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="">— Tidak dihubungkan —</option>
                            @foreach($venues as $venue)
                                <option value="{{ $venue->id }}">{{ $venue->name }} ({{ $venue->sport }})</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1.5">Opsional</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cabor / Sport <span class="text-red-500">*</span></label>
                        <input type="text" name="sport" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="e.g., Padel, Futsal, Tennis" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Court <span class="text-red-500">*</span></label>
                        <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="e.g., Court A, Court 1" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi <span class="text-red-500">*</span></label>
                        <input type="text" name="location" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="e.g., Jakarta Timur">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link Google Maps</label>
                        <input type="url" name="maps_url" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="https://maps.google.com/...">
                    </div>
                </div>
            </div>
            
            <!-- Images Section -->
            <div class="mb-8">
                <h4 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Gambar & Media</h4>
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Utama Venue</label>
                        <input type="file" name="venue_image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-1.5">Format: JPG, PNG. Max 2MB</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Court</label>
                        <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-1.5">Format: JPG, PNG. Max 2MB</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Galeri Court</label>
                        <input type="file" name="gallery[]" multiple accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-1.5">Boleh lebih dari 1 gambar. Format: JPG, PNG</p>
                    </div>
                </div>
            </div>
            
            <!-- Description Section -->
            <div class="mb-8">
                <h4 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Deskripsi & Informasi</h4>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tentang Venue</label>
                        <textarea name="about" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Contoh: Padel Co. at Kiara Artha Park Bandung menawarkan pengalaman bermain padel terbaik dengan fasilitas modern..."></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Aturan Venue</label>
                        <textarea name="rules" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Contoh: Non-Refundable and Reschedule. Harap datang 10 menit sebelum waktu booking..."></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kebijakan Refund & Reschedule</label>
                        <textarea name="refund_policy" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Contoh: Reservasi tidak dapat dibatalkan dan tidak berlaku refund. Reschedule dapat dilakukan maksimal 24 jam sebelum waktu booking..."></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Facilities Section -->
            <div class="mb-8">
                <h4 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Fasilitas</h4>
                @php $facilityOptions = ['Jual Minuman','Musholla','Parkir Mobil','Parkir Motor','Toilet','Tribun Penonton','Hot Shower','Shower','Ruang Ganti']; @endphp
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($facilityOptions as $f)
                        <label class="flex items-center gap-3 px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                            <input type="checkbox" name="facilities[]" value="{{ $f }}" class="w-4 h-4 rounded text-blue-600 focus:ring-2 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">{{ $f }}</span>
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
                        <label class="flex items-center gap-3 px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                            <input type="checkbox" name="labels[]" value="{{ $lb }}" class="w-4 h-4 rounded text-blue-600 focus:ring-2 focus:ring-blue-500">
                            <span class="flex items-center gap-2 text-sm text-gray-700">
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
                        <label class="block text-sm font-medium text-gray-700 mb-2">Buka dari jam <span class="text-red-500">*</span></label>
                        <input type="time" name="open_time" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sampai jam <span class="text-red-500">*</span></label>
                        <input type="time" name="close_time" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Durasi Booking (menit) <span class="text-red-500">*</span></label>
                        <select name="booking_duration_minutes" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                            <option value="">Pilih durasi</option>
                            <option value="60">60 menit</option>
                            <option value="90">90 menit</option>
                            <option value="120">120 menit</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga per Sesi <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                            <input type="number" step="1000" min="0" name="price_per_session" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="200000" required>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                            <option value="active">Aktif</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="inactive">Nonaktif</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Timeslots Section -->
            <div class="mb-8">
                <h4 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Waktu Sesi & Harga Detail</h4>
                <p class="text-sm text-gray-600 mb-4">Tambahkan slot waktu spesifik dengan harga berbeda (opsional)</p>
                
                <div class="bg-gray-50 rounded-lg p-4 mb-3">
                    <div class="grid grid-cols-12 gap-2 text-xs font-medium text-gray-600 mb-2">
                        <div class="col-span-3">Mulai</div>
                        <div class="col-span-3">Selesai</div>
                        <div class="col-span-3">Harga (Rp)</div>
                        <div class="col-span-3">Status</div>
                    </div>
                    
                    <div id="timeslotRows" class="space-y-2">
                        <div class="grid grid-cols-12 gap-2 timeslot-row">
                            <div class="col-span-3">
                                <input type="time" name="timeslot_start[]" class="w-full px-2 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="08:00">
                            </div>
                            <div class="col-span-3">
                                <input type="time" name="timeslot_end[]" class="w-full px-2 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="10:00">
                            </div>
                            <div class="col-span-3">
                                <input type="number" step="1000" min="0" name="timeslot_price[]" class="w-full px-2 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="200000">
                            </div>
                            <div class="col-span-3">
                                <select name="timeslot_status[]" class="w-full px-2 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                    <option value="available">Available</option>
                                    <option value="booked">Booked</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="button" onclick="addTimeslotRow()" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
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
    </script>
@endsection