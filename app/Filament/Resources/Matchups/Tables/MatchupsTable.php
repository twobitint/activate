<?php

namespace App\Filament\Resources\Matchups\Tables;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class MatchupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                    TextColumn::make('week')
                        ->label('Week')
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->sortable(),
                    TextColumn::make('game.room')
                        ->label('Room')
                        //->searchable()
                        ->sortable(),
                    TextColumn::make('game.name')
                        ->label('Game')
                        ->description(fn ($record) => "Level $record->level")
                        ->sortable(),
                    TextColumn::make('level')
                        ->formatStateUsing(fn ($state) => 'Level '.$state)
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->color('gray')
                        ->sortable(),
                    TextColumn::make('skilledPlayers')
                        ->label('Skilled players')
                        ->badge()
                        ->formatStateUsing(fn ($state) => $state->name)
                        ->color(fn ($state) => $state->pivot->skill->getColor())
                        ->listWithLineBreaks(),
                    TextColumn::make('unskilledPlayers')
                        ->label('Iffy players')
                        ->badge()
                        ->formatStateUsing(fn ($state) => $state->name)
                        ->color(fn ($state) => $state->pivot->skill->getColor())
                        ->listWithLineBreaks(),
                    TextColumn::make('participants')
                        ->badge()
                        ->formatStateUsing(fn ($state) => $state->name)
                        ->color(fn ($state) => $state->pivot->skill->getColor())
                        ->listWithLineBreaks(),
                    TextColumn::make('opponentStanding.record')
                        ->label('Opponent')
                        ->getStateUsing(fn ($record) =>
                            $record->is_global ? '🌐 The World' : $record->opponentStanding->record
                        )
                        ->description(fn ($record) =>
                            $record->is_global ? null : new HtmlString(
                                "{$record->opponent} <br><span style='font-size: 0.8em; color: gray;'>{$record->opponent_location}</span>"
                            )
                        )
                        // ->listWithLineBreaks()
                        // ->getStateUsing(fn ($record) => [
                        //     $record->is_global ? '🌐 The World' : $record->opponent,
                        //     $record->opponent_location,
                        // ])
                        // ->description(fn ($record) => $record->opponentStanding->record ?? '')
                        ->sortable(),
            ])->filters([
                SelectFilter::make('week')
                    ->options([
                        1 => 'Week 1',
                    ])
                    ->default(1),
            ]);
    }
}
