<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nama' => 'rhy0z Dz',
                'email' => 'rhyfk0z@gmail.com',
                'role' => '2',
                'status' => 1,
                'password' => '$2y$10$CZ5UurMeReDG0O/MegqPfOvWTscwY9W9mVnketPwL3YF4dJktbicS',
                'foto' => NULL,
                'created_at' => '2025-04-25 19:51:27',
                'updated_at' => '2025-04-25 19:51:27',
            ),
            1 => 
            array (
                'id' => 2,
                'nama' => 'Administrator',
                'email' => 'superadmin@gmail.com',
                'role' => '1',
                'status' => 1,
                'password' => '$2y$10$VLJ4nrsBHKLH4.jr39XTFe2vFmm5sLVeZW/GH9YRYYVRBoF2K29BC',
                'foto' => NULL,
                'created_at' => '2025-04-25 19:54:01',
                'updated_at' => '2025-04-25 19:54:01',
            ),
            2 => 
            array (
                'id' => 3,
                'nama' => 'rey admin',
                'email' => 'reyhansyah4@mail.com',
                'role' => '1',
                'status' => 1,
                'password' => '$2a$12$.8AW5WHUmUi2Lt5y9tUbuO/0ed0RKTK2B6TdXcXqGdychGdnY9A9q',
                'foto' => NULL,
                'created_at' => '2025-04-25 19:54:01',
                'updated_at' => '2025-04-25 19:54:01',
            ),
            3 => 
            array (
                'id' => 4,
                'nama' => 'reyuser',
                'email' => 'reyuser@gmail.com',
                'role' => '2',
                'status' => 1,
                'password' => '$2y$10$azoGBSqeioIxuWcaujvGO.mESq40EcQwjiNqnhYWbFFlXJ6ODEsfa',
                'foto' => NULL,
                'created_at' => '2025-04-25 19:54:01',
                'updated_at' => '2025-04-25 19:54:01',
            ),
            4 => 
            array (
                'id' => 7,
                'nama' => 'RHYru9 Reyhansyah',
                'email' => 'reyhansyah4@gmail.com',
                'role' => '2',
                'status' => 1,
                'password' => '$2a$12$FWPWskW6N3gUdFRBxD7.WOc3UyYRWP5UAyUPgEww/IaVrSSn2jGjm',
                'foto' => NULL,
                'created_at' => '2025-04-25 23:40:57',
                'updated_at' => '2025-04-25 23:40:57',
            ),
        ));
        
        
    }
}