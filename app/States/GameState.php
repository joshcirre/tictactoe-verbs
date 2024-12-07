<?php

namespace App\States;

use Carbon\Carbon;
use Thunk\Verbs\State;

class GameState extends State
{
    public array $board = [
        null, null, null,
        null, null, null,
        null, null, null,
    ];

    public ?string $current_player = null; // 'X' or 'O'

    public ?string $winner = null;

    public bool $is_complete = false;

    public array $player_ids = [];

    public Carbon $created_at;
}
