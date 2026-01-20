<?php

namespace App\Filament\Resources\Rooms\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RoomInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextEntry::make('created_at')
                //     ->dateTime()
                //     ->placeholder('-'),
                // TextEntry::make('updated_at')
                //     ->dateTime()
                //     ->placeholder('-'),
                // TextEntry::make('description')
                //     ->placeholder('-')
                //     ->columnSpanFull(),
                // TextEntry::make('hero_title')
                //     ->placeholder('-'),
                // ImageEntry::make('display_image')
                //     ->placeholder('-'),
                // TextEntry::make('illustration')
                //     ->placeholder('-'),
                // TextEntry::make('icon')
                //     ->placeholder('-'),
                // TextEntry::make('background')
                //     ->placeholder('-'),
                // TextEntry::make('background_poster')
                //     ->placeholder('-'),
                // TextEntry::make('preview')
                //     ->placeholder('-'),
                // TextEntry::make('youtube_id')
                //     ->placeholder('-'),
            ]);
    }
}
