<?php

namespace App\Livewire\Forms;

use App\Http\Requests\PlayerNotes\StorePlayerNoteRequest;
use App\Models\PlayerNote;
use Livewire\Form;

class PlayerNoteForm extends Form
{
    public ?int $editingNoteId = null;

    public string $content = '';

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return StorePlayerNoteRequest::rulesDefinition();
    }

    public function setFromNote(PlayerNote $playerNote): void
    {
        $this->editingNoteId = (int) $playerNote->id;
        $this->content = $playerNote->content;
    }

    public function resetState(): void
    {
        $this->reset(['editingNoteId', 'content']);
    }
}
