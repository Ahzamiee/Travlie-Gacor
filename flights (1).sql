-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2025 at 07:31 AM
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
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `id` int(11) NOT NULL,
  `departure_city_code` varchar(10) NOT NULL,
  `departure_city_name` varchar(255) NOT NULL,
  `arrival_city_code` varchar(10) NOT NULL,
  `arrival_city_name` varchar(255) NOT NULL,
  `arrival_date` date DEFAULT NULL,
  `arrival_time` time NOT NULL DEFAULT '00:00:00',
  `airline` varchar(255) NOT NULL,
  `flight_number` varchar(20) DEFAULT NULL,
  `departure_date` date NOT NULL,
  `departure_time` time NOT NULL DEFAULT '00:00:00',
  `price` decimal(10,2) NOT NULL,
  `flight_class` varchar(50) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`id`, `departure_city_code`, `departure_city_name`, `arrival_city_code`, `arrival_city_name`, `arrival_date`, `arrival_time`, `airline`, `flight_number`, `departure_date`, `departure_time`, `price`, `flight_class`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 'CGK', 'Jakarta', 'CNX', 'Chiang Mai', '2025-07-26', '10:00:00', 'AirAsia', 'GA 200', '2025-07-25', '07:30:00', 2622000.00, 'Economy', 'https://img.freepik.com/free-photo/ho-kham-luang-northern-thai-style-royal-flora-ratchaphruek-chiang-mai-thailand_335224-822.jpg', '2025-06-18 03:12:14', '2025-06-18 03:18:57'),
(2, 'CGK', 'Jakarta', 'CTS', 'Sapporo', '2025-07-27', '16:00:00', 'Garuda Indonesia', 'CI 123', '2025-07-27', '09:00:00', 6603800.00, 'Economy', 'https://img.freepik.com/free-photo/beautiful-architecture-building-with-mountain-landscape-winter-season-sapporo-city-hokkaido-japan_74190-6391.jpg', '2025-06-18 03:12:14', '2025-06-18 03:18:57'),
(3, 'CGK', 'Jakarta', 'FUK', 'Fukuoka', '2025-07-28', '14:30:00', 'Lion Air', 'JT 456', '2025-07-28', '11:00:00', 4896900.00, 'Economy', 'https://img.freepik.com/free-photo/urban-landscape-asian-city_23-2148889518.jpg', '2025-06-18 03:12:14', '2025-06-18 03:18:57'),
(4, 'CGK', 'Jakarta', 'CJU', 'Jeju', '2025-07-29', '00:30:00', 'Citilink', 'JT 880', '2025-07-28', '13:00:00', 5838100.00, 'Economy', 'https://img.freepik.com/free-photo/haedong-yonggungsa-temple-haeundae-sea-busan-buddhist-temple-busan-south-korea_335224-1362.jpg', '2025-06-18 03:12:14', '2025-06-18 03:18:57'),
(5, 'CGK', 'Jakarta', 'PUS', 'Busan', '2025-07-30', '06:45:00', 'Batik Air', 'ID 7777', '2025-07-28', '20:00:00', 6600800.00, 'Economy', 'https://img.freepik.com/free-photo/beautiful-architecture-building-cityscape-seoul-city_74190-3218.jpg', '2025-06-18 03:12:14', '2025-06-18 03:18:57'),
(6, 'CGK', 'Jakarta', 'ADL', 'Adelaide', '2025-08-02', '07:30:00', 'Qantas', 'QF 18', '2025-08-01', '22:00:00', 9000000.00, 'Economy', 'https://img.freepik.com/free-photo/toronto-skyline-from-park_649448-3488.jpg', '2025-06-18 03:12:14', '2025-06-18 03:18:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
