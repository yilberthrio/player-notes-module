<?php

namespace App\Livewire\Players;

use App\Http\Requests\PlayerNotes\StorePlayerNoteRequest;
use App\Livewire\Forms\PlayerNoteForm;
use App\Models\Player;
use App\Models\PlayerNote;
use App\Services\PlayerNoteService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Player Notes')]
class PlayerNotesManager extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    public Player $player;

    public PlayerNoteForm $form;

    public int $perPage = 10;

    public string $search = '';

    public string $sortBy = 'created_at';

    public string $sortDirection = 'desc';

    public int $contentMaxLength = StorePlayerNoteRequest::CONTENT_MAX_LENGTH;

    private PlayerNoteService $playerNoteService;

    public function boot(PlayerNoteService $playerNoteService): void
    {
        $this->playerNoteService = $playerNoteService;
    }

    public function mount(Player $player): void
    {
        $this->player = $player->load('person');
    }

    public function updatingSearch(): void
    {
        $this->resetPage('notesPage');
    }

    public function updatingPerPage(): void
    {
        $this->resetPage('notesPage');
    }

    public function updatedFormContent(string $value): void
    {
        if (mb_strlen($value) > $this->contentMaxLength) {
            $this->form->content = mb_substr($value, 0, $this->contentMaxLength);
        }
    }

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }

        $this->resetPage('notesPage');
    }

    public function createNote(): void
    {
        $this->authorize('create', PlayerNote::class);

        /** @var array{content: string} $validated */
        $validated = $this->form->validate();

        $this->playerNoteService->createForPlayer(
            $this->player,
            (int) auth()->id(),
            $validated['content'],
        );

        $this->dispatch('player-note-created');

        $this->form->resetState();
        $this->resetPage('notesPage');
    }

    public function startEditing(int $noteId): void
    {
        $note = $this->playerNoteService->findForPlayer($this->player, $noteId);

        abort_unless($note !== null, 404);
        $this->authorize('update', $note);

        $this->form->setFromNote($note);
    }

    public function updateNote(): void
    {
        if (! $this->form->editingNoteId) {
            return;
        }

        $note = $this->playerNoteService->findForPlayer($this->player, $this->form->editingNoteId);
        abort_unless($note !== null, 404);
        $this->authorize('update', $note);

        /** @var array{content: string} $validated */
        $validated = $this->form->validate();

        $updated = $this->playerNoteService->updateForPlayer(
            $this->player,
            $this->form->editingNoteId,
            (int) auth()->id(),
            $validated['content'],
        );

        abort_unless($updated !== null, 404);

        $this->dispatch('player-note-updated');

        $this->form->resetState();
    }

    public function cancelEditing(): void
    {
        $this->form->resetState();
    }

    public function deleteNote(int $noteId): void
    {
        $note = $this->playerNoteService->findForPlayer($this->player, $noteId);
        abort_unless($note !== null, 404);
        $this->authorize('delete', $note);

        $deleted = $this->playerNoteService->deleteForPlayer($this->player, $noteId);

        abort_unless($deleted, 404);

        if ($this->form->editingNoteId === $noteId) {
            $this->form->resetState();
        }

        $this->dispatch('player-note-deleted');

        $this->resetPage('notesPage');
    }

    #[On('player-note-created')]
    #[On('player-note-updated')]
    #[On('player-note-deleted')]
    public function refreshNotesTable(): void
    {
        // Listener hook to make component state/event handling explicit.
    }

    public function render(): View
    {
        return view('livewire.players.player-notes-manager', [
            'notes' => $this->playerNoteService->paginateForPlayer(
                $this->player,
                $this->perPage,
                'notesPage',
                $this->search,
                $this->sortBy,
                $this->sortDirection,
            ),
        ]);
    }
}
