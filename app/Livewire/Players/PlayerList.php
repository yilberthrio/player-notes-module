<?php

namespace App\Livewire\Players;

use App\Services\PlayerService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Players')]
class PlayerList extends Component
{
    use WithPagination;

    public string $search = '';

    public int $perPage = 10;

    public string $sortBy = 'id';

    public string $sortDirection = 'asc';

    private PlayerService $playerService;

    public function boot(PlayerService $playerService): void
    {
        $this->playerService = $playerService;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function render(): View
    {
        return view('livewire.players.player-list', [
            'players' => $this->playerService->paginatePlayers(
                $this->search,
                $this->perPage,
                $this->sortBy,
                $this->sortDirection,
            ),
        ]);
    }
}
