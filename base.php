@endsection

<!-- ============================================ -->
<!-- routes/web.php -->
<!-- ============================================ -->
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\BookingController;

// Public Routes
Route::get('/', function () {
    return view('home');
})->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Venue Routes (Public)
Route::get('/venues', [VenueController::class, 'index'])->name('venues.index');
Route::get('/venues/{venue}', [VenueController::class, 'show'])->name('venues.show');

// Slot Routes (Public)
Route::get('/slots', [SlotController::class, 'index'])->name('slots.index');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Booking
    Route::get('/venues/{venue}/booking', [BookingController::class, 'create'])->name('venues.booking');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    
    // Join Slot
    Route::post('/slots/{slot}/join', [SlotController::class, 'join'])->name('slots.join');
});

<!-- ============================================ -->
<!-- tailwind.config.js -->
<!-- ============================================ -->
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'blue': {
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
        },
      },
    },
  },
  plugins: [],
}

<!-- ============================================ -->
<!-- resources/css/app.css -->
<!-- ============================================ -->
@tailwind base;
@tailwind components;
@tailwind utilities;

/* Custom Styles */
@layer components {
    .btn-primary {
        @apply px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:from-blue-700 hover:to-blue-600 transition font-semibold shadow-lg;
    }
    
    .btn-secondary {
        @apply px-6 py-3 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition font-semibold;
    }
    
    .card {
        @apply bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition;
    }
    
    .input-field {
        @apply w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent;
    }
}

<!-- ============================================ -->
<!-- resources/js/app.js -->
<!-- ============================================ -->
import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

<!-- ============================================ -->
<!-- package.json -->
<!-- ============================================ -->
{
    "private": true,
    "type": "module",
    "scripts": {
        "dev": "vite",
        "build": "vite build"
    },
    "devDependencies": {
        "@tailwindcss/forms": "^0.5.7",
        "alpinejs": "^3.13.5",
        "autoprefixer": "^10.4.17",
        "axios": "^1.6.4",
        "laravel-vite-plugin": "^1.0.0",
        "postcss": "^8.4.35",
        "tailwindcss": "^3.4.1",
        "vite": "^5.0.0"
    }
}

<!-- ============================================ -->
<!-- vite.config.js -->
<!-- ============================================ -->
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});

<!-- ============================================ -->
<!-- STRUKTUR FOLDER & FILE YANG DIBUTUHKAN -->
<!-- ============================================ -->

/*
STRUKTUR PROJECT LARAVEL FITRENT:

fitrent/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   └── RegisterController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── VenueController.php
│   │   │   ├── SlotController.php
│   │   │   └── BookingController.php
│   │   └── Middleware/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Venue.php
│   │   ├── Slot.php
│   │   └── Booking.php
│   └── Services/
│       ├── VenueService.php
│       ├── BookingService.php
│       └── PaymentService.php
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000000_create_users_table.php
│   │   ├── 2024_01_02_000000_create_venues_table.php
│   │   ├── 2024_01_03_000000_create_slots_table.php
│   │   └── 2024_01_04_000000_create_bookings_table.php
│   └── seeders/
│       ├── VenueSeeder.php
│       └── DatabaseSeeder.php
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── dashboard/
│       │   └── index.blade.php
│       ├── venues/
│       │   ├── index.blade.php
│       │   └── booking.blade.php
│       ├── slots/
│       │   └── index.blade.php
│       ├── bookings/
│       │   └── index.blade.php
│       └── home.blade.php
├── routes/
│   └── web.php
├── .env
├── composer.json
├── package.json
├── tailwind.config.js
└── vite.config.js

INSTALASI & SETUP:

1. Install Dependencies:
   composer install
   npm install

2. Setup Environment:
   cp .env.example .env
   php artisan key:generate

3. Database Setup:
   php artisan migrate
   php artisan db:seed

4. Run Development Server:
   php artisan serve
   npm run dev

5. Access Application:
   http://localhost:8000
*/

