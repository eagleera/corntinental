<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Point extends Model
{
    protected $fillable = [
        'points', 'room_id', 'round_id', 'guest_id'
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function round(): BelongsTo
    {
        return $this->belongsTo(Round::class);
    }
    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }
}
