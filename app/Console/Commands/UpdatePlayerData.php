<?php

namespace App\Console\Commands;

use App\Models\Enums\G;
use App\Models\Player;
use Dom\HTMLDocument;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UpdatePlayerData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-player-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update player data in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $players = Storage::json('players.json');

        foreach ($players as $playerInfo) {

            $data = Storage::json('scores/' . $playerInfo['name'] . '.json')['props'];

            $playerData = $data['player'];

            $player = Player::updateOrCreate([
                'name' => $playerData['player']['playerName'],
            ], [
                'email' => $playerInfo['email'] ?? null,
                'sub' => $playerInfo['sub'] ?? false,
                'rank' => $playerData['player']['rank'] ?? null,
                'stars' => $playerData['player']['stars'] ?? null,
                'coins' => $playerData['player']['coins'] ?? null,
                'player_rank' => $playerData['playerLocation']['playerRank'] ?? null,
                'yearly_rank' => $playerData['playerLocation']['yearlyRank'] ?? null,
                'standing' => $playerData['playerLocation']['standing'] ?? null,
                'total_score' => $playerData['playerLocation']['totalScore'] ?? null,
                'yearly_score' => $playerData['playerLocation']['yearlyScore'] ?? null,
            ]);

            $gameScores = [];

            foreach ($playerData['playerLocation']['scores'] as $score) {
                $level = $score['levelId'] + 1;
                $gameScores[$score['gameId']][$level] = $score['highScore'];
            }

            foreach (G::cases() as $gameEnum) {
                $gameId = $gameEnum->value;
                if (!array_key_exists($gameId, $gameScores)) {
                    $gameScores[$gameId][0] = 0;
                }
                $scores = $gameScores[$gameId];
                $gamePlayerUpdates[$gameId] = [
                    'level_1_score' => $scores[1] ?? 0,
                    'level_2_score' => $scores[2] ?? 0,
                    'level_3_score' => $scores[3] ?? 0,
                    'level_4_score' => $scores[4] ?? 0,
                    'level_5_score' => $scores[5] ?? 0,
                    'level_6_score' => $scores[6] ?? 0,
                    'level_7_score' => $scores[7] ?? 0,
                    'level_8_score' => $scores[8] ?? 0,
                    'level_9_score' => $scores[9] ?? 0,
                    'level_10_score' => $scores[10] ?? 0,
                    'best_level' => max(array_keys($scores)),
                ];
            }

            $player->games()->sync($gamePlayerUpdates);
        }
    }
}
