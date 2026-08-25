<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; 

class Cinema extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'status',
    ];

    public function hall():HasMany{
        return $this->hasMany(Hall::class);
    }
}
