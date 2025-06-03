-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Jun 2025 pada 08.40
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `warung_makan_kebumen_1`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(2, 'Admin', '$2y$10$.kRcy0F4St04Vx4fNOgdFuagTRp226ZTh5/jgtQ6EOf6MACMwS8g6');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `id_pesanan`, `id_menu`, `jumlah`, `harga`, `subtotal`) VALUES
(1, 7, 5, 1, 15000.00, 15000.00),
(2, 7, 1, 1, 5000.00, 5000.00),
(3, 8, 1, 1, 5000.00, 5000.00),
(4, 9, 5, 1, 15000.00, 15000.00),
(5, 9, 2, 1, 8000.00, 8000.00),
(6, 10, 2, 1, 8000.00, 8000.00),
(7, 11, 4, 1, 11000.00, 11000.00),
(8, 12, 2, 1, 8000.00, 8000.00),
(9, 13, 12, 1, 10000.00, 10000.00),
(10, 14, 1, 1, 5000.00, 5000.00),
(11, 15, 1, 1, 5000.00, 5000.00),
(12, 15, 2, 1, 8000.00, 8000.00),
(13, 15, 4, 1, 11000.00, 11000.00),
(14, 16, 9, 1, 5000.00, 5000.00),
(15, 16, 10, 1, 4000.00, 4000.00),
(16, 17, 1, 1, 5000.00, 5000.00),
(17, 17, 5, 1, 4000.00, 4000.00),
(18, 17, 7, 1, 6000.00, 6000.00),
(19, 17, 8, 1, 3000.00, 3000.00),
(20, 17, 11, 1, 1000.00, 1000.00),
(21, 17, 12, 1, 10000.00, 10000.00),
(22, 18, 1, 3, 5000.00, 15000.00),
(23, 19, 9, 1, 5000.00, 5000.00),
(24, 20, 10, 1, 4000.00, 4000.00),
(25, 20, 12, 1, 10000.00, 10000.00),
(26, 20, 11, 1, 1000.00, 1000.00),
(27, 20, 9, 1, 5000.00, 5000.00),
(28, 20, 5, 1, 4000.00, 4000.00),
(29, 20, 7, 1, 6000.00, 6000.00),
(30, 20, 8, 1, 3000.00, 3000.00),
(31, 20, 1, 1, 5000.00, 5000.00),
(32, 20, 2, 1, 8000.00, 8000.00),
(33, 20, 4, 2, 11000.00, 22000.00),
(34, 21, 1, 3, 5000.00, 15000.00),
(35, 21, 2, 3, 8000.00, 24000.00),
(36, 21, 4, 3, 11000.00, 33000.00),
(37, 21, 5, 3, 4000.00, 12000.00),
(38, 21, 7, 2, 6000.00, 12000.00),
(39, 21, 8, 2, 3000.00, 6000.00),
(40, 21, 9, 1, 5000.00, 5000.00),
(41, 22, 1, 4, 5000.00, 20000.00),
(42, 23, 2, 5, 8000.00, 40000.00),
(43, 24, 4, 2, 11000.00, 22000.00),
(44, 25, 7, 1, 6000.00, 6000.00),
(45, 26, 9, 5, 5000.00, 25000.00),
(46, 27, 10, 2, 4000.00, 8000.00),
(47, 28, 1, 2, 5000.00, 10000.00),
(48, 28, 2, 1, 8000.00, 8000.00),
(49, 29, 2, 8, 8000.00, 64000.00),
(50, 30, 1, 8, 5000.00, 40000.00),
(51, 31, 1, 4, 5000.00, 20000.00),
(52, 32, 1, 4, 5000.00, 20000.00),
(53, 32, 5, 2, 4000.00, 8000.00),
(54, 33, 8, 5, 3000.00, 15000.00),
(55, 34, 1, 5, 5000.00, 25000.00),
(56, 35, 9, 7, 5000.00, 35000.00),
(57, 36, 12, 1, 10000.00, 10000.00),
(58, 37, 8, 1, 3000.00, 3000.00),
(59, 38, 9, 1, 5000.00, 5000.00),
(60, 39, 1, 1, 5000.00, 5000.00),
(61, 40, 1, 1, 5000.00, 5000.00),
(62, 41, 4, 1, 11000.00, 11000.00),
(63, 42, 10, 1, 4000.00, 4000.00),
(64, 43, 2, 1, 8000.00, 8000.00),
(65, 44, 12, 1, 10000.00, 10000.00),
(66, 45, 1, 2, 5000.00, 10000.00),
(67, 46, 1, 5, 5000.00, 25000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kasir`
--

CREATE TABLE `kasir` (
  `id_kasir` int(11) NOT NULL,
  `nama_kasir` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status` enum('Tersedia','Habis') DEFAULT 'Tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `harga`, `jumlah`, `kategori`, `deskripsi`, `gambar`, `status`) VALUES
(1, 'Nasi Putih', 5000, 67, 'Makanan', 'Nasi putih hangat untuk 1 porsi', 'nasi-putih.jpg', 'Tersedia'),
(2, 'Ayam Goreng', 8000, 17, 'Makanan', 'Ayam goreng renyah', 'ayam-goreng.jpg', 'Tersedia'),
(3, 'Ikan Cakalang Goreng', 5000, 0, 'Makanan', 'Ikan cakalang goreng yang renyah', 'ikan-goreng.jpg', 'Habis'),
(4, 'Rendang', 11000, 24, 'Makanan', 'Rendang daging sapi khas', 'rendang.jpg', 'Tersedia'),
(5, 'Tempe Orek dan Kentang', 4000, 30, 'Makanan', 'Tempe orek dengan kentang yang lezat', 'tempe-orek-kentang.jpg', 'Tersedia'),
(6, 'Tempe Tahu', 3000, 0, 'Makanan', 'Tempe dan tahu goreng', 'tempe-tahu.jpg', 'Habis'),
(7, 'Cumi Cabai Garam', 6000, 10, 'Makanan', 'Cumi pedas dengan olahan khas', 'cumi-cabai-garam.jpg', 'Tersedia'),
(8, 'Es Teh Manis', 3000, 94, 'Minuman', 'Teh manis dingin segar', 'es-teh-manis.jpg', 'Tersedia'),
(9, 'Es Jeruk', 5000, 41, 'Minuman', 'Jeruk segar dengan es', 'es-jeruk.jpg', 'Tersedia'),
(10, 'Air Mineral', 4000, 199, 'Minuman', 'Air mineral dalam kemasan', 'air-mineral.jpg', 'Tersedia'),
(11, 'Sambal Ijo', 1000, 10, 'Makanan', 'sangat cocok untuk pecinta pedas', 'sambal-ijo.jpeg', 'Tersedia'),
(12, 'Udang Keju', 10000, 10, 'Makanan', '1 porsi isi 3. ', 'udang-keju.jpeg', 'Tersedia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL,
  `tanggal` datetime NOT NULL,
  `metode_pembayaran` enum('Cash','Cashless') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `total`, `status`, `tanggal`, `metode_pembayaran`) VALUES
(1, 20000.00, 'Menunggu Pembayaran', '2025-05-16 13:54:43', 'Cash'),
(2, 20000.00, 'Menunggu Pembayaran', '2025-05-16 13:56:02', 'Cash'),
(3, 20000.00, 'Menunggu Pembayaran', '2025-05-16 13:58:40', 'Cash'),
(4, 20000.00, 'Menunggu Pembayaran', '2025-05-16 13:59:00', 'Cash'),
(5, 20000.00, 'Menunggu Pembayaran', '2025-05-16 13:59:58', 'Cash'),
(6, 20000.00, 'Menunggu Pembayaran', '2025-05-16 14:00:38', 'Cash'),
(7, 20000.00, 'Menunggu Pembayaran', '2025-05-16 14:02:05', 'Cash'),
(8, 5000.00, 'Menunggu Pembayaran', '2025-05-16 14:06:33', 'Cash'),
(9, 23000.00, 'Menunggu Pembayaran', '2025-05-17 03:46:52', 'Cashless'),
(10, 8000.00, 'Menunggu Pembayaran', '2025-05-17 03:54:35', 'Cashless'),
(11, 11000.00, 'Menunggu Pembayaran', '2025-05-17 03:58:44', 'Cashless'),
(12, 8000.00, 'Lunas', '2025-05-17 04:10:50', 'Cashless'),
(13, 10000.00, 'Lunas', '2025-05-18 15:55:36', 'Cash'),
(14, 5000.00, 'Lunas', '2025-05-18 15:57:48', 'Cash'),
(15, 24000.00, 'Menunggu Pembayaran', '2025-05-18 16:04:11', 'Cash'),
(16, 9000.00, 'Menunggu Pembayaran', '2025-05-18 16:18:05', 'Cashless'),
(17, 29000.00, 'Lunas', '2025-05-20 13:11:10', 'Cash'),
(18, 15000.00, 'Menunggu Pembayaran', '2025-05-20 13:33:36', 'Cash'),
(19, 5000.00, 'Menunggu Pembayaran', '2025-05-20 13:40:20', 'Cashless'),
(20, 68000.00, 'Lunas', '2025-05-21 10:59:58', 'Cash'),
(21, 107000.00, 'Lunas', '2025-05-21 11:07:29', 'Cashless'),
(22, 20000.00, 'Lunas', '2025-05-21 11:10:52', 'Cash'),
(23, 40000.00, 'Lunas', '2025-05-21 11:12:24', 'Cashless'),
(24, 22000.00, 'Lunas', '2025-05-21 11:17:58', 'Cashless'),
(25, 6000.00, 'Lunas', '2025-05-21 11:19:30', 'Cashless'),
(26, 25000.00, 'Lunas', '2025-05-21 11:26:53', 'Cash'),
(27, 8000.00, 'Lunas', '2025-05-21 11:28:12', 'Cashless'),
(28, 18000.00, 'Menunggu Pembayaran', '2025-05-21 11:31:09', 'Cashless'),
(29, 64000.00, 'Lunas', '2025-05-21 11:50:11', 'Cashless'),
(30, 40000.00, 'Lunas', '2025-05-23 11:16:22', 'Cashless'),
(31, 20000.00, 'Lunas', '2025-05-23 11:19:49', 'Cashless'),
(32, 28000.00, 'Lunas', '2025-05-23 11:23:08', 'Cashless'),
(33, 15000.00, 'Lunas', '2025-05-23 11:24:40', 'Cash'),
(34, 25000.00, 'Lunas', '2025-05-23 11:27:45', 'Cashless'),
(35, 35000.00, 'Lunas', '2025-05-23 11:36:30', 'Cashless'),
(36, 10000.00, 'Lunas', '2025-05-28 09:11:16', 'Cashless'),
(37, 3000.00, 'Lunas', '2025-05-28 09:14:04', 'Cashless'),
(38, 5000.00, 'Lunas', '2025-05-28 09:14:59', 'Cash'),
(39, 5000.00, 'Lunas', '2025-05-28 09:29:27', 'Cash'),
(40, 5000.00, 'Lunas', '2025-05-28 09:30:07', 'Cash'),
(41, 11000.00, 'Lunas', '2025-05-28 09:32:59', 'Cash'),
(42, 4000.00, 'Lunas', '2025-05-28 09:33:31', 'Cashless'),
(43, 8000.00, 'Lunas', '2025-05-28 09:38:28', 'Cash'),
(44, 10000.00, 'Lunas', '2025-05-28 09:39:19', 'Cashless'),
(45, 10000.00, 'Lunas', '2025-05-31 04:34:00', 'Cashless'),
(46, 25000.00, 'Lunas', '2025-05-31 08:53:20', 'Cashless');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `status_pembayaran` varchar(20) DEFAULT NULL,
  `metode_pembayaran` varchar(20) DEFAULT NULL,
  `waktu_transaksi` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pesanan`, `total_harga`, `status_pembayaran`, `metode_pembayaran`, `waktu_transaksi`) VALUES
(1, 12, 8000, 'Lunas', 'Cashless', '2025-05-21 12:55:10'),
(2, 20, 68000, 'Lunas', 'Cash', '2025-05-21 16:00:17'),
(3, 12, 8000, 'Lunas', 'Cashless', '2025-05-21 16:06:51'),
(4, 21, 107000, 'Lunas', 'Cashless', '2025-05-21 16:07:45'),
(5, 22, 20000, 'Lunas', 'Cash', '2025-05-21 16:10:57'),
(6, 23, 40000, 'Lunas', 'Cashless', '2025-05-21 16:12:30'),
(7, 23, 40000, 'Lunas', 'Cashless', '2025-05-21 16:18:17'),
(8, 24, 22000, 'Lunas', 'Cashless', '2025-05-21 16:18:36'),
(9, 25, 6000, 'Lunas', 'Cashless', '2025-05-21 16:19:38'),
(10, 26, 25000, 'Lunas', 'Cash', '2025-05-21 16:27:42'),
(11, 27, 8000, 'Lunas', 'Cashless', '2025-05-21 16:30:09'),
(12, 27, 8000, 'Lunas', 'Cashless', '2025-05-21 16:32:26'),
(13, 14, 5000, 'Lunas', 'Cash', '2025-05-21 16:33:51'),
(14, 13, 10000, 'Lunas', 'Cash', '2025-05-21 16:38:11'),
(15, 13, 10000, 'Lunas', 'Cash', '2025-05-21 16:39:30'),
(16, 29, 64000, 'Lunas', 'Cashless', '2025-05-21 16:50:20'),
(17, 30, 40000, 'Lunas', 'Cashless', '2025-05-23 16:16:33'),
(18, 31, 20000, 'Lunas', 'Cashless', '2025-05-23 16:20:28'),
(19, 31, 20000, 'Lunas', 'Cashless', '2025-05-23 16:23:19'),
(20, 32, 28000, 'Lunas', 'Cashless', '2025-05-23 16:23:45'),
(21, 33, 15000, 'Lunas', 'Cash', '2025-05-23 16:24:49'),
(22, 34, 25000, 'Lunas', 'Cashless', '2025-05-23 16:27:53'),
(23, 35, 35000, 'Lunas', 'Cashless', '2025-05-23 16:36:39'),
(24, 36, 10000, 'Lunas', 'Cashless', '2025-05-28 14:11:31'),
(25, 37, 3000, 'Lunas', 'Cashless', '2025-05-28 14:14:14'),
(26, 38, 5000, 'Lunas', 'Cash', '2025-05-28 14:15:06'),
(27, 38, 5000, 'Lunas', 'Cash', '2025-05-28 14:16:07'),
(28, 40, 5000, 'Lunas', 'Cash', '2025-05-28 14:30:43'),
(29, 39, 5000, 'Lunas', 'Cash', '2025-05-28 14:32:02'),
(30, 41, 11000, 'Lunas', 'Cash', '2025-05-28 14:33:05'),
(31, 42, 4000, 'Lunas', 'Cashless', '2025-05-28 14:33:42'),
(32, 43, 8000, 'Lunas', 'Cash', '2025-05-28 14:38:33'),
(33, 44, 10000, 'Lunas', 'Cashless', '2025-05-28 14:39:28'),
(34, 45, 10000, 'Lunas', 'Cashless', '2025-05-31 09:34:59'),
(35, 46, 25000, 'Lunas', 'Cashless', '2025-05-31 13:56:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indeks untuk tabel `kasir`
--
ALTER TABLE `kasir`
  ADD PRIMARY KEY (`id_kasir`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT untuk tabel `kasir`
--
ALTER TABLE `kasir`
  MODIFY `id_kasir` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`),
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`);

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
