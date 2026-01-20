<?php

namespace App\Filament\Resources\Players\RelationManagers;

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
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('best_level')
                    ->label('Highest Level Completed')
                    ->sortable(),
                TextColumn::make('skill')
                    ->badge()
                    ->sortable(),
            ]);
    }


}
