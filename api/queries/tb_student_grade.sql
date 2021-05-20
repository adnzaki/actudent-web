-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2020 at 04:29 PM
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
(3, 6, 1, '2020-03-11 15:27:58', '2020-03-11 15:27:58'),
(6, 2, 1, '2020-03-11 09:31:05', '2020-03-11 09:31:05'),
(7, 3, 1, '2020-03-11 13:09:58', '2020-03-11 13:09:58'),
(9, 3, 1, '2020-03-11 13:10:18', '2020-03-11 13:10:18'),
(11, 6, 1, '2020-03-11 15:28:00', '2020-03-11 15:28:00'),
(12, 3, 1, '2020-03-11 13:10:16', '2020-03-11 13:10:16'),
(17, 2, 1, '2020-03-11 09:31:02', '2020-03-11 09:31:02'),
(21, 3, 1, '2020-03-11 13:10:00', '2020-03-11 13:10:00'),
(24, 6, 1, '2020-03-11 15:28:02', '2020-03-11 15:28:02'),
(25, 6, 1, '2020-03-11 15:22:16', '2020-03-11 15:22:16'),
(27, 3, 1, '2020-03-11 13:10:20', '2020-03-11 13:10:20'),
(28, 6, 1, '2020-03-11 15:22:14', '2020-03-11 15:22:14'),
(29, 3, 1, '2020-03-11 13:10:17', '2020-03-11 13:10:17');

--
-- Indexes for dumped tables
--

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
-- Constraints for table `tb_student_grade`
--
ALTER TABLE `tb_student_grade`
  ADD CONSTRAINT `fk_grade` FOREIGN KEY (`grade_id`) REFERENCES `tb_grade` (`grade_id`),
  ADD CONSTRAINT `fk_student` FOREIGN KEY (`student_id`) REFERENCES `tb_student` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
