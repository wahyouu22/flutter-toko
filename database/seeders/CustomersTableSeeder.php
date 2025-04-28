<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // First ensure the user exists
        $userId = DB::table('users')
            ->where('email', 'rhyfk0z@gmail.com')
            ->value('id');

        // If user doesn't exist, create one
        if (!$userId) {
            $userId = DB::table('users')->insertGetId([
                'nama' => 'rhy0z Dz',
                'email' => 'rhyfk0z@gmail.com',
                'password' => Hash::make('password123'), // or use the existing hash if needed
                'role' => 0, // Assuming default role
                'status' => 1,
                'hp' => null,
                'foto' => 'https://lh3.googleusercontent.com/a/ACg8ocLvBEeiRgI8z0VV9kcQZYRtBlyUzFnziMDzLJ8jcPRVGr6BPA=s96-c',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // Now insert or update the customer record
        DB::table('customers')->updateOrInsert(
            ['email' => 'rhyfk0z@gmail.com'],
            [
                'user_id' => $userId,
                'google_id' => 'xxxx',
                'google_token' => 'xxxx',
                'name' => 'rhy0z Dz',
                'email' => 'rhyfk0z@gmail.com',
                'password' => '$2y$10$N8bHWKUJwp2ksOEY5C472.uo564VL4kW4Ew7xR17hxo6B866.5Ou.',
                'hp' => null,
                'alamat' => null,
                'pos' => null,
                'foto' => 'https://lh3.googleusercontent.com/a/ACg8ocLvBEeiRgI8z0VV9kcQZYRtBlyUzFnziMDzLJ8jcPRVGr6BPA=s96-c',
                'remember_token' => null,
                'email_verified_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ]
        );
    }
}
