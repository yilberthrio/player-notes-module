<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'players.view',
            'player-notes.view',
            'player-notes.create',
            'player-notes.update',
            'player-notes.delete',
        ];

        foreach ($permissions as $permissionName) {
            Permission::query()->firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);
        }

        $admin = Role::query()->where('name', 'admin')->where('guard_name', 'web')->first();
        $player = Role::query()->where('name', 'player')->where('guard_name', 'web')->first();
        $consultor = Role::query()->where('name', 'consultor')->where('guard_name', 'web')->first();

        if ($admin) {
            $admin->syncPermissions($permissions);
        }

        if ($player) {
            $player->syncPermissions([
                'players.view',
                'player-notes.view',
            ]);
        }

        if ($consultor) {
            $consultor->syncPermissions([
                'players.view',
                'player-notes.view',
            ]);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
