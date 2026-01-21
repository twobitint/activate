<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class UpdateAllData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update data in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('app:update-game-data');
        Artisan::call('app:update-player-data');
        Artisan::call('app:update-league-data');
        Artisan::call('app:update-leaderboard-data');
    }
}
