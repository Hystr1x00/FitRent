<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Venues') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-50">
    <div class="pt-12 pb-16 px-4">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8">Temukan Lapangan</h1>
            
            <!-- Filters - Responsive Style -->
            <div class="bg-gradient-to-r from-blue-700 to-blue-600 p-4 md:p-6 rounded-xl shadow-lg mb-8">
                <form action="{{ route('venues.index') }}" method="GET">
                    <!-- Desktop & Tablet Horizontal Layout -->
                    <div class="hidden md:flex items-center justify-between gap-4 lg:gap-6">
                        <!-- Aktivitas -->
                        <div class="flex items-center gap-3 flex-1 relative group">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-white flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6 2h12v6h-3v12h-6V8H6V2z"/>
                            </svg>
                            <div class="flex flex-col flex-1 min-w-0">
                                <label class="text-white text-xs lg:text-sm font-semibold mb-1">Aktivitas</label>
                                <div class="relative">
                                    <button type="button" class="w-full bg-transparent text-white text-left text-sm lg:text-base font-medium focus:outline-none flex items-center justify-between" onclick="toggleDropdown('sport-dropdown')">
                                        <span id="sport-selected" class="truncate">Pilih Aktivitas</span>
                                        <svg class="w-4 h-4 ml-2 transition-transform duration-200 flex-shrink-0" id="sport-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <input type="hidden" name="sport" id="sport-input" value="{{ request('sport') }}">
                                    <div id="sport-dropdown" class="hidden absolute top-full left-0 mt-2 w-56 lg:w-64 bg-white rounded-lg shadow-xl z-50 overflow-hidden">
                                        <div class="py-2 max-h-64 overflow-y-auto">
                                            <a href="#" class="dropdown-item block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOption('sport', '', 'Pilih Aktivitas')">Pilih Aktivitas</a>
                                            <a href="#" class="dropdown-item block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOption('sport', 'Futsal', 'Futsal')">⚽ Futsal</a>
                                            <a href="#" class="dropdown-item block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOption('sport', 'Basketball', 'Basketball')">🏀 Basketball</a>
                                            <a href="#" class="dropdown-item block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOption('sport', 'Badminton', 'Badminton')">🏸 Badminton</a>
                                            <a href="#" class="dropdown-item block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOption('sport', 'Voli', 'Voli')">🏐 Voli</a>
                                            <a href="#" class="dropdown-item block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOption('sport', 'Tennis', 'Tennis')">🎾 Tennis</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="h-12 w-px bg-white bg-opacity-30 hidden lg:block"></div>

                        <!-- Lokasi -->
                        <div class="flex items-center gap-3 flex-1 relative group">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-white flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                            <div class="flex flex-col flex-1 min-w-0">
                                <label class="text-white text-xs lg:text-sm font-semibold mb-1">Lokasi</label>
                                <div class="relative">
                                    <button type="button" class="w-full bg-transparent text-white text-left text-sm lg:text-base font-medium focus:outline-none flex items-center justify-between" onclick="toggleDropdown('location-dropdown')">
                                        <span id="location-selected" class="truncate">Pilih Kota</span>
                                        <svg class="w-4 h-4 ml-2 transition-transform duration-200 flex-shrink-0" id="location-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <input type="hidden" name="location" id="location-input" value="{{ request('location') }}">
                                    <div id="location-dropdown" class="hidden absolute top-full left-0 mt-2 w-56 lg:w-64 bg-white rounded-lg shadow-xl z-50 overflow-hidden">
                                        <div class="py-2 max-h-64 overflow-y-auto">
                                            <a href="#" class="dropdown-item block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOption('location', '', 'Pilih Kota')">Pilih Kota</a>
                                            <a href="#" class="dropdown-item block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOption('location', 'Jakarta Selatan', 'Jakarta Selatan')">📍 Jakarta Selatan</a>
                                            <a href="#" class="dropdown-item block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOption('location', 'Jakarta Pusat', 'Jakarta Pusat')">📍 Jakarta Pusat</a>
                                            <a href="#" class="dropdown-item block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOption('location', 'Jakarta Barat', 'Jakarta Barat')">📍 Jakarta Barat</a>
                                            <a href="#" class="dropdown-item block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOption('location', 'Jakarta Timur', 'Jakarta Timur')">📍 Jakarta Timur</a>
                                            <a href="#" class="dropdown-item block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOption('location', 'Jakarta Utara', 'Jakarta Utara')">📍 Jakarta Utara</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="h-12 w-px bg-white bg-opacity-30 hidden lg:block"></div>

                        <!-- Cabang Olahraga -->
                        <div class="flex items-center gap-3 flex-1 relative group">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-white flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                            </svg>
                            <div class="flex flex-col flex-1 min-w-0">
                                <label class="text-white text-xs lg:text-sm font-semibold mb-1">Cabang Olahraga</label>
                                <div class="relative">
                                    <button type="button" class="w-full bg-transparent text-white text-left text-sm lg:text-base font-medium focus:outline-none flex items-center justify-between" onclick="toggleDropdown('branch-dropdown')">
                                        <span id="branch-selected" class="truncate">Pilih Cabang</span>
                                        <svg class="w-4 h-4 ml-2 transition-transform duration-200 flex-shrink-0" id="branch-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <input type="hidden" name="branch" id="branch-input" value="{{ request('branch') }}">
                                    <div id="branch-dropdown" class="hidden absolute top-full left-0 mt-2 w-56 lg:w-64 bg-white rounded-lg shadow-xl z-50 overflow-hidden">
                                        <div class="py-2">
                                            <a href="#" class="dropdown-item block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOption('branch', '', 'Pilih Cabang')">Pilih Cabang Olahraga</a>
                                            <a href="#" class="dropdown-item block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOption('branch', 'Indoor', 'Indoor')">🏠 Indoor</a>
                                            <a href="#" class="dropdown-item block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOption('branch', 'Outdoor', 'Outdoor')">🌳 Outdoor</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Search Button -->
                        <button type="submit" class="bg-white text-blue-700 px-6 lg:px-8 py-3 rounded-lg text-sm lg:text-base font-semibold hover:bg-gray-100 transition flex items-center gap-2 shadow-md hover:shadow-lg flex-shrink-0">
                            Temukan
                            <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Mobile Vertical Layout -->
                    <div class="md:hidden space-y-4">
                        <!-- Aktivitas -->
                        <div class="relative">
                            <label class="text-white text-sm font-semibold mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6 2h12v6h-3v12h-6V8H6V2z"/>
                                </svg>
                                Aktivitas
                            </label>
                            <button type="button" class="w-full bg-white bg-opacity-20 backdrop-blur-sm text-white px-4 py-3 rounded-lg text-left font-medium focus:outline-none flex items-center justify-between border border-white border-opacity-30" onclick="toggleDropdown('sport-dropdown-mobile')">
                                <span id="sport-selected-mobile">Pilih Aktivitas</span>
                                <svg class="w-5 h-5 transition-transform duration-200" id="sport-icon-mobile" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <input type="hidden" id="sport-input-mobile" value="{{ request('sport') }}">
                            <div id="sport-dropdown-mobile" class="hidden absolute top-full left-0 mt-2 w-full bg-white rounded-lg shadow-xl z-50 overflow-hidden">
                                <div class="py-2 max-h-60 overflow-y-auto">
                                    <a href="#" class="dropdown-item block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOptionMobile('sport', '', 'Pilih Aktivitas')">Pilih Aktivitas</a>
                                    <a href="#" class="dropdown-item block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOptionMobile('sport', 'Futsal', 'Futsal')">⚽ Futsal</a>
                                    <a href="#" class="dropdown-item block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOptionMobile('sport', 'Basketball', 'Basketball')">🏀 Basketball</a>
                                    <a href="#" class="dropdown-item block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOptionMobile('sport', 'Badminton', 'Badminton')">🏸 Badminton</a>
                                    <a href="#" class="dropdown-item block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOptionMobile('sport', 'Voli', 'Voli')">🏐 Voli</a>
                                    <a href="#" class="dropdown-item block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOptionMobile('sport', 'Tennis', 'Tennis')">🎾 Tennis</a>
                                </div>
                            </div>
                        </div>

                        <!-- Lokasi -->
                        <div class="relative">
                            <label class="text-white text-sm font-semibold mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                </svg>
                                Lokasi
                            </label>
                            <button type="button" class="w-full bg-white bg-opacity-20 backdrop-blur-sm text-white px-4 py-3 rounded-lg text-left font-medium focus:outline-none flex items-center justify-between border border-white border-opacity-30" onclick="toggleDropdown('location-dropdown-mobile')">
                                <span id="location-selected-mobile">Pilih Kota</span>
                                <svg class="w-5 h-5 transition-transform duration-200" id="location-icon-mobile" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <input type="hidden" id="location-input-mobile" value="{{ request('location') }}">
                            <div id="location-dropdown-mobile" class="hidden absolute top-full left-0 mt-2 w-full bg-white rounded-lg shadow-xl z-50 overflow-hidden">
                                <div class="py-2 max-h-60 overflow-y-auto">
                                    <a href="#" class="dropdown-item block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOptionMobile('location', '', 'Pilih Kota')">Pilih Kota</a>
                                    <a href="#" class="dropdown-item block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOptionMobile('location', 'Jakarta Selatan', 'Jakarta Selatan')">📍 Jakarta Selatan</a>
                                    <a href="#" class="dropdown-item block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOptionMobile('location', 'Jakarta Pusat', 'Jakarta Pusat')">📍 Jakarta Pusat</a>
                                    <a href="#" class="dropdown-item block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOptionMobile('location', 'Jakarta Barat', 'Jakarta Barat')">📍 Jakarta Barat</a>
                                    <a href="#" class="dropdown-item block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOptionMobile('location', 'Jakarta Timur', 'Jakarta Timur')">📍 Jakarta Timur</a>
                                    <a href="#" class="dropdown-item block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOptionMobile('location', 'Jakarta Utara', 'Jakarta Utara')">📍 Jakarta Utara</a>
                                </div>
                            </div>
                        </div>

                        <!-- Cabang Olahraga -->
                        <div class="relative">
                            <label class="text-white text-sm font-semibold mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                                </svg>
                                Cabang Olahraga
                            </label>
                            <button type="button" class="w-full bg-white bg-opacity-20 backdrop-blur-sm text-white px-4 py-3 rounded-lg text-left font-medium focus:outline-none flex items-center justify-between border border-white border-opacity-30" onclick="toggleDropdown('branch-dropdown-mobile')">
                                <span id="branch-selected-mobile">Pilih Cabang Olahraga</span>
                                <svg class="w-5 h-5 transition-transform duration-200" id="branch-icon-mobile" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <input type="hidden" id="branch-input-mobile" value="{{ request('branch') }}">
                            <div id="branch-dropdown-mobile" class="hidden absolute top-full left-0 mt-2 w-full bg-white rounded-lg shadow-xl z-50 overflow-hidden">
                                <div class="py-2">
                                    <a href="#" class="dropdown-item block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOptionMobile('branch', '', 'Pilih Cabang Olahraga')">Pilih Cabang Olahraga</a>
                                    <a href="#" class="dropdown-item block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOptionMobile('branch', 'Indoor', 'Indoor')">🏠 Indoor</a>
                                    <a href="#" class="dropdown-item block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition" onclick="selectOptionMobile('branch', 'Outdoor', 'Outdoor')">🌳 Outdoor</a>
                                </div>
                            </div>
                        </div>

                        <!-- Search Button -->
                        <button type="submit" class="w-full bg-white text-blue-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                            Temukan
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <script>
            // Desktop/Tablet dropdown toggle
            function toggleDropdown(dropdownId) {
                const dropdown = document.getElementById(dropdownId);
                const icon = document.getElementById(dropdownId.replace('-dropdown', '-icon'));
                
                // Close all other dropdowns
                document.querySelectorAll('[id$="-dropdown"]').forEach(d => {
                    if (d.id !== dropdownId) {
                        d.classList.add('hidden');
                        const otherIcon = document.getElementById(d.id.replace('-dropdown', '-icon'));
                        if (otherIcon) otherIcon.style.transform = 'rotate(0deg)';
                    }
                });
                
                // Toggle current dropdown
                dropdown.classList.toggle('hidden');
                if (icon) {
                    icon.style.transform = dropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
                }
            }

            // Desktop/Tablet option select
            function selectOption(type, value, label) {
                event.preventDefault();
                document.getElementById(type + '-selected').textContent = label;
                document.getElementById(type + '-input').value = value;
                toggleDropdown(type + '-dropdown');
                // sinkronkan ke input mobile agar label mobile ikut berubah
                const mobileInput = document.getElementById(type + '-input-mobile');
                if (mobileInput) mobileInput.value = value;
                const mobileLabel = document.getElementById(type + '-selected-mobile');
                if (mobileLabel) mobileLabel.textContent = label;
            }

            // Mobile option select
            function selectOptionMobile(type, value, label) {
                event.preventDefault();
                document.getElementById(type + '-selected-mobile').textContent = label;
                document.getElementById(type + '-input-mobile').value = value;
                // tulis juga ke input utama (yang memiliki name=...)
                const mainInput = document.getElementById(type + '-input');
                if (mainInput) mainInput.value = value;
                toggleDropdown(type + '-dropdown-mobile');
            }

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('button') && !event.target.closest('[id$="-dropdown"]')) {
                    document.querySelectorAll('[id$="-dropdown"]').forEach(dropdown => {
                        dropdown.classList.add('hidden');
                        const icon = document.getElementById(dropdown.id.replace('-dropdown', '-icon'));
                        if (icon) icon.style.transform = 'rotate(0deg)';
                    });
                }
            });

            // Initialize selected values from request on page load
            window.addEventListener('DOMContentLoaded', function() {
                // Desktop/Tablet initialization
                const sportValue = document.getElementById('sport-input').value;
                const locationValue = document.getElementById('location-input').value;
                const branchValue = document.getElementById('branch-input').value;
                
                if (sportValue) {
                    const sportLabel = document.querySelector(`[onclick*="selectOption('sport', '${sportValue}'"]`)?.textContent.trim();
                    if (sportLabel) document.getElementById('sport-selected').textContent = sportLabel;
                }
                
                if (locationValue) {
                    const locationLabel = document.querySelector(`[onclick*="selectOption('location', '${locationValue}'"]`)?.textContent.trim();
                    if (locationLabel) document.getElementById('location-selected').textContent = locationLabel;
                }
                
                if (branchValue) {
                    const branchLabel = document.querySelector(`[onclick*="selectOption('branch', '${branchValue}'"]`)?.textContent.trim();
                    if (branchLabel) document.getElementById('branch-selected').textContent = branchLabel;
                }
                
                // Mobile initialization
                const sportValueMobile = document.getElementById('sport-input-mobile')?.value;
                const locationValueMobile = document.getElementById('location-input-mobile')?.value;
                const branchValueMobile = document.getElementById('branch-input-mobile')?.value;
                
                if (sportValueMobile) {
                    const sportLabelMobile = document.querySelector(`[onclick*="selectOptionMobile('sport', '${sportValueMobile}'"]`)?.textContent.trim();
                    if (sportLabelMobile) document.getElementById('sport-selected-mobile').textContent = sportLabelMobile;
                }
                
                if (locationValueMobile) {
                    const locationLabelMobile = document.querySelector(`[onclick*="selectOptionMobile('location', '${locationValueMobile}'"]`)?.textContent.trim();
                    if (locationLabelMobile) document.getElementById('location-selected-mobile').textContent = locationLabelMobile;
                }
                
                if (branchValueMobile) {
                    const branchLabelMobile = document.querySelector(`[onclick*="selectOptionMobile('branch', '${branchValueMobile}'"]`)?.textContent.trim();
                    if (branchLabelMobile) document.getElementById('branch-selected-mobile').textContent = branchLabelMobile;
                }
            });
            </script>

                <!-- Venues Grid -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($venues as $venue)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition group relative cursor-pointer" onclick="window.location='{{ route('venues.booking', $venue) }}'">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $venue->image_url }}" alt="{{ $venue->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
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
                                <span class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg select-none">
                                    Lihat & Book
                                </span>
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