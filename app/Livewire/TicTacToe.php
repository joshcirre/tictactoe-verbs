<?php

namespace App\Livewire;

use App\Events\PlayerJoinedGame;
use App\Events\PlayerMadeMove;
use App\States\GameState;
use App\States\PlayerState;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class TicTacToe extends Component
{
    #[Locked]
    public $gameId;

    #[Locked]
    public $playerId;

    public function mount($gameId)
    {
        $this->gameId = (int) $gameId;

        // Get or create player ID from session
        $this->playerId = Session::get('player_id');
        if (! $this->playerId) {
            $this->playerId = (int) snowflake_id();
            Session::put('player_id', $this->playerId);
        }

        // If this game doesn't have any players yet, automatically join as X
        $gameState = GameState::load($this->gameId);
        if (empty($gameState->player_ids)) {
            $this->joinAsFirstPlayer();
        }

        // If player was in this game before, they're already joined
        $playerState = PlayerState::load($this->playerId);
        if ($playerState->current_game_id === $this->gameId) {
            return;
        }
    }

    public function joinAsFirstPlayer()
    {
        PlayerJoinedGame::fire(
            game_id: $this->gameId,
            player_id: $this->playerId,
            symbol: 'X'
        );
    }

    public function joinGame()
    {
        PlayerJoinedGame::fire(
            game_id: $this->gameId,
            player_id: $this->playerId,
            symbol: 'O'
        );
    }

    public function makeMove($position)
    {
        // Only allow move if it's this player's turn
        if ($this->gameState->current_player !== $this->playerState->symbol) {
            return;
        }

        PlayerMadeMove::fire(
            game_id: $this->gameId,
            player_id: $this->playerId,
            position: $position
        );
    }

    #[Computed]
    public function gameState()
    {
        return GameState::load($this->gameId);
    }

    #[Computed]
    public function playerState()
    {
        return PlayerState::load($this->playerId);
    }

    #[Computed]
    public function canMove()
    {
        return $this->playerState->symbol &&
               $this->gameState->current_player === $this->playerState->symbol &&
               ! $this->gameState->is_complete;
    }

    public function render()
    {
        return view('livewire.tic-tac-toe');
    }
}
