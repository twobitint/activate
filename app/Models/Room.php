<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function games()
    {
        return $this->hasMany(Game::class, 'room', 'name');
    }
}
