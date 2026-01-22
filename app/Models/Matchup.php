<?php

namespace App\Models;

use App\Models\Enums\RosterStatus;
use App\Models\Enums\Skill;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Matchup extends Model
{
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function players()
    {
        return $this->belongsToMany(Player::class)
            ->using(MatchupPlayer::class);
    }

    public function activePlayers()
    {
        return $this->players()
            ->wherePivot('status', RosterStatus::Active->value);
    }

    public function skilledPlayers(): Attribute
    {
        return Attribute::get(fn () =>
            $this->game->players()
                ->where('game_player.skill', '>', Skill::Neutral->value)
                ->orderBy('game_player.skill', 'desc')
                ->whereIn('player_id', $this->activePlayers->pluck('id'))
                ->get()
        );
    }

    public function unskilledPlayers(): Attribute
    {
        return Attribute::get(fn () =>
            $this->game->players()
                ->where('game_player.skill', '<', Skill::Neutral->value)
                ->where('game_player.skill', '!=', Skill::Unknown->value)
                ->orderBy('game_player.skill', 'desc')
                ->whereIn('player_id', $this->activePlayers->pluck('id'))
                ->get()
        );
    }

    public function participants(): Attribute
    {
        return Attribute::get(fn () =>
            $this->game->players()
                ->orderBy('game_player.skill', 'desc')
                ->limit($this->game->optimal_players)
                ->whereIn('player_id', $this->activePlayers->pluck('id'))
                ->get()
        );
    }

    public function opponentStanding()
    {
        return $this->belongsTo(Standing::class, 'opponent', 'team');
    }
}
