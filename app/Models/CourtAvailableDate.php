<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourtAvailableDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'court_id',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function court()
    {
        return $this->belongsTo(Court::class);
    }
}


