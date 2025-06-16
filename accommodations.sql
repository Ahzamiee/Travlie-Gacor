-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jun 2025 pada 08.03
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
-- Struktur dari tabel `accommodations`
--

CREATE TABLE `accommodations` (
  `id_akomodasi` int(11) NOT NULL,
  `nama_akomodasi` varchar(255) NOT NULL,
  `deskripsi_singkat` varchar(500) DEFAULT NULL,
  `deskripsi_lengkap` text DEFAULT NULL,
  `tipe_akomodasi` varchar(50) NOT NULL,
  `provinsi` varchar(100) DEFAULT NULL,
  `kota` varchar(100) NOT NULL,
  `rating_bintang` decimal(2,1) DEFAULT NULL,
  `skor_ulasan_rata` decimal(2,1) DEFAULT NULL,
  `jumlah_ulasan` int(11) DEFAULT 0,
  `harga_standard` decimal(15,2) NOT NULL,
  `harga_diskon` decimal(15,2) NOT NULL,
  `kapasitas_default_tamu` int(11) DEFAULT NULL,
  `check_in_standar` time DEFAULT NULL,
  `check_out_standar` time DEFAULT NULL,
  `telepon_kontak` varchar(30) DEFAULT NULL,
  `email_kontak` varchar(100) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `is_aktif` tinyint(1) DEFAULT 1,
  `url_gambar_utama` varchar(255) DEFAULT NULL,
  `list_url_gambar` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`list_url_gambar`)),
  `list_fasilitas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`list_fasilitas`)),
  `list_tipe_kamar_dasar` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`list_tipe_kamar_dasar`)),
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `accommodations`
--

INSERT INTO `accommodations` (`id_akomodasi`, `nama_akomodasi`, `deskripsi_singkat`, `deskripsi_lengkap`, `tipe_akomodasi`, `provinsi`, `kota`, `rating_bintang`, `skor_ulasan_rata`, `jumlah_ulasan`, `harga_standard`, `harga_diskon`, `kapasitas_default_tamu`, `check_in_standar`, `check_out_standar`, `telepon_kontak`, `email_kontak`, `website_url`, `is_aktif`, `url_gambar_utama`, `list_url_gambar`, `list_fasilitas`, `list_tipe_kamar_dasar`, `created_at`, `updated_at`) VALUES
(1, 'The Stones Hotel Legian Bali', 'Resort mewah di Legian, Bali dengan kolam renang yang luas.', 'The Stones Hotel Legian Bali adalah resort bintang 5 yang ikonik, terletak strategis di Legian, menawarkan pengalaman menginap yang tak terlupakan. Nikmati fasilitas kolam renang laguna yang megah, pusat kebugaran modern, dan berbagai pilihan restoran dan bar.', 'Hotel', 'Bali', 'Kuta', 4.7, 8.9, 959, 1999000.00, 1863497.00, 2, '14:00:00', '12:00:00', '+623618496060', 'info.legian@stoneshotel.com', 'https://www.marriott.com/en-us/hotels/dpsak-the-stones-hotel-legian-bali-autograph-collection/overview/', 1, 'style/assets/accommodation/hotel.png', '[\r\n        \"style/assets/accommodation/hotel(1).png\",\r\n        \"style/assets/accommodation/hotel(2).png\"\r\n    ]', '[\r\n        \"Kolam Renang\",\r\n        \"WiFi Gratis\",\r\n        \"Restoran\",\r\n        \"Pusat Kebugaran\",\r\n        \"Spa\"\r\n    ]', '[\r\n        {\"nama\": \"Deluxe Room\", \"kapasitas\": 2, \"harga\": 1863497},\r\n        {\"nama\": \"Suite\", \"kapasitas\": 4, \"harga\": 3500000}\r\n    ]', '2025-06-10 00:59:53', '2025-06-10 00:59:53'),
(2, 'Infinity8 Bali', 'Hotel modern di Jimbaran dengan akses mudah ke pantai.', 'Infinity8 Bali menawarkan akomodasi yang nyaman dan modern di area Jimbaran, dekat dengan berbagai destinasi wisata populer. Ideal untuk wisatawan bisnis maupun liburan, hotel ini dilengkapi dengan fasilitas lengkap dan pelayanan terbaik.', 'Hotel', 'Bali', 'Jimbaran', 4.5, 8.5, 3562, 499000.00, 453869.00, 2, '14:00:00', '12:00:00', '+623613008888', 'info@infinity8bali.com', 'https://infinity8bali.com/', 1, 'style/assets/accommodation/hotel2.png', '[\r\n        \"style/assets/accommodation/hotel2-a.png\",\r\n        \"style/assets/accommodation/hotel2-b.png\"\r\n    ]', '[\r\n        \"Kolam Renang Rooftop\",\r\n        \"WiFi Gratis\",\r\n        \"Restoran\",\r\n        \"Layanan Kamar\"\r\n    ]', '[\r\n        {\"nama\": \"Superior Room\", \"kapasitas\": 2, \"harga\": 453869},\r\n        {\"nama\": \"Deluxe Room\", \"kapasitas\": 2, \"harga\": 550000}\r\n    ]', '2025-06-10 00:59:53', '2025-06-10 00:59:53'),
(3, 'Grand Mercure Malang Mirama', 'Hotel bintang 5 di Malang dengan arsitektur elegan.', 'Grand Mercure Malang Mirama adalah pilihan sempurna untuk pengalaman menginap mewah di Malang. Berlokasi strategis, hotel ini menawarkan fasilitas modern, kamar yang luas, dan layanan ramah untuk memastikan kenyamanan Anda.', 'Hotel', 'Jawa Timur', 'Malang', 4.7, 9.1, 3562, 1200000.00, 1050200.00, 2, '14:00:00', '12:00:00', '+62341334900', 'ha977@accor.com', 'https://all.accor.com/hotel/A977/index.en.shtml', 1, 'style/assets/accommodation/hotel3.png', '[\r\n        \"style/assets/accommodation/hotel3-a.png\",\r\n        \"style/assets/accommodation/hotel3-b.png\"\r\n    ]', '[\r\n        \"Kolam Renang\",\r\n        \"Pusat Kebugaran\",\r\n        \"Spa\",\r\n        \"Restoran\",\r\n        \"Bar\"\r\n    ]', '[\r\n        {\"nama\": \"Standard Room\", \"kapasitas\": 2, \"harga\": 1050200},\r\n        {\"nama\": \"Executive Room\", \"kapasitas\": 2, \"harga\": 1300000}\r\n    ]', '2025-06-10 00:59:53', '2025-06-10 00:59:53'),
(4, 'Swiss-Belinn Malang', 'Hotel nyaman dan modern di pusat kota Malang.', 'Swiss-Belinn Malang menawarkan akomodasi nyaman dan fungsional di jantung kota Malang. Dengan lokasi yang strategis, hotel ini memudahkan akses ke pusat perbelanjaan, kuliner, dan destinasi wisata di Malang.', 'Hotel', 'Jawa Timur', 'Malang', 4.4, 8.3, 3562, 580000.00, 560000.00, 2, '14:00:00', '12:00:00', '+62341550300', 'resvsmb@swiss-belhotel.com', 'https://www.swiss-belhotel.com/swiss-belinn-malang/', 1, 'style/assets/accommodation/hotel4.png', '[\r\n        \"style/assets/accommodation/hotel4-a.png\",\r\n        \"style/assets/accommodation/hotel4-b.png\"\r\n    ]', '[\r\n        \"WiFi Gratis\",\r\n        \"Kolam Renang\",\r\n        \"Restoran\",\r\n        \"Layanan Kamar\"\r\n    ]', '[\r\n        {\"nama\": \"Standard Room\", \"kapasitas\": 2, \"harga\": 560000},\r\n        {\"nama\": \"Family Room\", \"kapasitas\": 3, \"harga\": 700000}\r\n    ]', '2025-06-10 00:59:53', '2025-06-10 00:59:53'),
(5, 'Hotel Tentrem Yogyakarta', 'Hotel bintang 5 mewah dengan sentuhan budaya Jawa.', 'Hotel Tentrem Yogyakarta adalah perpaduan sempurna antara kemewahan modern dan kekayaan budaya Jawa. Rasakan pengalaman menginap yang tak tertandingi dengan fasilitas premium dan keramahan khas Yogyakarta.', 'Hotel', 'DI Yogyakarta', 'Jetis', 4.7, 9.2, 1952, 2000000.00, 0.00, 2, '15:00:00', '12:00:00', '+622746415555', 'reservation.yogyakarta@tentremhotel.com', 'https://www.tentremhotel.com/yogyakarta/', 1, 'style/assets/accommodation/hotel5.png', '[\r\n        \"style/assets/accommodation/hotel5-a.png\",\r\n        \"style/assets/accommodation/hotel5-b.png\"\r\n    ]', '[\r\n        \"Kolam Renang\",\r\n        \"Pusat Kebugaran\",\r\n        \"Spa\",\r\n        \"Restoran\",\r\n        \"Kids Club\"\r\n    ]', '[\r\n        {\"nama\": \"Deluxe Room\", \"kapasitas\": 2, \"harga\": 2000000},\r\n        {\"nama\": \"Executive Suite\", \"kapasitas\": 2, \"harga\": 3500000}\r\n    ]', '2025-06-10 00:59:53', '2025-06-15 00:36:02'),
(6, 'Royal Ambarukmo Yogyakarta', 'Hotel bersejarah dan mewah di pusat kota Yogyakarta.', 'Royal Ambarukmo Yogyakarta adalah hotel legendaris yang memadukan sejarah dengan fasilitas modern. Berada di lokasi strategis, dekat dengan pusat perbelanjaan dan wisata, menawarkan pengalaman menginap yang berkelas.', 'Hotel', 'DI Yogyakarta', 'Depok, Sleman', 4.7, 9.0, 1064, 1700000.00, 0.00, 2, '14:00:00', '12:00:00', '+622744319000', 'info@royalambarrukmo.com', 'https://www.royalambarrukmo.com/', 1, 'style/assets/accommodation/hotel6.png', '[\r\n        \"style/assets/accommodation/hotel6-a.png\",\r\n        \"style/assets/accommodation/hotel6-b.png\"\r\n    ]', '[\r\n        \"Kolam Renang\",\r\n        \"Pusat Kebugaran\",\r\n        \"Spa\",\r\n        \"Akses Mal\",\r\n        \"Taman\"\r\n    ]', '[\r\n        {\"nama\": \"Deluxe Room\", \"kapasitas\": 2, \"harga\": 1700000},\r\n        {\"nama\": \"Heritage Room\", \"kapasitas\": 2, \"harga\": 2200000}\r\n    ]', '2025-06-10 00:59:53', '2025-06-16 05:32:18');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `accommodations`
--
ALTER TABLE `accommodations`
  ADD PRIMARY KEY (`id_akomodasi`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `accommodations`
--
ALTER TABLE `accommodations`
  MODIFY `id_akomodasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
