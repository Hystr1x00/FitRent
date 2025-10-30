<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'venue_id',
        'slot_id',
        'type',
        'date',
        'time',
        'total_price',
        'penalty_amount',
        'penalty_paid_at',
        'status',
        'payment_status',
        'notes',
        'return_photo',
        'return_note',
        'returned_at',
        'overtime_minutes',
        'fine_amount',
        'return_status',
    ];

    protected $casts = [
        'date' => 'date',
        'total_price' => 'decimal:2',
        'penalty_amount' => 'decimal:2',
        'penalty_paid_at' => 'datetime',
        'returned_at' => 'datetime',
        'fine_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

    public function getVenueNameAttribute()
    {
        return $this->venue->name;
    }

    public function getVenueLocationAttribute()
    {
        return $this->venue->location;
    }
}