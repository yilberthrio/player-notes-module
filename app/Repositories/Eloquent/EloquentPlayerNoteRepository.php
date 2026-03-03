<?php

namespace App\Repositories\Eloquent;

use App\Models\PlayerNote;
use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentPlayerNoteRepository implements PlayerNoteRepositoryInterface
{
    public function paginateByPlayer(
        int $playerId,
        int $perPage = 10,
        string $pageName = 'page',
        string $search = '',
        string $sortBy = 'created_at',
        string $sortDirection = 'desc'
    ): LengthAwarePaginator
    {
        $allowedSorts = [
            'id',
            'created_at',
            'updated_at',
        ];

        if (! in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'created_at';
        }

        if (! in_array($sortDirection, ['asc', 'desc'], true)) {
            $sortDirection = 'desc';
        }

        return PlayerNote::query()
            ->where('player_id', $playerId)
            ->with('creator')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($nestedQuery) use ($search): void {
                    $nestedQuery->where('content', 'like', "%{$search}%")
                        ->orWhereHas('creator', function ($creatorQuery) use ($search): void {
                            $creatorQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage, ['*'], $pageName);
    }

    public function findByPlayerAndId(int $playerId, int $noteId): ?PlayerNote
    {
        return PlayerNote::query()
            ->where('player_id', $playerId)
            ->where('id', $noteId)
            ->first();
    }

    public function create(array $attributes): PlayerNote
    {
        return PlayerNote::query()->create($attributes);
    }

    public function update(PlayerNote $playerNote, array $attributes): PlayerNote
    {
        $playerNote->fill($attributes);
        $playerNote->save();

        return $playerNote;
    }

    public function delete(PlayerNote $playerNote): void
    {
        $playerNote->delete();
    }
}
