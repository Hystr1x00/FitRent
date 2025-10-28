<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitRent - Platform Sewa Lapangan Olahraga</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' rx='20' fill='%231e40af'/%3E%3Ctext x='50' y='65' font-family='Arial' font-size='60' font-weight='bold' text-anchor='middle' fill='white'%3EF%3C/text%3E%3C/svg%3E">
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
    @include('layouts.navigation')

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

    @include('layouts.footer')

</body>
</html>