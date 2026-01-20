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
            ->modifyQueryUsing(fn ($query) => $query->whereNotIn('name', ['Arena', 'Climb', 'Pipes', 'Trench', 'Push']))
            ->columns([
                ImageColumn::make('hero_title')
                    ->label('Name'),
                TextColumn::make('description')
                    ->wrap(),
            ])
            ->paginated(false);
    }
}
