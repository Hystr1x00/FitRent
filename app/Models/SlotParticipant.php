<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlotParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'slot_id',
        'user_id',
        'booking_id',
        'amount_paid',
        'payment_status',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
    ];

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}