<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    // Disable foreign key checks temporarily
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('users')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $users = [
        [
            'id' => 1, // Explicit ID to reference in other tables
            'nama' => 'Administrator',
            'email' => 'superadmin@gmail.com',
            'role' => 1,
            'status' => 1,
            'password' => Hash::make('password123'),
            'hp' => '081234567890',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // Add other users with explicit IDs
    ];

    foreach ($users as $user) {
        DB::table('users')->insert($user);
    }
}
}
