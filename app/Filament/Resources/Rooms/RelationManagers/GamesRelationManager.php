<?php

namespace App\Filament\Resources\Rooms\RelationManagers;

use App\Filament\Resources\Games\GameResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GamesRelationManager extends RelationManager
{
    protected static string $relationship = 'games';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('level_3_top_score')
                    ->label('Level 3 top score'),
                TextColumn::make('level_4_top_score')
                    ->label('Level 4 top score'),

            ])
            ->paginated(false)
            ->recordUrl(fn ($record) => GameResource::getUrl('view', ['record' => $record]));
    }


}
