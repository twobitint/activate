<?php

namespace App\Filament\Resources\Matchups;

use App\Filament\Resources\Matchups\Pages\ListMatchups;
use App\Filament\Resources\Matchups\Pages\ViewMatchup;
use App\Filament\Resources\Matchups\Schemas\MatchupInfolist;
use App\Filament\Resources\Matchups\Tables\MatchupsTable;
use App\Models\Matchup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MatchupResource extends Resource
{
    protected static ?string $model = Matchup::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    public static function infolist(Schema $schema): Schema
    {
        return MatchupInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MatchupsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMatchups::route('/'),
            'view' => ViewMatchup::route('/{record}'),
        ];
    }
}