<!-- ============================================ -->
<!-- CONTOH MIGRATION FILES -->
<!-- ============================================ -->

-- database/migrations/2024_01_01_000000_create_users_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->json('favorite_sports')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

-- database/migrations/2024_01_02_000000_create_venues_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sport');
            $table->string('location');
            $table->text('address');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('rating', 3, 2)->default(4.5);
            $table->string('image')->nullable();
            $table->boolean('available')->default(true);
            $table->json('facilities')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};

-- database/migrations/2024_01_03_000000_create_slots_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained()->onDelete('cascade');
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');
            $table->date('date');
            $table->string('time');
            $table->integer('max_participants');
            $table->integer('current_participants')->default(1);
            $table->decimal('price_per_person', 10, 2);
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slots');
    }
};

-- database/migrations/2024_01_04_000000_create_bookings_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('venue_id')->constrained()->onDelete('cascade');
            $table->foreignId('slot_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('type', ['private', 'shared']);
            $table->date('date');
            $table->string('time');
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'refunded'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

-- database/migrations/2024_01_05_000000_create_slot_participants_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slot_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slot_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->decimal('amount_paid', 10, 2);
            $table->enum('payment_status', ['pending', 'paid'])->default('pending');
            $table->timestamps();
            
            $table->unique(['slot_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slot_participants');
    }
};

<!-- ============================================ -->
<!-- CONTOH SEEDER -->
<!-- ============================================ -->

-- database/seeders/VenueSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venue;

class VenueSeeder extends Seeder
{
    public function run(): void
    {
        $venues = [
            [
                'name' => 'Arena Futsal Pro',
                'sport' => 'Futsal',
                'location' => 'Jakarta Selatan',
                'address' => 'Jl. Fatmawati No. 123, Jakarta Selatan',
                'description' => 'Lapangan futsal profesional dengan rumput sintetis berkualitas tinggi',
                'price' => 200000,
                'rating' => 4.8,
                'image' => 'https://images.unsplash.com/photo-1589487391730-58f20eb2c308?w=400',
                'available' => true,
                'facilities' => json_encode(['Parking', 'Toilet', 'Musholla', 'Kantin']),
            ],
            [
                'name' => 'Basket Court Elite',
                'sport' => 'Basketball',
                'location' => 'Jakarta Pusat',
                'address' => 'Jl. Sudirman No. 456, Jakarta Pusat',
                'description' => 'Lapangan basket indoor dengan AC dan lighting profesional',
                'price' => 150000,
                'rating' => 4.7,
                'image' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=400',
                'available' => true,
                'facilities' => json_encode(['AC', 'Parking', 'Shower', 'Locker']),
            ],
            [
                'name' => 'Badminton Center',
                'sport' => 'Badminton',
                'location' => 'Jakarta Barat',
                'address' => 'Jl. Panjang No. 789, Jakarta Barat',
                'description' => '8 lapangan badminton indoor dengan standar internasional',
                'price' => 80000,
                'rating' => 4.9,
                'image' => 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?w=400',
                'available' => true,
                'facilities' => json_encode(['AC', 'Parking', 'Kantin', 'Pro Shop']),
            ],
            [
                'name' => 'Futsal Arena 88',
                'sport' => 'Futsal',
                'location' => 'Jakarta Timur',
                'address' => 'Jl. Basuki Rahmat No. 88, Jakarta Timur',
                'description' => 'Lapangan futsal outdoor dengan pencahayaan LED',
                'price' => 180000,
                'rating' => 4.6,
                'image' => 'https://images.unsplash.com/photo-1575361204480-aadea25e6e68?w=400',
                'available' => true,
                'facilities' => json_encode(['Parking', 'Toilet', 'Kantin']),
            ],
        ];

        foreach ($venues as $venue) {
            Venue::create($venue);
        }
    }
}

<!-- ============================================ -->
<!-- DOKUMENTASI INSTALASI -->
<!-- ============================================ -->

