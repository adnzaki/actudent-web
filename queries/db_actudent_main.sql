-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Jan 2019 pada 08.36
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
-- Database: `db_actudent_main`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_organization`
--

CREATE TABLE `tb_organization` (
  `organization_id` int(11) NOT NULL,
  `organization_name` varchar(100) NOT NULL,
  `organization_origination` varchar(500) NOT NULL,
  `organization_destination` varchar(500) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_organization`
--

INSERT INTO `tb_organization` (`organization_id`, `organization_name`, `organization_origination`, `organization_destination`, `created`, `modified`) VALUES
(1, 'SMK Negeri 1 Kota Bekasi', 'smkn1bekasi.sch.id', 'https://smkn1bekasi.actudent.com', '2019-01-30 07:35:58', '2019-01-30 07:35:58');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_organization`
--
ALTER TABLE `tb_organization`
  ADD PRIMARY KEY (`organization_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_organization`
--
ALTER TABLE `tb_organization`
  MODIFY `organization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
