<?php

namespace App\Filament\Resources\Rooms\Schemas;

use App\Filament\Resources\Games\GameResource;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
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
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
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
                // RepeatableEntry::make('games')
                //     ->table([
                //         TableColumn::make('Name'),
                //         TableColumn::make('Level 3 top score'),
                //         TableColumn::make('Level 4 top score'),
                //         TableColumn::make(''),
                //     ])
                //     ->schema([
                //         TextEntry::make('name'),
                //         TextEntry::make('level_3_top_score'),
                //         TextEntry::make('level_4_top_score'),
                //         TextEntry::make('link')
                //             ->getStateUsing(fn ($record) => 'View')
                //             ->url(fn ($record) => GameResource::getUrl('view', ['record' => $record])),
                //     ]),
                // ->recordUrl(fn ($record) => GameResource::getUrl('view', ['record' => $record]));
            ]);
    }
}
