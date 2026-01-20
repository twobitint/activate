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

        $week = 1;

        foreach ($leageueData['props']['teamSchedule']['matches'] as $matchData) {
            $games = $matchData['games'];

            if (empty($games)) {
                continue;
            }

            $game = $games[0];

            Matchup::updateOrCreate([
                'game_id' => Game::where('name', $game['gameName'])->first()->id,
                'week' => $week,
                'season' => '2026',
            ], [
                'level' => $game['level'],
            ]);
        }
    }
}
