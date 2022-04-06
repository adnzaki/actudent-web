-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2020 at 09:48 AM
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
-- Table structure for table `tb_student_parent`
--

CREATE TABLE `tb_student_parent` (
  `parent_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_student_parent`
--

INSERT INTO `tb_student_parent` (`parent_id`, `student_id`, `deleted`, `created`, `modified`) VALUES
(10, 1, 0, '2020-02-19 10:28:53', '2020-02-19 10:28:53'),
(11, 2, 0, '2020-02-19 10:28:53', '2020-02-19 10:28:53'),
(12, 3, 0, '2020-02-19 10:30:53', '2020-02-19 10:30:53'),
(13, 17, 0, '2020-02-18 14:45:41', '2020-02-18 14:45:41'),
(14, 6, 0, '2020-02-19 10:35:20', '2020-02-19 10:35:20'),
(15, 7, 0, '2020-02-19 10:35:21', '2020-02-19 10:35:21'),
(16, 8, 0, '2020-02-19 10:35:21', '2020-02-19 10:35:21'),
(17, 9, 0, '2020-02-19 10:35:21', '2020-02-19 10:35:21'),
(18, 10, 0, '2020-02-19 10:35:21', '2020-02-19 10:35:21'),
(19, 11, 0, '2020-02-19 10:35:21', '2020-02-19 10:35:21'),
(20, 12, 0, '2020-02-19 10:35:21', '2020-02-19 10:35:21'),
(21, 13, 0, '2020-02-19 10:35:21', '2020-02-19 10:35:21'),
(22, 14, 0, '2020-02-19 10:35:21', '2020-02-19 10:35:21'),
(13, 4, 0, '2020-02-19 10:35:20', '2020-02-19 10:40:30'),
(21, 18, 0, '2020-02-19 11:57:03', '2020-02-19 11:57:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_student_parent`
--
ALTER TABLE `tb_student_parent`
  ADD KEY `fk_student_parent` (`student_id`),
  ADD KEY `parent` (`parent_id`) USING BTREE;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_student_parent`
--
ALTER TABLE `tb_student_parent`
  ADD CONSTRAINT `fk_ortu` FOREIGN KEY (`parent_id`) REFERENCES `tb_parent` (`parent_id`),
  ADD CONSTRAINT `fk_student_parent` FOREIGN KEY (`student_id`) REFERENCES `tb_student` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
