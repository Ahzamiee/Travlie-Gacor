-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2025 at 06:37 AM
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
  `category` enum('Flight','Accommodation','Vehicle Rent','All') NOT NULL COMMENT 'Kategori promo untuk filter',
  `promo_code` varchar(50) DEFAULT NULL COMMENT 'Kode unik untuk promo (jika ada)',
  `discount_type` enum('Percentage','Fixed') NOT NULL DEFAULT 'Percentage' COMMENT 'Jenis diskon (persen atau nominal)',
  `discount_value` decimal(10,2) NOT NULL COMMENT 'Nilai diskon (angka persen atau nominal)',
  `start_date` date NOT NULL COMMENT 'Tanggal mulai berlaku promo',
  `end_date` date NOT NULL COMMENT 'Tanggal berakhir promo',
  `terms_conditions` text DEFAULT NULL COMMENT 'Syarat dan Ketentuan',
  `status` enum('Active','Inactive','Expired') NOT NULL DEFAULT 'Active' COMMENT 'Status promo saat ini',
  `usage_limit` int(11) DEFAULT NULL COMMENT 'Batas penggunaan promo (jika ada)',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promos`
--

INSERT INTO `promos` (`promo_id`, `title`, `description`, `image_url`, `category`, `promo_code`, `discount_type`, `discount_value`, `start_date`, `end_date`, `terms_conditions`, `status`, `usage_limit`, `created_at`) VALUES
(1, 'Flash Sale Tiket Murah', 'Diskon Besar Untuk Flight Domestik!', 'style/assets/promo-pesawat.jpg', 'Flight', 'FLIGHTGO15', 'Percentage', 15.00, '2025-06-01', '2025-06-15', 'Min. transaksi Rp 1.000.000. Hanya untuk penerbangan domestik.', 'Active', 3, '2025-05-27 06:13:07'),
(3, 'Sewa Kendaraan Hemat 20%', 'Bayar Dengan Harga Teririt.', 'style/assets/promo-rent.jpg', 'Vehicle Rent', 'SEWA20', 'Percentage', 20.00, '2025-06-01', '2025-06-30', 'Hanya untuk sewa mobil minimal 3 hari.', 'Active', 3, '2025-05-27 06:13:07');

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
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
