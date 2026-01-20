<?php

namespace App\Filament\Pages;

use App\Models\Enums\Skill;
use BackedEnum;
use App\Models\Matchup;
use Filament\Pages\Page;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class Week extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.week';

    protected static ?string $slug = '/';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;

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
                Split::make([
                    Split::make([
                        TextColumn::make('game.room')
                            ->label('Room')
                            //->searchable()
                            ->sortable(),
                        Stack::make([
                            TextColumn::make('game.name')
                                ->label('Game')
                                ->sortable(),
                            TextColumn::make('level')
                                ->formatStateUsing(fn ($state) => 'Level '.$state)
                                ->color('gray')
                                ->size(TextSize::ExtraSmall)
                                ->sortable(),
                        ]),
                    ])->from('md'),
                    TextColumn::make('participants')
                        ->badge()
                        ->formatStateUsing(fn ($state) => $state->name)
                        ->color(fn ($state) => $state->pivot->skill?->getColor() ?? Skill::Unknown->getColor())
                        ->wrap(),
                ]),
            ])
            ->paginated(false);
    }
}
