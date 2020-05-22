<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Room extends Model
{
    protected $fillable = [
        'password', 'status', 'name'
    ];

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }
    public function owner(): HasOne
    {
        return $this->HasOne(Guest::class);
    }
    public function points(): HasMany
    {
        return $this->hasMany(Point::class);
    }
    public function scopeRecord($query, $room_id, $guest_id = null){
        $query->where('rooms.id', $room_id)
            ->selectRaw('sum(points.points) as points, points.guest_id, points.round_id, guests.alias')
            ->groupBy('points.guest_id', 'round_id', 'guests.alias')
            ->orderBy('points', 'ASC')
            ->join('points', 'rooms.id', '=', 'points.room_id')
            ->join('guests', 'points.guest_id', '=', 'guests.id');
        if($guest_id != null){
            $query->where('guests.id', $guest_id);
        }
        return $query;
    }
}
