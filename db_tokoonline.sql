-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 13 Apr 2025 pada 07.43
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tokoonline`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `foto_produk`
--

CREATE TABLE `foto_produk` (
  `id` bigint UNSIGNED NOT NULL,
  `produk_id` bigint UNSIGNED NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(1, 'Brownies'),
(2, 'Mochi'),
(3, 'Sumayyah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_user_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_11_25_131047_create_kategori_table', 1),
(6, '2024_12_02_204856_create_produk_table', 1),
(7, '2024_12_04_190455_create_foto_produk_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` bigint UNSIGNED NOT NULL,
  `kategori_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL,
  `nama_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `stok` int NOT NULL,
  `berat` double(8,2) NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `kategori_id`, `user_id`, `status`, `nama_produk`, `detail`, `harga`, `stok`, `berat`, `foto`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 'Mochi Cokelat', '<p>Camilan sempurna untuk para pencinta cokelat! Mochi ini memiliki isian cokelat yang lumer di mulut, menciptakan perpaduan sempurna antara tekstur kenyal dan rasa manis yang memanjakan lidah. Kelezatan cokelat yang kaya berpadu dengan kelembutan mochi, menjadikannya pilihan ideal untuk menikmati manisnya hari dengan cara yang lebih spesial.</p>', '5000.00', 25, 60.00, '20250413101054_67fb2b3eca6c9.jpg', '2025-04-13 03:10:55', '2025-04-13 03:33:34'),
