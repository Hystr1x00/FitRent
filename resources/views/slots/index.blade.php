<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Available Slots') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <div class="pt-12 pb-16 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Open Slots</h1>
                    <p class="text-gray-600">Gabung dengan pemain lain dan hemat biaya!</p>
                </div>

                <!-- Filters - Responsive Style -->
                <div class="bg-gradient-to-r from-blue-700 to-blue-600 p-4 md:p-6 rounded-xl shadow-lg mb-8">
                    <form action="{{ route('slots.index') }}" method="GET">
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

                            <!-- Tanggal - Custom Date Picker -->
                            <div class="flex items-center gap-3 flex-1 relative group">
                                <svg class="w-5 h-5 lg:w-6 lg:h-6 text-white flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div class="flex flex-col flex-1 min-w-0">
                                    <label class="text-white text-xs lg:text-sm font-semibold mb-1">Tanggal</label>
                                    <div class="relative">
                                        <button type="button" class="w-full bg-transparent text-white text-left text-sm lg:text-base font-medium focus:outline-none flex items-center justify-between" onclick="toggleDatePicker()">
                                            <span id="date-display" class="truncate">Pilih Tanggal</span>
                                            <svg class="w-4 h-4 ml-2 transition-transform duration-200 flex-shrink-0" id="date-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </button>
                                        <input type="hidden" name="date" id="date-input" value="{{ request('date') }}">
                                        
                                        <!-- Custom Date Picker -->
                                        <div id="date-picker" class="hidden absolute top-full left-0 mt-2 w-80 bg-white rounded-xl shadow-2xl z-50 overflow-hidden">
                                            <div class="p-4">
                                                <!-- Month/Year Header -->
                                                <div class="flex items-center justify-between mb-4">
                                                    <button type="button" onclick="changeMonth(-1)" class="p-2 hover:bg-blue-50 rounded-lg transition">
                                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                                        </svg>
                                                    </button>
                                                    <div class="text-center">
                                                        <div class="text-lg font-bold text-gray-800" id="current-month"></div>
                                                        <div class="text-sm text-gray-500" id="current-year"></div>
                                                    </div>
                                                    <button type="button" onclick="changeMonth(1)" class="p-2 hover:bg-blue-50 rounded-lg transition">
                                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                                
                                                <!-- Days of Week -->
                                                <div class="grid grid-cols-7 gap-1 mb-2">
                                                    <div class="text-center text-xs font-semibold text-gray-500 py-2">Min</div>
                                                    <div class="text-center text-xs font-semibold text-gray-500 py-2">Sen</div>
                                                    <div class="text-center text-xs font-semibold text-gray-500 py-2">Sel</div>
                                                    <div class="text-center text-xs font-semibold text-gray-500 py-2">Rab</div>
                                                    <div class="text-center text-xs font-semibold text-gray-500 py-2">Kam</div>
                                                    <div class="text-center text-xs font-semibold text-gray-500 py-2">Jum</div>
                                                    <div class="text-center text-xs font-semibold text-gray-500 py-2">Sab</div>
                                                </div>
                                                
                                                <!-- Calendar Days -->
                                                <div id="calendar-days" class="grid grid-cols-7 gap-1"></div>

                                                <!-- Quick Actions -->
                                                <div class="mt-4 pt-3 border-t flex gap-2">
                                                    <button type="button" onclick="selectToday()" class="flex-1 px-3 py-2 text-sm bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition font-medium">
                                                        Hari Ini
                                                    </button>
                                                    <button type="button" onclick="clearDate()" class="flex-1 px-3 py-2 text-sm bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100 transition font-medium">
                                                        Reset
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Divider -->
                            <div class="h-12 w-px bg-white bg-opacity-30 hidden lg:block"></div>

                            <!-- Search -->
                            <div class="flex items-center gap-3 flex-1 relative group">
                                <svg class="w-5 h-5 lg:w-6 lg:h-6 text-white flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <div class="flex flex-col flex-1 min-w-0">
                                    <label class="text-white text-xs lg:text-sm font-semibold mb-1">Cari Slot</label>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari slot..." class="w-full bg-transparent text-white text-sm lg:text-base font-medium focus:outline-none border-b border-white border-opacity-50 focus:border-white transition placeholder-white placeholder-opacity-70">
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
                                <input type="hidden" name="sport" id="sport-input-mobile" value="{{ request('sport') }}">
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

                            <!-- Tanggal - Mobile Date Picker -->
                            <div class="relative">
                                <label class="text-white text-sm font-semibold mb-2 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Tanggal
                                </label>
                                <button type="button" class="w-full bg-white bg-opacity-20 backdrop-blur-sm text-white px-4 py-3 rounded-lg text-left font-medium focus:outline-none flex items-center justify-between border border-white border-opacity-30" onclick="toggleDatePickerMobile()">
                                    <span id="date-display-mobile">Pilih Tanggal</span>
                                    <svg class="w-5 h-5 transition-transform duration-200" id="date-icon-mobile" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <input type="hidden" name="date" id="date-input-mobile" value="{{ request('date') }}">
                                
                                <!-- Mobile Date Picker -->
                                <div id="date-picker-mobile" class="hidden absolute top-full left-0 mt-2 w-full bg-white rounded-xl shadow-2xl z-50 overflow-hidden">
                                    <div class="p-4">
                                        <!-- Month/Year Header -->
                                        <div class="flex items-center justify-between mb-4">
                                            <button type="button" onclick="changeMonthMobile(-1)" class="p-2 hover:bg-blue-50 rounded-lg transition">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                                </svg>
                                            </button>
                                            <div class="text-center">
                                                <div class="text-base font-bold text-gray-800" id="current-month-mobile"></div>
                                                <div class="text-xs text-gray-500" id="current-year-mobile"></div>
                                            </div>
                                            <button type="button" onclick="changeMonthMobile(1)" class="p-2 hover:bg-blue-50 rounded-lg transition">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </button>
                                        </div>
                                        
                                        <!-- Days of Week -->
                                        <div class="grid grid-cols-7 gap-1 mb-2">
                                            <div class="text-center text-xs font-semibold text-gray-500 py-1">Min</div>
                                            <div class="text-center text-xs font-semibold text-gray-500 py-1">Sen</div>
                                            <div class="text-center text-xs font-semibold text-gray-500 py-1">Sel</div>
                                            <div class="text-center text-xs font-semibold text-gray-500 py-1">Rab</div>
                                            <div class="text-center text-xs font-semibold text-gray-500 py-1">Kam</div>
                                            <div class="text-center text-xs font-semibold text-gray-500 py-1">Jum</div>
                                            <div class="text-center text-xs font-semibold text-gray-500 py-1">Sab</div>
                                        </div>
                                        
                                        <!-- Calendar Days -->
                                        <div id="calendar-days-mobile" class="grid grid-cols-7 gap-1"></div>

                                        <!-- Quick Actions -->
                                        <div class="mt-3 pt-3 border-t flex gap-2">
                                            <button type="button" onclick="selectTodayMobile()" class="flex-1 px-3 py-2 text-sm bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition font-medium">
                                                Hari Ini
                                            </button>
                                            <button type="button" onclick="clearDateMobile()" class="flex-1 px-3 py-2 text-sm bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100 transition font-medium">
                                                Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Search -->
                            <div class="relative">
                                <label class="text-white text-sm font-semibold mb-2 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    Cari Slot
                                </label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari slot..." class="w-full bg-white bg-opacity-20 backdrop-blur-sm text-white px-4 py-3 rounded-lg font-medium focus:outline-none border border-white border-opacity-30 placeholder-white placeholder-opacity-70">
                            </div>

                            <!-- Search Button -->
                            <button type="submit" class="w-full bg-white text-blue-700 py-3 rounded-lg font-semibold hover:bg-gray-100 transition flex items-center justify-center gap-2 shadow-md">
                                Temukan Slot
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <script>
                // Date Picker State
                let currentDate = new Date();
                let selectedDate = null;
                const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

                // Desktop Date Picker Functions
                function toggleDatePicker() {
                    const picker = document.getElementById('date-picker');
                    const icon = document.getElementById('date-icon');
                    
                    // Close other dropdowns
                    document.querySelectorAll('[id$="-dropdown"]').forEach(d => {
                        if (d.id !== 'date-picker') {
                            d.classList.add('hidden');
                        }
                    });
                    
                    picker.classList.toggle('hidden');
                    if (icon) {
                        icon.style.transform = picker.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
                    }
                    
                    if (!picker.classList.contains('hidden')) {
                        renderCalendar();
                    }
                }

                function renderCalendar() {
                    document.getElementById('current-month').textContent = monthNames[currentDate.getMonth()];
                    document.getElementById('current-year').textContent = currentDate.getFullYear();
                    
                    const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
                    const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
                    const prevLastDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 0);
                    
                    const firstDayIndex = firstDay.getDay();
                    const lastDayDate = lastDay.getDate();
                    const prevLastDayDate = prevLastDay.getDate();
                    
                    const calendarDays = document.getElementById('calendar-days');
                    calendarDays.innerHTML = '';
                    
                    // Previous month days
                    for (let i = firstDayIndex; i > 0; i--) {
                        const day = document.createElement('button');
                        day.type = 'button';
                        day.className = 'aspect-square flex items-center justify-center text-sm text-gray-300 hover:bg-gray-50 rounded-lg transition';
                        day.textContent = prevLastDayDate - i + 1;
                        calendarDays.appendChild(day);
                    }
                    
                    // Current month days
                    const today = new Date();
                    for (let i = 1; i <= lastDayDate; i++) {
                        const day = document.createElement('button');
                        day.type = 'button';
                        const dateStr = `${currentDate.getFullYear()}-${String(currentDate.getMonth() + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                        const isToday = i === today.getDate() && currentDate.getMonth() === today.getMonth() && currentDate.getFullYear() === today.getFullYear();
                        const isSelected = selectedDate && selectedDate === dateStr;
                        
                        day.className = `aspect-square flex items-center justify-center text-sm rounded-lg transition font-medium ${
                            isSelected ? 'bg-blue-600 text-white' : 
                            isToday ? 'bg-blue-50 text-blue-600 ring-2 ring-blue-600 ring-offset-2' : 
                            'text-gray-700 hover:bg-blue-50 hover:text-blue-600'
                        }`;
                        day.textContent = i;
                        day.onclick = () => selectDate(dateStr);
                        calendarDays.appendChild(day);
                    }
                    
                    // Next month days
                    const remainingDays = 42 - (firstDayIndex + lastDayDate);
                    for (let i = 1; i <= remainingDays; i++) {
                        const day = document.createElement('button');
                        day.type = 'button';
                        day.className = 'aspect-square flex items-center justify-center text-sm text-gray-300 hover:bg-gray-50 rounded-lg transition';
                        day.textContent = i;
                        calendarDays.appendChild(day);
                    }
                }

                function selectDate(dateStr) {
                    selectedDate = dateStr;
                    const date = new Date(dateStr);
                    const formatted = `${date.getDate()} ${monthNames[date.getMonth()]} ${date.getFullYear()}`;
                    
                    document.getElementById('date-display').textContent = formatted;
                    document.getElementById('date-input').value = dateStr;
                    
                    renderCalendar();
                    setTimeout(() => toggleDatePicker(), 100);
                }

                function changeMonth(delta) {
                    currentDate.setMonth(currentDate.getMonth() + delta);
                    renderCalendar();
                }

                function selectToday() {
                    const today = new Date();
                    const dateStr = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
                    selectDate(dateStr);
                }

                function clearDate() {
                    selectedDate = null;
                    document.getElementById('date-display').textContent = 'Pilih Tanggal';
                    document.getElementById('date-input').value = '';
                    renderCalendar();
                    toggleDatePicker();
                }

                // Mobile Date Picker Functions
                let currentDateMobile = new Date();
                let selectedDateMobile = null;

                function toggleDatePickerMobile() {
                    const picker = document.getElementById('date-picker-mobile');
                    const icon = document.getElementById('date-icon-mobile');
                    
                    picker.classList.toggle('hidden');
                    if (icon) {
                        icon.style.transform = picker.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
                    }
                    
                    if (!picker.classList.contains('hidden')) {
                        renderCalendarMobile();
                    }
                }

                function renderCalendarMobile() {
                    document.getElementById('current-month-mobile').textContent = monthNames[currentDateMobile.getMonth()];
                    document.getElementById('current-year-mobile').textContent = currentDateMobile.getFullYear();
                    
                    const firstDay = new Date(currentDateMobile.getFullYear(), currentDateMobile.getMonth(), 1);
                    const lastDay = new Date(currentDateMobile.getFullYear(), currentDateMobile.getMonth() + 1, 0);
                    const prevLastDay = new Date(currentDateMobile.getFullYear(), currentDateMobile.getMonth(), 0);
                    
                    const firstDayIndex = firstDay.getDay();
                    const lastDayDate = lastDay.getDate();
                    const prevLastDayDate = prevLastDay.getDate();
                    
                    const calendarDays = document.getElementById('calendar-days-mobile');
                    calendarDays.innerHTML = '';
                    
                    // Previous month days
                    for (let i = firstDayIndex; i > 0; i--) {
                        const day = document.createElement('button');
                        day.type = 'button';
                        day.className = 'aspect-square flex items-center justify-center text-xs text-gray-300 hover:bg-gray-50 rounded-lg transition';
                        day.textContent = prevLastDayDate - i + 1;
                        calendarDays.appendChild(day);
                    }
                    
                    // Current month days
                    const today = new Date();
                    for (let i = 1; i <= lastDayDate; i++) {
                        const day = document.createElement('button');
                        day.type = 'button';
                        const dateStr = `${currentDateMobile.getFullYear()}-${String(currentDateMobile.getMonth() + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                        const isToday = i === today.getDate() && currentDateMobile.getMonth() === today.getMonth() && currentDateMobile.getFullYear() === today.getFullYear();
                        const isSelected = selectedDateMobile && selectedDateMobile === dateStr;
                        
                        day.className = `aspect-square flex items-center justify-center text-xs rounded-lg transition font-medium ${
                            isSelected ? 'bg-blue-600 text-white' : 
                            isToday ? 'bg-blue-50 text-blue-600 ring-2 ring-blue-600 ring-offset-2' : 
                            'text-gray-700 hover:bg-blue-50 hover:text-blue-600'
                        }`;
                        day.textContent = i;
                        day.onclick = () => selectDateMobile(dateStr);
                        calendarDays.appendChild(day);
                    }
                    
                    // Next month days
                    const remainingDays = 42 - (firstDayIndex + lastDayDate);
                    for (let i = 1; i <= remainingDays; i++) {
                        const day = document.createElement('button');
                        day.type = 'button';
                        day.className = 'aspect-square flex items-center justify-center text-xs text-gray-300 hover:bg-gray-50 rounded-lg transition';
                        day.textContent = i;
                        calendarDays.appendChild(day);
                    }
                }

                function selectDateMobile(dateStr) {
                    selectedDateMobile = dateStr;
                    const date = new Date(dateStr);
                    const formatted = `${date.getDate()} ${monthNames[date.getMonth()]} ${date.getFullYear()}`;
                    
                    document.getElementById('date-display-mobile').textContent = formatted;
                    document.getElementById('date-input-mobile').value = dateStr;
                    
                    renderCalendarMobile();
                    setTimeout(() => toggleDatePickerMobile(), 100);
                }

                function changeMonthMobile(delta) {
                    currentDateMobile.setMonth(currentDateMobile.getMonth() + delta);
                    renderCalendarMobile();
                }

                function selectTodayMobile() {
                    const today = new Date();
                    const dateStr = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
                    selectDateMobile(dateStr);
                }

                function clearDateMobile() {
                    selectedDateMobile = null;
                    document.getElementById('date-display-mobile').textContent = 'Pilih Tanggal';
                    document.getElementById('date-input-mobile').value = '';
                    renderCalendarMobile();
                    toggleDatePickerMobile();
                }

                // Sport Dropdown Functions
                function toggleDropdown(dropdownId) {
                    const dropdown = document.getElementById(dropdownId);
                    const icon = document.getElementById(dropdownId.replace('-dropdown', '-icon'));
                    
                    // Close all other dropdowns and date picker
                    document.querySelectorAll('[id$="-dropdown"]').forEach(d => {
                        if (d.id !== dropdownId) {
                            d.classList.add('hidden');
                            const otherIcon = document.getElementById(d.id.replace('-dropdown', '-icon'));
                            if (otherIcon) otherIcon.style.transform = 'rotate(0deg)';
                        }
                    });
                    
                    const datePicker = document.getElementById('date-picker');
                    if (datePicker) {
                        datePicker.classList.add('hidden');
                        const dateIcon = document.getElementById('date-icon');
                        if (dateIcon) dateIcon.style.transform = 'rotate(0deg)';
                    }
                    
                    // Toggle current dropdown
                    dropdown.classList.toggle('hidden');
                    if (icon) {
                        icon.style.transform = dropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
                    }
                }

                function selectOption(type, value, label) {
                    event.preventDefault();
                    document.getElementById(type + '-selected').textContent = label;
                    document.getElementById(type + '-input').value = value;
                    toggleDropdown(type + '-dropdown');
                }

                function selectOptionMobile(type, value, label) {
                    event.preventDefault();
                    document.getElementById(type + '-selected-mobile').textContent = label;
                    document.getElementById(type + '-input-mobile').value = value;
                    toggleDropdown(type + '-dropdown-mobile');
                }

                // Close dropdowns when clicking outside
                document.addEventListener('click', function(event) {
                    if (!event.target.closest('button') && !event.target.closest('[id$="-dropdown"]') && !event.target.closest('#date-picker') && !event.target.closest('#date-picker-mobile')) {
                        document.querySelectorAll('[id$="-dropdown"]').forEach(dropdown => {
                            dropdown.classList.add('hidden');
                            const icon = document.getElementById(dropdown.id.replace('-dropdown', '-icon'));
                            if (icon) icon.style.transform = 'rotate(0deg)';
                        });
                        
                        const datePicker = document.getElementById('date-picker');
                        const datePickerMobile = document.getElementById('date-picker-mobile');
                        if (datePicker) {
                            datePicker.classList.add('hidden');
                            const dateIcon = document.getElementById('date-icon');
                            if (dateIcon) dateIcon.style.transform = 'rotate(0deg)';
                        }
                        if (datePickerMobile) {
                            datePickerMobile.classList.add('hidden');
                            const dateIconMobile = document.getElementById('date-icon-mobile');
                            if (dateIconMobile) dateIconMobile.style.transform = 'rotate(0deg)';
                        }
                    }
                });

                // Initialize selected values
                document.addEventListener('DOMContentLoaded', function() {
                    // Sport initialization
                    const sportValue = '{{ request("sport") }}';
                    if (sportValue) {
                        const sportLabels = {
                            'Futsal': 'Futsal',
                            'Basketball': 'Basketball', 
                            'Badminton': 'Badminton',
                            'Voli': 'Voli',
                            'Tennis': 'Tennis'
                        };
                        const sportLabel = sportLabels[sportValue] || 'Pilih Aktivitas';
                        const sportSelectedEl = document.getElementById('sport-selected');
                        const sportSelectedMobileEl = document.getElementById('sport-selected-mobile');
                        if (sportSelectedEl) sportSelectedEl.textContent = sportLabel;
                        if (sportSelectedMobileEl) sportSelectedMobileEl.textContent = sportLabel;
                    }

                    // Date initialization
                    const dateValue = '{{ request("date") }}';
                    if (dateValue) {
                        selectedDate = dateValue;
                        selectedDateMobile = dateValue;
                        const date = new Date(dateValue);
                        const formatted = `${date.getDate()} ${monthNames[date.getMonth()]} ${date.getFullYear()}`;
                        
                        const dateDisplayEl = document.getElementById('date-display');
                        const dateDisplayMobileEl = document.getElementById('date-display-mobile');
                        if (dateDisplayEl) dateDisplayEl.textContent = formatted;
                        if (dateDisplayMobileEl) dateDisplayMobileEl.textContent = formatted;
                    }
                });
                </script>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($slots as $slot)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100">
                        <!-- Image Header -->
                        <div class="relative h-48 bg-gradient-to-br from-blue-600 to-blue-800">
                            @if($slot->venue->image)
                                <img src="{{ asset('storage/' . $slot->venue->image) }}" alt="{{ $slot->venue->name }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            @endif
                            <div class="absolute top-4 left-4 right-4 flex items-center justify-between">
                                <span class="px-3 py-1.5 bg-white/90 backdrop-blur-sm text-blue-600 rounded-full text-sm font-bold shadow-lg">
                                    🏆 {{ $slot->venue->sport }}
                                </span>
                                <span class="px-3 py-1.5 bg-green-500/90 backdrop-blur-sm text-white rounded-full text-sm font-bold shadow-lg">
                                    {{ $slot->max_participants - $slot->current_participants }} slot
                                </span>
                            </div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <h3 class="text-2xl font-bold text-white mb-1">{{ $slot->venue->name }}</h3>
                                @if($slot->court_name)
                                    <p class="text-white/90 text-sm">📍 {{ $slot->court_name }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <!-- Location -->
                            <div class="flex items-start text-gray-600 mb-4 pb-4 border-b">
                                <svg class="w-5 h-5 mr-2 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                </svg>
                                <span class="text-sm">{{ $slot->venue->location }}</span>
                            </div>
                            
                            <!-- Details -->
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="font-medium">{{ $slot->date->format('d M Y') }}</span>
                                </div>
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="font-medium">{{ $slot->time }}</span>
                                </div>
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span class="font-medium">{{ $slot->current_participants }}/{{ $slot->max_participants }} peserta</span>
                                </div>
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="font-medium text-sm">Dibuat oleh: <span class="text-blue-600">{{ $slot->creator->name }}</span></span>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-4 mb-4 border border-blue-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-blue-600 font-medium mb-1">Biaya per orang</p>
                                        <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($slot->price_per_person, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500">+ Biaya Layanan</p>
                                        <p class="text-sm font-semibold text-gray-700">Rp 5.000</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Join Button -->
                            @auth
                                @if(auth()->id() === $slot->creator_id)
                                    <div class="w-full py-3 bg-gray-100 text-gray-600 rounded-xl text-center font-semibold text-sm border-2 border-gray-200">
                                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Slot Anda
                                    </div>
                                @elseif($slot->current_participants < $slot->max_participants)
                                    <form action="{{ route('slots.join', $slot) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full py-3 bg-gradient-to-r from-green-600 to-green-500 text-white rounded-xl hover:from-green-700 hover:to-green-600 transition font-bold text-lg shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Join Slot - Rp {{ number_format($slot->price_per_person + 5000, 0, ',', '.') }}
                                        </button>
                                    </form>
                                @else
                                    <div class="w-full py-3 bg-red-100 text-red-800 rounded-xl text-center font-bold border-2 border-red-200">
                                        ⛔ Slot Penuh
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="w-full py-3 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition font-bold text-center block shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                    Login untuk Join
                                </a>
                            @endauth
                        </div>
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

                <!-- Pagination -->
                @if($slots->hasPages())
                    <div class="mt-12">
                        {{ $slots->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>