<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('employees')->upsert([
            [
                'id' => 1,
                'person_id' => 1,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'person_id' => 2,
                'created_at' => null,
                'updated_at' => null,
            ],
        ], ['id'], ['person_id', 'created_at', 'updated_at']);
    }
}
