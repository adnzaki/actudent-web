-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2022 at 05:55 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

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
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_agenda`
--

INSERT INTO `tb_agenda` (`agenda_id`, `agenda_name`, `agenda_start`, `agenda_end`, `agenda_description`, `agenda_priority`, `agenda_location`, `agenda_attachment`, `user_id`, `created`, `modified`) VALUES
(6, 'Sosialisasi Ujian Nasional SMKN 999 Kota Bekasi', '2019-06-26 00:00:00', '2019-06-26 23:30:00', 'hahahahaha', 'high', 'sekolah', NULL, 1, '2019-06-26 16:51:51', '2019-06-26 16:51:51'),
(7, 'Pengumuman Kelulusan SMKN 999 Kota Bekasi', '2019-06-29 08:00:00', '2019-06-29 10:00:00', 'Semangat kalian!!!!', 'high', 'sekolah', '1561543266_4fc5d15c868b378d226a.pdf', 1, '2019-06-26 17:01:06', '2019-06-26 17:01:06'),
(21, 'Hari pertama PPDB 2019/2020 untuk SD', '2019-07-01 07:00:00', '2019-07-01 14:00:00', 'Semoga berjalan lancar', 'high', 'Sekolah', NULL, 1, '2019-06-30 14:35:51', '2019-06-30 14:35:51'),
(22, 'HUT RI ke-74', '2019-08-17 00:00:00', '2019-08-17 23:30:00', 'hahaha', 'normal', '', '1566879986_edb42c87f27f38713e42.pdf', 1, '2019-07-01 20:58:14', '2019-08-27 11:26:26'),
(24, 'Kita adalah siapa', '2019-10-31 10:30:00', '2019-10-31 16:30:00', '', 'low', '', NULL, 1, '2019-07-03 11:22:46', '2019-07-03 11:22:46'),
(25, 'hhahaha', '2019-11-24 10:00:00', '2019-11-24 11:30:00', 'ssssss', 'normal', '', NULL, 1, '2019-07-03 11:23:12', '2019-07-03 11:23:12'),
(26, 'Alhamdulillah udah cukup keren..', '2019-07-10 08:30:00', '2019-07-10 10:00:00', 'mantappppss', 'normal', '', NULL, 1, '2019-07-03 17:49:27', '2019-07-03 17:49:27'),
(27, 'Kegiatan apakah ini?', '2019-07-17 09:00:00', '2019-07-17 16:30:00', '', 'low', '', NULL, 1, '2019-07-15 17:27:51', '2019-07-15 17:27:51'),
(28, 'Sabtu maiiinnnn', '2019-07-20 20:30:00', '2019-07-20 22:30:00', '', 'high', 'rumah beta', NULL, 1, '2019-07-15 17:28:45', '2019-07-15 17:28:45'),
(29, 'Coba coba', '2019-07-25 00:00:00', '2019-07-25 23:30:00', '', 'high', 'hehe', NULL, 1, '2019-07-24 23:15:34', '2019-07-24 23:15:34'),
(30, 'Target selesai halaman edit', '2019-08-24 00:00:00', '2019-08-24 23:30:00', 'Hari ini form edit sudah harus selesai ya bro!!!', 'high', 'Dimana aja yg penting bisa coding', NULL, 1, '2019-08-08 12:07:43', '2019-08-19 14:58:18'),
(31, 'Alhamdulillah ternyata sudah selesai', '2019-08-19 00:00:00', '2019-08-19 23:30:00', 'mantap dah aing bisa', 'low', 'rumah', '1566546105_be2406fb37814442b20e.pdf', 1, '2019-08-09 02:23:29', '2019-08-23 14:41:45'),
(32, 'ngasal dulu', '2019-08-22 00:00:00', '2019-08-24 23:30:00', '', 'normal', '', NULL, 1, '2019-08-09 11:32:23', '2019-08-09 11:32:23'),
(33, 'hari tasyrik', '2019-08-21 00:00:00', '2019-08-21 23:30:00', 'takbir!!', 'high', '', '1566546408_31351a89a7f02372f595.pdf', 1, '2019-08-09 11:34:37', '2019-08-23 14:46:48'),
(34, 'Sekolah sehat mamen', '2019-08-21 00:00:00', '2019-08-21 23:30:00', 'ayo kita sukseskan kegiatan ini!!!', 'high', 'Sekolah', '1566546147_bcdffbb6acd53dd1371e.pdf', 1, '2019-08-10 12:17:50', '2019-08-23 14:42:26'),
(35, 'Persiapan PTS Ganjil', '2019-08-29 00:00:00', '2019-08-30 23:30:00', 'Mohon kepada bapak ibu guru partisipasinya.', 'high', 'Sekolah', '1565414411_6b3ca8d7fce3cc1c9fa8.pdf', 1, '2019-08-10 12:20:11', '2019-08-10 12:20:11'),
(36, 'Ini adalah hari sabtu', '2019-08-31 00:00:00', '2019-08-31 23:30:00', 'okeee', 'high', 'Dimana aja', '1565592050_712411f7ea42f39130d4.pdf', 1, '2019-08-12 13:40:49', '2019-08-12 13:40:49'),
(37, 'Agenda awal bulan', '2019-09-16 00:00:00', '2019-09-16 23:30:00', '', 'normal', '', NULL, 1, '2019-08-12 13:45:47', '2019-09-12 09:34:19'),
(40, 'Liburan dulu euy', '2019-08-25 06:00:00', '2019-08-25 23:30:00', '', 'high', '', '1566880075_7c08884baa0e3a13d576.pdf', 1, '2019-08-15 10:58:23', '2019-08-27 11:27:54'),
(42, 'Maulid Nabi Muhammad', '2019-11-09 07:00:00', '2019-11-09 11:00:00', '', 'high', 'Sekolah', NULL, 1, '2019-11-09 17:42:21', '2019-11-09 17:42:21'),
(43, 'Mengapa ini terjadi??', '2019-11-13 00:00:00', '2019-11-13 23:30:00', '', 'high', '', NULL, 1, '2019-11-10 10:35:39', '2019-11-10 10:35:39'),
(44, 'Refreshing dulu masbro', '2020-01-25 08:00:00', '2020-01-25 17:00:00', 'Jalan-jalan sama ndin..', 'high', 'Taman Mini dan Lubang Buaya', NULL, 1, '2020-01-24 13:36:31', '2020-01-24 13:36:31'),
(45, 'Hari belajar', '2020-03-16 00:00:00', '2020-03-16 23:30:00', '', 'normal', '', '1584002130_6fb36433707371d5b95d.pdf', 1, '2020-03-12 15:35:29', '2020-03-12 15:35:30'),
(46, 'Akhir April kita ngapain hayo?', '2020-04-30 21:30:00', '2020-05-01 09:00:00', '', 'low', 'dimana aja', '1588495530_86f422d491f4a106337d.pdf', 1, '2020-04-14 12:38:20', '2020-05-03 15:45:30'),
(47, 'Malem taun baruan', '2020-12-31 00:00:00', '2021-01-01 23:30:00', '', 'normal', 'mana aja udah', NULL, 1, '2020-04-14 13:11:47', '2020-04-14 13:23:07'),
(48, 'Makan-makan ', '2020-04-16 00:00:00', '2020-04-18 23:30:00', '', 'normal', 'Di rumah masing-masing', NULL, 1, '2020-04-14 19:57:08', '2020-04-14 19:57:08'),
(49, 'Pra-Pendaftaran Siswa Baru', '2020-06-08 08:00:00', '2020-06-13 13:00:00', 'Persiapan PPDB dimulai dengan upload berkas dan verifikasi dinas.', 'high', 'Sekolah', '1591859791_048da77417873ae22a3b.pdf', 1, '2020-06-04 11:44:50', '2020-06-11 14:18:25'),
(50, 'RAPAT SEMESTER GANJIL', '2020-06-29 09:00:00', '2020-06-29 12:00:00', '', 'high', 'RPS', NULL, 1, '2020-06-20 10:49:36', '2020-06-20 10:49:36'),
(51, 'Pendaftaran PPDB SMKN 999 Kota Bekasi', '2020-07-01 09:00:00', '2020-07-04 15:00:00', 'Mulai tanggal 1 hingga 4 Juli SMKN 999 Kota Bekasi menyelenggarakan kegiatan penerimaan peserta didik baru secara online Tahun Ajaran 2019/2020', 'high', 'Sekolah', NULL, 1, '2020-07-02 08:57:40', '2020-07-02 08:57:40'),
(52, 'Sosialisasi aplikasi Actudent', '2020-07-06 08:00:00', '2020-07-06 11:00:00', 'SMKN 999 Kota Bekasi akan mengadakan sosialisasi Actudent kepada orang tua dan guru', 'high', 'Ruang Aula', NULL, 1, '2020-07-02 09:06:09', '2020-07-02 09:06:09'),
(53, 'Menyusun laporan keuangan akhir tahun', '2020-12-29 08:00:00', '2020-12-30 16:00:00', 'ayo selesaikan', 'high', '', NULL, 1, '2020-12-29 16:31:48', '2020-12-29 16:31:48'),
(54, 'Hari pertama masuk sekolah tatap muka', '2021-01-04 07:00:00', '2021-01-04 12:00:00', '', 'normal', 'di sekolah', NULL, 1, '2021-01-01 13:47:13', '2021-01-01 13:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `tb_agenda_user`
--

CREATE TABLE `tb_agenda_user` (
  `agenda_id` int(11) NOT NULL,
  `guests` text DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_agenda_user`
--

INSERT INTO `tb_agenda_user` (`agenda_id`, `guests`, `created`, `modified`) VALUES
(6, '5,4,13', '2019-06-26 16:51:51', '2019-06-26 16:51:51'),
(7, '12,8,9,10', '2019-06-26 17:01:06', '2019-06-26 17:01:06'),
(30, '12,10,11', '2019-08-08 12:07:44', '2019-08-08 12:07:44'),
(31, '11,4,8,6', '2019-08-09 02:23:29', '2019-08-09 02:23:29'),
(34, '4,13', '2019-08-10 12:17:50', '2019-08-10 12:17:50'),
(35, '4,13,12', '2019-08-10 12:20:11', '2019-08-10 12:20:11'),
(48, '4,28,30,31,33,43,39', '2020-04-14 19:57:08', '2020-04-14 19:57:08'),
(50, '53', '2020-07-10 13:51:52', '2020-07-10 13:51:52'),
(52, '28,31,33,43,39,23,27,34,26,30', '2020-07-02 09:06:09', '2020-07-16 12:53:42');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `grade_name` varchar(20) DEFAULT NULL,
  `period_start` varchar(4) DEFAULT NULL,
  `period_end` varchar(4) DEFAULT NULL,
  `teacher_id` int(11) NOT NULL,
  `grade_status` tinyint(1) DEFAULT NULL,
  `rombel_dapodik_id` varchar(50) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_grade`
--

INSERT INTO `tb_grade` (`grade_id`, `grade_name`, `period_start`, `period_end`, `teacher_id`, `grade_status`, `rombel_dapodik_id`, `deleted`, `created`, `modified`) VALUES
(1, 'X TKJ 2', '2021', '2022', 2, 1, NULL, 1, '2019-03-29 05:51:07', '2021-12-18 17:02:27'),
(2, 'X Grafika 1', '2021', '2022', 10, 1, NULL, 0, '2019-03-28 07:37:57', '2021-12-18 17:02:27'),
(3, 'X TKJ 1', '2021', '2022', 1, 1, NULL, 0, '2019-03-29 05:54:53', '2021-12-18 17:02:27'),
(6, 'X Animasi 1', '2021', '2022', 2, 1, NULL, 0, '2020-03-11 15:22:07', '2021-12-18 17:02:27'),
(7, 'X TKJ 2', '2021', '2022', 4, 1, NULL, 1, '2020-04-03 14:02:17', '2021-12-18 17:02:27');

-- --------------------------------------------------------

--
-- Table structure for table `tb_homework`
--

CREATE TABLE `tb_homework` (
  `journal_id` int(11) NOT NULL,
  `homework_title` varchar(300) DEFAULT NULL,
  `homework_description` varchar(500) DEFAULT NULL,
  `due_date` timestamp NULL DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(132, 'Menulis karya puisi sendiri', 'Dikerjakan di rumah', '2022-02-24 16:59:00', '2022-02-22 05:20:19', '2022-02-22 05:20:19');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(136, 71, 'test 2', 0, '2022-02-28', '2022-02-28 01:59:46', '2022-03-05 21:29:01');

-- --------------------------------------------------------

--
-- Table structure for table `tb_lessons`
--

CREATE TABLE `tb_lessons` (
  `lesson_id` int(11) NOT NULL,
  `lesson_code` varchar(50) NOT NULL,
  `lesson_name` varchar(100) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(16, 'PRG', 'Pemrograman Dasar', 1, '2020-07-09 05:43:19', '2021-01-13 05:09:24');

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
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_lessons_grade`
--

INSERT INTO `tb_lessons_grade` (`lessons_grade_id`, `lesson_id`, `grade_id`, `teacher_id`, `deleted`, `created`, `modified`) VALUES
(30, 1, 6, 2, 0, '2020-06-20 10:42:44', '2020-06-20 10:42:44'),
(31, 1, 3, 1, 0, '2020-07-01 05:54:56', '2020-07-01 05:54:56'),
(32, 9, 3, 3, 0, '2020-07-01 05:55:13', '2020-07-01 05:55:13'),
(33, 11, 3, 7, 0, '2020-07-01 05:55:50', '2020-07-01 05:55:50'),
(34, 5, 2, 3, 0, '2020-07-01 07:27:02', '2020-07-01 07:27:02'),
(35, 6, 2, 8, 0, '2020-07-01 07:27:35', '2020-07-01 07:27:35'),
(36, 2, 3, 4, 0, '2020-07-02 08:52:41', '2020-07-02 08:52:41'),
(37, 3, 3, 9, 0, '2020-07-02 08:52:54', '2020-07-02 08:52:54'),
(38, 16, 3, 6, 0, '2020-07-09 12:46:06', '2020-07-09 12:46:06'),
(39, 2, 6, 4, 0, '2020-07-09 12:46:36', '2020-07-09 12:46:36'),
(40, 3, 6, 4, 0, '2020-07-09 12:46:47', '2020-07-09 12:46:47'),
(41, 11, 6, 5, 0, '2020-07-09 12:47:02', '2020-07-09 12:47:02'),
(42, 13, 2, 10, 0, '2020-07-09 12:47:35', '2020-07-10 12:48:38'),
(43, 1, 2, 1, 0, '2020-07-09 12:47:45', '2020-07-09 12:47:45'),
(44, 10, 6, 3, 0, '2020-07-10 11:56:30', '2020-07-10 11:56:30'),
(45, 14, 3, 10, 0, '2020-07-10 12:54:11', '2020-07-10 12:54:11'),
(46, 14, 6, 10, 0, '2020-07-10 12:55:47', '2020-07-10 12:55:47'),
(47, 10, 2, 6, 0, '2021-01-13 12:10:01', '2021-01-13 12:10:01'),
(48, 5, 2, 5, 1, '2021-01-13 12:11:09', '2021-01-13 12:16:28');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(19, 32, '3290809284095894', 'Abdi Negara Sejati', 'Ibu Negara', '0839809458490', 0, '2020-02-10 08:17:14', '2020-02-20 04:24:14'),
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
(47, 68, '3297982374837583', 'Huntu', 'Hinti', '08039485948', 0, '2021-05-18 05:25:53', '2021-05-18 05:25:53');

