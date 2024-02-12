-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2024 at 05:43 AM
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
-- Database: `db_actudent_main`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_installation`
--

CREATE TABLE `tb_installation` (
  `id` int(11) NOT NULL,
  `db_group_key` varchar(100) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_installation`
--

INSERT INTO `tb_installation` (`id`, `db_group_key`, `created`, `modified`) VALUES
(11, 'localhost', '2024-01-16 08:01:25', '2024-01-16 08:01:25');

-- --------------------------------------------------------

--
-- Table structure for table `tb_notification`
--

CREATE TABLE `tb_notification` (
  `notif_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `notif_from` varchar(500) DEFAULT NULL,
  `notif_to` text DEFAULT NULL,
  `notif_title` varchar(300) DEFAULT NULL,
  `notif_body` varchar(500) DEFAULT NULL,
  `notif_data` text DEFAULT NULL,
  `notif_sent` tinyint(4) NOT NULL DEFAULT 0,
  `notif_read` tinyint(4) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_notification`
--

INSERT INTO `tb_notification` (`notif_id`, `user_id`, `notif_from`, `notif_to`, `notif_title`, `notif_body`, `notif_data`, `notif_sent`, `notif_read`, `created`, `modified`) VALUES
(57, 30, 'smkn11kotabekasi.actudent.com', 'fj1a5_qNRe2ZKhdsDhXisi:APA91bEU_ghoaFV942Cy3QCsD9Q_ZduTCooSlUW9_q_R7rrYP3QJYqnfIebQUazqfnMgg3WwFWAoRYnztFFsxNVXzy8NDCxCy_OH32ZxZXh63sIt2IsHuUs-EiCzOdTCkVBUTS6TI05V', 'Status Kehadiran', '08 Jun 2020: Brendon Rodgers telah tiba di sekolah', NULL, 1, 0, '2020-06-13 08:50:38', '2020-06-13 17:30:01'),
(58, 30, 'smkn11kotabekasi.actudent.com', 'fj1a5_qNRe2ZKhdsDhXisi:APA91bEU_ghoaFV942Cy3QCsD9Q_ZduTCooSlUW9_q_R7rrYP3QJYqnfIebQUazqfnMgg3WwFWAoRYnztFFsxNVXzy8NDCxCy_OH32ZxZXh63sIt2IsHuUs-EiCzOdTCkVBUTS6TI05V', 'Status Kehadiran', '09 Jun 2020: Brendon Rodgers telah tiba di sekolah', NULL, 1, 0, '2020-06-13 08:50:38', '2020-06-13 17:30:02'),
(59, 30, 'smkn11kotabekasi.actudent.com', 'fj1a5_qNRe2ZKhdsDhXisi:APA91bEU_ghoaFV942Cy3QCsD9Q_ZduTCooSlUW9_q_R7rrYP3QJYqnfIebQUazqfnMgg3WwFWAoRYnztFFsxNVXzy8NDCxCy_OH32ZxZXh63sIt2IsHuUs-EiCzOdTCkVBUTS6TI05V', 'Status Kehadiran', '10 Jun 2020: Brendon Rodgers telah tiba di sekolah', NULL, 1, 0, '2020-06-13 08:50:38', '2020-06-13 17:32:01'),
(60, 30, 'demo.actudent.com', 'eDX0-axlQJy3FKyRv1Nh_P:APA91bHgrYR2cbyV85tfvWquwARiQX6S5Rcb5M0ORjBy_98rHmiEQQOkigGVh5LA414MUYtD6tmHWRIzXVstbKR-TKVfEDmSbpbP32GNh6rdFDzWlBk4iXMoQ5YRV6VgS7gHI0YXOaBV', 'Kehadiran Mata Pelajaran', 'Brendon Rodgers mengikuti mata pelajaran Fisika', NULL, 1, 0, '2020-06-30 22:59:29', '2020-06-30 23:00:01'),
(61, 30, 'demo.actudent.com', 'eDX0-axlQJy3FKyRv1Nh_P:APA91bHgrYR2cbyV85tfvWquwARiQX6S5Rcb5M0ORjBy_98rHmiEQQOkigGVh5LA414MUYtD6tmHWRIzXVstbKR-TKVfEDmSbpbP32GNh6rdFDzWlBk4iXMoQ5YRV6VgS7gHI0YXOaBV', 'Kehadiran Mata Pelajaran', 'Johnson Simatupang mengikuti mata pelajaran Fisika', NULL, 1, 0, '2020-06-30 22:59:31', '2020-06-30 23:00:01'),
(62, 30, 'demo.actudent.com', 'eDX0-axlQJy3FKyRv1Nh_P:APA91bHgrYR2cbyV85tfvWquwARiQX6S5Rcb5M0ORjBy_98rHmiEQQOkigGVh5LA414MUYtD6tmHWRIzXVstbKR-TKVfEDmSbpbP32GNh6rdFDzWlBk4iXMoQ5YRV6VgS7gHI0YXOaBV', 'Kehadiran Mata Pelajaran', 'Raju Herningtyas Pratama tidak mengikuti mata pelajaran Fisika dikarenakan sakit', NULL, 1, 0, '2020-06-30 22:59:48', '2020-06-30 23:00:01'),
(63, 30, 'demo.actudent.com', 'eDX0-axlQJy3FKyRv1Nh_P:APA91bHgrYR2cbyV85tfvWquwARiQX6S5Rcb5M0ORjBy_98rHmiEQQOkigGVh5LA414MUYtD6tmHWRIzXVstbKR-TKVfEDmSbpbP32GNh6rdFDzWlBk4iXMoQ5YRV6VgS7gHI0YXOaBV', 'Kehadiran Mata Pelajaran', 'Brendon Rodgers mengikuti mata pelajaran Fisika', NULL, 1, 0, '2020-06-30 23:00:42', '2020-06-30 23:01:01'),
(64, 30, 'demo.actudent.com', 'eDX0-axlQJy3FKyRv1Nh_P:APA91bHgrYR2cbyV85tfvWquwARiQX6S5Rcb5M0ORjBy_98rHmiEQQOkigGVh5LA414MUYtD6tmHWRIzXVstbKR-TKVfEDmSbpbP32GNh6rdFDzWlBk4iXMoQ5YRV6VgS7gHI0YXOaBV', 'Kehadiran Mata Pelajaran', 'Brendon Rodgers mengikuti mata pelajaran Fisika', NULL, 1, 0, '2020-06-30 23:01:18', '2020-06-30 23:02:01'),
(65, 30, 'demo.actudent.com', 'eDX0-axlQJy3FKyRv1Nh_P:APA91bHgrYR2cbyV85tfvWquwARiQX6S5Rcb5M0ORjBy_98rHmiEQQOkigGVh5LA414MUYtD6tmHWRIzXVstbKR-TKVfEDmSbpbP32GNh6rdFDzWlBk4iXMoQ5YRV6VgS7gHI0YXOaBV', 'Kehadiran Mata Pelajaran', 'Johnson Simatupang mengikuti mata pelajaran Fisika', NULL, 1, 0, '2020-06-30 23:01:19', '2020-06-30 23:02:01'),
(66, 30, 'demo.actudent.com', 'eDX0-axlQJy3FKyRv1Nh_P:APA91bHgrYR2cbyV85tfvWquwARiQX6S5Rcb5M0ORjBy_98rHmiEQQOkigGVh5LA414MUYtD6tmHWRIzXVstbKR-TKVfEDmSbpbP32GNh6rdFDzWlBk4iXMoQ5YRV6VgS7gHI0YXOaBV', 'Kehadiran Mata Pelajaran', 'Raju Herningtyas Pratama tidak mengikuti mata pelajaran Fisika tanpa keterangan (Alfa)', NULL, 1, 0, '2020-06-30 23:01:26', '2020-06-30 23:02:01'),
(67, 30, 'demo.actudent.com', 'eDX0-axlQJy3FKyRv1Nh_P:APA91bHgrYR2cbyV85tfvWquwARiQX6S5Rcb5M0ORjBy_98rHmiEQQOkigGVh5LA414MUYtD6tmHWRIzXVstbKR-TKVfEDmSbpbP32GNh6rdFDzWlBk4iXMoQ5YRV6VgS7gHI0YXOaBV', 'Kehadiran Mata Pelajaran', 'Brendon Rodgers tidak mengikuti mata pelajaran Fisika tanpa keterangan (Alfa)', NULL, 1, 0, '2020-06-30 23:04:43', '2020-06-30 23:05:01'),
(68, 30, 'demo.actudent.com', 'eDX0-axlQJy3FKyRv1Nh_P:APA91bHgrYR2cbyV85tfvWquwARiQX6S5Rcb5M0ORjBy_98rHmiEQQOkigGVh5LA414MUYtD6tmHWRIzXVstbKR-TKVfEDmSbpbP32GNh6rdFDzWlBk4iXMoQ5YRV6VgS7gHI0YXOaBV', 'Pemberitahuan Tugas Baru', 'Matematika: Tugas Harian 1 telah terbit, batas waktu pengumpulan tugas 08 Jul 2020', NULL, 1, 0, '2020-06-30 23:46:36', '2020-06-30 23:47:02'),
(69, 30, 'demo.actudent.com', 'eDX0-axlQJy3FKyRv1Nh_P:APA91bHgrYR2cbyV85tfvWquwARiQX6S5Rcb5M0ORjBy_98rHmiEQQOkigGVh5LA414MUYtD6tmHWRIzXVstbKR-TKVfEDmSbpbP32GNh6rdFDzWlBk4iXMoQ5YRV6VgS7gHI0YXOaBV', 'Kehadiran Mata Pelajaran', 'Brendon Rodgers tidak mengikuti mata pelajaran Fisika tanpa keterangan (Alfa)', NULL, 1, 0, '2020-07-01 00:24:48', '2020-07-01 00:25:01'),
(70, 30, 'demo.actudent.com', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 'Kehadiran Mata Pelajaran', 'Brendon Rodgers mengikuti mata pelajaran Desain Grafis', NULL, 1, 0, '2020-07-13 08:23:29', '2020-07-13 08:24:01'),
(71, 30, 'demo.actudent.com', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 'Kehadiran Mata Pelajaran', 'Johnson Simatupang mengikuti mata pelajaran Desain Grafis', NULL, 1, 0, '2020-07-13 08:23:30', '2020-07-13 08:24:01'),
(72, 30, 'demo.actudent.com', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 'Kehadiran Mata Pelajaran', 'Raju Herningtyas Pratama mengikuti mata pelajaran Desain Grafis', NULL, 1, 0, '2020-07-13 08:23:34', '2020-07-13 08:24:01'),
(73, 30, 'demo.actudent.com', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 'Kehadiran Mata Pelajaran', 'Brendon Rodgers tidak mengikuti mata pelajaran Desain Grafis dikarenakan sakit', NULL, 1, 0, '2020-07-13 13:52:25', '2020-07-13 13:53:01'),
(74, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'mengikuti pelajaran', NULL, 0, 0, '2020-07-16 03:17:54', '2020-07-16 03:17:54'),
(75, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'Raju Herningtyas Pratamamengikuti pelajaranBahasa Indonesia', NULL, 0, 0, '2020-07-16 03:34:58', '2020-07-16 03:34:58'),
(76, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'Raju Herningtyas Pratama tidak mengikuti pelajaran Bahasa Indonesia', NULL, 0, 0, '2020-07-16 03:36:16', '2020-07-16 03:36:16'),
(77, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'Raju Herningtyas Pratama mengikuti pelajaran Bahasa Indonesia', NULL, 0, 0, '2020-07-16 03:42:28', '2020-07-16 03:42:28'),
(78, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'Brendon Rodgers mengikuti pelajaran Bahasa Indonesia', NULL, 0, 0, '2020-07-16 03:42:28', '2020-07-16 03:42:28'),
(79, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'Raju Herningtyas Pratama mengikuti pelajaran Bahasa Indonesia', NULL, 0, 0, '2020-07-16 03:59:52', '2020-07-16 03:59:52'),
(80, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'Johnson Simatupang mengikuti pelajaran Bahasa Indonesia', NULL, 0, 0, '2020-07-16 03:59:52', '2020-07-16 03:59:52'),
(81, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'Brendon Rodgers mengikuti pelajaran Bahasa Indonesia', NULL, 0, 0, '2020-07-16 03:59:52', '2020-07-16 03:59:52'),
(82, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Pemberitahuan Tugas Baru untuk Raju Herningtyas Pratama', 'X TKJ 1: Tugas harian 3 telah terbit, batas pengumpulan tugas Invalid date input: <b>2020-7-14</b>', NULL, 0, 0, '2020-07-16 04:27:02', '2020-07-16 04:27:02'),
(83, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Pemberitahuan Tugas Baru untuk Johnson Simatupang', 'X TKJ 1: Tugas harian 3 telah terbit, batas pengumpulan tugas Invalid date input: <b>2020-7-14</b>', NULL, 0, 0, '2020-07-16 04:27:02', '2020-07-16 04:27:02'),
(84, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Pemberitahuan Tugas Baru untuk Brendon Rodgers', 'X TKJ 1: Tugas harian 3 telah terbit, batas pengumpulan tugas Invalid date input: <b>2020-7-14</b>', NULL, 0, 0, '2020-07-16 04:27:02', '2020-07-16 04:27:02'),
(85, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Pemberitahuan Tugas Baru untuk Raju Herningtyas Pratama', 'X TKJ 1: Latihan 1 telah terbit, batas pengumpulan tugas Selasa, 14 Juli 2020', NULL, 0, 0, '2020-07-16 04:29:50', '2020-07-16 04:29:50'),
(86, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Pemberitahuan Tugas Baru untuk Johnson Simatupang', 'X TKJ 1: Latihan 1 telah terbit, batas pengumpulan tugas Selasa, 14 Juli 2020', NULL, 0, 0, '2020-07-16 04:29:50', '2020-07-16 04:29:50'),
(87, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Pemberitahuan Tugas Baru untuk Brendon Rodgers', 'X TKJ 1: Latihan 1 telah terbit, batas pengumpulan tugas Selasa, 14 Juli 2020', NULL, 0, 0, '2020-07-16 04:29:51', '2020-07-16 04:29:51'),
(88, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Pemberitahuan Tugas Baru untuk Raju Herningtyas Pratama', 'Bahasa Indonesia: Tugas harian 12 telah terbit, batas pengumpulan tugas Selasa, 14 Juli 2020', NULL, 0, 0, '2020-07-16 04:38:53', '2020-07-16 04:38:53'),
(89, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Pemberitahuan Tugas Baru untuk Johnson Simatupang', 'Bahasa Indonesia: Tugas harian 12 telah terbit, batas pengumpulan tugas Selasa, 14 Juli 2020', NULL, 0, 0, '2020-07-16 04:38:53', '2020-07-16 04:38:53'),
(90, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Pemberitahuan Tugas Baru untuk Brendon Rodgers', 'Bahasa Indonesia: Tugas harian 12 telah terbit, batas pengumpulan tugas Selasa, 14 Juli 2020', NULL, 0, 0, '2020-07-16 04:38:53', '2020-07-16 04:38:53'),
(91, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'Raju Herningtyas Pratama mengikuti pelajaran Bahasa Indonesia', NULL, 0, 0, '2020-07-16 04:43:57', '2020-07-16 04:43:57'),
(92, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'Raju Herningtyas Pratama tidak mengikuti pelajaran Bahasa Indonesia', NULL, 0, 0, '2020-07-16 05:15:19', '2020-07-16 05:15:19'),
(93, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'Raju Herningtyas Pratama mengikuti pelajaran Bahasa Indonesia', NULL, 0, 0, '2020-07-16 05:22:01', '2020-07-16 05:22:01'),
(94, 51, 'smkn11kotabekasi.actudent.com', 'fhOk-f5zRmezHH5WoW9LIm:APA91bGzEQw8GACRUzwHDnKA3fBO6AgdEZi2-m0ORkQjJufKpGdb7NNd5dPCc2mRkprifnzXhoNP7bpDBIqvQHSBRbbfv7JheZph1f65GWTeTi6eh6Rh_uhZun2Ln4ag_GXWOz8yshpG', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan percobaan ke sekian', NULL, 0, 0, '2020-07-16 05:32:11', '2020-07-16 05:32:11'),
(95, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan percobaan ke sekian', NULL, 0, 0, '2020-07-16 05:32:11', '2020-07-16 05:32:11'),
(96, 51, 'smkn11kotabekasi.actudent.com', 'fhOk-f5zRmezHH5WoW9LIm:APA91bGzEQw8GACRUzwHDnKA3fBO6AgdEZi2-m0ORkQjJufKpGdb7NNd5dPCc2mRkprifnzXhoNP7bpDBIqvQHSBRbbfv7JheZph1f65GWTeTi6eh6Rh_uhZun2Ln4ag_GXWOz8yshpG', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan bau ketek lu', NULL, 0, 0, '2020-07-16 05:34:38', '2020-07-16 05:34:38'),
(97, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan bau ketek lu', NULL, 0, 0, '2020-07-16 05:34:38', '2020-07-16 05:34:38'),
(98, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Acara akhir bulan, makan indomie', NULL, 0, 0, '2020-07-16 05:37:12', '2020-07-16 05:37:12'),
(99, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'Raju Herningtyas Pratama mengikuti pelajaran Pemrograman Dasar', NULL, 0, 0, '2020-07-20 06:02:26', '2020-07-20 06:02:26'),
(100, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'Johnson Simatupang mengikuti pelajaran Pemrograman Dasar', NULL, 0, 0, '2020-07-20 06:02:27', '2020-07-20 06:02:27'),
(101, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'Brendon Rodgers mengikuti pelajaran Pemrograman Dasar', NULL, 0, 0, '2020-07-20 06:02:27', '2020-07-20 06:02:27'),
(102, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'Raju Herningtyas Pratama tidak mengikuti pelajaran Pemrograman Dasar', NULL, 0, 0, '2020-07-20 06:02:54', '2020-07-20 06:02:54'),
(103, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Pemberitahuan Tugas Baru untuk Raju Herningtyas Pratama', 'Pemrograman Dasar: Membuat pseudo-code aplikasi peminjaman buku telah terbit, batas pengumpulan tugas Senin, 20 Juli 2020', NULL, 0, 0, '2020-07-20 06:04:20', '2020-07-20 06:04:20'),
(104, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Pemberitahuan Tugas Baru untuk Johnson Simatupang', 'Pemrograman Dasar: Membuat pseudo-code aplikasi peminjaman buku telah terbit, batas pengumpulan tugas Senin, 20 Juli 2020', NULL, 0, 0, '2020-07-20 06:04:21', '2020-07-20 06:04:21'),
(105, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Pemberitahuan Tugas Baru untuk Brendon Rodgers', 'Pemrograman Dasar: Membuat pseudo-code aplikasi peminjaman buku telah terbit, batas pengumpulan tugas Senin, 20 Juli 2020', NULL, 0, 0, '2020-07-20 06:04:21', '2020-07-20 06:04:21'),
(106, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'Raju Herningtyas Pratama mengikuti pelajaran Bahasa Indonesia', NULL, 0, 0, '2020-12-29 09:25:17', '2020-12-29 09:25:17'),
(107, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'Johnson Simatupang mengikuti pelajaran Bahasa Indonesia', NULL, 0, 0, '2020-12-29 09:25:17', '2020-12-29 09:25:17'),
(108, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'Brendon Rodgers mengikuti pelajaran Bahasa Indonesia', NULL, 0, 0, '2020-12-29 09:25:18', '2020-12-29 09:25:18'),
(109, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'Brendon Rodgers tidak mengikuti pelajaran Bahasa Indonesia', NULL, 0, 0, '2020-12-29 09:25:26', '2020-12-29 09:25:26'),
(110, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'Raju Herningtyas Pratama mengikuti pelajaran Matematika', NULL, 0, 0, '2021-01-27 16:00:56', '2021-01-27 16:00:56'),
(111, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'Johnson Simatupang mengikuti pelajaran Matematika', NULL, 0, 0, '2021-01-27 16:00:56', '2021-01-27 16:00:56'),
(112, 30, 'smkn11kotabekasi.actudent.com', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 'Kehadiran Mata Pelajaran', 'Brendon Rodgers mengikuti pelajaran Matematika', NULL, 0, 0, '2021-01-27 16:00:56', '2021-01-27 16:00:56'),
(113, 30, 'demo.actudent.com', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Pemberitahuan Tugas Baru untuk Brendon Rodgers', 'Biologi: Mencari contoh makhluk hidup telah terbit, batas pengumpulan tugas Selasa, 22 Februari 2022', NULL, 0, 0, '2022-02-22 02:21:30', '2022-02-22 02:21:30'),
(114, 30, 'demo.actudent.com', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Pemberitahuan Tugas Baru untuk Johnson Simatupang', 'Biologi: Mencari contoh makhluk hidup telah terbit, batas pengumpulan tugas Selasa, 22 Februari 2022', NULL, 0, 0, '2022-02-22 02:21:30', '2022-02-22 02:21:30'),
(115, 30, 'demo.actudent.com', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Pemberitahuan Tugas Baru untuk Raju Herningtyas Pratama', 'Biologi: Mencari contoh makhluk hidup telah terbit, batas pengumpulan tugas Selasa, 22 Februari 2022', NULL, 0, 0, '2022-02-22 02:21:30', '2022-02-22 02:21:30'),
(116, 30, 'demo.actudent.com', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Kehadiran Mata Pelajaran', 'Brendon Rodgers mengikuti pelajaran Biologi', NULL, 0, 0, '2022-02-22 02:21:36', '2022-02-22 02:21:36'),
(117, 30, 'demo.actudent.com', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Kehadiran Mata Pelajaran', 'Johnson Simatupang mengikuti pelajaran Biologi', NULL, 0, 0, '2022-02-22 02:21:37', '2022-02-22 02:21:37'),
(118, 30, 'demo.actudent.com', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Kehadiran Mata Pelajaran', 'Raju Herningtyas Pratama mengikuti pelajaran Biologi', NULL, 0, 0, '2022-02-22 02:21:51', '2022-02-22 02:21:51'),
(119, 30, 'demo.actudent.com', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Kehadiran Mata Pelajaran', 'Brendon Rodgers mengikuti pelajaran Matematika', NULL, 0, 0, '2022-04-18 02:22:17', '2022-04-18 02:22:17'),
(120, 30, 'demo.actudent.com', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Kehadiran Mata Pelajaran', 'Johnson Simatupang mengikuti pelajaran Matematika', NULL, 0, 0, '2022-04-18 02:22:17', '2022-04-18 02:22:17'),
(121, 30, 'demo.actudent.com', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Kehadiran Mata Pelajaran', 'Raju Herningtyas Pratama mengikuti pelajaran Matematika', NULL, 0, 0, '2022-04-18 02:22:17', '2022-04-18 02:22:17'),
(122, 30, 'demo.actudent.com', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Kehadiran Mata Pelajaran', 'Brendon Rodgers mengikuti pelajaran Matematika', NULL, 0, 0, '2022-05-25 01:18:47', '2022-05-25 01:18:47'),
(123, 30, 'demo.actudent.com', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Kehadiran Mata Pelajaran', 'Johnson Simatupang mengikuti pelajaran Matematika', NULL, 0, 0, '2022-05-25 01:18:47', '2022-05-25 01:18:47'),
(124, 30, 'demo.actudent.com', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Kehadiran Mata Pelajaran', 'Raju Herningtyas Pratama mengikuti pelajaran Matematika', NULL, 0, 0, '2022-05-25 01:18:47', '2022-05-25 01:18:47'),
(125, 53, 'demo.actudent.com', 'fcDzlt1TSZKGmb6WJPHmVf:APA91bHfyz4df_gdrbdsttsqbVYJwJrJnNEbfm0P2_zPxk7zQ0U0xo8y0D4Eds3vExnYc9M-RxOBNPmCr9UrtAht_X-lK6A79bYifto46E_dnUSd9wY489Ms7c9qkUMZz8y39UGt9QiT', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Upacara HUT RI ke-77', NULL, 0, 0, '2022-08-04 04:04:54', '2022-08-04 04:04:54'),
(126, 13, 'demo.actudent.com', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Upacara HUT RI ke-77', NULL, 0, 0, '2022-08-04 04:04:54', '2022-08-04 04:04:54'),
(127, 30, 'demo.actudent.com', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Status Kehadiran', 'Brendon Rodgers mengikuti pelajaran Bahasa Indonesia', NULL, 0, 0, '2022-08-04 04:17:15', '2022-08-04 04:17:15'),
(128, 30, 'demo.actudent.com', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Status Kehadiran', 'Johnson Simatupang mengikuti pelajaran Bahasa Indonesia', NULL, 0, 0, '2022-08-04 04:17:15', '2022-08-04 04:17:15'),
(129, 30, 'demo.actudent.com', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Status Kehadiran', 'Raju Herningtyas Pratama mengikuti pelajaran Bahasa Indonesia', NULL, 0, 0, '2022-08-04 04:17:15', '2022-08-04 04:17:15'),
(130, 30, 'demo.actudent.com', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Status Kehadiran', 'Brendon Rodgers tidak mengikuti pelajaran Bahasa Indonesia', NULL, 0, 0, '2022-08-04 04:17:47', '2022-08-04 04:17:47'),
(131, 53, 'demo.actudent.com', 'fcDzlt1TSZKGmb6WJPHmVf:APA91bHfyz4df_gdrbdsttsqbVYJwJrJnNEbfm0P2_zPxk7zQ0U0xo8y0D4Eds3vExnYc9M-RxOBNPmCr9UrtAht_X-lK6A79bYifto46E_dnUSd9wY489Ms7c9qkUMZz8y39UGt9QiT', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Upacara HUT RI ke-77', NULL, 0, 0, '2022-08-04 04:35:54', '2022-08-04 04:35:54'),
(132, 13, 'demo.actudent.com', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Upacara HUT RI ke-77', NULL, 0, 0, '2022-08-04 04:35:54', '2022-08-04 04:35:54'),
(133, 53, 'wolestech.com', 'fcDzlt1TSZKGmb6WJPHmVf:APA91bHfyz4df_gdrbdsttsqbVYJwJrJnNEbfm0P2_zPxk7zQ0U0xo8y0D4Eds3vExnYc9M-RxOBNPmCr9UrtAht_X-lK6A79bYifto46E_dnUSd9wY489Ms7c9qkUMZz8y39UGt9QiT', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Upacara HUT RI ke-77', NULL, 0, 0, '2022-08-16 04:36:18', '2022-08-16 04:36:18'),
(134, 13, 'wolestech.com', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Upacara HUT RI ke-77', NULL, 0, 0, '2022-08-16 04:36:18', '2022-08-16 04:36:18'),
(135, 53, 'wolestech.com', 'fcDzlt1TSZKGmb6WJPHmVf:APA91bHfyz4df_gdrbdsttsqbVYJwJrJnNEbfm0P2_zPxk7zQ0U0xo8y0D4Eds3vExnYc9M-RxOBNPmCr9UrtAht_X-lK6A79bYifto46E_dnUSd9wY489Ms7c9qkUMZz8y39UGt9QiT', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Upacara HUT RI ke-77', NULL, 0, 0, '2022-08-18 05:01:05', '2022-08-18 05:01:05'),
(136, 13, 'wolestech.com', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Upacara HUT RI ke-77', NULL, 0, 0, '2022-08-18 05:01:05', '2022-08-18 05:01:05'),
(137, 53, 'wolestech.com', 'fcDzlt1TSZKGmb6WJPHmVf:APA91bHfyz4df_gdrbdsttsqbVYJwJrJnNEbfm0P2_zPxk7zQ0U0xo8y0D4Eds3vExnYc9M-RxOBNPmCr9UrtAht_X-lK6A79bYifto46E_dnUSd9wY489Ms7c9qkUMZz8y39UGt9QiT', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Upacara HUT RI ke-77', NULL, 0, 0, '2022-08-18 07:40:49', '2022-08-18 07:40:49'),
(138, 13, 'wolestech.com', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Upacara HUT RI ke-77', NULL, 0, 0, '2022-08-18 07:40:49', '2022-08-18 07:40:49'),
(139, 53, 'wolestech.com', 'fcDzlt1TSZKGmb6WJPHmVf:APA91bHfyz4df_gdrbdsttsqbVYJwJrJnNEbfm0P2_zPxk7zQ0U0xo8y0D4Eds3vExnYc9M-RxOBNPmCr9UrtAht_X-lK6A79bYifto46E_dnUSd9wY489Ms7c9qkUMZz8y39UGt9QiT', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Perkemahan Sabtu-Minggu', NULL, 0, 0, '2022-08-18 07:41:50', '2022-08-18 07:41:50'),
(140, 13, 'wolestech.com', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Perkemahan Sabtu-Minggu', NULL, 0, 0, '2022-08-18 07:41:50', '2022-08-18 07:41:50'),
(141, 53, 'wolestech.com', 'fcDzlt1TSZKGmb6WJPHmVf:APA91bHfyz4df_gdrbdsttsqbVYJwJrJnNEbfm0P2_zPxk7zQ0U0xo8y0D4Eds3vExnYc9M-RxOBNPmCr9UrtAht_X-lK6A79bYifto46E_dnUSd9wY489Ms7c9qkUMZz8y39UGt9QiT', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Perkemahan Sabtu-Minggu', NULL, 0, 0, '2022-08-19 06:42:18', '2022-08-19 06:42:18'),
(142, 13, 'wolestech.com', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Perkemahan Sabtu-Minggu', NULL, 0, 0, '2022-08-19 06:42:18', '2022-08-19 06:42:18'),
(143, 53, 'wolestech.com', 'fcDzlt1TSZKGmb6WJPHmVf:APA91bHfyz4df_gdrbdsttsqbVYJwJrJnNEbfm0P2_zPxk7zQ0U0xo8y0D4Eds3vExnYc9M-RxOBNPmCr9UrtAht_X-lK6A79bYifto46E_dnUSd9wY489Ms7c9qkUMZz8y39UGt9QiT', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Rapat wali kelas', NULL, 0, 0, '2022-08-19 06:43:20', '2022-08-19 06:43:20'),
(144, 53, 'wolestech.com', 'fcDzlt1TSZKGmb6WJPHmVf:APA91bHfyz4df_gdrbdsttsqbVYJwJrJnNEbfm0P2_zPxk7zQ0U0xo8y0D4Eds3vExnYc9M-RxOBNPmCr9UrtAht_X-lK6A79bYifto46E_dnUSd9wY489Ms7c9qkUMZz8y39UGt9QiT', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Ngopi...', NULL, 0, 0, '2022-08-21 14:45:00', '2022-08-21 14:45:00'),
(145, 53, 'wolestech.com', 'fcDzlt1TSZKGmb6WJPHmVf:APA91bHfyz4df_gdrbdsttsqbVYJwJrJnNEbfm0P2_zPxk7zQ0U0xo8y0D4Eds3vExnYc9M-RxOBNPmCr9UrtAht_X-lK6A79bYifto46E_dnUSd9wY489Ms7c9qkUMZz8y39UGt9QiT', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Rapat Persiapan PTS ', NULL, 0, 0, '2022-09-02 08:21:46', '2022-09-02 08:21:46'),
(146, 13, 'wolestech.com', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Rapat Persiapan PTS ', NULL, 0, 0, '2022-09-02 08:21:46', '2022-09-02 08:21:46'),
(147, 53, 'wolestech.com', 'fcDzlt1TSZKGmb6WJPHmVf:APA91bHfyz4df_gdrbdsttsqbVYJwJrJnNEbfm0P2_zPxk7zQ0U0xo8y0D4Eds3vExnYc9M-RxOBNPmCr9UrtAht_X-lK6A79bYifto46E_dnUSd9wY489Ms7c9qkUMZz8y39UGt9QiT', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Rapat Persiapan PTS ', NULL, 0, 0, '2022-09-02 09:06:15', '2022-09-02 09:06:15'),
(148, 13, 'wolestech.com', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Rapat Persiapan PTS ', NULL, 0, 0, '2022-09-02 09:06:15', '2022-09-02 09:06:15'),
(149, 53, 'wolestech.com', 'fcDzlt1TSZKGmb6WJPHmVf:APA91bHfyz4df_gdrbdsttsqbVYJwJrJnNEbfm0P2_zPxk7zQ0U0xo8y0D4Eds3vExnYc9M-RxOBNPmCr9UrtAht_X-lK6A79bYifto46E_dnUSd9wY489Ms7c9qkUMZz8y39UGt9QiT', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Rapat Persiapan PTS ', NULL, 0, 0, '2022-09-02 09:13:24', '2022-09-02 09:13:24'),
(150, 13, 'wolestech.com', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Rapat Persiapan PTS ', NULL, 0, 0, '2022-09-02 09:13:24', '2022-09-02 09:13:24'),
(151, 30, 'wolestech.com', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Status Kehadiran', 'Brendon Rodgers mengikuti pelajaran Matematika', NULL, 0, 0, '2022-11-25 04:08:43', '2022-11-25 04:08:43'),
(152, 30, 'wolestech.com', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Status Kehadiran', 'Johnson Simatupang mengikuti pelajaran Matematika', NULL, 0, 0, '2022-11-25 04:08:43', '2022-11-25 04:08:43'),
(153, 30, 'wolestech.com', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Status Kehadiran', 'Raju Herningtyas Pratama mengikuti pelajaran Matematika', NULL, 0, 0, '2022-11-25 04:08:43', '2022-11-25 04:08:43'),
(154, 53, 'demo.actudent.com', 'fcDzlt1TSZKGmb6WJPHmVf:APA91bHfyz4df_gdrbdsttsqbVYJwJrJnNEbfm0P2_zPxk7zQ0U0xo8y0D4Eds3vExnYc9M-RxOBNPmCr9UrtAht_X-lK6A79bYifto46E_dnUSd9wY489Ms7c9qkUMZz8y39UGt9QiT', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Halal bi Halal', NULL, 0, 0, '2023-04-20 03:06:40', '2023-04-20 03:06:40'),
(155, 13, 'demo.actudent.com', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Halal bi Halal', NULL, 0, 0, '2023-04-20 03:06:40', '2023-04-20 03:06:40'),
(156, 53, 'demo.actudent.com', 'fcDzlt1TSZKGmb6WJPHmVf:APA91bHfyz4df_gdrbdsttsqbVYJwJrJnNEbfm0P2_zPxk7zQ0U0xo8y0D4Eds3vExnYc9M-RxOBNPmCr9UrtAht_X-lK6A79bYifto46E_dnUSd9wY489Ms7c9qkUMZz8y39UGt9QiT', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Halal bi Halal', NULL, 0, 0, '2023-04-20 03:08:05', '2023-04-20 03:08:05'),
(157, 13, 'demo.actudent.com', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Halal bi Halal', NULL, 0, 0, '2023-04-20 03:08:05', '2023-04-20 03:08:05'),
(158, 30, 'wolestech.com', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Status Kehadiran', 'Brendon Rodgers mengikuti pelajaran Matematika', NULL, 0, 0, '2023-07-06 15:15:03', '2023-07-06 15:15:03'),
(159, 30, 'demo.actudent.com', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Status Kehadiran', 'Brendon Rodgers mengikuti pelajaran Matematika', NULL, 0, 0, '2023-07-06 15:37:04', '2023-07-06 15:37:04'),
(160, 30, 'localhost', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Status Kehadiran', 'Brendon Rodgers mengikuti pelajaran Matematika', NULL, 0, 0, '2023-08-11 15:26:25', '2023-08-11 15:26:25'),
(161, 30, 'localhost', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Status Kehadiran', 'Brendon Rodgers mengikuti pelajaran Matematika', NULL, 0, 0, '2023-08-15 05:40:31', '2023-08-15 05:40:31'),
(162, 30, 'localhost', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Status Kehadiran', 'Brendon Rodgers mengikuti pelajaran Pendidikan Kewarganegaraan', NULL, 0, 0, '2023-09-06 08:47:27', '2023-09-06 08:47:27'),
(163, 30, 'localhost', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Status Kehadiran', 'Brendon Rodgers mengikuti pelajaran Pendidikan Jasmani, Olahraga dan Kesehatan', NULL, 0, 0, '2023-09-06 13:33:15', '2023-09-06 13:33:15'),
(164, 30, 'localhost', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Status Kehadiran', 'Brendon Rodgers mengikuti pelajaran Pendidikan Kewarganegaraan', NULL, 0, 0, '2023-09-06 14:10:51', '2023-09-06 14:10:51'),
(165, 30, 'localhost', 'ePCVe_8USAeZ3yUNvdp1RK:APA91bHRFNlwF1BfnC2Z0o4LFLzdYTEWEZ-oj332vbPWdEzaIbaZnId-bw-R7YQeok5aBl8oETGdrohxGZUPwk8V6PTm5vmhJGuhCZgSE8mtHpxvNygnex72_7jt3gTllZkaaaIWfNFG', 'Status Kehadiran', 'Brendon Rodgers mengikuti pelajaran Pendidikan Kewarganegaraan', NULL, 0, 0, '2023-09-06 16:03:04', '2023-09-06 16:03:04'),
(166, 53, 'localhost', 'fcDzlt1TSZKGmb6WJPHmVf:APA91bHfyz4df_gdrbdsttsqbVYJwJrJnNEbfm0P2_zPxk7zQ0U0xo8y0D4Eds3vExnYc9M-RxOBNPmCr9UrtAht_X-lK6A79bYifto46E_dnUSd9wY489Ms7c9qkUMZz8y39UGt9QiT', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Peringatan HUT RI ke-78', NULL, 0, 0, '2023-09-11 03:39:52', '2023-09-11 03:39:52'),
(167, 13, 'localhost', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Peringatan HUT RI ke-78', NULL, 0, 0, '2023-09-11 03:39:52', '2023-09-11 03:39:52'),
(168, 53, 'localhost', 'fcDzlt1TSZKGmb6WJPHmVf:APA91bHfyz4df_gdrbdsttsqbVYJwJrJnNEbfm0P2_zPxk7zQ0U0xo8y0D4Eds3vExnYc9M-RxOBNPmCr9UrtAht_X-lK6A79bYifto46E_dnUSd9wY489Ms7c9qkUMZz8y39UGt9QiT', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Pulang Kampung', NULL, 0, 0, '2023-09-11 03:41:26', '2023-09-11 03:41:26'),
(169, 13, 'localhost', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Pulang Kampung', NULL, 0, 0, '2023-09-11 03:41:26', '2023-09-11 03:41:26'),
(170, 53, 'localhost', 'fcDzlt1TSZKGmb6WJPHmVf:APA91bHfyz4df_gdrbdsttsqbVYJwJrJnNEbfm0P2_zPxk7zQ0U0xo8y0D4Eds3vExnYc9M-RxOBNPmCr9UrtAht_X-lK6A79bYifto46E_dnUSd9wY489Ms7c9qkUMZz8y39UGt9QiT', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Pulang Kampung', NULL, 0, 0, '2023-09-11 08:16:56', '2023-09-11 08:16:56'),
(171, 13, 'localhost', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 'Undangan Kegiatan', 'Anda diundang dalam kegiatan Pulang Kampung', NULL, 0, 0, '2023-09-11 08:16:56', '2023-09-11 08:16:56');

-- --------------------------------------------------------

--
-- Table structure for table `tb_notification_setting`
--

CREATE TABLE `tb_notification_setting` (
  `setting_id` int(11) NOT NULL,
  `running_process` tinyint(4) NOT NULL DEFAULT 0,
  `last_process` timestamp NULL DEFAULT NULL,
  `enabled_service` tinyint(4) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_notification_setting`
--

INSERT INTO `tb_notification_setting` (`setting_id`, `running_process`, `last_process`, `enabled_service`, `created`, `modified`) VALUES
(1, 0, '2020-07-14 07:46:02', 1, '2020-06-03 05:29:33', '2020-07-14 07:46:02');

-- --------------------------------------------------------

--
-- Table structure for table `tb_organization`
--

CREATE TABLE `tb_organization` (
  `organization_id` int(11) NOT NULL,
  `organization_name` varchar(100) NOT NULL,
  `organization_origination` varchar(500) NOT NULL,
  `organization_destination` varchar(500) NOT NULL,
  `db_version` varchar(10) NOT NULL DEFAULT '2.2.6',
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_organization`
--

INSERT INTO `tb_organization` (`organization_id`, `organization_name`, `organization_origination`, `organization_destination`, `db_version`, `created`, `modified`) VALUES
(1, 'SMK Negeri 11 Kota Bekasi', 'smkn11kotabekasi.actudent.com', 'https://api.smkn11kotabekasi.actudent.com/index.php/api/v1/', '2.2.6', '2019-01-30 07:35:58', '2023-08-04 02:51:16'),
(2, 'Actudent Demo', 'demo.actudent.com', 'https://api.demo.actudent.com/index.php/api/v1/', '2.2.6', '2020-06-30 08:16:04', '2023-08-04 02:51:20'),
(3, 'SMKN 999 Kota Bekasi', 'localhost', 'https://api.demo.actudent.com/index.php/api/v1/', '2.2.9', '2020-06-30 08:16:04', '2024-02-08 06:26:24'),
(29, 'SDN Pengasinan VII', 'localhost', '', '2.2.6', '2023-08-11 13:38:00', '2023-08-11 13:38:00'),
(30, 'SDN Pengasinan VII', 'localhost', '', '2.2.6', '2023-08-11 13:39:40', '2023-08-11 13:39:40'),
(31, 'SDN Pengasinan VII', 'localhost', '', '2.2.6', '2023-08-11 13:41:56', '2023-08-11 13:41:56'),
(32, 'SDN Pengasinan VII', 'localhost', '', '2.2.6', '2023-08-11 13:43:04', '2023-08-11 13:43:04'),
(33, 'SDN Pengasinan VII', 'localhost', '', '2.2.7', '2023-08-15 13:16:09', '2023-08-15 13:16:09'),
(34, 'SDN Bojong Menteng VII', 'localhost', '', '2.2.9', '2024-01-16 07:57:53', '2024-01-16 07:57:53'),
(35, 'SMK Mandiri', 'localhost', '', '2.2.9', '2024-01-16 08:01:25', '2024-01-16 08:01:25');

-- --------------------------------------------------------

--
-- Table structure for table `tb_organization_database`
--

CREATE TABLE `tb_organization_database` (
  `organization_id` int(11) NOT NULL,
  `database_name` varchar(100) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `crerated` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_organization_database`
--

INSERT INTO `tb_organization_database` (`organization_id`, `database_name`, `status`, `crerated`, `modified`) VALUES
(27, 'db_actudent_install', 1, '2023-08-11 13:38:00', '2023-08-11 13:38:00'),
(28, 'db_actudent_install', 1, '2023-08-11 13:39:40', '2023-08-11 13:39:40'),
(29, 'db_actudent_install', 1, '2023-08-11 13:41:56', '2023-08-11 13:41:56'),
(30, 'db_actudent_install', 1, '2023-08-11 13:43:04', '2023-08-11 13:43:04'),
(31, 'db_actudent_install', 1, '2023-08-15 13:16:09', '2023-08-15 13:16:09'),
(32, 'db_actudent_install', 1, '2024-01-16 07:57:53', '2024-01-16 07:57:53'),
(33, 'db_actudent_install', 1, '2024-01-16 08:01:25', '2024-01-16 08:01:25');

-- --------------------------------------------------------

--
-- Table structure for table `tb_subscription`
--

CREATE TABLE `tb_subscription` (
  `organization_id` int(11) NOT NULL,
  `subscription_type` enum('free','starter','standard','enhanced','enterprise') DEFAULT NULL,
  `subscription_expiration` datetime DEFAULT NULL,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_subscription`
--

INSERT INTO `tb_subscription` (`organization_id`, `subscription_type`, `subscription_expiration`, `created`, `modified`) VALUES
(1, 'standard', '2021-06-30 23:59:00', '2021-01-29 03:56:49', '2021-01-29 03:56:49'),
(2, 'free', '2021-06-30 23:59:00', '2021-01-29 03:56:49', '2021-01-29 03:56:49'),
(3, 'free', '2024-12-31 19:19:19', '2021-01-29 03:56:49', '2024-01-11 07:24:12'),
(29, 'free', '2024-08-10 23:59:59', '2023-08-11 13:38:00', '2023-08-11 13:38:00'),
(30, 'free', '2024-08-10 23:59:59', '2023-08-11 13:39:40', '2023-08-11 13:39:40'),
(31, 'free', '2024-08-10 23:59:59', '2023-08-11 13:41:56', '2023-08-11 13:41:56'),
(32, 'free', '2024-08-10 23:59:59', '2023-08-11 13:43:04', '2023-08-11 13:43:04'),
(33, 'free', '2024-08-14 23:59:59', '2023-08-15 13:16:09', '2023-08-15 13:16:09'),
(34, 'standard', '2025-01-15 23:59:59', '2024-01-16 07:57:53', '2024-01-16 07:57:53'),
(35, 'free', '2025-01-15 23:59:59', '2024-01-16 08:01:25', '2024-01-16 08:01:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_installation`
--
ALTER TABLE `tb_installation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_notification`
--
ALTER TABLE `tb_notification`
  ADD PRIMARY KEY (`notif_id`);

--
-- Indexes for table `tb_notification_setting`
--
ALTER TABLE `tb_notification_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `tb_organization`
--
ALTER TABLE `tb_organization`
  ADD PRIMARY KEY (`organization_id`);

--
-- Indexes for table `tb_organization_database`
--
ALTER TABLE `tb_organization_database`
  ADD PRIMARY KEY (`organization_id`);

--
-- Indexes for table `tb_subscription`
--
ALTER TABLE `tb_subscription`
  ADD PRIMARY KEY (`organization_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_installation`
--
ALTER TABLE `tb_installation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_notification`
--
ALTER TABLE `tb_notification`
  MODIFY `notif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `tb_notification_setting`
--
ALTER TABLE `tb_notification_setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_organization`
--
ALTER TABLE `tb_organization`
  MODIFY `organization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tb_organization_database`
--
ALTER TABLE `tb_organization_database`
  MODIFY `organization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_subscription`
--
ALTER TABLE `tb_subscription`
  ADD CONSTRAINT `fk_organization` FOREIGN KEY (`organization_id`) REFERENCES `tb_organization` (`organization_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
