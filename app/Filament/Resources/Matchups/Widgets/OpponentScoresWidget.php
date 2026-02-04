<?php

namespace App\Filament\Resources\Matchups\Widgets;

use Filament\Tables\Table;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OpponentScoresWidget extends ChartWidget
{
    protected ?string $heading = 'Common games vs opponent';

    // column span
    protected int|string|array $columnSpan = 'full';

    protected ?string $maxHeight = '600px';

    protected ?array $options = [
        'aspectRatio' => 1,
        'scales' => [
            'y' => [
                'beginAtZero' => false,
            ],
        ],
    ];

    public ?Model $record;

    protected function getData(): array
    {
        $ourScores = $this->getScores("For Fun Friends");
        $theirScores = $this->getScores($this->record->opponent);

        $commonGames = array_intersect(array_keys($ourScores), array_keys($theirScores));

        return [
            'datasets' => [
                [
                    'label' => 'For Fun Friends',
                    'data' => array_values(array_map(fn($game) => $ourScores[$game], $commonGames)),
                    'backgroundColor' => 'rgba(54, 162, 235, 1)',
                ],
                [
                    'label' => $this->record->opponent,
                    'data' => array_values(array_map(fn($game) => $theirScores[$game], $commonGames)),
                    'backgroundColor' => 'rgba(255, 99, 132, 1)',
                ],
            ],
            'labels' => array_values($commonGames),
        ];
    }

    private function getScores($teamName): array
    {
        $scores = [];
        $matchesData = Storage::json('matches.json');
        $matches = $matchesData[$teamName] ?? [];

        foreach ($matches as $match) {

            if ($match['status'] != 'completed') {
                continue;
            }

            $game = $match['games'][0];

            if (isset($game['score'])) {
                $gameColumn = $game['gameName'] . ' ' . $game['level'];
                $score = $game['score'];

                if (array_key_exists($gameColumn, $scores)) {
                    $scores[$gameColumn] = max($scores[$gameColumn], $score);
                } else {
                    $scores[$gameColumn] = $score;
                }
            }
        }

        return $scores;
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
