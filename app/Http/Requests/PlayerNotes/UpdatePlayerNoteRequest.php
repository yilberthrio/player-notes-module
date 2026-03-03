<?php

namespace App\Http\Requests\PlayerNotes;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlayerNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->can('player-notes.update');
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return StorePlayerNoteRequest::rulesDefinition();
    }
}
