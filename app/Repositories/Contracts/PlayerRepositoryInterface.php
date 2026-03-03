<?php

namespace App\Repositories\Contracts;

use App\Models\Player;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PlayerRepositoryInterface
{
    public function paginateWithPerson(
        string $search = '',
        int $perPage = 10,
        string $sortBy = 'id',
        string $sortDirection = 'asc'
    ): LengthAwarePaginator;

    public function findOrFail(int $id): Player;
}
