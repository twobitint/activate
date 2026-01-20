<?php

namespace App\Filament\Resources\Matchups\Pages;

use App\Filament\Resources\Matchups\MatchupResource;
use Filament\Resources\Pages\ViewRecord;

class ViewMatchup extends ViewRecord
{
    protected static string $resource = MatchupResource::class;

    public function getTitle(): string
    {
        return $this->record->game->name . ' level ' . $this->record->level;
    }
}
