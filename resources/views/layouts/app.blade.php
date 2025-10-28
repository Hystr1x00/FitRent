<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitRent - Platform Sewa Lapangan Olahraga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .gradient-blue { background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); }
        .hero-pattern { background-image: radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.1) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(30, 64, 175, 0.1) 0%, transparent 50%); }
    </style>
</head>
<body class="bg-white">
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
                    <a href="#" class="text-gray-700 hover:text-blue-600 font-medium transition">Tentang</a>
                </div>
                
                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="px-5 py-2.5 text-blue-600 hover:text-blue-700 font-medium transition">Login</a>
                    <a href="{{ route('register') }}" class="px-6 py-2.5 gradient-blue text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">Daftar</a>
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
                <a href="{{ route('home') }}" class="block px-3 py-3 text-gray-700 hover:bg-blue-50 rounded-lg font-medium">Home</a>
                <a href="{{ route('venues.index') }}" class="block px-3 py-3 text-gray-700 hover:bg-blue-50 rounded-lg font-medium">Lapangan</a>
                <a href="{{ route('slots.index') }}" class="block px-3 py-3 text-gray-700 hover:bg-blue-50 rounded-lg font-medium">Open Slots</a>
                <a href="#" class="block px-3 py-3 text-gray-700 hover:bg-blue-50 rounded-lg font-medium">Tentang</a>
                <a href="{{ route('login') }}" class="block px-3 py-3 text-blue-600 hover:bg-blue-50 rounded-lg font-medium">Login</a>
                <a href="{{ route('register') }}" class="block px-3 py-3 gradient-blue text-white rounded-lg font-medium text-center">Daftar</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 hero-pattern">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-block px-4 py-2 bg-blue-50 rounded-full mb-6">
                        <span class="text-blue-600 font-semibold text-sm">🏆 Platform Terpercaya #1</span>
                    </div>
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-900 leading-tight mb-6">
                        Booking Lapangan<br/>
                        <span class="gradient-blue bg-clip-text text-transparent">Olahraga Favoritmu</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Cari dan booking lapangan olahraga dengan mudah. Dari futsal, basket, badminton hingga tenis, semua ada di FitRent!
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" class="px-8 py-4 gradient-blue text-white rounded-xl font-semibold text-lg hover:shadow-xl hover:scale-105 transition-all text-center">
                            Mulai Booking
                        </a>
                        <a href="{{ route('venues.index') }}" class="px-8 py-4 bg-white border-2 border-blue-600 text-blue-600 rounded-xl font-semibold text-lg hover:bg-blue-50 transition-all text-center">
                            Lihat Lapangan
                        </a>
                    </div>
                    <div class="mt-12 flex items-center gap-8">
                        <div>
                            <div class="text-3xl font-bold text-gray-900">1000+</div>
                            <div class="text-gray-600">Lapangan</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-gray-900">50K+</div>
                            <div class="text-gray-600">Pengguna Aktif</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-gray-900">100K+</div>
                            <div class="text-gray-600">Booking</div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="relative z-10">
                        <img src="https://images.unsplash.com/photo-1551958219-acbc608c6377?w=600&h=600&fit=crop" 
                             alt="Hero" class="rounded-3xl shadow-2xl w-full">
                    </div>
                    <div class="absolute -bottom-8 -right-8 w-full h-full gradient-blue rounded-3xl opacity-20"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Kenapa Pilih FitRent?</h2>
                <p class="text-xl text-gray-600">Kemudahan dan kenyamanan dalam satu platform</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all">
                    <div class="w-16 h-16 gradient-blue rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Booking Instan</h3>
                    <p class="text-gray-600 leading-relaxed">Booking lapangan dalam hitungan detik tanpa ribet. Pilih, bayar, dan mainkan!</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all">
                    <div class="w-16 h-16 gradient-blue rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Terpercaya</h3>
                    <p class="text-gray-600 leading-relaxed">Semua lapangan telah terverifikasi dan review asli dari pengguna.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all">
                    <div class="w-16 h-16 gradient-blue rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Harga Terbaik</h3>
                    <p class="text-gray-600 leading-relaxed">Dapatkan harga terbaik dengan berbagai promo dan diskon menarik.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sports Categories -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Olahraga Favorit</h2>
                <p class="text-xl text-gray-600">Berbagai jenis lapangan olahraga tersedia untuk Anda</p>
            </div>
            <div class="grid md:grid-cols-4 gap-6">
                <div class="group cursor-pointer">
                    <div class="relative overflow-hidden rounded-2xl shadow-lg">
                        <img src="https://images.unsplash.com/photo-1459865264687-595d652de67e?w=400&h=300&fit=crop" 
                             alt="Futsal" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <h3 class="text-2xl font-bold text-white mb-2">Futsal</h3>
                            <p class="text-white/90">200+ Lapangan</p>
                        </div>
                    </div>
                </div>
                <div class="group cursor-pointer">
                    <div class="relative overflow-hidden rounded-2xl shadow-lg">
                        <img src="https://images.unsplash.com/photo-1546519638-68e109498ffc?w=400&h=300&fit=crop" 
                             alt="Badminton" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <h3 class="text-2xl font-bold text-white mb-2">Badminton</h3>
                            <p class="text-white/90">300+ Lapangan</p>
                        </div>
                    </div>
                </div>
                <div class="group cursor-pointer">
                    <div class="relative overflow-hidden rounded-2xl shadow-lg">
                        <img src="https://images.unsplash.com/photo-1519861531473-9200262188bf?w=400&h=300&fit=crop" 
                             alt="Basket" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <h3 class="text-2xl font-bold text-white mb-2">Basket</h3>
                            <p class="text-white/90">150+ Lapangan</p>
                        </div>
                    </div>
                </div>
                <div class="group cursor-pointer">
                    <div class="relative overflow-hidden rounded-2xl shadow-lg">
                        <img src="https://images.unsplash.com/photo-1554068865-24cecd4e34b8?w=400&h=300&fit=crop" 
                             alt="Tenis" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <h3 class="text-2xl font-bold text-white mb-2">Tenis</h3>
                            <p class="text-white/90">100+ Lapangan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 gradient-blue">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Siap Mulai Berolahraga?
            </h2>
            <p class="text-xl text-blue-100 mb-10 max-w-2xl mx-auto">
                Bergabunglah dengan ribuan pengguna lainnya dan rasakan kemudahan booking lapangan olahraga
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="px-10 py-4 bg-white text-blue-600 rounded-xl font-bold text-lg hover:shadow-2xl hover:scale-105 transition-all">
                    Daftar Sekarang
                </a>
                <a href="{{ route('venues.index') }}" class="px-10 py-4 bg-blue-700 text-white rounded-xl font-bold text-lg hover:bg-blue-800 transition-all">
                    Lihat Lapangan
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 gradient-blue rounded-lg flex items-center justify-center mr-3">
                            <span class="text-white font-bold text-xl">F</span>
                        </div>
                        <span class="text-2xl font-bold">FitRent</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed">Platform booking lapangan olahraga terpercaya di Indonesia</p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4">Layanan</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="{{ route('venues.index') }}" class="hover:text-white transition">Sewa Lapangan</a></li>
                        <li><a href="{{ route('slots.index') }}" class="hover:text-white transition">Open Slots</a></li>
                        <li><a href="#" class="hover:text-white transition">Tournament</a></li>
                        <li><a href="#" class="hover:text-white transition">Komunitas</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4">Perusahaan</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white transition">Karir</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Press Kit</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4">Kontak</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li>Email: info@fitrent.id</li>
                        <li>Phone: 021-12345678</li>
                        <li>WhatsApp: 0812-3456-7890</li>
                    </ul>
                    <div class="flex gap-4 mt-6">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center">
                <p class="text-gray-400">&copy; 2025 FitRent. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>