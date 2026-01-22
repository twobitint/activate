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
            ->using(GamePlayer::class)
            ->withPivot('skill', 'best_level', 'level_3_score', 'level_4_score', 'level_5_score', 'level_6_score');
    }
}
