<?php

namespace App\Filament\Resources\Matchups\Pages;

use App\Filament\Resources\Matchups\MatchupResource;
use Filament\Resources\Pages\ListRecords;

class ListMatchups extends ListRecords
{
    protected static string $resource = MatchupResource::class;
}
