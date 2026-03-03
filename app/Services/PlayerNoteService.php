<?php

namespace App\Services;

use App\Models\Player;
use App\Models\PlayerNote;
use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PlayerNoteService
{
    public function __construct(private readonly PlayerNoteRepositoryInterface $playerNoteRepository)
    {
    }

    public function paginateForPlayer(
        Player $player,
        int $perPage = 10,
        string $pageName = 'page',
        string $search = '',
        string $sortBy = 'created_at',
        string $sortDirection = 'desc'
    ): LengthAwarePaginator
    {
        return $this->playerNoteRepository->paginateByPlayer(
            (int) $player->id,
            $perPage,
            $pageName,
            $search,
            $sortBy,
            $sortDirection,
        );
    }

    public function createForPlayer(Player $player, int $authorId, string $content): PlayerNote
    {
        return $this->playerNoteRepository->create([
            'player_id' => (int) $player->id,
            'content' => trim($content),
            'created_by' => $authorId,
            'updated_by' => $authorId,
        ]);
    }

    public function findForPlayer(Player $player, int $noteId): ?PlayerNote
    {
        return $this->playerNoteRepository->findByPlayerAndId((int) $player->id, $noteId);
    }

    public function updateForPlayer(Player $player, int $noteId, int $authorId, string $content): ?PlayerNote
    {
        $note = $this->findForPlayer($player, $noteId);

        if (! $note) {
            return null;
        }

        return $this->playerNoteRepository->update($note, [
            'content' => trim($content),
            'updated_by' => $authorId,
        ]);
    }

    public function deleteForPlayer(Player $player, int $noteId): bool
    {
        $note = $this->findForPlayer($player, $noteId);

        if (! $note) {
            return false;
        }

        $this->playerNoteRepository->delete($note);

        return true;
    }
}
