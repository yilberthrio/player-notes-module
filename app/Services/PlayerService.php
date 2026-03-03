<?php

namespace App\Services;

use App\Repositories\Contracts\PlayerRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PlayerService
{
    public function __construct(private readonly PlayerRepositoryInterface $playerRepository)
    {
    }

    public function paginatePlayers(
        string $search = '',
        int $perPage = 10,
        string $sortBy = 'id',
        string $sortDirection = 'asc'
    ): LengthAwarePaginator
    {
        return $this->playerRepository->paginateWithPerson($search, $perPage, $sortBy, $sortDirection);
    }
}
