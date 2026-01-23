<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    protected $fillable = [
        'team',
        'standing',
        'wins',
        'losses',
        'ties',
        'strength_of_schedule',
        'rpi'
    ];

    protected function record(): Attribute
    {
        return Attribute::get(fn () =>
            "{$this->wins}-{$this->losses}-{$this->ties}"
        );
    }

    protected function winPercentage(): Attribute
    {
        return Attribute::get(function () {
            $totalGames = $this->wins + $this->losses + $this->ties;
            if ($totalGames === 0) {
                return 0;
            }

            // Standard calculation: wins + (ties * 0.5) / total games
            return ($this->wins + ($this->ties * 0.5)) / $totalGames;
        });
    }

    protected function rpiFormatted(): Attribute
    {
        return Attribute::get(function () {
            if ($this->rpi === null) {
                return 'N/A';
            }
            return number_format($this->rpi, 3);
        });
    }

    public function matchupsAsOpponent()
    {
        return $this->hasMany(Matchup::class, 'opponent', 'team');
    }
}
