<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->find(1)?->syncRoles(['admin']);
        User::query()->find(2)?->syncRoles(['admin']);
        User::query()->find(3)?->syncRoles(['player']);
        User::query()->find(4)?->syncRoles(['player']);
        User::query()->find(5)?->syncRoles(['consultor']);
    }
}
