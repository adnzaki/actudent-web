-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2020 at 01:47 PM
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
-- Table structure for table `tb_lessons`
--

CREATE TABLE `tb_lessons` (
  `lesson_id` int(11) NOT NULL,
  `lesson_code` varchar(50) NOT NULL,
  `lesson_name` varchar(100) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_lessons`
--

INSERT INTO `tb_lessons` (`lesson_id`, `lesson_code`, `lesson_name`, `created`, `modified`) VALUES
(1, 'MTK', 'Matematika', '2020-03-21 12:44:18', '2020-03-21 12:44:18'),
(2, 'BIND', 'Bahasa Indonesia', '2020-03-21 12:44:18', '2020-03-21 12:44:18'),
(3, 'BING', 'Bahasa Inggris', '2020-03-21 12:44:18', '2020-03-21 12:44:18'),
(4, 'PAI', 'Pendidikan Agama Islam', '2020-03-21 12:44:18', '2020-03-21 12:44:18'),
(5, 'PKN', 'Pendidikan Kewarganegaraan', '2020-03-21 12:44:18', '2020-03-21 12:44:18'),
(6, 'PJOK', 'Pendidikan Jasmani, Olahraga dan Kesehatan', '2020-03-21 12:44:18', '2020-03-21 12:44:18');

-- --------------------------------------------------------

--
-- Table structure for table `tb_lessons_grade`
--

CREATE TABLE `tb_lessons_grade` (
  `lesson_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_lessons_grade`
--

INSERT INTO `tb_lessons_grade` (`lesson_id`, `grade_id`, `teacher_id`, `created`, `modified`) VALUES
(1, 3, 2, '2020-03-13 07:14:46', '2020-03-20 23:10:21'),
(2, 3, 4, '2020-03-20 23:11:06', '2020-03-20 23:11:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_lessons`
--
ALTER TABLE `tb_lessons`
  ADD PRIMARY KEY (`lesson_id`);

--
-- Indexes for table `tb_lessons_grade`
--
ALTER TABLE `tb_lessons_grade`
  ADD KEY `fk_teacher_lesson` (`teacher_id`),
  ADD KEY `fk_grade_lesson` (`grade_id`),
  ADD KEY `fk_lesson` (`lesson_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_lessons`
--
ALTER TABLE `tb_lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_lessons_grade`
--
ALTER TABLE `tb_lessons_grade`
  ADD CONSTRAINT `fk_grade_lesson` FOREIGN KEY (`grade_id`) REFERENCES `tb_grade` (`grade_id`),
  ADD CONSTRAINT `fk_lesson` FOREIGN KEY (`lesson_id`) REFERENCES `tb_lessons` (`lesson_id`),
  ADD CONSTRAINT `fk_teacher_lesson` FOREIGN KEY (`teacher_id`) REFERENCES `tb_staff` (`staff_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
