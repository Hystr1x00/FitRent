<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitRent Admin</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cdefs%3E%3ClinearGradient id='grad' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' style='stop-color:%233b82f6'/%3E%3Cstop offset='100%25' style='stop-color:%231e40af'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect width='100' height='100' rx='20' fill='url(%23grad)'/%3E%3Ctext x='50' y='70' font-family='system-ui,-apple-system,sans-serif' font-size='55' font-weight='bold' text-anchor='middle' fill='white'%3EF%3C/text%3E%3C/svg%3E">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-between px-6 py-5 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-xl">F</span>
                        </div>
                        <span class="text-xl font-bold text-gray-800">FitRent</span>
                    </div>
                    <button id="closeSidebar" class="lg:hidden text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-primary-50 hover:text-primary-600' }}">
                        <i class="fas fa-home text-lg w-5"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.fields.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.fields.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-primary-50 hover:text-primary-600' }}">
                        <i class="fas fa-layer-group text-lg w-5"></i>
                        <span class="font-medium">Kelola Lapangan</span>
                    </a>
                    <a href="{{ route('admin.bookings.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.bookings.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-primary-50 hover:text-primary-600' }}">
                        <i class="fas fa-calendar-check text-lg w-5"></i>
                        <span class="font-medium">Booking</span>
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.reports.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-primary-50 hover:text-primary-600' }}">
                        <i class="fas fa-chart-line text-lg w-5"></i>
                        <span class="font-medium">Laporan</span>
                    </a>
                    <a href="{{ route('admin.customers.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.customers.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-primary-50 hover:text-primary-600' }}">
                        <i class="fas fa-users text-lg w-5"></i>
                        <span class="font-medium">Pelanggan</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-700 rounded-lg hover:bg-primary-50 hover:text-primary-600 transition">
                        <i class="fas fa-cog text-lg w-5"></i>
                        <span class="font-medium">Pengaturan</span>
                    </a>
                </nav>

                <!-- User Profile -->
                <div class="px-4 py-4 border-t border-gray-200">
                    <div class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-50 cursor-pointer">
                        <img src="https://ui-avatars.com/api/?name=Admin+FitRent&background=3b82f6&color=fff" class="w-10 h-10 rounded-full" alt="Admin">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800 truncate">Admin FitRent</p>
                            <p class="text-xs text-gray-500 truncate">admin@fitrent.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Overlay for mobile -->
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Header -->
            <header class="bg-white shadow-sm sticky top-0 z-30">
                <div class="flex items-center justify-between px-4 lg:px-8 py-4">
                    <div class="flex items-center space-x-4">
                        <button id="menuToggle" class="lg:hidden text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div>
                            <h1 class="text-xl lg:text-2xl font-bold text-gray-800">@yield('title', 'Admin')</h1>
                            <p class="text-sm text-gray-500 hidden sm:block">@yield('subtitle')</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="relative hidden md:block">
                            <input type="text" placeholder="Cari..." class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-bell text-xl"></i>
                        </button>
                    </div>
                </div>
            </header>

            <div class="p-4 lg:p-8">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Mobile Menu Toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const closeSidebar = document.getElementById('closeSidebar');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }

        function closeSidebarFunc() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        if (menuToggle) menuToggle.addEventListener('click', openSidebar);
        if (closeSidebar) closeSidebar.addEventListener('click', closeSidebarFunc);
        if (overlay) overlay.addEventListener('click', closeSidebarFunc);

        // Close sidebar on window resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                closeSidebarFunc();
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>


