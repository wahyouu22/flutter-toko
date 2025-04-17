<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kategori;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'Administrator',
            'email' => 'superadmin@gmail.com',
            'role' => '1',
            'status' => 1, 
            'hp' => '0812345678901', 
            'password' => bcrypt('superadmin123'),
        ]);
    

        User::create([ 
        'nama' => 'Sopian Aji', 
        'email' => 'sopian4ji@gmail.com', 
        'role' => '0', 
        'status' => 1, 
        'hp' => '081234567892', 
        'password' => bcrypt('admin123'), 
        ]); 

        User::create([ 
            'nama' => 'Haja', 
            'email' => 'haja@gmail.com', 
            'role' => '2', 
            'status' => 0, 
            'hp' => '08126374923', 
            'password' => bcrypt('costumer123'), 
            ]); 
            # Data Kategori
            Kategori::create([ 
                'nama_kategori' => 'Brownies', 
            ]); 
                Kategori::create([ 
                'nama_kategori' => 'Combro', 
            ]); 
                Kategori::create([ 
                'nama_kategori' => 'Dawet', 
            ]); 
                Kategori::create([ 
                'nama_kategori' => 'Mochi', 
            ]); 
                Kategori::create([ 
                'nama_kategori' => 'Wingko', 
            ]); 
    } 
} 