<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    // public function room()
    // {
    //     return $this->belongsTo(Room::class, 'room', 'name');
    // }

    public function players()
    {
        return $this->belongsToMany(Player::class)
            ->using(GamePlayer::class);
    }
}
