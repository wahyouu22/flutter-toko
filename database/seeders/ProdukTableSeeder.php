<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProdukTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('produk')->delete();
        
        \DB::table('produk')->insert(array (
            0 => 
            array (
                'id' => 1,
                'kategori_id' => 2,
                'user_id' => 3,
                'status' => 1,
                'nama_produk' => 'Combro Asik',
                'detail' => '<p>Combro mantap</p>',
                'harga' => '5000.00',
                'stok' => 99,
                'berat' => 0.3,
                'foto' => '20250425205142_680b936ebc440.jpeg',
                'created_at' => '2025-04-25 20:51:42',
                'updated_at' => '2025-04-25 20:52:23',
            ),
            1 => 
            array (
                'id' => 2,
                'kategori_id' => 5,
                'user_id' => 3,
                'status' => 1,
                'nama_produk' => 'Wingko Babat',
                'detail' => '<p>Wingko Hidangan, manisan</p>',
                'harga' => '15000.00',
                'stok' => 78,
                'berat' => 0.5,
                'foto' => '20250425205303_680b93bfcf8ac.jpeg',
                'created_at' => '2025-04-25 20:53:03',
                'updated_at' => '2025-04-25 20:53:22',
            ),
            2 => 
            array (
                'id' => 3,
                'kategori_id' => 5,
                'user_id' => 3,
                'status' => 1,
                'nama_produk' => 'wingko',
                'detail' => '<p>test wingko 2</p>',
                'harga' => '5000.00',
                'stok' => 67,
                'berat' => 0.3,
                'foto' => '20250425210116_680b95ac9b697.jpg',
                'created_at' => '2025-04-25 21:01:16',
                'updated_at' => '2025-04-25 21:21:21',
            ),
            3 => 
            array (
                'id' => 5,
                'kategori_id' => 4,
                'user_id' => 3,
                'status' => 1,
                'nama_produk' => 'mochi enak',
                'detail' => '<p>aaaa</p>',
                'harga' => '60000.00',
                'stok' => 4,
                'berat' => 0.5,
                'foto' => '20250425212417_680b9b110450d.jpg',
                'created_at' => '2025-04-25 21:24:17',
                'updated_at' => '2025-04-25 21:24:22',
            ),
        ));
        
        
    }
}