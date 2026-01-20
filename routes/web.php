<?php

use App\Models\Player;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

// ...

Route::get('scores', fn () =>
    json_decode(Storage::get('scores/Twongx.json'))
);

Route::get('grid', fn () =>
    json_decode(Storage::get('games/mega grid.json'))
);

Route::get('league', fn () =>
    json_decode(Storage::get('league.json'))
);

Route::get('leaderboard', fn () =>
    json_decode(Storage::get('leaderboard.json'))
);

// Route::get('hoops', fn () =>
//     json_decode(Storage::get('hoops.json'))
// );



Route::get('/login', function ()
{
    return Socialite::driver('google')->redirect();
});

// Route::get('/auth/refresh', function ()
// {
//     $refreshToken = Storage::disk('local')->get('google/oauth-refresh-token.json');

//     $newTokens = Socialite::driver('google')->refreshToken($refreshToken);

//     if($newTokens->token)
//     {
//         Storage::disk('local')->put('google/oauth-token.json', $newTokens->token);
//     }

//     if($newTokens->refreshToken)
//     {
//         Storage::disk('local')->put('google/oauth-refresh-token.json', $newTokens->refreshToken);
//     }

//     return redirect('/gmail');
// });

Route::get('/auth/callback', function ()
{
    $googleUser = Socialite::driver('google')->user();

    $email = $googleUser->getEmail();

    $player = Player::where('email', $email)->first();

    Auth::login($player);

    return redirect('/');
});
