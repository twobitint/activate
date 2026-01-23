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

        $this->handleRatingPercentageIndex();
    }

    public function handleRatingPercentageIndex()
    {
        $teamMatches = Storage::json('opponents.json');
        $standings = Standing::all()->keyBy('team');

        // First pass: calculate all team win percentages (excluding games against each other)
        $teamWinPercentages = [];
        foreach ($standings as $teamName => $standing) {
            $teamWinPercentages[$teamName] = $this->calculateAdjustedWinPercentage($teamName, $standing, $teamMatches, $standings);
        }

        // Second pass: calculate RPI for each team
        foreach ($standings as $teamName => $standing) {
            $rpi = $this->calculateTeamRPI($teamName, $standing, $teamMatches, $standings, $teamWinPercentages);

            Standing::where('team', $teamName)->update([
                'rpi' => round($rpi, 3),
            ]);

            $this->line("Updated {$teamName} RPI: " . number_format($rpi, 3));
        }
    }

    /**
     * Calculate a team's win percentage excluding games against a specific opponent
     */
    protected function calculateAdjustedWinPercentage($teamName, $standing, $teamMatches, $allStandings, $excludeOpponent = null)
    {
        $wins = $standing->wins;
        $losses = $standing->losses;
        $ties = $standing->ties;

        // If we need to exclude games against a specific opponent, adjust the record
        if ($excludeOpponent && isset($teamMatches[$teamName])) {
            foreach ($teamMatches[$teamName] as $match) {
                if (isset($match['opponentName']) && $match['opponentName'] === $excludeOpponent) {
                    // Adjust the record based on the result of this game
                    if (isset($match['games']) && !empty($match['games'])) {
                        $game = $match['games'][0];
                        $result = $game['result'] ?? 'pending';

                        switch ($result) {
                            case 'win':
                                $wins--;
                                break;
                            case 'loss':
                                $losses--;
                                break;
                            case 'tie':
                                $ties--;
                                break;
                        }
                    }
                }
            }
        }

        $totalGames = $wins + $losses + $ties;
        if ($totalGames === 0) {
            return 0;
        }

        return ($wins + ($ties * 0.5)) / $totalGames;
    }

    /**
     * Calculate RPI for a specific team
     */
    protected function calculateTeamRPI($teamName, $standing, $teamMatches, $allStandings, $teamWinPercentages)
    {
        // WP (25%): Team's own winning percentage
        $wp = $standing->win_percentage;

        // Get list of opponents this team played against
        $opponents = [];
        if (isset($teamMatches[$teamName])) {
            foreach ($teamMatches[$teamName] as $match) {
                if (isset($match['opponentName']) && $match['opponentName'] !== $teamName) {
                    $opponentName = $match['opponentName'];
                    if (isset($allStandings[$opponentName])) {
                        $opponents[] = $opponentName;
                    }
                }
            }
        }

        $opponents = array_unique($opponents);

        // OWP (50%): Opponents' winning percentage (excluding games against this team)
        $owp = 0;
        if (!empty($opponents)) {
            $opponentWPs = [];
            foreach ($opponents as $opponent) {
                if (isset($teamWinPercentages[$opponent])) {
                    // Calculate opponent's win percentage excluding games against current team
                    $adjustedWP = $this->calculateAdjustedWinPercentage(
                        $opponent,
                        $allStandings[$opponent],
                        $teamMatches,
                        $allStandings,
                        $teamName
                    );
                    $opponentWPs[] = $adjustedWP;
                }
            }
            $owp = !empty($opponentWPs) ? array_sum($opponentWPs) / count($opponentWPs) : 0;
        }

        // OOWP (25%): Opponents' opponents' winning percentage
        $oowp = 0;
        if (!empty($opponents)) {
            $opponentOWPs = [];
            foreach ($opponents as $opponent) {
                // Calculate this opponent's OWP
                $opponentOpponents = [];
                if (isset($teamMatches[$opponent])) {
                    foreach ($teamMatches[$opponent] as $match) {
                        if (isset($match['opponentName']) && $match['opponentName'] !== $opponent && $match['opponentName'] !== $teamName) {
                            $opponentOpponentName = $match['opponentName'];
                            if (isset($allStandings[$opponentOpponentName])) {
                                $opponentOpponents[] = $opponentOpponentName;
                            }
                        }
                    }
                }

                $opponentOpponents = array_unique($opponentOpponents);

                if (!empty($opponentOpponents)) {
                    $opponentOpponentWPs = [];
                    foreach ($opponentOpponents as $opponentOpponent) {
                        if (isset($teamWinPercentages[$opponentOpponent])) {
                            $adjustedWP = $this->calculateAdjustedWinPercentage(
                                $opponentOpponent,
                                $allStandings[$opponentOpponent],
                                $teamMatches,
                                $allStandings,
                                $opponent
                            );
                            $opponentOpponentWPs[] = $adjustedWP;
                        }
                    }
                    $opponentOWP = !empty($opponentOpponentWPs) ? array_sum($opponentOpponentWPs) / count($opponentOpponentWPs) : 0;
                    $opponentOWPs[] = $opponentOWP;
                }
            }
            $oowp = !empty($opponentOWPs) ? array_sum($opponentOWPs) / count($opponentOWPs) : 0;
        }

        // Calculate RPI: (0.25 × WP) + (0.50 × OWP) + (0.25 × OOWP)
        $rpi = (0.25 * $wp) + (0.50 * $owp) + (0.25 * $oowp);

        return $rpi;
    }
}
