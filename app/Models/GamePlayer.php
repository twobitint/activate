<?php

namespace App\Models;

use App\Models\Enums\Skill;
use Illuminate\Database\Eloquent\Relations\Pivot;

class GamePlayer extends Pivot
{
    protected $casts = [
        'level_1_score' => 'integer',
        'level_2_score' => 'integer',
        'level_3_score' => 'integer',
        'level_4_score' => 'integer',
        'level_5_score' => 'integer',
        'level_6_score' => 'integer',
        'level_7_score' => 'integer',
        'level_8_score' => 'integer',
        'level_9_score' => 'integer',
        'level_10_score' => 'integer',
        'best_level' => 'integer',
        'skill' => Skill::class,
    ];
}
