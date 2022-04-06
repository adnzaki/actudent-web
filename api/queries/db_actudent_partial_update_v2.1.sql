-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2020 at 04:06 PM
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
-- Table structure for table `tb_lessons_grade`
--

CREATE TABLE `tb_lessons_grade` (
  `lesson_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_lessons_grade`
--

INSERT INTO `tb_lessons_grade` (`lesson_id`, `grade_id`, `teacher_id`, `deleted`, `created`, `modified`) VALUES
(1, 3, 2, 0, '2020-03-13 07:14:46', '2020-04-01 21:49:35'),
(1, 3, 4, 0, '2020-03-20 23:11:06', '2020-04-01 21:49:35'),
(6, 6, 1, 1, '2020-03-29 17:16:06', '2020-04-03 19:00:28'),
(1, 6, 4, 1, '2020-03-29 18:05:37', '2020-04-03 19:00:28'),
(5, 6, 3, 1, '2020-03-29 18:07:09', '2020-04-03 19:00:28'),
(4, 2, 2, 1, '2020-03-29 18:09:03', '2020-04-03 19:16:16'),
(1, 2, 1, 1, '2020-04-01 22:01:58', '2020-04-03 19:16:16'),
(4, 6, 2, 1, '2020-04-01 22:15:02', '2020-04-03 19:00:14'),
(4, 6, 2, 0, '2020-04-03 19:33:31', '2020-04-03 19:33:31'),
(1, 6, 1, 0, '2020-04-03 19:33:47', '2020-04-03 19:33:47'),
(4, 2, 2, 0, '2020-04-03 19:39:28', '2020-04-03 19:39:28'),
(5, 2, 3, 0, '2020-04-03 19:39:40', '2020-04-03 19:39:40'),
(1, 2, 1, 0, '2020-04-03 19:39:49', '2020-04-03 19:39:49');

-- --------------------------------------------------------

--
-- Table structure for table `tb_student_grade`
--

CREATE TABLE `tb_student_grade` (
  `student_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `student_tag` tinyint(1) DEFAULT '1',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_student_grade`
--

INSERT INTO `tb_student_grade` (`student_id`, `grade_id`, `student_tag`, `deleted`, `created`, `modified`) VALUES
(1, 2, 1, 0, '2020-03-11 15:45:20', '2020-03-11 15:45:20'),
(3, 6, 1, 0, '2020-03-11 15:27:58', '2020-03-11 15:27:58'),
(6, 2, 1, 0, '2020-03-11 09:31:05', '2020-03-11 09:31:05'),
(7, 3, 1, 0, '2020-03-11 13:09:58', '2020-03-11 13:09:58'),
(8, 6, 1, 0, '2020-03-20 01:51:15', '2020-03-20 01:51:15'),
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
(32, 2, 1, 0, '2020-03-11 15:45:25', '2020-03-11 15:45:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_lessons_grade`
--
ALTER TABLE `tb_lessons_grade`
  ADD KEY `fk_teacher_lesson` (`teacher_id`),
  ADD KEY `fk_grade_lesson` (`grade_id`),
  ADD KEY `fk_lesson` (`lesson_id`);

--
-- Indexes for table `tb_student_grade`
--
ALTER TABLE `tb_student_grade`
  ADD PRIMARY KEY (`student_id`,`grade_id`),
  ADD KEY `fk_grade` (`grade_id`);

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

--
-- Constraints for table `tb_student_grade`
--
ALTER TABLE `tb_student_grade`
  ADD CONSTRAINT `fk_grade` FOREIGN KEY (`grade_id`) REFERENCES `tb_grade` (`grade_id`),
  ADD CONSTRAINT `fk_student` FOREIGN KEY (`student_id`) REFERENCES `tb_student` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
