-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2024 at 03:51 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `tb_agenda`
--

CREATE TABLE `tb_agenda` (
  `agenda_id` int(11) NOT NULL,
  `agenda_name` varchar(250) DEFAULT NULL,
  `agenda_start` datetime DEFAULT NULL,
  `agenda_end` datetime DEFAULT NULL,
  `agenda_description` text DEFAULT NULL,
  `agenda_priority` enum('high','normal','low') DEFAULT NULL,
  `agenda_location` varchar(50) DEFAULT NULL,
  `agenda_attachment` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_agenda`
--

INSERT INTO `tb_agenda` (`agenda_id`, `agenda_name`, `agenda_start`, `agenda_end`, `agenda_description`, `agenda_priority`, `agenda_location`, `agenda_attachment`, `user_id`, `created`, `modified`) VALUES
(6, 'Sosialisasi Ujian Nasional SMKN 999 Kota Bekasi', '2019-06-26 00:00:00', '2019-06-26 23:30:00', 'hahahahaha', 'high', 'sekolah', NULL, 1, '2019-06-26 09:51:51', '2019-06-26 09:51:51'),
(7, 'Pengumuman Kelulusan SMKN 999 Kota Bekasi', '2019-06-29 08:00:00', '2019-06-29 10:00:00', 'Semangat kalian!!!!', 'high', 'sekolah', '1561543266_4fc5d15c868b378d226a.pdf', 1, '2019-06-26 10:01:06', '2019-06-26 10:01:06'),
(21, 'Hari pertama PPDB 2019/2020 untuk SD', '2019-07-01 07:00:00', '2019-07-01 14:00:00', 'Semoga berjalan lancar', 'high', 'Sekolah', NULL, 1, '2019-06-30 07:35:51', '2019-06-30 07:35:51'),
(22, 'HUT RI ke-74', '2019-08-17 00:00:00', '2019-08-17 23:30:00', 'hahaha', 'normal', '', '1566879986_edb42c87f27f38713e42.pdf', 1, '2019-07-01 13:58:14', '2019-08-27 04:26:26'),
(24, 'Kita adalah siapa', '2019-10-31 10:30:00', '2019-10-31 16:30:00', '', 'low', '', NULL, 1, '2019-07-03 04:22:46', '2019-07-03 04:22:46'),
(25, 'hhahaha', '2019-11-24 10:00:00', '2019-11-24 11:30:00', 'ssssss', 'normal', '', NULL, 1, '2019-07-03 04:23:12', '2019-07-03 04:23:12'),
(26, 'Alhamdulillah udah cukup keren..', '2019-07-10 08:30:00', '2019-07-10 10:00:00', 'mantappppss', 'normal', '', NULL, 1, '2019-07-03 10:49:27', '2019-07-03 10:49:27'),
(27, 'Kegiatan apakah ini?', '2019-07-17 09:00:00', '2019-07-17 16:30:00', '', 'low', '', NULL, 1, '2019-07-15 10:27:51', '2019-07-15 10:27:51'),
(28, 'Sabtu maiiinnnn', '2019-07-20 20:30:00', '2019-07-20 22:30:00', '', 'high', 'rumah beta', NULL, 1, '2019-07-15 10:28:45', '2019-07-15 10:28:45'),
(29, 'Coba coba', '2019-07-25 00:00:00', '2019-07-25 23:30:00', '', 'high', 'hehe', NULL, 1, '2019-07-24 16:15:34', '2019-07-24 16:15:34'),
(30, 'Target selesai halaman edit', '2019-08-24 00:00:00', '2019-08-24 23:30:00', 'Hari ini form edit sudah harus selesai ya bro!!!', 'high', 'Dimana aja yg penting bisa coding', NULL, 1, '2019-08-08 05:07:43', '2019-08-19 07:58:18'),
(31, 'Alhamdulillah ternyata sudah selesai', '2019-08-19 00:00:00', '2019-08-19 23:30:00', 'mantap dah aing bisa', 'low', 'rumah', '1566546105_be2406fb37814442b20e.pdf', 1, '2019-08-08 19:23:29', '2019-08-23 07:41:45'),
(32, 'ngasal dulu', '2019-08-22 00:00:00', '2019-08-24 23:30:00', '', 'normal', '', NULL, 1, '2019-08-09 04:32:23', '2019-08-09 04:32:23'),
(33, 'hari tasyrik', '2019-08-21 00:00:00', '2019-08-21 23:30:00', 'takbir!!', 'high', '', '1566546408_31351a89a7f02372f595.pdf', 1, '2019-08-09 04:34:37', '2019-08-23 07:46:48'),
(34, 'Sekolah sehat mamen', '2019-08-21 00:00:00', '2019-08-21 23:30:00', 'ayo kita sukseskan kegiatan ini!!!', 'high', 'Sekolah', '1566546147_bcdffbb6acd53dd1371e.pdf', 1, '2019-08-10 05:17:50', '2019-08-23 07:42:26'),
(35, 'Persiapan PTS Ganjil', '2019-08-29 00:00:00', '2019-08-30 23:30:00', 'Mohon kepada bapak ibu guru partisipasinya.', 'high', 'Sekolah', '1565414411_6b3ca8d7fce3cc1c9fa8.pdf', 1, '2019-08-10 05:20:11', '2019-08-10 05:20:11'),
(36, 'Ini adalah hari sabtu', '2019-08-31 00:00:00', '2019-08-31 23:30:00', 'okeee', 'high', 'Dimana aja', '1565592050_712411f7ea42f39130d4.pdf', 1, '2019-08-12 06:40:49', '2019-08-12 06:40:49'),
(37, 'Agenda awal bulan', '2019-09-16 00:00:00', '2019-09-16 23:30:00', '', 'normal', '', NULL, 1, '2019-08-12 06:45:47', '2019-09-12 02:34:19'),
(40, 'Liburan dulu euy', '2019-08-25 06:00:00', '2019-08-25 23:30:00', '', 'high', '', '1566880075_7c08884baa0e3a13d576.pdf', 1, '2019-08-15 03:58:23', '2019-08-27 04:27:54'),
(42, 'Maulid Nabi Muhammad', '2019-11-09 07:00:00', '2019-11-09 11:00:00', '', 'high', 'Sekolah', NULL, 1, '2019-11-09 10:42:21', '2019-11-09 10:42:21'),
(43, 'Mengapa ini terjadi??', '2019-11-13 00:00:00', '2019-11-13 23:30:00', '', 'high', '', NULL, 1, '2019-11-10 03:35:39', '2019-11-10 03:35:39'),
(44, 'Refreshing dulu masbro', '2020-01-25 08:00:00', '2020-01-25 17:00:00', 'Jalan-jalan sama ndin..', 'high', 'Taman Mini dan Lubang Buaya', NULL, 1, '2020-01-24 06:36:31', '2020-01-24 06:36:31'),
(45, 'Hari belajar', '2020-03-16 00:00:00', '2020-03-16 23:30:00', '', 'normal', '', '1584002130_6fb36433707371d5b95d.pdf', 1, '2020-03-12 08:35:29', '2020-03-12 08:35:30'),
(46, 'Akhir April kita ngapain hayo?', '2020-04-30 21:30:00', '2020-05-01 09:00:00', '', 'low', 'dimana aja', '1588495530_86f422d491f4a106337d.pdf', 1, '2020-04-14 05:38:20', '2020-05-03 08:45:30'),
(47, 'Malem taun baruan', '2020-12-31 00:00:00', '2021-01-01 23:30:00', '', 'normal', 'mana aja udah', NULL, 1, '2020-04-14 06:11:47', '2020-04-14 06:23:07'),
(48, 'Makan-makan ', '2020-04-16 00:00:00', '2020-04-18 23:30:00', '', 'normal', 'Di rumah masing-masing', NULL, 1, '2020-04-14 12:57:08', '2020-04-14 12:57:08'),
(49, 'Pra-Pendaftaran Siswa Baru', '2020-06-08 08:00:00', '2020-06-13 13:00:00', 'Persiapan PPDB dimulai dengan upload berkas dan verifikasi dinas.', 'high', 'Sekolah', '1591859791_048da77417873ae22a3b.pdf', 1, '2020-06-04 04:44:50', '2020-06-11 07:18:25'),
(50, 'RAPAT SEMESTER GANJIL', '2020-06-29 09:00:00', '2020-06-29 12:00:00', '', 'high', 'RPS', NULL, 1, '2020-06-20 03:49:36', '2020-06-20 03:49:36'),
(51, 'Pendaftaran PPDB SMKN 999 Kota Bekasi', '2020-07-01 09:00:00', '2020-07-04 15:00:00', 'Mulai tanggal 1 hingga 4 Juli SMKN 999 Kota Bekasi menyelenggarakan kegiatan penerimaan peserta didik baru secara online Tahun Ajaran 2019/2020', 'high', 'Sekolah', NULL, 1, '2020-07-02 01:57:40', '2020-07-02 01:57:40'),
(52, 'Sosialisasi aplikasi Actudent', '2020-07-06 08:00:00', '2020-07-06 11:00:00', 'SMKN 999 Kota Bekasi akan mengadakan sosialisasi Actudent kepada orang tua dan guru', 'high', 'Ruang Aula', NULL, 1, '2020-07-02 02:06:09', '2020-07-02 02:06:09'),
(53, 'Menyusun laporan keuangan akhir tahun', '2020-12-29 08:00:00', '2020-12-30 16:00:00', 'ayo selesaikan', 'high', '', NULL, 1, '2020-12-29 09:31:48', '2020-12-29 09:31:48'),
(54, 'Hari pertama masuk sekolah tatap muka', '2021-01-04 07:00:00', '2021-01-04 12:00:00', '', 'normal', 'di sekolah', NULL, 1, '2021-01-01 06:47:13', '2021-01-01 06:47:13'),
(55, 'Percobaan 1', '2022-05-24 23:03:00', '2022-05-25 00:03:00', '', 'normal', '', '1653408198_4cedd6b718955067f86f.pdf', 1, '2022-05-24 16:03:20', '2022-05-24 16:03:20'),
(56, 'Percobaan 2', '2022-05-24 08:00:00', '2022-05-25 07:45:00', '', 'normal', '', '', 1, '2022-05-24 16:04:03', '2022-05-24 16:04:03'),
(57, 'rencana kita esok hari', '2022-06-17 07:00:00', '2022-06-17 09:45:00', '', 'normal', '', '', 1, '2022-06-16 16:38:48', '2022-06-16 16:38:48'),
(58, 'Persiapan HUT RI ke-77', '2022-08-10 10:00:00', '2022-08-10 12:00:00', 'Penyusunan rencana kegiatan pelaksanaan HUT RI ke-77', 'high', 'Ruang Aula', '1659585275_53fcb0e84438d874a889.pdf', 1, '2022-08-04 03:55:05', '2022-08-04 03:55:05'),
(61, 'testtttt', '2022-08-04 22:20:00', '2022-08-04 23:20:00', '', 'normal', '', '', 1, '2022-08-04 15:20:41', '2022-08-04 15:20:41'),
(64, 'testtttt', '2022-09-13 10:35:00', '2022-09-13 11:35:00', '', 'normal', '', '', 1, '2022-09-13 03:35:18', '2022-09-13 03:35:18'),
(65, 'auuuuu', '2022-09-13 10:36:00', '2022-09-13 11:36:00', '', 'normal', '', '', 1, '2022-09-13 03:36:17', '2022-09-13 03:36:17'),
(66, 'hebuuuu', '2022-09-13 10:36:00', '2022-09-13 11:36:00', '', 'normal', '', '', 1, '2022-09-13 03:36:39', '2022-09-13 03:36:39'),
(67, 'Kemaaaah coy', '2022-11-28 07:00:00', '2022-11-30 08:30:00', 'main kemah-kemahan', 'high', 'sekolah', '', 1, '2022-11-27 13:50:52', '2022-11-27 14:43:26'),
(68, 'Halal bi Halal', '2023-04-26 07:30:00', '2023-04-26 08:30:00', 'Halal bi Halal Idul Fitri di sekolah', 'high', 'Halaman Sekolah', '', 1, '2023-04-20 03:06:40', '2023-04-20 03:06:40'),
(69, 'Test agenda', '2023-08-16 20:00:00', '2023-08-16 23:00:00', '', 'normal', '', '', 1, '2023-08-16 13:18:53', '2023-08-16 13:20:17'),
(70, 'Ramah Tamah', '2024-01-18 08:00:00', '2024-01-18 11:00:00', 'Ramah tamah antar guru dan siswa di sekolah', 'high', 'Halaman Sekolah', '', 1, '2024-01-11 07:25:31', '2024-01-11 07:25:31');

-- --------------------------------------------------------

--
-- Table structure for table `tb_agenda_user`
--

CREATE TABLE `tb_agenda_user` (
  `agenda_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `present` int(11) NOT NULL DEFAULT 0,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_agenda_user`
--

INSERT INTO `tb_agenda_user` (`agenda_id`, `user_id`, `present`, `created`, `modified`) VALUES
(61, 72, 0, '2022-08-04 15:53:14', '2022-08-04 15:53:14'),
(61, 73, 0, '2022-08-04 15:53:14', '2022-08-04 15:53:14'),
(61, 4, 0, '2022-08-04 15:53:14', '2022-08-04 15:53:14'),
(68, 49, 0, '2023-04-20 03:08:05', '2023-04-20 03:08:05'),
(68, 72, 0, '2023-04-20 03:08:05', '2023-04-20 03:08:05'),
(68, 73, 0, '2023-04-20 03:08:05', '2023-04-20 03:08:05'),
(68, 4, 0, '2023-04-20 03:08:05', '2023-04-20 03:08:05'),
(68, 78, 0, '2023-04-20 03:08:05', '2023-04-20 03:08:05'),
(68, 71, 0, '2023-04-20 03:08:05', '2023-04-20 03:08:05'),
(68, 53, 0, '2023-04-20 03:08:05', '2023-04-20 03:08:05'),
(68, 69, 0, '2023-04-20 03:08:05', '2023-04-20 03:08:05'),
(68, 13, 0, '2023-04-20 03:08:05', '2023-04-20 03:08:05'),
(68, 12, 0, '2023-04-20 03:08:05', '2023-04-20 03:08:05'),
(68, 79, 0, '2023-04-20 03:08:05', '2023-04-20 03:08:05'),
(68, 80, 0, '2023-04-20 03:08:05', '2023-04-20 03:08:05'),
(68, 48, 0, '2023-04-20 03:08:05', '2023-04-20 03:08:05'),
(68, 34, 0, '2023-04-20 03:08:05', '2023-04-20 03:08:05'),
(68, 26, 0, '2023-04-20 03:08:05', '2023-04-20 03:08:05');

-- --------------------------------------------------------

--
-- Table structure for table `tb_chat`
--

CREATE TABLE `tb_chat` (
  `chat_id` int(11) NOT NULL,
  `chat_user_id` int(11) DEFAULT NULL,
  `sender` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `read_status` int(11) DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_chat`
--

INSERT INTO `tb_chat` (`chat_id`, `chat_user_id`, `sender`, `content`, `read_status`, `created`) VALUES
(1, 1, 1, 'selamat siang pak rizal', 1, '2020-12-23 04:48:29'),
(2, 1, 53, 'siang pak zaki', 1, '2020-12-23 04:49:02'),
(3, 1, 1, 'halo halo', 1, '2021-01-07 07:27:31'),
(4, 1, 1, 'hai hai', 1, '2021-01-07 07:29:41'),
(5, 1, 1, 'hai juga..', 1, '2021-01-13 05:07:57'),
(6, 1, 1, 'eh itu kan saya sendiri', 1, '2021-01-13 05:08:03'),
(7, 1, 53, 'apasih astaghfirullah..', 1, '2021-01-19 03:21:07'),
(8, 1, 1, 'ngga', 0, '2021-02-07 10:10:59');

-- --------------------------------------------------------

--
-- Table structure for table `tb_chat_users`
--

CREATE TABLE `tb_chat_users` (
  `chat_user_id` int(11) NOT NULL,
  `participant_1` varchar(5) DEFAULT NULL,
  `participant_2` varchar(5) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_chat_users`
--

INSERT INTO `tb_chat_users` (`chat_user_id`, `participant_1`, `participant_2`, `created`) VALUES
(1, '1', '53', '2020-12-23 04:48:29');

-- --------------------------------------------------------

--
-- Table structure for table `tb_grade`
--

CREATE TABLE `tb_grade` (
  `grade_id` int(11) NOT NULL,
  `grade_name` varchar(50) DEFAULT NULL,
  `period_start` varchar(4) DEFAULT NULL,
  `period_end` varchar(4) DEFAULT NULL,
  `teacher_id` int(11) NOT NULL,
  `grade_status` tinyint(1) DEFAULT NULL,
  `rombel_dapodik_id` varchar(50) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_grade`
--

INSERT INTO `tb_grade` (`grade_id`, `grade_name`, `period_start`, `period_end`, `teacher_id`, `grade_status`, `rombel_dapodik_id`, `deleted`, `created`, `modified`) VALUES
(1, 'X TKJ 2', '2022', '2023', 2, 1, NULL, 1, '2019-03-29 05:51:07', '2022-09-08 08:15:04'),
(2, 'X Grafika 1', '2022', '2023', 10, 0, NULL, 0, '2019-03-28 07:37:57', '2023-09-07 05:30:44'),
(3, 'X TKJ 1', '2022', '2023', 1, 0, NULL, 0, '2019-03-29 05:54:53', '2023-09-07 05:30:31'),
(6, 'X Animasi 1', '2021', '2022', 2, 1, NULL, 0, '2020-03-11 15:22:07', '2022-09-26 14:39:19'),
(7, 'X TKJ 2', '2022', '2023', 4, 1, NULL, 1, '2020-04-03 14:02:17', '2022-09-08 08:15:04'),
(8, 'X Animasi 1', '2022', '2023', 2, 0, NULL, 0, '2022-09-26 08:50:51', '2023-09-07 05:35:37'),
(9, 'XI Animasi 1', '2022', '2023', 7, 0, NULL, 0, '2023-04-17 06:59:35', '2023-09-07 05:35:37'),
(10, 'XI Animasi 2', '2022', '2023', 14, 1, NULL, 1, '2023-04-17 07:03:12', '2023-04-17 07:09:09'),
(11, 'X Grafika', '2023', '2024', 1, 1, NULL, 0, '2023-07-06 04:13:05', '2023-07-06 04:13:05'),
(12, 'XI TKJ 1', '2023', '2024', 8, 1, NULL, 0, '2023-09-07 05:29:13', '2023-09-07 05:38:29'),
(13, 'X Grafika 1', '2023', '2024', 10, 1, NULL, 0, '2023-09-07 05:30:44', '2023-09-07 05:30:44'),
(14, 'X Animasi 1', '2023', '2024', 2, 1, NULL, 0, '2023-09-07 05:35:37', '2023-09-07 05:35:37'),
(15, 'XII Animasi 1', '2023', '2024', 7, 1, NULL, 0, '2023-09-07 05:35:37', '2023-09-07 05:38:13');

-- --------------------------------------------------------

--
-- Table structure for table `tb_homework`
--

CREATE TABLE `tb_homework` (
  `journal_id` int(11) NOT NULL,
  `homework_title` varchar(300) DEFAULT NULL,
  `homework_description` varchar(500) DEFAULT NULL,
  `due_date` timestamp NULL DEFAULT NULL,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_homework`
--

INSERT INTO `tb_homework` (`journal_id`, `homework_title`, `homework_description`, `due_date`, `created`, `modified`) VALUES
(40, 'Tugas Harian 1', 'Kerjakan tugas halaman sekian pada buku ini', '2020-07-08 16:46:36', '2020-06-30 23:46:36', '2020-06-30 23:46:36'),
(47, 'Menjadi warga negara yang baik', 'Cobalah menjadi warga negara yang bijaksana, jangan ugal-ugalan', '2020-07-21 17:32:16', '2020-07-01 00:32:16', '2020-07-01 00:32:16'),
(48, 'beli kertas plano', 'coba kalian cari tau berapa harga kertas plano sekarang', '2020-07-16 16:59:00', '2020-07-09 05:55:13', '2020-07-09 05:55:13'),
(62, 'Nilai-nilai pancasila', 'menyebutkan 5 contoh sikap pelajar yang menggambarkan nilai-nilai pancasial', '2020-07-16 21:30:54', '2020-07-10 04:30:54', '2020-07-10 04:30:54'),
(70, 'kalkulasi grafik', 'mengerjakn tugas lks halaman 28-29', '2020-07-17 19:24:23', '2020-07-11 02:24:23', '2020-07-11 02:24:23'),
(77, 'Mempelajari hukum newton', 'coba itu', '2020-07-23 16:59:00', '2020-07-16 05:51:41', '2020-07-16 07:01:40'),
(81, 'Tugas mengarang puisi', 'Coba buat', '2020-07-23 16:59:00', '2020-07-16 09:37:55', '2020-07-16 09:37:55'),
(82, 'Menghitung harga kertas', 'Cobalah hitung harga kertas ya! ', '2020-08-01 16:59:00', '2020-07-27 06:42:39', '2020-07-27 06:42:39'),
(84, 'Menanam toge', 'Coba praktekkan di rumah masing-masing', '2020-09-11 16:59:00', '2020-09-03 23:56:12', '2020-09-03 23:56:12'),
(85, 'Membuat pesawat cerita masa kecil', 'Ceritakan dengan bahasa inggris yang baik dan benar ', '2020-09-11 16:59:00', '2020-09-03 23:59:14', '2020-09-03 23:59:14'),
(92, 'melanjutkan tugas dari sekolah', 'coba buatlah cerpen yang oke', '2020-09-30 16:59:00', '2020-09-23 04:35:56', '2020-09-23 04:35:56'),
(96, 'Kalkulasi Grafika Dasar', 'Mengerjakan LKS hal 34 - 37', '2020-11-03 22:36:49', '2020-10-28 05:36:37', '2020-10-28 05:36:49'),
(97, 'Membuat gambar 2D', 'Silakan buat gambar 2D sederhana menggunakan Adobe illustrator', '2020-11-06 22:48:03', '2020-11-01 05:48:03', '2020-11-01 05:48:03'),
(104, 'tata bahasa dirumah', 'belajar bicara bahasa inggris bersama mama papa', '2021-01-20 16:59:00', '2021-01-13 05:21:05', '2021-01-13 05:21:05'),
(125, 'Membuat segitiga sama kaki', 'Coba kerjakan dengan kaki anda', '2022-02-21 16:59:00', '2022-02-21 02:23:32', '2022-02-21 02:23:32'),
(126, 'membuat apa saja yang kau bisa', 'sama kaya judulnya', '2022-02-21 16:59:00', '2022-02-21 04:23:25', '2022-02-21 04:23:25'),
(128, 'Membeli kertas plano', 'Membeli kertas plano', '2022-02-24 16:59:00', '2022-02-22 02:18:24', '2022-02-22 02:18:24'),
(129, 'Mencari contoh makhluk hidup', 'Seperti hewan, tumbuhan, dll...', '2022-02-24 16:59:00', '2022-02-22 02:21:30', '2022-02-22 02:21:30'),
(130, 'Input tugas rumah', 'uraian tugasnya..', '2022-02-24 16:59:00', '2022-02-22 02:26:24', '2022-02-22 02:26:24'),
(131, 'Menulis karya puisi sendiri', 'Dikerjakan di rumah', '2022-02-24 16:59:00', '2022-02-22 05:19:36', '2022-02-22 05:19:36'),
(132, 'Menulis karya puisi sendiri', 'Dikerjakan di rumah', '2022-02-24 16:59:00', '2022-02-22 05:20:19', '2022-02-22 05:20:19'),
(147, 'Membuat puisi pendek', 'cobalah buat puisi pendek', '2023-04-25 16:59:00', '2023-04-18 06:25:08', '2023-04-18 06:25:08');

-- --------------------------------------------------------

--
-- Table structure for table `tb_journal`
--

CREATE TABLE `tb_journal` (
  `journal_id` int(11) NOT NULL,
  `schedule_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_archive` int(11) NOT NULL DEFAULT 0,
  `journal_date` date DEFAULT current_timestamp(),
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_journal`
--

INSERT INTO `tb_journal` (`journal_id`, `schedule_id`, `description`, `is_archive`, `journal_date`, `created`, `modified`) VALUES
(38, 71, 'MATERI 1', 0, '2020-06-22', '2020-06-22 10:43:57', '2022-03-05 21:29:01'),
(39, 71, 'Oke', 0, '2020-06-08', '2020-06-08 17:54:06', '2022-03-05 21:29:01'),
(40, 72, 'Belajar membuat pesawat sederhana', 0, '2020-07-01', '2020-07-01 22:58:17', '2022-03-05 21:29:01'),
(41, 72, 'Belajar membuat pesawat sederhana', 0, '2020-07-01', '2020-07-01 23:00:15', '2022-03-05 21:29:01'),
(42, 72, 'Belajar membuat pesawat sederhana', 0, '2020-07-01', '2020-07-01 23:00:25', '2022-03-05 21:29:01'),
(43, 72, 'Belajar membuat pesawat sederhana', 0, '2020-07-01', '2020-07-01 23:00:32', '2022-03-05 21:29:01'),
(44, 72, 'Belajar membuat pesawat sederhana', 0, '2020-07-01', '2020-07-01 23:01:15', '2022-03-05 21:29:01'),
(45, 72, 'Belajar membuat pesawat sederhana', 0, '2020-07-01', '2020-07-01 23:02:02', '2022-03-05 21:29:01'),
(46, 72, 'Belajar membuat pesawat sederhana', 0, '2020-07-01', '2020-07-01 23:07:20', '2022-03-05 21:29:01'),
(47, 76, 'Menghafal pancasila', 0, '2020-07-01', '2020-07-01 00:29:08', '2022-03-05 21:29:01'),
(48, 85, 'menghitung kertas plano untuk dicetak', 0, '2020-07-09', '2020-07-09 12:55:13', '2022-03-05 21:29:01'),
(49, 78, 'Belajar berbahasa sesuai kaidah', 0, '2020-07-09', '2020-07-09 12:57:00', '2022-03-05 21:29:01'),
(50, 72, 'Membuat pesawat sederhana', 0, '2020-07-08', '2020-07-08 12:57:48', '2022-03-05 21:29:01'),
(51, 82, 'Mempelajari past tense', 0, '2020-07-08', '2020-07-08 12:58:10', '2022-03-05 21:29:01'),
(52, 83, 'belajar hitung ruas kapal', 0, '2020-07-09', '2020-07-09 13:00:02', '2022-03-05 21:29:01'),
(53, 79, 'Meminta maaf dalam bahasa inggris', 0, '2020-07-03', '2020-07-03 13:33:30', '2022-03-05 21:29:01'),
(54, 75, 'Melakukan lari sekitar 2km', 0, '2020-07-08', '2020-07-08 13:36:13', '2022-03-05 21:29:01'),
(55, 76, 'Mempelajari arti dari UUD 1945', 0, '2020-07-08', '2020-07-08 13:37:37', '2022-03-05 21:29:01'),
(56, 77, 'Mempelajari Makna Pancasila', 0, '2020-07-08', '2020-07-08 13:37:59', '2022-03-05 21:29:01'),
(57, 84, 'Memahami Pembelajaran fotosintesis', 0, '2020-07-03', '2020-07-03 13:41:53', '2022-03-05 21:29:01'),
(58, 71, 'Belajar Rumus', 0, '2020-07-06', '2020-07-06 13:42:44', '2022-03-05 21:29:01'),
(59, 81, 'Belajar BIkin Cerpen', 0, '2020-07-07', '2020-07-07 13:43:27', '2022-03-05 21:29:01'),
(60, 84, 'Memahami tahapan reproduksi ', 0, '2020-07-10', '2020-07-10 08:33:23', '2022-03-05 21:29:01'),
(61, 79, 'Tata bahasa', 0, '2020-07-10', '2020-07-10 08:34:00', '2022-03-05 21:29:01'),
(62, 86, 'Melafalkan pancasila', 0, '2020-07-10', '2020-07-10 09:59:31', '2022-03-05 21:29:01'),
(63, 96, 'Mempelajari dasar-dasar warna', 1, '2020-07-10', '2020-07-10 13:49:56', '2022-03-05 21:29:01'),
(64, 85, 'Dasar dasar desain grafis', 0, '2020-07-10', '2020-07-10 07:46:04', '2022-03-05 21:29:01'),
(65, 85, 'Dasar dasar desain grafis', 0, '2020-07-10', '2020-07-10 07:46:20', '2022-03-05 21:29:01'),
(66, 85, 'Dasar dasar desain grafis', 0, '2020-07-10', '2020-07-10 07:47:11', '2022-03-05 21:29:01'),
(67, 87, 'aku padamu', 0, '2020-07-10', '2020-07-10 07:50:00', '2022-03-05 21:29:01'),
(68, 90, 'Photoshop enterprise 1', 0, '2020-07-10', '2020-07-10 07:51:30', '2022-03-05 21:29:01'),
(69, 97, 'Design grafis', 0, '2020-07-11', '2020-07-11 08:46:32', '2022-03-05 21:29:01'),
(70, 99, 'Dasar perhitungan grafika', 0, '2020-07-11', '2020-07-11 02:21:13', '2022-03-05 21:29:01'),
(71, 101, 'Pengenalan komputer', 0, '2020-07-11', '2020-07-11 08:23:27', '2022-03-05 21:29:01'),
(72, 92, 'belajar', 0, '2020-07-10', '2020-07-10 23:22:27', '2022-03-05 21:29:01'),
(73, 92, 'belajar', 0, '2020-07-10', '2020-07-10 23:22:56', '2022-03-05 21:29:01'),
(74, 89, 'belajar', 0, '2020-07-10', '2020-07-10 23:58:35', '2022-03-05 21:29:01'),
(75, 94, 'Pengenalan dasar komputet', 1, '2020-07-10', '2020-07-10 03:46:42', '2022-03-05 21:29:01'),
(76, 85, 'ini ngapain ya?', 0, '2020-07-17', '2020-07-17 03:47:27', '2022-03-05 21:29:01'),
(77, 72, 'Gaya gravitasi', 0, '2020-07-15', '2020-07-15 12:48:12', '2022-03-05 21:29:01'),
(78, 97, 'desain bebas', 0, '2020-07-04', '2020-07-04 07:18:12', '2022-03-05 21:29:01'),
(79, 97, 'desain bebas', 0, '2020-07-04', '2020-07-04 07:19:01', '2022-03-05 21:29:01'),
(80, 99, 'cara ngitung utang', 0, '2020-07-04', '2020-07-04 07:21:36', '2022-03-05 21:29:01'),
(81, 78, 'Membuat puisi', 0, '2020-07-16', '2020-07-16 16:36:00', '2022-03-05 21:29:01'),
(82, 97, 'Kalkulasi grafika', 0, '2020-07-25', '2020-07-25 13:42:39', '2022-03-05 21:29:01'),
(83, 85, 'Belajar vektor', 0, '2020-08-07', '2020-08-07 06:22:25', '2022-03-05 21:29:01'),
(84, 84, 'Menanam tanaman', 0, '2020-09-04', '2020-09-04 06:55:08', '2022-03-05 21:29:01'),
(85, 79, 'Past tense ', 0, '2020-09-04', '2020-09-04 06:57:17', '2022-03-05 21:29:01'),
(86, 85, 'Menghitung biaya cetak ', 0, '2020-09-18', '2020-09-18 15:14:14', '2022-03-05 21:29:01'),
(87, 85, 'menghitung biaya cetak', 0, '2020-09-25', '2020-09-25 11:31:29', '2022-03-05 21:29:01'),
(88, 89, 'menghitung apa saja', 0, '2020-09-18', '2020-09-18 11:32:28', '2022-03-05 21:29:01'),
(89, 75, 'belajar kayang', 0, '2020-09-23', '2020-09-23 11:33:33', '2022-03-05 21:29:01'),
(90, 72, 'aerospace...', 0, '2020-09-23', '2020-09-23 11:33:55', '2022-03-05 21:29:01'),
(91, 82, 'belajar past tense', 0, '2020-09-23', '2020-09-23 11:34:18', '2022-03-05 21:29:01'),
(92, 81, 'membuat cerpen', 0, '2020-09-22', '2020-09-22 11:35:56', '2022-03-05 21:29:01'),
(93, 71, 'membuat bangun ruang', 0, '2020-09-21', '2020-09-21 11:36:40', '2022-03-05 21:29:01'),
(94, 86, 'Menghafal pancasila', 0, '2020-10-02', '2020-10-02 06:45:12', '2022-03-05 21:29:01'),
(95, 85, 'belajar lagi menghitung ongkos cetak', 0, '2020-10-02', '2020-10-02 09:54:14', '2022-03-05 21:29:01'),
(96, 85, 'Pengantar Kalkulasi Grafika', 0, '2020-10-23', '2020-10-23 05:33:36', '2022-03-05 21:29:01'),
(97, 97, 'Dasar-dasar illustrator', 0, '2020-10-31', '2020-10-31 05:46:35', '2022-03-05 21:29:01'),
(98, 79, 'Past tense', 0, '2020-11-13', '2020-11-13 13:01:08', '2022-03-05 21:29:01'),
(99, 97, 'masukkkk', 0, '2020-11-21', '2020-11-21 11:55:07', '2022-03-05 21:29:01'),
(100, 78, 'Belajar membaca', 0, '2020-12-24', '2020-12-24 14:36:02', '2022-03-05 21:29:01'),
(101, 81, 'belajar bikin puisi', 0, '2021-01-05', '2021-01-05 11:48:56', '2022-03-05 21:29:01'),
(102, 75, 'kayang dengan satu tangan', 0, '2021-01-13', '2021-01-13 12:19:34', '2022-03-05 21:29:01'),
(103, 72, 'astrologi..', 0, '2021-01-13', '2021-01-13 12:20:00', '2022-03-05 21:29:01'),
(104, 82, 'belajar grammar terus ora ada udahnya', 0, '2021-01-13', '2021-01-13 12:20:31', '2022-03-05 21:29:01'),
(105, 86, 'kumparan', 0, '2021-01-15', '2021-01-15 15:52:29', '2022-03-05 21:29:01'),
(106, 79, 'grammar', 0, '2021-01-15', '2021-01-15 15:52:58', '2022-03-05 21:29:01'),
(107, 84, 'biologis', 0, '2021-01-15', '2021-01-15 15:53:17', '2022-03-05 21:29:01'),
(108, 99, 'menghitung harga kertas plano', 0, '2021-01-18', '2021-01-18 10:21:26', '2022-03-05 21:29:01'),
(109, 85, 'Menghitung grafika', 0, '2021-01-15', '2021-01-15 09:07:37', '2022-03-05 21:29:01'),
(110, 86, 'Menulis norma norma kehidupan berbangsa', 0, '2021-01-22', '2021-01-22 22:04:21', '2022-03-05 21:29:01'),
(111, 85, 'Menghitung ongkos cetak undangan ', 0, '2021-01-22', '2021-01-22 22:08:56', '2022-03-05 21:29:01'),
(112, 103, 'ss', 0, '2021-02-04', '2021-02-04 19:44:27', '2022-03-05 21:29:01'),
(113, 78, 'aa', 0, '2021-02-04', '2021-02-04 19:44:40', '2022-03-05 21:29:01'),
(114, 83, 'mm', 0, '2021-02-04', '2021-02-04 19:44:58', '2022-03-05 21:29:01'),
(115, 82, 'uu', 0, '2021-02-03', '2021-02-03 19:45:15', '2022-03-05 21:29:01'),
(116, 75, 'rr', 0, '2021-02-03', '2021-02-03 19:45:31', '2022-03-05 21:29:01'),
(117, 72, 'ab', 0, '2021-02-03', '2021-02-03 19:45:49', '2022-03-05 21:29:01'),
(118, 107, 'se', 0, '2021-02-02', '2021-02-02 19:46:04', '2022-03-05 21:29:01'),
(119, 106, 'rt', 1, '2021-02-02', '2021-02-02 19:46:19', '2022-03-05 21:29:01'),
(120, 81, 'aa', 0, '2021-02-02', '2021-02-02 19:46:36', '2022-03-05 21:29:01'),
(121, 99, 'pp', 0, '2021-02-01', '2021-02-01 19:47:10', '2022-03-05 21:29:01'),
(122, 71, 'ty', 0, '2021-02-01', '2021-02-01 19:47:30', '2022-03-05 21:29:01'),
(123, 108, 'lo', 0, '2021-02-01', '2021-02-01 19:48:06', '2022-03-05 21:29:01'),
(124, 86, 'Menjadi warga negara...\r\n', 0, '2021-02-26', '2021-02-26 02:06:36', '2022-03-05 21:29:01'),
(125, 71, 'Menghitung luas segitiga', 0, '2022-02-21', '2022-02-21 09:23:32', '2022-03-05 21:29:01'),
(126, 111, 'kita coba yaa...', 0, '2022-02-21', '2022-02-21 10:08:47', '2022-03-05 21:29:01'),
(127, 114, 'BPJS tai entut', 0, '2022-02-22', '2022-02-22 08:58:25', '2022-03-05 21:29:01'),
(128, 85, 'Menghitung kertas plano', 0, '2022-02-22', '2022-02-22 09:18:24', '2022-03-05 21:29:01'),
(129, 107, 'Mengenal kehidupan makhluk hidup', 0, '2022-02-22', '2022-02-22 09:21:30', '2022-03-05 21:29:01'),
(130, 81, 'Judul jurnal', 0, '2022-02-22', '2022-02-22 09:26:24', '2022-03-05 21:29:01'),
(131, 111, 'Memahami isi puisi', 0, '2022-02-14', '2022-02-14 12:19:36', '2022-03-05 21:29:01'),
(132, 119, 'Memahami isi puisi', 0, '2022-02-14', '2022-02-14 12:20:19', '2022-03-05 21:29:01'),
(133, 71, 'Mempelajari aljabar linear', 0, '2022-02-14', '2022-02-14 21:52:25', '2022-03-05 21:29:01'),
(134, 111, 'test 1', 0, '2022-02-28', '2022-02-28 01:59:04', '2022-03-05 21:29:01'),
(135, 119, 'test 1', 0, '2022-02-28', '2022-02-28 01:59:29', '2022-03-05 21:29:01'),
(136, 71, 'test 2', 0, '2022-02-28', '2022-02-28 01:59:46', '2022-03-05 21:29:01'),
(137, 83, 'test aja dulu..', 0, '2022-07-14', '2022-07-14 23:35:02', '2022-07-14 23:35:02'),
(138, 83, 'belajar matematika', 0, '2022-08-04', '2022-08-04 11:11:55', '2022-08-04 11:11:55'),
(139, 78, 'membuat puisi', 0, '2022-08-04', '2022-08-04 11:17:09', '2022-08-04 11:17:09'),
(140, 123, 'Pelajaran pertama hari ini', 0, '2022-11-21', '2022-11-21 11:19:31', '2022-11-21 11:19:31'),
(141, 129, 'Mengamati pergerakan bintang', 0, '2022-11-24', '2022-11-24 15:42:53', '2022-11-24 15:42:53'),
(142, 130, 'menjadi warga negara', 0, '2022-11-24', '2022-11-24 15:46:34', '2022-11-24 15:46:34'),
(143, 103, 'molekul atom', 0, '2022-11-24', '2022-11-24 15:48:40', '2022-11-24 15:48:40'),
(144, 131, 'gerak bumi dan gaya', 0, '2022-11-25', '2022-11-25 09:16:01', '2022-11-25 09:16:01'),
(145, 132, 'luas segitiga', 0, '2022-11-25', '2022-11-25 09:17:17', '2022-11-25 09:17:17'),
(146, 125, 'mamam lu peyot', 0, '2022-11-26', '2022-11-22 21:07:25', '2022-11-26 21:07:25'),
(147, 125, 'Tatanan bahasa dalam puisi', 0, '2023-04-18', '2023-04-18 13:25:08', '2023-04-18 13:25:08'),
(148, 75, 'Lompat-lompat', 0, '2023-04-19', '2023-04-19 10:37:50', '2023-04-19 10:37:50'),
(149, 137, 'menghitung luas segitiga', 0, '2023-07-06', '2023-07-06 22:37:00', '2023-07-06 22:37:00'),
(150, 137, 'Rumus segitiga', 0, '2023-08-11', '2023-08-10 15:26:22', '2023-08-11 22:26:22'),
(151, 139, 'Menghitung volume segitiga', 0, '2023-08-15', '2023-08-15 05:40:02', '2023-08-15 12:40:02'),
(152, 139, 'menghitung luas segitiga', 0, '2023-08-22', '2023-08-22 22:25:41', '2023-08-22 22:25:41'),
(153, 137, 'menghitung luas persegi', 0, '2023-08-23', '2023-08-17 10:08:52', '2023-08-23 10:08:52'),
(154, 148, 'Menjadi warga negara yang baik', 0, '2023-09-06', '2023-09-06 15:11:43', '2023-09-06 15:11:43'),
(155, 149, 'Belajar kayang', 0, '2023-09-06', '2023-09-06 15:49:36', '2023-09-06 15:49:36'),
(156, 139, 'Belajar menghitung volume tabunggg', 0, '2023-09-06', '2023-09-05 20:12:18', '2023-09-06 20:14:04'),
(157, 139, 'Menghitung luas lingkaran', 0, '2023-09-06', '2023-08-29 20:16:51', '2023-09-06 20:16:51'),
(158, 148, 'Menghafal pancasila', 0, '2023-09-06', '2023-08-30 20:17:57', '2023-09-06 20:17:57'),
(159, 149, 'belajar main bola di lapangan hehee', 0, '2023-09-06', '2023-08-30 20:19:35', '2023-09-06 20:20:47'),
(160, 148, 'Memiliki sikap tenggang rasa', 0, '2023-09-06', '2023-08-23 21:10:44', '2023-09-06 21:10:44'),
(161, 149, 'Memulai pola hidup sehat', 0, '2023-08-23', '2023-08-23 21:11:18', '2023-09-06 22:38:51'),
(162, 150, 'Belajar tenses sampe 16', 0, '2023-09-06', '2023-09-06 23:00:41', '2023-09-06 23:00:41'),
(163, 148, 'Menghafal pancasila', 0, '2023-08-16', '2023-08-16 23:01:44', '2023-09-06 23:01:44'),
(164, 149, 'Belajar main voli', 0, '2023-08-16', '2023-08-16 23:03:28', '2023-09-06 23:03:28'),
(165, 150, 'Simple present tense', 0, '2023-08-16', '2023-08-16 23:08:15', '2023-09-06 23:08:15');

-- --------------------------------------------------------

--
-- Table structure for table `tb_lessons`
--

CREATE TABLE `tb_lessons` (
  `lesson_id` int(11) NOT NULL,
  `lesson_code` varchar(50) NOT NULL,
  `lesson_name` varchar(100) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_lessons`
--

INSERT INTO `tb_lessons` (`lesson_id`, `lesson_code`, `lesson_name`, `deleted`, `created`, `modified`) VALUES
(1, 'MTK', 'Matematika', 0, '2020-03-21 12:44:18', '2020-03-21 12:44:18'),
(2, 'BIND', 'Bahasa Indonesia', 0, '2020-03-21 12:44:18', '2020-03-21 12:44:18'),
(3, 'BING', 'Bahasa Inggris', 0, '2020-03-21 12:44:18', '2020-03-21 12:44:18'),
(4, 'PAI', 'Pendidikan Agama Islam', 0, '2020-03-21 12:44:18', '2020-03-21 12:44:18'),
(5, 'PKN', 'Pendidikan Kewarganegaraan', 0, '2020-03-21 12:44:18', '2020-03-21 12:44:18'),
(6, 'PJOK', 'Pendidikan Jasmani, Olahraga dan Kesehatan', 0, '2020-03-21 12:44:18', '2020-03-21 12:44:18'),
(7, 'IPS', 'Ilmu Pengetahuan Sosial', 0, '2020-04-05 12:11:11', '2020-04-05 12:11:11'),
(8, 'PLH', 'Pendidikan Lingkungan Hidup', 0, '2020-04-05 12:11:55', '2020-04-05 12:11:55'),
(9, 'FSK', 'Fisika', 0, '2020-04-17 10:10:07', '2020-04-17 10:10:07'),
(10, 'KMA', 'Kimia', 0, '2020-04-17 10:10:16', '2020-04-17 10:10:16'),
(11, 'BIO', 'Biologi', 0, '2020-04-17 10:10:24', '2020-04-17 10:10:24'),
(12, 'PRD', 'Pemrograman Dasar', 0, '2020-04-17 10:10:58', '2020-04-17 10:10:58'),
(13, 'KGRF', 'Kalkulasi Grafika', 0, '2020-05-28 22:51:38', '2020-05-28 22:51:38'),
(14, 'DGR', 'Desain Grafis', 0, '2020-05-28 22:51:50', '2020-05-28 22:51:50'),
(15, 'IKOM', 'Instalasi Komputer', 0, '2020-07-09 05:42:05', '2020-07-09 05:42:05'),
(16, 'PRG', 'Pemrograman Dasar', 1, '2020-07-09 05:43:19', '2021-01-13 05:09:24'),
(17, 'KLK', 'Kalkulussss', 1, '2023-04-17 07:29:05', '2023-04-17 07:29:32');

-- --------------------------------------------------------

--
-- Table structure for table `tb_lessons_grade`
--

CREATE TABLE `tb_lessons_grade` (
  `lessons_grade_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_lessons_grade`
--

INSERT INTO `tb_lessons_grade` (`lessons_grade_id`, `lesson_id`, `grade_id`, `teacher_id`, `deleted`, `created`, `modified`) VALUES
(30, 1, 6, 2, 0, '2020-06-20 03:42:44', '2020-06-20 03:42:44'),
(31, 1, 3, 1, 0, '2020-06-30 22:54:56', '2020-06-30 22:54:56'),
(32, 9, 3, 3, 0, '2020-06-30 22:55:13', '2020-06-30 22:55:13'),
(33, 11, 3, 7, 0, '2020-06-30 22:55:50', '2020-06-30 22:55:50'),
(34, 5, 2, 3, 0, '2020-07-01 00:27:02', '2020-07-01 00:27:02'),
(35, 6, 2, 8, 0, '2020-07-01 00:27:35', '2020-07-01 00:27:35'),
(36, 2, 3, 4, 0, '2020-07-02 01:52:41', '2020-07-02 01:52:41'),
(37, 3, 3, 9, 0, '2020-07-02 01:52:54', '2020-07-02 01:52:54'),
(38, 16, 3, 6, 0, '2020-07-09 05:46:06', '2020-07-09 05:46:06'),
(39, 2, 6, 4, 0, '2020-07-09 05:46:36', '2020-07-09 05:46:36'),
(40, 3, 6, 4, 0, '2020-07-09 05:46:47', '2020-07-09 05:46:47'),
(41, 11, 6, 5, 0, '2020-07-09 05:47:02', '2020-07-09 05:47:02'),
(42, 13, 2, 10, 0, '2020-07-09 05:47:35', '2020-07-10 05:48:38'),
(43, 1, 2, 1, 0, '2020-07-09 05:47:45', '2020-07-09 05:47:45'),
(44, 10, 6, 3, 0, '2020-07-10 04:56:30', '2020-07-10 04:56:30'),
(45, 14, 3, 10, 0, '2020-07-10 05:54:11', '2020-07-10 05:54:11'),
(46, 14, 6, 10, 0, '2020-07-10 05:55:47', '2020-07-10 05:55:47'),
(47, 10, 2, 6, 0, '2021-01-13 05:10:01', '2021-01-13 05:10:01'),
(48, 5, 2, 5, 1, '2021-01-13 05:11:09', '2021-01-13 05:16:28'),
(49, 4, 6, 1, 1, '2022-07-07 17:00:07', '2022-07-07 17:00:21'),
(50, 4, 6, 11, 1, '2022-07-14 16:19:59', '2022-07-14 16:20:09'),
(51, 2, 8, 1, 0, '2022-11-21 04:18:51', '2022-11-21 04:18:51'),
(52, 9, 8, 6, 0, '2022-11-22 01:55:33', '2022-11-22 01:55:33'),
(53, 5, 8, 8, 0, '2022-11-22 01:55:40', '2022-11-22 01:55:40'),
(54, 1, 9, 1, 0, '2023-04-18 05:09:59', '2023-04-18 05:09:59'),
(55, 2, 9, 8, 0, '2023-04-18 05:17:14', '2023-04-18 05:17:22'),
(56, 1, 11, 1, 0, '2023-07-06 04:13:56', '2023-07-06 04:13:56'),
(57, 3, 11, 1, 0, '2023-07-06 04:14:08', '2023-08-06 14:33:39'),
(58, 2, 11, 4, 0, '2023-07-06 04:24:04', '2023-07-06 04:24:04'),
(59, 4, 11, 8, 0, '2023-07-06 04:26:03', '2023-07-06 04:26:03'),
(60, 5, 11, 15, 0, '2023-07-06 04:29:08', '2023-07-06 04:29:08'),
(61, 6, 11, 14, 0, '2023-07-06 04:29:48', '2023-07-06 04:29:48');

-- --------------------------------------------------------

--
-- Table structure for table `tb_logins`
--

CREATE TABLE `tb_logins` (
  `login_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(20) DEFAULT NULL,
  `platform` varchar(50) DEFAULT NULL,
  `browser` varchar(50) DEFAULT NULL,
  `location` varchar(150) DEFAULT NULL,
  `login_time` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_logins`
--

INSERT INTO `tb_logins` (`login_id`, `user_id`, `ip_address`, `platform`, `browser`, `location`, `login_time`) VALUES
(1, 1, '127.0.0.1', 'Desktop (Windows 10)', 'Firefox 122.0', 'The address 127.0.0.1 is not in the database.', '2024-02-08 06:27:06'),
(2, 1, '::1', 'Desktop (Windows 10)', 'Chrome 121.0.0.0', 'The address ::1 is not in the database.', '2024-02-08 06:27:35'),
(3, 1, '::1', 'Desktop (Windows 10)', 'Chrome 121.0.0.0', 'The address ::1 is not in the database.', '2024-02-08 06:28:34'),
(4, 1, '127.0.0.1', 'Desktop (Windows 10)', 'Firefox 122.0', 'The address 127.0.0.1 is not in the database.', '2024-02-09 04:45:33'),
(5, 1, '127.0.0.1', 'Desktop (Windows 10)', 'Firefox 122.0', 'The address 127.0.0.1 is not in the database.', '2024-02-11 14:27:39'),
(6, 1, '127.0.0.1', 'Desktop (Windows 10)', 'Firefox 122.0', 'The address 127.0.0.1 is not in the database.', '2024-02-11 16:30:48'),
(7, 1, '::1', 'Desktop (Windows 10)', 'Chrome 121.0.0.0', 'The address ::1 is not in the database.', '2024-02-11 16:32:31');

-- --------------------------------------------------------

--
-- Table structure for table `tb_parent`
--

CREATE TABLE `tb_parent` (
  `parent_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_family_card` varchar(18) DEFAULT NULL,
  `parent_father_name` varchar(100) DEFAULT NULL,
  `parent_mother_name` varchar(100) DEFAULT NULL,
  `parent_phone_number` varchar(15) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_parent`
--

INSERT INTO `tb_parent` (`parent_id`, `user_id`, `parent_family_card`, `parent_father_name`, `parent_mother_name`, `parent_phone_number`, `deleted`, `created`, `modified`) VALUES
(1, 14, '3273987984273984', 'Bambang Tri', 'Sintia', '080385048593', 1, '2020-02-08 05:04:31', '2020-02-10 02:59:52'),
(2, 15, '3287398279873984', 'Sinto', 'Santi', '0879349895849', 1, '2020-02-08 05:06:12', '2020-02-10 02:59:32'),
(3, 16, '3287879823749827', 'Rizky Nur Hidayat', 'Jihan Nur Kamila', '0894587839734', 1, '2020-02-10 02:54:50', '2020-02-10 02:59:53'),
(4, 17, '3298738297498273', 'Bernard Siahaan', 'Juliana Zein', '0868785949388', 1, '2020-02-10 03:01:33', '2020-02-10 03:03:19'),
(10, 23, '3276438945089802', 'Haryanto', 'Fatmawati', '0867276876786', 0, '2020-02-10 07:33:09', '2020-02-19 13:44:39'),
(11, 24, '3275092039402859', 'Ahmad Ridho', 'Liana Saktiwanti', '087865368761', 0, '2020-02-10 07:34:15', '2020-02-10 07:34:15'),
(12, 25, '3275099839457398', 'Fahruliansyah', 'Sheila Nur Majid', '0867587247827', 0, '2020-02-10 07:35:17', '2020-02-10 07:35:17'),
(13, 26, '3276874874958794', 'Andreas Prasetyo', 'Intan Nur Hotimah', '0832894937857', 0, '2020-02-10 07:35:54', '2020-02-10 07:35:54'),
(14, 27, '3271908329042839', 'Emet Nur Cholis', 'Amit Nur Badai', '0878745987326', 0, '2020-02-10 07:38:11', '2020-02-10 07:38:11'),
(15, 28, '3283729873982749', 'Gledek Nurmantyo', 'Bredek Santini', '0824839048395', 0, '2020-02-10 08:10:10', '2020-02-10 08:10:10'),
(16, 29, '2413432214135233', 'bambang', 'siti', '02125587341', 0, '2020-02-10 08:15:03', '2020-02-10 08:15:29'),
(17, 30, '3287874289374983', 'Badut Siahaan', 'Didot Mantaulu', '085789739842', 0, '2020-02-10 08:16:45', '2020-02-10 08:16:45'),
(18, 31, '3184613454254134', 'Katmo', 'Sri ', '0813813461134', 0, '2020-02-10 08:16:56', '2020-02-10 08:16:56'),
(19, 32, '3290809284095894', 'Abdi Negara Sejati ', 'Ibu Negara', '0839809458490', 0, '2020-02-10 08:17:14', '2023-08-21 14:33:37'),
(20, 33, '3750936413456432', 'Yono', 'Maemunah', '0812064658643', 0, '2020-02-10 08:17:33', '2020-02-10 08:17:33'),
(21, 34, '3297398274982378', 'Amran Kartakarun', 'Imrin Kirtikirin', '0857683278465', 0, '2020-02-10 08:17:53', '2020-02-10 08:17:53'),
(22, 35, '3275120300505310', 'Jajang', 'Yati', '0856062315840', 0, '2020-02-10 08:18:10', '2020-02-10 08:18:10'),
(23, 36, '3283972987895749', 'Sandrayono', 'Sandrayani', '0886509486904', 0, '2020-02-10 08:19:23', '2020-02-10 08:19:23'),
(24, 37, '5475272753675201', 'Anto', 'Iis', '0287630563123', 0, '2020-02-10 08:19:31', '2020-02-10 08:19:31'),
(25, 38, '6541435432165333', 'Asam Suryanto', 'Asyinah Said', '2504540757546', 0, '2020-02-10 08:20:15', '2020-07-09 05:33:28'),
(26, 39, '3298038972983748', 'Mugiono Apriyani', 'Cici Parwito', '0894984590684', 0, '2020-02-10 08:31:25', '2020-02-10 08:34:27'),
(27, 40, '9023908092859480', 'Jamet Brigidik', 'Linda Sukmawati', '0877998492384', 1, '2020-02-20 04:25:09', '2020-02-20 04:25:24'),
(28, 41, '3276298739874982', 'Berry Sihalahua', 'Rinti Sumanti', '0878674638823', 0, '2020-03-10 07:32:22', '2020-03-10 07:32:22'),
(29, 42, '3276983290485830', 'Abdul Jabbar', 'Siti Nurhasanah', '0878479832984', 0, '2020-03-10 07:34:54', '2020-03-10 07:34:54'),
(30, 43, '3276732698472987', 'Riko Tantorini', 'Reina Suhanda', '08783874878', 0, '2020-03-11 13:09:01', '2020-03-11 13:09:01'),
(31, 46, '3290892374892372', 'Baharudin Saifulloh', 'Ina Karlina', '0897983787863', 1, '2020-04-03 13:06:55', '2020-04-03 13:07:47'),
(32, 51, '3282367468287467', 'Muhammad Azam Bin Bayan', 'Indri Sintiasari', '0878987367253', 0, '2020-07-09 05:36:01', '2020-07-09 05:36:01'),
(33, 52, '3276827498459892', 'Kartono', 'Kartini', '0898737687634', 0, '2020-07-09 05:37:39', '2020-07-09 05:37:39'),
(34, 55, '3275040529203046', 'Abdul Majid', 'Siti Fatimah', '089932108876', 0, '2021-05-17 04:29:42', '2021-05-17 04:29:42'),
(35, 56, '3298798257489374', 'jsndfjsn', 'jnsjfdn', '0809839849899', 0, '2021-05-17 08:06:27', '2021-05-17 08:06:27'),
(36, 57, '3289782734874878', 'Ibnu Kamil', 'Masitoh', '089898948293', 0, '2021-05-17 08:28:06', '2021-05-17 08:28:06'),
(37, 58, '3298798347539898', 'Ahmad Hasan ', 'Rina Puspita', '083989489485', 0, '2021-05-17 08:30:35', '2021-05-17 08:30:35'),
(38, 59, '3298792898394893', 'Ahmad Fajrul', 'Rina Rosinta', '083989482878', 0, '2021-05-17 08:31:31', '2021-05-17 08:31:31'),
(39, 60, '3289798237482735', 'Roni Sianturi', 'Rima Nurmala', '089738979823', 0, '2021-05-17 10:28:06', '2021-05-17 10:28:06'),
(40, 61, '3287928374897387', 'Adi Sumarno', 'Rini Sumarni', '08890389284', 0, '2021-05-17 10:44:07', '2021-05-17 10:44:07'),
(41, 62, '3298782374834785', 'Hamdan Syakirin', 'Lusiana Fatinah', '089083984432', 0, '2021-05-17 10:48:17', '2021-05-17 10:48:17'),
(42, 63, '3287923784787872', 'Hamdan Naimin', 'Mazidah', '098300983992', 0, '2021-05-17 10:57:22', '2021-05-17 10:57:22'),
(43, 64, '3275978923490824', 'Syarif Romadhon', 'Syarifah Ramadhani', '088492898393', 0, '2021-05-17 12:56:31', '2021-05-17 12:56:31'),
(44, 65, '3209809324037483', 'Izzatul Islam', 'Mariana Dista', '080894894893', 0, '2021-05-17 13:04:32', '2021-05-17 13:04:32'),
(45, 66, '3298789237484375', 'Abdul Fattah', 'Rini Marini', '0839089384938', 0, '2021-05-17 13:05:20', '2021-05-17 13:05:20'),
(46, 67, '3287983475834757', 'Himdin', 'Himdiniyih', '089038984989', 0, '2021-05-17 13:09:31', '2021-05-17 13:09:31'),
(47, 68, '3297982374837583', 'Huntu', 'Hinti', '08039485948', 0, '2021-05-18 05:25:53', '2021-05-18 05:25:53'),
(48, 74, '3287832794823748', 'Faruq As-Sahab', 'Riana Kamila', '08084874543', 0, '2022-06-16 06:01:58', '2022-06-16 06:01:58'),
(49, 75, '3276287364782346', 'Andi Irawan', 'Resti Anindya', '08439573847', 0, '2022-06-26 17:20:43', '2022-06-26 17:20:43'),
(50, 77, '3281798327482723', 'Zidan Abdiyan', 'Laila Nurlilah', '083928493823', 0, '2022-06-30 04:36:45', '2022-06-30 04:36:45'),
(51, 81, '3209353453463464', 'Muhammad Ibrahim', 'Siti Fatimah', '080394835345', 1, '2023-04-15 04:03:19', '2023-04-15 04:05:26'),
(52, 83, '3284732984732857', 'Sahrul Aminin', 'Dina Novitasari', '08390824348', 1, '2023-06-27 02:44:26', '2023-06-27 02:44:38'),
(53, 84, '3210948237328957', 'Adrian Simatupang', 'Indri Setianingsih', '0809328492839', 1, '2023-06-27 03:27:39', '2023-06-27 03:27:56');

-- --------------------------------------------------------

--
-- Table structure for table `tb_presence`
--

CREATE TABLE `tb_presence` (
  `journal_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `presence_status` int(11) DEFAULT NULL,
  `presence_mark` varchar(300) DEFAULT NULL,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_presence`
--

INSERT INTO `tb_presence` (`journal_id`, `student_id`, `presence_status`, `presence_mark`, `created`, `modified`) VALUES
(38, 3, 1, '', '2020-06-22 11:00:20', '2020-06-25 11:00:20'),
(38, 8, 1, '', '2020-06-22 11:00:20', '2020-06-25 11:00:20'),
(38, 11, 1, '', '2020-06-22 11:00:20', '2020-06-25 11:00:20'),
(38, 14, 1, '', '2020-06-22 11:00:20', '2020-06-25 11:00:20'),
(38, 24, 1, '', '2020-06-22 11:00:20', '2020-06-25 11:00:20'),
(38, 26, 1, '', '2020-06-22 11:00:20', '2020-06-25 11:00:20'),
(38, 28, 1, '', '2020-06-22 11:00:20', '2020-06-25 11:00:20'),
(39, 1, 1, '', '2020-06-08 10:54:15', '2020-06-25 10:54:15'),
(39, 3, 1, '', '2020-06-08 10:54:15', '2020-06-25 10:54:15'),
(39, 6, 1, '', '2020-06-08 10:54:15', '2020-06-25 10:54:15'),
(39, 8, 1, '', '2020-06-08 10:54:15', '2020-06-25 10:54:15'),
(39, 11, 1, '', '2020-06-08 10:54:15', '2020-06-25 10:54:15'),
(39, 13, 1, '', '2020-06-08 10:54:15', '2020-06-25 10:54:15'),
(39, 14, 3, '', '2020-06-08 10:54:23', '2020-06-25 10:54:23'),
(39, 17, 1, '', '2020-06-08 10:54:15', '2020-06-25 10:54:15'),
(39, 24, 1, '', '2020-06-08 10:54:15', '2020-06-25 10:54:15'),
(39, 26, 1, '', '2020-06-08 10:54:15', '2020-06-25 10:54:15'),
(39, 28, 1, '', '2020-06-08 10:54:15', '2020-06-25 10:54:15'),
(40, 7, 2, 'Jalan jalan', '2020-07-01 15:59:44', '2020-06-30 22:59:44'),
(40, 9, 3, '', '2020-07-01 15:59:48', '2020-06-30 22:59:48'),
(40, 10, 0, '', '2020-07-01 15:59:53', '2020-06-30 22:59:53'),
(40, 12, 1, '', '2020-07-01 16:00:04', '2020-06-30 23:00:04'),
(40, 21, 1, '', '2020-07-01 15:59:31', '2020-06-30 22:59:31'),
(40, 27, 0, '', '2020-07-01 15:59:29', '2020-07-01 00:24:48'),
(40, 29, 3, '', '2020-07-01 16:00:02', '2020-06-30 23:44:46'),
(40, 30, 1, '', '2020-07-01 15:59:50', '2020-06-30 22:59:50'),
(43, 27, 1, '', '2020-07-01 16:00:42', '2020-06-30 23:00:42'),
(44, 7, 1, '', '2020-07-01 16:01:24', '2020-06-30 23:01:24'),
(44, 9, 0, '', '2020-07-01 16:01:26', '2020-06-30 23:01:26'),
(44, 10, 1, '', '2020-07-01 16:01:29', '2020-06-30 23:01:29'),
(44, 12, 1, '', '2020-07-01 16:01:33', '2020-06-30 23:01:33'),
(44, 21, 1, '', '2020-07-01 16:01:19', '2020-06-30 23:01:19'),
(44, 27, 1, '', '2020-07-01 16:01:18', '2020-06-30 23:01:18'),
(44, 29, 1, '', '2020-07-01 16:01:31', '2020-06-30 23:01:31'),
(44, 30, 3, '', '2020-07-01 16:01:27', '2020-06-30 23:01:27'),
(45, 27, 0, '', '2020-07-01 16:04:43', '2020-06-30 23:04:43'),
(47, 1, 3, '', '2020-07-01 00:33:35', '2020-07-02 09:36:47'),
(47, 6, 2, 'makan', '2020-07-01 00:33:35', '2020-07-02 09:37:03'),
(47, 13, 0, '', '2020-07-01 00:33:35', '2020-07-02 09:36:39'),
(47, 17, 1, '', '2020-07-01 00:33:35', '2020-07-01 00:33:35'),
(47, 18, 3, '', '2020-07-01 16:42:34', '2020-07-01 16:42:34'),
(47, 31, 3, '', '2020-07-01 00:33:41', '2020-07-01 00:33:41'),
(47, 32, 1, '', '2020-07-01 00:33:35', '2020-07-01 00:33:35'),
(48, 1, 1, '', '2020-07-09 05:56:24', '2020-07-09 05:56:24'),
(48, 6, 1, '', '2020-07-09 05:56:24', '2020-07-09 05:56:24'),
(48, 13, 1, '', '2020-07-09 05:56:24', '2020-07-09 05:56:24'),
(48, 17, 1, '', '2020-07-09 05:56:24', '2020-07-09 05:56:24'),
(48, 18, 1, '', '2020-07-09 06:23:49', '2020-07-09 06:23:49'),
(48, 31, 1, '', '2020-07-09 05:56:24', '2020-07-09 05:56:24'),
(48, 32, 1, '', '2020-07-09 05:56:24', '2020-07-09 05:56:24'),
(48, 36, 1, '', '2020-07-09 05:56:24', '2020-07-09 05:56:24'),
(49, 7, 1, '', '2020-07-09 05:57:06', '2020-07-09 05:57:06'),
(49, 9, 2, 'keluar rumah', '2020-07-09 05:57:19', '2020-07-09 05:57:19'),
(49, 10, 1, '', '2020-07-09 05:57:06', '2020-07-09 05:57:06'),
(49, 12, 3, '', '2020-07-09 05:57:26', '2020-07-09 05:57:26'),
(49, 21, 1, '', '2020-07-09 05:57:06', '2020-07-09 05:57:06'),
(49, 27, 1, '', '2020-07-09 05:57:06', '2020-07-09 05:57:06'),
(49, 29, 1, '', '2020-07-09 05:57:06', '2020-07-09 05:57:06'),
(49, 30, 1, '', '2020-07-09 05:57:06', '2020-07-09 05:57:06'),
(49, 34, 1, '', '2020-07-09 05:57:06', '2020-07-09 05:57:06'),
(50, 7, 1, '', '2020-07-08 05:57:52', '2020-07-09 05:57:52'),
(50, 9, 3, '', '2020-07-08 05:57:52', '2020-07-09 23:12:44'),
(50, 10, 1, '', '2020-07-08 05:57:52', '2020-07-09 05:57:52'),
(50, 12, 0, '', '2020-07-08 06:40:04', '2020-07-09 06:40:04'),
(50, 21, 1, '', '2020-07-08 05:57:52', '2020-07-09 05:57:52'),
(50, 27, 1, '', '2020-07-08 05:57:55', '2020-07-09 23:12:27'),
(50, 29, 1, '', '2020-07-08 05:57:52', '2020-07-09 05:57:52'),
(50, 30, 1, '', '2020-07-08 05:57:52', '2020-07-09 23:13:12'),
(50, 34, 1, '', '2020-07-08 05:57:52', '2020-07-09 05:57:52'),
(51, 3, 1, '', '2020-07-08 05:58:14', '2020-07-09 05:58:14'),
(51, 8, 1, '', '2020-07-08 05:58:14', '2020-07-09 05:58:14'),
(51, 11, 1, '', '2020-07-08 05:58:14', '2020-07-09 05:58:14'),
(51, 14, 1, '', '2020-07-08 05:58:14', '2020-07-09 05:58:14'),
(51, 24, 1, '', '2020-07-08 05:58:14', '2020-07-09 05:58:14'),
(51, 26, 1, '', '2020-07-08 05:58:14', '2020-07-09 05:58:14'),
(51, 28, 1, '', '2020-07-08 05:58:14', '2020-07-09 05:58:14'),
(51, 35, 1, '', '2020-07-08 05:58:14', '2020-07-09 05:58:14'),
(52, 3, 1, '', '2020-07-09 06:00:06', '2020-07-09 06:00:06'),
(52, 8, 3, '', '2020-07-09 06:00:11', '2020-07-09 06:00:11'),
(52, 11, 1, '', '2020-07-09 06:00:06', '2020-07-09 06:00:06'),
(52, 14, 1, '', '2020-07-09 06:00:06', '2020-07-09 06:00:06'),
(52, 24, 0, '', '2020-07-09 06:00:13', '2020-07-09 06:00:13'),
(52, 26, 1, '', '2020-07-09 06:00:06', '2020-07-09 06:00:06'),
(52, 28, 1, '', '2020-07-09 06:00:06', '2020-07-09 06:00:06'),
(52, 35, 1, '', '2020-07-09 06:00:06', '2020-07-09 06:00:06'),
(58, 3, 1, '', '2020-07-06 10:51:48', '2020-07-09 10:51:48'),
(58, 8, 1, '', '2020-07-06 10:51:48', '2020-07-09 10:51:48'),
(58, 11, 1, '', '2020-07-06 10:51:48', '2020-07-09 10:51:48'),
(58, 14, 1, '', '2020-07-06 10:51:48', '2020-07-09 10:51:48'),
(58, 24, 1, '', '2020-07-06 10:51:48', '2020-07-09 10:51:48'),
(58, 26, 1, '', '2020-07-06 10:51:48', '2020-07-09 10:51:48'),
(58, 28, 1, '', '2020-07-06 10:51:48', '2020-07-09 10:51:48'),
(58, 35, 1, '', '2020-07-06 10:51:48', '2020-07-09 10:51:48'),
(60, 3, 1, '', '2020-07-10 01:33:28', '2020-07-10 01:33:28'),
(60, 8, 1, '', '2020-07-10 01:33:28', '2020-07-10 01:33:28'),
(60, 11, 1, '', '2020-07-10 01:33:28', '2020-07-10 01:33:28'),
(60, 14, 1, '', '2020-07-10 01:33:28', '2020-07-10 01:33:28'),
(60, 24, 2, 'Pulang kampung', '2020-07-10 01:33:41', '2020-07-10 01:33:41'),
(60, 26, 1, '', '2020-07-10 01:33:28', '2020-07-10 01:33:28'),
(60, 28, 1, '', '2020-07-10 01:33:28', '2020-07-10 01:33:28'),
(60, 35, 1, '', '2020-07-10 01:33:28', '2020-07-10 01:33:28'),
(61, 7, 1, '', '2020-07-10 01:34:04', '2020-07-10 01:34:04'),
(61, 9, 1, '', '2020-07-10 01:34:04', '2020-07-10 01:34:04'),
(61, 10, 1, '', '2020-07-10 01:34:04', '2020-07-10 01:34:04'),
(61, 12, 1, '', '2020-07-10 01:34:04', '2020-07-10 01:34:04'),
(61, 21, 1, '', '2020-07-10 01:34:04', '2020-07-10 01:34:04'),
(61, 27, 1, '', '2020-07-10 01:34:04', '2020-07-10 01:34:04'),
(61, 29, 1, '', '2020-07-10 01:34:04', '2020-07-10 01:34:04'),
(61, 30, 1, '', '2020-07-10 01:34:04', '2020-07-10 01:34:04'),
(61, 34, 1, '', '2020-07-10 01:34:04', '2020-07-10 01:34:04'),
(62, 1, 1, '', '2020-07-10 02:59:34', '2020-07-10 02:59:34'),
(62, 6, 1, '', '2020-07-10 02:59:34', '2020-07-10 02:59:34'),
(62, 13, 3, '', '2020-07-10 02:59:38', '2020-07-10 02:59:38'),
(62, 17, 1, '', '2020-07-10 02:59:34', '2020-07-10 02:59:34'),
(62, 18, 1, '', '2020-07-10 02:59:34', '2020-07-10 02:59:34'),
(62, 31, 1, '', '2020-07-10 02:59:34', '2020-07-10 04:32:37'),
(62, 32, 1, '', '2020-07-10 02:59:34', '2020-07-10 02:59:34'),
(62, 36, 1, '', '2020-07-10 02:59:34', '2020-07-10 02:59:34'),
(63, 3, 1, '', '2020-07-10 06:49:59', '2020-07-10 06:49:59'),
(63, 8, 1, '', '2020-07-10 06:49:59', '2020-07-10 06:49:59'),
(63, 11, 1, '', '2020-07-10 06:49:59', '2020-07-10 06:49:59'),
(63, 14, 0, '', '2020-07-10 06:50:03', '2020-07-10 06:50:03'),
(63, 24, 1, '', '2020-07-10 06:49:59', '2020-07-10 06:49:59'),
(63, 26, 1, '', '2020-07-10 06:49:59', '2020-07-10 06:49:59'),
(63, 28, 1, '', '2020-07-10 06:49:59', '2020-07-10 06:49:59'),
(63, 35, 1, '', '2020-07-10 06:49:59', '2020-07-10 06:49:59'),
(64, 1, 1, '', '2020-07-10 00:47:52', '2020-07-10 07:47:52'),
(64, 6, 1, '', '2020-07-10 00:47:54', '2020-07-10 07:47:54'),
(64, 13, 1, '', '2020-07-10 00:48:04', '2020-07-10 07:48:04'),
(64, 17, 1, '', '2020-07-10 00:47:55', '2020-07-10 07:47:55'),
(64, 18, 1, '', '2020-07-10 00:47:59', '2020-07-10 07:47:59'),
(64, 31, 1, '', '2020-07-10 00:48:02', '2020-07-10 07:48:02'),
(64, 32, 1, '', '2020-07-10 00:48:00', '2020-07-10 07:48:00'),
(64, 36, 1, '', '2020-07-10 00:47:57', '2020-07-10 07:47:57'),
(65, 1, 1, '', '2020-07-10 00:46:29', '2020-07-10 07:46:29'),
(65, 6, 1, '', '2020-07-10 00:46:30', '2020-07-10 07:46:30'),
(65, 13, 1, '', '2020-07-10 00:46:51', '2020-07-10 07:46:51'),
(65, 17, 0, '', '2020-07-10 00:46:32', '2020-07-10 07:47:02'),
(65, 18, 1, '', '2020-07-10 00:46:38', '2020-07-10 07:46:38'),
(65, 31, 1, '', '2020-07-10 00:46:49', '2020-07-10 07:46:49'),
(65, 32, 1, '', '2020-07-10 00:46:46', '2020-07-10 07:46:46'),
(65, 36, 1, '', '2020-07-10 00:46:35', '2020-07-10 07:46:35'),
(67, 3, 1, '', '2020-07-10 00:50:07', '2020-07-10 07:50:07'),
(67, 8, 3, '', '2020-07-10 00:50:22', '2020-07-10 07:50:22'),
(67, 11, 1, '', '2020-07-10 00:50:12', '2020-07-10 07:50:12'),
(67, 14, 1, '', '2020-07-10 00:50:15', '2020-07-10 07:50:15'),
(67, 24, 1, '', '2020-07-10 00:50:20', '2020-07-10 07:50:20'),
(67, 26, 1, '', '2020-07-10 00:50:09', '2020-07-10 07:50:09'),
(67, 28, 1, '', '2020-07-10 00:50:03', '2020-07-10 07:50:03'),
(67, 35, 1, '', '2020-07-10 00:50:17', '2020-07-10 07:50:17'),
(68, 3, 1, '', '2020-07-10 00:51:36', '2020-07-10 07:51:36'),
(68, 8, 1, '', '2020-07-10 00:51:50', '2020-07-10 07:51:50'),
(68, 11, 0, '', '2020-07-10 00:51:41', '2020-07-10 07:51:41'),
(68, 14, 1, '', '2020-07-10 00:51:42', '2020-07-10 07:51:42'),
(68, 24, 1, '', '2020-07-10 00:51:47', '2020-07-10 07:51:47'),
(68, 26, 3, '', '2020-07-10 00:51:39', '2020-07-10 07:51:39'),
(68, 28, 1, '', '2020-07-10 00:51:32', '2020-07-10 07:51:32'),
(68, 35, 1, '', '2020-07-10 00:51:45', '2020-07-10 07:51:45'),
(69, 3, 3, '', '2020-07-11 02:23:57', '2020-07-11 02:23:57'),
(69, 8, 0, '', '2020-07-11 02:26:13', '2020-07-11 02:26:13'),
(69, 11, 1, '', '2020-07-11 02:11:36', '2020-07-11 02:11:36'),
(69, 14, 1, '', '2020-07-11 02:11:37', '2020-07-11 02:11:37'),
(69, 24, 1, '', '2020-07-11 02:11:39', '2020-07-11 02:11:39'),
(69, 26, 1, '', '2020-07-11 02:10:20', '2020-07-11 02:10:20'),
(69, 28, 1, '', '2020-07-11 02:10:20', '2020-07-11 02:10:20'),
(69, 35, 1, '', '2020-07-11 02:10:20', '2020-07-11 02:10:20'),
(70, 1, 1, '', '2020-07-10 19:21:30', '2020-07-11 02:21:30'),
(70, 6, 1, '', '2020-07-10 19:21:34', '2020-07-11 02:21:34'),
(70, 13, 1, '', '2020-07-10 19:22:21', '2020-07-11 02:22:21'),
(70, 17, 1, '', '2020-07-10 19:21:56', '2020-07-11 02:25:53'),
(70, 18, 0, '', '2020-07-10 19:22:07', '2020-07-11 02:22:07'),
(70, 31, 1, '', '2020-07-10 19:22:18', '2020-07-11 02:22:18'),
(70, 32, 1, '', '2020-07-10 19:22:16', '2020-07-11 02:22:16'),
(70, 36, 3, '', '2020-07-10 19:22:02', '2020-07-11 02:22:02'),
(71, 7, 1, '', '2020-07-11 01:23:31', '2020-07-13 08:23:31'),
(71, 9, 1, '', '2020-07-11 01:23:34', '2020-07-13 08:23:34'),
(71, 10, 1, '', '2020-07-11 01:23:38', '2020-07-13 08:23:38'),
(71, 12, 1, '', '2020-07-11 01:23:40', '2020-07-13 08:23:40'),
(71, 21, 1, '', '2020-07-11 01:23:30', '2020-07-13 08:23:30'),
(71, 27, 3, '', '2020-07-11 01:23:29', '2020-07-13 13:52:25'),
(71, 29, 0, '', '2020-07-11 01:23:39', '2020-07-13 08:23:39'),
(71, 30, 3, '', '2020-07-11 01:23:36', '2020-07-13 08:23:36'),
(71, 34, 1, '', '2020-07-11 01:23:33', '2020-07-13 08:23:33'),
(72, 3, 1, '', '2020-07-10 16:22:34', '2020-07-13 23:22:34'),
(72, 8, 1, '', '2020-07-10 16:22:47', '2020-07-13 23:22:47'),
(72, 11, 1, '', '2020-07-10 16:22:39', '2020-07-13 23:22:39'),
(72, 14, 1, '', '2020-07-10 16:22:40', '2020-07-13 23:22:40'),
(72, 24, 1, '', '2020-07-10 16:22:45', '2020-07-13 23:22:45'),
(72, 26, 1, '', '2020-07-10 16:22:36', '2020-07-13 23:22:36'),
(72, 28, 1, '', '2020-07-10 16:22:32', '2020-07-13 23:22:32'),
(72, 35, 3, '', '2020-07-10 16:22:43', '2020-07-13 23:22:43'),
(74, 7, 1, '', '2020-07-10 16:58:41', '2020-07-14 23:58:41'),
(74, 9, 1, '', '2020-07-10 16:58:44', '2020-07-14 23:58:44'),
(74, 10, 1, '', '2020-07-10 16:58:48', '2020-07-14 23:58:48'),
(74, 12, 1, '', '2020-07-10 16:58:51', '2020-07-14 23:58:51'),
(74, 21, 1, '', '2020-07-10 16:58:39', '2020-07-14 23:58:39'),
(74, 27, 1, '', '2020-07-10 16:58:38', '2020-07-14 23:58:38'),
(74, 29, 1, '', '2020-07-10 16:58:49', '2020-07-14 23:58:49'),
(74, 30, 1, '', '2020-07-10 16:58:46', '2020-07-14 23:58:46'),
(74, 34, 1, '', '2020-07-10 16:58:42', '2020-07-14 23:58:42'),
(75, 3, 1, '', '2020-07-09 20:46:46', '2020-07-16 03:46:46'),
(75, 8, 1, '', '2020-07-09 20:46:57', '2020-07-16 03:46:57'),
(75, 11, 1, '', '2020-07-09 20:46:50', '2020-07-16 03:46:50'),
(75, 14, 1, '', '2020-07-09 20:46:52', '2020-07-16 03:46:52'),
(75, 24, 1, '', '2020-07-09 20:46:55', '2020-07-16 03:46:55'),
(75, 26, 1, '', '2020-07-09 20:46:48', '2020-07-16 03:46:48'),
(75, 28, 1, '', '2020-07-09 20:46:45', '2020-07-16 03:46:45'),
(75, 35, 1, '', '2020-07-09 20:46:53', '2020-07-16 03:46:53'),
(76, 1, 1, '', '2020-07-16 21:17:45', '2020-07-16 04:17:45'),
(76, 6, 1, '', '2020-07-16 21:17:47', '2020-07-16 04:17:47'),
(76, 13, 1, '', '2020-07-16 21:18:00', '2020-07-16 04:18:00'),
(76, 17, 1, '', '2020-07-16 21:17:49', '2020-07-16 04:17:49'),
(76, 18, 1, '', '2020-07-16 21:17:53', '2020-07-16 04:17:53'),
(76, 31, 1, '', '2020-07-16 21:17:59', '2020-07-16 04:17:59'),
(76, 32, 1, '', '2020-07-16 21:17:56', '2020-07-16 04:17:56'),
(76, 36, 1, '', '2020-07-16 21:17:51', '2020-07-16 04:17:51'),
(77, 7, 1, '', '2020-07-15 05:49:03', '2020-07-16 05:49:03'),
(77, 9, 1, '', '2020-07-15 05:49:03', '2020-07-16 05:49:03'),
(77, 10, 1, '', '2020-07-15 05:49:03', '2020-07-16 05:49:03'),
(77, 12, 1, '', '2020-07-15 05:49:03', '2020-07-16 05:49:03'),
(77, 21, 1, '', '2020-07-15 05:49:03', '2020-07-16 05:49:03'),
(77, 27, 1, '', '2020-07-15 05:49:03', '2020-07-16 05:49:03'),
(77, 29, 1, '', '2020-07-15 05:49:03', '2020-07-16 05:49:03'),
(77, 30, 1, '', '2020-07-15 05:49:03', '2020-07-16 05:49:03'),
(77, 34, 1, '', '2020-07-15 05:49:03', '2020-07-16 05:49:03'),
(78, 3, 1, '', '2020-07-04 00:18:24', '2020-07-16 07:18:24'),
(78, 8, 0, '', '2020-07-04 00:18:49', '2020-07-16 07:18:49'),
(78, 11, 3, '', '2020-07-04 00:18:35', '2020-07-16 07:18:35'),
(78, 14, 1, '', '2020-07-04 00:18:39', '2020-07-16 07:18:39'),
(78, 24, 0, '', '2020-07-04 00:18:46', '2020-07-16 07:18:46'),
(78, 26, 2, 'acara keluarga', '2020-07-04 00:18:32', '2020-07-16 07:18:32'),
(78, 28, 1, '', '2020-07-04 00:18:20', '2020-07-16 07:18:20'),
(78, 35, 1, '', '2020-07-04 00:18:42', '2020-07-16 07:18:42'),
(80, 1, 1, '', '2020-07-04 00:21:42', '2020-07-16 07:21:42'),
(80, 6, 1, '', '2020-07-04 00:21:45', '2020-07-16 07:21:45'),
(80, 13, 1, '', '2020-07-04 00:22:09', '2020-07-16 07:22:09'),
(80, 17, 3, '', '2020-07-04 00:21:51', '2020-07-16 07:21:51'),
(80, 18, 0, '', '2020-07-04 00:21:58', '2020-07-16 07:21:58'),
(80, 31, 1, '', '2020-07-04 00:22:05', '2020-07-16 07:22:05'),
(80, 32, 1, '', '2020-07-04 00:22:02', '2020-07-16 07:22:02'),
(80, 36, 1, '', '2020-07-04 00:21:55', '2020-07-16 07:21:55'),
(81, 7, 1, '', '2020-07-16 09:36:10', '2020-07-16 09:36:10'),
(81, 9, 0, '', '2020-07-16 09:36:30', '2020-07-16 09:36:30'),
(81, 10, 1, '', '2020-07-16 09:36:10', '2020-07-16 09:36:10'),
(81, 12, 1, '', '2020-07-16 09:36:10', '2020-07-16 09:36:10'),
(81, 21, 1, '', '2020-07-16 09:36:10', '2020-07-16 09:36:10'),
(81, 27, 1, '', '2020-07-16 09:36:10', '2020-07-16 09:36:10'),
(81, 29, 1, '', '2020-07-16 09:36:10', '2020-07-16 09:36:10'),
(81, 30, 1, '', '2020-07-16 09:36:10', '2020-07-16 09:36:10'),
(81, 34, 1, '', '2020-07-16 09:36:10', '2020-07-16 09:36:10'),
(82, 3, 1, '', '2020-07-25 06:42:44', '2020-07-27 06:42:44'),
(82, 8, 1, '', '2020-07-25 06:42:44', '2020-07-27 06:42:44'),
(82, 11, 1, '', '2020-07-25 06:42:44', '2020-07-27 06:42:44'),
(82, 14, 1, '', '2020-07-25 06:42:44', '2020-07-27 06:42:44'),
(82, 24, 1, '', '2020-07-25 06:42:44', '2020-07-27 06:42:44'),
(82, 26, 1, '', '2020-07-25 06:42:44', '2020-07-27 06:42:44'),
(82, 28, 1, '', '2020-07-25 06:42:44', '2020-07-27 06:42:44'),
(82, 35, 1, '', '2020-07-25 06:42:44', '2020-07-27 06:42:44'),
(83, 1, 1, '', '2020-08-06 23:22:30', '2020-08-03 06:22:30'),
(83, 6, 1, '', '2020-08-06 23:22:31', '2020-08-03 06:22:31'),
(83, 13, 1, '', '2020-08-06 23:22:48', '2020-08-03 06:22:48'),
(83, 17, 1, '', '2020-08-06 23:22:35', '2020-08-03 06:22:35'),
(83, 18, 1, '', '2020-08-06 23:22:39', '2020-08-03 06:22:39'),
(83, 31, 1, '', '2020-08-06 23:22:45', '2020-08-03 06:22:45'),
(83, 32, 1, '', '2020-08-06 23:22:43', '2020-08-03 06:22:43'),
(83, 36, 1, '', '2020-08-06 23:22:37', '2020-08-03 06:22:37'),
(84, 3, 1, '', '2020-09-03 23:55:19', '2020-09-03 23:55:19'),
(84, 8, 1, '', '2020-09-03 23:55:19', '2020-09-03 23:55:19'),
(84, 11, 1, '', '2020-09-03 23:55:19', '2020-09-03 23:55:19'),
(84, 14, 1, '', '2020-09-03 23:55:19', '2020-09-03 23:55:19'),
(84, 24, 1, '', '2020-09-03 23:55:19', '2020-09-03 23:55:19'),
(84, 26, 1, '', '2020-09-03 23:55:19', '2020-09-03 23:55:19'),
(84, 28, 1, '', '2020-09-03 23:55:19', '2020-09-03 23:55:19'),
(84, 35, 1, '', '2020-09-03 23:55:19', '2020-09-03 23:55:19'),
(85, 7, 1, '', '2020-09-03 23:57:22', '2020-09-03 23:57:22'),
(85, 9, 1, '', '2020-09-03 23:57:22', '2020-09-03 23:57:22'),
(85, 10, 1, '', '2020-09-03 23:57:22', '2020-09-03 23:57:22'),
(85, 12, 1, '', '2020-09-03 23:57:22', '2020-09-03 23:57:22'),
(85, 21, 1, '', '2020-09-03 23:57:22', '2020-09-03 23:57:22'),
(85, 27, 0, '', '2020-09-03 23:57:31', '2020-09-03 23:57:31'),
(85, 29, 1, '', '2020-09-03 23:57:22', '2020-09-03 23:57:22'),
(85, 30, 1, '', '2020-09-03 23:57:22', '2020-09-03 23:57:22'),
(85, 34, 1, '', '2020-09-03 23:57:22', '2020-09-03 23:57:22'),
(86, 1, 1, '', '2020-09-18 08:14:30', '2020-09-21 08:14:30'),
(86, 6, 1, '', '2020-09-18 08:14:30', '2020-09-21 08:14:30'),
(86, 13, 1, '', '2020-09-18 08:14:30', '2020-09-21 08:14:30'),
(86, 17, 1, '', '2020-09-18 08:14:30', '2020-09-21 08:14:30'),
(86, 18, 0, '', '2020-09-18 08:14:38', '2020-09-21 08:14:38'),
(86, 31, 1, '', '2020-09-18 08:14:30', '2020-09-21 08:14:30'),
(86, 32, 1, '', '2020-09-18 08:14:30', '2020-09-21 08:14:30'),
(86, 36, 1, '', '2020-09-18 08:14:30', '2020-09-21 08:14:30'),
(87, 1, 1, '', '2020-09-25 04:31:32', '2020-09-23 04:31:32'),
(87, 6, 1, '', '2020-09-25 04:31:32', '2020-09-23 04:31:32'),
(87, 13, 1, '', '2020-09-25 04:31:32', '2020-09-23 04:31:32'),
(87, 17, 1, '', '2020-09-25 04:31:32', '2020-09-23 04:31:32'),
(87, 18, 1, '', '2020-09-25 04:31:32', '2020-09-23 04:31:32'),
(87, 31, 1, '', '2020-09-25 04:31:32', '2020-09-23 04:31:32'),
(87, 32, 1, '', '2020-09-25 04:31:32', '2020-09-23 04:31:32'),
(87, 36, 1, '', '2020-09-25 04:31:32', '2020-09-23 04:31:32'),
(88, 7, 1, '', '2020-09-18 04:32:31', '2020-09-23 04:32:31'),
(88, 9, 0, '', '2020-09-18 04:32:32', '2020-09-23 04:32:32'),
(88, 10, 1, '', '2020-09-18 04:32:31', '2020-09-23 04:32:31'),
(88, 12, 1, '', '2020-09-18 04:32:31', '2020-09-23 04:32:31'),
(88, 21, 1, '', '2020-09-18 04:32:31', '2020-09-23 04:32:31'),
(88, 27, 1, '', '2020-09-18 04:32:31', '2020-09-23 04:32:31'),
(88, 29, 1, '', '2020-09-18 04:32:31', '2020-09-23 04:32:31'),
(88, 30, 1, '', '2020-09-18 04:32:31', '2020-09-23 04:32:31'),
(88, 34, 1, '', '2020-09-18 04:32:31', '2020-09-23 04:32:31'),
(89, 1, 1, '', '2020-09-23 04:33:36', '2020-09-23 04:33:36'),
(89, 6, 1, '', '2020-09-23 04:33:36', '2020-09-23 04:33:36'),
(89, 13, 1, '', '2020-09-23 04:33:36', '2020-09-23 04:33:36'),
(89, 17, 3, '', '2020-09-23 04:33:39', '2020-09-23 04:33:39'),
(89, 18, 1, '', '2020-09-23 04:33:36', '2020-09-23 04:33:36'),
(89, 31, 1, '', '2020-09-23 04:33:36', '2020-09-23 04:33:36'),
(89, 32, 1, '', '2020-09-23 04:33:36', '2020-09-23 04:33:36'),
(89, 36, 1, '', '2020-09-23 04:33:36', '2020-09-23 04:33:36'),
(90, 7, 1, '', '2020-09-23 04:34:00', '2020-09-23 04:34:00'),
(90, 9, 1, '', '2020-09-23 04:34:00', '2020-09-23 04:34:00'),
(90, 10, 1, '', '2020-09-23 04:34:00', '2020-09-23 04:34:00'),
(90, 12, 1, '', '2020-09-23 04:34:00', '2020-09-23 04:34:00'),
(90, 21, 1, '', '2020-09-23 04:34:00', '2020-09-23 04:34:00'),
(90, 27, 1, '', '2020-09-23 04:34:00', '2020-09-23 04:34:00'),
(90, 29, 1, '', '2020-09-23 04:34:00', '2020-09-23 04:34:00'),
(90, 30, 1, '', '2020-09-23 04:34:00', '2020-09-23 04:34:00'),
(90, 34, 1, '', '2020-09-23 04:34:00', '2020-09-23 04:34:00'),
(91, 3, 1, '', '2020-09-23 04:34:24', '2020-09-23 04:34:24'),
(91, 8, 1, '', '2020-09-23 04:34:24', '2020-09-23 04:34:24'),
(91, 11, 1, '', '2020-09-23 04:34:24', '2020-09-23 04:34:24'),
(91, 14, 1, '', '2020-09-23 04:34:24', '2020-09-23 04:34:24'),
(91, 24, 1, '', '2020-09-23 04:34:24', '2020-09-23 04:34:24'),
(91, 26, 1, '', '2020-09-23 04:34:24', '2020-09-23 04:34:24'),
(91, 28, 1, '', '2020-09-23 04:34:24', '2020-09-23 04:34:24'),
(91, 35, 1, '', '2020-09-23 04:34:24', '2020-09-23 04:34:24'),
(92, 3, 1, '', '2020-09-22 04:35:59', '2020-09-23 04:35:59'),
(92, 8, 1, '', '2020-09-22 04:36:00', '2020-09-23 04:36:00'),
(92, 11, 1, '', '2020-09-22 04:36:00', '2020-09-23 04:36:00'),
(92, 14, 1, '', '2020-09-22 04:36:00', '2020-09-23 04:36:00'),
(92, 24, 1, '', '2020-09-22 04:36:00', '2020-09-23 04:36:00'),
(92, 26, 1, '', '2020-09-22 04:36:00', '2020-09-23 04:36:00'),
(92, 28, 0, '', '2020-09-22 04:36:01', '2020-09-23 04:36:01'),
(92, 35, 1, '', '2020-09-22 04:36:00', '2020-09-23 04:36:00'),
(93, 3, 1, '', '2020-09-21 04:36:42', '2020-09-23 04:36:42'),
(93, 8, 1, '', '2020-09-21 04:36:42', '2020-09-23 04:36:42'),
(93, 11, 1, '', '2020-09-21 04:36:42', '2020-09-23 04:36:42'),
(93, 14, 1, '', '2020-09-21 04:36:42', '2020-09-23 04:36:42'),
(93, 24, 2, 'sakit perut mendadak', '2020-09-21 04:36:51', '2020-09-23 04:36:51'),
(93, 26, 1, '', '2020-09-21 04:36:42', '2020-09-23 04:36:42'),
(93, 28, 1, '', '2020-09-21 04:36:42', '2020-09-23 04:36:42'),
(93, 35, 1, '', '2020-09-21 04:36:42', '2020-09-23 04:36:42'),
(94, 1, 1, '', '2020-10-01 23:45:27', '2020-10-11 23:45:27'),
(94, 6, 1, '', '2020-10-01 23:45:27', '2020-10-11 23:45:27'),
(94, 13, 1, '', '2020-10-01 23:45:27', '2020-10-11 23:45:27'),
(94, 17, 1, '', '2020-10-01 23:45:27', '2020-10-11 23:45:27'),
(94, 18, 1, '', '2020-10-01 23:45:27', '2020-10-11 23:45:27'),
(94, 31, 1, '', '2020-10-01 23:45:27', '2020-10-11 23:45:27'),
(94, 32, 2, 'Pulang kampung', '2020-10-01 23:45:38', '2020-10-11 23:45:38'),
(94, 36, 1, '', '2020-10-01 23:45:27', '2020-10-11 23:45:27'),
(95, 1, 1, '', '2020-10-02 02:54:21', '2020-10-12 02:54:21'),
(95, 6, 1, '', '2020-10-02 02:54:21', '2020-10-12 02:54:21'),
(95, 13, 1, '', '2020-10-02 02:54:21', '2020-10-12 02:54:21'),
(95, 17, 1, '', '2020-10-02 02:54:21', '2020-10-12 02:54:21'),
(95, 18, 1, '', '2020-10-02 02:54:21', '2020-10-12 02:54:21'),
(95, 31, 1, '', '2020-10-02 02:54:21', '2020-10-12 02:54:21'),
(95, 32, 2, 'pulang kampung', '2020-10-02 02:54:31', '2020-10-12 02:54:31'),
(95, 36, 1, '', '2020-10-02 02:54:21', '2020-10-12 02:54:21'),
(96, 1, 1, '', '2020-10-22 22:34:08', '2020-10-28 05:34:08'),
(96, 6, 1, '', '2020-10-22 22:34:10', '2020-10-28 05:34:10'),
(96, 13, 1, '', '2020-10-22 22:34:46', '2020-10-28 05:34:46'),
(96, 17, 1, '', '2020-10-22 22:34:21', '2020-10-28 05:34:21'),
(96, 18, 0, '', '2020-10-22 22:34:26', '2020-10-28 05:34:26'),
(96, 31, 1, '', '2020-10-22 22:34:44', '2020-10-28 05:34:44'),
(96, 32, 1, '', '2020-10-22 22:34:29', '2020-10-28 05:34:29'),
(96, 36, 3, '', '2020-10-22 22:34:24', '2020-10-28 05:34:24'),
(97, 3, 1, '', '2020-10-30 22:46:40', '2020-11-01 05:46:40'),
(97, 8, 1, '', '2020-10-30 22:46:51', '2020-11-01 05:46:51'),
(97, 11, 1, '', '2020-10-30 22:46:43', '2020-11-01 05:46:43'),
(97, 14, 1, '', '2020-10-30 22:46:45', '2020-11-01 05:46:45'),
(97, 24, 0, '', '2020-10-30 22:46:49', '2020-11-01 05:46:49'),
(97, 26, 1, '', '2020-10-30 22:46:42', '2020-11-01 05:46:42'),
(97, 28, 1, '', '2020-10-30 22:46:39', '2020-11-01 05:46:39'),
(97, 35, 1, '', '2020-10-30 22:46:47', '2020-11-01 05:46:47'),
(98, 7, 1, '', '2020-11-13 06:01:14', '2020-11-13 06:01:14'),
(98, 9, 1, '', '2020-11-13 06:01:14', '2020-11-13 06:01:14'),
(98, 10, 1, '', '2020-11-13 06:01:14', '2020-11-13 06:01:14'),
(98, 12, 1, '', '2020-11-13 06:01:14', '2020-11-13 06:01:14'),
(98, 21, 1, '', '2020-11-13 06:01:14', '2020-11-13 06:01:14'),
(98, 27, 1, '', '2020-11-13 06:01:14', '2020-11-13 06:01:14'),
(98, 29, 1, '', '2020-11-13 06:01:14', '2020-11-13 06:01:14'),
(98, 30, 1, '', '2020-11-13 06:01:14', '2020-11-13 06:01:14'),
(98, 34, 1, '', '2020-11-13 06:01:14', '2020-11-13 06:01:14'),
(99, 3, 1, '', '2020-11-21 04:55:11', '2020-11-23 04:55:11'),
(99, 8, 1, '', '2020-11-21 04:55:11', '2020-11-23 04:55:11'),
(99, 11, 1, '', '2020-11-21 04:55:11', '2020-11-23 04:55:11'),
(99, 14, 1, '', '2020-11-21 04:55:11', '2020-11-23 04:55:11'),
(99, 24, 1, '', '2020-11-21 04:55:11', '2020-11-23 04:55:11'),
(99, 26, 1, '', '2020-11-21 04:55:11', '2020-11-23 04:55:11'),
(99, 28, 1, '', '2020-11-21 04:55:11', '2020-11-23 04:55:11'),
(99, 35, 1, '', '2020-11-21 04:55:11', '2020-11-23 04:55:11'),
(100, 7, 2, 'izin', '2020-12-24 07:36:19', '2020-12-28 07:36:19'),
(102, 1, 1, '', '2021-01-13 05:19:37', '2021-01-13 05:19:37'),
(102, 6, 1, '', '2021-01-13 05:19:37', '2021-01-13 05:19:37'),
(102, 13, 1, '', '2021-01-13 05:19:37', '2021-01-13 05:19:37'),
(102, 17, 1, '', '2021-01-13 05:19:37', '2021-01-13 05:19:37'),
(102, 18, 1, '', '2021-01-13 05:19:37', '2021-01-13 05:19:37'),
(102, 31, 1, '', '2021-01-13 05:19:37', '2021-01-13 05:19:37'),
(102, 32, 1, '', '2021-01-13 05:19:37', '2021-01-13 05:19:37'),
(102, 36, 1, '', '2021-01-13 05:19:37', '2021-01-13 05:19:37'),
(103, 7, 1, '', '2021-01-13 05:20:10', '2021-01-13 05:20:10'),
(103, 9, 1, '', '2021-01-13 05:20:10', '2021-01-13 05:20:10'),
(103, 10, 1, '', '2021-01-13 05:20:10', '2021-01-13 05:20:10'),
(103, 12, 1, '', '2021-01-13 05:20:10', '2021-01-13 05:20:10'),
(103, 21, 1, '', '2021-01-13 05:20:10', '2021-01-13 05:20:10'),
(103, 27, 1, '', '2021-01-13 05:20:10', '2021-01-13 05:20:10'),
(103, 29, 0, '', '2021-01-13 05:20:13', '2021-01-13 05:20:13'),
(103, 30, 1, '', '2021-01-13 05:20:10', '2021-01-13 05:20:10'),
(103, 34, 1, '', '2021-01-13 05:20:10', '2021-01-13 05:20:10'),
(104, 3, 1, '', '2021-01-13 05:21:08', '2021-01-13 05:21:08'),
(104, 8, 1, '', '2021-01-13 05:21:08', '2021-01-13 05:21:08'),
(104, 11, 1, '', '2021-01-13 05:21:08', '2021-01-13 05:21:08'),
(104, 14, 3, '', '2021-01-13 05:21:15', '2021-01-13 05:21:15'),
(104, 24, 1, '', '2021-01-13 05:21:08', '2021-01-13 05:21:08'),
(104, 26, 1, '', '2021-01-13 05:21:08', '2021-01-13 05:21:08'),
(104, 28, 1, '', '2021-01-13 05:21:08', '2021-01-13 05:21:08'),
(104, 35, 1, '', '2021-01-13 05:21:08', '2021-01-13 05:21:08'),
(105, 1, 1, '', '2021-01-15 08:52:32', '2021-01-15 08:52:32'),
(105, 6, 1, '', '2021-01-15 08:52:32', '2021-01-15 08:52:32'),
(105, 13, 1, '', '2021-01-15 08:52:32', '2021-01-15 08:52:32'),
(105, 17, 1, '', '2021-01-15 08:52:32', '2021-01-15 08:52:32'),
(105, 18, 1, '', '2021-01-15 08:52:32', '2021-01-15 08:52:32'),
(105, 31, 1, '', '2021-01-15 08:52:32', '2021-01-15 08:52:32'),
(105, 32, 1, '', '2021-01-15 08:52:32', '2021-01-15 08:52:32'),
(105, 36, 1, '', '2021-01-15 08:52:32', '2021-01-15 08:52:32'),
(106, 7, 1, '', '2021-01-15 08:53:00', '2021-01-15 08:53:00'),
(106, 9, 1, '', '2021-01-15 08:53:00', '2021-01-15 08:53:00'),
(106, 10, 1, '', '2021-01-15 08:53:00', '2021-01-15 08:53:00'),
(106, 12, 3, '', '2021-01-15 08:53:07', '2021-01-15 08:53:07'),
(106, 21, 1, '', '2021-01-15 08:53:00', '2021-01-15 08:53:00'),
(106, 27, 3, '', '2021-01-15 08:53:05', '2021-01-15 08:53:05'),
(106, 29, 1, '', '2021-01-15 08:53:00', '2021-01-15 08:53:00'),
(106, 30, 1, '', '2021-01-15 08:53:00', '2021-01-15 08:53:00'),
(106, 34, 1, '', '2021-01-15 08:53:00', '2021-01-15 08:53:00'),
(107, 3, 0, '', '2021-01-15 08:53:21', '2021-01-15 08:53:21'),
(107, 8, 1, '', '2021-01-15 08:53:20', '2021-01-15 08:53:20'),
(107, 11, 1, '', '2021-01-15 08:53:20', '2021-01-15 08:53:20'),
(107, 14, 1, '', '2021-01-15 08:53:20', '2021-01-15 08:53:20'),
(107, 24, 0, '', '2021-01-15 08:53:22', '2021-01-15 08:53:22'),
(107, 26, 1, '', '2021-01-15 08:53:20', '2021-01-15 08:53:20'),
(107, 28, 3, '', '2021-01-15 08:53:23', '2021-01-15 08:53:23'),
(107, 35, 1, '', '2021-01-15 08:53:20', '2021-01-15 08:53:20'),
(108, 1, 1, '', '2021-01-18 03:21:31', '2021-01-19 03:21:31'),
(108, 6, 0, '', '2021-01-18 03:21:38', '2021-01-19 03:21:38'),
(108, 13, 1, '', '2021-01-18 03:21:31', '2021-01-19 03:21:31'),
(108, 17, 1, '', '2021-01-18 03:21:31', '2021-01-19 03:21:31'),
(108, 18, 1, '', '2021-01-18 03:21:31', '2021-01-19 03:21:31'),
(108, 31, 1, '', '2021-01-18 03:21:31', '2021-01-19 03:21:31'),
(108, 32, 1, '', '2021-01-18 03:21:31', '2021-01-19 03:21:31'),
(108, 36, 1, '', '2021-01-18 03:21:31', '2021-01-19 03:21:31'),
(109, 1, 1, '', '2021-01-15 02:07:41', '2021-01-20 02:07:41'),
(109, 6, 1, '', '2021-01-15 02:07:41', '2021-01-20 02:07:41'),
(109, 13, 0, '', '2021-01-15 02:07:49', '2021-01-20 02:07:49'),
(109, 17, 1, '', '2021-01-15 02:07:41', '2021-01-20 02:07:41'),
(109, 18, 0, '', '2021-01-15 02:07:49', '2021-01-20 02:07:49'),
(109, 31, 1, '', '2021-01-15 02:07:41', '2021-01-20 02:07:41'),
(109, 32, 3, '', '2021-01-15 02:07:54', '2021-01-20 02:07:54'),
(109, 36, 1, '', '2021-01-15 02:07:41', '2021-01-20 02:07:41'),
(110, 1, 1, '', '2021-01-22 15:04:27', '2021-01-23 15:04:27'),
(110, 6, 1, '', '2021-01-22 15:04:27', '2021-01-23 15:04:27'),
(110, 13, 1, '', '2021-01-22 15:04:27', '2021-01-23 15:04:27'),
(110, 17, 1, '', '2021-01-22 15:04:27', '2021-01-23 15:04:27'),
(110, 18, 1, '', '2021-01-22 15:04:27', '2021-01-23 15:04:27'),
(110, 31, 3, '', '2021-01-22 15:04:51', '2021-01-23 15:04:51'),
(110, 32, 1, '', '2021-01-22 15:04:27', '2021-01-23 15:04:27'),
(110, 36, 1, '', '2021-01-22 15:04:27', '2021-01-23 15:04:27'),
(111, 1, 1, '', '2021-01-22 15:09:00', '2021-01-23 15:09:00'),
(111, 6, 1, '', '2021-01-22 15:09:00', '2021-01-23 15:09:00'),
(111, 13, 1, '', '2021-01-22 15:09:00', '2021-01-23 15:09:00'),
(111, 17, 1, '', '2021-01-22 15:09:00', '2021-01-23 15:09:00'),
(111, 18, 1, '', '2021-01-22 15:09:00', '2021-01-23 15:09:00'),
(111, 31, 3, '', '2021-01-22 15:09:25', '2021-01-23 15:09:25'),
(111, 32, 1, '', '2021-01-22 15:09:00', '2021-01-23 15:09:00'),
(111, 36, 1, '', '2021-01-22 15:09:00', '2021-01-23 15:09:00'),
(112, 1, 1, '', '2021-02-04 12:44:31', '2021-02-04 12:44:31'),
(112, 6, 1, '', '2021-02-04 12:44:31', '2021-02-04 12:44:31'),
(112, 13, 1, '', '2021-02-04 12:44:31', '2021-02-04 12:44:31'),
(112, 17, 1, '', '2021-02-04 12:44:31', '2021-02-04 12:44:31'),
(112, 18, 1, '', '2021-02-04 12:44:31', '2021-02-04 12:44:31'),
(112, 31, 1, '', '2021-02-04 12:44:31', '2021-02-04 12:44:31'),
(112, 32, 1, '', '2021-02-04 12:44:31', '2021-02-04 12:44:31'),
(112, 36, 1, '', '2021-02-04 12:44:31', '2021-02-04 12:44:31'),
(113, 7, 3, '', '2021-02-04 12:44:50', '2021-02-04 12:44:50'),
(113, 9, 1, '', '2021-02-04 12:44:43', '2021-02-04 12:44:43'),
(113, 10, 1, '', '2021-02-04 12:44:43', '2021-02-04 12:44:43'),
(113, 12, 0, '', '2021-02-04 12:44:44', '2021-02-04 12:44:44'),
(113, 21, 1, '', '2021-02-04 12:44:43', '2021-02-04 12:44:43'),
(113, 27, 1, '', '2021-02-04 12:44:43', '2021-02-04 12:44:43'),
(113, 29, 1, '', '2021-02-04 12:44:43', '2021-02-04 12:44:43'),
(113, 30, 1, '', '2021-02-04 12:44:43', '2021-02-04 12:44:43'),
(113, 34, 1, '', '2021-02-04 12:44:43', '2021-02-04 12:44:43'),
(114, 3, 1, '', '2021-02-04 12:45:02', '2021-02-04 12:45:02'),
(114, 8, 1, '', '2021-02-04 12:45:02', '2021-02-04 12:45:02'),
(114, 11, 1, '', '2021-02-04 12:45:02', '2021-02-04 12:45:02'),
(114, 14, 1, '', '2021-02-04 12:45:02', '2021-02-04 12:45:02'),
(114, 24, 1, '', '2021-02-04 12:45:02', '2021-02-04 12:45:02'),
(114, 26, 0, '', '2021-02-04 12:45:05', '2021-02-04 12:45:05'),
(114, 28, 1, '', '2021-02-04 12:45:02', '2021-02-04 12:45:02'),
(114, 35, 0, '', '2021-02-04 12:45:06', '2021-02-04 12:45:06'),
(115, 3, 1, '', '2021-02-03 12:45:18', '2021-02-04 12:45:18'),
(115, 8, 0, '', '2021-02-03 12:45:22', '2021-02-04 12:45:22'),
(115, 11, 1, '', '2021-02-03 12:45:18', '2021-02-04 12:45:18'),
(115, 14, 1, '', '2021-02-03 12:45:18', '2021-02-04 12:45:18'),
(115, 24, 1, '', '2021-02-03 12:45:18', '2021-02-04 12:45:18'),
(115, 26, 1, '', '2021-02-03 12:45:18', '2021-02-04 12:45:18'),
(115, 28, 1, '', '2021-02-03 12:45:18', '2021-02-04 12:45:18'),
(115, 35, 1, '', '2021-02-03 12:45:18', '2021-02-04 12:45:18'),
(116, 1, 1, '', '2021-02-03 12:45:34', '2021-02-04 12:45:34'),
(116, 6, 1, '', '2021-02-03 12:45:34', '2021-02-04 12:45:34'),
(116, 13, 1, '', '2021-02-03 12:45:34', '2021-02-04 12:45:34'),
(116, 17, 2, 'mudik', '2021-02-03 12:45:41', '2021-02-04 12:45:41'),
(116, 18, 1, '', '2021-02-03 12:45:34', '2021-02-04 12:45:34'),
(116, 31, 1, '', '2021-02-03 12:45:34', '2021-02-04 12:45:34'),
(116, 32, 1, '', '2021-02-03 12:45:34', '2021-02-04 12:45:34'),
(116, 36, 1, '', '2021-02-03 12:45:34', '2021-02-04 12:45:34'),
(117, 7, 1, '', '2021-02-03 12:45:52', '2021-02-04 12:45:52'),
(117, 9, 1, '', '2021-02-03 12:45:52', '2021-02-04 12:45:52'),
(117, 10, 1, '', '2021-02-03 12:45:52', '2021-02-04 12:45:52'),
(117, 12, 1, '', '2021-02-03 12:45:52', '2021-02-04 12:45:52'),
(117, 21, 1, '', '2021-02-03 12:45:52', '2021-02-04 12:45:52'),
(117, 27, 1, '', '2021-02-03 12:45:52', '2021-02-04 12:45:52'),
(117, 29, 1, '', '2021-02-03 12:45:52', '2021-02-04 12:45:52'),
(117, 30, 1, '', '2021-02-03 12:45:52', '2021-02-04 12:45:52'),
(117, 34, 1, '', '2021-02-03 12:45:52', '2021-02-04 12:45:52'),
(118, 7, 1, '', '2021-02-02 12:46:07', '2021-02-04 12:46:07'),
(118, 9, 3, '', '2021-02-02 12:46:10', '2021-02-04 12:46:10'),
(118, 10, 1, '', '2021-02-02 12:46:07', '2021-02-04 12:46:07'),
(118, 12, 1, '', '2021-02-02 12:46:07', '2021-02-04 12:46:07'),
(118, 21, 1, '', '2021-02-02 12:46:07', '2021-02-04 12:46:07'),
(118, 27, 1, '', '2021-02-02 12:46:07', '2021-02-04 12:46:07'),
(118, 29, 0, '', '2021-02-02 12:46:12', '2021-02-04 12:46:12'),
(118, 30, 1, '', '2021-02-02 12:46:07', '2021-02-04 12:46:07'),
(118, 34, 1, '', '2021-02-02 12:46:07', '2021-02-04 12:46:07'),
(119, 1, 1, '', '2021-02-02 12:46:22', '2021-02-04 12:46:22'),
(119, 6, 1, '', '2021-02-02 12:46:22', '2021-02-04 12:46:22'),
(119, 13, 1, '', '2021-02-02 12:46:22', '2021-02-04 12:46:22'),
(119, 17, 1, '', '2021-02-02 12:46:22', '2021-02-04 12:46:22'),
(119, 18, 3, '', '2021-02-02 12:46:25', '2021-02-04 12:46:25'),
(119, 31, 1, '', '2021-02-02 12:46:22', '2021-02-04 12:46:22'),
(119, 32, 1, '', '2021-02-02 12:46:22', '2021-02-04 12:46:22'),
(119, 36, 1, '', '2021-02-02 12:46:22', '2021-02-04 12:46:22'),
(120, 3, 1, '', '2021-02-02 12:46:39', '2021-02-04 12:46:39'),
(120, 8, 1, '', '2021-02-02 12:46:39', '2021-02-04 12:46:39'),
(120, 11, 1, '', '2021-02-02 12:46:39', '2021-02-04 12:46:39'),
(120, 14, 1, '', '2021-02-02 12:46:39', '2021-02-04 12:46:39'),
(120, 24, 1, '', '2021-02-02 12:46:39', '2021-02-04 12:46:39'),
(120, 26, 1, '', '2021-02-02 12:46:39', '2021-02-04 12:46:39'),
(120, 28, 1, '', '2021-02-02 12:46:39', '2021-02-04 12:46:39'),
(120, 35, 1, '', '2021-02-02 12:46:39', '2021-02-04 12:46:39'),
(121, 1, 1, '', '2021-02-01 12:47:12', '2021-02-04 12:47:12'),
(121, 6, 0, '', '2021-02-01 12:47:16', '2021-02-04 12:47:16'),
(121, 13, 1, '', '2021-02-01 12:47:12', '2021-02-04 12:47:12'),
(121, 17, 0, '', '2021-02-01 12:47:17', '2021-02-04 12:47:17'),
(121, 18, 1, '', '2021-02-01 12:47:12', '2021-02-04 12:47:12'),
(121, 31, 1, '', '2021-02-01 12:47:12', '2021-02-04 12:47:12'),
(121, 32, 1, '', '2021-02-01 12:47:12', '2021-02-04 12:47:12'),
(121, 36, 1, '', '2021-02-01 12:47:12', '2021-02-04 12:47:12'),
(122, 3, 1, '', '2021-02-01 12:47:32', '2021-02-04 12:47:32'),
(122, 8, 1, '', '2021-02-01 12:47:32', '2021-02-04 12:47:32'),
(122, 11, 1, '', '2021-02-01 12:47:32', '2021-02-04 12:47:32'),
(122, 14, 3, '', '2021-02-01 12:47:34', '2021-02-04 12:47:34'),
(122, 24, 1, '', '2021-02-01 12:47:32', '2021-02-04 12:47:32'),
(122, 26, 3, '', '2021-02-01 12:47:35', '2021-02-04 12:47:35'),
(122, 28, 1, '', '2021-02-01 12:47:32', '2021-02-04 12:47:32'),
(122, 35, 1, '', '2021-02-01 12:47:32', '2021-02-04 12:47:32'),
(123, 7, 1, '', '2021-02-01 12:48:08', '2021-02-04 12:48:08'),
(123, 9, 0, '', '2021-02-01 12:48:10', '2021-02-04 12:48:10'),
(123, 10, 1, '', '2021-02-01 12:48:08', '2021-02-04 12:48:08'),
(123, 12, 3, '', '2021-02-01 12:48:12', '2021-02-04 12:48:12'),
(123, 21, 1, '', '2021-02-01 12:48:08', '2021-02-04 12:48:08'),
(123, 27, 1, '', '2021-02-01 12:48:08', '2021-02-04 12:48:08'),
(123, 29, 1, '', '2021-02-01 12:48:08', '2021-02-04 12:48:08'),
(123, 30, 1, '', '2021-02-01 12:48:08', '2021-02-04 12:48:08'),
(123, 34, 1, '', '2021-02-01 12:48:08', '2021-02-04 12:48:08'),
(124, 1, 1, '', '2021-02-25 19:06:42', '2021-02-26 19:06:42'),
(124, 6, 1, '', '2021-02-25 19:06:42', '2021-02-26 19:06:42'),
(124, 13, 1, '', '2021-02-25 19:06:42', '2021-02-26 19:06:42'),
(124, 17, 1, '', '2021-02-25 19:06:42', '2021-02-26 19:06:42'),
(124, 18, 1, '', '2021-02-25 19:06:42', '2021-02-26 19:06:42'),
(124, 31, 1, '', '2021-02-25 19:06:42', '2021-02-26 19:06:42'),
(124, 32, 1, '', '2021-02-25 19:06:42', '2021-02-26 19:06:42'),
(124, 36, 1, '', '2021-02-25 19:06:42', '2021-02-26 19:06:42'),
(125, 3, 3, '', '2022-02-21 15:34:48', '2022-02-21 15:34:48'),
(125, 8, 1, '', '2022-02-21 15:38:22', '2022-02-21 15:38:22'),
(125, 11, 1, '', '2022-02-21 15:37:58', '2022-02-21 15:37:58'),
(125, 14, 0, '', '2022-02-21 15:36:51', '2022-02-21 15:36:51'),
(125, 24, 3, '', '2022-02-21 15:36:47', '2022-02-21 15:36:47'),
(125, 26, 1, '', '2022-02-21 15:37:57', '2022-02-21 15:37:57'),
(125, 28, 1, '', '2022-02-21 15:23:16', '2022-02-21 15:23:16'),
(125, 35, 1, '', '2022-02-21 15:34:40', '2022-02-21 15:34:40'),
(126, 3, 1, '', '2022-02-21 15:39:02', '2022-02-21 15:39:02'),
(126, 26, 0, '', '2022-02-21 15:39:03', '2022-02-21 15:39:03'),
(126, 28, 1, '', '2022-02-21 15:39:01', '2022-02-21 15:39:01'),
(127, 1, 1, '', '2022-02-22 01:58:37', '2022-02-22 01:58:37'),
(127, 6, 1, '', '2022-02-22 01:58:38', '2022-02-22 01:58:38'),
(127, 13, 1, '', '2022-02-22 01:58:50', '2022-02-22 01:58:50'),
(127, 17, 1, '', '2022-02-22 01:58:40', '2022-02-22 01:58:40'),
(127, 18, 3, '', '2022-02-22 01:58:44', '2022-02-22 01:58:44'),
(127, 31, 1, '', '2022-02-22 01:58:48', '2022-02-22 01:58:48'),
(127, 32, 0, '', '2022-02-22 02:02:13', '2022-02-22 02:02:13'),
(127, 36, 1, '', '2022-02-22 01:58:42', '2022-02-22 01:58:42'),
(129, 7, 1, '', '2022-02-22 02:21:39', '2022-02-22 02:21:39'),
(129, 9, 1, '', '2022-02-22 02:21:51', '2022-02-22 02:21:51'),
(129, 10, 0, '', '2022-02-22 02:21:52', '2022-02-22 02:21:52'),
(129, 12, 1, '', '2022-02-22 02:21:57', '2022-02-22 02:21:57'),
(129, 21, 1, '', '2022-02-22 02:21:37', '2022-02-22 02:21:37'),
(129, 27, 1, '', '2022-02-22 02:21:36', '2022-02-22 02:21:36'),
(129, 29, 1, '', '2022-02-22 02:21:56', '2022-02-22 02:21:56'),
(129, 30, 3, '', '2022-02-22 02:21:54', '2022-02-22 02:21:54'),
(129, 34, 1, '', '2022-02-22 02:21:48', '2022-02-22 02:21:48'),
(130, 3, 1, '', '2022-02-22 05:08:25', '2022-02-22 05:08:25'),
(130, 8, 1, '', '2022-02-22 05:08:25', '2022-02-22 05:08:25'),
(130, 11, 1, '', '2022-02-22 05:08:25', '2022-02-22 05:08:25'),
(130, 14, 1, '', '2022-02-22 05:08:25', '2022-02-22 05:08:25'),
(130, 24, 1, '', '2022-02-22 05:08:25', '2022-02-22 05:08:25'),
(130, 26, 0, '', '2022-02-22 05:11:14', '2022-02-22 05:11:14'),
(130, 28, 1, '', '2022-02-22 05:08:25', '2022-02-22 05:08:25'),
(130, 35, 1, '', '2022-02-22 05:08:25', '2022-02-22 05:08:25'),
(131, 3, 2, 'pulang kampung', '2022-02-14 05:19:58', '2022-02-22 05:19:58'),
(131, 8, 1, '', '2022-02-14 05:19:43', '2022-02-22 05:19:43'),
(131, 11, 1, '', '2022-02-14 05:19:43', '2022-02-22 05:19:43'),
(131, 14, 1, '', '2022-02-14 05:19:43', '2022-02-22 05:19:43'),
(131, 24, 1, '', '2022-02-14 05:19:43', '2022-02-22 05:19:43'),
(131, 26, 3, '', '2022-02-14 05:19:51', '2022-02-22 05:19:51'),
(131, 28, 1, '', '2022-02-14 05:19:43', '2022-02-22 05:19:43'),
(131, 35, 0, '', '2022-02-14 05:20:03', '2022-02-22 05:20:03'),
(132, 3, 0, '', '2022-02-14 05:20:28', '2022-02-22 05:20:28'),
(132, 8, 1, '', '2022-02-14 05:20:26', '2022-02-22 05:20:26'),
(132, 11, 3, '', '2022-02-14 05:20:29', '2022-02-22 05:20:29'),
(132, 14, 1, '', '2022-02-14 05:20:26', '2022-02-22 05:20:26'),
(132, 24, 1, '', '2022-02-14 05:20:26', '2022-02-22 05:20:26'),
(132, 26, 2, 'pulang kampung bareng', '2022-02-14 05:20:42', '2022-02-22 05:20:42'),
(132, 28, 2, 'pulang kampung bareng', '2022-02-14 05:20:42', '2022-02-22 05:20:42'),
(132, 35, 1, '', '2022-02-14 05:20:26', '2022-02-22 05:20:26'),
(133, 3, 3, '', '2022-02-14 14:52:31', '2022-02-22 14:52:31'),
(133, 8, 1, '', '2022-02-14 14:52:29', '2022-02-22 14:52:29'),
(133, 11, 1, '', '2022-02-14 14:52:29', '2022-02-22 14:52:29'),
(133, 14, 1, '', '2022-02-14 14:52:29', '2022-02-22 14:52:29'),
(133, 24, 1, '', '2022-02-14 14:52:29', '2022-02-22 14:52:29'),
(133, 26, 1, '', '2022-02-14 14:52:29', '2022-02-22 14:52:29'),
(133, 28, 1, '', '2022-02-14 14:52:29', '2022-02-22 14:52:29'),
(133, 35, 1, '', '2022-02-14 14:52:29', '2022-02-22 14:52:29'),
(134, 28, 1, '', '2022-02-28 16:32:36', '2022-03-07 16:32:36'),
(135, 28, 1, '', '2022-02-28 16:32:49', '2022-03-07 16:32:49'),
(136, 28, 2, 'keperluan mendesak', '2022-02-28 16:32:57', '2022-03-07 16:32:57'),
(138, 3, 1, '', '2022-08-04 04:16:42', '2022-08-04 04:16:42'),
(138, 8, 1, '', '2022-08-04 04:16:42', '2022-08-04 04:16:42'),
(138, 11, 1, '', '2022-08-04 04:16:42', '2022-08-04 04:16:42'),
(138, 14, 1, '', '2022-08-04 04:16:42', '2022-08-04 04:16:42'),
(138, 24, 1, '', '2022-08-04 04:16:42', '2022-08-04 04:16:42'),
(138, 26, 1, '', '2022-08-04 04:16:42', '2022-08-04 04:16:42'),
(138, 28, 1, '', '2022-08-04 04:16:42', '2022-08-04 04:16:42'),
(138, 35, 1, '', '2022-08-04 04:16:42', '2022-08-04 04:16:42'),
(138, 37, 1, '', '2022-08-04 04:16:42', '2022-08-04 04:16:42'),
(139, 7, 1, '', '2022-08-04 04:17:15', '2022-08-04 04:17:15'),
(139, 9, 1, '', '2022-08-04 04:17:15', '2022-08-04 04:17:15'),
(139, 10, 1, '', '2022-08-04 04:17:15', '2022-08-04 04:17:15'),
(139, 12, 1, '', '2022-08-04 04:17:15', '2022-08-04 04:17:15'),
(139, 21, 1, '', '2022-08-04 04:17:15', '2022-08-04 04:17:15'),
(139, 27, 0, '', '2022-08-04 04:17:47', '2022-08-04 04:17:47'),
(139, 29, 1, '', '2022-08-04 04:17:15', '2022-08-04 04:17:15'),
(139, 30, 1, '', '2022-08-04 04:17:15', '2022-08-04 04:17:15'),
(139, 34, 1, '', '2022-08-04 04:17:15', '2022-08-04 04:17:15'),
(140, 3, 1, '', '2022-11-21 04:19:37', '2022-11-21 04:19:37'),
(140, 28, 1, '', '2022-11-21 04:19:37', '2022-11-21 04:19:37'),
(140, 38, 1, '', '2022-11-21 04:19:37', '2022-11-21 04:19:37'),
(141, 3, 1, '', '2022-11-24 14:12:22', '2022-11-24 14:12:22'),
(141, 14, 1, '', '2022-11-24 08:45:53', '2022-11-24 08:45:53'),
(141, 28, 1, '', '2022-11-24 08:43:00', '2022-11-24 08:43:00'),
(141, 35, 0, '', '2022-11-24 08:45:51', '2022-11-24 08:45:51'),
(141, 37, 2, 'pulang kampung', '2022-11-24 08:45:44', '2022-11-24 08:45:44'),
(141, 38, 3, '', '2022-11-24 08:46:12', '2022-11-24 08:46:12'),
(142, 3, 1, '', '2022-11-24 08:46:37', '2022-11-24 08:46:37'),
(142, 14, 1, '', '2022-11-24 08:46:37', '2022-11-24 08:46:37'),
(142, 28, 1, '', '2022-11-24 08:46:37', '2022-11-24 08:46:37'),
(142, 35, 1, '', '2022-11-24 08:46:37', '2022-11-24 08:46:37'),
(142, 37, 1, '', '2022-11-24 08:46:37', '2022-11-24 08:46:37'),
(142, 38, 1, '', '2022-11-24 08:46:37', '2022-11-24 08:46:37'),
(143, 1, 1, '', '2022-11-24 08:48:50', '2022-11-24 08:48:50'),
(143, 6, 0, '', '2022-11-24 08:51:08', '2022-11-24 08:51:08'),
(143, 13, 1, '', '2022-11-24 08:48:50', '2022-11-24 08:48:50'),
(143, 17, 1, '', '2022-11-24 08:48:50', '2022-11-24 08:48:50'),
(143, 18, 1, '', '2022-11-24 08:48:50', '2022-11-24 08:48:50'),
(143, 31, 1, '', '2022-11-24 08:48:50', '2022-11-24 08:48:50'),
(143, 32, 3, '', '2022-11-24 08:52:34', '2022-11-24 08:52:34'),
(143, 36, 1, '', '2022-11-24 08:48:50', '2022-11-24 08:48:50'),
(144, 3, 1, '', '2022-11-25 02:16:04', '2022-11-25 02:16:04'),
(144, 14, 1, '', '2022-11-25 02:16:04', '2022-11-25 02:16:04'),
(144, 28, 1, '', '2022-11-25 02:16:04', '2022-11-25 02:16:04'),
(144, 35, 1, '', '2022-11-25 02:16:04', '2022-11-25 02:16:04'),
(144, 37, 0, '', '2022-11-25 02:16:07', '2022-11-25 02:16:07'),
(144, 38, 0, '', '2022-11-25 15:48:43', '2022-11-25 15:48:43'),
(145, 1, 1, '', '2022-11-25 02:17:20', '2022-11-25 02:17:20'),
(145, 6, 1, '', '2022-11-25 02:21:46', '2022-11-25 02:21:46'),
(145, 13, 1, '', '2022-11-25 02:17:20', '2022-11-25 02:17:20'),
(145, 17, 1, '', '2022-11-25 02:21:18', '2022-11-25 02:21:18'),
(145, 18, 1, '', '2022-11-25 02:17:20', '2022-11-25 02:17:20'),
(145, 31, 1, '', '2022-11-25 02:17:20', '2022-11-25 02:17:20'),
(145, 32, 0, '', '2022-11-25 02:18:24', '2022-11-25 02:18:24'),
(145, 36, 0, '', '2022-11-25 02:18:18', '2022-11-25 02:18:18'),
(146, 3, 0, '', '2022-11-22 14:09:39', '2022-11-26 14:09:39'),
(146, 14, 1, '', '2022-11-22 14:07:31', '2022-11-26 14:07:31'),
(146, 28, 1, '', '2022-11-22 14:07:31', '2022-11-26 14:07:31'),
(146, 35, 1, '', '2022-11-22 14:07:31', '2022-11-26 14:07:31'),
(146, 37, 3, '', '2022-11-22 14:10:42', '2022-11-26 14:10:42'),
(146, 38, 3, '', '2022-11-22 14:10:25', '2022-11-26 14:10:25'),
(147, 3, 3, '', '2023-04-18 06:25:13', '2023-04-18 06:25:13'),
(147, 14, 1, '', '2023-04-18 06:26:47', '2023-04-18 06:26:47'),
(147, 28, 1, '', '2023-04-18 06:25:12', '2023-04-18 06:25:12'),
(147, 35, 1, '', '2023-04-18 06:26:47', '2023-04-18 06:26:47'),
(147, 37, 0, '', '2023-04-18 06:25:20', '2023-04-18 06:25:20'),
(147, 38, 2, 'mudik', '2023-04-18 06:25:18', '2023-04-18 06:25:18'),
(148, 1, 1, '', '2023-04-19 03:37:54', '2023-04-19 03:37:54'),
(148, 6, 1, '', '2023-04-19 03:37:54', '2023-04-19 03:37:54'),
(148, 13, 1, '', '2023-04-19 03:37:54', '2023-04-19 03:37:54'),
(148, 17, 1, '', '2023-04-19 03:37:54', '2023-04-19 03:37:54'),
(148, 18, 1, '', '2023-04-19 03:37:54', '2023-04-19 03:37:54'),
(148, 31, 1, '', '2023-04-19 03:37:54', '2023-04-19 03:37:54'),
(148, 32, 1, '', '2023-04-19 03:37:54', '2023-04-19 03:37:54'),
(148, 36, 3, '', '2023-04-19 03:37:59', '2023-04-19 03:37:59'),
(149, 1, 1, '', '2023-07-06 15:37:04', '2023-07-06 15:37:04'),
(149, 3, 1, '', '2023-07-06 15:37:04', '2023-07-06 15:37:04'),
(149, 27, 1, '', '2023-07-06 15:37:04', '2023-07-06 15:37:04'),
(149, 28, 1, '', '2023-07-06 15:37:04', '2023-07-06 15:37:04'),
(150, 1, 1, '', '2023-08-10 08:26:25', '2023-08-11 15:26:25'),
(150, 3, 1, '', '2023-08-10 08:26:25', '2023-08-11 15:26:25'),
(150, 27, 3, '', '2023-08-10 08:26:28', '2023-08-11 15:26:28'),
(150, 28, 1, '', '2023-08-10 08:26:25', '2023-08-11 15:26:25'),
(151, 1, 1, '', '2023-08-14 22:40:31', '2023-08-15 05:40:31'),
(151, 3, 1, '', '2023-08-14 22:40:31', '2023-08-15 05:40:31'),
(151, 27, 1, '', '2023-08-14 22:40:31', '2023-08-15 05:40:31'),
(151, 28, 1, '', '2023-08-14 22:40:31', '2023-08-15 05:40:31'),
(154, 1, 1, '', '2023-09-06 08:47:27', '2023-09-06 08:47:27'),
(154, 3, 3, '', '2023-09-06 08:47:30', '2023-09-06 08:47:30'),
(154, 27, 1, '', '2023-09-06 08:47:27', '2023-09-06 08:47:27'),
(154, 28, 1, '', '2023-09-06 08:47:27', '2023-09-06 08:47:27'),
(155, 1, 1, '', '2023-09-06 13:33:15', '2023-09-06 13:33:15'),
(155, 3, 3, '', '2023-09-06 13:33:17', '2023-09-06 13:33:17'),
(155, 27, 1, '', '2023-09-06 13:33:15', '2023-09-06 13:33:15'),
(155, 28, 1, '', '2023-09-06 13:33:15', '2023-09-06 13:33:15'),
(160, 1, 1, '', '2023-08-23 14:10:51', '2023-09-06 14:10:51'),
(160, 3, 1, '', '2023-08-23 14:10:51', '2023-09-06 14:10:51'),
(160, 27, 1, '', '2023-08-23 14:10:51', '2023-09-06 14:10:51'),
(160, 28, 1, '', '2023-08-23 14:10:51', '2023-09-06 14:10:51'),
(161, 1, 1, '', '2023-08-23 15:53:55', '2023-09-06 15:53:55'),
(161, 3, 1, '', '2023-08-23 15:53:55', '2023-09-06 15:53:55'),
(161, 27, 1, '', '2023-08-23 15:53:55', '2023-09-06 15:53:55'),
(161, 28, 1, '', '2023-08-23 15:53:55', '2023-09-06 15:53:55'),
(162, 1, 1, '', '2023-09-06 16:00:41', '2023-09-06 16:00:41'),
(162, 3, 3, '', '2023-09-06 16:00:41', '2023-09-06 16:00:41'),
(162, 27, 1, '', '2023-09-06 16:00:41', '2023-09-06 16:00:41'),
(162, 28, 1, '', '2023-09-06 16:00:41', '2023-09-06 16:00:41'),
(163, 1, 1, '', '2023-08-16 16:03:04', '2023-09-06 16:03:04'),
(163, 3, 1, '', '2023-08-16 16:03:04', '2023-09-06 16:03:04'),
(163, 27, 1, '', '2023-08-16 16:03:04', '2023-09-06 16:03:04'),
(163, 28, 3, '', '2023-08-16 16:03:08', '2023-09-06 16:03:08'),
(164, 1, 1, '', '2023-08-16 16:03:28', '2023-09-06 16:03:28'),
(164, 3, 1, '', '2023-08-16 16:03:28', '2023-09-06 16:03:28'),
(164, 27, 1, '', '2023-08-16 16:03:28', '2023-09-06 16:03:28'),
(164, 28, 3, '', '2023-08-16 16:03:28', '2023-09-06 16:03:28'),
(165, 1, 1, '', '2023-08-16 16:08:15', '2023-09-06 16:08:15'),
(165, 3, 1, '', '2023-08-16 16:08:15', '2023-09-06 16:08:15'),
(165, 27, 1, '', '2023-08-16 16:08:15', '2023-09-06 16:08:15'),
(165, 28, 3, '', '2023-08-16 16:08:15', '2023-09-06 16:08:15');

-- --------------------------------------------------------

--
-- Table structure for table `tb_report_settings`
--

CREATE TABLE `tb_report_settings` (
  `id` int(11) NOT NULL,
  `setting_name` varchar(100) DEFAULT NULL,
  `setting_value` varchar(100) DEFAULT NULL,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_report_settings`
--

INSERT INTO `tb_report_settings` (`id`, `setting_name`, `setting_value`, `created`, `modified`) VALUES
(1, 'letterhead', NULL, '2023-08-26 16:08:34', '2023-08-26 16:08:34'),
(2, 'daily_journal_sign', 'walas', '2023-08-26 16:08:34', '2023-08-26 16:08:34'),
(3, 'daily_presence_sign', 'walas', '2023-08-26 16:08:34', '2023-08-26 16:08:34'),
(4, 'monthly_presence_sign', 'kepsek,walas', '2023-08-26 16:08:34', '2023-08-26 16:08:34'),
(5, 'monthly_summary_sign', 'kepsek,walas', '2023-08-26 16:08:34', '2023-08-26 16:09:25'),
(6, 'semester_summary_sign', 'kepsek,walas', '2023-08-26 16:08:34', '2023-08-26 16:09:28');

-- --------------------------------------------------------

--
-- Table structure for table `tb_room`
--

CREATE TABLE `tb_room` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(300) DEFAULT NULL,
  `room_code` varchar(50) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT 0,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_room`
--

INSERT INTO `tb_room` (`room_id`, `room_name`, `room_code`, `deleted`, `created`, `modified`) VALUES
(1, 'Ruang 113', 'R113', 0, '2020-04-23 15:11:56', '2020-04-23 15:11:56'),
(2, 'Ruang 114', 'R114', 0, '2020-04-23 15:11:56', '2020-04-23 15:11:56'),
(3, 'Ruang 098', 'R098', 0, '2020-05-28 22:41:27', '2020-05-28 22:43:49'),
(4, 'Laboratorium Komputer 1', 'LAB01', 0, '2020-05-28 22:42:00', '2020-05-28 22:43:51'),
(5, 'Ruang 100', 'R100', 0, '2020-05-28 22:45:14', '2020-05-28 22:45:14'),
(6, 'Ruang 120', 'R120', 0, '2020-06-20 03:40:44', '2020-06-20 03:40:44'),
(7, 'KELAS 10', 'R01', 0, '2020-06-20 03:41:50', '2020-06-20 03:41:50'),
(8, 'Ruang 101', 'R101_deleted_1495992912', 1, '2023-04-17 07:23:30', '2023-04-17 07:23:52'),
(9, 'Ruang 101', 'R101', 0, '2023-04-17 07:23:59', '2023-04-17 07:23:59'),
(10, 'Ruang 102', 'R102', 0, '2023-04-17 07:24:05', '2023-04-17 07:24:05');

-- --------------------------------------------------------

--
-- Table structure for table `tb_schedule`
--

CREATE TABLE `tb_schedule` (
  `schedule_id` int(11) NOT NULL,
  `lessons_grade_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `schedule_semester` int(11) DEFAULT NULL,
  `schedule_day` varchar(20) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `schedule_start` varchar(10) DEFAULT NULL,
  `schedule_end` varchar(10) DEFAULT NULL,
  `schedule_order` int(11) DEFAULT NULL,
  `schedule_status` enum('active','inactive','','') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_schedule`
--

INSERT INTO `tb_schedule` (`schedule_id`, `lessons_grade_id`, `room_id`, `schedule_semester`, `schedule_day`, `duration`, `schedule_start`, `schedule_end`, `schedule_order`, `schedule_status`) VALUES
(71, 30, 3, 1, 'senin', 2, '10.10', '11.30', 3, 'active'),
(72, 32, 3, 1, 'rabu', 2, '07.00', '08.30', 0, 'active'),
(73, 31, 3, 1, 'rabu', 1, '08.30', '09.15', 1, 'active'),
(74, 33, 2, 1, 'rabu', 2, '09.35', '11.05', 3, 'active'),
(75, 35, 4, 1, 'rabu', 2, '07.00', '08.30', 0, 'active'),
(76, 34, 5, 1, 'rabu', 1, '08.30', '09.15', 1, 'active'),
(77, 34, 5, 1, 'rabu', 1, '09.35', '10.20', 3, 'active'),
(78, 36, 3, 1, 'kamis', 2, '07.00', '08.30', 0, 'active'),
(79, 37, 5, 1, 'jumat', 2, '07.00', '08.30', 0, 'active'),
(80, 31, 4, 1, 'jumat', 1, '08.30', '09.15', 1, 'active'),
(81, 39, 3, 1, 'selasa', 2, '07.15', '08.35', 0, 'active'),
(82, 40, 1, 1, 'rabu', 2, '07.00', '08.30', 0, 'active'),
(83, 30, 6, 1, 'kamis', 1, '07.15', '07.55', 0, 'active'),
(84, 41, 2, 1, 'jumat', 2, '07.00', '08.30', 0, 'active'),
(85, 42, 4, 1, 'selasa', 2, '08.30', '10.00', 1, 'active'),
(86, 34, 5, 1, 'sabtu', 1, '07.00', '07.45', 0, 'active'),
(87, 44, 1, 1, 'jumat', 1, '08.30', '09.15', 1, 'active'),
(88, 32, 5, 1, 'jumat', 1, '09.15', '10.00', 2, 'active'),
(89, 45, 5, 1, 'jumat', 2, '10.20', '11.50', 4, 'active'),
(90, 46, 1, 1, 'jumat', 2, '09.35', '11.05', 3, 'inactive'),
(91, 39, 4, 1, 'senin', 2, '10.45', '12.15', 3, 'inactive'),
(92, 46, 6, 1, 'rabu', 2, '08.30', '10.00', 1, 'active'),
(93, 30, 5, 1, 'jumat', 2, '09.45', '11.15', 3, 'inactive'),
(94, 46, 4, 1, 'rabu', 2, '10.00', '11.30', 2, 'inactive'),
(95, 30, 5, 1, 'jumat', 2, '09.45', '11.15', 3, 'active'),
(96, 46, 4, 1, 'jumat', 2, '12.15', '13.45', 5, 'inactive'),
(97, 46, 4, 1, 'sabtu', 2, '07.00', '08.30', 0, 'active'),
(98, 35, 2, 1, 'senin', 2, '07.00', '08.30', 0, 'active'),
(99, 42, 4, 1, 'senin', 2, '10.20', '11.50', 4, 'active'),
(100, 38, 4, 1, 'sabtu', 4, '07.00', '10.00', 0, 'active'),
(101, 45, 4, 1, 'sabtu', 2, '10.00', '11.30', 1, 'active'),
(102, 41, 6, 1, 'selasa', 2, '08.35', '09.55', 1, 'active'),
(103, 47, 5, 1, 'kamis', 2, '07.00', '08.30', 0, 'active'),
(104, 43, 1, 1, 'kamis', 2, '08.30', '10.00', 1, 'active'),
(105, 43, 5, 1, 'kamis', 1, '10.20', '11.05', 3, 'active'),
(106, 47, 5, 1, 'jumat', 2, '07.00', '08.30', 0, 'inactive'),
(107, 33, 7, 1, 'selasa', 2, '07.00', '08.30', 0, 'active'),
(108, 31, 3, 1, 'senin', 2, '07.15', '08.35', 0, 'active'),
(109, 44, 5, 1, 'selasa', 2, '09.55', '11.15', 2, 'active'),
(110, 41, 6, 1, 'sabtu', 1, '08.30', '09.15', 1, 'active'),
(111, 39, 3, 1, 'senin', 2, '07.15', '08.35', 0, 'active'),
(112, 46, 4, 1, 'senin', 2, '09.15', '10.45', 2, 'inactive'),
(114, 34, 3, 1, 'selasa', 2, '07.00', '08.30', 0, 'active'),
(115, 43, 3, 1, 'senin', 1, '08.30', '09.15', 1, 'active'),
(116, 43, 3, 1, 'senin', 1, '09.35', '10.20', 3, 'active'),
(117, 36, 5, 1, 'senin', 1, '08.35', '09.15', 1, 'active'),
(118, 36, 5, 1, 'senin', 1, '09.35', '10.15', 3, 'active'),
(119, 39, 2, 1, 'senin', 2, '08.50', '10.10', 2, 'active'),
(120, 44, 3, 1, 'kamis', 1, '07.55', '08.35', 1, 'inactive'),
(121, 39, 3, 1, 'kamis', 1, '07.55', '08.35', 1, 'active'),
(122, 44, 7, 1, 'senin', 2, '11.30', '12.50', 4, 'inactive'),
(123, 51, 3, 1, 'senin', 2, '07.15', '08.35', 0, 'active'),
(124, 52, 2, 1, 'senin', 2, '08.55', '10.15', 2, 'active'),
(125, 51, 7, 1, 'selasa', 2, '07.15', '08.35', 0, 'active'),
(126, 53, 7, 1, 'selasa', 2, '08.45', '10.05', 2, 'active'),
(127, 51, 7, 1, 'rabu', 2, '07.15', '08.35', 0, 'active'),
(128, 53, 3, 1, 'rabu', 1, '08.45', '09.25', 2, 'active'),
(129, 52, 6, 1, 'kamis', 2, '07.15', '08.35', 0, 'active'),
(130, 53, 2, 1, 'kamis', 2, '08.35', '09.55', 1, 'active'),
(131, 52, 2, 1, 'jumat', 1, '07.15', '07.55', 0, 'active'),
(132, 43, 1, 1, 'jumat', 2, '07.15', '08.35', 0, 'active'),
(133, 47, 3, 1, 'jumat', 2, '08.45', '10.05', 2, 'active'),
(134, 54, 9, 1, 'senin', 2, '07.00', '08.30', 0, 'active'),
(135, 55, 2, 1, 'senin', 2, '09.00', '10.30', 2, 'inactive'),
(136, 55, 10, 1, 'senin', 2, '09.00', '10.30', 2, 'active'),
(137, 56, 9, 1, 'kamis', 2, '07.00', '08.30', 0, 'active'),
(138, 57, 1, 1, 'kamis', 1, '08.30', '09.15', 1, 'active'),
(139, 56, 9, 1, 'selasa', 2, '07.00', '08.30', 0, 'active'),
(140, 60, 9, 1, 'rabu', 2, '07.00', '08.09', 0, 'inactive'),
(141, 60, 5, 1, 'rabu', 2, '07.00', '08.09', 0, 'inactive'),
(142, 58, 10, 1, 'rabu', 2, '07.00', '08.09', 0, 'inactive'),
(143, 61, 3, 1, 'rabu', 2, '07.00', '08.16', 0, 'inactive'),
(144, 60, 3, 1, 'rabu', 2, '07.00', '08.10', 0, 'inactive'),
(145, 58, 6, 1, 'rabu', 4, '07.00', '09.20', 0, 'inactive'),
(146, 57, 9, 1, 'rabu', 3, '07.00', '08.45', 0, 'inactive'),
(147, 58, 1, 1, 'rabu', 1, '07.00', '07.35', 0, 'inactive'),
(148, 60, 5, 1, 'rabu', 2, '07.00', '08.30', 0, 'active'),
(149, 61, 10, 1, 'rabu', 2, '08.30', '10.00', 1, 'active'),
(150, 57, 2, 1, 'rabu', 2, '10.00', '11.30', 2, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tb_schedule_settings`
--

CREATE TABLE `tb_schedule_settings` (
  `schedule_setting_id` int(11) NOT NULL,
  `setting_name` varchar(100) DEFAULT NULL,
  `setting_value` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_schedule_settings`
--

INSERT INTO `tb_schedule_settings` (`schedule_setting_id`, `setting_name`, `setting_value`) VALUES
(1, 'lesson_hour', '45'),
(2, 'start_time', '7'),
(3, 'lesson_hour', '45'),
(4, 'start_time', '7'),
(5, 'lesson_hour', '45'),
(6, 'start_time', '7'),
(7, 'lesson_hour', '45'),
(8, 'start_time', '7'),
(9, 'lesson_hour', '45'),
(10, 'start_time', '7'),
(11, 'lesson_hour', '45'),
(12, 'start_time', '7'),
(13, 'lesson_hour', '45'),
(14, 'start_time', '7'),
(15, 'lesson_hour', '45'),
(16, 'start_time', '7'),
(17, 'lesson_hour', '45'),
(18, 'start_time', '7'),
(19, 'lesson_hour', '45'),
(20, 'start_time', '7'),
(21, 'lesson_hour', '45'),
(22, 'start_time', '7'),
(23, 'lesson_hour', '45'),
(24, 'start_time', '7'),
(25, 'lesson_hour', '45'),
(26, 'start_time', '7'),
(27, 'lesson_hour', '45'),
(28, 'start_time', '7'),
(29, 'lesson_hour', '45'),
(30, 'start_time', '7'),
(31, 'lesson_hour', '45'),
(32, 'start_time', '7'),
(33, 'lesson_hour', '45'),
(34, 'start_time', '7'),
(35, 'lesson_hour', '45'),
(36, 'start_time', '7'),
(37, 'lesson_hour', '45'),
(38, 'start_time', '7'),
(39, 'lesson_hour', '45'),
(40, 'start_time', '7'),
(41, 'lesson_hour', '45'),
(42, 'start_time', '7'),
(43, 'lesson_hour', '45'),
(44, 'start_time', '7'),
(45, 'lesson_hour', '45'),
(46, 'start_time', '7'),
(47, 'lesson_hour', '45'),
(48, 'start_time', '7'),
(49, 'lesson_hour', '45'),
(50, 'start_time', '7'),
(51, 'lesson_hour', '45'),
(52, 'start_time', '7'),
(53, 'lesson_hour', '45'),
(54, 'start_time', '7'),
(55, 'lesson_hour', '45'),
(56, 'start_time', '7'),
(57, 'lesson_hour', '45'),
(58, 'start_time', '7'),
(59, 'lesson_hour', '45'),
(60, 'start_time', '7'),
(61, 'lesson_hour', '45'),
(62, 'start_time', '7'),
(63, 'lesson_hour', '45'),
(64, 'start_time', '7'),
(65, 'lesson_hour', '45'),
(66, 'start_time', '7'),
(67, 'lesson_hour', '45'),
(68, 'start_time', '7'),
(69, 'lesson_hour', '45'),
(70, 'start_time', '7'),
(71, 'lesson_hour', '45'),
(72, 'start_time', '7'),
(73, 'lesson_hour', '45'),
(74, 'start_time', '7'),
(75, 'lesson_hour', '45'),
(76, 'start_time', '7'),
(77, 'lesson_hour', '45'),
(78, 'start_time', '7'),
(79, 'lesson_hour', '45'),
(80, 'start_time', '7'),
(81, 'lesson_hour', '45'),
(82, 'start_time', '7'),
(83, 'lesson_hour', '45'),
(84, 'start_time', '7'),
(85, 'lesson_hour', '45'),
(86, 'start_time', '7'),
(87, 'lesson_hour', '45'),
(88, 'start_time', '7'),
(89, 'lesson_hour', '45'),
(90, 'start_time', '7'),
(91, 'lesson_hour', '45'),
(92, 'start_time', '7'),
(93, 'lesson_hour', '45'),
(94, 'start_time', '7'),
(95, 'lesson_hour', '45'),
(96, 'start_time', '7'),
(97, 'lesson_hour', '45'),
(98, 'start_time', '7'),
(99, 'lesson_hour', '45'),
(100, 'start_time', '7'),
(101, 'lesson_hour', '45'),
(102, 'start_time', '7'),
(103, 'lesson_hour', '45'),
(104, 'start_time', '7'),
(105, 'lesson_hour', '45'),
(106, 'start_time', '7'),
(107, 'lesson_hour', '45'),
(108, 'start_time', '7'),
(109, 'lesson_hour', '45'),
(110, 'start_time', '7'),
(111, 'lesson_hour', '45'),
(112, 'start_time', '7'),
(113, 'lesson_hour', '45'),
(114, 'start_time', '7'),
(115, 'lesson_hour', '45'),
(116, 'start_time', '7'),
(117, 'lesson_hour', '45'),
(118, 'start_time', '7'),
(119, 'lesson_hour', '45'),
(120, 'start_time', '7');

-- --------------------------------------------------------

--
-- Table structure for table `tb_school`
--

CREATE TABLE `tb_school` (
  `school_id` int(11) NOT NULL,
  `school_name` varchar(300) NOT NULL,
  `school_type` enum('Sekolah Dasar','Sekolah Menengah Pertama','Sekolah Manengah Atas') NOT NULL,
  `school_address` varchar(500) DEFAULT NULL,
  `school_telephone` varchar(30) DEFAULT NULL,
  `school_status` tinyint(1) NOT NULL,
  `school_domain` varchar(255) NOT NULL,
  `school_letterhead` text DEFAULT NULL,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_school`
--

INSERT INTO `tb_school` (`school_id`, `school_name`, `school_type`, `school_address`, `school_telephone`, `school_status`, `school_domain`, `school_letterhead`, `created`, `modified`) VALUES
(1, 'SMK Negeri 999 Kota Bekasi', 'Sekolah Manengah Atas', 'Jl. Raya Pekayon No. 30', '(021) 800398493', 1, 'next.actudent.com', '{\n    \"city\": \"Bekasi\",\n    \"website\": \"smkn999kotabekasi.sch.id\",\n    \"email\": \"smkn999kotabekasi@yahoo.com\",\n    \"opd_logo\": \"logo-opd.png\",\n    \"school_logo\": \"logo-sekolah.png\",\n    \"opd_name\": \"Pemerintah Provinsi Jawa Barat\",\n    \"sub_opd_name\": \"Kantor Cabang Dinas Wilayah IV\",\n    \"headmaster\": \"Dr. Raihan, M.Pd.\",\n    \"headmaster_nip\": \"19631212 198410 1 012\",\n    \"co_headmaster\": \"Rino Swastika, S.Pd\",\n    \"co_headmaster_nip\": \"19631212 198410 1 012\"\n}', '2018-10-09 17:00:00', '2023-08-06 15:01:41');

-- --------------------------------------------------------

--
-- Table structure for table `tb_score`
--

CREATE TABLE `tb_score` (
  `score_id` int(11) NOT NULL,
  `lessons_grade_id` int(11) NOT NULL,
  `score_type` enum('Teori','Praktik') NOT NULL,
  `score_category` enum('Tugas','UH','PTS','PAS','Kinerja','Proyek') NOT NULL,
  `score_description` varchar(250) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_score`
--

INSERT INTO `tb_score` (`score_id`, `lessons_grade_id`, `score_type`, `score_category`, `score_description`, `deleted`, `created`, `modified`) VALUES
(1, 34, 'Teori', 'Tugas', 'Menjadi warga negara yang baik', 0, '2020-09-18 08:40:31', '2020-09-18 08:40:31'),
(2, 35, 'Praktik', 'Tugas', 'Latihan memanjat tebing', 0, '2020-09-18 08:50:32', '2020-09-18 08:50:32'),
(3, 42, 'Teori', 'Tugas', 'Menghitung harga kertas plano', 0, '2020-09-18 08:52:50', '2020-09-18 08:52:50'),
(4, 42, 'Teori', 'UH', 'Ini ulangan tersulit', 0, '2020-09-18 08:55:02', '2020-09-18 08:55:02'),
(5, 34, 'Teori', 'Tugas', 'Tes mengingat kenangan', 0, '2020-09-18 09:51:02', '2020-09-18 09:51:02');

-- --------------------------------------------------------

--
-- Table structure for table `tb_score_student`
--

CREATE TABLE `tb_score_student` (
  `score_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `score` decimal(10,2) NOT NULL,
  `score_note` text DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_score_student`
--

INSERT INTO `tb_score_student` (`score_id`, `student_id`, `score`, `score_note`, `created`, `modified`) VALUES
(1, 1, 85.00, 'sudah bagus sekali ini', '2020-09-18 08:41:05', '2020-09-18 08:41:05'),
(1, 6, 80.00, 'kalah oleh rekannya', '2020-09-18 08:41:05', '2020-09-18 08:41:05'),
(2, 1, 95.00, 'pertahankan prestasimu', '2020-09-18 08:51:18', '2020-09-18 08:51:18'),
(2, 6, 80.00, 'jangan mau kalah oleh teman', '2020-09-18 08:51:18', '2020-09-18 08:51:18'),
(2, 13, 75.00, 'kurang sekali performanya', '2020-09-18 08:51:18', '2020-09-18 08:51:18'),
(2, 17, 78.50, 'lumayan', '2020-09-18 08:51:18', '2020-09-18 08:51:18'),
(3, 1, 90.00, '', '2020-09-18 09:50:16', '2020-09-18 09:50:28'),
(3, 6, 90.00, '', '2020-09-18 09:50:28', '2020-09-18 09:50:28'),
(3, 13, 90.00, '', '2020-09-18 09:50:28', '2020-09-18 09:50:28'),
(3, 17, 80.00, '', '2020-09-18 09:50:28', '2020-09-18 09:50:28'),
(3, 18, 90.00, '', '2020-09-18 09:50:28', '2020-09-18 09:50:36'),
(3, 31, 90.00, '', '2020-09-18 09:50:28', '2020-09-18 09:50:28'),
(3, 32, 90.00, '', '2020-09-18 09:50:28', '2020-09-18 09:50:28');

-- --------------------------------------------------------

--
-- Table structure for table `tb_sessions`
--

CREATE TABLE `tb_sessions` (
  `login_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_main_session` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `token_expiration` int(15) NOT NULL,
  `created` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_sessions`
--

INSERT INTO `tb_sessions` (`login_id`, `user_id`, `is_main_session`, `is_active`, `token_expiration`, `created`) VALUES
(1, 1, 1, 1, 1707380826, '2024-02-08 06:27:06'),
(2, 1, 0, 1, 1707380855, '2024-02-08 06:27:35'),
(3, 1, 0, 1, 1707380914, '2024-02-08 06:28:34'),
(4, 1, 1, 1, 1707461133, '2024-02-09 04:45:33'),
(5, 1, 1, 1, 1707668859, '2024-02-11 14:27:39'),
(6, 1, 1, 1, 1707676248, '2024-02-11 16:30:48'),
(7, 1, 0, 1, 1707676351, '2024-02-11 16:32:31');

-- --------------------------------------------------------

--
-- Table structure for table `tb_staff`
--

CREATE TABLE `tb_staff` (
  `staff_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `staff_nik` varchar(20) DEFAULT NULL,
  `staff_name` varchar(50) DEFAULT NULL,
  `staff_phone` varchar(20) DEFAULT NULL,
  `staff_type` enum('teacher','staff') DEFAULT NULL,
  `staff_title` varchar(100) DEFAULT NULL,
  `staff_photo` text DEFAULT NULL,
  `staff_tag` tinyint(1) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_staff`
--

INSERT INTO `tb_staff` (`staff_id`, `user_id`, `staff_nik`, `staff_name`, `staff_phone`, `staff_type`, `staff_title`, `staff_photo`, `staff_tag`, `deleted`, `created`, `modified`) VALUES
(1, 4, '123456789', 'Firhan Yudha Prakoso', '08230298484', 'teacher', 'Guru Matematika', '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', 1, 0, '2020-02-12 12:37:26', '2022-09-09 07:58:03'),
(2, 12, '987654321', 'Uus Rusmawan Prasetyo', '083290489348', 'teacher', 'Guru RPL', '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', 1, 0, '2020-02-12 12:38:09', '2020-02-25 07:03:44'),
(3, 13, '2093847283', 'Sudrajat Drajat', '089889878476', 'teacher', 'Guru PKN', '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', 1, 0, '2020-02-23 06:55:07', '2020-07-10 05:00:29'),
(4, 44, '9087657654', 'Rian Mangkulangit', '089878738774', 'teacher', 'Guru Berbudaya', NULL, 1, 0, '2020-03-13 00:11:26', '2020-03-13 00:11:26'),
(5, 45, '7656746298', 'Reinhard Oktora', '087898765723', 'teacher', 'Guru Biologis', NULL, 1, 0, '2020-03-13 00:12:31', '2020-03-13 00:12:31'),
(6, 47, '9878736567', 'Indah Dwi Hartati', '0878676354526', 'teacher', 'Guru IPS', NULL, 1, 0, '2020-04-06 01:39:35', '2020-04-06 01:39:35'),
(7, 48, '9087678365', 'Lintang Sudarmanto', '0897872847681', 'teacher', 'Guru PJOK', NULL, 1, 0, '2020-04-06 01:40:31', '2020-04-06 01:40:31'),
(8, 49, '0929789274', 'Abdal Salem', '0878928878472', 'teacher', 'Guru Nasional', 'null', 1, 0, '2020-04-06 01:43:50', '2022-11-29 06:09:12'),
(9, 50, '2908392849', 'Edwin Susanto', '0893874876277', 'teacher', 'Guru Pemrograman', NULL, 1, 0, '2020-04-17 10:12:27', '2020-04-17 10:12:27'),
(10, 53, '2309849028', 'Muhammad Rizal', '0897384758284', 'teacher', 'Guru Desain Grafis', NULL, 1, 0, '2020-07-10 05:47:57', '2020-07-10 05:47:57'),
(11, 69, '3985093485', 'Ryan Dahl', '080930984398', 'teacher', 'Guru Node.js', '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', 1, 0, '2022-06-16 05:44:57', '2022-06-16 05:44:57');
INSERT INTO `tb_staff` (`staff_id`, `user_id`, `staff_nik`, `staff_name`, `staff_phone`, `staff_type`, `staff_title`, `staff_photo`, `staff_tag`, `deleted`, `created`, `modified`) VALUES
(12, 70, '9384345938', 'Ryan Dahl', '089308495384', 'teacher', 'Guru Node.js', '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', 1, 1, '2022-06-16 05:46:16', '2022-06-16 05:46:32'),
(13, 71, '3975834759', 'Linus Torvalds', '0830842987342', 'teacher', 'Guru Linux', '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', 1, 0, '2022-06-16 05:47:26', '2022-06-16 05:47:26'),
(14, 72, '0943593845', 'Abraham Lincoln', '08345893485', 'teacher', 'Guru Amerika', 'iVBORw0KGgoAAAANSUhEUgAAAHgAAACgCAYAAADHCaiQAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAgAElEQVR4nO2dWYxdV3aev33GO091h5rnYrHIIotTUZREUZSolroldbfdbsMPNgK7EfgheTDgIMir8pA8JQhgIA4QxEAC2zESOImnbrtHqTVRFElxHopDzXPVned7pjwUiyJFFoukWJdUsX6AuMV79rlrrb3O3metPfxb9A694nAfFPJpHGflkm1bSJJ81/Xmtg7K5SqyJHB7PJiOhFlYJl2o0piIUygU8AWCFPM5vL4ApmkggFI+Q9mExliIctVGVQSG6VCrFPEFw1TLJbz+IJVSgUA4SqWYp1QqgYDk4vz9VN3CA6CsOvFuODiOc9vB3Pn3LQhZJxx2Y9sWlZqFrssUymUswwBZJ57wUyzk8Qcj2GYVRdNZmBylIZ6gWqiSSy8Ta91GNrmA7vKQTqdoaQsym89RKxeRJJlSPofj2EiygqZI9+iwhfUhWrftvafWbNvGNGqAc/v/kiTdeRuqpuNyu6mUy3i8XvK5LC6Xi3K5TCAYIpfNEAiGyGcz+INhyqUCRq2KoqpYloPARlI0dE2lWjNQFQmEgm3WsGwbAFlRwbHwhRNUsosUiqV61Mmmgoi2bVu3WTi2jbjLwfWFJMnYtvXU5H+TobhVsW4hx5EQYv1yGwcb5Kcp/5sLJezTn7YOW9hAKPat9926BRVlg1V5MMrlMpb1dLtpIQQej+ep9maO42CaJkIIHMdBUZQH6rOu1xzHIR6Po+tPt6XPzMxQq9Weqg6O4xCNRlFV9anqsbCwgGEYuN1uotHoA8s+VOQkPcUAawv3YtUfD+OXr+25QKiBffv24ve6v+5PPTZkzc0rr7xCS1P8qchvaetk//79dPf00NbRTUPA8+VFIbFjcDexhvBd9whJJhQMPDEdFEWhvb2d9vb2u1r1136xdm8fZHnsPK8fO0YqV2bs+gh9/duYmRhFdgdR7Aq24iHs1UgXq5ilHC5/hEJmEdnlpykWYmEpgyJMLl4eeSwd3ME4Id3mW299h8+/OE9PWyPj0/N4VJhPl9gzuJ3jH39MY1MMWXERSTQzdu0yOwZ3c/7cWQZ37WZyfJSunh4++fX7pLKFR5I/uHOAL06dJJxoxKu6UcwiO/cOMz89Tqqq0tUYZHpmlv7eTmRXkHgswqVLV3j7O2/wi19+QF9fH2Ojowxs345tW6SWFymZArtS4Or1m49cH3cOCD2Bvlewa2gPF8+fQ5UcfLFWbl48RWfPNtqaE1y4PMK+fXtxud3gQCQSwQEi4Qj79+1HVnQUWaIhEvlaWgzs3ofiGLxy+DDIGm5NJh6Pc2DPLn7yi084fPgQ7W2ttLW349UVbHeUuZvnCTX1EPHK+P0BFNVF+DFalayotLQ0EYnGUISgtbufaMCFx+tjefoGI9MpDu7ZQXv3dmINIWRFI+D3MXZ9hP6duzGrVaJNbSzP3MS0bALhKI7jEGl4tDrRdR1d1++KEeR4PP7eejf6fD5kWb7vNUXVGLl0loXlDJqmMXrjOnv2H2Ri9BqFqkVrooG5xSS1coFyzUJTBJWaiYzF5Mw8imOQypfwujWmpmfX1CGfz68ZRQtZZnlmjFTRYHxiArdsM7ucJeT3cO7SNY68uI8P33+fRHsf1WKauflFboxcZu/Bl5geu0aoIc7o2BiBQIDlxXkyubVbcDAYvKcuFFni4sVLKKpGcnEBy6ygegJMT4xjyzrberqYn5vGFYxx88p5fP4g6eQC4XgrN6+NEItFGR0dpVouUq6a5PN5TBt0VWJm9t7x91KphGVZqKqK273yalQUhZaWFjRNwzAMstnsSt0MDg4+cCTLcRwaGxufeuT4rETRbW1tj1UXutvHtu5WLly6+rX1WFpaolqt4vF4iKzT822Fx3VCtVx4Is59VKwbZAkhyGazTz0PrtVqGIbxVHUAKBaLa76u6gHHcW73ZJVKhXw+/8Dy63bRW/hmQ3m6kwhb2Ggo4XB4/VJb+MZiK8ja5Nhy8CbHloM3ObYcvMmx5eBNji0Hb3JsOXiTY8vBmxxbDt7kUFanm1ZX6dUDm1VWveU9jCwlmUwiyzKKolCtVuuimNvtplwu101WpVKpW6XX0zZN01a2GZnmmmUkYFNv6nrebVNWdxE699lBuFF4GrKeV9ueiyDreW7Fz0ULvvOzHvKeJduUOxWq55Neb1nPq23SnQXrhc0qq97yHirIcrlcSJKEqqp12zXncrnqVhEul6uuuWk9bXuYNEkpl8tIkoRpmnXLg4G65YqO41CpVOoiaxX1ss00TWzbfuC22k0fZN0ps15yniXbNn2QVe+Hd1VmveQ890FWvfGs2aZ0tNSYnlvZtfBV5aTGVkTo1l5TxwHbwpq8AdWv/06rS0VIEo7HD6qOk8us2FAHPLJtdwa397lXSrQivH7spTmcfOb297Li4PVBuQhmzcEy4auMHEq1Kjiwu4yqW2BWuFDcQV6Ogixjz01h37i4qgXICsruQ+yf/gjHNJAlOJFqQPE0YpQW8PnzbAvGcDJl7EwJx3LIWTbjqkE0YlGpSuQK4na3ImlRJL0FcMAxcawSjl3CqSVxnHsDB6FqyP1DKxVi2zi1Ck4xjzQ7RW9NRkJwPaTjbB+CWnWlsqwaVCrIPYM4c5M4i3PY5h3BpBAonn6QNBy7jFW6cU8lKzIM76qCgJoBZ661IunNYOfp2jmFHJYRBZubpw1k26HRlGg1FCwcNAQLXSUam21sSeVCdYia8+U2IMmRcByLdr9Di7mMYpuczuoo5XHMmkOx5SBIizileUQsjtTeC6qGvzxGRyLD0oyJNyShqKDqAssQLHzhRXPceKwA4rXf+Z5T9ZnIupdQ83bemZzg5qib7rZlEGMYHpOSA3MFQbEi2NEgUd7WSyFn43E77NJLvD+Ro6XNRWIySHVvmbLjp5idIWnJtHsF/UmdyUU3LsnGky3jN2qUTYmTeoIJbQpw8KR0ImxDM8L0iAL+nsvoGKQXwR+2KZoyVzy9LI5ZlKoCe26ZJtOL7k1gNHq5oJ1EUgRHw624u65CyCCXtgl5VMolg56aTmZ8B4s5F7pR4oWGaziSoGj6mPZLLFQtYkWFQsGDnyRJAbvjUHAHUPMWl0dSCNnBFwFXT5jZWgZvk4tsLoR7towRsNmZErgUGLXLnLOyuBQLXRaEpF38pDmKXEqxz5rBVQzjWDl8ug+n5EezTA42LLIgV/H5wFX18V+kXoRkMhCZwjqlI1UEhSY4mZaQaxX2vtXBzJ/lsKsWqm3QFLNQFIeyt4YacUjOF0nWyoi//Tc/cgzHg1asUZ7RWWgtY5SquFx+XE0OlreIXpIIVCvowiSLD7nkxhQ2mWwWQyRo1Q2yMwukw61oThBh5Cg3+Ci3NWKns8hzF1AlA6fkphr3IXltlJJG05SgNT6Og8N42WFCtqgoNpmUhF8ITAdSbi/BBj/uWpUepUSf10SVHNIqLBQdNMWhbGu0xCpYDkxNNMBMkFrFwu8p0KnIyLrDcV+Fk5YBNQdUgU/2ElR0cpkSPU4Oj1tmfNlienVrsCSI+CGhQRYV77YwkYAXO1mlmO7GI5mo6SVCtVlqpsDBgJcl/KkgekhgN+i4jCVsIeCaTuWsTlYTNLTXiNoOZVFhYqHGsqvGbElgaDq94VaqBQk7L/GGdxFTGGRki0hXDW9QgCVTTGsUU4JS1SLuttBkgeWySeUAQ+BxO/iFhOZ2KJsuxJEjR5zVgY565cEul6tuuanL5aJardZ1oKNetqmqum4eLIHA43bjOFCPcSwhyZiGgVaHDeWSrGBbJpqmbbgsAE13UavV0Oskz7btdfnLFEnxMLx/F9mKQik1wdUbUxuq1I69L9EaNFlOlzh95tyGytJ0Dwf2DuGORDjzq39gubixRGqxpg529jaSzeQ4cerMhspSNDd7dw2gBeJMXznOxHz2/uWEMFlcTFFxVDLLqQ1VCiCbWkSUHSrlje/GJFkwNzuFv1IhV9l4ljyvS+bSyBgB18azApq1MlMzs4QNh1R2bRZeceTIkWcrM9/CE8VzsaLjeUbdGEYVLCQe3FkYyDh1CfXWh6auwwfiCGrm0yVoXYUQDpJ6f1JZRddUHCRMs4ZtOyAEkVCIVDoNgNvjxTJWKPlrlTKqpj/WdNgPtum827m28wro/KufpSijISSJSChEoVgiGPCxtJxcSXdqBqoscHt85LIZ7Fupj+5yUb2VmqzqK6s6RvXx9f23f2TQ0772POu5qyr/7k9XHKxqOh6XhuUIVFmQzRdRZYGQFYyaQcDvJZ1ZCYL8gSBej5tUcpmaYRIIBMnns/h8fvKFAm5dp/yIaZbuM/ij/9ALyr12Knt39LLj0Ov8zV/8N1KFKl5fkL2HXmF59Bznrs/y7rtvY1YrVCwJgUNqfoLPTj169OvRZGL28tpKaqv8ioLf+MEPGb95nYamdgrzoxx6YRjDcjh+ZoTdXQ1UHJWwV+Gnv/wI1eXlD//w9/nTP/nPWJLCu++8jWVUKRsrT3ZmcZpPP3/0iDbkN0mEF9a8HvA1r+jtDfKb736LK1eu0tXTz8xCkmjYR3rmOq5oB9cunufQq8c4/vO/ZS5VwOVy89obb/LTv/tr5EQHh3b1UEOjqbmR5NwUZ0+fZOox8mh/1MRScvd8L9mWwfnzF29/UcxnyOdyKLoHWfOQW5qhalicPfMFiiLT0NRBUzT4yAo8NISMVS1y5swZ8qUq0VicmakpQCBJglo5j+bycu7cBQCMSpFLV6+vGKO6ySXnqNRMzp49gyIrhONtNMdCG6ZuJNHCzctnOXf+IrKqEQ64mZ6ZRxIrLPmp5SVyhSI+nw+ApaVF0kvzpHIlYolGzp/+DFnYfPzRJ/gjCXbv3Yf8BFfWSCOjUxTyOUxrpQ+PxBoJeHRKNZvtHTFsPUQ+myKTKzJ2fQQHsbFLexyTpUyRY8eOodhVPvzgV5w+d5FixeDw8G7GFwp0NjfgD3z5kOUyGWTNw0B3E5bqp5BLkc7mGb85gr3B+s5PXCPeMcCrr7zE3NQ4P/unf+TSxfNE27fhVRwamtpQHIN8aaX7dAcamJu8QVtPP+mZmwwdOsrk6DUcIfHFqc+RhPRER5zWTJN0b5CgDoup+yfQj4qBmEx3zLfmdcOyeP9aFsN5PJIxzRMg7JFYWM6sX/ghcPSQTTCwNvnbcrLCJ6cfnxCtubWNxdlpTPvrZ6mqbnHwSAxxn5xIcekawXADpUKOfKEIQhBtiJBcTrJYBI/Pj1WroGguquUimu5aOajqETF14IcsHX13zetapUDp3/8xarWMJMk0NETIF4qEg34WFhZxezyUqzU0WWCYNi6XRvHWMTvhcJhMOs1CCTxeH7ZRRdZc1ColVE1/LH3Pp/4YqdS25nWzMAL8VwB0lxuvS8O8FWSlcwW0W0GWLCsEA37SqSSlW4M7breb2emVEcNQOEwuk8EfDJLNZvG4XJQeMSi0Um5af/XPMO9DeqcMDfTS1ruDX/78ZysCIzG27dyNnZ3ms/M3eec7b2EaNaqmhBAOydkxPjt9/pEUAJBdLjL+hjWvh2+PTQt+47d+yI2Rqwy1dpKduc7B4f3UTJvjZ0bY0Ragtauf93/5M4rFEu19uxjoiFKrlnn/k1O88/a3sYwaZVMgCUjNT3D85NlH1tcWXvJl/5rXvdIK6bfuDfGb7xzj0qUr9GzbztTcMoeiAZLTK0HWlbNfsPfgS1z6/APGZirEm9v4zuuH+R9/8VfE23oZ3tGJJbtvB1mnT554ZAcDqEUP5uK9Ub/k2Cbj03PsGRoEIJNaJuBzcfHqKJLmIbc8R7Vmcvr0SSRJItrSRfMGB1lmpcD58+fIl6okGpuYnJhA3AqyIo3tUCvwwsEXAEg0NvLFiU9w+0K3gqx5KjWTL06fRJIEDY0dtMQ3juwtEm9m9Mp5Lly6jKzqNIS8jE/N3Q6yspkUZjnP2MwSAIuzU8wtJgGIxhNcPPs5EhYffPBrfOE4e/cfQJaeYJA1OpvE79FJJVfGoZvae/EqDtGmVnZ0xrHUALn0MrlCmbHrV7BsZ53hiq8Jx2QxVeDYsWPIVoVff/Arzpy/RK5c4/DwLj79+CMKhmB+fg6AyxfO8OJr32ZsbIwdPU2Yio98Jkk2X2L8xgjmQ54q87iYn7hGQ3s/r77yErOTo/zsn/6RKxcvEGnbhlu2qdoyqeTiXfek02nae7aTnr7B7heOMnFzBElWOfX5iZXD5p5gBT8gyAoQ0GApfW9u9TiQenbga+ta87plGuQ++wDZfDxOaM3jJ+SWWEw+maBQCw3jcq/dRZeLKYzco3f9q2hqaWVxbgbrCQRZoqbQr++5b7awNdmwybE12bDJseXgTY67pkO2De5DKi/RNbCXqclparl5ro3P0trVh8sucmNi7UMztvBsQnz6+WdOcnaa//if/oQXjr7Ntw8P0dDYzF//3x+TaPCzc6CfD0+c5YVd3dyczdDR2swHv/4133v7TT749DRu2SYW8fFnf/6/n7YtW7gPJLNaRvcEbp/e+vN//DtGbk4ihKCUS6N4wkTDfhYXFojHYywsZ4jHolw5f4pf/fIXvPHdH/Dpxx8/XSu2sCaUTDbDX/z3P8ew4eIXxxFWldG5/0mxWELXVK6NTnBzdIyu7i5mZ35MIh5lanaBsN9NV28fV05/wtWxra77WcVWmrTJsRVFb3JsOXiTQ3naJ3tvYWOheDweJElCUZS6nQ2o63rd9kHpuk6tVqvb3qR62qYoCo7jPJijI5vNUu/NZ/Uk7Kz35rN62qaqKo7jPJhl53kgYXmebdv0QdazxpnxJLHFNkv9WXaeNds2fQuG57sVb/oWfKfMesl5lmx7Ki14Mx9p+6zZpvTbAYQjkIWCadfnlG+tplGz6zPAotY0DFurG0dWPW2TTQXHtrEfsLBQuUIGSUiokkqVOuXBspsydTqUQ3FTMSts8FrQL+XV0TZN0rCxMe2HyINhc9IZbnFV1lmpLdQXT6UFP2u54kbIq6esZ64FP0tpxDdZ1sPguXgH11NePWU9TAtW1E6QhIOsWKzHO/KkIOkWap1OD5A1C7VWrxi6vrYpio1tO4gHbL9S4kYLQggUR8Ew6uNhXdKpGvWpBU1o1Iz6zHNDfW1TnIeYD06lVnYVSpL0wIT5SWKzyqq3vNVRswd20ZLq5dD+bWTLCtmFUabnkxuqVHvfLhJ+h3LZ4OKVkQ2V5faF6O9uw9cQ5+wn71OobWzFJ1q66GxtwCiV+OLC5Q2VpWhutvd2oAfiTFw5yXL2/oMrksBCkjQURUFRHp9z4mHh9frw+bzrsqQ+CUiSQFV1VFVFrsOoe1NTgmKxglwH28xamUrNQlFVlAcYt7UuepPjuZgPfp6x5eBNji0Hb3JIoWAAgHAkghAQCIZoiESQhMDj8Txl9Z59vPHW2xx+8SBerxe3240kKwQCASLhEJIkk0gkkJ4ga86jQnnr7bcZuTaOT7PxeNwEG5q4NjZFp1nErcHHJx6faOR5QKlcRlMUDh8+jOaPUkzNUcqleenoG/z85+/TGvUg63v4h5/89KnoJ80uJnFMA7fbg2kYZDMpzp/+jJdf+xYXNziXe9axenSrZVlYlnX7tM87kc9laevqY2puEbWaZmj3ToLxVmbnF9EUCa/Xi/WAhekbDfH6sWOOZRjoLjfVShlFVYlEE+zo6+D9Dz95aoo9bdi2jeM4yLJ8z/ewMmIFoGk6ApuqYaLKMgiBZVm43W6CiXYicpHLN6Zuc1vXG/JA/7b3/IEgNcMgHA5RyBcoFHKYlkMul8Pj8SDJCrFoA6ViCUcIIpEI5XKZQCBAtWbgdmk0NjaRy93NqdXV208s5KNQqhKLRRE41GoGwVAEr3uF+FoIiWg0Qs2wCfo9eP1BhGNjPMWnHsCyrNuDMfatdU+StMJeZ1nWbQevtG77rnKO42AYBvn0MoupbN0mOu4H+fXXjr4XjjQwsGsPmqqwZ7CPseklDgwNUHNUfvjdtxDuAJpVZTmVwuX1s/+Fl2lrjPHK0VdpijeQWpyjobUPpZalWLN56eXDmJUCL71ylMmxm5SqJjuHDpAIKEzNLvLGt94kubRAPl/gN3/429imiWlDoiHAkaPHGNw1yKXz53gCHGGPBcdxEGKFhtiwajR9N0Boj4fkpTyKUG6fKP6sraC8HyTN5SGRSNyi8g/iOAJ/Q4J8coGXXzxI1RaMX7tC/54D+N0a5UKOXDZLrVLg44+P0xBvZt/+A0xNz9Le2kz/7mHmRy+yb/gQ6eUFxqdmKBfz+FwSn55aIR6/cXOUgwf2g5CwaiWu3piksbmJWCSE2+PFdgRufeMPzloLdw7em5gE+l24uxTQ7PuWWUUgEHhoGW6PF0Ve/wHx++9l2/P4ArS3Nj+UHPl3fvsH7y0nU5QqNXRVIpNOMTk5Q19fN7/+6NOV3XmGSSTox5ZUNFmmtbWZxflZhOZhdmaKSNCPJWkk5yZZSGY4cPAFFmanqBoWMzMzAMSiUWbnlxgc2IY/FMGslhifmCQcbaR/Ww+lfJZapYQnGKGQy3D92rUnwqX8OBBC3O6SFaGQHimSvVhG5JS7rgkhePX1bzG8b4hrIyO8/sZb1MpFJFnGETJvvHEMs1ICSSXoc6PqHoJ+L8VSiaNHX8MbaODll14kvTiNpXj5je+9TTgcZvjFlwn6PAQ8CqHGLnSrSK5UobmlDdus8eZ33iGTXCCVKfB7v/8jpq5fYt/hN2n0S8wuJunfsYtvv/Ealy9fRvnbv//JfY0cm5wjn8vy4YcfAnDz+ggtrW3Mzc0yPXs36crVK1fo6upianGFjPvHP773Nz/77DNUl5elxQXmL1358vtPPryr3JmLGzvD9LBYbaFCCEjL2MBqOntn9+zRFcbn00R8LmRZpql7gLe6E1wZnSHg0UhncvzuH/xzRK3AXDLPhdOfsrC08lvNiQZ+9sFx9vV0MlPSOP/5h/QOHmR6aoru7h7mNZXPzlzm0FAfJWWZwb5m3IE9VMtFpmcXcGyTKyPXkQRcuHiRwbYVwvWb16+zrbsN23HuHcnatWc/2/u6GRsbAyHo37YNWDkHsKOzk4H+Pnp7e+nu286rrx7B73UBrJRfB0alyPzSxp+u9iSgKMo9adHqXtw7Z8IMW9DbGiddrIAk0RwL8/7Hn7O7v4PZZJG+ng4WFuY5ceIzrl+/wYEDB27fu5DM8tZrL5Mq1KhkFtl36CjFXJKFpTQzMzO0tbUSCYco5nNUywVC0QRGtYxp1CjeIjm//apwHBwHOjs7+fZ3v0+tUkFXJMS//uM/chR3EF22+NUHHxFLNHPkxf38n7/5e2KNzbx++AX+11//P15949tcOf0JqXyZoaEhmlraWEplUSrLfHLqQn1q/SlgNSqGlda8Gj0/CNt3DiGMPFeuja5ZZmBwN6NXL1I1bTr7trM8eYNC9d7MYeeuIa5dvoBhPdxc9uDgIBcvfnnIihJsaKSnt5sLX5wCILW8iC1Wcr+l+VnSueJKQUWmVjM4evToyqoFy2R89AbDQ9uBzevgh3HoV3H10vrHDl25+CVr/vj1q2uWu3Th0Y4wutO5AHJbW+t7s/NLWLUS84tL7D94iKXZSQZ3DTE2NobjOKTTaaanphl+4UXy6WVm5ubJ5It0d7Zx9ovTFOtw0OQWHg9rTvh7PJ7HOsxiC88W1ux/tpy7ObA1H7zJseXgTY4tB29ybDl4k2PLwZscWw7e5Nhy8CbHloM3ObYcvMmhRCIRgNvLUOqBzSqr3vIeRpaSTCaRZRlFUTYlX7Tb7aZSqWxKvmhN024v7V0LEjx7xCFPEs+7bZuejPR5t+25CLKe51b8XLTgOz/rIe9Zsm3T82Stynpebdv0THebmVXvYaC4XK7bx+rUayuGy+WqW0W4XK665qb1tO1h0iSlXC4jSRKmadYtDwbqlis6jkOlUt9FgfWybXXd9gOJ0DZ7kHWnzHrJeZZs2/RB1hYheJ2VqreseuNZs22rBW+QzIdF2DaoComSeHSWwYeiE77TuZvxPfUsxxc7jAI2goBtMqm4mZe1x5K1bhf9QIW+AbvYv4kI2iaqY3NV9fK5HqTXKCJJCkhPli9UaewfXuGLlmWcW/mUhIPbtmi1KsiOTUFWmZFdKI6NjaAiJCwhkBwHGYe7VHIAsfKx+tiI1X+OA0IgKSqWaeAABuKWzBW5DmAhsG89WOKOPa42YAuBg+B+e+0EoDg2yi1FbARC1TBME49j4bEtFBzKQqIoZNRbGlaRMB7wIEu3bFy1V1q1BbCEwL6ljy0Ekqrh+grvtgQIHJQ77o9ZNcYUN5FbZa4AL1Sz+BybZdXDgqRi3KrjVfvvlAUgyzKO46xJXyzhrOxN2jo/+Mmh3ucHr5cHS0JSaG9rIRJN4NY3ngbXEwjj83poikc3XJbb6ycU8NHR1UU9XjTxxhbcbjdtzYkNlyUkmXAoSHNrO+oDuD4khEJjIkokEqe7q23DFdtz4DAvDw/SENv4SqhUKrR1bKOtdzuJQB34qWWVXYPbCUc2/uEVkkQi0UisuZP2pvCa5RRJcpibW6BiSWSX5zZcsc8//gUBnwutDgzdbo+HqYkRtEUfC7mN592ShM2FiyO49Y0nVrdNg/GJCQKhPAuz6TXLbRGCb3I8Fys6nmdsOXiTQwJBT0/P7S/u/PvrwuXx89KLh5AlwcDuPeh3PE6+YASv6/5sdkNDQ09MhycJT63C9+08sn1vWqJoLg6/coTGWOQ+d0Io3kpPZzsdbU2PLFcImUMvvozf4yIQbaarNX77miSrxGMN971v245dyD/4/rvv6R4fLc2NJJqacLlc9PbvYHCgD1vSOHToRWqFJNnCo+d2R18/xo3xWbZ3xPDF2tje0013bw/pZJI33/0eHXE/6AGGD+zD5/PR3tLI7PwSu3btoL2zF6taJJcvPrLcjYBiW/yLkMIPNJNyrcaI0OCO5Kt7YA9hrcrVm1McOfo6TbEwfQO7GY+QyGAAAAYlSURBVOjtRHUHGR4eppxLoikKBw+/RiLiJ97cwaHhvVy7do0Hpen9Qy9QWZ5gz/5hFjNlvvXKC/jCcfwadPUP8erhg6SzBYaHh/H5vAwNDjA1NcmeoSEkx4FoQ4RILEFDOEQ0GsWtyWRLJvsG+zh9YYSG4L18iQ8DWYJyuYKiquBYfPTBh/gDEb73Wz8ks7TA+fPn2Lt3L6VShWqlQlNzM+29A0zfvEKhWKKxceNTqYeBwOH7HsExrwypJX7XyXGglr+rzM1LpxlbLPGdd77Hzm3t2LaDKjmYyHR3tHD85BdIikokHKJayuH2hUhEw2TyZdYjhFdUhUqlDGKlCzz7xecE/T66B4fx6oIbI1fpGxjEqJQwDRPdGyQciWFWCsjb+/vey+TyzMwnWZ4dp1CqkE6nSafTzC8sc+TIEebGr7GYzj9Yi/tgKZlleGiA4ydOUTNs9uzdxYlPfk1HZxc//dkvGNqzl7PnLtAQ9LGYzODSZBLxGCdPn6WppZVcOkkynXlkuU8aL8gW/7KvGbE0D8UiYmGWPUEvpw1BVlmZIIjEGhnY1sOV86fIVSCXXiKZzpBOp5mYnmOwv5sb129QKpXI5vKk0xnKNYuD+4c4+fnJBzLrJhfn2Tf8EmdPnSBfLLFj5y6uXblIvKmNzz78JbGWLkYuXSCeiDM/P4/X66Eh3sils6cQR48eddYay4wlmmlvjnHm7PrUvg+77ine2IJkVZhfuv8Ja42NjczPz6/7O/VCuJjlR9u72OWWiYycw54eB9NketsQp02Zv6oqVDTXQ/3WV4+96+nbjuJUGbmxPg3kV+HxB2mOhrgxNnHf66v1KP/eH/zovfnxUQb3HWTnQD+aZJNMZwEoFfPMzS/cnjTo7e1l9azDOyGEymuvvczYV4QNDb+EW1TZdfAVqpk5du1/kXjYy+WR6/Tv2MWBfXuYmRyna2APYZeDO9JC1CsTCEcY2neQge3bWZyZpGqsPda60ahoLo7nynSVc3TcvAC3xn3/OtrD/7JcmPLKCFlzWyfvvvMdVMlhfmEJWKEVXFxcvPVLgmPHXmdsfJq3334bTXYYuXaNZOrLHqqztx+zlKNm3r/BHXr5FXo6WpmYnKKtvZPd+/aTnp+kuXvn7frrTAQJhCP0bNvBwPbtKOIWVV8sHie9OEtnTz9H33ybfHKBbMVh4volhg6+gl+1GJ2cpa+vj3ShQmMkSEt7G5cunMeluRDcfcKnNxilpakRctPkCmW8bp1wwIOND1lAZ0cHNVuipz1BQ7yBQHsMw9EwqlkU1UU03oisagS8OrlS/RYD3g+O4+AU83BnT/eVzmp2apx0ZoDlos33332bbDZNS1c/6eQyh149xtzNSyu0iJJMwO+lkM/zg9/5XVqiPm6Mz+Lx+aiWi5QSAX71ycn76tHW2oZkrSwgHL0xQn9fNwupPP1Da9ef5DgCl0vDcWxMJPK5HJgVTp85h6bKzC8uo6sKx0+sCB2bXaY34UdoLk5/fgJkjfGxsXu68FgsukLX39CwwozqOOguDx6Xhj8Q5OOPPyIRDTA1u4yqSkzMpliavYks64CgWMhx9sJlWlsejvh6I2HbNsdNhb/sGeYvew7wlz3DXC1W7ztN5wsEmZ2ewOvzk89m8MXakKo5/MEQur5yvsOJz05w+NWjeN06n376GbZR5fjJ8/g9LpaXltbQQmDWKthCIhQMonrCVAsrvemD6k+88ea3HVWyUVQXuVyGcDiCpKhItkGpahH0uciXawQ8OvlimWyuQDi4cg5De2sTY+MTdHR2sbwwR754NzueornQJAdbUnGMCi5vABmTnbuGuHDxMmatRKFYJhgMks2uvBaCwSCwwmquyzAxOfVUzzxYxf3ii6+uIw+FQmQyWdo62lmYncYbiCCsGqGGGMsLcyiaTjqdobOri9TSPIYjEwsHyOTylCs1VEUQi0YZn5i8rw6RaBwFk/6BnRw/cRJdgWKp8sD62xqL3uTYGqrc5FCmZhfXLWRZ5j1BxRaebQhZxh1pQckU149Qa3Xe+rGFrw9J1Ym2NKFI8vqT0yup1Nbqym8ShCQj6x4U6SGWaYrHWJS9hacLISRk1cX/B5aTGQPM1X6OAAAAAElFTkSuQmCC', 1, 0, '2022-06-16 05:49:51', '2022-06-16 05:49:51');
INSERT INTO `tb_staff` (`staff_id`, `user_id`, `staff_nik`, `staff_name`, `staff_phone`, `staff_type`, `staff_title`, `staff_photo`, `staff_tag`, `deleted`, `created`, `modified`) VALUES
(15, 73, '2989327482', 'Ebino Gaban', '0808340385435', 'teacher', 'Guru Si Gaban', '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', 1, 0, '2022-06-16 05:52:02', '2022-06-16 05:52:02'),
(16, 76, '2329124237', 'Abaababa', '3092840928432', 'teacher', 'Guru ngasal', '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', 1, 1, '2022-06-26 17:23:08', '2022-06-26 17:23:20'),
(17, 78, '1209839028', 'Indra Setiawan', '089309238942', 'teacher', 'Guru Imajinasi', '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', 1, 0, '2022-09-06 04:56:55', '2022-09-06 04:56:55'),
(18, 79, '1029829374', 'Ibrahim Al-Awwad Al-Baihaki', '089389423842', 'staff', 'Staff Kurikulum', '', 1, 0, '2022-09-09 08:03:08', '2022-11-29 02:31:52'),
(19, 80, '3094859038', 'Reyhan Pratama ', '0823982945843', 'staff', 'Staff kesiswaan', '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', 1, 0, '2022-11-28 15:00:42', '2022-11-28 15:22:51');
INSERT INTO `tb_staff` (`staff_id`, `user_id`, `staff_nik`, `staff_name`, `staff_phone`, `staff_type`, `staff_title`, `staff_photo`, `staff_tag`, `deleted`, `created`, `modified`) VALUES
(20, 82, '0932493285', 'Dorawati Candra', '0839042839823', 'staff', 'Pustakawan', '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', 1, 1, '2023-04-17 06:58:19', '2023-04-17 06:58:56');

-- --------------------------------------------------------

--
-- Table structure for table `tb_student`
--

CREATE TABLE `tb_student` (
  `student_id` int(11) NOT NULL,
  `student_nis` varchar(20) DEFAULT NULL,
  `student_name` varchar(100) DEFAULT NULL,
  `student_tag` tinyint(1) DEFAULT 1,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_student`
--

INSERT INTO `tb_student` (`student_id`, `student_nis`, `student_name`, `student_tag`, `deleted`, `created`, `modified`) VALUES
(1, '2015420022', 'Adnan Zaki', 2, 0, '2018-10-20 04:19:34', '2020-02-19 14:08:16'),
(2, '2015420003', 'Saka Putra ', 3, 1, '2018-10-20 03:23:30', '2020-02-19 15:34:07'),
(3, '2015420004', 'Bima Sakti', 2, 0, '2018-10-14 03:02:10', '2020-02-19 14:15:04'),
(4, '2015420015', 'Widya Sari Wangi', 3, 1, '2018-10-19 09:32:46', '2020-02-19 15:34:06'),
(5, '2015420049', 'Joko Tole', 1, 1, '2020-02-10 03:58:02', '2020-02-17 05:41:48'),
(6, '2014310039', 'Dani Rusmawan', 1, 0, '2018-10-20 03:11:18', '2020-02-22 14:46:11'),
(7, '2014310012', 'Mukhlisin', 1, 0, '2018-10-20 03:11:23', '2018-10-19 17:00:00'),
(8, '2015310028', 'Rino Ardiansyah', 1, 0, '2018-10-20 04:20:22', '2018-10-19 17:00:00'),
(9, '2015310029', 'Raju Herningtyas Pratama', 1, 0, '2018-10-20 03:11:44', '2018-10-19 17:00:00'),
(10, '2014310088', 'Ridwan Kamil', 1, 0, '2018-10-20 03:11:48', '2018-10-19 17:00:00'),
(11, '2015310098', 'Firhan Yudha Gamalama', 2, 0, '2018-10-20 13:53:06', '2020-02-22 14:46:54'),
(12, '2014220038', 'Try Albahri', 1, 0, '2018-10-20 13:53:06', '2018-10-19 17:00:00'),
(13, '2015190029', 'Wahyudi', 1, 0, '2018-10-20 13:53:06', '2018-10-19 17:00:00'),
(14, '2015310124', 'Kipiir', 1, 0, '2018-11-13 16:53:15', '2020-02-10 16:05:45'),
(17, '2837893745', 'Dennis Septianto', 1, 0, '2020-02-18 07:45:41', '2020-02-18 07:45:41'),
(18, '192009008', 'Johnson Saputra', 1, 0, '2020-02-19 04:57:03', '2020-02-19 04:57:03'),
(19, '2082390840', 'Sari Koala', 3, 1, '2020-02-19 14:13:09', '2020-02-19 15:32:54'),
(20, '2003949343', 'Indra Herlambang', 3, 1, '2020-02-19 14:14:45', '2020-02-19 15:34:07'),
(21, '3098230984', 'Johnson Simatupang', 1, 0, '2020-02-19 14:15:36', '2020-02-19 14:15:36'),
(23, '209230493', 'Jenong Pampang', 3, 1, '2020-02-20 04:21:08', '2020-02-20 04:21:37'),
(24, '1920092093', 'Rian Nurdoni Balakatuktak Simaoooo', 2, 0, '2020-03-10 07:35:22', '2023-08-21 14:28:18'),
(25, '1920392890', 'Edwin Zigot', 3, 1, '2020-03-10 07:35:49', '2020-03-11 15:43:42'),
(26, '1928023009', 'Doni Kusumadewi', 3, 1, '2020-03-10 07:36:07', '2023-04-17 03:04:31'),
(27, '1920209189', 'Brendon Rodgers', 2, 0, '2020-03-11 13:06:36', '2022-11-28 15:51:11'),
(28, '1819098198', 'Badrun Hasiholan Loba loba Konohooooo', 2, 0, '2020-03-11 13:06:52', '2023-08-21 14:38:08'),
(29, '1920292038', 'Soleh Nur Majid', 1, 0, '2020-03-11 13:09:27', '2020-03-11 13:09:27'),
(30, '1920908239', 'Rian Sanjaya', 1, 0, '2020-03-11 15:44:20', '2020-03-11 15:44:20'),
(31, '1920093489', 'Taufik Silobahutang', 1, 0, '2020-03-11 15:44:36', '2020-03-11 15:44:36'),
(32, '1920923890', 'Roni Hidayat', 1, 0, '2020-03-11 15:44:53', '2020-03-11 15:44:53'),
(33, '2392830918', 'Sinta Nurlia', 3, 1, '2020-04-03 13:07:18', '2020-04-03 13:07:32'),
(34, '9028394893', 'Raihan Nur Fajri', 1, 0, '2020-07-09 05:39:22', '2020-07-09 05:39:22'),
(35, '1209890328', 'Lala Sintia', 1, 0, '2020-07-09 05:39:44', '2020-07-09 05:39:44'),
(36, '1290809238', 'Indah Purnamasari', 1, 0, '2020-07-09 05:40:18', '2020-07-09 05:40:18'),
(37, '2122038438', 'Indah Parawangsa', 1, 0, '2022-06-16 06:02:31', '2022-06-16 06:02:31'),
(38, '2309482098', 'Hebring Danuwindo', 1, 0, '2022-08-18 08:34:12', '2022-08-18 08:34:12'),
(39, '9435893453', 'Imas Setyaningsih', 1, 0, '2023-04-16 16:01:36', '2023-04-16 16:01:36');

-- --------------------------------------------------------

--
-- Table structure for table `tb_student_grade`
--

CREATE TABLE `tb_student_grade` (
  `student_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `student_tag` tinyint(1) DEFAULT 1,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_student_grade`
--

INSERT INTO `tb_student_grade` (`student_id`, `grade_id`, `student_tag`, `deleted`, `created`, `modified`) VALUES
(1, 2, 1, 0, '2020-03-11 15:45:20', '2020-03-11 15:45:20'),
(1, 11, 1, 0, '2023-07-06 04:13:31', '2023-07-06 04:13:31'),
(1, 13, 1, 0, '2023-09-07 05:30:44', '2023-09-07 05:30:44'),
(3, 6, 1, 0, '2022-07-14 16:00:39', '2022-07-14 16:00:39'),
(3, 8, 1, 0, '2022-09-27 02:09:08', '2022-09-27 02:09:08'),
(3, 11, 1, 0, '2023-07-06 04:13:32', '2023-07-06 04:13:32'),
(3, 14, 1, 0, '2023-09-07 05:35:37', '2023-09-07 05:35:37'),
(6, 2, 1, 0, '2020-03-11 09:31:05', '2020-03-11 09:31:05'),
(6, 13, 1, 0, '2023-09-07 05:30:44', '2023-09-07 05:30:44'),
(7, 3, 1, 0, '2020-03-11 13:09:58', '2020-03-11 13:09:58'),
(7, 12, 1, 0, '2023-09-07 05:29:13', '2023-09-07 05:29:13'),
(8, 6, 1, 0, '2022-07-14 16:00:35', '2022-07-14 16:00:35'),
(9, 3, 1, 0, '2020-03-11 13:10:18', '2020-03-11 13:10:18'),
(9, 12, 1, 0, '2023-09-07 05:29:13', '2023-09-07 05:29:13'),
(10, 3, 1, 0, '2020-03-12 03:03:47', '2020-03-12 03:03:47'),
(10, 12, 1, 0, '2023-09-07 05:29:13', '2023-09-07 05:29:13'),
(12, 3, 1, 0, '2020-03-11 13:10:16', '2020-03-11 13:10:16'),
(12, 12, 1, 0, '2023-09-07 05:29:13', '2023-09-07 05:29:13'),
(13, 2, 1, 0, '2020-03-12 03:03:41', '2020-03-12 03:03:41'),
(13, 13, 1, 0, '2023-09-07 05:30:44', '2023-09-07 05:30:44'),
(14, 6, 1, 0, '2022-07-14 16:00:36', '2022-07-14 16:00:36'),
(14, 8, 1, 0, '2022-11-24 08:45:27', '2022-11-24 08:45:27'),
(14, 14, 1, 0, '2023-09-07 05:35:37', '2023-09-07 05:35:37'),
(17, 2, 1, 0, '2020-03-11 09:31:02', '2020-03-11 09:31:02'),
(17, 13, 1, 0, '2023-09-07 05:30:44', '2023-09-07 05:30:44'),
(18, 2, 1, 0, '2020-03-11 15:45:23', '2020-03-11 15:45:23'),
(18, 13, 1, 0, '2023-09-07 05:30:44', '2023-09-07 05:30:44'),
(21, 3, 1, 0, '2020-03-11 13:10:00', '2020-03-11 13:10:00'),
(21, 12, 1, 0, '2023-09-07 05:29:13', '2023-09-07 05:29:13'),
(24, 6, 1, 0, '2022-07-14 16:00:34', '2022-07-14 16:00:34'),
(25, 6, 3, 1, '2020-03-11 15:22:16', '2020-04-03 10:51:01'),
(26, 6, 3, 1, '2022-07-14 16:00:38', '2023-04-17 03:04:31'),
(27, 3, 1, 0, '2020-03-11 13:10:20', '2020-03-11 13:10:20'),
(27, 11, 1, 0, '2023-07-06 04:13:34', '2023-07-06 04:13:34'),
(27, 12, 1, 0, '2023-09-07 05:29:13', '2023-09-07 05:29:13'),
(28, 6, 1, 0, '2022-07-14 16:00:40', '2022-07-14 16:00:40'),
(28, 8, 1, 0, '2022-09-26 14:53:45', '2022-09-26 14:53:45'),
(28, 11, 1, 0, '2023-07-06 04:13:33', '2023-07-06 04:13:33'),
(28, 14, 1, 0, '2023-09-07 05:35:37', '2023-09-07 05:35:37'),
(29, 3, 1, 0, '2020-03-11 13:10:17', '2020-03-11 13:10:17'),
(29, 12, 1, 0, '2023-09-07 05:29:13', '2023-09-07 05:29:13'),
(30, 3, 1, 0, '2020-03-12 03:03:49', '2020-03-12 03:03:49'),
(30, 12, 1, 0, '2023-09-07 05:29:13', '2023-09-07 05:29:13'),
(31, 2, 1, 0, '2020-03-12 03:03:42', '2020-03-12 03:03:42'),
(31, 13, 1, 0, '2023-09-07 05:30:44', '2023-09-07 05:30:44'),
(32, 2, 1, 0, '2020-03-11 15:45:25', '2020-03-11 15:45:25'),
(32, 13, 1, 0, '2023-09-07 05:30:44', '2023-09-07 05:30:44'),
(34, 3, 1, 0, '2020-07-09 05:40:59', '2020-07-09 05:40:59'),
(34, 12, 1, 0, '2023-09-07 05:29:13', '2023-09-07 05:29:13'),
(35, 6, 1, 0, '2022-07-14 16:00:34', '2022-07-14 16:00:34'),
(35, 8, 1, 0, '2022-11-24 08:45:28', '2022-11-24 08:45:28'),
(35, 14, 1, 0, '2023-09-07 05:35:37', '2023-09-07 05:35:37'),
(36, 2, 1, 0, '2020-07-09 05:40:51', '2020-07-09 05:40:51'),
(36, 13, 1, 0, '2023-09-07 05:30:44', '2023-09-07 05:30:44'),
(37, 6, 1, 0, '2022-07-14 16:00:36', '2022-07-14 16:00:36'),
(37, 8, 1, 0, '2022-11-24 08:45:26', '2022-11-24 08:45:26'),
(37, 14, 1, 0, '2023-09-07 05:35:37', '2023-09-07 05:35:37'),
(38, 8, 1, 0, '2022-09-27 02:06:29', '2022-09-27 02:06:29'),
(38, 14, 1, 0, '2023-09-07 05:35:37', '2023-09-07 05:35:37');

-- --------------------------------------------------------

--
-- Table structure for table `tb_student_parent`
--

CREATE TABLE `tb_student_parent` (
  `parent_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_student_parent`
--

INSERT INTO `tb_student_parent` (`parent_id`, `student_id`, `deleted`, `created`, `modified`) VALUES
(10, 1, 0, '2020-02-19 03:28:53', '2020-02-19 14:09:16'),
(11, 2, 1, '2020-02-19 03:28:53', '2020-02-19 15:34:07'),
(12, 3, 0, '2020-02-19 03:30:53', '2020-02-19 03:30:53'),
(13, 17, 0, '2020-02-18 07:45:41', '2020-02-18 07:45:41'),
(14, 6, 0, '2020-02-19 03:35:20', '2020-02-19 03:35:20'),
(15, 7, 0, '2020-02-19 03:35:21', '2020-02-19 03:35:21'),
(16, 8, 0, '2020-02-19 03:35:21', '2020-02-19 03:35:21'),
(17, 9, 0, '2020-02-19 03:35:21', '2020-02-19 03:35:21'),
(18, 10, 0, '2020-02-19 03:35:21', '2020-02-19 03:35:21'),
(19, 11, 0, '2020-02-19 03:35:21', '2020-02-19 03:35:21'),
(20, 12, 0, '2020-02-19 03:35:21', '2020-02-19 03:35:21'),
(21, 13, 0, '2020-02-19 03:35:21', '2020-02-19 03:35:21'),
(22, 14, 0, '2020-02-19 03:35:21', '2020-02-19 03:35:21'),
(13, 4, 1, '2020-02-19 03:35:20', '2020-02-19 15:34:07'),
(21, 18, 0, '2020-02-19 04:57:03', '2020-02-19 04:57:03'),
(15, 19, 1, '2020-02-19 14:13:09', '2020-02-19 15:32:55'),
(23, 20, 1, '2020-02-19 14:14:46', '2020-02-19 15:34:08'),
(17, 21, 0, '2020-02-19 14:15:36', '2020-02-19 14:15:36'),
(18, 23, 1, '2020-02-20 04:21:08', '2020-02-20 04:21:38'),
(29, 24, 0, '2020-03-10 07:35:22', '2020-03-10 07:35:22'),
(28, 25, 1, '2020-03-10 07:35:49', '2020-03-11 15:43:42'),
(28, 26, 1, '2020-03-10 07:36:07', '2023-04-17 03:04:31'),
(17, 27, 0, '2020-03-11 13:06:36', '2020-03-11 13:06:36'),
(21, 28, 0, '2020-03-11 13:06:53', '2020-03-11 13:06:53'),
(30, 29, 0, '2020-03-11 13:09:27', '2020-03-11 13:09:27'),
(26, 30, 0, '2020-03-11 15:44:20', '2020-03-11 15:44:20'),
(15, 31, 0, '2020-03-11 15:44:36', '2020-03-11 15:44:36'),
(30, 32, 0, '2020-03-11 15:44:53', '2020-03-11 15:44:53'),
(31, 33, 1, '2020-04-03 13:07:19', '2020-04-03 13:07:32'),
(32, 34, 0, '2020-07-09 05:39:22', '2020-07-09 05:39:22'),
(32, 35, 0, '2020-07-09 05:39:44', '2020-07-09 05:39:44'),
(33, 36, 0, '2020-07-09 05:40:18', '2020-07-09 05:40:18'),
(48, 37, 0, '2022-06-16 06:02:31', '2022-06-16 06:02:31'),
(15, 38, 0, '2022-08-18 08:34:12', '2022-08-18 08:34:12'),
(23, 39, 0, '2023-04-16 16:01:36', '2023-04-16 16:01:36');

-- --------------------------------------------------------

--
-- Table structure for table `tb_timeline`
--

CREATE TABLE `tb_timeline` (
  `timeline_id` int(11) NOT NULL,
  `timeline_title` varchar(100) DEFAULT NULL,
  `timeline_content` text DEFAULT NULL,
  `timeline_date` datetime DEFAULT NULL,
  `timeline_status` enum('public','draft') DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_timeline`
--

INSERT INTO `tb_timeline` (`timeline_id`, `timeline_title`, `timeline_content`, `timeline_date`, `timeline_status`, `featured_image`, `user_id`, `deleted`, `created`, `modified`) VALUES
(1, 'Post pertama', 'Postingan ini dibuat oleh admin. <h1>Heading 1</h1>\n<blockquote>\n    Pengalaman yang luar biasa adalah...\n</blockquote>\n\n<script>\n  alert(\'hello!\')\n</script>', NULL, 'public', NULL, 1, 1, '2023-08-29 03:23:25', '2023-09-05 09:07:57'),
(2, 'Post kedua', 'Postingan ini dibuat oleh guru di sekolah', NULL, 'public', NULL, 4, 1, '2023-08-29 03:25:25', '2023-09-05 09:07:57'),
(3, 'Post ketiga', 'Ini adalah postingan ketiga yang masih menjadi draft dan dibuat oleh admin', NULL, 'draft', NULL, 1, 1, '2023-08-29 03:27:25', '2023-09-05 09:07:57'),
(4, 'Post keempat', 'Ceritakan sesuatu tentang <b>sekolah anda</b>...', NULL, 'public', '2023-08-31_1693473807_b48d865a9f6618f8f558.png', 1, 1, '2023-08-31 09:24:42', '2023-09-05 09:07:57'),
(5, 'Post kelima', '', NULL, 'public', '2023-08-31_1693474332_3b97e9a64e5705e95064.png', 1, 1, '2023-08-31 09:32:36', '2023-09-05 09:07:57'),
(6, 'Post keenam', '', NULL, 'draft', NULL, 1, 1, '2023-08-31 09:36:00', '2023-09-05 03:21:55'),
(7, 'Post ketujuh', 'Ceritakan sesuatu tentang <b>sekolah anda</b>...', NULL, 'draft', NULL, 1, 1, '2023-08-31 09:39:16', '2023-09-05 03:21:55'),
(8, 'Post ke delapan', 'Ceritakan sesuatu tentang <b>sekolah anda</b>...', NULL, 'public', '', 1, 1, '2023-08-31 09:41:09', '2023-09-05 03:21:55'),
(9, 'Kegiatan Ekskul Pramuka', 'Kegiatan ekskul pramuka hari ini<br>', NULL, 'public', '2023-09-04_1693802590_fdbd303170ac4db00bf5.png', 1, 0, '2023-09-04 04:06:16', '2023-09-04 04:46:51'),
(10, 'Sertijab Kepala SDN Pengasinan VII', '<div>Hari ini telah dilaksanakan Serah Terima Jabatan (Sertijab) antara Kepala SDN Pengasinan VII yang lama dengan yang baru.</div><div><h6>Awal Mula</h6><div>Tidak seperti yang kau kira <b>Nodi. </b>Ini hanyalah teks biasa. Tidak seperti yang kau kira <b>Nodi. </b>Ini hanyalah teks biasa. Tidak seperti yang kau kira <b>Nodi. </b>Ini hanyalah teks biasa. Tidak seperti yang kau kira <b>Nodi. </b>Ini hanyalah teks biasa. Tidak seperti yang kau kira <b>Nodi. </b>Ini hanyalah teks biasa. Tidak seperti yang kau kira <b>Nodi. </b>Ini hanyalah teks biasa. Tidak seperti yang kau kira <b>Nodi. </b>Ini hanyalah teks biasa. Tidak seperti yang kau kira <b>Nodi. </b>Ini hanyalah teks biasa. Tidak seperti yang kau kira <b>Nodi. </b>Ini hanyalah teks biasa. Tidak seperti yang kau kira <b>Nodi. </b>Ini hanyalah teks biasa. Tidak seperti yang kau kira <b>Nodi. </b>Ini hanyalah teks biasa. Tidak seperti yang kau kira <b>Nodi. </b>Ini hanyalah teks biasa. Tidak seperti yang kau kira <b>Nodi. </b>Ini hanyalah teks biasa. Tidak seperti yang kau kira <b>Nodi. </b>Ini hanyalah teks biasa. </div></div><br>\r\n<script>\r\nalert(\'hello!\')\r\n</script>', NULL, 'public', '2023-09-04_1693842378_8e0daf1a11ca5963401b.jpg', 1, 0, '2023-09-04 04:34:56', '2023-09-05 04:39:48'),
(11, 'Post kesepuluh', 'Ceritakan sesuatu tentang <b>sekolah anda</b>... begitu yaaaaaa okeee<br>', NULL, 'public', '2023-09-04_1693813515_d2e915e1c69f64b88cad.png', 1, 1, '2023-09-04 04:59:29', '2023-09-05 03:12:53'),
(12, 'Post kesebelas', 'Ceritakan sesuatu tentang <b>sekolah anda</b>...', NULL, 'public', '2023-09-05_1693883679_45c0b4f0162339b476dc.png', 1, 1, '2023-09-04 15:21:56', '2023-09-05 03:14:56'),
(13, 'Post keduabelas', 'Ceritakan sesuatu tentang <b>sekolah anda</b>...', NULL, 'public', '2023-09-05_1693885596_bedc66dd4e8d4cc7154f.png', 1, 0, '2023-09-04 15:28:58', '2023-09-05 03:46:38'),
(14, 'Post ketigabelas', 'Ceritakan sesuatu tentang <b>sekolah anda</b>...', NULL, 'public', '2023-09-04_1693843408_dc214371d9caf620556d.png', 1, 1, '2023-09-04 16:03:41', '2023-09-05 03:13:54'),
(15, 'Upacara HUT RI', 'Pada hari Kamis, 17 Agustus 2023 telah dilaksanakan Upacara peringatan HUT RI ke-78<br>', NULL, 'public', '2023-09-07_1694053108_73d186abcbc39faafd34.png', 1, 0, '2023-09-07 02:18:32', '2023-09-07 02:18:32');

-- --------------------------------------------------------

--
-- Table structure for table `tb_timeline_images`
--

CREATE TABLE `tb_timeline_images` (
  `id` int(11) NOT NULL,
  `timeline_id` int(11) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_timeline_images`
--

INSERT INTO `tb_timeline_images` (`id`, `timeline_id`, `filename`, `created`, `modified`) VALUES
(5, 9, '2023-09-04_gallery_1693800318_2583a9ec805d796db58d.jpg', '2023-09-04 04:06:16', '2023-09-04 04:06:16'),
(6, 9, '2023-09-04_gallery_1693800350_6e5d6808c709c38ea8d9.jpg', '2023-09-04 04:06:16', '2023-09-04 04:06:16'),
(11, 10, '2023-09-04_gallery_1693800940_266d830746c9ab1e201a.png', '2023-09-04 04:34:56', '2023-09-04 04:34:56'),
(12, 10, '2023-09-04_gallery_1693800940_19e137c761cb4595d713.png', '2023-09-04 04:34:56', '2023-09-04 04:34:56'),
(13, 10, '2023-09-04_gallery_1693800940_f819a0fd25cf7a6cf312.png', '2023-09-04 04:34:56', '2023-09-04 04:34:56'),
(90, 9, '2023-09-05_gallery_1693924802_e0a6f7ae901d3d1c741f.png', '2023-09-05 14:40:14', '2023-09-05 14:40:14'),
(91, 9, '2023-09-05_gallery_1693924802_ddb6a57334fb3c32f93b.png', '2023-09-05 14:40:14', '2023-09-05 14:40:14'),
(92, 9, '2023-09-05_gallery_1693924802_08e1a61c9eb94a51f493.png', '2023-09-05 14:40:14', '2023-09-05 14:40:14'),
(93, 9, '2023-09-05_gallery_1693924802_4a46d5345299de15dcf7.png', '2023-09-05 14:40:14', '2023-09-05 14:40:14'),
(94, 9, '2023-09-05_gallery_1693924802_5011f6ad2977b73b5807.png', '2023-09-05 14:40:14', '2023-09-05 14:40:14'),
(95, 9, '2023-09-05_gallery_1693924802_911bc393bc35a1c70e5c.png', '2023-09-05 14:40:14', '2023-09-05 14:40:14'),
(96, 9, '2023-09-05_gallery_1693924811_499cc0c2077ecc88ab96.png', '2023-09-05 14:40:14', '2023-09-05 14:40:14'),
(97, 9, '2023-09-05_gallery_1693924862_29cebcba34d51072d80c.png', '2023-09-05 14:41:04', '2023-09-05 14:41:04'),
(98, 15, '2023-09-29_gallery_1695954449_2a2c57563f55653beaf9.png', '2023-09-29 02:27:47', '2023-09-29 02:27:47'),
(99, 15, '2023-09-29_gallery_1695954462_7340a253f5fe6524c034.png', '2023-09-29 02:27:47', '2023-09-29 02:27:47');

-- --------------------------------------------------------

--
-- Table structure for table `tb_timelog`
--

CREATE TABLE `tb_timelog` (
  `log_id` int(11) NOT NULL,
  `student_nis` varchar(20) DEFAULT NULL,
  `verifymode` tinyint(4) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `iomode` tinyint(4) DEFAULT NULL,
  `created` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_timelog`
--

INSERT INTO `tb_timelog` (`log_id`, `student_nis`, `verifymode`, `timestamp`, `iomode`, `created`) VALUES
(1, '2015420022', 1, '2020-04-23 14:34:06', 1, '2020-04-23 16:42:09'),
(2, '1920209189', 1, '2020-04-20 14:34:06', 1, '2020-04-23 16:42:09');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_level` tinyint(4) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `network` varchar(10) NOT NULL DEFAULT 'offline',
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `user_name`, `user_email`, `user_password`, `user_level`, `deleted`, `network`, `created`, `modified`) VALUES
(1, 'Adnan Zaki', 'admin@localhost', '$2y$10$/pGoRZE82.7qfG.gjIHure.dNYJacwdlmWztWgT4AtpwsLRTfFlHu', 1, 0, 'online', '2018-10-10 17:00:00', '2023-10-31 03:45:27'),
(2, 'Mukhlisin', 'mukliz@wolestech.com', '$2y$10$8n/ojdr/Cb6DjfBIjVKkvekVHXfjXAATlWlnsMZAvV9ioz7Zv/La2', 0, 1, 'offline', '2018-10-30 17:00:00', '2022-11-29 02:32:17'),
(3, 'Dany Prastio', 'danyprastio@wolestech.com', '$2y$10$UpUUj08e6BuSfzOWqUJvQ.Y6ue8CCO/98RKshSx3hJL7OF5tkrpUe', 0, 1, 'offline', '2018-10-30 17:00:00', '2022-11-29 02:31:19'),
(4, 'Firhan Yudha Prakoso', 'firhanyp@localhost', '$2y$10$YzLzivugHcnB7KByu/vv.O5LAWL4bC/VTLDeBpKOX5zSmmt6rrvhu', 2, 0, 'online', '2019-03-17 17:00:00', '2023-08-17 14:55:12'),
(12, 'Uus Rusmawan Prasetyo', 'uusrusmawan@smkn11kotabekasi.actudent.com', '$2y$10$sHHFUTN8js.27Nz3exYru..1Sq6kyNOcGGy/1AGR5SYECvBiAc0Aq', 2, 0, 'online', '2019-03-27 17:00:00', '2022-06-20 16:32:03'),
(13, 'Sudrajat', 'sudrajat@demo.actudent.com', '$2y$10$uRTcEtv.NxzipbhTI5mXPOrC7mWw4j7MSOJ5up8gztVR/YqZ.cg5a', 2, 0, 'online', '2019-03-28 17:00:00', '2020-07-10 06:17:32'),
(14, 'Bambang Tri', 'bambang@smkn11kotabekasi.actudent.com', '$2y$10$3qsfIV6tYUkZvCgs6uTu6.X4lnZnLP2.ZVDixeL/Obk0cuRlt0o1S', 0, 1, 'offline', '2020-02-08 05:04:31', '2020-06-17 07:20:50'),
(15, 'Sinto', 'sinto@smkn11kotabekasi.actudent.com', '$2y$10$ZUfIX77V.H8HZYsENgFoH.QhdH8jBpDrzKb3UXCb/yQISzuxTfnvy', 0, 1, 'offline', '2020-02-08 05:06:12', '2020-06-17 07:20:50'),
(16, 'Rizky Nur Hidayat', 'rizkynur@smkn11kotabekasi.actudent.com', '$2y$10$FQnHnmSSTgW6mUYb8B/Lxer3ltbmcBuijIrY4qQr4szfM063heMyC', 0, 1, 'offline', '2020-02-10 02:54:50', '2020-06-17 07:20:50'),
(17, 'Bernard Siahaan', 'bernard@smkn11kotabekasi.actudent.com', '$2y$10$4aBQchBOsJmjj5FSi4q3vOtp1oC4gaoz9FrobyyjgeIagp3SKY9Hy', 0, 1, 'offline', '2020-02-10 03:01:31', '2020-06-17 07:20:50'),
(23, 'Susanto Nurjaman', 'susantonur@smkn11kotabekasi.actudent.com', '$2y$10$OPDJcB9JSaS8m9KnqJbFHOMkC//xz6o69WOTzAIHqyOtZ63/6KE1u', 0, 1, 'offline', '2020-02-10 07:33:09', '2022-11-29 02:32:31'),
(24, 'Ahmad Ridho', 'ahmad.ridho@smkn11kotabekasi.actudent.com', '$2y$10$tiSdWeWFn9.l6KR.JQzkw.G6AEXJtQjwMz7otMwc8zUFwQt49EK/e', 0, 1, 'offline', '2020-02-10 07:34:15', '2022-11-28 15:30:40'),
(25, 'Fahruliansyah', 'fahruliansyah@smkn11kotabekasi.actudent.com', '$2y$10$sHnfCCQmtA1CCsGH5V/v7u5bjbDMhYJcGQ2rhGKeL2Y0mX8YmkkHO', 0, 1, 'offline', '2020-02-10 07:35:17', '2022-11-29 02:31:32'),
(26, 'Andreas Prasetyo', 'andreas.prasetya@smkn11kotabekasi.actudent.com', '$2y$10$f2Vf06NLCbTYGLO2opRWlOcxTsnlRPVpY0dQxeMUwmfYv1ooiiNk2', 0, 1, 'offline', '2020-02-10 07:35:53', '2022-11-29 02:30:46'),
(27, 'Emet Nur Cholis', 'emet.cholis@smkn11kotabekasi.actudent.com', '$2y$10$xeeenDsJ1.U3UaGAXarBWOf2GhtbdXnApe9G9aPfqvfHUlYW1p4Me', 0, 1, 'offline', '2020-02-10 07:38:11', '2022-11-29 02:31:29'),
(28, 'Gledek Nurmantyo', 'gledek.nur@smkn11kotabekasi.actudent.com', '$2y$10$VuBTeKY26z1.ZD7bigwanuBwZawaabZ4nO3/MiOPpWoEQTvbLC0Gi', 0, 1, 'offline', '2020-02-10 08:10:10', '2022-11-29 02:31:35'),
(29, 'asdgvfevbds', 'asdgvfevbds@smkn11kotabekasi.actudent.com', '$2y$10$m6dhzqnTeTeHSapp7ncDweLxGsmCk4cpCVjtMS22XGJx72KMXpG9W', 0, 1, 'offline', '2020-02-10 08:15:03', '2022-11-29 02:30:59'),
(30, 'Badut Siahaan', 'badut.siahaan@demo.actudent.com', '$2y$10$uRTcEtv.NxzipbhTI5mXPOrC7mWw4j7MSOJ5up8gztVR/YqZ.cg5a', 3, 0, 'offline', '2020-02-10 08:16:45', '2020-06-30 08:58:58'),
(31, 'Katmo', 'yuhu@smkn11kotabekasi.actudent.com', '$2y$10$QCZkcT17AjFTDqsMEk5B.OyPaplWSv5JmiN/LfOvH7Doi9hFBjdyu', 0, 1, 'offline', '2020-02-10 08:16:56', '2022-11-29 02:32:05'),
(32, 'Abdi Negara', 'abdinegara@smkn11kotabekasi.actudent.com', '$2y$10$ep.TCSdv6GKxg1gcTVoecuHpY4/mKRRhiKgKUm.XllM/SAhoerY9i', 3, 0, 'online', '2020-02-10 08:17:14', '2023-08-08 03:02:23'),
(33, 'Yono', 'ahay@smkn11kotabekasi.actudent.com', '$2y$10$fiKYu1o07/j5vAGRdjsbWugXl5msV3KBmh2.3YjP8xGxeDQmsgR4u', 0, 1, 'offline', '2020-02-10 08:17:33', '2022-11-29 02:32:35'),
(34, 'Amran Kartakarun', 'lelejepang@smkn11kotabekasi.actudent.com', '$2y$10$519EUkbcNvfhUDCnMWmU0.gGVBIxTlpvABpYfAbyVjsoaxLUq21GC', 0, 1, 'offline', '2020-02-10 08:17:53', '2022-11-28 14:58:23'),
(35, 'Jajang', 'bedul@smkn11kotabekasi.actudent.com', '$2y$10$VgvRgehTFqw.zT18.WhFneNCRTH6UAh8qosqAMqQQC9qEGBOZUmne', 0, 1, 'offline', '2020-02-10 08:18:10', '2022-11-29 02:32:03'),
(36, 'Sandrayono', 'didikempot@smkn11kotabekasi.actudent.com', '$2y$10$aJ2zsiCmT9vEkp2XeyK1WuVVG4ielaNRMK2C9BTCB/m3UMjl/zxSe', 0, 1, 'offline', '2020-02-10 08:19:23', '2022-11-29 02:32:28'),
(37, 'Anto', 'cekot@smkn11kotabekasi.actudent.com', '$2y$10$Gx4MOrOMnQUf5vUm3SjhXe8RDILcDHjctiEZ6zZxUb6y9GqCPjsZK', 0, 1, 'offline', '2020-02-10 08:19:31', '2022-11-28 15:51:57'),
(38, 'dgjhrsjthj', 'ihi@smkn11kotabekasi.actudent.com', '$2y$10$xSKCnhM0Puv6Ws4.9/lQxuykJf0NLUCRosZHnSNzDBB4ihZ5mvsMa', 0, 1, 'offline', '2020-02-10 08:20:15', '2022-11-29 02:31:24'),
(39, 'Mugiono Apriyani', 'mugiono.apriyani@smkn11kotabekasi.actudent.com', '$2y$10$FSiwxDs87YTx2k44TpACr.DVlvtjQyyAgNApefDpWuer4CC5Dz0Hu', 0, 1, 'offline', '2020-02-10 08:31:25', '2022-11-29 02:32:12'),
(40, 'Linda Sukmawati', 'linda.sukma@smkn11kotabekasi.actudent.com', '$2y$10$RzAC35rNJShVZjB8EYZYoe9UVwu/oGOgZF4XaSu1XgynBlOhpGiZW', 0, 1, 'offline', '2020-02-20 04:25:09', '2020-06-17 07:20:50'),
(41, 'Berry Sihalahua', 'berry.sihala@smkn11kotabekasi.actudent.com', '$2y$10$3p8fGp7UrvUBQgb8eIN9E.rb9DuS0Rco2AFzRdyc1acXFS/b9LRq.', 0, 1, 'offline', '2020-03-10 07:32:22', '2022-11-29 02:31:04'),
(42, 'Abdul Jabbar', 'abduljabbar@smkn11kotabekasi.actudent.com', '$2y$10$GxMQ9W8Oh/urNJteKMQB8uA/lpoSAouTZE4p7xF/F4BFej7BWytl2', 0, 1, 'offline', '2020-03-10 07:34:54', '2022-11-28 08:50:23'),
(43, 'Riko Tantorini', 'rikotanto@smkn11kotabekasi.actudent.com', '$2y$10$MQ8K72/H/xm0l1LCHDXYRuQerQYknJMynU6Dr37Pkl/IuywjVyktS', 0, 1, 'offline', '2020-03-11 13:09:01', '2022-11-29 02:32:25'),
(44, 'Rian Mangkulangit', 'rianmangkulangit@smkn11kotabekasi.actudent.com', '$2y$10$KfyKWSudFaaSQVxByz3jzubP0VQC54lu/njLp3ezC/DXg9oqbUYhG', 0, 1, 'offline', '2020-03-13 00:11:26', '2022-11-29 02:32:23'),
(45, 'Reinhard Oktora', 'reinhard.oktora@smkn11kotabekasi.actudent.com', '$2y$10$Vvnfh0n5jC29K2U3k90h0unCWwc7Sm8jIxo1NKycYe016EctK3cSe', 0, 1, 'offline', '2020-03-13 00:12:31', '2022-11-29 02:32:20'),
(46, 'Baharudin Saifulloh', 'baharsaiful@smkn11kotabekasi.actudent.com', '$2y$10$fmGet4t.IjLkL3.8KgJvpuaMPfwqFKGE.ZEw6A2XCnX2gaN3aqgMi', 0, 1, 'offline', '2020-04-03 13:06:55', '2020-06-17 07:20:50'),
(47, 'Indah Dwi Hartati', 'indahhartati@smkn11kotabekasi.actudent.com', '$2y$10$KKPF1a.COnWa4.6HLI4GWutggcWTNFImmFX.ufjXv3UWtnCKl.GHS', 0, 1, 'offline', '2020-04-06 01:39:35', '2022-11-29 02:32:01'),
(48, 'Lintang Sudarmanto', 'lintangsudarmanto@smkn11kotabekasi.actudent.com', '$2y$10$K7LrXPpLuRs/a8cJjr0muOAz4fht.aeuvJspz2g1v9gCVIsAsq11u', 0, 1, 'offline', '2020-04-06 01:40:30', '2022-11-29 02:32:08'),
(49, 'Abdal Salem', 'abdalsalem@smkn11kotabekasi.actudent.com', '$2y$10$ZdISGSPBBg7k2LjZnLFsJOjhrYiQvM3QdWftzQNj/h.HyALFrJHD.', 2, 0, 'offline', '2020-04-06 01:43:50', '2022-11-29 06:09:12'),
(50, 'Edwin Susanto', 'edwin.susanto@smkn11kotabekasi.actudent.com', '$2y$10$U7FyAdvPZnarAk0molJo2uAZmIlv63vzjdrbZy9Skv8se.bAOfQ2e', 0, 1, 'offline', '2020-04-17 10:12:26', '2022-11-29 02:31:27'),
(51, 'Indri Sintiasari', 'indrisintia@smkn999kotabekasi.actudent.com', '$2y$10$rAUBYcBeGxkhSW2D3lfF.OiNQv2fUbd.tSCygzAYmaFb4albHylAi', 3, 0, 'offline', '2020-07-09 05:36:01', '2020-07-09 05:36:01'),
(52, 'Kartono', 'kartono99@smkn999kotabekasi.actudent.com', '$2y$10$xJ7jc.uJFjrkBagIWzhE5OeUsH5ScATBmt.r5JQ6E9rb4lu5qjHae', 3, 0, 'offline', '2020-07-09 05:37:39', '2020-07-09 05:37:39'),
(53, 'Muhammad Rizal', 'mrizal@localhost', '$2y$10$VV1nFPRnYpvAUkgvI9PcGOj/aGvqcxAFyyX3UvdVCoJC4lotKnoDW', 2, 0, 'online', '2020-07-10 05:47:57', '2022-05-24 16:02:27'),
(54, 'Administrator', 'admin@demo.actudent.com', '$2y$10$gKk1sx1Jx/cXx2L8BolU4emqDn2Kg/zSr9hqOb7Syo5NpisY.QnwC', 1, 0, 'online', '2021-02-03 02:45:55', '2021-03-15 06:40:13'),
(55, 'Abdul Majid', 'abdulmajid97@demo.actudent.com', '$2y$10$HzH7jhmpnhT4/GFjT76ZieUO2VF3joByaXh1bdUMIR04it2wDgaPe', 3, 0, 'offline', '2021-05-17 04:29:42', '2021-05-17 04:29:42'),
(56, 'jsndfjsn', 'kjnjfnfj@demo.actudent.com', '$2y$10$I1YR8I.lA1DqE33igLMKZOOmRaETKcvNE9MWVSupo9n2Js4aKX0OG', 3, 1, 'offline', '2021-05-17 08:06:27', '2023-04-20 03:11:43'),
(57, 'Ibnu Kamil', 'ibnukamil87@demo.actudent.com', '$2y$10$ZWMk7ceGzAWmmSvP6usSjuUOpqdrHSZEhV0s.xHryn25ZWmXV1/p6', 3, 0, 'offline', '2021-05-17 08:28:06', '2021-05-17 08:28:06'),
(58, 'Ahmad Hasan ', 'rinapuspita@demo.actudent.com', '$2y$10$M7nn0bSfzdNeWGX8CQU7HOaBCej3f8TZbqg80P1PzqAe/AVP0x2dq', 3, 0, 'offline', '2021-05-17 08:30:35', '2021-05-17 08:30:35'),
(59, 'Ahmad Fajrul', 'rinarosinta@demo.actudent.com', '$2y$10$rlLUPusxbvy2apBACoZESeopwNw4VAPSJ4SUk78mUOs.r2Up2h5i6', 3, 0, 'offline', '2021-05-17 08:31:31', '2021-05-17 08:31:31'),
(60, 'Rima Nurmala', 'rimanurmala@demo.actudent.com', '$2y$10$wVX5tG1g.54Az.Crlhafpe.WGqn8LriawV8ZuAmMEJ77H4vCWsKQa', 3, 1, 'offline', '2021-05-17 10:28:06', '2023-04-20 03:24:13'),
(61, 'Adi Sumarno', 'adi_sumarno@demo.actudent.com', '$2y$10$VLnn68bLggBLVPnZN0T69O/iHH0Tj6NuMA9L80MyFiH8jhmLaTt3y', 3, 0, 'offline', '2021-05-17 10:44:07', '2021-05-17 10:44:07'),
(62, 'Hamdan Syakirin', 'hamdans@demo.actudent.com', '$2y$10$hn1XSqIpxicTxlOznrNIv.UQ9ODXxwh09otNbLZKGBPM/l/rGILF2', 3, 0, 'offline', '2021-05-17 10:48:17', '2021-05-17 10:48:17'),
(63, 'Hamdan Naimin', 'hamdanna@demo.actudent.com', '$2y$10$dweEpb382S4Y6V.uVi5XYOcvEUYDnlpheqPpNmcU1DTWgmwD6FF9m', 3, 0, 'offline', '2021-05-17 10:57:22', '2021-05-17 10:57:22'),
(64, 'Syarif Romadhon', 'syarif_r192@demo.actudent.com', '$2y$10$8kS86VVcEX8dp9qYJolqNuO18GWOD7dFsgLoVHYqAe4L2A99//Zmu', 3, 0, 'offline', '2021-05-17 12:56:31', '2021-05-17 12:56:31'),
(65, 'Izzatul Islam', 'izzatul_islam@demo.actudent.com', '$2y$10$OXaD.DmIdONG/9LvqCaaP.yHDvZbSuHF6I7zMLcDJPyhMBP9O5biO', 3, 0, 'offline', '2021-05-17 13:04:32', '2021-05-17 13:04:32'),
(66, 'Abdul Fattah', 'abdulfattah@demo.actudent.com', '$2y$10$a8UdokSBwOoIGUdrkTHhkODvY9p3Qw208zyDE3fcW1Tue/6uFH.5q', 3, 0, 'offline', '2021-05-17 13:05:20', '2021-05-17 13:05:20'),
(67, 'Himdin', 'himdin982@demo.actudent.com', '$2y$10$dCgnt6HfDhFtB.xor0sBqOfPPjlk7C/JArrPyAIeqI5.S/aETK0Ly', 3, 0, 'offline', '2021-05-17 13:09:31', '2021-05-17 13:09:31'),
(68, 'Huntu', 'huntu92@demo.actudent.com', '$2y$10$9ldHEXaRC.nBLCaeUnUF0.eNDSrLfBtpicebe2sPQly/.Wc0YxFi.', 3, 0, 'offline', '2021-05-18 05:25:52', '2021-05-18 05:25:52'),
(69, 'Ryan Dahl', 'ryandahl@demo.actudent.com', '$2y$10$86LpWxDE.13BHsHydQWniObNQvt0U5qdUMYkbfS.HHJogw5rXMyX2', 2, 0, 'offline', '2022-06-16 05:44:57', '2022-06-16 05:44:57'),
(70, 'Ryan Dahl', 'ryan dahl@demo.actudent.com', '$2y$10$XFLlm6ifXRPXXhNQoTkCz.7q04tVPbuoQxu8yo6QCBUB47sbu4vK6', 2, 1, 'offline', '2022-06-16 05:46:16', '2022-06-16 05:46:32'),
(71, 'Linus Torvalds', 'linustor@demo.actudent.com', '$2y$10$yoeC7KCelDFvW21iDhRfx.LV.13CgKHa.r1PflDWUhvAZVJI51BeO', 2, 0, 'offline', '2022-06-16 05:47:26', '2022-06-16 05:47:26'),
(72, 'Abraham Lincoln', 'abrahamlincoln@demo.actudent.com', '$2y$10$h.n7/I3GvVAUV83RItJBt.86eEOKYaZy.qcoH4i0lPWbyPikZ1Jum', 2, 0, 'offline', '2022-06-16 05:49:51', '2022-06-16 05:49:51'),
(73, 'Ebino Gaban', 'ebinogaban@demo.actudent.com', '$2y$10$bvnJN7jUW.S8se6zoatadOcwfF85hTs9T184s0sv3VJVfYGW2Stme', 2, 0, 'offline', '2022-06-16 05:52:02', '2022-06-16 05:52:02'),
(74, 'Faruq As-Sahab', 'faruqsahab@demo.actudent.com', '$2y$10$4jcbZ9fBJC4E7fm13dhAzONvs2tgpiZw7tDHyzdCju5W5yCM0UzXy', 3, 0, 'offline', '2022-06-16 06:01:58', '2022-06-16 06:01:58'),
(75, 'Andi Irawan', 'andiirawan@demo.actudent.com', '$2y$10$9cXn7JnvPywziAqbw7QD7.4GzBOEkqoAvXCzhFr5TyFk4AEiMah5S', 3, 0, 'online', '2022-06-26 17:20:43', '2022-06-26 17:23:41'),
(76, 'Abaababa', 'ababaafy@demo.actudent.com', '$2y$10$tL2O9aGtzEnsw1OjZI/GhuBqcKN3Ui6L0xaOUVo01kb7rrzMmIJNe', 2, 1, 'offline', '2022-06-26 17:23:07', '2022-06-26 17:23:20'),
(77, 'Zidan Abdiyan', 'zidanabdiyan@demo.actudent.com', '$2y$10$Cp0lvQb3XdtQJ77pAId9eO8BdS7SzyN7WXRRP0.WqK8UTsX8Bs5hS', 3, 1, 'offline', '2022-06-30 04:36:45', '2023-04-20 03:13:01'),
(78, 'Indra Setiawan', 'NULL', '$2y$10$dOXyBumqbaLY6S7bYvymvenBc9H8EncwI.iPbn67Zzf79UBXr3Qvm', 2, 0, 'online', '2022-09-06 04:56:55', '2022-09-06 07:50:29'),
(79, 'Ibrahim Al-Awwad Al-Baihaki', 'ibrahimawwad@gmail.com', '$2y$10$M4TvTjii7L3ZzRyVjc/OmOd8JT0bjs3inBTPM/7stJfIKv2rC1CVO', 0, 0, 'offline', '2022-09-09 08:03:08', '2022-11-28 15:29:47'),
(80, 'Reyhan Pratama ', 'reyhanpratama@gmail.com', '$2y$10$AWyLRrv6yBwXuqhnfPqKzeqqYrZRc66UsaF6SGTjkd2iaBeAIW8qC', 0, 0, 'offline', '2022-11-28 15:00:42', '2022-11-28 15:22:51'),
(81, 'Muhammad Ibrahim', 'mibrahim@demo.actudent.com', '$2y$10$UwObcZIBYdR7N9vu2.egqO2A.coDJUfYSwFFPQdvtVJt/TjZVCa5C', 3, 1, 'offline', '2023-04-15 04:03:19', '2023-04-15 04:05:26'),
(82, 'Dorawati Candra', 'indralesmana222@gmail.com', '$2y$10$pbDUYzqE6ZdOH.9Wj9ILf.Fn89ts87kQpcgnYjCd6OWN.JyDOcfN2', 0, 1, 'offline', '2023-04-17 06:58:19', '2023-04-17 06:58:56'),
(83, 'Sahrul Aminin', 'sahrulaminin90@demo.actudent.com', '$2y$10$BqsTuKboZZJ9as5JumU5x.cyNqffj8qiAJhcW8HOFEp/nPeEXLeK.', 3, 1, 'offline', '2023-06-27 02:44:26', '2023-06-27 02:44:38'),
(84, 'Adrian Simatupang', 'adriansimatupan8839@demo.actudent.com', '$2y$10$oFeNnU2i7TwApkr8jciA6eRicTpkIqkNmagGuJaWefScMODW2QrPe', 3, 1, 'offline', '2023-06-27 03:27:39', '2023-06-27 03:27:56');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_devices`
--

CREATE TABLE `tb_user_devices` (
  `device_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `device_type` varchar(100) DEFAULT NULL,
  `device_version` varchar(100) DEFAULT NULL,
  `fcm_registration_id` varchar(500) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_user_devices`
--

INSERT INTO `tb_user_devices` (`device_id`, `user_id`, `device_type`, `device_version`, `fcm_registration_id`, `status`, `created`, `modified`) VALUES
(1, 30, 'ANDROID', '24', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 1, '2020-06-30 08:59:03', '2020-11-13 05:59:06'),
(2, 13, 'ANDROID', '22', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 0, '2020-06-30 10:12:35', '2020-07-11 01:57:19'),
(3, 53, 'ANDROID', '29', 'fcDzlt1TSZKGmb6WJPHmVf:APA91bHfyz4df_gdrbdsttsqbVYJwJrJnNEbfm0P2_zPxk7zQ0U0xo8y0D4Eds3vExnYc9M-RxOBNPmCr9UrtAht_X-lK6A79bYifto46E_dnUSd9wY489Ms7c9qkUMZz8y39UGt9QiT', 1, '2020-07-10 06:27:35', '2020-12-16 11:04:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_agenda`
--
ALTER TABLE `tb_agenda`
  ADD PRIMARY KEY (`agenda_id`),
  ADD KEY `agenda_author` (`user_id`);

--
-- Indexes for table `tb_chat`
--
ALTER TABLE `tb_chat`
  ADD PRIMARY KEY (`chat_id`),
  ADD KEY `chat_user` (`chat_user_id`);

--
-- Indexes for table `tb_chat_users`
--
ALTER TABLE `tb_chat_users`
  ADD PRIMARY KEY (`chat_user_id`);

--
-- Indexes for table `tb_grade`
--
ALTER TABLE `tb_grade`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `wali_kelas` (`teacher_id`);

--
-- Indexes for table `tb_homework`
--
ALTER TABLE `tb_homework`
  ADD KEY `journal_homework` (`journal_id`);

--
-- Indexes for table `tb_journal`
--
ALTER TABLE `tb_journal`
  ADD PRIMARY KEY (`journal_id`),
  ADD KEY `schedule_journal` (`schedule_id`);

--
-- Indexes for table `tb_lessons`
--
ALTER TABLE `tb_lessons`
  ADD PRIMARY KEY (`lesson_id`);

--
-- Indexes for table `tb_lessons_grade`
--
ALTER TABLE `tb_lessons_grade`
  ADD PRIMARY KEY (`lessons_grade_id`),
  ADD KEY `fk_teacher_lesson` (`teacher_id`),
  ADD KEY `fk_grade_lesson` (`grade_id`),
  ADD KEY `fk_lesson` (`lesson_id`);

--
-- Indexes for table `tb_logins`
--
ALTER TABLE `tb_logins`
  ADD PRIMARY KEY (`login_id`),
  ADD KEY `tb_logins_user_id_foreign` (`user_id`);

--
-- Indexes for table `tb_parent`
--
ALTER TABLE `tb_parent`
  ADD PRIMARY KEY (`parent_id`,`user_id`) USING BTREE,
  ADD KEY `fk_parent` (`user_id`);

--
-- Indexes for table `tb_presence`
--
ALTER TABLE `tb_presence`
  ADD PRIMARY KEY (`journal_id`,`student_id`),
  ADD KEY `student_presence` (`student_id`);

--
-- Indexes for table `tb_report_settings`
--
ALTER TABLE `tb_report_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_room`
--
ALTER TABLE `tb_room`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `tb_schedule`
--
ALTER TABLE `tb_schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `lessons_grade` (`lessons_grade_id`),
  ADD KEY `room` (`room_id`);

--
-- Indexes for table `tb_schedule_settings`
--
ALTER TABLE `tb_schedule_settings`
  ADD PRIMARY KEY (`schedule_setting_id`);

--
-- Indexes for table `tb_school`
--
ALTER TABLE `tb_school`
  ADD PRIMARY KEY (`school_id`);

--
-- Indexes for table `tb_score`
--
ALTER TABLE `tb_score`
  ADD PRIMARY KEY (`score_id`),
  ADD KEY `score_lessons_grade` (`lessons_grade_id`);

--
-- Indexes for table `tb_score_student`
--
ALTER TABLE `tb_score_student`
  ADD PRIMARY KEY (`score_id`,`student_id`),
  ADD KEY `score_student` (`student_id`);

--
-- Indexes for table `tb_sessions`
--
ALTER TABLE `tb_sessions`
  ADD PRIMARY KEY (`login_id`),
  ADD KEY `tb_sessions_user_id_foreign` (`user_id`);

--
-- Indexes for table `tb_staff`
--
ALTER TABLE `tb_staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `fk_staff_user` (`user_id`);

--
-- Indexes for table `tb_student`
--
ALTER TABLE `tb_student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `tb_student_grade`
--
ALTER TABLE `tb_student_grade`
  ADD PRIMARY KEY (`student_id`,`grade_id`),
  ADD KEY `fk_grade` (`grade_id`);

--
-- Indexes for table `tb_student_parent`
--
ALTER TABLE `tb_student_parent`
  ADD KEY `fk_student_parent` (`student_id`),
  ADD KEY `parent` (`parent_id`) USING BTREE;

--
-- Indexes for table `tb_timeline`
--
ALTER TABLE `tb_timeline`
  ADD PRIMARY KEY (`timeline_id`),
  ADD KEY `tb_timeline_user_id_foreign` (`user_id`);

--
-- Indexes for table `tb_timeline_images`
--
ALTER TABLE `tb_timeline_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_timeline_images_timeline_id_foreign` (`timeline_id`);

--
-- Indexes for table `tb_timelog`
--
ALTER TABLE `tb_timelog`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tb_user_devices`
--
ALTER TABLE `tb_user_devices`
  ADD PRIMARY KEY (`device_id`),
  ADD KEY `user_device` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_agenda`
--
ALTER TABLE `tb_agenda`
  MODIFY `agenda_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `tb_chat`
--
ALTER TABLE `tb_chat`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_chat_users`
--
ALTER TABLE `tb_chat_users`
  MODIFY `chat_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_grade`
--
ALTER TABLE `tb_grade`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tb_journal`
--
ALTER TABLE `tb_journal`
  MODIFY `journal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `tb_lessons`
--
ALTER TABLE `tb_lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tb_lessons_grade`
--
ALTER TABLE `tb_lessons_grade`
  MODIFY `lessons_grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `tb_logins`
--
ALTER TABLE `tb_logins`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_parent`
--
ALTER TABLE `tb_parent`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `tb_report_settings`
--
ALTER TABLE `tb_report_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_room`
--
ALTER TABLE `tb_room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_schedule`
--
ALTER TABLE `tb_schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `tb_schedule_settings`
--
ALTER TABLE `tb_schedule_settings`
  MODIFY `schedule_setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `tb_school`
--
ALTER TABLE `tb_school`
  MODIFY `school_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_score`
--
ALTER TABLE `tb_score`
  MODIFY `score_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_sessions`
--
ALTER TABLE `tb_sessions`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_staff`
--
ALTER TABLE `tb_staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tb_student`
--
ALTER TABLE `tb_student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tb_timeline`
--
ALTER TABLE `tb_timeline`
  MODIFY `timeline_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tb_timeline_images`
--
ALTER TABLE `tb_timeline_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `tb_timelog`
--
ALTER TABLE `tb_timelog`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `tb_user_devices`
--
ALTER TABLE `tb_user_devices`
  MODIFY `device_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_agenda`
--
ALTER TABLE `tb_agenda`
  ADD CONSTRAINT `agenda_author` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_chat`
--
ALTER TABLE `tb_chat`
  ADD CONSTRAINT `chat_user` FOREIGN KEY (`chat_user_id`) REFERENCES `tb_chat_users` (`chat_user_id`);

--
-- Constraints for table `tb_grade`
--
ALTER TABLE `tb_grade`
  ADD CONSTRAINT `wali_kelas` FOREIGN KEY (`teacher_id`) REFERENCES `tb_staff` (`staff_id`);

--
-- Constraints for table `tb_homework`
--
ALTER TABLE `tb_homework`
  ADD CONSTRAINT `journal_homework` FOREIGN KEY (`journal_id`) REFERENCES `tb_journal` (`journal_id`);

--
-- Constraints for table `tb_journal`
--
ALTER TABLE `tb_journal`
  ADD CONSTRAINT `schedule_journal` FOREIGN KEY (`schedule_id`) REFERENCES `tb_schedule` (`schedule_id`);

--
-- Constraints for table `tb_lessons_grade`
--
ALTER TABLE `tb_lessons_grade`
  ADD CONSTRAINT `fk_grade_lesson` FOREIGN KEY (`grade_id`) REFERENCES `tb_grade` (`grade_id`),
  ADD CONSTRAINT `fk_lesson` FOREIGN KEY (`lesson_id`) REFERENCES `tb_lessons` (`lesson_id`),
  ADD CONSTRAINT `fk_teacher_lesson` FOREIGN KEY (`teacher_id`) REFERENCES `tb_staff` (`staff_id`);

--
-- Constraints for table `tb_logins`
--
ALTER TABLE `tb_logins`
  ADD CONSTRAINT `tb_logins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_parent`
--
ALTER TABLE `tb_parent`
  ADD CONSTRAINT `fk_parent` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_presence`
--
ALTER TABLE `tb_presence`
  ADD CONSTRAINT `presence_journal` FOREIGN KEY (`journal_id`) REFERENCES `tb_journal` (`journal_id`),
  ADD CONSTRAINT `student_presence` FOREIGN KEY (`student_id`) REFERENCES `tb_student` (`student_id`);

--
-- Constraints for table `tb_schedule`
--
ALTER TABLE `tb_schedule`
  ADD CONSTRAINT `lessons_grade` FOREIGN KEY (`lessons_grade_id`) REFERENCES `tb_lessons_grade` (`lessons_grade_id`),
  ADD CONSTRAINT `room` FOREIGN KEY (`room_id`) REFERENCES `tb_room` (`room_id`);

--
-- Constraints for table `tb_score`
--
ALTER TABLE `tb_score`
  ADD CONSTRAINT `score_lessons_grade` FOREIGN KEY (`lessons_grade_id`) REFERENCES `tb_lessons_grade` (`lessons_grade_id`);

--
-- Constraints for table `tb_score_student`
--
ALTER TABLE `tb_score_student`
  ADD CONSTRAINT `score_id` FOREIGN KEY (`score_id`) REFERENCES `tb_score` (`score_id`),
  ADD CONSTRAINT `score_student` FOREIGN KEY (`student_id`) REFERENCES `tb_student` (`student_id`);

--
-- Constraints for table `tb_sessions`
--
ALTER TABLE `tb_sessions`
  ADD CONSTRAINT `tb_sessions_login_id_foreign` FOREIGN KEY (`login_id`) REFERENCES `tb_logins` (`login_id`),
  ADD CONSTRAINT `tb_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_staff`
--
ALTER TABLE `tb_staff`
  ADD CONSTRAINT `fk_staff_user` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_student_grade`
--
ALTER TABLE `tb_student_grade`
  ADD CONSTRAINT `fk_grade` FOREIGN KEY (`grade_id`) REFERENCES `tb_grade` (`grade_id`),
  ADD CONSTRAINT `fk_student` FOREIGN KEY (`student_id`) REFERENCES `tb_student` (`student_id`);

--
-- Constraints for table `tb_student_parent`
--
ALTER TABLE `tb_student_parent`
  ADD CONSTRAINT `fk_ortu` FOREIGN KEY (`parent_id`) REFERENCES `tb_parent` (`parent_id`),
  ADD CONSTRAINT `fk_student_parent` FOREIGN KEY (`student_id`) REFERENCES `tb_student` (`student_id`);

--
-- Constraints for table `tb_timeline`
--
ALTER TABLE `tb_timeline`
  ADD CONSTRAINT `tb_timeline_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_timeline_images`
--
ALTER TABLE `tb_timeline_images`
  ADD CONSTRAINT `tb_timeline_images_timeline_id_foreign` FOREIGN KEY (`timeline_id`) REFERENCES `tb_timeline` (`timeline_id`);

--
-- Constraints for table `tb_user_devices`
--
ALTER TABLE `tb_user_devices`
  ADD CONSTRAINT `user_device` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
