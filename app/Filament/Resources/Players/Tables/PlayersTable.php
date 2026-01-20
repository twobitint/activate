<?php

namespace App\Filament\Resources\Players\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlayersTable
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
                    ->searchable()
                    // ->description(fn ($record) => "Rank $record->player_rank")
                    ->sortable(),
                TextColumn::make('player_rank')
                    ->label('Rank')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('stars')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('coins')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('standing')
                    ->label('Leaderboard')
                    ->sortable(),
                // TextColumn::make('rank')
                //     ->sortable(),
                TextColumn::make('yearly_rank')
                    ->label('2026 Leaderboard')
                    ->sortable(),
                TextColumn::make('total_score')
                    ->label('Score')
                    ->sortable(),
                TextColumn::make('yearly_score')
                    ->label('2026 Score')
                    ->sortable(),
                IconColumn::make('team_status')
                    ->label('Member')
                    ->boolean()
                    ->trueIcon('heroicon-o-user-group')
                    ->falseIcon('heroicon-o-user')
                    ->sortable(),
            ])
            ->defaultSort('standing');
            //->defaultGroup('team_status');
            // ->groups([
            //     Group::make('sub')
            //         ->titlePrefixedWithLabel(false)
            //         ->getTitleFromRecordUsing(fn ($record): string => $record->sub ? 'Substitutes' : 'Members'),
            // ]);
    }
}
