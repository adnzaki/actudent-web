-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2019 at 10:02 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

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

--
-- Dumping data for table `tb_agenda`
--

INSERT INTO `tb_agenda` (`agenda_id`, `agenda_name`, `agenda_start`, `agenda_end`, `agenda_description`, `agenda_priority`, `agenda_location`, `agenda_attachment`, `user_id`, `created`, `modified`) VALUES
(6, 'Sosialisasi Ujian Nasional SMKN 999 Kota Bekasi', '2019-06-26 00:00:00', '2019-06-26 23:30:00', 'hahahahaha', 'high', 'sekolah', NULL, 1, '2019-06-26 16:51:51', '2019-06-26 16:51:51'),
(7, 'Pengumuman Kelulusan SMKN 999 Kota Bekasi', '2019-06-29 08:00:00', '2019-06-29 10:00:00', 'Semangat kalian!!!!', 'high', 'sekolah', '1561543266_4fc5d15c868b378d226a.pdf', 1, '2019-06-26 17:01:06', '2019-06-26 17:01:06'),
(21, 'Hari pertama PPDB 2019/2020 untuk SD', '2019-07-01 07:00:00', '2019-07-01 14:00:00', 'Semoga berjalan lancar', 'high', 'Sekolah', NULL, 1, '2019-06-30 14:35:51', '2019-06-30 14:35:51'),
(22, 'Agenda kita bulan depan', '2019-08-09 12:30:00', '2019-08-09 14:30:00', 'hahaha', 'normal', '', NULL, 1, '2019-07-01 20:58:14', '2019-07-01 20:58:14'),
(23, 'Mari kita beraktivitas', '2019-09-18 00:00:00', '2019-09-18 23:30:00', '', 'normal', '', NULL, 1, '2019-07-03 10:58:25', '2019-07-03 10:58:25'),
(24, 'Kita adalah siapa', '2019-10-31 10:30:00', '2019-10-31 16:30:00', '', 'low', '', NULL, 1, '2019-07-03 11:22:46', '2019-07-03 11:22:46'),
(25, 'hhahaha', '2019-11-24 10:00:00', '2019-11-24 11:30:00', 'ssssss', 'normal', '', NULL, 1, '2019-07-03 11:23:12', '2019-07-03 11:23:12'),
(26, 'Alhamdulillah udah cukup keren..', '2019-07-10 08:30:00', '2019-07-10 10:00:00', 'mantappppss', 'normal', '', NULL, 1, '2019-07-03 17:49:27', '2019-07-03 17:49:27'),
(27, 'Kegiatan apakah ini?', '2019-07-17 09:00:00', '2019-07-17 16:30:00', '', 'low', '', NULL, 1, '2019-07-15 17:27:51', '2019-07-15 17:27:51'),
(28, 'Sabtu maiiinnnn', '2019-07-20 20:30:00', '2019-07-20 22:30:00', '', 'high', 'rumah beta', NULL, 1, '2019-07-15 17:28:45', '2019-07-15 17:28:45'),
(29, 'Coba coba', '2019-07-25 00:00:00', '2019-07-25 23:30:00', '', 'high', 'hehe', NULL, 1, '2019-07-24 23:15:34', '2019-07-24 23:15:34'),
(30, 'Target selesai halaman edit', '2019-08-24 00:00:00', '2019-08-24 23:30:00', 'Hari ini form edit sudah harus selesai ya bro!!!', 'high', 'Dimana aja yg penting bisa coding', NULL, 1, '2019-08-08 12:07:43', '2019-08-08 12:07:43'),
(31, 'Alhamdulillah ternyata sudah selesai', '2019-08-17 00:00:00', '2019-08-17 23:30:00', 'mantap dah aing bisa', 'low', 'rumah', '1565292210_7dc38fb0f2bfa0632502.pdf', 1, '2019-08-09 02:23:29', '2019-08-09 02:23:29');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
