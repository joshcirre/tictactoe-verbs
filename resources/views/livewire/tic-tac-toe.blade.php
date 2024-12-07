<div class="p-4" wire:poll.2s>
    <div class="max-w-md mx-auto">
        <!-- Game Status -->
        <div class="mb-4 text-center">
            @if (! $this->playerState->symbol)
                <button wire:click="joinGame" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                    Join Game as O
                </button>
            @else
                <p class="text-lg">
                    You are playing as:
                    <span class="font-bold">{{ $this->playerState->symbol }}</span>
                </p>
            @endif
        </div>

        <!-- Game Board -->
        <div class="grid grid-cols-3 gap-2 mb-4">
            @foreach ($this->gameState->board as $index => $cell)
                <button
                    wire:click="makeMove({{ $index }})"
                    class="h-24 bg-gray-100 hover:bg-gray-200 text-4xl font-bold rounded flex items-center justify-center {{ $this->canMove && ! $cell ? "cursor-pointer" : "cursor-not-allowed" }}"
                    @if (!$this->canMove || $cell) disabled @endif
                >
                    {{ $cell }}
                </button>
            @endforeach
        </div>

        <!-- Game Status Messages -->
        @if ($this->gameState->winner)
            <div class="text-xl font-bold text-center text-green-600">
                @if ($this->gameState->winner === $this->playerState->symbol)
                    You won!
                @else
                    Player {{ $this->gameState->winner }} wins!
                @endif
            </div>
        @elseif ($this->gameState->is_complete)
            <div class="text-xl font-bold text-center text-blue-600">Game tied!</div>
        @else
            <div class="text-lg text-center">
                @if ($this->gameState->current_player === $this->playerState->symbol)
                    <span class="font-bold text-green-600">Your turn!</span>
                @else
                    Waiting for other player...
                @endif
            </div>
        @endif

        <!-- Share Game URL -->
        <div class="p-4 mt-4 bg-white rounded shadow">
            <p class="mb-2 font-bold">Share this game:</p>
            <div class="flex items-center gap-2">
                <input type="text" value="{{ url("/game/{$gameId}") }}" class="flex-1 p-2 border rounded" readonly />
                <button
                    onclick="navigator.clipboard.writeText('{{ url("/game/{$gameId}") }}')"
                    class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600"
                >
                    Copy
                </button>
            </div>
        </div>

        <!-- New Game Button -->
        <div class="mt-4 text-center">
            <a href="{{ route("game.create") }}" class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600">
                New Game
            </a>
        </div>
    </div>
</div>
