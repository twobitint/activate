<?php

namespace App\Filament\Pages;

use App\Models\Standing;
use UnitEnum;
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

class Standings extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.standings';
    protected static ?string $slug = '/standings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    // nav label
    protected static ?string $navigationLabel = 'Standings';

    protected static UnitEnum|string|null $navigationGroup = 'Research';

    // page title
    public function getTitle(): string
    {
        return 'Standings';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Standing::query())
            ->columns([
                TextColumn::make('standing')
                    ->label('#')
                    ->sortable(),
                TextColumn::make('team')
                    ->label('Team')
                    ->sortable(),
                TextColumn::make('record')
                    ->label('Record')
                    ->sortable(),
                TextColumn::make('wins')
                    ->label('Wins')
                    ->sortable(),
                TextColumn::make('losses')
                    ->label('Losses')
                    ->sortable(),
                TextColumn::make('ties')
                    ->label('Ties')
                    ->sortable(),
                TextColumn::make('strength_of_schedule')
                    ->label('Strength of Schedule')
                    ->sortable(),
                // TextColumn::make('rpiFormatted')
                //     ->label('RPI')
                //     ->sortable(),
            ])->paginated(false);
    }
}
