<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('players')->upsert([
            [
                'id' => 1,
                'uuid' => '677678',
                'person_id' => 3,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'uuid' => '768778',
                'person_id' => 4,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 3,
                'uuid' => '988797',
                'person_id' => 5,
                'created_at' => null,
                'updated_at' => null,
            ],
        ], ['id'], ['uuid', 'person_id', 'created_at', 'updated_at']);
    }
}
