<?php

namespace App\States;

use Thunk\Verbs\State;

class PlayerState extends State
{
    public ?string $symbol = null; // 'X' or 'O'

    public ?int $current_game_id = null;
}
