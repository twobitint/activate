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

        $this->handleStrengthOfSchedule();
    }

    public function handleStrengthOfSchedule()
    {
        $teamMatches = Storage::json('matches.json');
        $standings = Standing::all()->keyBy('team');

        foreach ($teamMatches as $teamName => $matches) {

            $ow = $this->opponentWinPercent($teamName, $matches, $standings);

            $oowWins = 0;
            $oowTies = 0;
            $oowGames = 0;
            foreach ($matches as $match) {

                if (!isset($match['opponentName'])
                    || $match['opponentName'] === $teamName
                    || $match['opponentName'] === 'The World'
                    || $match['status'] != 'completed') {
                    continue;
                }

                $opponentMatches = $teamMatches[$match['opponentName']] ?? [];

                $this->opponentWinPercent(
                    $match['opponentName'],
                    $opponentMatches,
                    $standings,
                    $oowWins,
                    $oowTies,
                    $oowGames
                );
            }

            $oow = $oowGames === 0 ? 0 : ($oowWins + ($oowTies * 0.5)) / $oowGames;

            $strength = ($ow * (2/3)) + ($oow * (1/3));
            $rpi = (1/4) * $standings[$teamName]->winPercentage +
                   (1/2) * $ow +
                   (1/4) * $oow;

            Standing::where('team', $teamName)->update([
                'strength_of_schedule' => round($strength, 3),
                'rpi' => round($rpi, 3),
            ]);

            $this->line("Updated {$teamName} SoS: " . number_format($strength, 3));
            $this->line("Updated {$teamName} RPI: " . number_format($rpi, 3));
        }
    }

    public function opponentWinPercent($team, $matches, $standings, &$wins = 0, &$ties = 0, &$games = 0)
    {
        $opponentWins = 0;
        $opponentTies = 0;
        $opponentGames = 0;

        foreach ($matches as $match) {
            if (!isset($match['opponentName'])
                || $match['opponentName'] === $team
                || $match['opponentName'] === 'The World'
                || $match['status'] != 'completed') {
                continue;
            }

            $opponentStanding = $standings[$match['opponentName']];
            $opponentWins += $opponentStanding->wins;
            $opponentTies += $opponentStanding->ties;
            $opponentGames += $opponentStanding->wins + $opponentStanding->losses + $opponentStanding->ties;
        }

        $wins += $opponentWins;
        $ties += $opponentTies;
        $games += $opponentGames;

        if ($opponentGames === 0) {
            return 0;
        } else {
            return ($opponentWins + ($opponentTies * 0.5)) / $opponentGames;
        }
    }
}
