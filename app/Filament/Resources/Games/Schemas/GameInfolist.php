<?php

namespace App\Filament\Resources\Games\Schemas;

use App\Filament\Resources\Rooms\RoomResource;
use App\Models\Room;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class GameInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('room')
                    ->url(fn ($record) => RoomResource::getUrl('view', ['record' => Room::where('name', 'like', $record->room)->first()])),
                TextEntry::make('description')
                    ->columnSpanFull(),
                TextEntry::make('level_3_top_score'),
                TextEntry::make('level_4_top_score'),
                // TextEntry::make('updated_at')
                //     ->dateTime()
                //     ->placeholder('-'),
            ]);
    }
}
