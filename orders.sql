-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Jun 2025 pada 06.59
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
-- Database: `travlie`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `user_id` int(7) NOT NULL,
  `order_name` varchar(10) NOT NULL DEFAULT 'TRVL-',
  `order_code` int(15) NOT NULL,
  `order_title` varchar(50) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `detail` text NOT NULL,
  `total_price` varchar(50) DEFAULT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('Menunggu Pembayaran','Sudah Selesai','Pesanan DIbatalkan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`user_id`, `order_name`, `order_code`, `order_title`, `category`, `detail`, `total_price`, `order_date`, `status`) VALUES
(1029, 'TRVL-', 101, 'Penerbangan Jakarta - Papua', 'Flight', 'Tanggal Keberangkatan = 12 Maret 2023\r\nMaskapai = Garuda Indonesia\r\nKelas = Ekonomi', 'Rp 4.000.000', '2025-06-10 17:55:55', 'Menunggu Pembayaran'),
(1021, 'TRVL-', 103, 'Hotel Padma Bandun', 'Accomodation', 'Checkjkadbda;iuce', 'Rp 2.000.000', '2025-06-10 23:47:31', 'Sudah Selesai'),
(1028, 'TRVL-', 106, 'Sewa 100 tahun', 'Vehicle Rent', 'Nmax Racing', 'Rp 1.700.000.0000', '2025-06-10 23:59:22', 'Pesanan DIbatalkan'),
(1031, 'TRVL-', 107, 'Penerbangan ke Antartika', 'Flight', 'berdua sama beruang', 'Rp 1.500.000.000.000.000', '2025-06-11 00:05:28', 'Pesanan DIbatalkan'),
(1021, 'TRVL-', 110, 'Hotel InterContinental', 'Accomodation', 'adbaudbo', 'Rp 10.000', '2025-06-14 11:51:28', 'Menunggu Pembayaran');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_code`) USING BTREE;

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `order_code` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
