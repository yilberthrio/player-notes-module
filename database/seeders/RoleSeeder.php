<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->upsert([
            [
                'id' => 1,
                'name' => 'admin',
                'guard_name' => 'web',
                'created_at' => '2026-03-03 01:26:41',
                'updated_at' => '2026-03-03 01:26:41',
            ],
            [
                'id' => 2,
                'name' => 'player',
                'guard_name' => 'web',
                'created_at' => '2026-03-03 01:26:41',
                'updated_at' => '2026-03-03 01:26:41',
            ],
            [
                'id' => 3,
                'name' => 'consultor',
                'guard_name' => 'web',
                'created_at' => '2026-03-03 01:26:41',
                'updated_at' => '2026-03-03 01:26:41',
            ],
        ], ['id'], ['name', 'guard_name', 'created_at', 'updated_at']);
    }
}
