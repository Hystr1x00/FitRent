@extends('layouts.app')

@section('title', 'FitRent - Platform Sewa Lapangan Olahraga')

@section('content')
<!-- Hero Section -->
<section class="pt-24 pb-16 px-4 bg-gradient-to-b from-blue-50 to-white">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                    Sewa Lapangan <span class="bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">Lebih Mudah</span>
                </h1>
                <p class="text-lg text-gray-600">
                    Platform booking lapangan olahraga terpercaya. Join slot dengan pemain lain atau sewa pribadi dengan mudah dan hemat!
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:from-blue-700 hover:to-blue-600 transition font-semibold shadow-lg text-center">
                        Mulai Sekarang
                    </a>
                    <a href="{{ route('venues.index') }}" class="px-8 py-4 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition font-semibold text-center">
                        Lihat Lapangan
                    </a>
                </div>
            </div>
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-600 rounded-3xl transform rotate-3"></div>
                <img src="https://images.unsplash.com/photo-1589487391730-58f20eb2c308?w=600" alt="Sports" class="relative rounded-3xl shadow-2xl">
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="py-16 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-900">Kenapa FitRent?</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="p-6 bg-gradient-to-br from-blue-50 to-white rounded-xl hover:shadow-lg transition border border-blue-100">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-blue-400 rounded-lg flex items-center justify-center text-white mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-900">Smart Search</h3>
                <p class="text-gray-600">Temukan lapangan berdasarkan lokasi & preferensi</p>
            </div>
            <div class="p-6 bg-gradient-to-br from-blue-50 to-white rounded-xl hover:shadow-lg transition border border-blue-100">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-blue-400 rounded-lg flex items-center justify-center text-white mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-900">Join Slot</h3>
                <p class="text-gray-600">Gabung dengan pemain lain & hemat biaya</p>
            </div>
            <div class="p-6 bg-gradient-to-br from-blue-50 to-white rounded-xl hover:shadow-lg transition border border-blue-100">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-blue-400 rounded-lg flex items-center justify-center text-white mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-900">Secure Payment</h3>
                <p class="text-gray-600">Pembayaran aman & terpercaya</p>
            </div>
            <div class="p-6 bg-gradient-to-br from-blue-50 to-white rounded-xl hover:shadow-lg transition border border-blue-100">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-blue-400 rounded-lg flex items-center justify-center text-white mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-900">Instant Booking</h3>
                <p class="text-gray-600">Booking cepat tanpa ribet</p>
            </div>
        </div>
    </div>
</section>

<!-- Stats -->
<section class="py-16 px-4 bg-gradient-to-r from-blue-600 to-blue-500 text-white">
    <div class="max-w-7xl mx-auto">
        <div class="grid sm:grid-cols-3 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold mb-2">500+</div>
                <div class="text-blue-100">Lapangan Tersedia</div>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">10K+</div>
                <div class="text-blue-100">Pengguna Aktif</div>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">50K+</div>
                <div class="text-blue-100">Booking Berhasil</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 px-4 bg-white">
    <div class="max-w-4xl mx-auto text-center space-y-6">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Siap Mulai Bermain?</h2>
        <p class="text-lg text-gray-600">Daftar sekarang dan dapatkan pengalaman booking lapangan terbaik</p>
        <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:from-blue-700 hover:to-blue-600 transition font-semibold shadow-lg">
            Daftar Gratis
        </a>
    </div>
</section>
@endsection
