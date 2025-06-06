-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Jun 2025 pada 08.58
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pesan` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `pengirim_tipe` enum('seller','user') NOT NULL,
  `penerima_tipe` enum('seller','user') NOT NULL,
  `is_read` tinyint(4) NOT NULL,
  `waktu_kirim` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `chats`
--

INSERT INTO `chats` (`id`, `seller_id`, `user_id`, `pesan`, `gambar`, `pengirim_tipe`, `penerima_tipe`, `is_read`, `waktu_kirim`, `created_at`, `updated_at`) VALUES
(65, 1, 5, 'kak saya pesan yang putih ya, ukuran L, ', '', 'user', 'seller', 1, '2025-03-08 11:37:20', '2025-03-08 11:37:20', '2025-03-08 11:37:20'),
(66, 1, 5, 'ok kak pesanan akan kami proses mohon ditunggu ya kak', '', 'seller', 'user', 1, '2025-03-08 11:37:54', '2025-03-08 11:37:54', '2025-03-08 11:37:54'),
(67, 1, 5, 'ok kak terima kasih', '', 'user', 'seller', 1, '2025-03-08 11:39:59', '2025-03-08 11:39:59', '2025-03-08 11:39:59'),
(68, 1, 5, 'sama sama kak pesanan sudah dikirim kak', '', 'seller', 'user', 1, '2025-03-08 11:40:23', '2025-03-08 11:40:23', '2025-03-08 11:40:23'),
(69, 1, 7, 'kak saya pesan satu ya ;', '', 'user', 'seller', 1, '2025-04-20 08:52:37', '2025-04-20 08:52:37', '2025-04-20 08:52:37'),
(70, 1, 7, 'ok kaka, pesanan akan diperoses mohon ditunggu, terima kasih atas pesanannya', '', 'seller', 'user', 1, '2025-04-20 08:53:14', '2025-04-20 08:53:14', '2025-04-20 08:53:14'),
(71, 1, 7, 'produk itu sudah lama gak ada kak', 'uploads/download.jpg', 'user', 'seller', 1, '2025-05-01 06:07:10', '2025-05-01 06:07:10', '2025-05-01 06:07:10'),
(72, 1, 7, 'iya kak bulan ini ready kak tgl 21', '', 'seller', 'user', 1, '2025-05-01 06:08:04', '2025-05-01 06:08:04', '2025-05-01 06:08:04'),
(73, 1, 7, 'oke kak ', '', 'user', 'seller', 1, '2025-05-01 06:08:39', '2025-05-01 06:08:39', '2025-05-01 06:08:39'),
(74, 1, 7, 'oke', '', 'seller', 'user', 1, '2025-05-01 06:09:05', '2025-05-01 06:09:05', '2025-05-01 06:09:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `keranjang`
--

INSERT INTO `keranjang` (`id`, `user_id`, `produk_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-02-21 07:25:53', '2025-02-21 07:25:53'),
(7, 7, 9, '2025-03-06 14:34:37', '2025-03-06 14:34:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('pending','dikirim','ditolak','selesai','di proses','batal','di batalkan','pembatalan') DEFAULT 'pending',
  `tgl_pesanan` date DEFAULT NULL,
  `ukuran` varchar(255) DEFAULT NULL,
  `warna` varchar(255) DEFAULT NULL,
  `rasa` varchar(255) DEFAULT NULL,
  `metode` varchar(255) NOT NULL,
  `briva` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `admin` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id`, `user_id`, `produk_id`, `quantity`, `price`, `status`, `tgl_pesanan`, `ukuran`, `warna`, `rasa`, `metode`, `briva`, `keterangan`, `admin`, `created_at`, `updated_at`) VALUES
(8, 1, 12, 2, 10000.00, 'selesai', '2025-06-05', '-', '-', 'Coklat', 'COD', '', '', 'setuju', '2025-06-05 09:28:17', '2025-06-05 09:28:17'),
(9, 1, 8, 2, 10000.00, 'selesai', '2025-06-05', '-', '-', 'Manis', 'Cod', '', '', 'setuju', '2025-06-05 09:34:48', '2025-06-05 09:34:48'),
(10, 1, 1, 1, 50000.00, 'selesai', '2025-06-05', 'L', 'Merah', '-', 'COD', '', '', 'setuju', '2025-06-05 09:41:56', '2025-06-05 09:41:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `produk` text NOT NULL,
  `deskripsi` text NOT NULL,
  `kategori` enum('Fashion','Makanan','Kerajinan','Sembako') NOT NULL,
  `harga` text NOT NULL,
  `rasa` varchar(255) NOT NULL,
  `ukuran` varchar(255) NOT NULL,
  `warna` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `diskon` int(11) NOT NULL,
  `metode` varchar(255) NOT NULL,
  `briva` varchar(255) NOT NULL,
  `gambar1` text NOT NULL,
  `gambar2` text NOT NULL,
  `gambar3` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `seller_id`, `produk`, `deskripsi`, `kategori`, `harga`, `rasa`, `ukuran`, `warna`, `stock`, `diskon`, `metode`, `briva`, `gambar1`, `gambar2`, `gambar3`, `created_at`, `updated_at`) VALUES
(1, 2, 'Sepatu Jordan', 'Sepatu Ori Terbuat dari kulit asli', 'Fashion', '50000', '-', 'L,M,S', 'Biru,Merah,Kuning', 2, 10, 'Briva,COD', '8953JD87', 'f4.png', '', '', '2025-02-19 01:56:02', '2025-02-19 01:56:02'),
(2, 3, 'Kripik SIngkong', 'Olahan Singkong Enak', 'Makanan', '7000', 'Asin,Manis,Pedas', '-', '-', 3, 0, 'COD,Briva', 'HDGY5678', 'm1.png', '', '', '2025-02-19 01:56:02', '2025-02-19 01:56:02'),
(3, 3, 'Sendal Bambu', 'Kerajinan tangan', 'Kerajinan', '150000', '-', 'L,M,S', 'Kuning,Biru,Merah', 5, 30, 'COD,Briva', 'GDH8395', 'k3.png', '', '', '2025-02-19 01:56:02', '2025-02-19 01:56:02'),
(6, 1, 'Snack Kentang', 'Makanan Gurih Terbuat dari kentang berkualitas', 'Makanan', '10000', 'Manis', '-', '-', 100, 10, 'COD, Briva', '0459ekdgs', 'm2.png', '', '', '2025-02-19 05:48:42', '2025-02-19 05:48:42'),
(7, 1, 'Susu ', 'Susu Kualitas tinggi', 'Makanan', '15000', 'Coklat,Vanila', '-', '-', 10, 5, 'COD', '-', 'm3.png', '', '', '2025-02-19 05:54:02', '2025-02-19 05:54:02'),
(8, 2, 'Potato', 'Terbuat dari kentang berkualitas ', 'Makanan', '5000', 'Manis,Asin,Pedas', '-', '-', 10, 20, 'Briva,Cod', 'KDG089372', 'm4.png', '', '', '2025-02-19 05:54:02', '2025-02-19 05:54:02'),
(9, 1, 'Sepatu Nike', '    Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste facilis voluptatum nam magni architecto ipsa fugiat facere cupiditate voluptatem officia natus omnis id adipisci necessitatibus, harum aut! Quod laboriosam id deleniti architecto perferendis nemo, accusantium a modi aspernatur distinctio! Saepe quam reprehenderit minima reiciendis quas distinctio dignissimos iure ducimus, officia ullam sapiente ex? Totam ab veniam minima sit provident quibusdam nisi temporibus natus pariatur repudiandae cumque consectetur dolores consequatur, reprehenderit velit nesciunt beatae! Distinctio ea nihil id perferendis voluptatem autem, quos sit labore aut illum ad deserunt magnam officia veritatis placeat cum! Itaque est quae libero modi voluptatem aperiam deleniti et fugiat obcaecati in quam distinctio ipsa, delectus, atque eius quod alias laborum, quasi optio sunt. Ducimus, nostrum. Dolor ipsam reiciendis ipsum asperiores doloribus fuga voluptatem dolorum porro dignissimos, voluptate tenetur laudantium illo. Consectetur, repellat ipsam architecto laborum voluptates ut tenetur perspiciatis corrupti expedita mollitia rerum doloremque ratione? Nostrum ratione temporibus id neque officiis rem. Dolorum, omnis. Nostrum sunt libero excepturi aliquid quo nam, cupiditate cum, provident laborum eaque commodi iusto eius! Facilis error ducimus ipsa accusamus aut voluptates voluptatum laborum nulla maiores ex quos deleniti aperiam, quas pariatur fuga vitae possimus atque quae quidem eius eveniet. Aut, quae fugit?', 'Fashion', '200000', '-', 'L,S,M', 'Merah,Putih,Blue', 10, 20, 'Briva,COD', 'GDH8395', 'f5.png', 'f6.png', 'f4.png', '2025-02-19 05:54:02', '2025-02-19 05:54:02'),
(12, 1, 'Snack Ship', 'Snack renyah dari keju dan coklat berkualitas ', 'Makanan', '5000', 'Keju,Coklat', '-', '-', 10, 0, 'COD', '-', '68130d80445d7.jpg', '', '', '2025-05-01 05:58:24', '2025-05-01 05:58:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` float NOT NULL,
  `komentar` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rating`
--

INSERT INTO `rating` (`id`, `user_id`, `rating`, `komentar`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'Cukup Bagus, bermanfaat untuk umkm sumenep', '2025-03-04 06:13:12', '2025-03-04 06:13:12'),
(2, 7, 2, 'Cukup Bagus Websitenya', '2025-03-06 08:04:02', '2025-03-06 08:04:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `seller`
--

CREATE TABLE `seller` (
  `id` int(11) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` text NOT NULL,
  `kontak` varchar(250) NOT NULL,
  `alamat` text DEFAULT NULL,
  `nama_toko` varchar(250) NOT NULL,
  `deskripsi_toko` text DEFAULT NULL,
  `gambar` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `seller`
--

INSERT INTO `seller` (`id`, `nama`, `email`, `password`, `kontak`, `alamat`, `nama_toko`, `deskripsi_toko`, `gambar`, `created_at`) VALUES
(1, 'Awul', 'awul@gmail.com', '$2y$10$4j0ggEqMRCnphQJmA/g/SOqxl96Nb9DbLLH6X0EP6RAcqLWcyPJ3G', '04395035289', 'saronggi desa kermata', 'awulstore', 'toko peralatan komputer dan handphone lengkap', '67c84e54b74b1.png', '2025-02-19 02:36:35'),
(2, 'muhammad riyas', 'riyas@gmail.com', '$2y$10$xu.BCUu/RA4tPsAy1aDUUuJJ/TZLDKbBEaZPIG6kHS8Bu1iIjbDZu', '09876543', 'jalan raya gapura paberasan', 'toko kembar berkah', 'menjual aneka perlengkapan kantor dan sekolah (atk)', '67c84e9ba341a.png', '2025-02-27 08:39:37'),
(3, 'Azizah', 'azizah@gmail.com', '$2y$10$WawIdYZgmUkFw6T1uJr95e6TYJEeSroCWO8nMxm3DHXTiNupInspu', '0345350', 'Jalan Raya Lenteng No. ABC gang 12 dusun salosa', 'Azizah Store', 'Toko Peralatan Alat Alat Memasak Lengkap dan Murah', '67c543845fcf2.png', '2025-03-03 05:25:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tentang_kami`
--

CREATE TABLE `tentang_kami` (
  `id` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tentang_kami`
--

INSERT INTO `tentang_kami` (`id`, `deskripsi`, `created_at`, `updated_at`) VALUES
(2, '<div><strong>Selamat datang di Aplikasi Local Shop Sumenep&nbsp;<br></strong><br></div><ul><li>Aplikasi Website ini menyediakan produk lokal yang ada disumenep.</li><li>Daftar dan login, setelah itu update profil pribadi tambah alamat untuk mempermudah pembelian</li><li>Kami juga menghadirkan fitur chating untuk memudah kan anatara pelanggan dan penjual dalam melakukan transaksi.</li><li>Jangan lupa untuk memberikan rating dan ulasan pada aplikasi ini. Umpan balik Anda sangat berarti bagi kami untuk terus meningkatkan kualitas layanan dan fitur yang ada.</li></ul><div>Selamat berbelanja, semoga pengalaman Anda menyenangkan!</div>', '2025-02-16 03:22:48', '2025-02-16 03:22:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `pesanan_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `pesanan_id`, `created_at`, `updated_at`) VALUES
(7, 8, '2025-06-05 09:33:57', '2025-06-05 09:33:57'),
(8, 9, '2025-06-05 09:36:57', '2025-06-05 09:36:57'),
(9, 10, '2025-06-05 09:42:13', '2025-06-05 09:42:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasan`
--

CREATE TABLE `ulasan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `rating` float DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `transaksi_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ulasan`
--

INSERT INTO `ulasan` (`id`, `user_id`, `produk_id`, `rating`, `comment`, `created_at`, `transaksi_id`) VALUES
(8, 1, 8, 4, 'Pengiriman cepat, snacknya sangat enak', '2025-06-05 09:37:19', 8),
(11, 1, 1, 3, 'bagus\r\n', '2025-06-05 09:58:02', 9),
(12, 1, 12, 4, 'bagus', '2025-06-05 09:58:56', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `role` enum('user','admin') NOT NULL,
  `kontak` int(15) NOT NULL,
  `alamat` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `password`, `role`, `kontak`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 'Ayyubb', 'ayyub@gmail.com', '$2y$10$LwmhqPFk5EoFQz2Z9gdkrOBCeJC.0W783IKCtDvhg8XCsnHiPeSiG', 'user', 720520012, 'Jalan Raya Gapura Paberasan Sumenep Dusun Salosa RT/12 RW/06', '2025-02-19 00:02:14', '2025-02-19 00:02:14'),
(4, 'admin', 'admin@gmail.com', '$2y$10$AglQndIQL62FGy3pto.LMOUvrz1.uygg5lTtfozz2hjCIxllHS9Au', 'admin', 8237427, '', '2025-02-19 03:32:41', '2025-02-19 03:32:41'),
(5, 'tolak wulandari', 'wulan@gmail.com', '$2y$10$ARudbRWHeXBS.MLC6hHZvevAu5CaNJJONKeL/7.UtsfuXiwLaxWOm', 'user', 8773654, 'Jalan Raya Saronggi Dusun Kermata RT/12 RW/11', '2025-02-27 08:29:10', '2025-02-27 08:29:10'),
(7, 'Sucia', 'suci@gmail.com', '$2y$10$cyO0W1Aj4BPd/VHaQ1fP9eTHehJwbQn/VI7tb7L05Gt9X494j16Gu', 'user', 39845398, 'Kangean Kepulauan Sumenep Desa Tanjung ', '2025-03-03 00:40:49', '2025-03-03 00:40:49'),
(8, 'linda', 'linda@gmail.com', '$2y$10$5ePjwbCaJY5TDuBD0GIbr.DN01gEKhOJRxlmgo0//pmSgP0FgfT/2', 'user', 0, '', '2025-04-30 04:55:43', '2025-04-30 04:55:43');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tentang_kami`
--
ALTER TABLE `tentang_kami`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `seller`
--
ALTER TABLE `seller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tentang_kami`
--
ALTER TABLE `tentang_kami`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `seller` (`id`),
  ADD CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesanan_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `ulasan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ulasan_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
