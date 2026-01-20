<?php

namespace App\Models;

use App\Models\Enums\RosterStatus;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MatchupPlayer extends Pivot
{
    protected $casts = [
        'status' => RosterStatus::class,
    ];
}
