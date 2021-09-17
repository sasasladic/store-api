<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(
            [
                [
                    'name' => 'super-admin',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'user',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'manager',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]
        );
    }
}
