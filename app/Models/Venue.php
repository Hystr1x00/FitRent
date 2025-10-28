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
}