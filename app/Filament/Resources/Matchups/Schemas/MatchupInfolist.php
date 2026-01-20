<?php

namespace App\Filament\Resources\Matchups\Schemas;

use App\Filament\Resources\Matchups\MatchupResource;
use App\Models\Matchup;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MatchupInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }
}
