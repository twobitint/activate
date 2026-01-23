<?php

namespace App\Filament\Resources\Matchups\Tables;

use App\Models\Enums\Skill;
use App\Models\Matchup;
use Filament\Support\Enums\TextSize;
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
                        ->label('Preferred')
                        ->badge()
                        ->formatStateUsing(fn ($state) => $state->name)
                        ->color(fn ($state) => $state->pivot->skill?->getColor() ?? Skill::Unknown->getColor())
                        ->listWithLineBreaks(),
                    TextColumn::make('unskilledPlayers')
                        ->label('Iffy')
                        ->badge()
                        ->formatStateUsing(fn ($state) => $state->name)
                        ->color(fn ($state) => $state->pivot->skill?->getColor() ?? Skill::Unknown->getColor())
                        ->listWithLineBreaks(),
                    TextColumn::make('participants')
                        ->badge()
                        ->formatStateUsing(fn ($state) => $state->name)
                        ->color(fn ($state) => $state->pivot->skill?->getColor() ?? Skill::Unknown->getColor())
                        ->listWithLineBreaks(),
                    TextColumn::make('opponentStanding.wins')
                        ->label('Opponent')
                        ->getStateUsing(fn ($record) =>
                            $record->is_global ? '🌐 The World' : $record->opponentStanding->record
                        )->formatStateUsing(fn ($state, $record) =>
                            $record->is_global ? '🌐 The World' :
                                new HtmlString("{$state} <small style=\"color: gray;\">{$record->opponentStanding->strength_of_schedule}</small>")
                        )
                        ->description(fn ($record) =>
                            $record->is_global ? null : new HtmlString(
                                "{$record->opponent} <br><span style='font-size: 0.8em; color: gray;'>{$record->opponent_location}</span>"
                            )
                        )
                        ->sortable(),
                    TextColumn::make('notes')
                        ->label('Notes')
                        ->toggleable()
                        ->size(TextSize::ExtraSmall)
                        ->html()
                        ->wrap(),
            ])->filters([
                SelectFilter::make('week')
                    ->options(fn () =>
                        Matchup::query()
                            ->distinct()
                            ->orderBy('week', 'asc')
                            ->pluck('week', 'week')
                            ->map(fn ($week) => "Week $week")
                            ->toArray()
                    )
                    ->default(config('activate.current_week')),
            ]);
    }
}
