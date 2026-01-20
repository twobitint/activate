<?php

namespace App\Filament\Resources\Players;

use App\Filament\Resources\Players\Pages\ListPlayers;
use App\Filament\Resources\Players\RelationManagers\GamesRelationManager;
use App\Filament\Resources\Players\Schemas\PlayerInfolist;
use App\Filament\Resources\Players\Tables\PlayersTable;
use App\Filament\Resources\Players\Pages\ViewPlayer;
use App\Models\Player;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PlayerResource extends Resource
{
    protected static ?string $model = Player::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function table(Table $table): Table
    {
        return PlayersTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PlayerInfolist::configure($schema);
    }

    public static function getRelations(): array
    {
        return [
            GamesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPlayers::route('/'),
            'view' => ViewPlayer::route('/{record}'),
        ];
    }
}
