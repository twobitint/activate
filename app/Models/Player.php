<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Player extends Authenticatable implements FilamentUser
{
    public function games()
    {
        return $this->belongsToMany(Game::class)
            ->using(GamePlayer::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
