-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Bulan Mei 2020 pada 05.46
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
-- Struktur dari tabel `tb_timelog`
--

CREATE TABLE `tb_timelog` (
  `log_id` int(11) NOT NULL,
  `student_nis` varchar(20) DEFAULT NULL,
  `verifymode` tinyint(4) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `iomode` tinyint(4) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_timelog`
--

INSERT INTO `tb_timelog` (`log_id`, `student_nis`, `verifymode`, `timestamp`, `iomode`, `created`) VALUES
(1, '2015420022', 1, '2020-04-23 14:34:06', 1, '2020-04-23 16:42:09'),
(2, '1920209189', 1, '2020-04-20 14:34:06', 1, '2020-04-23 16:42:09');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_timelog`
--
ALTER TABLE `tb_timelog`
  ADD PRIMARY KEY (`log_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_timelog`
--
ALTER TABLE `tb_timelog`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
