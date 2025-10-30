<!-- Navigation -->
<nav class="fixed w-full top-0 z-50 bg-white shadow-sm" x-data="{ isOpen: false, scrolled: false }" 
     @scroll.window="scrolled = window.pageYOffset > 20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <div class="w-10 h-10 gradient-blue rounded-lg flex items-center justify-center mr-3">
                        <span class="text-white font-bold text-xl">F</span>
                    </div>
                    <span class="text-2xl font-bold text-gray-900">FitRent</span>
                </a>
            </div>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Home</a>
                <a href="{{ route('venues.index') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Lapangan</a>
                <a href="{{ route('slots.index') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Open Slots</a>
            </div>
            
            <!-- Auth Buttons -->
            <div class="hidden md:flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="px-5 py-2.5 text-blue-600 hover:text-blue-700 font-medium transition">Login</a>
                    <a href="{{ route('register') }}" class="px-6 py-2.5 gradient-blue text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">Daftar</a>
                @else
                    <!-- User dropdown -->
                    <div class="ml-3 relative" x-data="{ open: false }">
                        <div>
                            <button @click="open = !open" class="bg-white flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <span class="sr-only">Open user menu</span>
                                <div class="h-8 w-8 rounded-full gradient-blue flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                            </button>
                        </div>
                        <div x-show="open" @click.away="open = false" x-transition class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <div class="px-4 py-2 text-sm text-gray-700 border-b">
                                <div class="font-medium">{{ auth()->user()->name }}</div>
                                <div class="text-gray-500">{{ auth()->user()->email }}</div>
                            </div>
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                            <a href="{{ route('bookings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Bookings</a>
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
            
            <!-- Mobile Menu Button -->
            <button @click="isOpen = !isOpen" class="md:hidden text-gray-700">
                <svg x-show="!isOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg x-show="isOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div x-show="isOpen" x-transition class="md:hidden bg-white border-t">
        <div class="px-4 pt-2 pb-3 space-y-1">
            @if(auth()->check())
                <!-- User Profile Section -->
                <div class="px-3 py-3 bg-blue-50 rounded-lg mb-3">
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full gradient-blue flex items-center justify-center mr-3">
                            <span class="text-white text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">{{ auth()->user()->name }}</div>
                            <div class="text-sm text-gray-500">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                </div>
            @endif
            
            <a href="{{ route('home') }}" class="block px-3 py-3 text-gray-700 hover:bg-blue-50 rounded-lg font-medium">Home</a>
            <a href="{{ route('venues.index') }}" class="block px-3 py-3 text-gray-700 hover:bg-blue-50 rounded-lg font-medium">Lapangan</a>
            <a href="{{ route('slots.index') }}" class="block px-3 py-3 text-gray-700 hover:bg-blue-50 rounded-lg font-medium">Open Slots</a>
            @if(auth()->check())
                <a href="{{ route('dashboard') }}" class="block px-3 py-3 text-gray-700 hover:bg-blue-50 rounded-lg font-medium">Dashboard</a>
                <a href="{{ route('bookings.index') }}" class="block px-3 py-3 text-gray-700 hover:bg-blue-50 rounded-lg font-medium">My Bookings</a>
            @endif
            @if(!auth()->check())
                <a href="{{ route('login') }}" class="block px-3 py-3 text-blue-600 hover:bg-blue-50 rounded-lg font-medium">Login</a>
                <a href="{{ route('register') }}" class="block px-3 py-3 gradient-blue text-white rounded-lg font-medium text-center">Daftar</a>
            @else
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-3 text-red-600 hover:bg-red-50 rounded-lg font-medium">Logout</button>
                </form>
            @endif
        </div>
    </div>
</nav>
