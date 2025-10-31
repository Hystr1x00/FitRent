<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FitRent Superadmin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
    <script>
        tailwind.config = { theme: { extend: { colors: { primary: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a' } } } } }
    </script>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
            <div class="flex flex-col h-full">
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
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <a href="{{ route('superadmin.users.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('superadmin.users.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-primary-50 hover:text-primary-600' }}">
                        <i class="fas fa-users-cog text-lg w-5"></i>
                        <span class="font-medium">Kelola Pengguna</span>
                    </a>
                </nav>
                <div class="px-4 py-4 border-t border-gray-200">
                    <div class="relative">
                        @php($su = auth()->user())
                        <button id="suProfileBtn" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-50 text-left">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($su?->name ?? 'Superadmin') }}&background=3b82f6&color=fff" class="w-10 h-10 rounded-full" alt="{{ $su?->name ?? 'Superadmin' }}">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">{{ $su?->name ?? 'Superadmin' }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $su?->email ?? '' }}</p>
                            </div>
                            <i class="fas fa-chevron-up text-gray-400" id="suProfileCaret"></i>
                        </button>
                        <div id="suProfileMenu" class="hidden absolute left-2 right-2 bottom-14 bg-white shadow-lg border border-gray-200 rounded-lg overflow-hidden z-50">
                            <div class="px-4 py-3 text-sm">
                                <div class="font-medium text-gray-900 truncate">{{ $su?->name ?? 'Superadmin' }}</div>
                                <div class="text-gray-600 truncate">{{ $su?->email ?? '' }}</div>
                            </div>
                            <div class="border-t">
                                <form method="POST" action="{{ route('logout') }}" id="logoutFormSuperadmin">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>
        <main class="flex-1 overflow-y-auto">
            <header class="bg-white shadow-sm sticky top-0 z-30">
                <div class="flex items-center justify-between px-4 lg:px-8 py-4">
                    <div class="flex items-center space-x-4">
                        <button id="menuToggle" class="lg:hidden text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div>
                            <h1 class="text-xl lg:text-2xl font-bold text-gray-800">@yield('title', 'Superadmin')</h1>
                            <p class="text-sm text-gray-500 hidden sm:block">@yield('subtitle')</p>
                        </div>
                    </div>
                </div>
            </header>
            <div class="p-4 lg:p-8">
                @yield('content')
            </div>
        </main>
    </div>
    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const closeSidebar = document.getElementById('closeSidebar');
        function openSidebar() { sidebar.classList.remove('-translate-x-full'); overlay.classList.remove('hidden'); }
        function closeSidebarFunc() { sidebar.classList.add('-translate-x-full'); overlay.classList.add('hidden'); }
        if (menuToggle) menuToggle.addEventListener('click', openSidebar);
        if (closeSidebar) closeSidebar.addEventListener('click', closeSidebarFunc);
        if (overlay) overlay.addEventListener('click', closeSidebarFunc);
        window.addEventListener('resize', function() { if (window.innerWidth >= 1024) { closeSidebarFunc(); } });

        // Superadmin profile dropdown
        const suBtn = document.getElementById('suProfileBtn');
        const suMenu = document.getElementById('suProfileMenu');
        const suCaret = document.getElementById('suProfileCaret');
        function toggleSu() {
            if (!suMenu) return;
            suMenu.classList.toggle('hidden');
            if (suCaret) suCaret.classList.toggle('rotate-180');
        }
        if (suBtn) suBtn.addEventListener('click', function(e){ e.stopPropagation(); toggleSu(); });
        document.addEventListener('click', function(e){
            if (!suMenu || !suBtn) return;
            if (!suMenu.classList.contains('hidden')) {
                const inside = suBtn.contains(e.target) || suMenu.contains(e.target);
                if (!inside) { suMenu.classList.add('hidden'); if (suCaret) suCaret.classList.remove('rotate-180'); }
            }
        });

        // Refresh CSRF token before logout to prevent 419 errors
        const logoutFormSuperadmin = document.getElementById('logoutFormSuperadmin');
        if (logoutFormSuperadmin) {
            logoutFormSuperadmin.addEventListener('submit', function(e) {
                const metaToken = document.querySelector('meta[name="csrf-token"]');
                if (metaToken) {
                    const tokenInput = logoutFormSuperadmin.querySelector('input[name="_token"]');
                    if (tokenInput) {
                        tokenInput.value = metaToken.getAttribute('content');
                    }
                }
            });
        }
    </script>
    @stack('scripts')
</body>
</html>


