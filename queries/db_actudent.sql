-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2018 at 02:57 AM
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
-- Table structure for table `tb_grade`
--

CREATE TABLE `tb_grade` (
  `gradeID` int(11) NOT NULL,
  `schoolID` int(11) DEFAULT NULL,
  `gradeName` varchar(20) DEFAULT NULL,
  `periodFrom` varchar(4) DEFAULT NULL,
  `periodUntil` varchar(4) DEFAULT NULL,
  `gradeStatus` tinyint(1) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_grade`
--

INSERT INTO `tb_grade` (`gradeID`, `schoolID`, `gradeName`, `periodFrom`, `periodUntil`, `gradeStatus`, `created`, `modified`) VALUES
(1, 1, 'TKJ1', '2018', '2019', 1, '2018-10-14 04:17:35', '0000-00-00 00:00:00'),
(2, 1, 'XI Grafika1', '2018', '2019', 1, '2018-10-20 03:13:51', '2018-10-19 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_parent`
--

CREATE TABLE `tb_parent` (
  `parentID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `familyCard` varchar(18) NOT NULL,
  `fatherName` varchar(100) DEFAULT NULL,
  `motherName` varchar(100) DEFAULT NULL,
  `parentTelp` varchar(15) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_schedule`
--

CREATE TABLE `tb_schedule` (
  `scheduleID` int(11) NOT NULL,
  `gradeID` int(11) NOT NULL,
  `semester` int(11) DEFAULT NULL,
  `schedule` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_school`
--

CREATE TABLE `tb_school` (
  `schoolID` int(11) NOT NULL,
  `schoolName` varchar(300) NOT NULL,
  `schoolType` enum('Sekolah Dasar','Sekolah Menengah Pertama','Sekolah Manengah Atas') NOT NULL,
  `schoolAddress` varchar(500) DEFAULT NULL,
  `schoolTelephone` varchar(30) DEFAULT NULL,
  `schoolStatus` tinyint(1) NOT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_school`
--

INSERT INTO `tb_school` (`schoolID`, `schoolName`, `schoolType`, `schoolAddress`, `schoolTelephone`, `schoolStatus`, `created`, `modified`) VALUES
(1, 'SMK Negeri 999 Kota Bekasi', 'Sekolah Manengah Atas', 'Pekayon, Bekasi Selatan', '021-80000000', 1, '2018-10-09 17:00:00', '2018-10-09 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_settings`
--

CREATE TABLE `tb_settings` (
  `settingID` int(11) NOT NULL,
  `settingKey` varchar(50) DEFAULT NULL,
  `settingValue` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_student`
--

CREATE TABLE `tb_student` (
  `studentID` int(11) NOT NULL,
  `schoolID` int(11) DEFAULT NULL,
  `studentNis` varchar(20) DEFAULT NULL,
  `studentName` varchar(100) DEFAULT NULL,
  `studentStatus` tinyint(1) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_student`
--

INSERT INTO `tb_student` (`studentID`, `schoolID`, `studentNis`, `studentName`, `studentStatus`, `created`, `modified`) VALUES
(1, 1, '2015420022', 'Adnan Zaki keren', 1, '2018-10-20 04:19:34', '0000-00-00 00:00:00'),
(2, 1, '2015420003', 'Saka Putra ', 1, '2018-10-20 03:23:30', '0000-00-00 00:00:00'),
(3, 1, '2015420004', 'Bima Sakti', 1, '2018-10-14 03:02:10', '0000-00-00 00:00:00'),
(4, 1, '2015420015', 'Widya Sari Wangi', 1, '2018-10-19 09:32:46', '0000-00-00 00:00:00'),
(5, 1, '2015420049', 'Joko Tole', 0, '2018-10-14 03:03:36', '0000-00-00 00:00:00'),
(6, 1, '2014310039', 'Dani Rusmawan', 1, '2018-10-20 03:11:18', '2018-10-19 17:00:00'),
(7, 1, '2014310012', 'Mukhlisin', 1, '2018-10-20 03:11:23', '2018-10-19 17:00:00'),
(8, 1, '2015310028', 'Rino Ardiansyah', 1, '2018-10-20 04:20:22', '2018-10-19 17:00:00'),
(9, 1, '2015310029', 'Raju Herningtyas Pratama', 1, '2018-10-20 03:11:44', '2018-10-19 17:00:00'),
(10, 1, '2014310088', 'Ridwan Kamil', 1, '2018-10-20 03:11:48', '2018-10-19 17:00:00'),
(11, 1, '2015310098', 'Firhan Yudha', 1, '2018-10-20 13:53:06', '2018-10-19 17:00:00'),
(12, 1, '2014220038', 'Try Albahri', 1, '2018-10-20 13:53:06', '2018-10-19 17:00:00'),
(13, 1, '2015190029', 'Wahyudi', 1, '2018-10-20 13:53:06', '2018-10-19 17:00:00'),
(14, 1, '2015310124', 'AAAAAAAAAAAAAAAAA', 1, '2018-11-13 16:53:15', '2018-11-12 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_student_grade`
--

CREATE TABLE `tb_student_grade` (
  `studentID` int(11) NOT NULL,
  `gradeID` int(11) NOT NULL,
  `studentGradeStatus` tinyint(1) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_student_grade`
--

INSERT INTO `tb_student_grade` (`studentID`, `gradeID`, `studentGradeStatus`, `created`, `modified`) VALUES
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
(13, 1, 1, '2018-10-20 13:54:02', '2018-10-19 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `userID` int(11) NOT NULL,
  `schoolID` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userPassword` varchar(100) NOT NULL,
  `userLevel` tinyint(4) NOT NULL,
  `userStatus` tinyint(4) NOT NULL,
  `network` varchar(10) NOT NULL DEFAULT 'offline',
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`userID`, `schoolID`, `userName`, `userEmail`, `userPassword`, `userLevel`, `userStatus`, `network`, `created`, `modified`) VALUES
(1, 1, 'Adnan Zaki', 'admin@wolestech.com', '$2y$10$4l1uN20KpNheU3EaSQkF6OuNPYjyBqvb3ePCHgXPAy/4tm95ROkZa', 1, 1, 'online', '2018-10-10 17:00:00', '2018-10-10 17:00:00'),
(2, 1, 'Mukhlisin', 'mukliz@wolestech.com', '$2y$10$IONmp6/MwfAY3ZQ4wH/Tr.mJhn8BPIgP0QR8IswX2kR.tI/ohjh6u', 1, 1, 'offline', '2018-10-30 17:00:00', '2018-10-30 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_student`
--

CREATE TABLE `tb_user_student` (
  `userID` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  `userStudentStatus` tinyint(1) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_themes`
--

CREATE TABLE `tb_user_themes` (
  `userThemesID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `theme` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user_themes`
--

INSERT INTO `tb_user_themes` (`userThemesID`, `userID`, `theme`) VALUES
(1, 1, 'night-vision'),
(2, 2, 'light-blue');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_grade`
--
ALTER TABLE `tb_grade`
  ADD PRIMARY KEY (`gradeID`),
  ADD KEY `schoolID` (`schoolID`);

--
-- Indexes for table `tb_parent`
--
ALTER TABLE `tb_parent`
  ADD PRIMARY KEY (`parentID`,`userID`,`familyCard`),
  ADD KEY `fk_parent` (`userID`);

--
-- Indexes for table `tb_schedule`
--
ALTER TABLE `tb_schedule`
  ADD PRIMARY KEY (`scheduleID`,`gradeID`),
  ADD KEY `fk_schedule` (`gradeID`);

--
-- Indexes for table `tb_school`
--
ALTER TABLE `tb_school`
  ADD PRIMARY KEY (`schoolID`);

--
-- Indexes for table `tb_settings`
--
ALTER TABLE `tb_settings`
  ADD PRIMARY KEY (`settingID`);

--
-- Indexes for table `tb_student`
--
ALTER TABLE `tb_student`
  ADD PRIMARY KEY (`studentID`),
  ADD KEY `fk_student_school` (`schoolID`);

--
-- Indexes for table `tb_student_grade`
--
ALTER TABLE `tb_student_grade`
  ADD PRIMARY KEY (`studentID`,`gradeID`),
  ADD KEY `fk_grade` (`gradeID`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `fkUser_to_School` (`schoolID`);

--
-- Indexes for table `tb_user_student`
--
ALTER TABLE `tb_user_student`
  ADD PRIMARY KEY (`userID`,`studentID`),
  ADD KEY `fk_student_user` (`studentID`);

--
-- Indexes for table `tb_user_themes`
--
ALTER TABLE `tb_user_themes`
  ADD PRIMARY KEY (`userThemesID`),
  ADD KEY `fk_user_themes` (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_grade`
--
ALTER TABLE `tb_grade`
  MODIFY `gradeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_parent`
--
ALTER TABLE `tb_parent`
  MODIFY `parentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_schedule`
--
ALTER TABLE `tb_schedule`
  MODIFY `scheduleID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_school`
--
ALTER TABLE `tb_school`
  MODIFY `schoolID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_settings`
--
ALTER TABLE `tb_settings`
  MODIFY `settingID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_student`
--
ALTER TABLE `tb_student`
  MODIFY `studentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_student_grade`
--
ALTER TABLE `tb_student_grade`
  MODIFY `studentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_user_themes`
--
ALTER TABLE `tb_user_themes`
  MODIFY `userThemesID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_grade`
--
ALTER TABLE `tb_grade`
  ADD CONSTRAINT `tb_grade_ibfk_1` FOREIGN KEY (`schoolID`) REFERENCES `tb_school` (`schoolID`);

--
-- Constraints for table `tb_parent`
--
ALTER TABLE `tb_parent`
  ADD CONSTRAINT `fk_parent` FOREIGN KEY (`userID`) REFERENCES `tb_user` (`userID`);

--
-- Constraints for table `tb_schedule`
--
ALTER TABLE `tb_schedule`
  ADD CONSTRAINT `fk_schedule` FOREIGN KEY (`gradeID`) REFERENCES `tb_grade` (`gradeID`);

--
-- Constraints for table `tb_student`
--
ALTER TABLE `tb_student`
  ADD CONSTRAINT `fk_student_school` FOREIGN KEY (`schoolID`) REFERENCES `tb_school` (`schoolID`);

--
-- Constraints for table `tb_student_grade`
--
ALTER TABLE `tb_student_grade`
  ADD CONSTRAINT `fk_grade` FOREIGN KEY (`gradeID`) REFERENCES `tb_grade` (`gradeID`),
  ADD CONSTRAINT `fk_student` FOREIGN KEY (`studentID`) REFERENCES `tb_student` (`studentID`);

--
-- Constraints for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `fkUser_to_School` FOREIGN KEY (`schoolID`) REFERENCES `tb_school` (`schoolID`);

--
-- Constraints for table `tb_user_student`
--
ALTER TABLE `tb_user_student`
  ADD CONSTRAINT `fk_student_user` FOREIGN KEY (`studentID`) REFERENCES `tb_student` (`studentID`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`userID`) REFERENCES `tb_user` (`userID`);

--
-- Constraints for table `tb_user_themes`
--
ALTER TABLE `tb_user_themes`
  ADD CONSTRAINT `fk_user_themes` FOREIGN KEY (`userID`) REFERENCES `tb_user` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
