<?php

namespace App\Filament\Pages;

use App\Filament\Resources\Matchups\MatchupResource;
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
use Illuminate\Support\HtmlString;

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
            ->query(Matchup::query()->where('week', config('activate.current_week')))
            ->columns([
                Split::make([
                    Split::make([
                        TextColumn::make('game.room')
                            ->label('Room')
                            ->description('Room', 'above')
                            ->sortable(),
                        TextColumn::make('game.name')
                            ->description('Game', 'above')
                            ->formatStateUsing(fn ($state, $record) => $state.' '.$record->level)
                            ->label('Game')
                            ->sortable(),
                        TextColumn::make('opponentStanding.wins')
                            ->description('Opponent', 'above')
                            ->label('Opponent')
                            ->getStateUsing(fn ($record) =>
                                $record->is_global ? '🌐 The World' : $record->opponentStanding->record
                            ),
                    ]),
                    TextColumn::make('participants')
                        // ->description('Participants', 'above')
                        ->badge()
                        ->formatStateUsing(fn ($state) => $state->name)
                        ->color(fn ($state) => $state->pivot->skill?->getColor() ?? Skill::Unknown->getColor())
                        ->wrap()
                        ->grow(false),
                ])
                ->from('sm')
                ->extraAttributes(['style' => 'gap: 1.25rem;']),
            ])
            ->recordUrl(fn ($record) => MatchupResource::getUrl('view', ['record' => $record]))
            ->paginated(false);
    }
}
