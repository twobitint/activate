<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Matchup;
use App\Models\Player;
use Dom\HTMLDocument;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UpdateLeagueData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-league-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update league data in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $leageueData = Storage::json('league.json');

        $teamSchedule = $leageueData['props']['teamSchedule'];

        foreach ($teamSchedule['matches'] as $matchData) {
            $games = $matchData['games'];

            $game = $games[0] ?? [];

            $gameId = $game ? Game::where('name', $game['gameName'])->first()->id : null;

            Matchup::updateOrCreate([
                'opponent' => $matchData['opponentName'] ?? null,
                'week' => $matchData['blockIndex'],
                'season' => $teamSchedule['season']['name'],
            ], [
                'opponent_location' => $matchData['opponentHomeLocationName'] ?? null,
                'is_global' => $matchData['opponentName'] == 'The World',
                'status' => $matchData['status'] ?? 'upcoming',
                // game data
                'game_id' => $gameId,
                'result' => $game['result'] ?? 'pending',
                'level' => $game['level'] ?? null,
                'score_type' => $game['scoreType'] ?? 'default',
                'score' => $game['score'] ?? 0,
                'opponent_score' => $game['opponentScore'] ?? 0,
            ]);
        }
    }
}