/*
==============================================
PANDUAN INSTALASI FITRENT - LARAVEL PROJECT
==============================================

REQUIREMENTS:
- PHP 8.1 atau lebih tinggi
- Composer
- Node.js & NPM
- MySQL atau PostgreSQL
- Git

LANGKAH INSTALASI:

1. Clone atau Download Project
   git clone https://github.com/your-repo/fitrent.git
   cd fitrent

2. Install PHP Dependencies
   composer install

3. Install JavaScript Dependencies
   npm install

4. Setup Environment File
   cp .env.example .env
   
   Edit .env dan sesuaikan:
   - DB_CONNECTION=mysql
   - DB_HOST=127.0.0.1
   - DB_PORT=3306
   - DB_DATABASE=fitrent
   - DB_USERNAME=root
   - DB_PASSWORD=

5. Generate Application Key
   php artisan key:generate

6. Create Database
   mysql -u root -p
   CREATE DATABASE fitrent;
   exit;

7. Run Migrations & Seeders
   php artisan migrate
   php artisan db:seed

8. Link Storage (untuk upload gambar)
   php artisan storage:link

9. Build Assets
   npm run dev

10. Start Development Server
    php artisan serve
    
    Buka browser: http://localhost:8000

UNTUK PRODUCTION:
   npm run build
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache

CLEAN ARCHITECTURE STRUCTURE:

app/
├── Domain/              # Business Logic
│   ├── Entities/
│   ├── Repositories/
│   └── Services/
├── Application/         # Use Cases
│   ├── UseCases/
│   └── DTOs/
├── Infrastructure/      # External Services
│   ├── Persistence/
│   ├── Payment/
│   └── Notification/
└── Presentation/        # Controllers & Views
    ├── Http/
    └── Views/

FITUR UTAMA:
✅ Registrasi & Login dengan preferensi olahraga
✅ Pencarian lapangan dengan filter
✅ Booking pribadi atau open slot (patungan)
✅ Join slot orang lain
✅ Dashboard user dengan statistik
✅ Riwayat booking
✅ Responsive design (Desktop, Tablet, Mobile)
✅ Payment integration ready
✅ Email notification ready

TEKNOLOGI:
- Laravel 10.x
- Tailwind CSS 3.x
- Alpine.js 3.x
- MySQL
- Vite

CONTACT:
Email: developer@fitrent.id
Website: https://fitrent.id
*/@endsection

<!-- ============================================ -->
<!-- resources/views/bookings/index.blade.php -->
<!-- ============================================ -->
@extends('layouts.app')

