<?php

namespace App\Events;

use App\States\GameState;
use App\States\PlayerState;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;

class PlayerMadeMove extends Event
{
    #[StateId(GameState::class)]
    public int $game_id;

    #[StateId(PlayerState::class)]
    public int $player_id;

    public int $position; // 0-8 for the board positions

    private function checkWinner(array $board): ?string
    {
        $lines = [
            [0, 1, 2], [3, 4, 5], [6, 7, 8], // Rows
            [0, 3, 6], [1, 4, 7], [2, 5, 8], // Columns
            [0, 4, 8], [2, 4, 6], // Diagonals
        ];

        foreach ($lines as $line) {
            $values = array_map(fn ($pos) => $board[$pos], $line);
            if (count(array_unique($values)) === 1 && $values[0] !== null) {
                return $values[0];
            }
        }

        return null;
    }

    public function validate(GameState $state)
    {
        $this->assert(
            ! $state->is_complete,
            'Game is already complete'
        );

        $this->assert(
            $this->position >= 0 && $this->position <= 8,
            'Invalid board position'
        );

        $this->assert(
            $state->board[$this->position] === null,
            'Position already taken'
        );
    }

    public function apply(GameState $state)
    {
        $state->board[$this->position] = $state->current_player;

        // Check for winner
        $winner = $this->checkWinner($state->board);
        if ($winner) {
            $state->winner = $winner;
            $state->is_complete = true;

            return;
        }

        // Check for tie
        if (! in_array(null, $state->board)) {
            $state->is_complete = true;

            return;
        }

        // Switch current player
        $state->current_player = $state->current_player === 'X' ? 'O' : 'X';
    }
}
