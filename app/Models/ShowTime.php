<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShowTime extends Model
{
    protected $fillable = [
        'movie_id',
        'hall_id',
        'start_at',
        'end_at',
        'status',
    ];

    protected $casts = [
    'start_at' => 'datetime',
    'end_at' => 'datetime',
];

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function hall(): BelongsTo
    {
        return $this->belongsTo(Hall::class);
    }

    public function ticketPrices(): HasMany
    {
        return $this->hasMany(TicketPrice::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
