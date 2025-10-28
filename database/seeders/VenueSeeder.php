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
            [
                'name' => 'Volleyball Court Premium',
                'sport' => 'Voli',
                'location' => 'Jakarta Utara',
                'address' => 'Jl. Kelapa Gading No. 99, Jakarta Utara',
                'description' => 'Lapangan voli indoor dengan standar internasional',
                'price' => 120000,
                'rating' => 4.5,
                'image' => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400',
                'available' => true,
                'facilities' => json_encode(['AC', 'Parking', 'Shower', 'Kantin']),
            ],
            [
                'name' => 'Tennis Club Elite',
                'sport' => 'Tennis',
                'location' => 'Jakarta Selatan',
                'address' => 'Jl. Kemang Raya No. 55, Jakarta Selatan',
                'description' => '2 lapangan tennis outdoor dengan permukaan clay',
                'price' => 250000,
                'rating' => 4.9,
                'image' => 'https://images.unsplash.com/photo-1554068865-24cecd4e34b8?w=400',
                'available' => true,
                'facilities' => json_encode(['Parking', 'Shower', 'Pro Shop', 'Restaurant']),
            ],
        ];

        foreach ($venues as $venue) {
            Venue::create($venue);
        }
    }
}