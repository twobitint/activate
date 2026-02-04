<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeagueScoresSpreadsheetService
{
    public function make(): StreamedResponse
    {
        $fileName = 'scores.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $matchData = Storage::json('matches.json');
        $columns = [];

        $scores = [];

        foreach ($matchData as $teamName => $matches) {
            foreach ($matches as $match) {
                if ($match['status'] != 'completed') {
                    continue;
                }

                $game = $match['games'][0];

                if (isset($game['score'])) {
                    $gameColumn = $game['gameName'] . ' ' . $game['level'];
                    if (!in_array($gameColumn, $columns)) {
                        $columns[] = $gameColumn;
                    }
                    $scores[$teamName][$gameColumn] = $game['score'];
                }
            }
        }

        $callback = function() use ($columns, $scores) {
            $file = fopen('php://output', 'w');
            fputcsv($file, array_merge(['team'], $columns));

            foreach ($scores as $teamName => $teamScores) {
                $row = array_fill_keys(array_merge(['team'], $columns), '');
                $row['team'] = $teamName;
                foreach ($columns as $gameColumn) {
                    $row[$gameColumn] = $teamScores[$gameColumn] ?? '';
                }
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
