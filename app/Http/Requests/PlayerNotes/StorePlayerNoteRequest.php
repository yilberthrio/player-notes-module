<?php

namespace App\Http\Requests\PlayerNotes;

use Illuminate\Foundation\Http\FormRequest;

class StorePlayerNoteRequest extends FormRequest
{
    public const CONTENT_MAX_LENGTH = 300;

    public function authorize(): bool
    {
        return (bool) $this->user()?->can('player-notes.create');
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return self::rulesDefinition();
    }

    /**
     * @return array<string, mixed>
     */
    public static function rulesDefinition(): array
    {
        return [
            'content' => ['required', 'string', 'max:'.self::CONTENT_MAX_LENGTH],
        ];
    }
}
