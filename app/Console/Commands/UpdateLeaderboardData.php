<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Matchup;
use App\Models\Player;
use App\Models\Standing;
use Dom\HTMLDocument;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UpdateLeaderboardData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-leaderboard-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update leaderboard data in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $leageueData = Storage::json('leaderboard.json');

        $season = 'Winter 2026';
        $divisionIndex = 6; // div 7, zero-indexed

        $seasonData = $leageueData['props']['allSeasons'];

        foreach ($seasonData as $seasonInfo) {
            if ($seasonInfo['name'] !== $season) {
                continue;
            }

            $standings = $seasonInfo['leaderboard']['standings'][$divisionIndex]['divisionStandings'];

            foreach ($standings as $standing) {
                Standing::updateOrCreate([
                    'team' => $standing['teamName'],
                ], [
                    'standing' => $standing['standing'] ?? 0,
                    'wins' => $standing['wins'] ?? 0,
                    'losses' => $standing['losses'] ?? 0,
                    'ties' => $standing['ties'] ?? 0,
                ]);
            }
        }
    }
}
