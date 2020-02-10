-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2020 at 05:11 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `tb_agenda`
--

CREATE TABLE `tb_agenda` (
  `agenda_id` int(11) NOT NULL,
  `agenda_name` varchar(250) DEFAULT NULL,
  `agenda_start` datetime DEFAULT NULL,
  `agenda_end` datetime DEFAULT NULL,
  `agenda_description` text,
  `agenda_priority` enum('high','normal','low') DEFAULT NULL,
  `agenda_location` varchar(50) DEFAULT NULL,
  `agenda_attachment` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
(44, 'Refreshing dulu masbro', '2020-01-25 08:00:00', '2020-01-25 17:00:00', 'Jalan-jalan sama ndin..', 'high', 'Taman Mini dan Lubang Buaya', NULL, 1, '2020-01-24 13:36:31', '2020-01-24 13:36:31');

-- --------------------------------------------------------

--
-- Table structure for table `tb_agenda_user`
--

CREATE TABLE `tb_agenda_user` (
  `agenda_id` int(11) NOT NULL,
  `guests` text,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
(35, '4,13,12', '2019-08-10 12:20:11', '2019-08-10 12:20:11');

-- --------------------------------------------------------

--
-- Table structure for table `tb_grade`
--

CREATE TABLE `tb_grade` (
  `grade_id` int(11) NOT NULL,
  `grade_name` varchar(20) DEFAULT NULL,
  `period_from` varchar(4) DEFAULT NULL,
  `period_until` varchar(4) DEFAULT NULL,
  `teacher_id` int(11) NOT NULL,
  `grade_status` tinyint(1) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_grade`
--

INSERT INTO `tb_grade` (`grade_id`, `grade_name`, `period_from`, `period_until`, `teacher_id`, `grade_status`, `created`, `modified`) VALUES
(1, 'X TKJ-1', '2018', '2019', 1, 1, '2019-03-29 05:51:07', '0000-00-00 00:00:00'),
(2, 'XI Grafika1', '2018', '2019', 2, 1, '2019-03-28 07:37:57', '2018-10-19 17:00:00'),
(3, 'X TKJ-2', '2018', '2019', 3, 1, '2019-03-29 05:54:53', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_parent`
--

CREATE TABLE `tb_parent` (
  `parent_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_family_card` varchar(18) NOT NULL,
  `parent_father_name` varchar(100) DEFAULT NULL,
  `parent_mother_name` varchar(100) DEFAULT NULL,
  `parent_phone_number` varchar(15) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_parent`
--

INSERT INTO `tb_parent` (`parent_id`, `user_id`, `parent_family_card`, `parent_father_name`, `parent_mother_name`, `parent_phone_number`, `deleted`, `created`, `modified`) VALUES
(1, 14, '3273987984273984', 'Bambang Tri', 'Sintia', '080385048593', 1, '2020-02-08 05:04:31', '2020-02-10 02:59:52'),
(2, 15, '3287398279873984', 'Sinto', 'Santi', '0879349895849', 1, '2020-02-08 05:06:12', '2020-02-10 02:59:32'),
(3, 16, '3287879823749827', 'Rizky Nur Hidayat', 'Jihan Nur Kamila', '0894587839734', 1, '2020-02-10 02:54:50', '2020-02-10 02:59:53'),
(4, 17, '3298738297498273', 'Bernard Siahaan', 'Juliana Zein', '0868785949388', 1, '2020-02-10 03:01:33', '2020-02-10 03:03:19'),
(10, 23, '3276438945089802', 'Susanto Nurjaman', 'Bidikwati Susikaloni', '0867276876786', 0, '2020-02-10 07:33:09', '2020-02-10 07:33:09'),
(11, 24, '3275092039402859', 'Ahmad Ridho', 'Liana Saktiwanti', '087865368761', 0, '2020-02-10 07:34:15', '2020-02-10 07:34:15'),
(12, 25, '3275099839457398', 'Fahruliansyah', 'Sheila Nur Majid', '0867587247827', 0, '2020-02-10 07:35:17', '2020-02-10 07:35:17'),
(13, 26, '3276874874958794', 'Andreas Prasetyo', 'Intan Nur Hotimah', '0832894937857', 0, '2020-02-10 07:35:54', '2020-02-10 07:35:54'),
(14, 27, '3271908329042839', 'Emet Nur Cholis', 'Amit Nur Badai', '0878745987326', 0, '2020-02-10 07:38:11', '2020-02-10 07:38:11'),
(15, 28, '3283729873982749', 'Gledek Nurmantyo', 'Bredek Santini', '0824839048395', 0, '2020-02-10 08:10:10', '2020-02-10 08:10:10'),
(16, 29, '2413432214135233', 'bambang', 'siti', '02125587341', 0, '2020-02-10 08:15:03', '2020-02-10 08:15:29'),
(17, 30, '3287874289374983', 'Badut Siahaan', 'Didot Mantaulu', '085789739842', 0, '2020-02-10 08:16:45', '2020-02-10 08:16:45'),
(18, 31, '3184613454254134', 'Katmo', 'Sri ', '0813813461134', 0, '2020-02-10 08:16:56', '2020-02-10 08:16:56'),
(19, 32, '3290809284095894', 'Abdi Negara', 'Ibu Negara', '0839809458490', 0, '2020-02-10 08:17:14', '2020-02-10 08:17:14'),
(20, 33, '3750936413456432', 'Yono', 'Maemunah', '0812064658643', 0, '2020-02-10 08:17:33', '2020-02-10 08:17:33'),
(21, 34, '3297398274982378', 'Amran Kartakarun', 'Imrin Kirtikirin', '0857683278465', 0, '2020-02-10 08:17:53', '2020-02-10 08:17:53'),
(22, 35, '3275120300505310', 'Jajang', 'Yati', '0856062315840', 0, '2020-02-10 08:18:10', '2020-02-10 08:18:10'),
(23, 36, '3283972987895749', 'Sandrayono', 'Sandrayani', '0886509486904', 0, '2020-02-10 08:19:23', '2020-02-10 08:19:23'),
(24, 37, '5475272753675201', 'Anto', 'Iis', '0287630563123', 0, '2020-02-10 08:19:31', '2020-02-10 08:19:31'),
(25, 38, '6541435432165333', 'Asem', 'Banget', '2504540757546', 0, '2020-02-10 08:20:15', '2020-02-10 08:21:28'),
(26, 39, '3298038972983748', 'Mugiono Apriyani', 'Cici Parwito', '0894984590684', 0, '2020-02-10 08:31:25', '2020-02-10 08:34:27');

-- --------------------------------------------------------

--
-- Table structure for table `tb_schedule`
--

CREATE TABLE `tb_schedule` (
  `schedule_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `schedule_semester` int(11) DEFAULT NULL,
  `schedule_list` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_schedule`
--

INSERT INTO `tb_schedule` (`schedule_id`, `grade_id`, `schedule_semester`, `schedule_list`) VALUES
(1, 1, 1, '\"schedule\":\r\n[{\r\n	\"label\" : \"Senin\",\r\n	\"scheduleName\" : [{\r\n			\"label\" : \"MTK\",\r\n			\"jamFrom\" : \"10.00\",\r\n			\"jamUntil\" : \"12.00\"\r\n		  },\r\n		 {\r\n			\"label\" : \"Bahasa Inggris\",\r\n			\"jamFrom\" : \"10.00\",\r\n			\"jamUntil\" : \"12.00\"\r\n		  }\r\n	]\r\n},\r\n{\r\n	\"label\" : \"Selasa\",\r\n	\"scheduleName\" : [{\r\n			\"label\" : \"Bahasa Sunda\",\r\n			\"jamFrom\" : \"10.00\",\r\n			\"jamUntil\" : \"12.00\"\r\n		  },\r\n		 {\r\n			\"label\" : \"Bahasa Wanita\",\r\n			\"jamFrom\" : \"10.00\",\r\n			\"jamUntil\" : \"12.00\"\r\n		  }\r\n	]\r\n},\r\n');

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
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_school`
--

INSERT INTO `tb_school` (`school_id`, `school_name`, `school_type`, `school_address`, `school_telephone`, `school_status`, `school_domain`, `created`, `modified`) VALUES
(1, 'SMK Negeri 11 Kota Bekasi', 'Sekolah Manengah Atas', 'Pekayon, Bekasi Selatan', '021-80000000', 1, 'smkn11kotabekasi.actudent.com', '2018-10-09 17:00:00', '2020-02-06 02:46:59');

-- --------------------------------------------------------

--
-- Table structure for table `tb_student`
--

CREATE TABLE `tb_student` (
  `student_id` int(11) NOT NULL,
  `student_nis` varchar(20) DEFAULT NULL,
  `student_name` varchar(100) DEFAULT NULL,
  `student_tag` tinyint(1) DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_student`
--

INSERT INTO `tb_student` (`student_id`, `student_nis`, `student_name`, `student_tag`, `created`, `modified`) VALUES
(1, '2015420022', 'Adnan Zaki keren', 1, '2018-10-20 04:19:34', '0000-00-00 00:00:00'),
(2, '2015420003', 'Saka Putra ', 1, '2018-10-20 03:23:30', '0000-00-00 00:00:00'),
(3, '2015420004', 'Bima Sakti', 1, '2018-10-14 03:02:10', '0000-00-00 00:00:00'),
(4, '2015420015', 'Widya Sari Wangi', 1, '2018-10-19 09:32:46', '0000-00-00 00:00:00'),
(5, '2015420049', 'Joko Tole', 3, '2020-02-10 03:58:02', '0000-00-00 00:00:00'),
(6, '2014310039', 'Dani Rusmawan', 1, '2018-10-20 03:11:18', '2018-10-19 17:00:00'),
(7, '2014310012', 'Mukhlisin', 1, '2018-10-20 03:11:23', '2018-10-19 17:00:00'),
(8, '2015310028', 'Rino Ardiansyah', 1, '2018-10-20 04:20:22', '2018-10-19 17:00:00'),
(9, '2015310029', 'Raju Herningtyas Pratama', 1, '2018-10-20 03:11:44', '2018-10-19 17:00:00'),
(10, '2014310088', 'Ridwan Kamil', 1, '2018-10-20 03:11:48', '2018-10-19 17:00:00'),
(11, '2015310098', 'Firhan Yudha', 1, '2018-10-20 13:53:06', '2018-10-19 17:00:00'),
(12, '2014220038', 'Try Albahri', 1, '2018-10-20 13:53:06', '2018-10-19 17:00:00'),
(13, '2015190029', 'Wahyudi', 1, '2018-10-20 13:53:06', '2018-10-19 17:00:00'),
(14, '2015310124', 'Kipiir', 1, '2018-11-13 16:53:15', '2020-02-10 16:05:45');

-- --------------------------------------------------------

--
-- Table structure for table `tb_student_grade`
--

CREATE TABLE `tb_student_grade` (
  `student_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `student_tag` tinyint(1) DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_student_grade`
--

INSERT INTO `tb_student_grade` (`student_id`, `grade_id`, `student_tag`, `created`, `modified`) VALUES
(1, 1, 1, '2018-10-14 04:18:39', '0000-00-00 00:00:00'),
(2, 1, 1, '2018-10-14 04:19:09', '0000-00-00 00:00:00'),
(3, 3, 1, '2019-03-29 05:55:40', '0000-00-00 00:00:00'),
(4, 1, 1, '2018-10-14 04:19:50', '0000-00-00 00:00:00'),
(5, 1, 3, '2020-02-10 04:36:11', '0000-00-00 00:00:00'),
(6, 2, 1, '2018-10-20 03:15:10', '0000-00-00 00:00:00'),
(7, 1, 1, '2018-10-20 03:15:10', '0000-00-00 00:00:00'),
(8, 2, 1, '2018-10-20 03:15:10', '0000-00-00 00:00:00'),
(9, 3, 1, '2019-03-29 05:55:47', '0000-00-00 00:00:00'),
(10, 2, 1, '2018-10-20 03:16:16', '0000-00-00 00:00:00'),
(11, 2, 1, '2018-10-20 13:53:36', '2018-10-19 17:00:00'),
(12, 1, 1, '2018-10-20 13:54:02', '2018-10-19 17:00:00'),
(13, 3, 1, '2019-03-29 05:55:54', '2018-10-19 17:00:00'),
(14, 1, 1, '2019-03-28 04:58:42', '2019-03-27 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_student_parent`
--

CREATE TABLE `tb_student_parent` (
  `parent_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_teacher`
--

CREATE TABLE `tb_teacher` (
  `teacher_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `teacher_name` varchar(50) DEFAULT NULL,
  `teacher_phone` varchar(20) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_teacher`
--

INSERT INTO `tb_teacher` (`teacher_id`, `user_id`, `teacher_name`, `teacher_phone`, `created`, `modified`) VALUES
(1, 4, 'Firhan Yudha P.', '08230298484', '2020-02-10 22:50:59', '2020-02-10 22:50:59'),
(2, 12, 'Uus Rusmawan Prasetyo', '083290489348', '2020-02-10 22:50:59', '2020-02-10 22:50:59'),
(3, 13, 'Sudrajat Drajat', '086969696969', '2020-02-10 22:50:59', '2020-02-10 22:50:59');

-- --------------------------------------------------------

--
-- Table structure for table `tb_timeline`
--

CREATE TABLE `tb_timeline` (
  `timeline_id` int(11) NOT NULL,
  `timeline_title` varchar(100) DEFAULT NULL,
  `timeline_content` text,
  `timeline_date` datetime DEFAULT NULL,
  `timeline_status` enum('public','draft') DEFAULT NULL,
  `timeline_image` varchar(500) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_timeline`
--

INSERT INTO `tb_timeline` (`timeline_id`, `timeline_title`, `timeline_content`, `timeline_date`, `timeline_status`, `timeline_image`, `user_id`, `created`, `modified`) VALUES
(1, 'Kisah seorang pemuda', 'ada anak bertanya pada bapaknya...', '2019-02-18 05:00:00', 'public', NULL, 1, '2019-02-18 00:00:00', '2019-02-18 00:00:00'),
(2, 'Acara Peringatan Maulid Nabi Muhammad.', 'Pada hari ini, seluruh warga sekolah dari SMKN 999 Kota Bekasi turut serta dalam acara peringatan maulid Nabi Muhammad yang diselenggarakan oleh pihak sekolah.', '2019-11-09 07:00:00', 'public', NULL, 1, '2019-11-08 09:00:00', '2019-11-08 09:00:00'),
(3, 'Serunya kegiatan Ekstrakuriler Pencak Bandeng!', 'Di hari Senin yang terik, siswa-siswi SMKN 999 Kota Bekasi yang mengikuti kegiatan Ekskul Pencak bandeng luar biasa semangat.', '2019-11-11 13:00:00', 'public', NULL, 3, '2019-11-08 00:00:00', '2019-11-08 00:00:00'),
(4, 'Semangat UTS!', 'Mulai hari ini siswa-siswi SMKN 999 Kota Bekasi mengikuti kegiatan UTS hari pertama dengan penuh semangat dan motivasi', '2019-10-28 07:00:00', 'public', NULL, 1, '2019-11-06 00:00:00', '2019-11-06 00:00:00'),
(5, 'Selamat bertugas para panutan!', 'Siswa-siswi SMKN 999 Kota Bekasi yang terpilih untuk mewakili sekolah dalam acara Ajang Orang Keren! hari ini berangkat ke Cikampek.', '2019-11-11 08:00:00', 'public', NULL, 2, '2019-11-12 17:00:00', '2019-11-12 17:00:00'),
(6, 'Berbahagialah para penerus bangsa!', 'Tepat pada hari Senin, 11 November 2019 kemarin, siswa-siswi SMKN 999 Kota Bekasi merayakan hari bahagia sekolah. Wow mantap! Acara berlangsung dengan sangat meriah', '2019-11-11 10:00:00', 'public', NULL, 2, '2019-11-13 00:00:00', '2019-11-13 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_timeline_comments`
--

CREATE TABLE `tb_timeline_comments` (
  `timeline_comment_id` int(11) NOT NULL,
  `timeline_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_parent` int(11) DEFAULT NULL,
  `comment_content` text,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_timeline_comments`
--

INSERT INTO `tb_timeline_comments` (`timeline_comment_id`, `timeline_id`, `user_id`, `comment_parent`, `comment_content`, `created`, `modified`) VALUES
(1, 1, 2, NULL, 'aduh lucu bgt deh ceritanya sis...', '2019-02-18 00:00:00', '2019-02-18 00:00:00'),
(2, 1, 1, 1, 'iya ihhhh', '2019-02-18 00:00:00', '2019-02-18 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_timeline_likes`
--

CREATE TABLE `tb_timeline_likes` (
  `timeline_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_timeline_likes`
--

INSERT INTO `tb_timeline_likes` (`timeline_id`, `user_id`, `created`, `modified`) VALUES
(1, 1, '2019-02-18 00:00:00', '2019-02-18 00:00:00'),
(1, 2, '2019-02-18 00:00:00', '2019-02-18 00:00:00');

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
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `network` varchar(10) NOT NULL DEFAULT 'offline',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `user_name`, `user_email`, `user_password`, `user_level`, `deleted`, `network`, `created`, `modified`) VALUES
(1, 'Adnan Zaki', 'admin@wolestech.com', '$2y$10$4l1uN20KpNheU3EaSQkF6OuNPYjyBqvb3ePCHgXPAy/4tm95ROkZa', 1, 0, 'online', '2018-10-10 17:00:00', '2020-02-10 02:25:15'),
(2, 'Mukhlisin', 'mukliz@wolestech.com', '$2y$10$8n/ojdr/Cb6DjfBIjVKkvekVHXfjXAATlWlnsMZAvV9ioz7Zv/La2', 1, 0, 'online', '2018-10-30 17:00:00', '2020-02-10 08:09:00'),
(3, 'Dany Prastio', 'danyprastio@wolestech.com', '$2y$10$3Sfe/cMO/PLunpye4PjZY.oTTzP8ze5XXMCf01x8t/eNpxOk2PoAy', 1, 0, 'offline', '2018-10-30 17:00:00', '2020-02-10 02:25:34'),
(4, 'Firhan Yudha P.', 'firhanyp@wolestech.com', '$2y$10$I/mLXlaxAjTonC0DAWx7JOM/z7xi.PGwj8LZwsKNGFVdid38KI4Z2', 2, 0, 'online', '2019-03-17 17:00:00', '2020-02-10 02:25:34'),
(12, 'Uus Rusmawan Prasetyo', 'uusrusmawan@smkn11kotabekasi.actudent.com', '$2y$10$TQiPrPCdBHcu9lkcfOTy7eFMmSCrRFmcgNBRjw8viXo2EVyvKxdd2', 2, 0, 'offline', '2019-03-27 17:00:00', '2020-02-10 02:25:34'),
(13, 'Sudrajat Papanya Raju', 'sudrajat@smkn11kotabekasi.actudent.com', '$2y$10$YlVwWrEAVKYLGQjemrufw.gLuBOHd/dCtSooI3TL0blkWHuYS/M3q', 2, 0, 'offline', '2019-03-28 17:00:00', '2020-02-10 02:25:34'),
(14, 'Bambang Tri', 'bambang@smkn11kotabekasi.actudent.com', '$2y$10$3qsfIV6tYUkZvCgs6uTu6.X4lnZnLP2.ZVDixeL/Obk0cuRlt0o1S', 3, 1, 'offline', '2020-02-08 05:04:31', '2020-02-10 02:59:53'),
(15, 'Sinto', 'sinto@smkn11kotabekasi.actudent.com', '$2y$10$ZUfIX77V.H8HZYsENgFoH.QhdH8jBpDrzKb3UXCb/yQISzuxTfnvy', 3, 1, 'offline', '2020-02-08 05:06:12', '2020-02-10 02:59:32'),
(16, 'Rizky Nur Hidayat', 'rizkynur@smkn11kotabekasi.actudent.com', '$2y$10$FQnHnmSSTgW6mUYb8B/Lxer3ltbmcBuijIrY4qQr4szfM063heMyC', 3, 1, 'offline', '2020-02-10 02:54:50', '2020-02-10 02:59:53'),
(17, 'Bernard Siahaan', 'bernard@smkn11kotabekasi.actudent.com', '$2y$10$4aBQchBOsJmjj5FSi4q3vOtp1oC4gaoz9FrobyyjgeIagp3SKY9Hy', 3, 1, 'offline', '2020-02-10 03:01:31', '2020-02-10 03:03:19'),
(23, 'Susanto Nurjaman', 'susantonur@smkn11kotabekasi.actudent.com', '$2y$10$OPDJcB9JSaS8m9KnqJbFHOMkC//xz6o69WOTzAIHqyOtZ63/6KE1u', 3, 0, 'offline', '2020-02-10 07:33:09', '2020-02-10 07:33:09'),
(24, 'Ahmad Ridho', 'ahmad.ridho@smkn11kotabekasi.actudent.com', '$2y$10$tiSdWeWFn9.l6KR.JQzkw.G6AEXJtQjwMz7otMwc8zUFwQt49EK/e', 3, 0, 'offline', '2020-02-10 07:34:15', '2020-02-10 07:34:15'),
(25, 'Fahruliansyah', 'fahruliansyah@smkn11kotabekasi.actudent.com', '$2y$10$sHnfCCQmtA1CCsGH5V/v7u5bjbDMhYJcGQ2rhGKeL2Y0mX8YmkkHO', 3, 0, 'offline', '2020-02-10 07:35:17', '2020-02-10 07:35:17'),
(26, 'Andreas Prasetyo', 'andreas.prasetya@smkn11kotabekasi.actudent.com', '$2y$10$f2Vf06NLCbTYGLO2opRWlOcxTsnlRPVpY0dQxeMUwmfYv1ooiiNk2', 3, 0, 'offline', '2020-02-10 07:35:53', '2020-02-10 07:35:53'),
(27, 'Emet Nur Cholis', 'emet.cholis@smkn11kotabekasi.actudent.com', '$2y$10$xeeenDsJ1.U3UaGAXarBWOf2GhtbdXnApe9G9aPfqvfHUlYW1p4Me', 3, 0, 'offline', '2020-02-10 07:38:11', '2020-02-10 07:38:11'),
(28, 'Gledek Nurmantyo', 'gledek.nur@smkn11kotabekasi.actudent.com', '$2y$10$VuBTeKY26z1.ZD7bigwanuBwZawaabZ4nO3/MiOPpWoEQTvbLC0Gi', 3, 0, 'offline', '2020-02-10 08:10:10', '2020-02-10 08:10:10'),
(29, 'asdgvfevbds', 'asdgvfevbds@smkn11kotabekasi.actudent.com', '$2y$10$m6dhzqnTeTeHSapp7ncDweLxGsmCk4cpCVjtMS22XGJx72KMXpG9W', 3, 0, 'offline', '2020-02-10 08:15:03', '2020-02-10 08:15:03'),
(30, 'Badut Siahaan', 'badut.siahaan@smkn11kotabekasi.actudent.com', '$2y$10$uRTcEtv.NxzipbhTI5mXPOrC7mWw4j7MSOJ5up8gztVR/YqZ.cg5a', 3, 0, 'offline', '2020-02-10 08:16:45', '2020-02-10 08:16:45'),
(31, 'Katmo', 'yuhu@smkn11kotabekasi.actudent.com', '$2y$10$QCZkcT17AjFTDqsMEk5B.OyPaplWSv5JmiN/LfOvH7Doi9hFBjdyu', 3, 0, 'offline', '2020-02-10 08:16:56', '2020-02-10 08:16:56'),
(32, 'Abdi Negara', 'abdinegara@smkn11kotabekasi.actudent.com', '$2y$10$1Lt/0LZQ5UxQxG.QSYJCc.8DKqfiLbIMtpvIfxa/02jiseyS1LmG6', 3, 0, 'offline', '2020-02-10 08:17:14', '2020-02-10 08:17:14'),
(33, 'Yono', 'ahay@smkn11kotabekasi.actudent.com', '$2y$10$fiKYu1o07/j5vAGRdjsbWugXl5msV3KBmh2.3YjP8xGxeDQmsgR4u', 3, 0, 'offline', '2020-02-10 08:17:33', '2020-02-10 08:17:33'),
(34, 'Amran Kartakarun', 'lelejepang@smkn11kotabekasi.actudent.com', '$2y$10$519EUkbcNvfhUDCnMWmU0.gGVBIxTlpvABpYfAbyVjsoaxLUq21GC', 3, 0, 'offline', '2020-02-10 08:17:53', '2020-02-10 08:17:53'),
(35, 'Jajang', 'bedul@smkn11kotabekasi.actudent.com', '$2y$10$VgvRgehTFqw.zT18.WhFneNCRTH6UAh8qosqAMqQQC9qEGBOZUmne', 3, 0, 'offline', '2020-02-10 08:18:10', '2020-02-10 08:18:10'),
(36, 'Sandrayono', 'didikempot@smkn11kotabekasi.actudent.com', '$2y$10$aJ2zsiCmT9vEkp2XeyK1WuVVG4ielaNRMK2C9BTCB/m3UMjl/zxSe', 3, 0, 'offline', '2020-02-10 08:19:23', '2020-02-10 08:19:23'),
(37, 'Anto', 'cekot@smkn11kotabekasi.actudent.com', '$2y$10$Gx4MOrOMnQUf5vUm3SjhXe8RDILcDHjctiEZ6zZxUb6y9GqCPjsZK', 3, 0, 'offline', '2020-02-10 08:19:31', '2020-02-10 08:19:31'),
(38, 'dgjhrsjthj', 'ihi@smkn11kotabekasi.actudent.com', '$2y$10$xSKCnhM0Puv6Ws4.9/lQxuykJf0NLUCRosZHnSNzDBB4ihZ5mvsMa', 3, 0, 'offline', '2020-02-10 08:20:15', '2020-02-10 08:20:15'),
(39, 'Mugiono Apriyani', 'mugiono.apriyani@smkn11kotabekasi.actudent.com', '$2y$10$FSiwxDs87YTx2k44TpACr.DVlvtjQyyAgNApefDpWuer4CC5Dz0Hu', 3, 0, 'offline', '2020-02-10 08:31:25', '2020-02-10 08:31:25');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_language`
--

CREATE TABLE `tb_user_language` (
  `user_lang_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_language` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user_language`
--

INSERT INTO `tb_user_language` (`user_lang_id`, `user_id`, `user_language`) VALUES
(1, 1, 'indonesia'),
(2, 2, 'english'),
(3, 3, 'english'),
(4, 4, 'indonesia');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_themes`
--

CREATE TABLE `tb_user_themes` (
  `user_themes_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `theme` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user_themes`
--

INSERT INTO `tb_user_themes` (`user_themes_id`, `user_id`, `theme`) VALUES
(1, 1, 'night-vision'),
(2, 2, 'night-vision'),
(3, 3, 'light-blue'),
(4, 4, 'light-blue');

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
-- Indexes for table `tb_grade`
--
ALTER TABLE `tb_grade`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `wali_kelas` (`teacher_id`);

--
-- Indexes for table `tb_parent`
--
ALTER TABLE `tb_parent`
  ADD PRIMARY KEY (`parent_id`,`user_id`,`parent_family_card`),
  ADD KEY `fk_parent` (`user_id`);

--
-- Indexes for table `tb_schedule`
--
ALTER TABLE `tb_schedule`
  ADD PRIMARY KEY (`schedule_id`,`grade_id`),
  ADD KEY `fk_schedule` (`grade_id`);

--
-- Indexes for table `tb_school`
--
ALTER TABLE `tb_school`
  ADD PRIMARY KEY (`school_id`);

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
  ADD PRIMARY KEY (`parent_id`),
  ADD KEY `fk_student_parent` (`student_id`);

--
-- Indexes for table `tb_teacher`
--
ALTER TABLE `tb_teacher`
  ADD PRIMARY KEY (`teacher_id`,`user_id`),
  ADD KEY `teacher_as_user` (`user_id`);

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
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tb_user_language`
--
ALTER TABLE `tb_user_language`
  ADD PRIMARY KEY (`user_lang_id`),
  ADD KEY `fk_user_language` (`user_id`);

--
-- Indexes for table `tb_user_themes`
--
ALTER TABLE `tb_user_themes`
  ADD PRIMARY KEY (`user_themes_id`),
  ADD KEY `fk_user_themes` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_agenda`
--
ALTER TABLE `tb_agenda`
  MODIFY `agenda_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tb_grade`
--
ALTER TABLE `tb_grade`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_parent`
--
ALTER TABLE `tb_parent`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tb_schedule`
--
ALTER TABLE `tb_schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_school`
--
ALTER TABLE `tb_school`
  MODIFY `school_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_student`
--
ALTER TABLE `tb_student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_teacher`
--
ALTER TABLE `tb_teacher`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_timeline`
--
ALTER TABLE `tb_timeline`
  MODIFY `timeline_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_timeline_comments`
--
ALTER TABLE `tb_timeline_comments`
  MODIFY `timeline_comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tb_user_language`
--
ALTER TABLE `tb_user_language`
  MODIFY `user_lang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_user_themes`
--
ALTER TABLE `tb_user_themes`
  MODIFY `user_themes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- Constraints for table `tb_grade`
--
ALTER TABLE `tb_grade`
  ADD CONSTRAINT `wali_kelas` FOREIGN KEY (`teacher_id`) REFERENCES `tb_teacher` (`teacher_id`);

--
-- Constraints for table `tb_parent`
--
ALTER TABLE `tb_parent`
  ADD CONSTRAINT `fk_parent` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_schedule`
--
ALTER TABLE `tb_schedule`
  ADD CONSTRAINT `fk_schedule` FOREIGN KEY (`grade_id`) REFERENCES `tb_grade` (`grade_id`);

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
  ADD CONSTRAINT `fk_student_parent` FOREIGN KEY (`student_id`) REFERENCES `tb_student` (`student_id`);

--
-- Constraints for table `tb_teacher`
--
ALTER TABLE `tb_teacher`
  ADD CONSTRAINT `teacher_as_user` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

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
-- Constraints for table `tb_user_language`
--
ALTER TABLE `tb_user_language`
  ADD CONSTRAINT `fk_user_language` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_user_themes`
--
ALTER TABLE `tb_user_themes`
  ADD CONSTRAINT `fk_user_themes` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
