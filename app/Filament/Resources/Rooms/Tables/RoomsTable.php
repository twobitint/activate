<?php

namespace App\Filament\Resources\Rooms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RoomsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // TextColumn::make('name')
                //     ->searchable(),
                ImageColumn::make('hero_title')
                    ->label('Name'),
                TextColumn::make('description')
                    ->wrap()
                    ->searchable(),
                // ImageColumn::make('display_image'),
                // ImageColumn::make('illustration')
                //     ->searchable(),
                // ImageColumn::make('icon')
                //     ->searchable(),
                // ImageColumn::make('background')
                //     ->searchable(),
                // ImageColumn::make('background_poster')
                //     ->searchable(),
                // ImageColumn::make('preview')
                //     ->searchable(),
                // TextColumn::make('youtube_id')
                //     ->searchable(),
            ])
            ->paginated(false);
    }
}
