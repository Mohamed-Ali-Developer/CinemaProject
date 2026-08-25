<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketPrice extends Model
{
    protected $fillable = [
        'show_time_id',
        'seat_type',
        'price'
    ];

    public function showTime(): BelongsTo
    {
        return $this->belongsTo(ShowTime::class);
    }
}
