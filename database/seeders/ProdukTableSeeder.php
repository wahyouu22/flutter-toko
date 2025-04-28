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
                'id' => 6,
                'kategori_id' => 2,
                'user_id' => 2,
                'status' => 1,
                'nama_produk' => 'Combro lokal',
                'detail' => '<p>Combro adalah camilan khas Sunda, Jawa Barat, yang terbuat dari singkong parut dengan isian oncom di dalamnya. Nama "combro" sendiri berasal dari kata "oncom di jero" yang berarti "oncom di dalam". Combro digoreng hingga berwarna kecoklatan dan renyah di luar, namun tetap empuk di dalam.&nbsp;</p><p>Berikut adalah deskripsi lebih detail tentang combro:&nbsp;</p><ul><li><strong>Bahan Dasar:</strong> Singkong parut.</li><li><strong>Isian:</strong> Oncom yang sudah dibumbui.</li><li><strong>Bentuk:</strong> Bulat atau oval.</li><li><strong>Cara Memasak:</strong> Digoreng hingga berwarna kecoklatan dan renyah.</li></ul><p>Combro adalah camilan yang populer di Jawa Barat, terutama di kalangan masyarakat Sunda. Banyak orang suka memakannya karena rasanya yang lezat dan gurih.</p>',
                'harga' => '50000.00',
                'stok' => 666,
                'berat' => 0.4,
                'foto' => '20250427015814_680d2cc65a334.jpeg',
                'created_at' => '2025-04-27 01:58:14',
                'updated_at' => '2025-04-27 01:58:22',
            ),
            1 =>
            array (
                'id' => 7,
                'kategori_id' => 5,
                'user_id' => 2,
                'status' => 1,
                'nama_produk' => 'Wingko babat',
                'detail' => '<p>Wingko Babat merupakan makanan tradisional yang berasal dari Lamongan, tepatnya di kecamatan Babat. Makanan ini mempunyai perpaduan rasa manis dan gurih karena terbuat dari kelapa muda, tepung beras ketan, gla pasir, telur, dan air kelapa. Rasanya yang manis dan gurih cocok untuk menemani saat minum teh bersama keluarga. Selain sebagai makanan, Wingko Babat juga mempunyai nilai yang dapat dipetik yaitu bentuknya yang bulat merupaakan simbol dari tekad yang bulat, untuk meraih impian diperlukan tekad yang bulat dan usaha yang tidak mengenal putus asa.</p>',
                'harga' => '15000.00',
                'stok' => 55,
                'berat' => 0.8,
                'foto' => '20250427020125_680d2d85a1bd8.jpeg',
                'created_at' => '2025-04-27 02:01:25',
                'updated_at' => '2025-04-27 02:01:42',
            ),
            2 =>
            array (
                'id' => 8,
                'kategori_id' => 5,
                'user_id' => 2,
                'status' => 1,
                'nama_produk' => 'wingko Babat enak',
                'detail' => '<p><strong>Wingko babat</strong> adalah salah satu&nbsp;makanan tradisional khas Indonesia. <strong>Wingko</strong> babat adalah sejenis kue yang terbuat dari kelapa muda, tepung beras ketan, dan gula pasir.</p><p><strong>Wingko</strong> adalah kudapan yang sangat terkenal di pantai utara pulau Jawa.&nbsp;Kue ini sering dijual di stasiun kereta api, stasiun bus atau juga di took-toko kue oleh-oleh.</p>',
                'harga' => '20000.00',
                'stok' => 456,
                'berat' => 1.0,
                'foto' => '20250427020242_680d2dd27a472.jpg',
                'created_at' => '2025-04-27 02:02:42',
                'updated_at' => '2025-04-27 02:02:42',
            ),
            3 =>
            array (
                'id' => 9,
                'kategori_id' => 2,
                'user_id' => 2,
                'status' => 1,
                'nama_produk' => 'Combro Desa',
                'detail' => '<p>Kota Bogor, yang dijuluki Kota Hujan, tak hanya menawarkan wisata alam yang memesona. Bogor juga merupakan surga bagi para pecinta kuliner. Ragam hidangan lezat dengan cita rasa khas Sunda, dan pengaruh dari berbagai budaya, siap memanjakan lidah para pengunjung.</p><p>Dari jajanan tradisional yang melegenda hingga restoran modern yang kekinian, Bogor memiliki pilihan kuliner yang lengkap. Di antara ragam jajanan tradisional yang menggoda selera, Combro adalah salah satu yang wajib di coba.</p><p>Nama "Combro" sendiri merupakan singkatan dari "oncom di jero" yang berarti "oncom di dalam". Sesuai dengan namanya, combro terbuat dari parutan singkong dan kelapa yang dibentuk bulat atau lonjong dan diisi dengan sambal oncom.&nbsp;<br>&nbsp;</p><p>Combro memiliki tekstur yang menarik, kulit luarnya memiliki sensasi sedikit renyah. Sementara bagian dalamnya yang berisi oncom terasa gurih dan sedikit pedas.<br>&nbsp;</p><p>Popularitas combro di Bogor tak perlu diragukan lagi. Jajanan ini mudah ditemukan di berbagai sudut kota, mulai dari gerobak kaki lima hingga kedai-kedai jajanan tradisional. Harganya yang terjangkau dan kelezatannya yang tak terbantahkan, menjadikan combro sebagai pilihan jajanan yang tak boleh dilewatkan saat berkunjung ke Bogor.&nbsp;<br>&nbsp;</p><p>Salah satu tempat yang bisa dikunjungi adalah kawasan Suryakencana Bogor. Disepanjang jalan ini anda bisa menemukan beberapa gerobak penjual Combro. Harga satuannya&nbsp; Rp. 4.000,- dan kelezatannya yang tak terbantahkan menjadikan combro sebagai pilihan jajanan yang tak boleh dilewatkan saat berkunjung ke Bogor.</p>',
                'harga' => '4000.00',
                'stok' => 5532,
                'berat' => 0.2,
                'foto' => '20250427020552_680d2e903f59c.jpg',
                'created_at' => '2025-04-27 02:05:52',
                'updated_at' => '2025-04-27 02:05:52',
            ),
            4 =>
            array (
                'id' => 10,
                'kategori_id' => 2,
                'user_id' => 2,
                'status' => 1,
                'nama_produk' => 'Combro Maknyusss',
                'detail' => '<p>Kota Bogor, yang dijuluki Kota Hujan, tak hanya menawarkan wisata alam yang memesona. Bogor juga merupakan surga bagi para pecinta kuliner. Ragam hidangan lezat dengan cita rasa khas Sunda, dan pengaruh dari berbagai budaya, siap memanjakan lidah para pengunjung.</p><p>Dari jajanan tradisional yang melegenda hingga restoran modern yang kekinian, Bogor memiliki pilihan kuliner yang lengkap. Di antara ragam jajanan tradisional yang menggoda selera, Combro adalah salah satu yang wajib di coba.</p><p>Nama "Combro" sendiri merupakan singkatan dari "oncom di jero" yang berarti "oncom di dalam". Sesuai dengan namanya, combro terbuat dari parutan singkong dan kelapa yang dibentuk bulat atau lonjong dan diisi dengan sambal oncom.&nbsp;<br>&nbsp;</p><p>Combro memiliki tekstur yang menarik, kulit luarnya memiliki sensasi sedikit renyah. Sementara bagian dalamnya yang berisi oncom terasa gurih dan sedikit pedas.<br>&nbsp;</p><p>Popularitas combro di Bogor tak perlu diragukan lagi. Jajanan ini mudah ditemukan di berbagai sudut kota, mulai dari gerobak kaki lima hingga kedai-kedai jajanan tradisional. Harganya yang terjangkau dan kelezatannya yang tak terbantahkan, menjadikan combro sebagai pilihan jajanan yang tak boleh dilewatkan saat berkunjung ke Bogor.&nbsp;<br>&nbsp;</p><p>Salah satu tempat yang bisa dikunjungi adalah kawasan Suryakencana Bogor. Disepanjang jalan ini anda bisa menemukan beberapa gerobak penjual Combro. Harga satuannya&nbsp; Rp. 4.000,- dan kelezatannya yang tak terbantahkan menjadikan combro sebagai pilihan jajanan yang tak boleh dilewatkan saat berkunjung ke Bogor.</p>',
                'harga' => '5000.00',
                'stok' => 344,
                'berat' => 0.2,
                'foto' => '20250427020639_680d2ebf08ce6.jpg',
                'created_at' => '2025-04-27 02:06:39',
                'updated_at' => '2025-04-27 02:06:39',
            ),
            5 =>
            array (
                'id' => 11,
                'kategori_id' => 5,
                'user_id' => 2,
                'status' => 1,
                'nama_produk' => 'Wingko khas Babat',
                'detail' => '<p>Wingko Babat kue tradisional yang terbuat dari kelapa muda, tepung ketan, dan gula, dikenal sebagai makanan khas Lamongan, Jawa Timur. Dirangkum dari goodnewsfromindonesia.id, Asal-usulnya dimulai pada awal abad ke-20, ketika Loe Soe Siang, seorang keturunan Tiongkok, pertama kali membuat wingko sebagai komoditas di Lamongan sekitar tahun 1900-an.</p><p>Namun, perjalanan Wingko ini berlanjut ke Semarang. Pada 1944, karena situasi yang tidak aman setelah kekalahan Jepang, keturunan Loe Soe Siang, Loe Lan Hwa, beserta suami dan dua anaknya pindah ke Semarang. Di kota ini, mereka mulai menjual Wingko dengan cara berkeliling dari rumah ke rumah dan menitipkannya di kios sekitar stasiun dan terminal. Keunikan dan rasa wingko yang gurih membuat kue ini cepat populer di Semarang, hingga akhirnya dikenal sebagai oleh-oleh khas kota tersebut.</p>',
                'harga' => '20000.00',
                'stok' => 344,
                'berat' => 0.8,
                'foto' => '20250427021040_680d2fb0bfde5.jpg',
                'created_at' => '2025-04-27 02:10:40',
                'updated_at' => '2025-04-27 02:10:40',
            ),
            6 =>
            array (
                'id' => 12,
                'kategori_id' => 1,
                'user_id' => 2,
                'status' => 1,
                'nama_produk' => 'Brownies yumyyy',
                'detail' => '<p>Brownies adalah kue panggang berbentuk persegi atau persegi panjang yang memiliki tekstur lembut dan padat di bagian dalam. Dengan rasa cokelat yang kuat dan manis, brownies sering menjadi pilihan camilan favorit untuk berbagai acara, dari pesta kecil hingga hidangan penutup sehari-hari.</p>',
                'harga' => '50000.00',
                'stok' => 50,
                'berat' => 0.8,
                'foto' => '20250427021426_680d309235624.jpg',
                'created_at' => '2025-04-27 02:14:26',
                'updated_at' => '2025-04-27 02:14:26',
            ),
            7 =>
            array (
                'id' => 13,
                'kategori_id' => 1,
                'user_id' => 2,
                'status' => 1,
                'nama_produk' => 'brownis slurlppppppp',
                'detail' => '<p>Brownies adalah karya seni kuliner berbahan dasar cokelat yang kaya, menggabungkan kelembutan, kekenyalan, dan sedikit kerapuhan di bagian atasnya. Setiap gigitan menawarkan keseimbangan sempurna antara rasa manis dan pahit, menjadikan brownies suguhan istimewa yang mampu memanjakan lidah dan menghadirkan kehangatan dalam setiap momen.</p>',
                'harga' => '100000.00',
                'stok' => 164,
                'berat' => 1.0,
                'foto' => '20250427021623_680d31078ce9d.png',
                'created_at' => '2025-04-27 02:16:23',
                'updated_at' => '2025-04-27 02:16:23',
            ),
            8 =>
            array (
                'id' => 14,
                'kategori_id' => 1,
                'user_id' => 2,
                'status' => 1,
                'nama_produk' => 'Brownis khas Jakarta',
                'detail' => '<p>Brownies itu kayak teman baik — manis, lembut, dan selalu bisa bikin suasana hati jadi lebih baik. Perpaduan rasa cokelat yang nendang dengan tekstur chewy-nya bikin brownies cocok banget buat teman ngopi, nonton film, atau sekadar ngemil santai kapan aja.</p>',
                'harga' => '120000.00',
                'stok' => 156,
                'berat' => 1.4,
                'foto' => '20250427021814_680d3176366e7.jpg',
                'created_at' => '2025-04-27 02:18:14',
                'updated_at' => '2025-04-27 02:18:14',
            ),
            9 =>
            array (
                'id' => 15,
                'kategori_id' => 3,
                'user_id' => 2,
                'status' => 1,
                'nama_produk' => 'Dawet Segerrrrr',
                'detail' => '<p>Dawet adalah minuman khas Indonesia yang terbuat dari campuran cendol berbahan tepung beras, santan segar, dan kuah gula merah. Rasanya manis dan gurih, dengan sensasi segar yang cocok dinikmati saat cuaca panas.</p>',
                'harga' => '7000.00',
                'stok' => 544,
                'berat' => 0.3,
                'foto' => '20250427022313_680d32a1c880f.jpg',
                'created_at' => '2025-04-27 02:23:13',
                'updated_at' => '2025-04-27 02:23:13',
            ),
            10 =>
            array (
                'id' => 16,
                'kategori_id' => 3,
                'user_id' => 2,
                'status' => 1,
                'nama_produk' => 'dawet kota',
                'detail' => '<p>Dawet, dengan cendol kenyal berwarna hijau, berpadu dengan santan yang creamy dan manis legitnya gula aren, menghadirkan rasa autentik yang menggoda. Setiap tegukan dawet memberi kesejukan alami dan kenikmatan tradisi Nusantara dalam satu gelas.</p>',
                'harga' => '8000.00',
                'stok' => 342,
                'berat' => 0.2,
                'foto' => '20250427022419_680d32e367ff6.jpg',
                'created_at' => '2025-04-27 02:24:19',
                'updated_at' => '2025-04-27 02:24:19',
            ),
            11 =>
            array (
                'id' => 17,
                'kategori_id' => 3,
                'user_id' => 2,
                'status' => 1,
                'nama_produk' => 'ES Dawet Alami',
                'detail' => '<p>Dawet itu minuman segar yang isinya cendol kenyal, santan gurih, sama gula merah manis. Cocok banget buat pelepas dahaga pas siang bolong, rasanya langsung adem di badan dan bikin ketagihan!</p>',
                'harga' => '10000.00',
                'stok' => 213,
                'berat' => 0.2,
                'foto' => '20250427022512_680d331892a84.jpg',
                'created_at' => '2025-04-27 02:25:12',
                'updated_at' => '2025-04-27 02:25:12',
            ),
        ));


    }
}
