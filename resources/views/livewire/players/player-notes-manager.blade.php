<section class="w-full p-6 space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <a href="{{ route('players.index') }}" wire:navigate class="text-sm text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100">
                ← Back to players
            </a>
            <h1 class="mt-2 text-2xl font-semibold text-zinc-900 dark:text-zinc-100">Player Notes</h1>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                Player: {{ trim(($player->person?->first_name ?? '').' '.($player->person?->last_name ?? '')) }}
                · UUID: {{ $player->uuid }}
            </p>
        </div>
    </div>

    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
        <div class="sm:col-span-2">
            <label for="notes-search" class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Search notes</label>
            <input
                id="notes-search"
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Content or author"
                class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100"
            >
        </div>
        <div>
            <label for="notes-per-page" class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Rows</label>
            <select
                id="notes-per-page"
                wire:model.live="perPage"
                class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100"
            >
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
    </div>

    @can('create', \App\Models\PlayerNote::class)
        @if (! $form->editingNoteId)
            <form wire:submit="createNote" class="space-y-3 rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                <label for="note-content" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">New note</label>
                <textarea
                    id="note-content"
                    wire:model.live.debounce.150ms="form.content"
                    rows="4"
                    maxlength="{{ $contentMaxLength }}"
                    placeholder="Write an internal note..."
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100"
                ></textarea>
                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                    {{ max(0, $contentMaxLength - mb_strlen($form->content)) }} characters remaining
                </p>
                @error('form.content')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <button type="submit" class="inline-flex rounded-md bg-zinc-900 px-3 py-2 text-sm font-medium text-white hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                    Save note
                </button>
            </form>
        @endif
    @endcan

    <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
            <thead class="bg-zinc-50 dark:bg-zinc-800">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-zinc-600 dark:text-zinc-300">
                        <button type="button" wire:click="sort('created_at')" class="inline-flex items-center gap-1 hover:text-zinc-900 dark:hover:text-zinc-100">
                            Date
                            @if ($sortBy === 'created_at')
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </button>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-zinc-600 dark:text-zinc-300">Author</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-zinc-600 dark:text-zinc-300">Content</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-zinc-600 dark:text-zinc-300">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @forelse ($notes as $note)
                    <tr>
                        <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-200">{{ $note->created_at?->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-200">{{ $note->creator?->name ?? 'System' }}</td>
                        <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-200">
                            @if ($form->editingNoteId === $note->id)
                                <div class="space-y-2">
                                    <textarea
                                        wire:model.live.debounce.150ms="form.content"
                                        rows="4"
                                        maxlength="{{ $contentMaxLength }}"
                                        class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100"
                                    ></textarea>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ max(0, $contentMaxLength - mb_strlen($form->content)) }} characters remaining
                                    </p>
                                    @error('form.content')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            @else
                                <p class="whitespace-pre-line">{{ $note->content }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex flex-wrap gap-2">
                                @if ($form->editingNoteId === $note->id)
                                    @can('update', $note)
                                        <button
                                            type="button"
                                            wire:click="updateNote"
                                            class="inline-flex rounded-md bg-zinc-900 px-3 py-1.5 text-xs font-medium text-white hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300"
                                        >
                                            Update
                                        </button>
                                    @endcan
                                    <button
                                        type="button"
                                        wire:click="cancelEditing"
                                        class="inline-flex rounded-md border border-zinc-300 px-3 py-1.5 text-xs font-medium text-zinc-700 hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800"
                                    >
                                        Cancel
                                    </button>
                                @else
                                    @can('update', $note)
                                        <button
                                            type="button"
                                            wire:click="startEditing({{ $note->id }})"
                                            class="inline-flex rounded-md border border-zinc-300 px-3 py-1.5 text-xs font-medium text-zinc-700 hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800"
                                        >
                                            Edit
                                        </button>
                                    @endcan
                                @endif

                                @can('delete', $note)
                                    <button
                                        type="button"
                                        wire:click="deleteNote({{ $note->id }})"
                                        onclick="if (!confirm('Delete this note?')) { event.stopImmediatePropagation(); }"
                                        class="inline-flex rounded-md border border-red-300 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-50 dark:border-red-900 dark:text-red-400 dark:hover:bg-red-950"
                                    >
                                        Delete
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-sm text-zinc-500 dark:text-zinc-400">
                            No notes found for this player.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $notes->links() }}
    </div>
</section>
