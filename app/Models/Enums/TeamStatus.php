<?php

namespace App\Models\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum TeamStatus: string implements HasLabel, HasDescription, HasColor
{
    case Member = 'Member';
    case Substitute = 'Substitute';

    public function getLabel(): string | Htmlable | null
    {
        return match ($this) {
            self::Member => 'Member',
            self::Substitute => 'Substitute',
        };
    }

    public function getDescription(): string | Htmlable | null
    {
        return match ($this) {
            self::Member => 'Active member of the team',
            self::Substitute => 'Substitute player',
        };
    }

    public function getColor(): string | null
    {
        return match ($this) {
            self::Member => 'success',
            self::Substitute => 'warning',
        };
    }
}
