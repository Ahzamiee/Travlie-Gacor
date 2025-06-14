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
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `fullname` varchar(100) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_id` int(7) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`fullname`, `email`, `password`, `user_id`, `role`, `photo`) VALUES
('User', 'qiyu@gmail.com', '$2y$10$g0LEof/29D0RrXTUuQJpZOeuXvwC0h82MJW9eq9f3aUC2rp9XUb0W', 1021, 'user', 'user_1021_1749543795.png'),
('Rora', 'woy@gmail.com', '$2y$10$qjgIzJFnzLvFZwtlpNDYQOwyBbZCRTSZ5rmJsLTo1XIhEKxvqRXM2', 1025, 'user', NULL),
('kon', 'dmin@gmail.com', '$2y$10$qJcFnA8xtjOv1YzD7unge.E8Zbdy.rQr2MJL9gV4pblwsCwLdeJ5i', 1028, 'user', NULL),
('KetumDivana', 'admin@gmail.com', '$2y$10$uz.PXmFVz0YGSQKzn25TNOa6ukQ03CxeK7T5oIJSYzGG/ii.ZdkXO', 1029, 'admin', 'user_1029_1749569670.png'),
('yoofi', 'ub@gmail.com', '$2y$10$1rMm6cOqOEeCyZOLJWYDX.43X5tRrzAeoxMPkKeLFzNC0e75ESQKy', 1031, 'user', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1032;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
