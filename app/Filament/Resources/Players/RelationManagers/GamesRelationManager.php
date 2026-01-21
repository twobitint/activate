<?php

namespace App\Filament\Resources\Players\RelationManagers;

use App\Models\Enums\Skill;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GamesRelationManager extends RelationManager
{
    protected static string $relationship = 'games';

    public function table(Table $table): Table
    {
        if (auth()->check() && auth()->user()->can('update', $this->ownerRecord)) {
            $skillColumn = SelectColumn::make('skill')
                ->label('Preference')
                ->options([
                    Skill::Great->value => Skill::Great->getSelectOptionHtml(),
                    Skill::Good->value => Skill::Good->getSelectOptionHtml(),
                    Skill::Neutral->value => Skill::Neutral->getSelectOptionHtml(),
                    Skill::Low->value => Skill::Low->getSelectOptionHtml(),
                    Skill::Poor->value => Skill::Poor->getSelectOptionHtml(),
                    Skill::Unknown->value => Skill::Unknown->getSelectOptionHtml(),
                ])
                ->searchableOptions()
                ->allowOptionsHtml()
                ->sortable();
        } else {
            $skillColumn = TextColumn::make('skill')
                ->label('Preference')
                ->badge()
                ->getStateUsing(fn ($record) => $record->pivot->skill)
                ->sortable();
        }

        return $table
            ->columns([
                TextColumn::make('room')
                    ->label('Room')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('best_level')
                    ->label('Highest Level Completed')
                    ->formatStateUsing(fn ($state) => $state ? $state : null)
                    ->sortable(),
                $skillColumn,
            ]);
    }


}
