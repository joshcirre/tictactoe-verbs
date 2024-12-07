<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Tic Tac Toe</title>

        @vite(["resources/css/app.css", "resources/js/app.js"])
    </head>
    <body class="bg-gray-100">
        <div class="container py-8 mx-auto">
            <h1 class="mb-8 text-3xl font-bold text-center">Tic Tac Toe</h1>
            <livewire:tic-tac-toe :gameId="$gameId ?? null" />
        </div>
    </body>
</html>
