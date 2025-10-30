<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_id',
        'creator_id',
        'court_id',
        'court_name',
        'date',
        'time',
        'max_participants',
        'current_participants',
        'price_per_person',
        'status',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'price_per_person' => 'decimal:2',
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function participants()
    {
        return $this->hasMany(SlotParticipant::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getSportAttribute()
    {
        return $this->venue->sport;
    }

    public function getVenueNameAttribute()
    {
        return $this->venue->name;
    }
}