<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class KategoriTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('kategori')->delete();
        
        \DB::table('kategori')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nama_kategori' => 'Brownies',
            ),
            1 => 
            array (
                'id' => 2,
                'nama_kategori' => 'Combro',
            ),
            2 => 
            array (
                'id' => 3,
                'nama_kategori' => 'Dawet',
            ),
            3 => 
            array (
                'id' => 4,
                'nama_kategori' => 'Mochi',
            ),
            4 => 
            array (
                'id' => 5,
                'nama_kategori' => 'Wingko',
            ),
        ));
        
        
    }
}