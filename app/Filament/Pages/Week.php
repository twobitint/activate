<?php

namespace App\Filament\Pages;

use App\Models\Matchup;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class Week extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.week';

    protected static ?string $slug = '/';

    // nav label
    protected static ?string $navigationLabel = 'This Week\'s Games';

    // page title
    public function getTitle(): string
    {
        return 'This Week\'s Games';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Matchup::query()->where('week', 1))
            ->columns([

                TextColumn::make('game.room')
                    ->label('Room')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('game.name')
                    ->label('Game')
                    ->description(fn ($record) => 'Level '.$record->level)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('level')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                // TextColumn::make('game.optimal_players')
                //     ->label('Optimal Players')
                //     ->sortable(),
                TextColumn::make('participants')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state->name)
                    ->color(fn ($state) => $state->pivot->skill->getColor())
                    ->listWithLineBreaks(),
            ])
            ->paginated(false);
    }
}
