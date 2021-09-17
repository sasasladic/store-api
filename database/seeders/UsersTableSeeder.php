<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name' => 'Sasa Sladic',
                'email' => 'sasa96.sladic@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('neznam123'),
                'role_id' => 1,
                'active' => 1,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );
    }
}
