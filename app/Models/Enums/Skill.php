<?php

namespace App\Models\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum Skill: int implements HasLabel, HasDescription, HasColor
{
    case Unknown = 0;
    case Poor = 1;
    case Low = 2;
    case Neutral = 3;
    case Good = 4;
    case Great = 5;

    public function getLabel(): string | Htmlable | null
    {
        return match ($this) {
            self::Unknown => 'Unknown',
            self::Poor => 'Declined',
            self::Low => 'Disliked',
            self::Neutral => 'Neutral',
            self::Good => 'Enjoys',
            self::Great => 'Great',
        };
    }

    public function getDescription(): string | Htmlable | null
    {
        return match ($this) {
            self::Unknown => 'No skill level specified or never played',
            self::Poor => 'Prefers not to play',
            self::Low => 'Does not enjoy but will play if needed',
            self::Neutral => 'OK at the game',
            self::Good => 'Enjoys playing this game',
            self::Great => 'Loves playing this game',
        };
    }

    public function getColor(): string | null
    {
        return match ($this) {
            self::Unknown => 'gray',
            self::Poor => 'danger',
            self::Low => 'orange',
            self::Neutral => 'warning',
            self::Good => 'info',
            self::Great => 'success',
        };
    }
}
