-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2025 at 05:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `promos`
--

CREATE TABLE `promos` (
  `promo_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category` enum('Flight','Accommodation','Vehicle Rent','All') NOT NULL,
  `promo_code` varchar(50) DEFAULT NULL,
  `discount_type` enum('Percentage','Fixed') NOT NULL DEFAULT 'Percentage',
  `discount_value` decimal(10,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `terms_conditions` text DEFAULT NULL,
  `status` enum('Active','Inactive','Expired') NOT NULL DEFAULT 'Active',
  `usage_limit` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promos`
--

INSERT INTO `promos` (`promo_id`, `title`, `description`, `image_url`, `category`, `promo_code`, `discount_type`, `discount_value`, `start_date`, `end_date`, `terms_conditions`, `status`, `usage_limit`, `created_at`, `is_default`) VALUES
(16, 'Flash Sale Tiket Murah', 'Diskon besar untuk penerbangan domestik!', NULL, 'Flight', 'FLIGHT50', '', 15.00, '2025-06-01', '2025-06-30', 'Hanya untuk rute domestik dan pemesanan online.', 'Active', NULL, '2025-06-14 08:38:23', NULL),
(17, 'Diskon Akomodasi Musim Panas', 'Menginap hemat di hotel bintang 4!', 'https://via.placeholder.com/300x200', 'Accommodation', 'SUMMER20', 'Percentage', 20.00, '2025-06-01', '2025-08-31', 'Minimal menginap 2 malam.', 'Active', 500, '2025-06-14 08:38:23', 0),
(18, 'Sewa Mobil Hemat', 'Diskon 10% untuk penyewaan mobil di seluruh Indonesia.', 'https://via.placeholder.com/300x200', 'Vehicle Rent', 'RENT10', 'Percentage', 10.00, '2025-06-01', '2025-06-30', 'Berlaku untuk semua jenis kendaraan.', 'Active', 200, '2025-06-14 08:38:23', 0),
(19, 'Liburan Lebaran', 'Diskon tiket pesawat ke semua kota besar!', NULL, 'Flight', 'LEBARAN25', '', 25.00, '2025-06-15', '2025-06-25', 'Berlaku hanya untuk pemesanan melalui aplikasi.', 'Active', NULL, '2025-06-14 08:38:23', NULL),
(20, 'Nginep Mewah Hemat', 'Diskon flat Rp100.000 untuk akomodasi pilihan.', 'https://via.placeholder.com/300x200', 'Accommodation', 'HOTEL100', '', 100000.00, '2025-06-10', '2025-06-30', 'Minimum transaksi Rp500.000.', 'Active', 150, '2025-06-14 08:38:23', 1),
(22, 'Promo Tiket Internasional', 'Hemat besar untuk tiket pesawat ke luar negeri!', 'https://via.placeholder.com/300x200', 'Flight', 'INTL40', 'Percentage', 40.00, '2025-06-05', '2025-06-25', 'Hanya untuk rute Asia dan Eropa.', 'Active', 250, '2025-06-14 08:38:23', 0),
(23, 'Diskon Staycation', 'Diskon Rp50.000 untuk hotel dalam kota.', 'https://via.placeholder.com/300x200', 'Accommodation', 'STAY50', 'Fixed', 50000.00, '2025-06-01', '2025-07-01', 'Berlaku untuk lokasi hotel di kota pengguna.', 'Active', 300, '2025-06-14 08:38:23', 0),
(24, 'Gratis Sewa 1 Hari', 'Sewa kendaraan 3 hari gratis 1 hari.', 'https://via.placeholder.com/300x200', 'Vehicle Rent', 'RENT1FREE', 'Percentage', 25.00, '2025-06-01', '2025-07-15', 'Minimal sewa 3 hari.', 'Active', 120, '2025-06-14 08:38:23', 0),
(25, 'Promo Spesial Pelajar', 'Diskon 20% untuk pelajar yang verifikasi NISN.', 'https://via.placeholder.com/300x200', 'Flight', 'STUDENT20', 'Percentage', 20.00, '2025-06-01', '2025-06-30', 'Hanya untuk pengguna usia < 25 tahun dengan NISN.', 'Active', 400, '2025-06-14 08:38:23', 0),
(57, 'Diskon Gila-Gilaan Tiket Pesawat', 'Dapatkan potongan harga hingga 25% untuk semua tujuan domestik.', 'images/promo/flight-discount.jpg', 'Flight', 'FLY25', 'Percentage', 25.00, '2025-06-15', '2025-07-15', 'Hanya berlaku untuk penerbangan domestik.', 'Active', 500, '2025-06-14 10:52:33', 0),
(58, 'Nginep Hemat di Hotel Bintang 4', 'Nikmati potongan Rp 150.000 untuk hotel pilihan.', 'images/promo/hotel-hemat.jpg', 'Accommodation', 'HOTEL150', 'Fixed', 150000.00, '2025-06-10', '2025-07-10', 'Minimal transaksi Rp 500.000.', 'Active', 300, '2025-06-14 10:52:33', 0),
(59, 'Sewa Mobil Diskon 50%', 'Perjalanan lebih nyaman dengan diskon sewa mobil.', 'images/promo/car-rental.jpg', 'Vehicle Rent', 'RENT50', 'Percentage', 50.00, '2025-06-01', '2025-07-01', 'Hanya berlaku untuk sewa minimal 3 hari.', 'Active', 200, '2025-06-14 10:52:33', 0),
(60, 'Staycation Spesial Akhir Pekan', 'Diskon Rp 100.000 untuk menginap saat weekend.', 'images/promo/staycation.jpg', 'Accommodation', 'WEEKENDSTAY', 'Fixed', 100000.00, '2025-06-14', '2025-08-14', 'Khusus hari Jumat sampai Minggu.', 'Active', 250, '2025-06-14 10:52:33', 0),
(61, 'Diskon 20% Tiket Internasional', 'Terbang ke luar negeri lebih murah dengan diskon spesial.', 'images/promo/international-flight.jpg', 'Flight', 'INTL20', 'Percentage', 20.00, '2025-06-12', '2025-07-20', 'Tidak berlaku untuk maskapai promo.', 'Active', 400, '2025-06-14 10:52:33', 0),
(63, 'Cashback Tiket Pesawat Rp 75.000', 'Dapatkan cashback untuk pembelian tiket pesawat.', 'images/promo/flight-cashback.jpg', 'Flight', 'CASH75', 'Fixed', 75000.00, '2025-06-05', '2025-07-05', 'Cashback diberikan dalam bentuk saldo.', 'Active', 150, '2025-06-14 10:52:33', 0),
(64, 'Diskon 30% Sewa Motor', 'Keliling kota hemat dengan sewa motor diskon 30%.', 'images/promo/motor-rent.jpg', 'Vehicle Rent', 'BIKERIDE30', '', 30.00, '2025-06-01', '2025-07-01', 'Minimal sewa 2 hari.', 'Active', 180, '2025-06-14 10:52:33', 1),
(65, 'Promo Combo: Flight + Hotel', 'Diskon ekstra untuk pemesanan paket Flight & Hotel.', 'images/promo/combo-promo.jpg', 'Flight', 'COMBODEAL', 'Fixed', 200000.00, '2025-06-15', '2025-08-15', 'Hanya untuk pemesanan gabungan.', 'Active', 220, '2025-06-14 10:52:33', 0),
(66, 'Diskon Libur Sekolah', 'Nikmati diskon perjalanan hingga 15% selama musim liburan.', NULL, 'Flight', 'HOLIDAY15', '', 15.00, '2025-06-20', '2025-07-30', 'Hanya untuk anak-anak dan keluarga.', 'Active', NULL, '2025-06-14 10:52:33', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`promo_id`),
  ADD UNIQUE KEY `idx_promo_code` (`promo_code`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_status_dates` (`status`,`start_date`,`end_date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `promos`
--
ALTER TABLE `promos`
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
