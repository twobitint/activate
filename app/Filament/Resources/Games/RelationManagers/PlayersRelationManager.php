<?php

namespace App\Filament\Resources\Games\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlayersRelationManager extends RelationManager
{
    protected static string $relationship = 'players';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('best_level')
                    ->label('Highest Level Completed')
                    ->formatStateUsing(fn ($state) => $state ? $state : null)
                    ->sortable(),
                TextColumn::make('skill')
                    ->badge()
                    ->sortable(),
                // TextColumn::make('level_1_score')
                //     ->label('Level 1')
                //     ->sortable(),
                // TextColumn::make('level_2_score')
                //     ->label('Level 2')
                //     ->sortable(),
                TextColumn::make('level_3_score')
                    ->label('Level 3')
                    ->formatStateUsing(fn ($state) => $state ? $state : null)
                    ->sortable(),
                TextColumn::make('level_4_score')
                    ->label('Level 4')
                    ->formatStateUsing(fn ($state) => $state ? $state : null)
                    ->sortable(),
                // TextColumn::make('level_5_score')
                //     ->label('Level 5')
                //     ->sortable(),
                // TextColumn::make('level_6_score')
                //     ->label('Level 6')
                //     ->sortable(),
                // TextColumn::make('level_7_score')
                //     ->label('Level 7')
                //     ->sortable(),
                // TextColumn::make('level_8_score')
                //     ->label('Level 8')
                //     ->sortable(),
                // TextColumn::make('level_9_score')
                //     ->label('Level 9')
                //     ->sortable(),
                // TextColumn::make('level_10_score')
                //     ->label('Level 10')
                //     ->sortable(),
            ]);
    }


}
