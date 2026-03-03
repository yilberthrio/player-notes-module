<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('persons')->upsert([
            [
                'id' => 1,
                'first_name' => 'Yilberth',
                'middle_name' => '',
                'last_name' => 'Galarza',
                'second_last_name' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'first_name' => 'Andres',
                'middle_name' => '',
                'last_name' => 'Vanegas',
                'second_last_name' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 3,
                'first_name' => 'Marco',
                'middle_name' => '',
                'last_name' => 'Polo',
                'second_last_name' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 4,
                'first_name' => 'Juan',
                'middle_name' => '',
                'last_name' => 'Diaz',
                'second_last_name' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 5,
                'first_name' => 'Luisa',
                'middle_name' => '',
                'last_name' => 'Reyes',
                'second_last_name' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ], ['id'], ['first_name', 'middle_name', 'last_name', 'second_last_name', 'created_at', 'updated_at']);
    }
}
