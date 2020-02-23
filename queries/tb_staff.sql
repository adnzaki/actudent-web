-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Feb 2020 pada 15.30
-- Versi server: 10.1.31-MariaDB
-- Versi PHP: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_actudent`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_staff`
--

CREATE TABLE `tb_staff` (
  `staff_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `staff_nik` varchar(20) DEFAULT NULL,
  `staff_name` varchar(50) DEFAULT NULL,
  `staff_phone` varchar(20) DEFAULT NULL,
  `staff_type` varchar(20) DEFAULT NULL,
  `staff_tag` tinyint(1) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_staff`
--

INSERT INTO `tb_staff` (`staff_id`, `user_id`, `staff_nik`, `staff_name`, `staff_phone`, `staff_type`, `staff_tag`, `created`, `modified`) VALUES
(1, 4, '123456789', 'Firhan Yudha P.', '08230298484', 'teacher', 1, '2020-02-12 12:37:26', NULL),
(2, 12, '987654321', 'Uus Rusmawan Prasetyo', '083290489348', 'staff', 2, '2020-02-12 12:38:09', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_staff`
--
ALTER TABLE `tb_staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_staff`
--
ALTER TABLE `tb_staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
