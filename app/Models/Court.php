<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_id',
        'sport',
        'court_code',
        'name',
        'image',
        'gallery',
        'about',
        'rules',
        'facilities',
        'refund_policy',
        'maps_url',
        'location',
        'labels',
        'available_dates',
        'booking_duration_minutes',
        'open_time',
        'close_time',
        'price_per_session',
        'status',
        'rating',
        'venue_name',
    ];

    protected $casts = [
        'facilities' => 'array',
        'price_per_session' => 'decimal:2',
        'gallery' => 'array',
        'labels' => 'array',
        'available_dates' => 'array',
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function timeslots()
    {
        return $this->hasMany(CourtTimeslot::class);
    }

    public function availableDates()
    {
        return $this->hasMany(CourtAvailableDate::class);
    }
}


