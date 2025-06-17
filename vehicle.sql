-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Jun 2025 pada 07.58
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
-- Struktur dari tabel `vehicle`
--

CREATE TABLE `vehicle` (
  `id_vehicle` int(11) NOT NULL,
  `jenis_kendaraan` varchar(50) NOT NULL,
  `merk` varchar(50) NOT NULL,
  `detail_kendaraan` text NOT NULL,
  `kota` varchar(100) NOT NULL,
  `harga_per_hari` int(11) NOT NULL,
  `gambar_url` varchar(255) DEFAULT NULL,
  `is_aktif` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `vehicle`
--

INSERT INTO `vehicle` (`id_vehicle`, `jenis_kendaraan`, `merk`, `detail_kendaraan`, `kota`, `harga_per_hari`, `gambar_url`, `is_aktif`) VALUES
(1, 'Motor', 'Honda Scoopy', '1 koper                                                                                                                                2 penumpang', 'Bandung', 70000, 'style/assets/scoopy.png', 0),
(2, 'Motor', 'Yamaha N-MAX', '1 koper                                                                                                                            2 penumpang', 'Bali', 90000, 'style/assets/nmax.png', 0),
(3, 'Motor', 'Honda Vario', '1 koper                                                                                                                                  2 penumpang', 'Jakarta', 75000, 'style/assets/vario.png', 0),
(4, 'Mobil', 'Toyota All New Agya', '2 koper                                                                                                                                 4 penumpang', 'Bandung', 350000, 'style/assets/agya.png', 0),
(5, 'Mobil', 'Suzuki All New Ertiga', '2 koper                                                                                                                6 penumpang', 'Yogyakarta', 375000, 'style/assets/ertiga.png', 0),
(6, 'Mobil', 'Daihatsu Terios', '2 koper                                                                                                                         6 penumpang', 'Bandung', 430000, 'style/assets/terios.png', 0),
(7, 'Motor', 'Honda Beat ', '1 koper                                                                                                                      2 penumpang', 'Jakarta', 50000, 'style/assets/beat.png', 1),
(9, 'Mobil', ' Daihatsu Sigra ', '2 koper 6 penumpang', 'Bali', 230000, 'https://ik.imagekit.io/tvlk/image/imageResource/2019/11/18/1574066228855-7d0be2649894c6d3ca5a848635832e4c.jpeg?tr=dpr-2,q-75,w-140', 0),
(11, 'Motor', ' Yamaha Fazzio', '0 koper 2 penumpang', 'Yogyakarta', 100000, 'https://ik.imagekit.io/tvlk/image/imageResource/2023/01/26/1674731305285-c2e5c5eb3dbf6d7648e5cbbc316aa87d.jpeg?tr=dpr-2,q-75,w-140', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id_vehicle`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id_vehicle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
