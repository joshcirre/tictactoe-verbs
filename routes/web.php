<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GameController::class, 'create'])->name('game.create');
Route::get('/game/{gameId}', [GameController::class, 'show'])->name('game.show');
