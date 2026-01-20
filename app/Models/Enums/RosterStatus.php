<?php

namespace App\Models\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum RosterStatus: string implements HasLabel, HasDescription, HasColor
{
    case Active = 'Active';
    case Inactive = 'Inactive';

    public function getLabel(): string | Htmlable | null
    {
        return match ($this) {
            self::Active => 'Active',
            self::Inactive => 'Inactive',
        };
    }

    public function getDescription(): string | Htmlable | null
    {
        return match ($this) {
            self::Active => 'Active player',
            self::Inactive => 'Inactive player',
        };
    }

    public function getColor(): string | null
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'gray',
        };
    }
}
