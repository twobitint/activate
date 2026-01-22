<?php

namespace App\Filament\Resources\Matchups\Schemas;

use App\Filament\Resources\Matchups\MatchupResource;
use App\Models\Matchup;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichEditorTool;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class MatchupInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components(fn ($record) => [
                Fieldset::make('Our opponent')
                    ->schema([
                        TextEntry::make('opponent')
                            ->label('Team'),
                        TextEntry::make('opponentStanding.record')
                            ->label('Record'),
                    ]),
                Fieldset::make('Game details')
                    ->schema([
                        TextEntry::make('game.description')
                            ->columnSpanFull(),
                        TextEntry::make("game.level_{$record->level}_top_score")
                            ->label("Culver top score"),
                    ]),
                Fieldset::make('Notes')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('notes')
                            ->markdown()
                            ->hiddenLabel()
                            ->columnSpanFull(),
                        Action::make('editNotes')
                            ->label('Edit Notes')
                            ->visible(auth()->user()?->can('update', $record) ?? false)
                            ->action(fn (Matchup $record, array $data) => $record->update(['notes' => $data['notes']]))
                            ->form([
                                RichEditor::make('notes')
                                    ->default($record->notes)
                                    ->hiddenLabel(),
                            ]),
                    ]),
                RepeatableEntry::make('participants')
                    ->label('Stats')
                    ->columnSpanFull()
                    ->table([
                        TableColumn::make('Player'),
                        TableColumn::make('Level Score'),
                        TableColumn::make('Preference'),
                        TableColumn::make('Highest Level Completed'),
                    ])
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make("pivot.level_{$record->level}_score"),
                        TextEntry::make('pivot.skill'),
                        TextEntry::make('pivot.best_level'),
                    ]),
            ]);
    }
}
