<?php

namespace App\Http\Controllers;

use App\Events\GameCreated;
use Thunk\Verbs\Facades\Verbs;

class GameController extends Controller
{
    public function create()
    {
        // Generate a new game ID using snowflake
        $gameId = (int) snowflake_id();

        // Create the game
        GameCreated::fire(game_id: $gameId);
        Verbs::commit();

        // Redirect to the game page
        return redirect()->route('game.show', $gameId);
    }

    public function show($gameId)
    {
        return view('game', ['gameId' => (int) $gameId]);
    }
}
