<?php

namespace App\Policies;

use App\Models\PlayerNote;
use App\Models\User;

class PlayerNotePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('player-notes.view');
    }

    public function view(User $user, PlayerNote $playerNote): bool
    {
        return $user->can('player-notes.view');
    }

    public function create(User $user): bool
    {
        return $user->can('player-notes.create');
    }

    public function update(User $user, PlayerNote $playerNote): bool
    {
        return $user->can('player-notes.update');
    }

    public function delete(User $user, PlayerNote $playerNote): bool
    {
        return $user->can('player-notes.delete');
    }
}
