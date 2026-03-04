<?php

namespace Tests\Feature\Players;

use App\Livewire\Players\PlayerNotesManager;
use App\Models\Person;
use App\Models\Player;
use App\Models\PlayerNote;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class PlayerNotesTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_user_can_create_a_player_note(): void
    {
        $this->seedPlayerNotePermissions();

        $user = User::factory()->create();
        $user->givePermissionTo('player-notes.create');

        $player = $this->createPlayer();

        $this->assertDatabaseCount('player_notes', 0);

        Livewire::actingAs($user)
            ->test(PlayerNotesManager::class, ['player' => $player])
            ->set('form.content', 'Internal support note for this player.')
            ->call('createNote')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('player_notes', [
            'player_id' => (int) $player->id,
            'content' => 'Internal support note for this player.',
            'created_by' => (int) $user->id,
            'updated_by' => (int) $user->id,
        ]);

        $this->assertDatabaseCount('player_notes', 1);
    }

    public function test_consultor_cannot_create_player_notes(): void
    {
        $this->seedPlayerNotePermissions();
        $consultor = $this->createConsultorUser();
        $player = $this->createPlayer();

        Livewire::actingAs($consultor)
            ->test(PlayerNotesManager::class, ['player' => $player])
            ->set('form.content', 'This note should not be created.')
            ->call('createNote')
            ->assertForbidden();

        $this->assertDatabaseCount('player_notes', 0);
    }

    public function test_consultor_cannot_update_player_notes(): void
    {
        $this->seedPlayerNotePermissions();
        $consultor = $this->createConsultorUser();
        $player = $this->createPlayer();
        $author = User::factory()->create();

        $note = PlayerNote::query()->create([
            'player_id' => (int) $player->id,
            'content' => 'Original content',
            'created_by' => (int) $author->id,
            'updated_by' => (int) $author->id,
        ]);

        Livewire::actingAs($consultor)
            ->test(PlayerNotesManager::class, ['player' => $player])
            ->set('form.editingNoteId', (int) $note->id)
            ->set('form.content', 'Updated content by consultor')
            ->call('updateNote')
            ->assertForbidden();

        $this->assertDatabaseHas('player_notes', [
            'id' => (int) $note->id,
            'content' => 'Original content',
        ]);
    }

    public function test_consultor_cannot_delete_player_notes(): void
    {
        $this->seedPlayerNotePermissions();
        $consultor = $this->createConsultorUser();
        $player = $this->createPlayer();
        $author = User::factory()->create();

        $note = PlayerNote::query()->create([
            'player_id' => (int) $player->id,
            'content' => 'Existing note',
            'created_by' => (int) $author->id,
            'updated_by' => (int) $author->id,
        ]);

        Livewire::actingAs($consultor)
            ->test(PlayerNotesManager::class, ['player' => $player])
            ->call('deleteNote', (int) $note->id)
            ->assertForbidden();

        $this->assertDatabaseHas('player_notes', [
            'id' => (int) $note->id,
        ]);
    }

    private function seedPlayerNotePermissions(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach ([
            'player-notes.view',
            'player-notes.create',
            'player-notes.update',
            'player-notes.delete',
        ] as $permissionName) {
            Permission::query()->firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);
        }
    }

    private function createConsultorUser(): User
    {
        $consultorRole = Role::query()->firstOrCreate([
            'name' => 'consultor',
            'guard_name' => 'web',
        ]);

        $consultorRole->syncPermissions([
            'player-notes.view',
        ]);

        $user = User::factory()->create();
        $user->assignRole($consultorRole);

        return $user;
    }

    private function createPlayer(): Player
    {
        $person = Person::query()->create([
            'first_name' => 'Marco',
            'middle_name' => null,
            'last_name' => 'Polo',
            'second_last_name' => null,
        ]);

        return Player::query()->create([
            'uuid' => (string) Str::uuid(),
            'person_id' => (int) $person->id,
        ]);
    }
}
