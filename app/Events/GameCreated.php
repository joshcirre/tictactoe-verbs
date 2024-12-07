<?php

namespace App\Events;

use App\States\GameState;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;

class GameCreated extends Event
{
    #[StateId(GameState::class)]
    public int $game_id;

    public function apply(GameState $state)
    {
        $state->created_at = now();
        $state->current_player = 'X';
    }
}
