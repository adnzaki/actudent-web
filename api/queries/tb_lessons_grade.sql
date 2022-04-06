-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2020 at 06:44 AM
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
  `lessons_grade_id` int(11) NOT NULL,
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

INSERT INTO `tb_lessons_grade` (`lessons_grade_id`, `lesson_id`, `grade_id`, `teacher_id`, `deleted`, `created`, `modified`) VALUES
(1, 4, 3, 2, 1, '2020-03-13 07:14:46', '2020-04-03 22:28:54'),
(2, 4, 3, 2, 1, '2020-03-20 23:11:06', '2020-04-03 22:28:54'),
(3, 6, 6, 1, 1, '2020-03-29 17:16:06', '2020-04-03 19:00:28'),
(4, 1, 6, 4, 1, '2020-03-29 18:05:37', '2020-04-03 19:00:28'),
(5, 5, 6, 3, 1, '2020-03-29 18:07:09', '2020-04-03 19:00:28'),
(6, 4, 2, 2, 1, '2020-03-29 18:09:03', '2020-04-03 19:16:16'),
(7, 1, 2, 1, 1, '2020-04-01 22:01:58', '2020-04-03 19:16:16'),
(8, 4, 6, 2, 1, '2020-04-01 22:15:02', '2020-04-03 19:00:14'),
(9, 4, 6, 2, 1, '2020-04-03 19:33:31', '2020-04-05 11:43:49'),
(10, 1, 6, 1, 1, '2020-04-03 19:33:47', '2020-04-05 11:43:49'),
(11, 4, 2, 2, 0, '2020-04-03 19:39:28', '2020-04-03 19:39:28'),
(12, 5, 2, 3, 0, '2020-04-03 19:39:40', '2020-04-03 19:39:40'),
(13, 1, 2, 1, 0, '2020-04-03 19:39:49', '2020-04-03 19:39:49'),
(14, 5, 6, 3, 0, '2020-04-04 20:11:35', '2020-04-04 20:11:35'),
(15, 2, 6, 4, 1, '2020-04-05 11:05:21', '2020-04-05 11:43:49'),
(16, 3, 6, 1, 1, '2020-04-05 11:16:37', '2020-04-05 11:43:35'),
(17, 4, 6, 2, 0, '2020-04-05 11:43:59', '2020-04-05 11:43:59'),
(18, 1, 6, 1, 0, '2020-04-05 11:44:09', '2020-04-05 11:44:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_lessons_grade`
--
ALTER TABLE `tb_lessons_grade`
  ADD PRIMARY KEY (`lessons_grade_id`),
  ADD KEY `fk_teacher_lesson` (`teacher_id`),
  ADD KEY `fk_grade_lesson` (`grade_id`),
  ADD KEY `fk_lesson` (`lesson_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_lessons_grade`
--
ALTER TABLE `tb_lessons_grade`
  MODIFY `lessons_grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
