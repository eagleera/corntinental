<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }
}
