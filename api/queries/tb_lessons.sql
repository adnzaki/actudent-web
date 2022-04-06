-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2020 at 05:53 PM
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
  `grade_id` int(11) NOT NULL,
  `lesson_name` varchar(100) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_lessons`
--

INSERT INTO `tb_lessons` (`lesson_id`, `grade_id`, `lesson_name`, `teacher_id`, `created`, `modified`) VALUES
(1, 3, 'Matematika', 2, '2020-03-13 07:14:46', '2020-03-20 23:10:21'),
(2, 3, 'RPL', 4, '2020-03-20 23:11:06', '2020-03-20 23:11:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_lessons`
--
ALTER TABLE `tb_lessons`
  ADD PRIMARY KEY (`lesson_id`),
  ADD KEY `fk_teacher_lesson` (`teacher_id`),
  ADD KEY `fk_grade_lesson` (`grade_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_lessons`
--
ALTER TABLE `tb_lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_lessons`
--
ALTER TABLE `tb_lessons`
  ADD CONSTRAINT `fk_grade_lesson` FOREIGN KEY (`grade_id`) REFERENCES `tb_grade` (`grade_id`),
  ADD CONSTRAINT `fk_teacher_lesson` FOREIGN KEY (`teacher_id`) REFERENCES `tb_staff` (`staff_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
