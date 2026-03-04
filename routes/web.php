<?php

use App\Http\Controllers\PlayerController;
use App\Models\PlayerNote;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('players', [PlayerController::class, 'index'])
        ->middleware('can:players.view')
        ->name('players.index');

    Route::get('players/{player}/notes', [PlayerController::class, 'notes'])
        ->middleware('can:viewAny,'.PlayerNote::class)
        ->name('players.notes');
});

require __DIR__.'/settings.php';