@section('title', 'Riwayat Booking - FitRent')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="pt-24 pb-16 px-4">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8">Riwayat Booking</h1>

            <!-- Stats Cards -->
            <div class="grid sm:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Booking</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total'] ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Pengeluaran Bulan Ini</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">Rp {{ number_format($stats['monthly'] ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Slot Akan Datang</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['upcoming'] ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking List -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Lapangan</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Waktu</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tipe</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Biaya</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($bookings ?? [] as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900">{{ $booking->venue_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->venue_location }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $booking->time }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-semibold">
                                        {{ $booking->type == 'private' ? 'Pribadi' : 'Join Slot' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($booking->status == 'completed')
                                        <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-semibold">Selesai</span>
                                    @elseif($booking->status == 'confirmed')
                                        <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-semibold">Dikonfirmasi</span>
                                    @elseif($booking->status == 'pending')
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-semibold">Menunggu</span>
                                    @else
                                        <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-semibold">Dibatalkan</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900">
                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('bookings.show', $booking->id) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="mb-4">Belum ada riwayat booking</p>
                                    <a href="{{ route('venues.index') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                        Mulai Booking
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if(isset($bookings) && $bookings->hasPages())
            <div class="mt-8">
                {{ $bookings->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

<!-- ============================================ -->
<!-- resources/views/venues/booking.blade.php -->
<!-- ============================================ -->
@extends('layouts.app')

@section('title', 'Booking Lapangan - FitRent')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="bookingForm()">
    <div class="pt-24 pb-16 px-4">
        <div class="max-w-5xl mx-auto">
            <a href="{{ route('venues.index') }}" class="flex items-center text-blue-600 hover:text-blue-700 mb-6">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Daftar Lapangan
            </a>

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Booking Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-md p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Booking Lapangan</h2>

                        <!-- Venue Info -->
                        <div class="mb-8 pb-8 border-b">
                            <div class="flex gap-4">
                                <img src="{{ $venue->image ?? 'https://images.unsplash.com/photo-1589487391730-58f20eb2c308?w=400' }}" alt="{{ $venue->name }}" class="w-32 h-32 rounded-lg object-cover">
                                <div class="flex-1">
                                    <span class="text-sm px-3 py-1 bg-blue-100 text-blue-600 rounded-full">{{ $venue->sport }}</span>
                                    <h3 class="text-xl font-bold text-gray-900 mt-2">{{ $venue->name }}</h3>
                                    <p class="text-gray-600 flex items-center mt-1">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $venue->location }}
                                    </p>
                                    <div class="flex items-center mt-2">
                                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <span class="ml-1 font-semibold">{{ $venue->rating ?? 4.5 }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('bookings.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="venue_id" value="{{ $venue->id }}">

                            <!-- Booking Type -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Tipe Booking</label>
                                <div class="grid sm:grid-cols-2 gap-4">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="type" value="private" x-model="bookingType" class="sr-only">
                                        <div :class="bookingType === 'private' ? 'border-blue-500 bg-blue-50' : 'border-gray-300'" class="p-4 border-2 rounded-lg transition">
                                            <div class="font-semibold text-gray-900 mb-1">Sewa Pribadi</div>
                                            <div class="text-sm text-gray-600">Sewa lapangan untuk tim Anda sendiri</div>
                                        </div>
                                    </label>

                                    <label class="cursor-pointer">
                                        <input type="radio" name="type" value="shared" x-model="bookingType" class="sr-only">
                                        <div :class="bookingType === 'shared' ? 'border-blue-500 bg-blue-50' : 'border-gray-300'" class="p-4 border-2 rounded-lg transition">
                                            <div class="font-semibold text-gray-900 mb-1">Buat Open Slot</div>
                                            <div class="text-sm text-gray-600">Buka slot untuk pemain lain bergabung</div>
                                        </div>
                                    </label>
                                </div>
                                @error('type')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date & Time -->
                            <div class="grid sm:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
                                    <input type="date" name="date" required min="{{ date('Y-m-d') }}" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('date') border-red-500 @enderror">
                                    @error('date')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Waktu Mulai</label>
                                    <select name="time" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('time') border-red-500 @enderror">
                                        <option value="">Pilih Waktu</option>
                                        <option value="08:00 - 10:00">08:00 - 10:00</option>
                                        <option value="10:00 - 12:00">10:00 - 12:00</option>
                                        <option value="13:00 - 15:00">13:00 - 15:00</option>
                                        <option value="15:00 - 17:00">15:00 - 17:00</option>
                                        <option value="17:00 - 19:00">17:00 - 19:00</option>
                                        <option value="19:00 - 21:00">19:00 - 21:00</option>
                                        <option value="21:00 - 23:00">21:00 - 23:00</option>
                                    </select>
                                    @error('time')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Participants (for shared booking) -->
                            <div x-show="bookingType === 'shared'" class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Jumlah Peserta Ideal
                                </label>
                                <input type="number" name="max_participants" x-model="participants" min="2" max="20" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                    placeholder="10">
                                <p class="text-sm text-gray-600 mt-2">
                                    Biaya akan dibagi rata: Rp <span x-text="Math.round({{ $venue->price }} / participants).toLocaleString('id-ID')"></span> per orang
                                </p>
                            </div>

                            <!-- Additional Notes -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan (Opsional)</label>
                                <textarea name="notes" rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                    placeholder="Tambahkan catatan khusus untuk booking Anda..."></textarea>
                            </div>

                            <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:from-blue-700 hover:to-blue-600 transition font-semibold shadow-lg">
                                Lanjut ke Pembayaran
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md p-6 sticky top-24">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Ringkasan Booking</h3>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Lapangan</span>
                                <span class="font-semibold text-gray-900">{{ $venue->name }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tipe</span>
                                <span class="font-semibold text-gray-900" x-text="bookingType === 'private' ? 'Sewa Pribadi' : 'Open Slot'">-</span>
                            </div>
                        </div>

                        <div class="border-t pt-4 mb-6">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Harga Sewa</span>
                                <span class="font-semibold">Rp {{ number_format($venue->price, 0, ',', '.') }}</span>
                            </div>
                            <div x-show="bookingType === 'shared'" class="flex justify-between mb-2 text-sm text-green-600">
                                <span>Dibagi <span x-text="participants"></span> orang</span>
                                <span>Rp <span x-text="Math.round({{ $venue->price }} / participants).toLocaleString('id-ID')"></span>/orang</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Biaya Layanan</span>
                                <span class="font-semibold">Rp 5.000</span>
                            </div>
                        </div>

                        <div class="border-t pt-4 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-900">Total</span>
                                <span class="text-2xl font-bold text-blue-600">
                                    Rp <span x-text="(bookingType === 'private' ? {{ $venue->price }} + 5000 : Math.round({{ $venue->price }} / participants) + 5000).toLocaleString('id-ID')"></span>
                                </span>
                            </div>
                        </div>

                        <p class="text-xs text-gray-500 text-center">
                            Dengan melanjutkan, Anda setuju dengan Syarat & Ketentuan kami
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function bookingForm() {
    return {
        bookingType: 'private',
        participants: 10
    }
}
</script>
@endsection@endsection

<!-- ============================================ -->
<!-- resources/views/venues/index.blade.php -->
<!-- ============================================ -->
@extends('layouts.app')

@section('title', 'Daftar Lapangan - FitRent')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="pt-24 pb-16 px-4">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8">Temukan Lapangan</h1>
            
            <!-- Filters -->
            <div class="bg-white p-6 rounded-xl shadow-md mb-8">
                <form action="{{ route('venues.index') }}" method="GET">
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="relative">
                            <svg class="absolute left-3 top-3 text-gray-400 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari lapangan..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <select name="sport" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Olahraga</option>
                            <option value="Futsal" {{ request('sport') == 'Futsal' ? 'selected' : '' }}>Futsal</option>
                            <option value="Basketball" {{ request('sport') == 'Basketball' ? 'selected' : '' }}>Basketball</option>
                            <option value="Badminton" {{ request('sport') == 'Badminton' ? 'selected' : '' }}>Badminton</option>
                        </select>
                        <select name="location" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Lokasi</option>
                            <option value="Jakarta Selatan">Jakarta Selatan</option>
                            <option value="Jakarta Pusat">Jakarta Pusat</option>
                            <option value="Jakarta Barat">Jakarta Barat</option>
                        </select>
                        <button type="submit" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:from-blue-700 hover:to-blue-600 transition">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Venues Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($venues ?? [] as $venue)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition group">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $venue->image ?? 'https://images.unsplash.com/photo-1589487391730-58f20eb2c308?w=400' }}" alt="{{ $venue->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
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
                                <span class="ml-1 text-sm font-semibold">{{ $venue->rating ?? 4.5 }}</span>
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
                                <div class="text-sm text-gray-500">per 2 jam</div>
                            </div>
                            <a href="{{ route('venues.booking', $venue->id) }}" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:from-blue-700 hover:to-blue-600 transition">
                                Book
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500">Tidak ada lapangan ditemukan</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if(isset($venues) && $venues->hasPages())
            <div class="mt-8">
                {{ $venues->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

<!-- ============================================ -->
<!-- resources/views/slots/index.blade.php -->
<!-- ============================================ -->
@extends('layouts.app')

@section('title', 'Open Slots - FitRent')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="pt-24 pb-16 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Open Slots</h1>
                <p class="text-gray-600">Gabung dengan pemain lain dan hemat biaya!</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">
                @forelse($slots ?? [] as $slot)
                <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold">{{ $slot->sport }}</span>
                        <span class="text-green-600 font-semibold">
                            {{ $slot->max_participants - $slot->current_participants }} slot tersisa
                        </span>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-4">{{ $slot->venue_name }}</h3>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($slot->date)->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $slot->time }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>{{ $slot->current_participants }}/{{ $slot->max_participants }} peserta</span>
                        </div>
                    </div>

                    <div class="border-t pt-4 mb-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Biaya per orang</span>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-blue-600">Rp {{ number_format($slot->price_per_person, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('slots.join', $slot->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:from-blue-700 hover:to-blue-600 transition font-semibold">
                            Join Slot
                        </button>
                    </form>
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
        </div>
    </div>
</div>
@endsection

<!-- ============================================ -->
<!-- resources/views/dashboard/index.blade.php -->
<!-- ============================================ -->
@extends('layouts.app')

@section('title', 'Dashboard - FitRent')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="pt-24 pb-16 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Dashboard</h1>
                <p class="text-gray-600">Selamat datang kembali, {{ Auth::user()->name }}!</p>
            </div>

            <!-- Quick Actions -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <a href="{{ route('venues.index') }}" class="p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition text-left">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Cari Lapangan</h3>
                    <p class="text-sm text-gray-600">Temukan lapangan favoritmu</p>
                </a>

                <a href="{{ route('slots.index') }}" class="p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition text-left">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Open Slots</h3>
                    <p class="text-sm text-gray-600">Gabung dengan pemain lain</p>
                </a>

                <a href="{{ route('bookings.index') }}" class="p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition text-left">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Riwayat Booking</h3>
                    <p class="text-sm text-gray-600">Lihat booking Anda</p>
                </a>

                <a href="#" class="p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition text-left">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Statistik</h3>
                    <p class="text-sm text-gray-600">Aktivitas bermain Anda</p>
                </a>
            </div>

            <!-- Stats -->
            <div class="grid sm:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Booking</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalBookings ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Pengeluaran Bulan Ini</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">Rp {{ number_format($monthlySpending ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Slot Akan Datang</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $upcomingSlots ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Bookings -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Booking Mendatang</h2>
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    @forelse($upcomingBookings ?? [] as $booking)
                    <div class="p-6 border-b last:border-b-0 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 mb-1">{{ $booking->venue_name }}</h3>
                                <p class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }} • {{ $booking->time }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-semibold">
                                    Akan Datang
                                </span>
                                <p class="text-lg font-bold text-blue-600 mt-2">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-12 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p>Belum ada booking mendatang</p>
                        <a href="{{ route('venues.index') }}" class="mt-4 inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Mulai Booking
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FitRent - Platform Sewa Lapangan Olahraga')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-md fixed w-full top-0 z-50" x-data="{ isOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">
                        FitRent
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 transition">Home</a>
                    <a href="{{ route('venues.index') }}" class="text-gray-700 hover:text-blue-600 transition">Lapangan</a>
                    <a href="{{ route('slots.index') }}" class="text-gray-700 hover:text-blue-600 transition">Open Slots</a>
                    <a href="#" class="text-gray-700 hover:text-blue-600 transition">Tentang</a>
                </div>
                
                <!-- Auth Buttons -->
                <div class="hidden md:flex space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="px-4 py-2 text-blue-600 hover:text-blue-700 transition">Login</a>
                        <a href="{{ route('register') }}" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:from-blue-700 hover:to-blue-600 transition">Daftar</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-blue-600 hover:text-blue-700 transition">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Logout</button>
                        </form>
                    @endguest
                </div>
                
                <!-- Mobile Menu Button -->
                <button @click="isOpen = !isOpen" class="md:hidden">
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
        <div x-show="isOpen" class="md:hidden bg-white border-t">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-gray-700 hover:bg-blue-50 rounded">Home</a>
                <a href="{{ route('venues.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-blue-50 rounded">Lapangan</a>
                <a href="{{ route('slots.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-blue-50 rounded">Open Slots</a>
                <a href="#" class="block px-3 py-2 text-gray-700 hover:bg-blue-50 rounded">Tentang</a>
                @guest
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-blue-600 hover:bg-blue-50 rounded">Login</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 bg-blue-600 text-white rounded">Daftar</a>
                @else
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-blue-600 hover:bg-blue-50 rounded">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 text-gray-700 hover:bg-gray-50 rounded">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-bold bg-gradient-to-r from-blue-400 to-blue-300 bg-clip-text text-transparent mb-4">FitRent</h3>
                    <p class="text-gray-400">Platform booking lapangan olahraga terpercaya di Indonesia</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Layanan</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">Sewa Lapangan</a></li>
                        <li><a href="#" class="hover:text-white">Open Slots</a></li>
                        <li><a href="#" class="hover:text-white">Tournament</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Perusahaan</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white">Karir</a></li>
                        <li><a href="#" class="hover:text-white">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Email: info@fitrent.id</li>
                        <li>Phone: 021-12345678</li>
                        <li>WhatsApp: 0812-3456-7890</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 FitRent. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>

<!-- ============================================ -->
<!-- resources/views/home.blade.php -->
<!-- ============================================ -->
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

<!-- ============================================ -->
<!-- resources/views/auth/register.blade.php -->
<!-- ============================================ -->
@extends('layouts.app')

@section('title', 'Daftar - FitRent')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-white flex items-center justify-center px-4 py-12">
    <div class="max-w-2xl w-full pt-16">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent mb-2">
                FitRent
            </h1>
            <h2 class="text-2xl font-bold text-gray-900">Daftar Sekarang</h2>
            <p class="text-gray-600 mt-2">Mulai pengalaman booking lapangan terbaik</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror" 
                                placeholder="John Doe">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror" 
                                placeholder="email@example.com">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror" 
                                placeholder="08123456789">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                            <input type="password" name="password" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror" 
                                placeholder="••••••••">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Olahraga Favorit</label>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach(['Futsal', 'Basketball', 'Badminton', 'Voli', 'Tennis', 'Lainnya'] as $sport)
                            <label class="flex items-center justify-center px-4 py-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                <input type="checkbox" name="sports[]" value="{{ $sport }}" class="mr-2">
                                <span class="text-sm font-medium">{{ $sport }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="agree" required class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-600">
                                Saya setuju dengan <a href="#" class="text-blue-600 hover:text-blue-700">Syarat & Ketentuan</a>
                            </span>
                        </label>
                    </div>

                    <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:from-blue-700 hover:to-blue-600 transition font-semibold shadow-lg">
                        Daftar Sekarang
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold">Login di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- ============================================ -->
<!-- resources/views/auth/login.blade.php -->
<!-- ============================================ -->
@extends('layouts.app')

@section('title', 'Login - FitRent')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-white flex items-center justify-center px-4">
    <div class="max-w-md w-full pt-16">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent mb-2">
                FitRent
            </h1>
            <h2 class="text-2xl font-bold text-gray-900">Selamat Datang Kembali</h2>
            <p class="text-gray-600 mt-2">Login untuk melanjutkan</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8">
            @if(session('error'))
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-600">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror" 
                            placeholder="email@example.com">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror" 
                            placeholder="••••••••">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700">Lupa password?</a>
                    </div>

                    <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:from-blue-700 hover:to-blue-600 transition font-semibold shadow-lg">
                        Login
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-semibold">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection