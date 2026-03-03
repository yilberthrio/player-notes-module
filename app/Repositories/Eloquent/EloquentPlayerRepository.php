<?php

namespace App\Repositories\Eloquent;

use App\Models\Player;
use App\Repositories\Contracts\PlayerRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentPlayerRepository implements PlayerRepositoryInterface
{
    public function paginateWithPerson(
        string $search = '',
        int $perPage = 10,
        string $sortBy = 'id',
        string $sortDirection = 'asc'
    ): LengthAwarePaginator
    {
        $allowedSorts = [
            'id',
            'uuid',
            'notes_count',
            'created_at',
        ];

        if (! in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'id';
        }

        if (! in_array($sortDirection, ['asc', 'desc'], true)) {
            $sortDirection = 'asc';
        }

        return Player::query()
            ->with('person')
            ->withCount('notes')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($nestedQuery) use ($search): void {
                    $nestedQuery->where('uuid', 'like', "%{$search}%")
                        ->orWhereHas('person', function ($personQuery) use ($search): void {
                            $personQuery
                                ->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
                        });
                });
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    public function findOrFail(int $id): Player
    {
        return Player::query()
            ->with('person')
            ->findOrFail($id);
    }
}
