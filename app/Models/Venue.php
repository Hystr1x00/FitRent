<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sport',
        'location',
        'address',
        'description',
        'price',
        'rating',
        'image',
        'available',
        'facilities',
        'admin_id',
    ];

    protected $casts = [
        'facilities' => 'array',
        'price' => 'decimal:2',
        'rating' => 'decimal:2',
        'available' => 'boolean',
    ];

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function courts()
    {
        return $this->hasMany(Court::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Normalized image URL (supports stored path or absolute URL)
    public function getImageUrlAttribute(): string
    {
        $image = $this->image;
        if (!$image) {
            return 'https://images.unsplash.com/photo-1529900748604-07564a03e7a6?w=1200';
        }
        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }
        return asset('storage/' . ltrim($image, '/'));
    }
}