<?php

namespace App\Models;

use App\Models\Enums\TeamStatus;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Player extends Authenticatable implements FilamentUser
{
    protected $casts = [
        'team_status' => TeamStatus::class,
    ];

    public function games()
    {
        return $this->belongsToMany(Game::class)
            ->using(GamePlayer::class);
    }

    public function matchups()
    {
        return $this->belongsToMany(Matchup::class)
            ->using(MatchupPlayer::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
