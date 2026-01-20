<?php

namespace App\Models;

use App\Models\Enums\Skill;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Matchup extends Model
{
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function playersThatLike(): Attribute
    {
        return Attribute::get(fn () =>
            $this->game->players()
                ->where('skill', '>', Skill::Neutral->value)
                ->orderBy('skill', 'desc')
                ->withPivot('skill')
                ->get()
        );
    }

    public function playersThatDontLike(): Attribute
    {
        return Attribute::get(fn () =>
            $this->game->players()
                ->where('skill', '<', Skill::Neutral->value)
                ->orderBy('skill', 'desc')
                ->withPivot('skill')
                ->get()
        );
    }

    public function participants(): Attribute
    {
        return Attribute::get(fn () =>
            $this->game->players()
                ->orderBy('skill', 'desc')
                ->withPivot('skill')
                ->limit($this->game->optimal_players)
                ->get()
        );
    }
}