(2, 2, 1, 1, 'Mochi Strawberry', '<p>Perpaduan mochi kenyal dengan isian strawberry yang manis dan sedikit asam menciptakan rasa yang segar dan menggugah selera. Sensasi rasa alami dari buah strawberry yang segar membuat setiap gigitan terasa ringan dan menyenangkan. Mochi ini cocok bagi kamu yang menginginkan camilan dengan sentuhan rasa buah yang autentik dan menyegarkan.</p>', '5000.00', 20, 60.00, '20250413101214_67fb2b8eb0e0d.jpg', '2025-04-13 03:12:15', '2025-04-13 03:32:55'),
(3, 2, 1, 1, 'Mochi Matcha', '<p>Dibuat dengan matcha premium pilihan, mochi ini menghadirkan perpaduan rasa manis dengan sedikit pahit khas teh hijau Jepang yang begitu menggoda. Teksturnya yang lembut dan kenyal berpadu dengan isian matcha yang creamy, memberikan sensasi relaksasi dan kenikmatan dalam satu gigitan. Cocok bagi pecinta matcha yang menginginkan keseimbangan rasa dalam camilan tradisional khas Jepang ini.</p>', '5000.00', 24, 60.00, '20250413101317_67fb2bcd095d3.jpg', '2025-04-13 03:13:17', '2025-04-13 03:32:41'),
(5, 2, 1, 0, 'Mochi Blueberry', '<p>Mochi dengan isian blueberry yang segar dan sedikit asam ini memberikan keseimbangan rasa yang unik dan menyegarkan. Setiap gigitan menghadirkan sensasi buah blueberry yang juicy dan alami, berpadu dengan tekstur mochi yang lembut dan kenyal. Cocok bagi kamu yang menyukai rasa buah yang segar dengan sentuhan kelembutan khas mochi.</p>', '5000.00', 0, 60.00, '20250413101636_67fb2c9469cd4.png', '2025-04-13 03:16:37', '2025-04-13 07:41:31'),
(6, 2, 1, 1, 'Mochi Durian', '<p>Mochi dengan isian durian yang creamy dan beraroma khas ini menghadirkan sensasi kenikmatan yang autentik bagi para pecinta durian. Tekstur mochi yang lembut dan kenyal berpadu sempurna dengan isian durian yang manis dan legit, memberikan pengalaman menikmati durian dalam bentuk yang lebih praktis dan elegan.</p>', '5000.00', 22, 60.00, '20250413101750_67fb2cde29fde.jpg', '2025-04-13 03:17:50', '2025-04-13 03:32:03'),
(7, 2, 1, 1, 'Mochi Oreo', '<p>Kombinasi unik antara mochi kenyal dengan isian krim oreo yang lembut dan taburan remahan biskuit renyah menjadikan varian ini salah satu favorit banyak orang. Setiap gigitan menghadirkan sensasi manis, creamy, dan sedikit renyah dari biskuit yang khas. Mochi oreo ini adalah pilihan yang sempurna bagi kamu yang ingin menikmati camilan dengan rasa yang modern dan kekinian.</p>', '5000.00', 23, 60.00, '20250413101903_67fb2d27ce383.jpg', '2025-04-13 03:19:04', '2025-04-13 03:31:37'),
(8, 2, 1, 1, 'Mochi Original', '<p>Menghadirkan kelezatan mochi dalam bentuk paling autentik, varian original ini mempertahankan cita rasa klasik dengan tekstur yang lembut dan kenyal. Dengan rasa yang sederhana namun tetap menggugah selera. Isian Cream Kacang Merah sangat cocok untuk di nikmati oleh kamu yang suka cita rasa original</p>', '5000.00', 17, 60.00, '20250413102135_67fb2dbfbf6fa.jpg', '2025-04-13 03:21:35', '2025-04-13 03:31:09'),
(9, 1, 1, 1, 'Brownies Keju', '<p>Perpaduan sempurna antara brownies cokelat yang lembut dengan keju yang gurih dan creamy, menciptakan cita rasa unik yang menggoda. Keju yang gurih dan manis menambah lapisan kelezatan yang sulit ditolak. Brownies keju ini cocok bagi kamu yang menginginkan perpaduan antara manisnya cokelat dan sedikit rasa asin yang khas dari keju, memberikan pengalaman makan yang lebih kaya dan memuaskan.</p>', '40000.00', 15, 600.00, '20250413102444_67fb2e7cdf3e7.jpg', '2025-04-13 03:24:45', '2025-04-13 03:29:00'),
(10, 1, 1, 1, 'Brownies Original', '<p>Brownies klasik dengan tekstur yang lembut, moist, dan penuh dengan rasa cokelat yang kaya. Setiap gigitannya menghadirkan kelezatan manis yang lumer di mulut, membuatnya menjadi pilihan sempurna bagi pecinta cokelat. Tanpa tambahan topping atau isian, brownies original ini tetap mampu mencuri perhatian dengan cita rasa autentiknya yang selalu bikin ketagihan.</p>', '40000.00', 19, 600.00, '20250413102551_67fb2ebfa2667.jpg', '2025-04-13 03:25:51', '2025-04-13 03:30:51'),
(11, 1, 1, 1, 'Brownies Kacang', '<p>Brownies lembut dan moist yang dipadukan dengan taburan kacang renyah, menciptakan kombinasi tekstur yang sempurna dalam setiap gigitan. Rasa cokelat yang kaya berpadu dengan gurihnya kacang, memberikan sensasi manis dan gurih yang seimbang. Setiap potongan brownies ini menghadirkan kelezatan yang memanjakan lidah</p>', '40000.00', 18, 600.00, '20250413102743_67fb2f2f81ca9.jpg', '2025-04-13 03:27:43', '2025-04-13 03:28:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hp` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `role`, `status`, `password`, `hp`, `foto`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'superadmin@gmail.com', '1', 1, '$2a$12$0HAIc1o/zLySI2wjQwzF4e9EZsICwEtsMCuZ/zMBSO2/k0QtQhinW', '0812345678901', NULL, '2025-04-06 14:39:56', '2025-04-06 14:39:56'),
(2, 'Rey super admin', 'reyhansyah4@mail.com', '1', 1, '$2a$12$0HAIc1o/zLySI2wjQwzF4e9EZsICwEtsMCuZ/zMBSO2/k0QtQhinW', '081234567892', NULL, '2025-04-06 14:39:56', '2025-04-06 14:39:56'),
(3, 'rey user', 'reyuser@gmail.com', '2', 1, '$2a$12$dy2oyFtcd2U/gEfqL5e6k.R.HPcR13ssg4QSZemlmauw3KdpEL7.6', '08126374923', NULL, '2025-04-06 14:39:57', '2025-04-06 14:39:57');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `foto_produk`
--
ALTER TABLE `foto_produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foto_produk_produk_id_foreign` (`produk_id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_kategori_id_foreign` (`kategori_id`),
  ADD KEY `produk_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `foto_produk`
--
ALTER TABLE `foto_produk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `foto_produk`
--
ALTER TABLE `foto_produk`
  ADD CONSTRAINT `foto_produk_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `produk_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
