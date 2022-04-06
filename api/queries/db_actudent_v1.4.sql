-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2019 at 02:48 AM
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
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_agenda`
--

INSERT INTO `tb_agenda` (`agenda_id`, `agenda_name`, `agenda_start`, `agenda_end`, `agenda_description`, `agenda_priority`, `agenda_location`, `agenda_attachment`, `user_id`, `created`, `modified`) VALUES
(1, 'Rapat Kenaikan Kelas', '2019-02-18 09:00:00', '2019-02-18 14:00:00', 'Kepada Yth. Bapak/Ibu guru agar dapat menghadiri kegiatan Rapat Kenaikan Kelas yang akan dilaksanakan hari ini mulai pukul 09.00 WIB. Dimohon hadir tepat waktu.', 'high', 'Ruang Rapat SMKN 1 Kota Bekasi', NULL, 1, '2019-02-18 00:00:00', '2019-02-18 00:00:00'),
(2, 'Pembinaan Guru', '2019-03-04 08:00:00', '2019-03-04 10:00:00', 'Pembinaan guru dan tenaga kependidikan SMK', 'high', 'Aula Sekolah', NULL, 1, '2019-02-27 00:00:00', '2019-02-27 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_agenda_user`
--

CREATE TABLE `tb_agenda_user` (
  `agenda_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_grade`
--

INSERT INTO `tb_grade` (`grade_id`, `grade_name`, `period_from`, `period_until`, `teacher_id`, `grade_status`, `created`, `modified`) VALUES
(1, 'TKJ1', '2018', '2019', 1, 1, '2019-03-28 07:37:51', '0000-00-00 00:00:00'),
(2, 'XI Grafika1', '2018', '2019', 2, 1, '2019-03-28 07:37:57', '2018-10-19 17:00:00');

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
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_parent`
--

INSERT INTO `tb_parent` (`parent_id`, `user_id`, `parent_family_card`, `parent_father_name`, `parent_mother_name`, `parent_phone_number`, `created`, `modified`) VALUES
(1, 5, '3275040605940018', 'Adrian Sumartani', 'Asmirandah', '081232938765', '2019-03-28 03:37:05', '2019-03-28 03:37:05'),
(2, 6, '3275040605943018', 'Rian Sugalih', 'Rina Rosinta', '082387428723', '2019-03-28 03:37:05', '2019-03-28 03:37:05'),
(3, 7, '3275040605940018', 'Rojak', 'Indri Maulida', '082340034239', '2019-03-28 04:02:05', '2019-03-28 04:02:05'),
(4, 8, '3275040605943018', 'Susanto Nurjaman', 'Rizka Yulianti', '0830424823439', '2019-03-28 04:02:05', '2019-03-28 04:02:05'),
(5, 9, '3275040605943014', 'Abdul Karim', 'Santi', '083208329435', '2019-03-28 04:02:05', '2019-03-28 04:02:05'),
(6, 10, '3275040605943018', 'Benny Saputra', 'Fitria Hanafi', '0803042390485', '2019-03-28 04:02:05', '2019-03-28 04:02:05'),
(7, 11, '3275040605943018', 'Andika Prasetyo', 'Yuli Ismania', '082384945843', '2019-03-28 04:02:05', '2019-03-28 04:02:05');

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
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_school`
--

INSERT INTO `tb_school` (`school_id`, `school_name`, `school_type`, `school_address`, `school_telephone`, `school_status`, `created`, `modified`) VALUES
(1, 'SMK Negeri 999 Kota Bekasi', 'Sekolah Manengah Atas', 'Pekayon, Bekasi Selatan', '021-80000000', 1, '2018-10-09 17:00:00', '2018-10-09 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_student`
--

CREATE TABLE `tb_student` (
  `student_id` int(11) NOT NULL,
  `student_nis` varchar(20) DEFAULT NULL,
  `student_name` varchar(100) DEFAULT NULL,
  `student_status` tinyint(1) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_student`
--

INSERT INTO `tb_student` (`student_id`, `student_nis`, `student_name`, `student_status`, `created`, `modified`) VALUES
(1, '2015420022', 'Adnan Zaki keren', 1, '2018-10-20 04:19:34', '0000-00-00 00:00:00'),
(2, '2015420003', 'Saka Putra ', 1, '2018-10-20 03:23:30', '0000-00-00 00:00:00'),
(3, '2015420004', 'Bima Sakti', 1, '2018-10-14 03:02:10', '0000-00-00 00:00:00'),
(4, '2015420015', 'Widya Sari Wangi', 1, '2018-10-19 09:32:46', '0000-00-00 00:00:00'),
(5, '2015420049', 'Joko Tole', 0, '2018-10-14 03:03:36', '0000-00-00 00:00:00'),
(6, '2014310039', 'Dani Rusmawan', 1, '2018-10-20 03:11:18', '2018-10-19 17:00:00'),
(7, '2014310012', 'Mukhlisin', 1, '2018-10-20 03:11:23', '2018-10-19 17:00:00'),
(8, '2015310028', 'Rino Ardiansyah', 1, '2018-10-20 04:20:22', '2018-10-19 17:00:00'),
(9, '2015310029', 'Raju Herningtyas Pratama', 1, '2018-10-20 03:11:44', '2018-10-19 17:00:00'),
(10, '2014310088', 'Ridwan Kamil', 1, '2018-10-20 03:11:48', '2018-10-19 17:00:00'),
(11, '2015310098', 'Firhan Yudha', 1, '2018-10-20 13:53:06', '2018-10-19 17:00:00'),
(12, '2014220038', 'Try Albahri', 1, '2018-10-20 13:53:06', '2018-10-19 17:00:00'),
(13, '2015190029', 'Wahyudi', 1, '2018-10-20 13:53:06', '2018-10-19 17:00:00'),
(14, '2015310124', 'AAAAAAAAAAAAAAAAA', 1, '2018-11-13 16:53:15', '2018-11-12 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_student_grade`
--

CREATE TABLE `tb_student_grade` (
  `student_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `student_grade_status` tinyint(1) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_student_grade`
--

INSERT INTO `tb_student_grade` (`student_id`, `grade_id`, `student_grade_status`, `created`, `modified`) VALUES
(1, 1, 1, '2018-10-14 04:18:39', '0000-00-00 00:00:00'),
(2, 1, 1, '2018-10-14 04:19:09', '0000-00-00 00:00:00'),
(3, 1, 1, '2018-10-14 04:19:25', '0000-00-00 00:00:00'),
(4, 1, 1, '2018-10-14 04:19:50', '0000-00-00 00:00:00'),
(5, 1, 0, '2018-10-14 04:20:04', '0000-00-00 00:00:00'),
(6, 2, 1, '2018-10-20 03:15:10', '0000-00-00 00:00:00'),
(7, 1, 1, '2018-10-20 03:15:10', '0000-00-00 00:00:00'),
(8, 2, 1, '2018-10-20 03:15:10', '0000-00-00 00:00:00'),
(9, 2, 1, '2018-10-20 03:15:10', '0000-00-00 00:00:00'),
(10, 2, 1, '2018-10-20 03:16:16', '0000-00-00 00:00:00'),
(11, 2, 1, '2018-10-20 13:53:36', '2018-10-19 17:00:00'),
(12, 1, 1, '2018-10-20 13:54:02', '2018-10-19 17:00:00'),
(13, 1, 1, '2018-10-20 13:54:02', '2018-10-19 17:00:00'),
(14, 1, 1, '2019-03-28 04:58:42', '2019-03-27 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_teacher`
--

CREATE TABLE `tb_teacher` (
  `teacher_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `teacher_name` varchar(50) DEFAULT NULL,
  `teacher_phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_teacher`
--

INSERT INTO `tb_teacher` (`teacher_id`, `user_id`, `teacher_name`, `teacher_phone`) VALUES
(1, 4, 'Firhan Yudha P.', '08230298484'),
(2, 12, 'Uus Rusmawan Prasetyo', '083290489348');

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
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_timeline`
--

INSERT INTO `tb_timeline` (`timeline_id`, `timeline_title`, `timeline_content`, `timeline_date`, `timeline_status`, `timeline_image`, `user_id`, `created`, `modified`) VALUES
(1, 'Kisah seorang pemuda', 'ada anak bertanya pada bapaknya...', '2019-02-18 05:00:00', 'public', NULL, 1, '2019-02-18 00:00:00', '2019-02-18 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_timeline_comments`
--

CREATE TABLE `tb_timeline_comments` (
  `timeline_comment_id` int(11) NOT NULL,
  `timeline_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_content` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_timeline_comments`
--

INSERT INTO `tb_timeline_comments` (`timeline_comment_id`, `timeline_id`, `user_id`, `comment_content`, `created`, `modified`) VALUES
(1, 1, 2, 'aduh lucu bgt deh ceritanya sis...', '2019-02-18 00:00:00', '2019-02-18 00:00:00'),
(2, 1, 1, 'iya ihhhh', '2019-02-18 00:00:00', '2019-02-18 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_timeline_likes`
--

CREATE TABLE `tb_timeline_likes` (
  `timeline_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
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
  `user_status` tinyint(4) NOT NULL,
  `network` varchar(10) NOT NULL DEFAULT 'offline',
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `user_name`, `user_email`, `user_password`, `user_level`, `user_status`, `network`, `created`, `modified`) VALUES
(1, 'Adnan Zaki', 'admin@wolestech.com', '$2y$10$4l1uN20KpNheU3EaSQkF6OuNPYjyBqvb3ePCHgXPAy/4tm95ROkZa', 1, 1, 'online', '2018-10-10 17:00:00', '2018-10-10 17:00:00'),
(2, 'Mukhlisin', 'mukliz@wolestech.com', '$2y$10$8n/ojdr/Cb6DjfBIjVKkvekVHXfjXAATlWlnsMZAvV9ioz7Zv/La2', 1, 1, 'offline', '2018-10-30 17:00:00', '2018-10-30 17:00:00'),
(3, 'Dany Prastio', 'danyprastio@wolestech.com', '$2y$10$3Sfe/cMO/PLunpye4PjZY.oTTzP8ze5XXMCf01x8t/eNpxOk2PoAy', 1, 1, 'offline', '2018-10-30 17:00:00', '2018-10-30 17:00:00'),
(4, 'Firhan Yudha P.', 'firhanyp@wolestech.com', '$2y$10$I/mLXlaxAjTonC0DAWx7JOM/z7xi.PGwj8LZwsKNGFVdid38KI4Z2', 2, 1, 'online', '2019-03-17 17:00:00', '2019-03-17 17:00:00'),
(5, 'Asmirandah', 'asmirandah@smkn999bekasi.actudent.com', '$2y$10$h6ww/v7.CN7nqs9q2bqJw.11dmkh6VtuMPmTk7pxU8SmH3kxQrrN.', 3, 1, 'offline', '2019-03-27 17:00:00', '2019-03-27 17:00:00'),
(6, 'Rian Sugalih', 'riansugalih@smkn999bekasi.actudent.com', '$2y$10$AcqlGhZTmpAyv7zWCCIhbOx/zqMwoA36mq4D2Buep69mBpOzgBoxa ', 3, 1, 'offline', '2019-03-21 17:00:00', '2019-03-21 17:00:00'),
(7, 'Indri Maulida', 'indrimaulida@smkn999bekasi.actudent.com', '$2y$10$GMXk1g8B2GbE8MYKD6vqyeaLezrfZvcyqdM6vBKtDgpSoSwJXhVIa', 3, 1, 'offline', '2019-03-27 17:00:00', '2019-03-27 17:00:00'),
(8, 'Susanto Nurjaman', 'susanto@smkn999bekasi.actudent.com', '$2y$10$zpQNIqTtwfyYh5hYxcyB3.jqYnj9quKID/RGFiaBfDlnaO5iHMEee', 3, 1, 'offline', '2019-03-27 17:00:00', '2019-03-27 17:00:00'),
(9, 'Abdul Karim', 'abdulkarim@smkn999bekasi.actudent.com', '$2y$10$T5oy4eDFM0bcBcRTLvjOUuFO0iYdElsv88oAW5sn0IRhURhMl/lQe', 3, 1, 'offline', '2019-03-27 17:00:00', '2019-03-27 17:00:00'),
(10, 'Benny Saputra', 'bennysaputra@smkn999bekasi.actudent.com', '$2y$10$Uq6hlQ1eI7uupe/xK9AC2.Xw4ejB8tGWDIbpJQ4lXVFllYAKV8zSS', 3, 1, 'offline', '2019-03-27 17:00:00', '2019-03-27 17:00:00'),
(11, 'Andika Prasetyo', 'andika@smkn999bekasi.actudent.com', '$2y$10$XF.YeQFOvhlH0UG3A4Z7DOG1nysZGOaZYZRoTvWSIXdYFni706qQi', 3, 1, 'offline', '2019-03-27 17:00:00', '2019-03-27 17:00:00'),
(12, 'Uus Rusmawan Prasetyo', 'uusrusmawan@smkn999bekasi.actudent.com', '$2y$10$TQiPrPCdBHcu9lkcfOTy7eFMmSCrRFmcgNBRjw8viXo2EVyvKxdd2', 2, 1, 'offline', '2019-03-27 17:00:00', '2019-03-27 17:00:00');

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
(1, 1, 'english'),
(2, 2, 'english'),
(3, 3, 'english'),
(4, 4, 'indonesia');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_student`
--

CREATE TABLE `tb_user_student` (
  `user_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `user_student_status` tinyint(1) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user_student`
--

INSERT INTO `tb_user_student` (`user_id`, `student_id`, `user_student_status`, `created`, `modified`) VALUES
(5, 1, 1, '2019-03-28 03:51:05', '2019-03-28 03:51:05'),
(5, 2, 1, '2019-03-28 03:51:05', '2019-03-28 03:51:05'),
(6, 3, 1, '2019-03-28 03:51:05', '2019-03-28 03:51:05'),
(7, 4, 1, '2019-03-28 04:38:22', '2019-03-28 04:38:22'),
(8, 5, 1, '2019-03-28 04:38:22', '2019-03-28 04:38:22'),
(8, 6, 1, '2019-03-28 04:38:22', '2019-03-28 04:38:22'),
(8, 7, 1, '2019-03-28 04:38:22', '2019-03-28 04:38:22'),
(9, 8, 1, '2019-03-28 04:38:22', '2019-03-28 04:38:22'),
(9, 9, 1, '2019-03-28 04:38:22', '2019-03-28 04:38:22'),
(9, 10, 1, '2019-03-28 04:38:22', '2019-03-28 04:38:22'),
(10, 11, 1, '2019-03-28 04:38:22', '2019-03-28 04:38:22'),
(10, 12, 1, '2019-03-28 04:38:22', '2019-03-28 04:38:22'),
(11, 13, 1, '2019-03-28 04:38:22', '2019-03-28 04:38:22'),
(11, 14, 1, '2019-03-28 04:38:35', '2019-03-28 04:38:22');

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
  ADD PRIMARY KEY (`agenda_id`,`user_id`),
  ADD KEY `fk_user_in_agenda` (`user_id`);

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
-- Indexes for table `tb_user_student`
--
ALTER TABLE `tb_user_student`
  ADD PRIMARY KEY (`user_id`,`student_id`),
  ADD KEY `fk_student_user` (`student_id`);

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
  MODIFY `agenda_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_grade`
--
ALTER TABLE `tb_grade`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_parent`
--
ALTER TABLE `tb_parent`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_timeline`
--
ALTER TABLE `tb_timeline`
  MODIFY `timeline_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_timeline_comments`
--
ALTER TABLE `tb_timeline_comments`
  MODIFY `timeline_comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  ADD CONSTRAINT `fk_agenda` FOREIGN KEY (`agenda_id`) REFERENCES `tb_agenda` (`agenda_id`),
  ADD CONSTRAINT `fk_user_in_agenda` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

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
-- Constraints for table `tb_user_student`
--
ALTER TABLE `tb_user_student`
  ADD CONSTRAINT `fk_student_user` FOREIGN KEY (`student_id`) REFERENCES `tb_student` (`student_id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_user_themes`
--
ALTER TABLE `tb_user_themes`
  ADD CONSTRAINT `fk_user_themes` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
