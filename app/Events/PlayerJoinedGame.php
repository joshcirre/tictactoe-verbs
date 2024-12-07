<?php

namespace App\Events;

use App\States\GameState;
use App\States\PlayerState;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;

class PlayerJoinedGame extends Event
{
    #[StateId(GameState::class)]
    public int $game_id;

    #[StateId(PlayerState::class)]
    public int $player_id;

    public string $symbol; // 'X' or 'O'

    public function validate(GameState $game)
    {
        $this->assert(
            count($game->player_ids) < 2,
            'Game is already full'
        );

        $this->assert(
            ! in_array($this->player_id, $game->player_ids),
            'Player has already joined this game'
        );
    }

    public function applyToGameState(GameState $game)
    {
        $game->player_ids[] = $this->player_id;
    }

    public function applyToPlayerState(PlayerState $player)
    {
        $player->symbol = $this->symbol;
        $player->current_game_id = $this->game_id;
    }
}
