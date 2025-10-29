<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourtTimeslot extends Model
{
    use HasFactory;

    protected $fillable = [
        'court_id',
        'start_time',
        'end_time',
        'price',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function court()
    {
        return $this->belongsTo(Court::class);
    }
}



