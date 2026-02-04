<?php

namespace App\Filament\Pages;

use App\Models\Standing;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class Standings extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.standings';
    protected static ?string $slug = '/standings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    // nav label
    protected static ?string $navigationLabel = 'Standings';

    // protected static UnitEnum|string|null $navigationGroup = 'Research';

    // page title
    public function getTitle(): string
    {
        return 'Standings';
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('scores')
                ->label('Download all scores')
                ->url('scores')
                ->openUrlInNewTab(),
        ];
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
                TextColumn::make('rpi')
                    ->label('Power')
                    ->sortable(),
                TextColumn::make('strength_of_schedule')
                    ->label('Strength of Schedule')
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
            ])->paginated(false);
    }
}
