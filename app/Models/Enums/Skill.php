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
            self::Poor => 'Avoids',
            self::Low => 'Dislikes',
            self::Neutral => 'Neutral',
            self::Good => 'Likes',
            self::Great => 'Loves',
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

    public function getSelectOptionHtml(): string
    {
        return match ($this) {
            self::Unknown => "<span style=\"color: gray;\">Unknown</span>",
            self::Poor => "<span style=\"color: oklch(0.404 0.245 29.997);\">Poor</span>",
            self::Low => "<span style=\"color: oklch(0.665 0.245 74.997);\">Low</span>",
            self::Neutral => "<span style=\"color: oklch(0.828 0.189 84.429);\">Neutral</span>",
            self::Good => "<span style=\"color: oklch(0.882 0.059 254.128);\">Good</span>",
            self::Great => "<span style=\"color: oklch(0.871 0.15 154.449);\">Great</span>",
        };
    }
}
