<?php

namespace App\Console\Commands;

use App\Models\Enums\R;
use App\Models\Game;
use App\Models\Room;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class UpdateGameData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-game-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update game data in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (R::cases() as $roomEnum) {
            $roomName = strtolower($roomEnum->value);
            $roomGameData = Storage::json("games/{$roomName}.json");

            $roomData = array_find($roomGameData['props']['games'], fn ($room) => strtolower($room['name']) == $roomName);

            if ($roomData) {

                // if (!array_key_exists('id', $roomData)) {
                //     dd($roomData);
                // }

                Room::updateOrCreate([
                    'id' => $roomData['id'],
                ], [
                    'name' => $roomData['name'],
                    'description' => $roomData['description'] ?? null,
                    'hero_title' => $roomData['hero_title'] ?? null,
                    'display_image' => $roomData['display_image'] ?? null,
                    'illustration' => $roomData['illustration'] ?? null,
                    'icon' => $roomData['icon'] ?? null,
                    'background' => $roomData['background'] ?? null,
                    'background_poster' => $roomData['background_poster'] ?? null,
                    'preview' => $roomData['preview'] ?? null,
                    'youtube_id' => $roomData['youtube_id'] ?? null,
                ]);

                foreach ($roomData['games'] as $gameData) {
                    $gameName = $gameData['attributes']['name'];
                    if (Game::where('name', $gameName)->exists()) {
                        Game::updateOrCreate([
                            'name' => $gameName,
                        ], [
                            'room' => $roomData['name'],
                            'image' => $gameData['attributes']['image'] ?? null,
                            'cooperative' => $gameData['attributes']['cooperative'] ?? false,
                            'description' => $gameData['attributes']['description'] ?? null,
                        ]);
                    }
                }
            }

            // top scores
            foreach ($roomGameData['props']['roomScores'] as $score) {
                Game::find($score['gameId'])
                    ->update([
                        'level_' . ($score['levelId'] + 1) . '_top_score' => $score['highScore'] ?? 0,
                    ]);
            }

        }
    }
}
