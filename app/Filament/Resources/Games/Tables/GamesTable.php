<?php

namespace App\Filament\Resources\Games\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GamesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('room')
                    ->searchable(),
                TextColumn::make('description')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('optimal_players')
                    ->numeric(),
            ])
            ->actions([
                EditAction::make(),
            ]);
    }
}
