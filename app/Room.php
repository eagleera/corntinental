<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'password', 'status'
    ];

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }
    public function points(): HasMany
    {
        return $this->hasMany(Point::class);
    }
}
