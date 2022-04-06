-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 14, 2020 at 02:46 PM
-- Server version: 10.2.32-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u1018042_actudent_main`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(73, 30, 'demo.actudent.com', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 'Kehadiran Mata Pelajaran', 'Brendon Rodgers tidak mengikuti mata pelajaran Desain Grafis dikarenakan sakit', NULL, 1, 0, '2020-07-13 13:52:25', '2020-07-13 13:53:01');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_organization`
--

INSERT INTO `tb_organization` (`organization_id`, `organization_name`, `organization_origination`, `organization_destination`, `created`, `modified`) VALUES
(1, 'SMK Negeri 11 Kota Bekasi', 'smkn11kotabekasi.actudent.com', 'https://api.smkn11kotabekasi.actudent.com/index.php/api/v1/', '2019-01-30 07:35:58', '2020-07-02 04:07:28'),
(2, 'Actudent Demo', 'demo.actudent.com', 'https://api.demo.actudent.com/index.php/api/v1/', '2020-06-30 08:16:04', '2020-06-30 08:16:04');

-- --------------------------------------------------------

--
-- Table structure for table `tb_score`
--

CREATE TABLE `tb_score` (
  `score_id` int(11) NOT NULL,
  `lessons_grade_id` int(11) NOT NULL,
  `score_category` enum('Tugas','UH','PTS','PAS','Kinerja','Proyek','Praktik') NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

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
-- Indexes for table `tb_score`
--
ALTER TABLE `tb_score`
  ADD PRIMARY KEY (`score_id`),
  ADD KEY `score_lessons_grade` (`lessons_grade_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_notification`
--
ALTER TABLE `tb_notification`
  MODIFY `notif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `tb_notification_setting`
--
ALTER TABLE `tb_notification_setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_organization`
--
ALTER TABLE `tb_organization`
  MODIFY `organization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
