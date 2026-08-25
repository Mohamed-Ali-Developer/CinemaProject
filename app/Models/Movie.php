<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'poster',
        'duration',
        'release_date',
        'description',
        'language',
        'status',
        'age_rating',
    ];

    public function showTimes(): HasMany
    {
        return $this->hasMany(ShowTime::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class)->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'user_movies_list_');
    }
}
