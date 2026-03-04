<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $defaultPassword = Hash::make('12345678');

        DB::table('users')->upsert([
            [
                'id' => 1,
                'person_id' => 1,
                'name' => 'yilberthandres',
                'email' => 'yilberthgalarza444@gmail.com',
                'email_verified_at' => null,
                'password' => $defaultPassword,
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
                'remember_token' => null,
                'created_at' => '2026-03-03 01:15:48',
                'updated_at' => '2026-03-03 01:15:48',
            ],
            [
                'id' => 2,
                'person_id' => 2,
                'name' => 'admin2',
                'email' => 'yilberth2@gmail.com',
                'email_verified_at' => null,
                'password' => $defaultPassword,
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
                'remember_token' => null,
                'created_at' => '2026-03-03 01:15:48',
                'updated_at' => '2026-03-03 01:15:48',
            ],
            [
                'id' => 3,
                'person_id' => 3,
                'name' => 'player3',
                'email' => 'yilberth3@gmail.com',
                'email_verified_at' => null,
                'password' => $defaultPassword,
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
                'remember_token' => null,
                'created_at' => '2026-03-03 01:15:48',
                'updated_at' => '2026-03-03 01:15:48',
            ],
            [
                'id' => 4,
                'person_id' => 4,
                'name' => 'player4',
                'email' => 'yilberth4@gmail.com',
                'email_verified_at' => null,
                'password' => $defaultPassword,
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
                'remember_token' => null,
                'created_at' => '2026-03-03 01:15:48',
                'updated_at' => '2026-03-03 01:15:48',
            ],
            [
                'id' => 5,
                'person_id' => 5,
                'name' => 'consultor',
                'email' => 'yilberth5@gmail.com',
                'email_verified_at' => null,
                'password' => $defaultPassword,
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
                'remember_token' => null,
                'created_at' => '2026-03-03 01:15:48',
                'updated_at' => '2026-03-03 01:15:48',
            ],
        ], ['id'], [
            'person_id',
            'name',
            'email',
            'email_verified_at',
            'password',
            'two_factor_secret',
            'two_factor_recovery_codes',
            'two_factor_confirmed_at',
            'remember_token',
            'created_at',
            'updated_at',
        ]);
    }
}
