<section class="w-full p-6">
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">Players</h1>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">Search and open player note history.</p>
        </div>

        <div class="grid w-full gap-3 sm:grid-cols-2 lg:w-auto">
            <div class="w-full sm:w-80">
                <label for="player-search" class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Search</label>
                <input
                    id="player-search"
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Name or UUID"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm text-zinc-900 focus:border-zinc-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100"
                >
            </div>
            <div class="w-full sm:w-36">
                <label for="players-per-page" class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Rows</label>
                <select
                    id="players-per-page"
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
    </div>

    <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
            <thead class="bg-zinc-50 dark:bg-zinc-800">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-zinc-600 dark:text-zinc-300">
                        <button type="button" wire:click="sort('id')" class="inline-flex items-center gap-1 hover:text-zinc-900 dark:hover:text-zinc-100">
                            ID
                            @if ($sortBy === 'id')
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </button>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-zinc-600 dark:text-zinc-300">
                        <button type="button" wire:click="sort('uuid')" class="inline-flex items-center gap-1 hover:text-zinc-900 dark:hover:text-zinc-100">
                            UUID
                            @if ($sortBy === 'uuid')
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </button>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-zinc-600 dark:text-zinc-300">Player</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-zinc-600 dark:text-zinc-300">
                        <button type="button" wire:click="sort('notes_count')" class="inline-flex items-center gap-1 hover:text-zinc-900 dark:hover:text-zinc-100">
                            Notes
                            @if ($sortBy === 'notes_count')
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </button>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-zinc-600 dark:text-zinc-300">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @forelse ($players as $player)
                    <tr>
                        <td class="px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100">{{ $player->id }}</td>
                        <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-200">{{ $player->uuid }}</td>
                        <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-200">
                            {{ trim(($player->person?->first_name ?? '').' '.($player->person?->last_name ?? '')) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-200">{{ $player->notes_count }}</td>
                        <td class="px-4 py-3 text-sm">
                            <a
                                href="{{ route('players.notes', $player) }}"
                                wire:navigate
                                class="inline-flex rounded-md bg-zinc-900 px-3 py-1.5 text-xs font-medium text-white hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300"
                            >
                                View Notes
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-sm text-zinc-500 dark:text-zinc-400">
                            No players found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $players->links() }}
    </div>
</section>