-- --------------------------------------------------------

--
-- Table structure for table `tb_presence`
--

CREATE TABLE `tb_presence` (
  `journal_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `presence_status` int(11) DEFAULT NULL,
  `presence_mark` varchar(300) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_presence`
--

INSERT INTO `tb_presence` (`journal_id`, `student_id`, `presence_status`, `presence_mark`, `created`, `modified`) VALUES
(38, 3, 1, '', '2020-06-22 18:00:20', '2020-06-25 18:00:20'),
(38, 8, 1, '', '2020-06-22 18:00:20', '2020-06-25 18:00:20'),
(38, 11, 1, '', '2020-06-22 18:00:20', '2020-06-25 18:00:20'),
(38, 14, 1, '', '2020-06-22 18:00:20', '2020-06-25 18:00:20'),
(38, 24, 1, '', '2020-06-22 18:00:20', '2020-06-25 18:00:20'),
(38, 26, 1, '', '2020-06-22 18:00:20', '2020-06-25 18:00:20'),
(38, 28, 1, '', '2020-06-22 18:00:20', '2020-06-25 18:00:20'),
(39, 1, 1, '', '2020-06-08 17:54:15', '2020-06-25 17:54:15'),
(39, 3, 1, '', '2020-06-08 17:54:15', '2020-06-25 17:54:15'),
(39, 6, 1, '', '2020-06-08 17:54:15', '2020-06-25 17:54:15'),
(39, 8, 1, '', '2020-06-08 17:54:15', '2020-06-25 17:54:15'),
(39, 11, 1, '', '2020-06-08 17:54:15', '2020-06-25 17:54:15'),
(39, 13, 1, '', '2020-06-08 17:54:15', '2020-06-25 17:54:15'),
(39, 14, 3, '', '2020-06-08 17:54:23', '2020-06-25 17:54:23'),
(39, 17, 1, '', '2020-06-08 17:54:15', '2020-06-25 17:54:15'),
(39, 24, 1, '', '2020-06-08 17:54:15', '2020-06-25 17:54:15'),
(39, 26, 1, '', '2020-06-08 17:54:15', '2020-06-25 17:54:15'),
(39, 28, 1, '', '2020-06-08 17:54:15', '2020-06-25 17:54:15'),
(40, 7, 2, 'Jalan jalan', '2020-07-01 22:59:44', '2020-07-01 05:59:44'),
(40, 9, 3, '', '2020-07-01 22:59:48', '2020-07-01 05:59:48'),
(40, 10, 0, '', '2020-07-01 22:59:53', '2020-07-01 05:59:53'),
(40, 12, 1, '', '2020-07-01 23:00:04', '2020-07-01 06:00:04'),
(40, 21, 1, '', '2020-07-01 22:59:31', '2020-07-01 05:59:31'),
(40, 27, 0, '', '2020-07-01 22:59:29', '2020-07-01 07:24:48'),
(40, 29, 3, '', '2020-07-01 23:00:02', '2020-07-01 06:44:46'),
(40, 30, 1, '', '2020-07-01 22:59:50', '2020-07-01 05:59:50'),
(43, 27, 1, '', '2020-07-01 23:00:42', '2020-07-01 06:00:42'),
(44, 7, 1, '', '2020-07-01 23:01:24', '2020-07-01 06:01:24'),
(44, 9, 0, '', '2020-07-01 23:01:26', '2020-07-01 06:01:26'),
(44, 10, 1, '', '2020-07-01 23:01:29', '2020-07-01 06:01:29'),
(44, 12, 1, '', '2020-07-01 23:01:33', '2020-07-01 06:01:33'),
(44, 21, 1, '', '2020-07-01 23:01:19', '2020-07-01 06:01:19'),
(44, 27, 1, '', '2020-07-01 23:01:18', '2020-07-01 06:01:18'),
(44, 29, 1, '', '2020-07-01 23:01:31', '2020-07-01 06:01:31'),
(44, 30, 3, '', '2020-07-01 23:01:27', '2020-07-01 06:01:27'),
(45, 27, 0, '', '2020-07-01 23:04:43', '2020-07-01 06:04:43'),
(47, 1, 3, '', '2020-07-01 07:33:35', '2020-07-02 16:36:47'),
(47, 6, 2, 'makan', '2020-07-01 07:33:35', '2020-07-02 16:37:03'),
(47, 13, 0, '', '2020-07-01 07:33:35', '2020-07-02 16:36:39'),
(47, 17, 1, '', '2020-07-01 07:33:35', '2020-07-01 07:33:35'),
(47, 18, 3, '', '2020-07-01 23:42:34', '2020-07-01 23:42:34'),
(47, 31, 3, '', '2020-07-01 07:33:41', '2020-07-01 07:33:41'),
(47, 32, 1, '', '2020-07-01 07:33:35', '2020-07-01 07:33:35'),
(48, 1, 1, '', '2020-07-09 12:56:24', '2020-07-09 12:56:24'),
(48, 6, 1, '', '2020-07-09 12:56:24', '2020-07-09 12:56:24'),
(48, 13, 1, '', '2020-07-09 12:56:24', '2020-07-09 12:56:24'),
(48, 17, 1, '', '2020-07-09 12:56:24', '2020-07-09 12:56:24'),
(48, 18, 1, '', '2020-07-09 13:23:49', '2020-07-09 13:23:49'),
(48, 31, 1, '', '2020-07-09 12:56:24', '2020-07-09 12:56:24'),
(48, 32, 1, '', '2020-07-09 12:56:24', '2020-07-09 12:56:24'),
(48, 36, 1, '', '2020-07-09 12:56:24', '2020-07-09 12:56:24'),
(49, 7, 1, '', '2020-07-09 12:57:06', '2020-07-09 12:57:06'),
(49, 9, 2, 'keluar rumah', '2020-07-09 12:57:19', '2020-07-09 12:57:19'),
(49, 10, 1, '', '2020-07-09 12:57:06', '2020-07-09 12:57:06'),
(49, 12, 3, '', '2020-07-09 12:57:26', '2020-07-09 12:57:26'),
(49, 21, 1, '', '2020-07-09 12:57:06', '2020-07-09 12:57:06'),
(49, 27, 1, '', '2020-07-09 12:57:06', '2020-07-09 12:57:06'),
(49, 29, 1, '', '2020-07-09 12:57:06', '2020-07-09 12:57:06'),
(49, 30, 1, '', '2020-07-09 12:57:06', '2020-07-09 12:57:06'),
(49, 34, 1, '', '2020-07-09 12:57:06', '2020-07-09 12:57:06'),
(50, 7, 1, '', '2020-07-08 12:57:52', '2020-07-09 12:57:52'),
(50, 9, 3, '', '2020-07-08 12:57:52', '2020-07-10 06:12:44'),
(50, 10, 1, '', '2020-07-08 12:57:52', '2020-07-09 12:57:52'),
(50, 12, 0, '', '2020-07-08 13:40:04', '2020-07-09 13:40:04'),
(50, 21, 1, '', '2020-07-08 12:57:52', '2020-07-09 12:57:52'),
(50, 27, 1, '', '2020-07-08 12:57:55', '2020-07-10 06:12:27'),
(50, 29, 1, '', '2020-07-08 12:57:52', '2020-07-09 12:57:52'),
(50, 30, 1, '', '2020-07-08 12:57:52', '2020-07-10 06:13:12'),
(50, 34, 1, '', '2020-07-08 12:57:52', '2020-07-09 12:57:52'),
(51, 3, 1, '', '2020-07-08 12:58:14', '2020-07-09 12:58:14'),
(51, 8, 1, '', '2020-07-08 12:58:14', '2020-07-09 12:58:14'),
(51, 11, 1, '', '2020-07-08 12:58:14', '2020-07-09 12:58:14'),
(51, 14, 1, '', '2020-07-08 12:58:14', '2020-07-09 12:58:14'),
(51, 24, 1, '', '2020-07-08 12:58:14', '2020-07-09 12:58:14'),
(51, 26, 1, '', '2020-07-08 12:58:14', '2020-07-09 12:58:14'),
(51, 28, 1, '', '2020-07-08 12:58:14', '2020-07-09 12:58:14'),
(51, 35, 1, '', '2020-07-08 12:58:14', '2020-07-09 12:58:14'),
(52, 3, 1, '', '2020-07-09 13:00:06', '2020-07-09 13:00:06'),
(52, 8, 3, '', '2020-07-09 13:00:11', '2020-07-09 13:00:11'),
(52, 11, 1, '', '2020-07-09 13:00:06', '2020-07-09 13:00:06'),
(52, 14, 1, '', '2020-07-09 13:00:06', '2020-07-09 13:00:06'),
(52, 24, 0, '', '2020-07-09 13:00:13', '2020-07-09 13:00:13'),
(52, 26, 1, '', '2020-07-09 13:00:06', '2020-07-09 13:00:06'),
(52, 28, 1, '', '2020-07-09 13:00:06', '2020-07-09 13:00:06'),
(52, 35, 1, '', '2020-07-09 13:00:06', '2020-07-09 13:00:06'),
(58, 3, 1, '', '2020-07-06 17:51:48', '2020-07-09 17:51:48'),
(58, 8, 1, '', '2020-07-06 17:51:48', '2020-07-09 17:51:48'),
(58, 11, 1, '', '2020-07-06 17:51:48', '2020-07-09 17:51:48'),
(58, 14, 1, '', '2020-07-06 17:51:48', '2020-07-09 17:51:48'),
(58, 24, 1, '', '2020-07-06 17:51:48', '2020-07-09 17:51:48'),
(58, 26, 1, '', '2020-07-06 17:51:48', '2020-07-09 17:51:48'),
(58, 28, 1, '', '2020-07-06 17:51:48', '2020-07-09 17:51:48'),
(58, 35, 1, '', '2020-07-06 17:51:48', '2020-07-09 17:51:48'),
(60, 3, 1, '', '2020-07-10 08:33:28', '2020-07-10 08:33:28'),
(60, 8, 1, '', '2020-07-10 08:33:28', '2020-07-10 08:33:28'),
(60, 11, 1, '', '2020-07-10 08:33:28', '2020-07-10 08:33:28'),
(60, 14, 1, '', '2020-07-10 08:33:28', '2020-07-10 08:33:28'),
(60, 24, 2, 'Pulang kampung', '2020-07-10 08:33:41', '2020-07-10 08:33:41'),
(60, 26, 1, '', '2020-07-10 08:33:28', '2020-07-10 08:33:28'),
(60, 28, 1, '', '2020-07-10 08:33:28', '2020-07-10 08:33:28'),
(60, 35, 1, '', '2020-07-10 08:33:28', '2020-07-10 08:33:28'),
(61, 7, 1, '', '2020-07-10 08:34:04', '2020-07-10 08:34:04'),
(61, 9, 1, '', '2020-07-10 08:34:04', '2020-07-10 08:34:04'),
(61, 10, 1, '', '2020-07-10 08:34:04', '2020-07-10 08:34:04'),
(61, 12, 1, '', '2020-07-10 08:34:04', '2020-07-10 08:34:04'),
(61, 21, 1, '', '2020-07-10 08:34:04', '2020-07-10 08:34:04'),
(61, 27, 1, '', '2020-07-10 08:34:04', '2020-07-10 08:34:04'),
(61, 29, 1, '', '2020-07-10 08:34:04', '2020-07-10 08:34:04'),
(61, 30, 1, '', '2020-07-10 08:34:04', '2020-07-10 08:34:04'),
(61, 34, 1, '', '2020-07-10 08:34:04', '2020-07-10 08:34:04'),
(62, 1, 1, '', '2020-07-10 09:59:34', '2020-07-10 09:59:34'),
(62, 6, 1, '', '2020-07-10 09:59:34', '2020-07-10 09:59:34'),
(62, 13, 3, '', '2020-07-10 09:59:38', '2020-07-10 09:59:38'),
(62, 17, 1, '', '2020-07-10 09:59:34', '2020-07-10 09:59:34'),
(62, 18, 1, '', '2020-07-10 09:59:34', '2020-07-10 09:59:34'),
(62, 31, 1, '', '2020-07-10 09:59:34', '2020-07-10 11:32:37'),
(62, 32, 1, '', '2020-07-10 09:59:34', '2020-07-10 09:59:34'),
(62, 36, 1, '', '2020-07-10 09:59:34', '2020-07-10 09:59:34'),
(63, 3, 1, '', '2020-07-10 13:49:59', '2020-07-10 13:49:59'),
(63, 8, 1, '', '2020-07-10 13:49:59', '2020-07-10 13:49:59'),
(63, 11, 1, '', '2020-07-10 13:49:59', '2020-07-10 13:49:59'),
(63, 14, 0, '', '2020-07-10 13:50:03', '2020-07-10 13:50:03'),
(63, 24, 1, '', '2020-07-10 13:49:59', '2020-07-10 13:49:59'),
(63, 26, 1, '', '2020-07-10 13:49:59', '2020-07-10 13:49:59'),
(63, 28, 1, '', '2020-07-10 13:49:59', '2020-07-10 13:49:59'),
(63, 35, 1, '', '2020-07-10 13:49:59', '2020-07-10 13:49:59'),
(64, 1, 1, '', '2020-07-10 07:47:52', '2020-07-10 14:47:52'),
(64, 6, 1, '', '2020-07-10 07:47:54', '2020-07-10 14:47:54'),
(64, 13, 1, '', '2020-07-10 07:48:04', '2020-07-10 14:48:04'),
(64, 17, 1, '', '2020-07-10 07:47:55', '2020-07-10 14:47:55'),
(64, 18, 1, '', '2020-07-10 07:47:59', '2020-07-10 14:47:59'),
(64, 31, 1, '', '2020-07-10 07:48:02', '2020-07-10 14:48:02'),
(64, 32, 1, '', '2020-07-10 07:48:00', '2020-07-10 14:48:00'),
(64, 36, 1, '', '2020-07-10 07:47:57', '2020-07-10 14:47:57'),
(65, 1, 1, '', '2020-07-10 07:46:29', '2020-07-10 14:46:29'),
(65, 6, 1, '', '2020-07-10 07:46:30', '2020-07-10 14:46:30'),
(65, 13, 1, '', '2020-07-10 07:46:51', '2020-07-10 14:46:51'),
(65, 17, 0, '', '2020-07-10 07:46:32', '2020-07-10 14:47:02'),
(65, 18, 1, '', '2020-07-10 07:46:38', '2020-07-10 14:46:38'),
(65, 31, 1, '', '2020-07-10 07:46:49', '2020-07-10 14:46:49'),
(65, 32, 1, '', '2020-07-10 07:46:46', '2020-07-10 14:46:46'),
(65, 36, 1, '', '2020-07-10 07:46:35', '2020-07-10 14:46:35'),
(67, 3, 1, '', '2020-07-10 07:50:07', '2020-07-10 14:50:07'),
(67, 8, 3, '', '2020-07-10 07:50:22', '2020-07-10 14:50:22'),
(67, 11, 1, '', '2020-07-10 07:50:12', '2020-07-10 14:50:12'),
(67, 14, 1, '', '2020-07-10 07:50:15', '2020-07-10 14:50:15'),
(67, 24, 1, '', '2020-07-10 07:50:20', '2020-07-10 14:50:20'),
(67, 26, 1, '', '2020-07-10 07:50:09', '2020-07-10 14:50:09'),
(67, 28, 1, '', '2020-07-10 07:50:03', '2020-07-10 14:50:03'),
(67, 35, 1, '', '2020-07-10 07:50:17', '2020-07-10 14:50:17'),
(68, 3, 1, '', '2020-07-10 07:51:36', '2020-07-10 14:51:36'),
(68, 8, 1, '', '2020-07-10 07:51:50', '2020-07-10 14:51:50'),
(68, 11, 0, '', '2020-07-10 07:51:41', '2020-07-10 14:51:41'),
(68, 14, 1, '', '2020-07-10 07:51:42', '2020-07-10 14:51:42'),
(68, 24, 1, '', '2020-07-10 07:51:47', '2020-07-10 14:51:47'),
(68, 26, 3, '', '2020-07-10 07:51:39', '2020-07-10 14:51:39'),
(68, 28, 1, '', '2020-07-10 07:51:32', '2020-07-10 14:51:32'),
(68, 35, 1, '', '2020-07-10 07:51:45', '2020-07-10 14:51:45'),
(69, 3, 3, '', '2020-07-11 09:23:57', '2020-07-11 09:23:57'),
(69, 8, 0, '', '2020-07-11 09:26:13', '2020-07-11 09:26:13'),
(69, 11, 1, '', '2020-07-11 09:11:36', '2020-07-11 09:11:36'),
(69, 14, 1, '', '2020-07-11 09:11:37', '2020-07-11 09:11:37'),
(69, 24, 1, '', '2020-07-11 09:11:39', '2020-07-11 09:11:39'),
(69, 26, 1, '', '2020-07-11 09:10:20', '2020-07-11 09:10:20'),
(69, 28, 1, '', '2020-07-11 09:10:20', '2020-07-11 09:10:20'),
(69, 35, 1, '', '2020-07-11 09:10:20', '2020-07-11 09:10:20'),
(70, 1, 1, '', '2020-07-11 02:21:30', '2020-07-11 09:21:30'),
(70, 6, 1, '', '2020-07-11 02:21:34', '2020-07-11 09:21:34'),
(70, 13, 1, '', '2020-07-11 02:22:21', '2020-07-11 09:22:21'),
(70, 17, 1, '', '2020-07-11 02:21:56', '2020-07-11 09:25:53'),
(70, 18, 0, '', '2020-07-11 02:22:07', '2020-07-11 09:22:07'),
(70, 31, 1, '', '2020-07-11 02:22:18', '2020-07-11 09:22:18'),
(70, 32, 1, '', '2020-07-11 02:22:16', '2020-07-11 09:22:16'),
(70, 36, 3, '', '2020-07-11 02:22:02', '2020-07-11 09:22:02'),
(71, 7, 1, '', '2020-07-11 08:23:31', '2020-07-13 15:23:31'),
(71, 9, 1, '', '2020-07-11 08:23:34', '2020-07-13 15:23:34'),
(71, 10, 1, '', '2020-07-11 08:23:38', '2020-07-13 15:23:38'),
(71, 12, 1, '', '2020-07-11 08:23:40', '2020-07-13 15:23:40'),
(71, 21, 1, '', '2020-07-11 08:23:30', '2020-07-13 15:23:30'),
(71, 27, 3, '', '2020-07-11 08:23:29', '2020-07-13 20:52:25'),
(71, 29, 0, '', '2020-07-11 08:23:39', '2020-07-13 15:23:39'),
(71, 30, 3, '', '2020-07-11 08:23:36', '2020-07-13 15:23:36'),
(71, 34, 1, '', '2020-07-11 08:23:33', '2020-07-13 15:23:33'),
(72, 3, 1, '', '2020-07-10 23:22:34', '2020-07-14 06:22:34'),
(72, 8, 1, '', '2020-07-10 23:22:47', '2020-07-14 06:22:47'),
(72, 11, 1, '', '2020-07-10 23:22:39', '2020-07-14 06:22:39'),
(72, 14, 1, '', '2020-07-10 23:22:40', '2020-07-14 06:22:40'),
(72, 24, 1, '', '2020-07-10 23:22:45', '2020-07-14 06:22:45'),
(72, 26, 1, '', '2020-07-10 23:22:36', '2020-07-14 06:22:36'),
(72, 28, 1, '', '2020-07-10 23:22:32', '2020-07-14 06:22:32'),
(72, 35, 3, '', '2020-07-10 23:22:43', '2020-07-14 06:22:43'),
(74, 7, 1, '', '2020-07-10 23:58:41', '2020-07-15 06:58:41'),
(74, 9, 1, '', '2020-07-10 23:58:44', '2020-07-15 06:58:44'),
(74, 10, 1, '', '2020-07-10 23:58:48', '2020-07-15 06:58:48'),
(74, 12, 1, '', '2020-07-10 23:58:51', '2020-07-15 06:58:51'),
(74, 21, 1, '', '2020-07-10 23:58:39', '2020-07-15 06:58:39'),
(74, 27, 1, '', '2020-07-10 23:58:38', '2020-07-15 06:58:38'),
(74, 29, 1, '', '2020-07-10 23:58:49', '2020-07-15 06:58:49'),
(74, 30, 1, '', '2020-07-10 23:58:46', '2020-07-15 06:58:46'),
(74, 34, 1, '', '2020-07-10 23:58:42', '2020-07-15 06:58:42'),
(75, 3, 1, '', '2020-07-10 03:46:46', '2020-07-16 10:46:46'),
(75, 8, 1, '', '2020-07-10 03:46:57', '2020-07-16 10:46:57'),
(75, 11, 1, '', '2020-07-10 03:46:50', '2020-07-16 10:46:50'),
(75, 14, 1, '', '2020-07-10 03:46:52', '2020-07-16 10:46:52'),
(75, 24, 1, '', '2020-07-10 03:46:55', '2020-07-16 10:46:55'),
(75, 26, 1, '', '2020-07-10 03:46:48', '2020-07-16 10:46:48'),
(75, 28, 1, '', '2020-07-10 03:46:45', '2020-07-16 10:46:45'),
(75, 35, 1, '', '2020-07-10 03:46:53', '2020-07-16 10:46:53'),
(76, 1, 1, '', '2020-07-17 04:17:45', '2020-07-16 11:17:45'),
(76, 6, 1, '', '2020-07-17 04:17:47', '2020-07-16 11:17:47'),
(76, 13, 1, '', '2020-07-17 04:18:00', '2020-07-16 11:18:00'),
(76, 17, 1, '', '2020-07-17 04:17:49', '2020-07-16 11:17:49'),
(76, 18, 1, '', '2020-07-17 04:17:53', '2020-07-16 11:17:53'),
(76, 31, 1, '', '2020-07-17 04:17:59', '2020-07-16 11:17:59'),
(76, 32, 1, '', '2020-07-17 04:17:56', '2020-07-16 11:17:56'),
(76, 36, 1, '', '2020-07-17 04:17:51', '2020-07-16 11:17:51'),
(77, 7, 1, '', '2020-07-15 12:49:03', '2020-07-16 12:49:03'),
(77, 9, 1, '', '2020-07-15 12:49:03', '2020-07-16 12:49:03'),
(77, 10, 1, '', '2020-07-15 12:49:03', '2020-07-16 12:49:03'),
(77, 12, 1, '', '2020-07-15 12:49:03', '2020-07-16 12:49:03'),
(77, 21, 1, '', '2020-07-15 12:49:03', '2020-07-16 12:49:03'),
(77, 27, 1, '', '2020-07-15 12:49:03', '2020-07-16 12:49:03'),
(77, 29, 1, '', '2020-07-15 12:49:03', '2020-07-16 12:49:03'),
(77, 30, 1, '', '2020-07-15 12:49:03', '2020-07-16 12:49:03'),
(77, 34, 1, '', '2020-07-15 12:49:03', '2020-07-16 12:49:03'),
(78, 3, 1, '', '2020-07-04 07:18:24', '2020-07-16 14:18:24'),
(78, 8, 0, '', '2020-07-04 07:18:49', '2020-07-16 14:18:49'),
(78, 11, 3, '', '2020-07-04 07:18:35', '2020-07-16 14:18:35'),
(78, 14, 1, '', '2020-07-04 07:18:39', '2020-07-16 14:18:39'),
(78, 24, 0, '', '2020-07-04 07:18:46', '2020-07-16 14:18:46'),
(78, 26, 2, 'acara keluarga', '2020-07-04 07:18:32', '2020-07-16 14:18:32'),
(78, 28, 1, '', '2020-07-04 07:18:20', '2020-07-16 14:18:20'),
(78, 35, 1, '', '2020-07-04 07:18:42', '2020-07-16 14:18:42'),
(80, 1, 1, '', '2020-07-04 07:21:42', '2020-07-16 14:21:42'),
(80, 6, 1, '', '2020-07-04 07:21:45', '2020-07-16 14:21:45'),
(80, 13, 1, '', '2020-07-04 07:22:09', '2020-07-16 14:22:09'),
(80, 17, 3, '', '2020-07-04 07:21:51', '2020-07-16 14:21:51'),
(80, 18, 0, '', '2020-07-04 07:21:58', '2020-07-16 14:21:58'),
(80, 31, 1, '', '2020-07-04 07:22:05', '2020-07-16 14:22:05'),
(80, 32, 1, '', '2020-07-04 07:22:02', '2020-07-16 14:22:02'),
(80, 36, 1, '', '2020-07-04 07:21:55', '2020-07-16 14:21:55'),
(81, 7, 1, '', '2020-07-16 16:36:10', '2020-07-16 16:36:10'),
(81, 9, 0, '', '2020-07-16 16:36:30', '2020-07-16 16:36:30'),
(81, 10, 1, '', '2020-07-16 16:36:10', '2020-07-16 16:36:10'),
(81, 12, 1, '', '2020-07-16 16:36:10', '2020-07-16 16:36:10'),
(81, 21, 1, '', '2020-07-16 16:36:10', '2020-07-16 16:36:10'),
(81, 27, 1, '', '2020-07-16 16:36:10', '2020-07-16 16:36:10'),
(81, 29, 1, '', '2020-07-16 16:36:10', '2020-07-16 16:36:10'),
(81, 30, 1, '', '2020-07-16 16:36:10', '2020-07-16 16:36:10'),
(81, 34, 1, '', '2020-07-16 16:36:10', '2020-07-16 16:36:10'),
(82, 3, 1, '', '2020-07-25 13:42:44', '2020-07-27 13:42:44'),
(82, 8, 1, '', '2020-07-25 13:42:44', '2020-07-27 13:42:44'),
(82, 11, 1, '', '2020-07-25 13:42:44', '2020-07-27 13:42:44'),
(82, 14, 1, '', '2020-07-25 13:42:44', '2020-07-27 13:42:44'),
(82, 24, 1, '', '2020-07-25 13:42:44', '2020-07-27 13:42:44'),
(82, 26, 1, '', '2020-07-25 13:42:44', '2020-07-27 13:42:44'),
(82, 28, 1, '', '2020-07-25 13:42:44', '2020-07-27 13:42:44'),
(82, 35, 1, '', '2020-07-25 13:42:44', '2020-07-27 13:42:44'),
(83, 1, 1, '', '2020-08-07 06:22:30', '2020-08-03 13:22:30'),
(83, 6, 1, '', '2020-08-07 06:22:31', '2020-08-03 13:22:31'),
(83, 13, 1, '', '2020-08-07 06:22:48', '2020-08-03 13:22:48'),
(83, 17, 1, '', '2020-08-07 06:22:35', '2020-08-03 13:22:35'),
(83, 18, 1, '', '2020-08-07 06:22:39', '2020-08-03 13:22:39'),
(83, 31, 1, '', '2020-08-07 06:22:45', '2020-08-03 13:22:45'),
(83, 32, 1, '', '2020-08-07 06:22:43', '2020-08-03 13:22:43'),
(83, 36, 1, '', '2020-08-07 06:22:37', '2020-08-03 13:22:37'),
(84, 3, 1, '', '2020-09-04 06:55:19', '2020-09-04 06:55:19'),
(84, 8, 1, '', '2020-09-04 06:55:19', '2020-09-04 06:55:19'),
(84, 11, 1, '', '2020-09-04 06:55:19', '2020-09-04 06:55:19'),
(84, 14, 1, '', '2020-09-04 06:55:19', '2020-09-04 06:55:19'),
(84, 24, 1, '', '2020-09-04 06:55:19', '2020-09-04 06:55:19'),
(84, 26, 1, '', '2020-09-04 06:55:19', '2020-09-04 06:55:19'),
(84, 28, 1, '', '2020-09-04 06:55:19', '2020-09-04 06:55:19'),
(84, 35, 1, '', '2020-09-04 06:55:19', '2020-09-04 06:55:19'),
(85, 7, 1, '', '2020-09-04 06:57:22', '2020-09-04 06:57:22'),
(85, 9, 1, '', '2020-09-04 06:57:22', '2020-09-04 06:57:22'),
(85, 10, 1, '', '2020-09-04 06:57:22', '2020-09-04 06:57:22'),
(85, 12, 1, '', '2020-09-04 06:57:22', '2020-09-04 06:57:22'),
(85, 21, 1, '', '2020-09-04 06:57:22', '2020-09-04 06:57:22'),
(85, 27, 0, '', '2020-09-04 06:57:31', '2020-09-04 06:57:31'),
(85, 29, 1, '', '2020-09-04 06:57:22', '2020-09-04 06:57:22'),
(85, 30, 1, '', '2020-09-04 06:57:22', '2020-09-04 06:57:22'),
(85, 34, 1, '', '2020-09-04 06:57:22', '2020-09-04 06:57:22'),
(86, 1, 1, '', '2020-09-18 15:14:30', '2020-09-21 15:14:30'),
(86, 6, 1, '', '2020-09-18 15:14:30', '2020-09-21 15:14:30'),
(86, 13, 1, '', '2020-09-18 15:14:30', '2020-09-21 15:14:30'),
(86, 17, 1, '', '2020-09-18 15:14:30', '2020-09-21 15:14:30'),
(86, 18, 0, '', '2020-09-18 15:14:38', '2020-09-21 15:14:38'),
(86, 31, 1, '', '2020-09-18 15:14:30', '2020-09-21 15:14:30'),
(86, 32, 1, '', '2020-09-18 15:14:30', '2020-09-21 15:14:30'),
(86, 36, 1, '', '2020-09-18 15:14:30', '2020-09-21 15:14:30'),
(87, 1, 1, '', '2020-09-25 11:31:32', '2020-09-23 11:31:32'),
(87, 6, 1, '', '2020-09-25 11:31:32', '2020-09-23 11:31:32'),
(87, 13, 1, '', '2020-09-25 11:31:32', '2020-09-23 11:31:32'),
(87, 17, 1, '', '2020-09-25 11:31:32', '2020-09-23 11:31:32'),
(87, 18, 1, '', '2020-09-25 11:31:32', '2020-09-23 11:31:32'),
(87, 31, 1, '', '2020-09-25 11:31:32', '2020-09-23 11:31:32'),
(87, 32, 1, '', '2020-09-25 11:31:32', '2020-09-23 11:31:32'),
(87, 36, 1, '', '2020-09-25 11:31:32', '2020-09-23 11:31:32'),
(88, 7, 1, '', '2020-09-18 11:32:31', '2020-09-23 11:32:31'),
(88, 9, 0, '', '2020-09-18 11:32:32', '2020-09-23 11:32:32'),
(88, 10, 1, '', '2020-09-18 11:32:31', '2020-09-23 11:32:31'),
(88, 12, 1, '', '2020-09-18 11:32:31', '2020-09-23 11:32:31'),
(88, 21, 1, '', '2020-09-18 11:32:31', '2020-09-23 11:32:31'),
(88, 27, 1, '', '2020-09-18 11:32:31', '2020-09-23 11:32:31'),
(88, 29, 1, '', '2020-09-18 11:32:31', '2020-09-23 11:32:31'),
(88, 30, 1, '', '2020-09-18 11:32:31', '2020-09-23 11:32:31'),
(88, 34, 1, '', '2020-09-18 11:32:31', '2020-09-23 11:32:31'),
(89, 1, 1, '', '2020-09-23 11:33:36', '2020-09-23 11:33:36'),
(89, 6, 1, '', '2020-09-23 11:33:36', '2020-09-23 11:33:36'),
(89, 13, 1, '', '2020-09-23 11:33:36', '2020-09-23 11:33:36'),
(89, 17, 3, '', '2020-09-23 11:33:39', '2020-09-23 11:33:39'),
(89, 18, 1, '', '2020-09-23 11:33:36', '2020-09-23 11:33:36'),
(89, 31, 1, '', '2020-09-23 11:33:36', '2020-09-23 11:33:36'),
(89, 32, 1, '', '2020-09-23 11:33:36', '2020-09-23 11:33:36'),
(89, 36, 1, '', '2020-09-23 11:33:36', '2020-09-23 11:33:36'),
(90, 7, 1, '', '2020-09-23 11:34:00', '2020-09-23 11:34:00'),
(90, 9, 1, '', '2020-09-23 11:34:00', '2020-09-23 11:34:00'),
(90, 10, 1, '', '2020-09-23 11:34:00', '2020-09-23 11:34:00'),
(90, 12, 1, '', '2020-09-23 11:34:00', '2020-09-23 11:34:00'),
(90, 21, 1, '', '2020-09-23 11:34:00', '2020-09-23 11:34:00'),
(90, 27, 1, '', '2020-09-23 11:34:00', '2020-09-23 11:34:00'),
(90, 29, 1, '', '2020-09-23 11:34:00', '2020-09-23 11:34:00'),
(90, 30, 1, '', '2020-09-23 11:34:00', '2020-09-23 11:34:00'),
(90, 34, 1, '', '2020-09-23 11:34:00', '2020-09-23 11:34:00'),
(91, 3, 1, '', '2020-09-23 11:34:24', '2020-09-23 11:34:24'),
(91, 8, 1, '', '2020-09-23 11:34:24', '2020-09-23 11:34:24'),
(91, 11, 1, '', '2020-09-23 11:34:24', '2020-09-23 11:34:24'),
(91, 14, 1, '', '2020-09-23 11:34:24', '2020-09-23 11:34:24'),
(91, 24, 1, '', '2020-09-23 11:34:24', '2020-09-23 11:34:24'),
(91, 26, 1, '', '2020-09-23 11:34:24', '2020-09-23 11:34:24'),
(91, 28, 1, '', '2020-09-23 11:34:24', '2020-09-23 11:34:24'),
(91, 35, 1, '', '2020-09-23 11:34:24', '2020-09-23 11:34:24'),
(92, 3, 1, '', '2020-09-22 11:35:59', '2020-09-23 11:35:59'),
(92, 8, 1, '', '2020-09-22 11:36:00', '2020-09-23 11:36:00'),
(92, 11, 1, '', '2020-09-22 11:36:00', '2020-09-23 11:36:00'),
(92, 14, 1, '', '2020-09-22 11:36:00', '2020-09-23 11:36:00'),
(92, 24, 1, '', '2020-09-22 11:36:00', '2020-09-23 11:36:00'),
(92, 26, 1, '', '2020-09-22 11:36:00', '2020-09-23 11:36:00'),
(92, 28, 0, '', '2020-09-22 11:36:01', '2020-09-23 11:36:01'),
(92, 35, 1, '', '2020-09-22 11:36:00', '2020-09-23 11:36:00'),
(93, 3, 1, '', '2020-09-21 11:36:42', '2020-09-23 11:36:42'),
(93, 8, 1, '', '2020-09-21 11:36:42', '2020-09-23 11:36:42'),
(93, 11, 1, '', '2020-09-21 11:36:42', '2020-09-23 11:36:42'),
(93, 14, 1, '', '2020-09-21 11:36:42', '2020-09-23 11:36:42'),
(93, 24, 2, 'sakit perut mendadak', '2020-09-21 11:36:51', '2020-09-23 11:36:51'),
(93, 26, 1, '', '2020-09-21 11:36:42', '2020-09-23 11:36:42'),
(93, 28, 1, '', '2020-09-21 11:36:42', '2020-09-23 11:36:42'),
(93, 35, 1, '', '2020-09-21 11:36:42', '2020-09-23 11:36:42'),
(94, 1, 1, '', '2020-10-02 06:45:27', '2020-10-12 06:45:27'),
(94, 6, 1, '', '2020-10-02 06:45:27', '2020-10-12 06:45:27'),
(94, 13, 1, '', '2020-10-02 06:45:27', '2020-10-12 06:45:27'),
(94, 17, 1, '', '2020-10-02 06:45:27', '2020-10-12 06:45:27'),
(94, 18, 1, '', '2020-10-02 06:45:27', '2020-10-12 06:45:27'),
(94, 31, 1, '', '2020-10-02 06:45:27', '2020-10-12 06:45:27'),
(94, 32, 2, 'Pulang kampung', '2020-10-02 06:45:38', '2020-10-12 06:45:38'),
(94, 36, 1, '', '2020-10-02 06:45:27', '2020-10-12 06:45:27'),
(95, 1, 1, '', '2020-10-02 09:54:21', '2020-10-12 09:54:21'),
(95, 6, 1, '', '2020-10-02 09:54:21', '2020-10-12 09:54:21'),
(95, 13, 1, '', '2020-10-02 09:54:21', '2020-10-12 09:54:21'),
(95, 17, 1, '', '2020-10-02 09:54:21', '2020-10-12 09:54:21'),
(95, 18, 1, '', '2020-10-02 09:54:21', '2020-10-12 09:54:21'),
(95, 31, 1, '', '2020-10-02 09:54:21', '2020-10-12 09:54:21'),
(95, 32, 2, 'pulang kampung', '2020-10-02 09:54:31', '2020-10-12 09:54:31'),
(95, 36, 1, '', '2020-10-02 09:54:21', '2020-10-12 09:54:21'),
(96, 1, 1, '', '2020-10-23 05:34:08', '2020-10-28 12:34:08'),
(96, 6, 1, '', '2020-10-23 05:34:10', '2020-10-28 12:34:10'),
(96, 13, 1, '', '2020-10-23 05:34:46', '2020-10-28 12:34:46'),
(96, 17, 1, '', '2020-10-23 05:34:21', '2020-10-28 12:34:21'),
(96, 18, 0, '', '2020-10-23 05:34:26', '2020-10-28 12:34:26'),
(96, 31, 1, '', '2020-10-23 05:34:44', '2020-10-28 12:34:44'),
(96, 32, 1, '', '2020-10-23 05:34:29', '2020-10-28 12:34:29'),
(96, 36, 3, '', '2020-10-23 05:34:24', '2020-10-28 12:34:24'),
(97, 3, 1, '', '2020-10-31 05:46:40', '2020-11-01 12:46:40'),
(97, 8, 1, '', '2020-10-31 05:46:51', '2020-11-01 12:46:51'),
(97, 11, 1, '', '2020-10-31 05:46:43', '2020-11-01 12:46:43'),
(97, 14, 1, '', '2020-10-31 05:46:45', '2020-11-01 12:46:45'),
(97, 24, 0, '', '2020-10-31 05:46:49', '2020-11-01 12:46:49'),
(97, 26, 1, '', '2020-10-31 05:46:42', '2020-11-01 12:46:42'),
(97, 28, 1, '', '2020-10-31 05:46:39', '2020-11-01 12:46:39'),
(97, 35, 1, '', '2020-10-31 05:46:47', '2020-11-01 12:46:47'),
(98, 7, 1, '', '2020-11-13 13:01:14', '2020-11-13 13:01:14'),
(98, 9, 1, '', '2020-11-13 13:01:14', '2020-11-13 13:01:14'),
(98, 10, 1, '', '2020-11-13 13:01:14', '2020-11-13 13:01:14'),
(98, 12, 1, '', '2020-11-13 13:01:14', '2020-11-13 13:01:14'),
(98, 21, 1, '', '2020-11-13 13:01:14', '2020-11-13 13:01:14'),
(98, 27, 1, '', '2020-11-13 13:01:14', '2020-11-13 13:01:14'),
(98, 29, 1, '', '2020-11-13 13:01:14', '2020-11-13 13:01:14'),
(98, 30, 1, '', '2020-11-13 13:01:14', '2020-11-13 13:01:14'),
(98, 34, 1, '', '2020-11-13 13:01:14', '2020-11-13 13:01:14'),
(99, 3, 1, '', '2020-11-21 11:55:11', '2020-11-23 11:55:11'),
(99, 8, 1, '', '2020-11-21 11:55:11', '2020-11-23 11:55:11'),
(99, 11, 1, '', '2020-11-21 11:55:11', '2020-11-23 11:55:11'),
(99, 14, 1, '', '2020-11-21 11:55:11', '2020-11-23 11:55:11'),
(99, 24, 1, '', '2020-11-21 11:55:11', '2020-11-23 11:55:11'),
(99, 26, 1, '', '2020-11-21 11:55:11', '2020-11-23 11:55:11'),
(99, 28, 1, '', '2020-11-21 11:55:11', '2020-11-23 11:55:11'),
(99, 35, 1, '', '2020-11-21 11:55:11', '2020-11-23 11:55:11'),
(100, 7, 2, 'izin', '2020-12-24 14:36:19', '2020-12-28 14:36:19'),
(102, 1, 1, '', '2021-01-13 12:19:37', '2021-01-13 12:19:37'),
(102, 6, 1, '', '2021-01-13 12:19:37', '2021-01-13 12:19:37'),
(102, 13, 1, '', '2021-01-13 12:19:37', '2021-01-13 12:19:37'),
(102, 17, 1, '', '2021-01-13 12:19:37', '2021-01-13 12:19:37'),
(102, 18, 1, '', '2021-01-13 12:19:37', '2021-01-13 12:19:37'),
(102, 31, 1, '', '2021-01-13 12:19:37', '2021-01-13 12:19:37'),
(102, 32, 1, '', '2021-01-13 12:19:37', '2021-01-13 12:19:37'),
(102, 36, 1, '', '2021-01-13 12:19:37', '2021-01-13 12:19:37'),
(103, 7, 1, '', '2021-01-13 12:20:10', '2021-01-13 12:20:10'),
(103, 9, 1, '', '2021-01-13 12:20:10', '2021-01-13 12:20:10'),
(103, 10, 1, '', '2021-01-13 12:20:10', '2021-01-13 12:20:10'),
(103, 12, 1, '', '2021-01-13 12:20:10', '2021-01-13 12:20:10'),
(103, 21, 1, '', '2021-01-13 12:20:10', '2021-01-13 12:20:10'),
(103, 27, 1, '', '2021-01-13 12:20:10', '2021-01-13 12:20:10'),
(103, 29, 0, '', '2021-01-13 12:20:13', '2021-01-13 12:20:13'),
(103, 30, 1, '', '2021-01-13 12:20:10', '2021-01-13 12:20:10'),
(103, 34, 1, '', '2021-01-13 12:20:10', '2021-01-13 12:20:10'),
(104, 3, 1, '', '2021-01-13 12:21:08', '2021-01-13 12:21:08'),
(104, 8, 1, '', '2021-01-13 12:21:08', '2021-01-13 12:21:08'),
(104, 11, 1, '', '2021-01-13 12:21:08', '2021-01-13 12:21:08'),
(104, 14, 3, '', '2021-01-13 12:21:15', '2021-01-13 12:21:15'),
(104, 24, 1, '', '2021-01-13 12:21:08', '2021-01-13 12:21:08'),
(104, 26, 1, '', '2021-01-13 12:21:08', '2021-01-13 12:21:08'),
(104, 28, 1, '', '2021-01-13 12:21:08', '2021-01-13 12:21:08'),
(104, 35, 1, '', '2021-01-13 12:21:08', '2021-01-13 12:21:08'),
(105, 1, 1, '', '2021-01-15 15:52:32', '2021-01-15 15:52:32'),
(105, 6, 1, '', '2021-01-15 15:52:32', '2021-01-15 15:52:32'),
(105, 13, 1, '', '2021-01-15 15:52:32', '2021-01-15 15:52:32'),
(105, 17, 1, '', '2021-01-15 15:52:32', '2021-01-15 15:52:32'),
(105, 18, 1, '', '2021-01-15 15:52:32', '2021-01-15 15:52:32'),
(105, 31, 1, '', '2021-01-15 15:52:32', '2021-01-15 15:52:32'),
(105, 32, 1, '', '2021-01-15 15:52:32', '2021-01-15 15:52:32'),
(105, 36, 1, '', '2021-01-15 15:52:32', '2021-01-15 15:52:32'),
(106, 7, 1, '', '2021-01-15 15:53:00', '2021-01-15 15:53:00'),
(106, 9, 1, '', '2021-01-15 15:53:00', '2021-01-15 15:53:00'),
(106, 10, 1, '', '2021-01-15 15:53:00', '2021-01-15 15:53:00'),
(106, 12, 3, '', '2021-01-15 15:53:07', '2021-01-15 15:53:07'),
(106, 21, 1, '', '2021-01-15 15:53:00', '2021-01-15 15:53:00'),
(106, 27, 3, '', '2021-01-15 15:53:05', '2021-01-15 15:53:05'),
(106, 29, 1, '', '2021-01-15 15:53:00', '2021-01-15 15:53:00'),
(106, 30, 1, '', '2021-01-15 15:53:00', '2021-01-15 15:53:00'),
(106, 34, 1, '', '2021-01-15 15:53:00', '2021-01-15 15:53:00'),
(107, 3, 0, '', '2021-01-15 15:53:21', '2021-01-15 15:53:21'),
(107, 8, 1, '', '2021-01-15 15:53:20', '2021-01-15 15:53:20'),
(107, 11, 1, '', '2021-01-15 15:53:20', '2021-01-15 15:53:20'),
(107, 14, 1, '', '2021-01-15 15:53:20', '2021-01-15 15:53:20'),
(107, 24, 0, '', '2021-01-15 15:53:22', '2021-01-15 15:53:22'),
(107, 26, 1, '', '2021-01-15 15:53:20', '2021-01-15 15:53:20'),
(107, 28, 3, '', '2021-01-15 15:53:23', '2021-01-15 15:53:23'),
(107, 35, 1, '', '2021-01-15 15:53:20', '2021-01-15 15:53:20'),
(108, 1, 1, '', '2021-01-18 10:21:31', '2021-01-19 10:21:31'),
(108, 6, 0, '', '2021-01-18 10:21:38', '2021-01-19 10:21:38'),
(108, 13, 1, '', '2021-01-18 10:21:31', '2021-01-19 10:21:31'),
(108, 17, 1, '', '2021-01-18 10:21:31', '2021-01-19 10:21:31'),
(108, 18, 1, '', '2021-01-18 10:21:31', '2021-01-19 10:21:31'),
(108, 31, 1, '', '2021-01-18 10:21:31', '2021-01-19 10:21:31'),
(108, 32, 1, '', '2021-01-18 10:21:31', '2021-01-19 10:21:31'),
(108, 36, 1, '', '2021-01-18 10:21:31', '2021-01-19 10:21:31'),
(109, 1, 1, '', '2021-01-15 09:07:41', '2021-01-20 09:07:41'),
(109, 6, 1, '', '2021-01-15 09:07:41', '2021-01-20 09:07:41'),
(109, 13, 0, '', '2021-01-15 09:07:49', '2021-01-20 09:07:49'),
(109, 17, 1, '', '2021-01-15 09:07:41', '2021-01-20 09:07:41'),
(109, 18, 0, '', '2021-01-15 09:07:49', '2021-01-20 09:07:49'),
(109, 31, 1, '', '2021-01-15 09:07:41', '2021-01-20 09:07:41'),
(109, 32, 3, '', '2021-01-15 09:07:54', '2021-01-20 09:07:54'),
(109, 36, 1, '', '2021-01-15 09:07:41', '2021-01-20 09:07:41'),
(110, 1, 1, '', '2021-01-22 22:04:27', '2021-01-23 22:04:27'),
(110, 6, 1, '', '2021-01-22 22:04:27', '2021-01-23 22:04:27'),
(110, 13, 1, '', '2021-01-22 22:04:27', '2021-01-23 22:04:27'),
(110, 17, 1, '', '2021-01-22 22:04:27', '2021-01-23 22:04:27'),
(110, 18, 1, '', '2021-01-22 22:04:27', '2021-01-23 22:04:27'),
(110, 31, 3, '', '2021-01-22 22:04:51', '2021-01-23 22:04:51'),
(110, 32, 1, '', '2021-01-22 22:04:27', '2021-01-23 22:04:27'),
(110, 36, 1, '', '2021-01-22 22:04:27', '2021-01-23 22:04:27'),
(111, 1, 1, '', '2021-01-22 22:09:00', '2021-01-23 22:09:00'),
(111, 6, 1, '', '2021-01-22 22:09:00', '2021-01-23 22:09:00'),
(111, 13, 1, '', '2021-01-22 22:09:00', '2021-01-23 22:09:00'),
(111, 17, 1, '', '2021-01-22 22:09:00', '2021-01-23 22:09:00'),
(111, 18, 1, '', '2021-01-22 22:09:00', '2021-01-23 22:09:00'),
(111, 31, 3, '', '2021-01-22 22:09:25', '2021-01-23 22:09:25'),
(111, 32, 1, '', '2021-01-22 22:09:00', '2021-01-23 22:09:00'),
(111, 36, 1, '', '2021-01-22 22:09:00', '2021-01-23 22:09:00'),
(112, 1, 1, '', '2021-02-04 19:44:31', '2021-02-04 19:44:31'),
(112, 6, 1, '', '2021-02-04 19:44:31', '2021-02-04 19:44:31'),
(112, 13, 1, '', '2021-02-04 19:44:31', '2021-02-04 19:44:31'),
(112, 17, 1, '', '2021-02-04 19:44:31', '2021-02-04 19:44:31'),
(112, 18, 1, '', '2021-02-04 19:44:31', '2021-02-04 19:44:31'),
(112, 31, 1, '', '2021-02-04 19:44:31', '2021-02-04 19:44:31'),
(112, 32, 1, '', '2021-02-04 19:44:31', '2021-02-04 19:44:31'),
(112, 36, 1, '', '2021-02-04 19:44:31', '2021-02-04 19:44:31'),
(113, 7, 3, '', '2021-02-04 19:44:50', '2021-02-04 19:44:50'),
(113, 9, 1, '', '2021-02-04 19:44:43', '2021-02-04 19:44:43'),
(113, 10, 1, '', '2021-02-04 19:44:43', '2021-02-04 19:44:43'),
(113, 12, 0, '', '2021-02-04 19:44:44', '2021-02-04 19:44:44'),
(113, 21, 1, '', '2021-02-04 19:44:43', '2021-02-04 19:44:43'),
(113, 27, 1, '', '2021-02-04 19:44:43', '2021-02-04 19:44:43'),
(113, 29, 1, '', '2021-02-04 19:44:43', '2021-02-04 19:44:43'),
(113, 30, 1, '', '2021-02-04 19:44:43', '2021-02-04 19:44:43'),
(113, 34, 1, '', '2021-02-04 19:44:43', '2021-02-04 19:44:43'),
(114, 3, 1, '', '2021-02-04 19:45:02', '2021-02-04 19:45:02'),
(114, 8, 1, '', '2021-02-04 19:45:02', '2021-02-04 19:45:02'),
(114, 11, 1, '', '2021-02-04 19:45:02', '2021-02-04 19:45:02'),
(114, 14, 1, '', '2021-02-04 19:45:02', '2021-02-04 19:45:02'),
(114, 24, 1, '', '2021-02-04 19:45:02', '2021-02-04 19:45:02'),
(114, 26, 0, '', '2021-02-04 19:45:05', '2021-02-04 19:45:05'),
(114, 28, 1, '', '2021-02-04 19:45:02', '2021-02-04 19:45:02'),
(114, 35, 0, '', '2021-02-04 19:45:06', '2021-02-04 19:45:06'),
(115, 3, 1, '', '2021-02-03 19:45:18', '2021-02-04 19:45:18'),
(115, 8, 0, '', '2021-02-03 19:45:22', '2021-02-04 19:45:22'),
(115, 11, 1, '', '2021-02-03 19:45:18', '2021-02-04 19:45:18'),
(115, 14, 1, '', '2021-02-03 19:45:18', '2021-02-04 19:45:18'),
(115, 24, 1, '', '2021-02-03 19:45:18', '2021-02-04 19:45:18'),
(115, 26, 1, '', '2021-02-03 19:45:18', '2021-02-04 19:45:18'),
(115, 28, 1, '', '2021-02-03 19:45:18', '2021-02-04 19:45:18'),
(115, 35, 1, '', '2021-02-03 19:45:18', '2021-02-04 19:45:18'),
(116, 1, 1, '', '2021-02-03 19:45:34', '2021-02-04 19:45:34'),
(116, 6, 1, '', '2021-02-03 19:45:34', '2021-02-04 19:45:34'),
(116, 13, 1, '', '2021-02-03 19:45:34', '2021-02-04 19:45:34'),
(116, 17, 2, 'mudik', '2021-02-03 19:45:41', '2021-02-04 19:45:41'),
(116, 18, 1, '', '2021-02-03 19:45:34', '2021-02-04 19:45:34'),
(116, 31, 1, '', '2021-02-03 19:45:34', '2021-02-04 19:45:34'),
(116, 32, 1, '', '2021-02-03 19:45:34', '2021-02-04 19:45:34'),
(116, 36, 1, '', '2021-02-03 19:45:34', '2021-02-04 19:45:34'),
(117, 7, 1, '', '2021-02-03 19:45:52', '2021-02-04 19:45:52'),
(117, 9, 1, '', '2021-02-03 19:45:52', '2021-02-04 19:45:52'),
(117, 10, 1, '', '2021-02-03 19:45:52', '2021-02-04 19:45:52'),
(117, 12, 1, '', '2021-02-03 19:45:52', '2021-02-04 19:45:52'),
(117, 21, 1, '', '2021-02-03 19:45:52', '2021-02-04 19:45:52'),
(117, 27, 1, '', '2021-02-03 19:45:52', '2021-02-04 19:45:52'),
(117, 29, 1, '', '2021-02-03 19:45:52', '2021-02-04 19:45:52'),
(117, 30, 1, '', '2021-02-03 19:45:52', '2021-02-04 19:45:52'),
(117, 34, 1, '', '2021-02-03 19:45:52', '2021-02-04 19:45:52'),
(118, 7, 1, '', '2021-02-02 19:46:07', '2021-02-04 19:46:07'),
(118, 9, 3, '', '2021-02-02 19:46:10', '2021-02-04 19:46:10'),
(118, 10, 1, '', '2021-02-02 19:46:07', '2021-02-04 19:46:07'),
(118, 12, 1, '', '2021-02-02 19:46:07', '2021-02-04 19:46:07'),
(118, 21, 1, '', '2021-02-02 19:46:07', '2021-02-04 19:46:07'),
(118, 27, 1, '', '2021-02-02 19:46:07', '2021-02-04 19:46:07'),
(118, 29, 0, '', '2021-02-02 19:46:12', '2021-02-04 19:46:12'),
(118, 30, 1, '', '2021-02-02 19:46:07', '2021-02-04 19:46:07'),
(118, 34, 1, '', '2021-02-02 19:46:07', '2021-02-04 19:46:07'),
(119, 1, 1, '', '2021-02-02 19:46:22', '2021-02-04 19:46:22'),
(119, 6, 1, '', '2021-02-02 19:46:22', '2021-02-04 19:46:22'),
(119, 13, 1, '', '2021-02-02 19:46:22', '2021-02-04 19:46:22'),
(119, 17, 1, '', '2021-02-02 19:46:22', '2021-02-04 19:46:22'),
(119, 18, 3, '', '2021-02-02 19:46:25', '2021-02-04 19:46:25'),
(119, 31, 1, '', '2021-02-02 19:46:22', '2021-02-04 19:46:22'),
(119, 32, 1, '', '2021-02-02 19:46:22', '2021-02-04 19:46:22'),
(119, 36, 1, '', '2021-02-02 19:46:22', '2021-02-04 19:46:22'),
(120, 3, 1, '', '2021-02-02 19:46:39', '2021-02-04 19:46:39'),
(120, 8, 1, '', '2021-02-02 19:46:39', '2021-02-04 19:46:39'),
(120, 11, 1, '', '2021-02-02 19:46:39', '2021-02-04 19:46:39'),
(120, 14, 1, '', '2021-02-02 19:46:39', '2021-02-04 19:46:39'),
(120, 24, 1, '', '2021-02-02 19:46:39', '2021-02-04 19:46:39'),
(120, 26, 1, '', '2021-02-02 19:46:39', '2021-02-04 19:46:39'),
(120, 28, 1, '', '2021-02-02 19:46:39', '2021-02-04 19:46:39'),
(120, 35, 1, '', '2021-02-02 19:46:39', '2021-02-04 19:46:39'),
(121, 1, 1, '', '2021-02-01 19:47:12', '2021-02-04 19:47:12'),
(121, 6, 0, '', '2021-02-01 19:47:16', '2021-02-04 19:47:16'),
(121, 13, 1, '', '2021-02-01 19:47:12', '2021-02-04 19:47:12'),
(121, 17, 0, '', '2021-02-01 19:47:17', '2021-02-04 19:47:17'),
(121, 18, 1, '', '2021-02-01 19:47:12', '2021-02-04 19:47:12'),
(121, 31, 1, '', '2021-02-01 19:47:12', '2021-02-04 19:47:12'),
(121, 32, 1, '', '2021-02-01 19:47:12', '2021-02-04 19:47:12'),
(121, 36, 1, '', '2021-02-01 19:47:12', '2021-02-04 19:47:12'),
(122, 3, 1, '', '2021-02-01 19:47:32', '2021-02-04 19:47:32'),
(122, 8, 1, '', '2021-02-01 19:47:32', '2021-02-04 19:47:32'),
(122, 11, 1, '', '2021-02-01 19:47:32', '2021-02-04 19:47:32'),
(122, 14, 3, '', '2021-02-01 19:47:34', '2021-02-04 19:47:34'),
(122, 24, 1, '', '2021-02-01 19:47:32', '2021-02-04 19:47:32'),
(122, 26, 3, '', '2021-02-01 19:47:35', '2021-02-04 19:47:35'),
(122, 28, 1, '', '2021-02-01 19:47:32', '2021-02-04 19:47:32'),
(122, 35, 1, '', '2021-02-01 19:47:32', '2021-02-04 19:47:32'),
(123, 7, 1, '', '2021-02-01 19:48:08', '2021-02-04 19:48:08'),
(123, 9, 0, '', '2021-02-01 19:48:10', '2021-02-04 19:48:10'),
(123, 10, 1, '', '2021-02-01 19:48:08', '2021-02-04 19:48:08'),
(123, 12, 3, '', '2021-02-01 19:48:12', '2021-02-04 19:48:12'),
(123, 21, 1, '', '2021-02-01 19:48:08', '2021-02-04 19:48:08'),
(123, 27, 1, '', '2021-02-01 19:48:08', '2021-02-04 19:48:08'),
(123, 29, 1, '', '2021-02-01 19:48:08', '2021-02-04 19:48:08'),
(123, 30, 1, '', '2021-02-01 19:48:08', '2021-02-04 19:48:08'),
(123, 34, 1, '', '2021-02-01 19:48:08', '2021-02-04 19:48:08'),
(124, 1, 1, '', '2021-02-26 02:06:42', '2021-02-27 02:06:42'),
(124, 6, 1, '', '2021-02-26 02:06:42', '2021-02-27 02:06:42'),
(124, 13, 1, '', '2021-02-26 02:06:42', '2021-02-27 02:06:42'),
(124, 17, 1, '', '2021-02-26 02:06:42', '2021-02-27 02:06:42'),
(124, 18, 1, '', '2021-02-26 02:06:42', '2021-02-27 02:06:42'),
(124, 31, 1, '', '2021-02-26 02:06:42', '2021-02-27 02:06:42'),
(124, 32, 1, '', '2021-02-26 02:06:42', '2021-02-27 02:06:42'),
(124, 36, 1, '', '2021-02-26 02:06:42', '2021-02-27 02:06:42'),
(125, 3, 3, '', '2022-02-21 22:34:48', '2022-02-21 22:34:48'),
(125, 8, 1, '', '2022-02-21 22:38:22', '2022-02-21 22:38:22'),
(125, 11, 1, '', '2022-02-21 22:37:58', '2022-02-21 22:37:58'),
(125, 14, 0, '', '2022-02-21 22:36:51', '2022-02-21 22:36:51'),
(125, 24, 3, '', '2022-02-21 22:36:47', '2022-02-21 22:36:47'),
(125, 26, 1, '', '2022-02-21 22:37:57', '2022-02-21 22:37:57'),
(125, 28, 1, '', '2022-02-21 22:23:16', '2022-02-21 22:23:16'),
(125, 35, 1, '', '2022-02-21 22:34:40', '2022-02-21 22:34:40'),
(126, 3, 1, '', '2022-02-21 22:39:02', '2022-02-21 22:39:02'),
(126, 26, 0, '', '2022-02-21 22:39:03', '2022-02-21 22:39:03'),
(126, 28, 1, '', '2022-02-21 22:39:01', '2022-02-21 22:39:01'),
(127, 1, 1, '', '2022-02-22 08:58:37', '2022-02-22 08:58:37'),
(127, 6, 1, '', '2022-02-22 08:58:38', '2022-02-22 08:58:38'),
(127, 13, 1, '', '2022-02-22 08:58:50', '2022-02-22 08:58:50'),
(127, 17, 1, '', '2022-02-22 08:58:40', '2022-02-22 08:58:40'),
(127, 18, 3, '', '2022-02-22 08:58:44', '2022-02-22 08:58:44'),
(127, 31, 1, '', '2022-02-22 08:58:48', '2022-02-22 08:58:48'),
(127, 32, 0, '', '2022-02-22 09:02:13', '2022-02-22 09:02:13'),
(127, 36, 1, '', '2022-02-22 08:58:42', '2022-02-22 08:58:42'),
(129, 7, 1, '', '2022-02-22 09:21:39', '2022-02-22 09:21:39'),
(129, 9, 1, '', '2022-02-22 09:21:51', '2022-02-22 09:21:51'),
(129, 10, 0, '', '2022-02-22 09:21:52', '2022-02-22 09:21:52'),
(129, 12, 1, '', '2022-02-22 09:21:57', '2022-02-22 09:21:57'),
(129, 21, 1, '', '2022-02-22 09:21:37', '2022-02-22 09:21:37'),
(129, 27, 1, '', '2022-02-22 09:21:36', '2022-02-22 09:21:36'),
(129, 29, 1, '', '2022-02-22 09:21:56', '2022-02-22 09:21:56'),
(129, 30, 3, '', '2022-02-22 09:21:54', '2022-02-22 09:21:54'),
(129, 34, 1, '', '2022-02-22 09:21:48', '2022-02-22 09:21:48'),
(130, 3, 1, '', '2022-02-22 12:08:25', '2022-02-22 12:08:25'),
(130, 8, 1, '', '2022-02-22 12:08:25', '2022-02-22 12:08:25'),
(130, 11, 1, '', '2022-02-22 12:08:25', '2022-02-22 12:08:25'),
(130, 14, 1, '', '2022-02-22 12:08:25', '2022-02-22 12:08:25'),
(130, 24, 1, '', '2022-02-22 12:08:25', '2022-02-22 12:08:25'),
(130, 26, 0, '', '2022-02-22 12:11:14', '2022-02-22 12:11:14'),
(130, 28, 1, '', '2022-02-22 12:08:25', '2022-02-22 12:08:25'),
(130, 35, 1, '', '2022-02-22 12:08:25', '2022-02-22 12:08:25'),
(131, 3, 2, 'pulang kampung', '2022-02-14 12:19:58', '2022-02-22 12:19:58'),
(131, 8, 1, '', '2022-02-14 12:19:43', '2022-02-22 12:19:43'),
(131, 11, 1, '', '2022-02-14 12:19:43', '2022-02-22 12:19:43'),
(131, 14, 1, '', '2022-02-14 12:19:43', '2022-02-22 12:19:43'),
(131, 24, 1, '', '2022-02-14 12:19:43', '2022-02-22 12:19:43'),
(131, 26, 3, '', '2022-02-14 12:19:51', '2022-02-22 12:19:51'),
(131, 28, 1, '', '2022-02-14 12:19:43', '2022-02-22 12:19:43'),
(131, 35, 0, '', '2022-02-14 12:20:03', '2022-02-22 12:20:03'),
(132, 3, 0, '', '2022-02-14 12:20:28', '2022-02-22 12:20:28'),
(132, 8, 1, '', '2022-02-14 12:20:26', '2022-02-22 12:20:26'),
(132, 11, 3, '', '2022-02-14 12:20:29', '2022-02-22 12:20:29'),
(132, 14, 1, '', '2022-02-14 12:20:26', '2022-02-22 12:20:26'),
(132, 24, 1, '', '2022-02-14 12:20:26', '2022-02-22 12:20:26'),
(132, 26, 2, 'pulang kampung bareng', '2022-02-14 12:20:42', '2022-02-22 12:20:42'),
(132, 28, 2, 'pulang kampung bareng', '2022-02-14 12:20:42', '2022-02-22 12:20:42'),
(132, 35, 1, '', '2022-02-14 12:20:26', '2022-02-22 12:20:26'),
(133, 3, 3, '', '2022-02-14 21:52:31', '2022-02-22 21:52:31'),
(133, 8, 1, '', '2022-02-14 21:52:29', '2022-02-22 21:52:29'),
(133, 11, 1, '', '2022-02-14 21:52:29', '2022-02-22 21:52:29'),
(133, 14, 1, '', '2022-02-14 21:52:29', '2022-02-22 21:52:29'),
(133, 24, 1, '', '2022-02-14 21:52:29', '2022-02-22 21:52:29'),
(133, 26, 1, '', '2022-02-14 21:52:29', '2022-02-22 21:52:29'),
(133, 28, 1, '', '2022-02-14 21:52:29', '2022-02-22 21:52:29'),
(133, 35, 1, '', '2022-02-14 21:52:29', '2022-02-22 21:52:29'),
(134, 28, 1, '', '2022-02-28 23:32:36', '2022-03-07 23:32:36'),
(135, 28, 1, '', '2022-02-28 23:32:49', '2022-03-07 23:32:49'),
(136, 28, 2, 'keperluan mendesak', '2022-02-28 23:32:57', '2022-03-07 23:32:57');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(7, 'KELAS 10', 'R01', 0, '2020-06-20 03:41:50', '2020-06-20 03:41:50');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(121, 39, 3, 1, 'kamis', 1, '07.55', '08.35', 1, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tb_schedule_settings`
--

CREATE TABLE `tb_schedule_settings` (
  `schedule_setting_id` int(11) NOT NULL,
  `setting_name` varchar(100) DEFAULT NULL,
  `setting_value` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_schedule_settings`
--

INSERT INTO `tb_schedule_settings` (`schedule_setting_id`, `setting_name`, `setting_value`) VALUES
(1, 'lesson_hour', '40'),
(2, 'start_time', '7.25');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_school`
--

INSERT INTO `tb_school` (`school_id`, `school_name`, `school_type`, `school_address`, `school_telephone`, `school_status`, `school_domain`, `school_letterhead`, `created`, `modified`) VALUES
(1, 'SMK Negeri 999 Kota Bekasi', 'Sekolah Manengah Atas', 'Jl. Raya Pekayon No. 30', '(021) 800398493', 1, 'demo.actudent.com', '{\r\n    \"city\": \"Bekasi\",\r\n    \"website\": \"smkn999kotabekasi.sch.id\",\r\n    \"email\": \"smkn999kotabekasi@yahoo.com\",\r\n    \"opd_logo\": \"logo-opd.png\",\r\n    \"school_logo\": \"logo-sekolah.png\",\r\n    \"opd_name\": \"Pemerintah Provinsi Jawa Barat\",\r\n    \"sub_opd_name\": \"Kantor Cabang Dinas Wilayah IV\",\r\n    \"headmaster\": \"Dr. Raihan, M.Pd.\",\r\n    \"headmaster_nip\": \"19631212 198410 1 012\",\r\n    \"co_headmaster\": \"Rino Swastika, S.Pd\",\r\n    \"co_headmaster_nip\": \"19631212 198410 1 012\"\r\n}', '2018-10-09 17:00:00', '2020-07-11 01:32:19');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_score_student`
--

INSERT INTO `tb_score_student` (`score_id`, `student_id`, `score`, `score_note`, `created`, `modified`) VALUES
(1, 1, '85.00', 'sudah bagus sekali ini', '2020-09-18 08:41:05', '2020-09-18 08:41:05'),
(1, 6, '80.00', 'kalah oleh rekannya', '2020-09-18 08:41:05', '2020-09-18 08:41:05'),
(2, 1, '95.00', 'pertahankan prestasimu', '2020-09-18 08:51:18', '2020-09-18 08:51:18'),
(2, 6, '80.00', 'jangan mau kalah oleh teman', '2020-09-18 08:51:18', '2020-09-18 08:51:18'),
(2, 13, '75.00', 'kurang sekali performanya', '2020-09-18 08:51:18', '2020-09-18 08:51:18'),
(2, 17, '78.50', 'lumayan', '2020-09-18 08:51:18', '2020-09-18 08:51:18'),
(3, 1, '90.00', '', '2020-09-18 09:50:16', '2020-09-18 09:50:28'),
(3, 6, '90.00', '', '2020-09-18 09:50:28', '2020-09-18 09:50:28'),
(3, 13, '90.00', '', '2020-09-18 09:50:28', '2020-09-18 09:50:28'),
(3, 17, '80.00', '', '2020-09-18 09:50:28', '2020-09-18 09:50:28'),
(3, 18, '90.00', '', '2020-09-18 09:50:28', '2020-09-18 09:50:36'),
(3, 31, '90.00', '', '2020-09-18 09:50:28', '2020-09-18 09:50:28'),
(3, 32, '90.00', '', '2020-09-18 09:50:28', '2020-09-18 09:50:28');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_staff`
--

INSERT INTO `tb_staff` (`staff_id`, `user_id`, `staff_nik`, `staff_name`, `staff_phone`, `staff_type`, `staff_title`, `staff_photo`, `staff_tag`, `deleted`, `created`, `modified`) VALUES
(1, 4, '123456789', 'Firhan Yudha P.', '08230298484', 'teacher', 'Guru Matematika', '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', 1, 0, '2020-02-12 12:37:26', '2020-02-25 07:03:34'),
(2, 12, '987654321', 'Uus Rusmawan Prasetyo', '083290489348', 'teacher', 'Guru RPL', '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', 1, 0, '2020-02-12 12:38:09', '2020-02-25 07:03:44'),
(3, 13, '2093847283', 'Sudrajat Drajat', '089889878476', 'teacher', 'Guru PKN', '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', 1, 0, '2020-02-23 06:55:07', '2020-07-10 05:00:29'),
(4, 44, '9087657654', 'Rian Mangkulangit', '089878738774', 'teacher', 'Guru Berbudaya', NULL, 1, 0, '2020-03-13 00:11:26', '2020-03-13 00:11:26'),
(5, 45, '7656746298', 'Reinhard Oktora', '087898765723', 'teacher', 'Guru Biologis', NULL, 1, 0, '2020-03-13 00:12:31', '2020-03-13 00:12:31'),
(6, 47, '9878736567', 'Indah Dwi Hartati', '0878676354526', 'teacher', 'Guru IPS', NULL, 1, 0, '2020-04-06 01:39:35', '2020-04-06 01:39:35'),
(7, 48, '9087678365', 'Lintang Sudarmanto', '0897872847681', 'teacher', 'Guru PJOK', NULL, 1, 0, '2020-04-06 01:40:31', '2020-04-06 01:40:31'),
(8, 49, '0929789274', 'Abdal Salem', '0878928878472', 'teacher', 'Guru Nasional', NULL, 1, 0, '2020-04-06 01:43:50', '2020-04-06 01:43:50'),
(9, 50, '2908392849', 'Edwin Susanto', '0893874876277', 'teacher', 'Guru Pemrograman', NULL, 1, 0, '2020-04-17 10:12:27', '2020-04-17 10:12:27'),
(10, 53, '2309849028', 'Muhammad Rizal', '0897384758284', 'teacher', 'Guru Desain Grafis', NULL, 1, 0, '2020-07-10 05:47:57', '2020-07-10 05:47:57');

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
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(24, '1920092093', 'Rian Nurdoni', 1, 0, '2020-03-10 07:35:22', '2020-03-10 07:35:22'),
(25, '1920392890', 'Edwin Zigot', 3, 1, '2020-03-10 07:35:49', '2020-03-11 15:43:42'),
(26, '1928023009', 'Doni Kusumadewi', 1, 0, '2020-03-10 07:36:07', '2020-03-10 07:36:07'),
(27, '1920209189', 'Brendon Rodgers', 1, 0, '2020-03-11 13:06:36', '2020-03-11 13:06:36'),
(28, '1819098198', 'Badrun Simalakama', 1, 0, '2020-03-11 13:06:52', '2020-03-11 13:06:52'),
(29, '1920292038', 'Soleh Nur Majid', 1, 0, '2020-03-11 13:09:27', '2020-03-11 13:09:27'),
(30, '1920908239', 'Rian Sanjaya', 1, 0, '2020-03-11 15:44:20', '2020-03-11 15:44:20'),
(31, '1920093489', 'Taufik Silobahutang', 1, 0, '2020-03-11 15:44:36', '2020-03-11 15:44:36'),
(32, '1920923890', 'Roni Hidayat', 1, 0, '2020-03-11 15:44:53', '2020-03-11 15:44:53'),
(33, '2392830918', 'Sinta Nurlia', 3, 1, '2020-04-03 13:07:18', '2020-04-03 13:07:32'),
(34, '9028394893', 'Raihan Nur Fajri', 1, 0, '2020-07-09 05:39:22', '2020-07-09 05:39:22'),
(35, '1209890328', 'Lala Sintia', 1, 0, '2020-07-09 05:39:44', '2020-07-09 05:39:44'),
(36, '1290809238', 'Indah Purnamasari', 1, 0, '2020-07-09 05:40:18', '2020-07-09 05:40:18');

-- --------------------------------------------------------

--
-- Table structure for table `tb_student_grade`
--

CREATE TABLE `tb_student_grade` (
  `student_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `student_tag` tinyint(1) DEFAULT 1,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_student_grade`
--

INSERT INTO `tb_student_grade` (`student_id`, `grade_id`, `student_tag`, `deleted`, `created`, `modified`) VALUES
(1, 2, 1, 0, '2020-03-11 15:45:20', '2020-03-11 15:45:20'),
(3, 6, 1, 0, '2020-03-11 15:27:58', '2020-03-11 15:27:58'),
(6, 2, 1, 0, '2020-03-11 09:31:05', '2020-03-11 09:31:05'),
(7, 3, 1, 0, '2020-03-11 13:09:58', '2020-03-11 13:09:58'),
(8, 6, 1, 0, '2022-03-03 06:53:58', '2022-03-03 06:53:58'),
(9, 3, 1, 0, '2020-03-11 13:10:18', '2020-03-11 13:10:18'),
(10, 3, 1, 0, '2020-03-12 03:03:47', '2020-03-12 03:03:47'),
(11, 6, 1, 0, '2020-03-11 15:28:00', '2020-03-11 15:28:00'),
(12, 3, 1, 0, '2020-03-11 13:10:16', '2020-03-11 13:10:16'),
(13, 2, 1, 0, '2020-03-12 03:03:41', '2020-03-12 03:03:41'),
(14, 6, 1, 0, '2020-03-20 01:51:14', '2020-03-20 01:51:14'),
(17, 2, 1, 0, '2020-03-11 09:31:02', '2020-03-11 09:31:02'),
(18, 2, 1, 0, '2020-03-11 15:45:23', '2020-03-11 15:45:23'),
(21, 3, 1, 0, '2020-03-11 13:10:00', '2020-03-11 13:10:00'),
(24, 6, 1, 0, '2020-03-11 15:28:02', '2020-03-11 15:28:02'),
(25, 6, 3, 1, '2020-03-11 15:22:16', '2020-04-03 10:51:01'),
(26, 6, 1, 0, '2020-03-12 03:03:30', '2020-03-12 03:03:30'),
(27, 3, 1, 0, '2020-03-11 13:10:20', '2020-03-11 13:10:20'),
(28, 6, 1, 0, '2020-03-11 15:22:14', '2020-03-11 15:22:14'),
(29, 3, 1, 0, '2020-03-11 13:10:17', '2020-03-11 13:10:17'),
(30, 3, 1, 0, '2020-03-12 03:03:49', '2020-03-12 03:03:49'),
(31, 2, 1, 0, '2020-03-12 03:03:42', '2020-03-12 03:03:42'),
(32, 2, 1, 0, '2020-03-11 15:45:25', '2020-03-11 15:45:25'),
(34, 3, 1, 0, '2020-07-09 05:40:59', '2020-07-09 05:40:59'),
(35, 6, 1, 0, '2020-07-09 05:40:43', '2020-07-09 05:40:43'),
(36, 2, 1, 0, '2020-07-09 05:40:51', '2020-07-09 05:40:51');

-- --------------------------------------------------------

--
-- Table structure for table `tb_student_parent`
--

CREATE TABLE `tb_student_parent` (
  `parent_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_student_parent`
--

INSERT INTO `tb_student_parent` (`parent_id`, `student_id`, `deleted`, `created`, `modified`) VALUES
(10, 1, 0, '2020-02-19 10:28:53', '2020-02-19 21:09:16'),
(11, 2, 1, '2020-02-19 10:28:53', '2020-02-19 22:34:07'),
(12, 3, 0, '2020-02-19 10:30:53', '2020-02-19 10:30:53'),
(13, 17, 0, '2020-02-18 14:45:41', '2020-02-18 14:45:41'),
(14, 6, 0, '2020-02-19 10:35:20', '2020-02-19 10:35:20'),
(15, 7, 0, '2020-02-19 10:35:21', '2020-02-19 10:35:21'),
(16, 8, 0, '2020-02-19 10:35:21', '2020-02-19 10:35:21'),
(17, 9, 0, '2020-02-19 10:35:21', '2020-02-19 10:35:21'),
(18, 10, 0, '2020-02-19 10:35:21', '2020-02-19 10:35:21'),
(19, 11, 0, '2020-02-19 10:35:21', '2020-02-19 10:35:21'),
(20, 12, 0, '2020-02-19 10:35:21', '2020-02-19 10:35:21'),
(21, 13, 0, '2020-02-19 10:35:21', '2020-02-19 10:35:21'),
(22, 14, 0, '2020-02-19 10:35:21', '2020-02-19 10:35:21'),
(13, 4, 1, '2020-02-19 10:35:20', '2020-02-19 22:34:07'),
(21, 18, 0, '2020-02-19 11:57:03', '2020-02-19 11:57:03'),
(15, 19, 1, '2020-02-19 21:13:09', '2020-02-19 22:32:55'),
(23, 20, 1, '2020-02-19 21:14:46', '2020-02-19 22:34:08'),
(17, 21, 0, '2020-02-19 21:15:36', '2020-02-19 21:15:36'),
(18, 23, 1, '2020-02-20 11:21:08', '2020-02-20 11:21:38'),
(29, 24, 0, '2020-03-10 14:35:22', '2020-03-10 14:35:22'),
(28, 25, 1, '2020-03-10 14:35:49', '2020-03-11 22:43:42'),
(28, 26, 0, '2020-03-10 14:36:07', '2020-03-10 14:36:07'),
(17, 27, 0, '2020-03-11 20:06:36', '2020-03-11 20:06:36'),
(21, 28, 0, '2020-03-11 20:06:53', '2020-03-11 20:06:53'),
(30, 29, 0, '2020-03-11 20:09:27', '2020-03-11 20:09:27'),
(26, 30, 0, '2020-03-11 22:44:20', '2020-03-11 22:44:20'),
(15, 31, 0, '2020-03-11 22:44:36', '2020-03-11 22:44:36'),
(30, 32, 0, '2020-03-11 22:44:53', '2020-03-11 22:44:53'),
(31, 33, 1, '2020-04-03 20:07:19', '2020-04-03 20:07:32'),
(32, 34, 0, '2020-07-09 12:39:22', '2020-07-09 12:39:22'),
(32, 35, 0, '2020-07-09 12:39:44', '2020-07-09 12:39:44'),
(33, 36, 0, '2020-07-09 12:40:18', '2020-07-09 12:40:18');

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
  `timeline_image` varchar(500) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_timeline`
--

INSERT INTO `tb_timeline` (`timeline_id`, `timeline_title`, `timeline_content`, `timeline_date`, `timeline_status`, `timeline_image`, `user_id`, `created`, `modified`) VALUES
(1, 'Selamat datang di Actudent!', 'Kami warga sekolah sangat bahagia dengan adanya aplikasi ini', '2020-06-30 21:40:29', 'public', 'img_1593528032_857e09b06a5a9d189b74.jpg', 1, '2020-06-25 00:28:57', '2020-06-30 21:40:32'),
(2, 'Ceritakan banyak hal tentang sekolah anda', 'Di dalam fitur timeline ini anda bisa dengan bebas membagikan banyak cerita tentang sekolah anda kepada guru dan orang tua murid yang menggunakan aplikasi Actudent. Jadikan semua informasi up-to date!', '2020-06-30 21:39:29', 'public', 'img_1593527976_53f1c747b348f72f7539.jpg', 1, '2020-06-25 00:30:29', '2020-06-30 21:39:37'),
(3, 'Buat kabar terbaru di mana saja! ', 'Tahukah kamu, postingan ini dibuat hanya dengan menggunakan sebuah ponsel!', '2020-06-30 21:43:08', 'public', 'img_1593528157_93bbdc6e76b3c7cdf617.jpg', 1, '2020-06-30 21:42:33', '2020-06-30 21:43:08'),
(4, 'Istirahat sejenak, mulailah bercerita', 'Luangkan waktu anda dan cobalah untuk lebih banyak berbagi dengan orang di sekitar anda, termasuk para orang tua siswa.', '2020-07-02 00:56:27', 'public', 'img_1593557529_b8eadabe1142c315a8b0.jpg', 1, '2020-06-30 21:45:01', '2020-07-02 00:56:27');

-- --------------------------------------------------------

--
-- Table structure for table `tb_timeline_comments`
--

CREATE TABLE `tb_timeline_comments` (
  `timeline_comment_id` int(11) NOT NULL,
  `timeline_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_parent` int(11) DEFAULT NULL,
  `comment_content` text DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_timeline_likes`
--

CREATE TABLE `tb_timeline_likes` (
  `timeline_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `user_name`, `user_email`, `user_password`, `user_level`, `deleted`, `network`, `created`, `modified`) VALUES
(1, 'Adnan Zaki', 'admin@localhost', '$2y$10$gKk1sx1Jx/cXx2L8BolU4emqDn2Kg/zSr9hqOb7Syo5NpisY.QnwC', 1, 0, 'online', '2018-10-10 17:00:00', '2021-04-04 16:39:11'),
(2, 'Mukhlisin', 'mukliz@wolestech.com', '$2y$10$8n/ojdr/Cb6DjfBIjVKkvekVHXfjXAATlWlnsMZAvV9ioz7Zv/La2', 0, 0, 'offline', '2018-10-30 17:00:00', '2020-06-17 07:20:50'),
(3, 'Dany Prastio', 'danyprastio@wolestech.com', '$2y$10$UpUUj08e6BuSfzOWqUJvQ.Y6ue8CCO/98RKshSx3hJL7OF5tkrpUe', 0, 0, 'offline', '2018-10-30 17:00:00', '2020-06-17 07:20:50'),
(4, 'Firhan Yudha P.', 'firhanyp@localhost', '$2y$10$RpDTs0rJ11ZPpNA/CMMJpeiASVJYwiyRn7KIJ3.oH2yE1gLZ4bqWW', 2, 0, 'online', '2019-03-17 17:00:00', '2022-03-01 16:34:47'),
(12, 'Uus Rusmawan Prasetyo', 'uusrusmawan@smkn11kotabekasi.actudent.com', '$2y$10$TQiPrPCdBHcu9lkcfOTy7eFMmSCrRFmcgNBRjw8viXo2EVyvKxdd2', 0, 0, 'offline', '2019-03-27 17:00:00', '2020-06-17 07:20:50'),
(13, 'Sudrajat', 'sudrajat@demo.actudent.com', '$2y$10$uRTcEtv.NxzipbhTI5mXPOrC7mWw4j7MSOJ5up8gztVR/YqZ.cg5a', 2, 0, 'online', '2019-03-28 17:00:00', '2020-07-10 06:17:32'),
(14, 'Bambang Tri', 'bambang@smkn11kotabekasi.actudent.com', '$2y$10$3qsfIV6tYUkZvCgs6uTu6.X4lnZnLP2.ZVDixeL/Obk0cuRlt0o1S', 0, 1, 'offline', '2020-02-08 05:04:31', '2020-06-17 07:20:50'),
(15, 'Sinto', 'sinto@smkn11kotabekasi.actudent.com', '$2y$10$ZUfIX77V.H8HZYsENgFoH.QhdH8jBpDrzKb3UXCb/yQISzuxTfnvy', 0, 1, 'offline', '2020-02-08 05:06:12', '2020-06-17 07:20:50'),
(16, 'Rizky Nur Hidayat', 'rizkynur@smkn11kotabekasi.actudent.com', '$2y$10$FQnHnmSSTgW6mUYb8B/Lxer3ltbmcBuijIrY4qQr4szfM063heMyC', 0, 1, 'offline', '2020-02-10 02:54:50', '2020-06-17 07:20:50'),
(17, 'Bernard Siahaan', 'bernard@smkn11kotabekasi.actudent.com', '$2y$10$4aBQchBOsJmjj5FSi4q3vOtp1oC4gaoz9FrobyyjgeIagp3SKY9Hy', 0, 1, 'offline', '2020-02-10 03:01:31', '2020-06-17 07:20:50'),
(23, 'Susanto Nurjaman', 'susantonur@smkn11kotabekasi.actudent.com', '$2y$10$OPDJcB9JSaS8m9KnqJbFHOMkC//xz6o69WOTzAIHqyOtZ63/6KE1u', 0, 0, 'offline', '2020-02-10 07:33:09', '2020-06-17 07:20:50'),
(24, 'Ahmad Ridho', 'ahmad.ridho@smkn11kotabekasi.actudent.com', '$2y$10$tiSdWeWFn9.l6KR.JQzkw.G6AEXJtQjwMz7otMwc8zUFwQt49EK/e', 0, 0, 'offline', '2020-02-10 07:34:15', '2020-06-17 07:20:50'),
(25, 'Fahruliansyah', 'fahruliansyah@smkn11kotabekasi.actudent.com', '$2y$10$sHnfCCQmtA1CCsGH5V/v7u5bjbDMhYJcGQ2rhGKeL2Y0mX8YmkkHO', 0, 0, 'offline', '2020-02-10 07:35:17', '2020-06-17 07:20:50'),
(26, 'Andreas Prasetyo', 'andreas.prasetya@smkn11kotabekasi.actudent.com', '$2y$10$f2Vf06NLCbTYGLO2opRWlOcxTsnlRPVpY0dQxeMUwmfYv1ooiiNk2', 0, 0, 'offline', '2020-02-10 07:35:53', '2020-06-17 07:20:50'),
(27, 'Emet Nur Cholis', 'emet.cholis@smkn11kotabekasi.actudent.com', '$2y$10$xeeenDsJ1.U3UaGAXarBWOf2GhtbdXnApe9G9aPfqvfHUlYW1p4Me', 0, 0, 'offline', '2020-02-10 07:38:11', '2020-06-17 07:20:50'),
(28, 'Gledek Nurmantyo', 'gledek.nur@smkn11kotabekasi.actudent.com', '$2y$10$VuBTeKY26z1.ZD7bigwanuBwZawaabZ4nO3/MiOPpWoEQTvbLC0Gi', 0, 0, 'offline', '2020-02-10 08:10:10', '2020-06-17 07:20:50'),
(29, 'asdgvfevbds', 'asdgvfevbds@smkn11kotabekasi.actudent.com', '$2y$10$m6dhzqnTeTeHSapp7ncDweLxGsmCk4cpCVjtMS22XGJx72KMXpG9W', 0, 0, 'offline', '2020-02-10 08:15:03', '2020-06-17 07:20:50'),
(30, 'Badut Siahaan', 'badut.siahaan@demo.actudent.com', '$2y$10$uRTcEtv.NxzipbhTI5mXPOrC7mWw4j7MSOJ5up8gztVR/YqZ.cg5a', 3, 0, 'offline', '2020-02-10 08:16:45', '2020-06-30 08:58:58'),
(31, 'Katmo', 'yuhu@smkn11kotabekasi.actudent.com', '$2y$10$QCZkcT17AjFTDqsMEk5B.OyPaplWSv5JmiN/LfOvH7Doi9hFBjdyu', 0, 0, 'offline', '2020-02-10 08:16:56', '2020-06-17 07:20:50'),
(32, 'Abdi Negara', 'abdinegara@smkn11kotabekasi.actudent.com', '$2y$10$1Lt/0LZQ5UxQxG.QSYJCc.8DKqfiLbIMtpvIfxa/02jiseyS1LmG6', 0, 0, 'offline', '2020-02-10 08:17:14', '2020-06-17 07:20:50'),
(33, 'Yono', 'ahay@smkn11kotabekasi.actudent.com', '$2y$10$fiKYu1o07/j5vAGRdjsbWugXl5msV3KBmh2.3YjP8xGxeDQmsgR4u', 0, 0, 'offline', '2020-02-10 08:17:33', '2020-06-17 07:20:50'),
(34, 'Amran Kartakarun', 'lelejepang@smkn11kotabekasi.actudent.com', '$2y$10$519EUkbcNvfhUDCnMWmU0.gGVBIxTlpvABpYfAbyVjsoaxLUq21GC', 0, 0, 'offline', '2020-02-10 08:17:53', '2020-06-17 07:20:50'),
(35, 'Jajang', 'bedul@smkn11kotabekasi.actudent.com', '$2y$10$VgvRgehTFqw.zT18.WhFneNCRTH6UAh8qosqAMqQQC9qEGBOZUmne', 0, 0, 'offline', '2020-02-10 08:18:10', '2020-06-17 07:20:50'),
(36, 'Sandrayono', 'didikempot@smkn11kotabekasi.actudent.com', '$2y$10$aJ2zsiCmT9vEkp2XeyK1WuVVG4ielaNRMK2C9BTCB/m3UMjl/zxSe', 0, 0, 'offline', '2020-02-10 08:19:23', '2020-06-17 07:20:50'),
(37, 'Anto', 'cekot@smkn11kotabekasi.actudent.com', '$2y$10$Gx4MOrOMnQUf5vUm3SjhXe8RDILcDHjctiEZ6zZxUb6y9GqCPjsZK', 0, 0, 'offline', '2020-02-10 08:19:31', '2020-06-17 07:20:50'),
(38, 'dgjhrsjthj', 'ihi@smkn11kotabekasi.actudent.com', '$2y$10$xSKCnhM0Puv6Ws4.9/lQxuykJf0NLUCRosZHnSNzDBB4ihZ5mvsMa', 0, 0, 'offline', '2020-02-10 08:20:15', '2020-06-17 07:20:50'),
(39, 'Mugiono Apriyani', 'mugiono.apriyani@smkn11kotabekasi.actudent.com', '$2y$10$FSiwxDs87YTx2k44TpACr.DVlvtjQyyAgNApefDpWuer4CC5Dz0Hu', 0, 0, 'offline', '2020-02-10 08:31:25', '2020-06-17 07:20:50'),
(40, 'Linda Sukmawati', 'linda.sukma@smkn11kotabekasi.actudent.com', '$2y$10$RzAC35rNJShVZjB8EYZYoe9UVwu/oGOgZF4XaSu1XgynBlOhpGiZW', 0, 1, 'offline', '2020-02-20 04:25:09', '2020-06-17 07:20:50'),
(41, 'Berry Sihalahua', 'berry.sihala@smkn11kotabekasi.actudent.com', '$2y$10$3p8fGp7UrvUBQgb8eIN9E.rb9DuS0Rco2AFzRdyc1acXFS/b9LRq.', 0, 0, 'offline', '2020-03-10 07:32:22', '2020-06-17 07:20:50'),
(42, 'Abdul Jabbar', 'abduljabbar@smkn11kotabekasi.actudent.com', '$2y$10$GxMQ9W8Oh/urNJteKMQB8uA/lpoSAouTZE4p7xF/F4BFej7BWytl2', 0, 0, 'offline', '2020-03-10 07:34:54', '2020-06-17 07:20:50'),
(43, 'Riko Tantorini', 'rikotanto@smkn11kotabekasi.actudent.com', '$2y$10$MQ8K72/H/xm0l1LCHDXYRuQerQYknJMynU6Dr37Pkl/IuywjVyktS', 0, 0, 'offline', '2020-03-11 13:09:01', '2020-06-17 07:20:50'),
(44, 'Rian Mangkulangit', 'rianmangkulangit@smkn11kotabekasi.actudent.com', '$2y$10$KfyKWSudFaaSQVxByz3jzubP0VQC54lu/njLp3ezC/DXg9oqbUYhG', 0, 0, 'offline', '2020-03-13 00:11:26', '2020-06-17 07:20:50'),
(45, 'Reinhard Oktora', 'reinhard.oktora@smkn11kotabekasi.actudent.com', '$2y$10$Vvnfh0n5jC29K2U3k90h0unCWwc7Sm8jIxo1NKycYe016EctK3cSe', 0, 0, 'offline', '2020-03-13 00:12:31', '2020-06-17 07:20:50'),
(46, 'Baharudin Saifulloh', 'baharsaiful@smkn11kotabekasi.actudent.com', '$2y$10$fmGet4t.IjLkL3.8KgJvpuaMPfwqFKGE.ZEw6A2XCnX2gaN3aqgMi', 0, 1, 'offline', '2020-04-03 13:06:55', '2020-06-17 07:20:50'),
(47, 'Indah Dwi Hartati', 'indahhartati@smkn11kotabekasi.actudent.com', '$2y$10$KKPF1a.COnWa4.6HLI4GWutggcWTNFImmFX.ufjXv3UWtnCKl.GHS', 0, 0, 'offline', '2020-04-06 01:39:35', '2020-06-17 07:20:50'),
(48, 'Lintang Sudarmanto', 'lintangsudarmanto@smkn11kotabekasi.actudent.com', '$2y$10$K7LrXPpLuRs/a8cJjr0muOAz4fht.aeuvJspz2g1v9gCVIsAsq11u', 0, 0, 'offline', '2020-04-06 01:40:30', '2020-06-17 07:20:50'),
(49, 'Abdal Salem', 'abdalsalem@smkn11kotabekasi.actudent.com', '$2y$10$ZdISGSPBBg7k2LjZnLFsJOjhrYiQvM3QdWftzQNj/h.HyALFrJHD.', 0, 0, 'offline', '2020-04-06 01:43:50', '2020-06-17 07:20:50'),
(50, 'Edwin Susanto', 'edwin.susanto@smkn11kotabekasi.actudent.com', '$2y$10$U7FyAdvPZnarAk0molJo2uAZmIlv63vzjdrbZy9Skv8se.bAOfQ2e', 0, 0, 'offline', '2020-04-17 10:12:26', '2020-06-17 07:20:50'),
(51, 'Indri Sintiasari', 'indrisintia@smkn999kotabekasi.actudent.com', '$2y$10$rAUBYcBeGxkhSW2D3lfF.OiNQv2fUbd.tSCygzAYmaFb4albHylAi', 3, 0, 'offline', '2020-07-09 05:36:01', '2020-07-09 05:36:01'),
(52, 'Kartono', 'kartono99@smkn999kotabekasi.actudent.com', '$2y$10$xJ7jc.uJFjrkBagIWzhE5OeUsH5ScATBmt.r5JQ6E9rb4lu5qjHae', 3, 0, 'offline', '2020-07-09 05:37:39', '2020-07-09 05:37:39'),
(53, 'Muhammad Rizal', 'mrizal@demo.actudent.com', '$2y$10$drvBweeuXwGU2j5WpiEYc.IteTmRrpxKdD2JAaluAZ/CEj8.uYz12', 2, 0, 'online', '2020-07-10 05:47:57', '2021-03-15 07:33:18'),
(54, 'Administrator', 'admin@demo.actudent.com', '$2y$10$gKk1sx1Jx/cXx2L8BolU4emqDn2Kg/zSr9hqOb7Syo5NpisY.QnwC', 1, 0, 'online', '2021-02-03 02:45:55', '2021-03-15 06:40:13'),
(55, 'Abdul Majid', 'abdulmajid97@demo.actudent.com', '$2y$10$HzH7jhmpnhT4/GFjT76ZieUO2VF3joByaXh1bdUMIR04it2wDgaPe', 3, 0, 'offline', '2021-05-17 04:29:42', '2021-05-17 04:29:42'),
(56, 'jsndfjsn', 'kjnjfnfj@demo.actudent.com', '$2y$10$I1YR8I.lA1DqE33igLMKZOOmRaETKcvNE9MWVSupo9n2Js4aKX0OG', 3, 0, 'offline', '2021-05-17 08:06:27', '2021-05-17 08:06:27'),
(57, 'Ibnu Kamil', 'ibnukamil87@demo.actudent.com', '$2y$10$ZWMk7ceGzAWmmSvP6usSjuUOpqdrHSZEhV0s.xHryn25ZWmXV1/p6', 3, 0, 'offline', '2021-05-17 08:28:06', '2021-05-17 08:28:06'),
(58, 'Ahmad Hasan ', 'rinapuspita@demo.actudent.com', '$2y$10$M7nn0bSfzdNeWGX8CQU7HOaBCej3f8TZbqg80P1PzqAe/AVP0x2dq', 3, 0, 'offline', '2021-05-17 08:30:35', '2021-05-17 08:30:35'),
(59, 'Ahmad Fajrul', 'rinarosinta@demo.actudent.com', '$2y$10$rlLUPusxbvy2apBACoZESeopwNw4VAPSJ4SUk78mUOs.r2Up2h5i6', 3, 0, 'offline', '2021-05-17 08:31:31', '2021-05-17 08:31:31'),
(60, 'Rima Nurmala', 'rimanurmala@demo.actudent.com', '$2y$10$wVX5tG1g.54Az.Crlhafpe.WGqn8LriawV8ZuAmMEJ77H4vCWsKQa', 3, 0, 'offline', '2021-05-17 10:28:06', '2021-05-17 10:28:06'),
(61, 'Adi Sumarno', 'adi_sumarno@demo.actudent.com', '$2y$10$VLnn68bLggBLVPnZN0T69O/iHH0Tj6NuMA9L80MyFiH8jhmLaTt3y', 3, 0, 'offline', '2021-05-17 10:44:07', '2021-05-17 10:44:07'),
(62, 'Hamdan Syakirin', 'hamdans@demo.actudent.com', '$2y$10$hn1XSqIpxicTxlOznrNIv.UQ9ODXxwh09otNbLZKGBPM/l/rGILF2', 3, 0, 'offline', '2021-05-17 10:48:17', '2021-05-17 10:48:17'),
(63, 'Hamdan Naimin', 'hamdanna@demo.actudent.com', '$2y$10$dweEpb382S4Y6V.uVi5XYOcvEUYDnlpheqPpNmcU1DTWgmwD6FF9m', 3, 0, 'offline', '2021-05-17 10:57:22', '2021-05-17 10:57:22'),
(64, 'Syarif Romadhon', 'syarif_r192@demo.actudent.com', '$2y$10$8kS86VVcEX8dp9qYJolqNuO18GWOD7dFsgLoVHYqAe4L2A99//Zmu', 3, 0, 'offline', '2021-05-17 12:56:31', '2021-05-17 12:56:31'),
(65, 'Izzatul Islam', 'izzatul_islam@demo.actudent.com', '$2y$10$OXaD.DmIdONG/9LvqCaaP.yHDvZbSuHF6I7zMLcDJPyhMBP9O5biO', 3, 0, 'offline', '2021-05-17 13:04:32', '2021-05-17 13:04:32'),
(66, 'Abdul Fattah', 'abdulfattah@demo.actudent.com', '$2y$10$a8UdokSBwOoIGUdrkTHhkODvY9p3Qw208zyDE3fcW1Tue/6uFH.5q', 3, 0, 'offline', '2021-05-17 13:05:20', '2021-05-17 13:05:20'),
(67, 'Himdin', 'himdin982@demo.actudent.com', '$2y$10$dCgnt6HfDhFtB.xor0sBqOfPPjlk7C/JArrPyAIeqI5.S/aETK0Ly', 3, 0, 'offline', '2021-05-17 13:09:31', '2021-05-17 13:09:31'),
(68, 'Huntu', 'huntu92@demo.actudent.com', '$2y$10$9ldHEXaRC.nBLCaeUnUF0.eNDSrLfBtpicebe2sPQly/.Wc0YxFi.', 3, 0, 'offline', '2021-05-18 05:25:52', '2021-05-18 05:25:52');

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
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Indexes for table `tb_agenda_user`
--
ALTER TABLE `tb_agenda_user`
  ADD PRIMARY KEY (`agenda_id`);

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
  ADD KEY `timeline_author` (`user_id`);

--
-- Indexes for table `tb_timeline_comments`
--
ALTER TABLE `tb_timeline_comments`
  ADD PRIMARY KEY (`timeline_comment_id`),
  ADD KEY `fk_timeline` (`timeline_id`),
  ADD KEY `comment_author` (`user_id`);

--
-- Indexes for table `tb_timeline_likes`
--
ALTER TABLE `tb_timeline_likes`
  ADD PRIMARY KEY (`timeline_id`,`user_id`),
  ADD KEY `like_author` (`user_id`);

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
  MODIFY `agenda_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

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
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_journal`
--
ALTER TABLE `tb_journal`
  MODIFY `journal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `tb_lessons`
--
ALTER TABLE `tb_lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_lessons_grade`
--
ALTER TABLE `tb_lessons_grade`
  MODIFY `lessons_grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tb_parent`
--
ALTER TABLE `tb_parent`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tb_room`
--
ALTER TABLE `tb_room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_schedule`
--
ALTER TABLE `tb_schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `tb_schedule_settings`
--
ALTER TABLE `tb_schedule_settings`
  MODIFY `schedule_setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_school`
--
ALTER TABLE `tb_school`
  MODIFY `school_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_score`
--
ALTER TABLE `tb_score`
  MODIFY `score_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_staff`
--
ALTER TABLE `tb_staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_student`
--
ALTER TABLE `tb_student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tb_timeline`
--
ALTER TABLE `tb_timeline`
  MODIFY `timeline_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_timeline_comments`
--
ALTER TABLE `tb_timeline_comments`
  MODIFY `timeline_comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_timelog`
--
ALTER TABLE `tb_timelog`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

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
-- Constraints for table `tb_agenda_user`
--
ALTER TABLE `tb_agenda_user`
  ADD CONSTRAINT `fk_agenda` FOREIGN KEY (`agenda_id`) REFERENCES `tb_agenda` (`agenda_id`);

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
  ADD CONSTRAINT `timeline_author` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_timeline_comments`
--
ALTER TABLE `tb_timeline_comments`
  ADD CONSTRAINT `comment_author` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`),
  ADD CONSTRAINT `fk_timeline` FOREIGN KEY (`timeline_id`) REFERENCES `tb_timeline` (`timeline_id`);

--
-- Constraints for table `tb_timeline_likes`
--
ALTER TABLE `tb_timeline_likes`
  ADD CONSTRAINT `fk_timeline_like` FOREIGN KEY (`timeline_id`) REFERENCES `tb_timeline` (`timeline_id`),
  ADD CONSTRAINT `like_author` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_user_devices`
--
ALTER TABLE `tb_user_devices`
  ADD CONSTRAINT `user_device` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
