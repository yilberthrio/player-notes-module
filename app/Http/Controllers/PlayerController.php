<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Contracts\View\View;

class PlayerController extends Controller
{
    public function index(): View
    {
        return view('players.index');
    }

    public function notes(Player $player): View
    {
        return view('players.notes', [
            'player' => $player,
        ]);
    }
}
