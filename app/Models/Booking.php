<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'show_time_id',
        'total_price',
        'status',
        'booked_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function showTime(): BelongsTo
    {
        return $this->belongsTo(ShowTime::class);
    }

    public function seats(): BelongsToMany
    {
        return $this->belongsToMany(Seat::class)
                    ->withTimestamps();
    }
}
