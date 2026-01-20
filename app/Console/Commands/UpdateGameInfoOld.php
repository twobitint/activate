<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Room;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class UpdateGameInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-game-info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update game info in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $rooms = Storage::json('scores/Whumps.json')['props']['games'] ?? [];

        foreach ($rooms as $roomData) {
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
        }

        foreach ($rooms as $roomData) {
            foreach ($roomData['games'] as $gameData) {
                Game::updateOrCreate([
                    'name' => $gameData['attributes']['name'],
                ], [
                    'room' => $roomData['name'],
                    'image' => $gameData['attributes']['image'] ?? null,
                    'cooperative' => $gameData['attributes']['cooperative'] ?? false,
                    'description' => $gameData['attributes']['description'] ?? null,
                ]);
            }
        }
    }
}
