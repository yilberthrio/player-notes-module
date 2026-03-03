<?php

namespace App\Repositories\Contracts;

use App\Models\PlayerNote;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PlayerNoteRepositoryInterface
{
    public function paginateByPlayer(
        int $playerId,
        int $perPage = 10,
        string $pageName = 'page',
        string $search = '',
        string $sortBy = 'created_at',
        string $sortDirection = 'desc'
    ): LengthAwarePaginator;

    public function findByPlayerAndId(int $playerId, int $noteId): ?PlayerNote;

    /**
     * @param array<string, mixed> $attributes
     */
    public function create(array $attributes): PlayerNote;

    /**
     * @param array<string, mixed> $attributes
     */
    public function update(PlayerNote $playerNote, array $attributes): PlayerNote;

    public function delete(PlayerNote $playerNote): void;
}
