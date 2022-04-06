-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2020 at 07:43 PM
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
-- Table structure for table `tb_presence`
--

CREATE TABLE `tb_presence` (
  `journal_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `presence_status` int(11) DEFAULT NULL,
  `presence_mark` varchar(300) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_presence`
--

INSERT INTO `tb_presence` (`journal_id`, `student_id`, `presence_status`, `presence_mark`, `created`, `modified`) VALUES
(27, 3, 1, '', '2020-06-08 22:39:56', '2020-06-09 22:39:56'),
(27, 8, 1, '', '2020-06-08 22:39:57', '2020-06-09 22:39:57'),
(27, 11, 1, '', '2020-06-08 22:39:57', '2020-06-09 22:39:57'),
(27, 14, 1, '', '2020-06-08 22:39:57', '2020-06-09 22:39:57'),
(27, 24, 1, '', '2020-06-08 22:39:57', '2020-06-09 22:39:57'),
(27, 26, 1, '', '2020-06-08 22:39:57', '2020-06-09 22:39:57'),
(27, 28, 1, '', '2020-06-08 22:39:57', '2020-06-09 22:39:57'),
(28, 1, 1, '', '2020-06-08 22:51:22', '2020-06-09 22:51:22'),
(28, 6, 1, '', '2020-06-08 22:51:23', '2020-06-09 22:51:23'),
(28, 13, 3, '', '2020-06-08 22:51:27', '2020-06-09 22:51:27'),
(28, 17, 1, '', '2020-06-08 22:51:23', '2020-06-09 22:51:23'),
(28, 18, 0, '', '2020-06-08 22:51:31', '2020-06-09 22:51:31'),
(28, 31, 1, '', '2020-06-08 22:51:23', '2020-06-09 22:51:23'),
(28, 32, 1, '', '2020-06-08 22:51:23', '2020-06-09 22:51:23'),
(29, 1, 3, '', '2020-06-01 22:52:18', '2020-06-09 22:52:18'),
(29, 6, 1, '', '2020-06-01 22:52:01', '2020-06-09 22:52:01'),
(29, 13, 1, '', '2020-06-01 22:52:01', '2020-06-09 22:52:01'),
(29, 17, 2, 'Keperluan Keluarga', '2020-06-01 22:52:10', '2020-06-09 22:52:10'),
(29, 18, 1, '', '2020-06-01 22:52:01', '2020-06-09 22:52:01'),
(29, 31, 1, '', '2020-06-01 22:52:01', '2020-06-09 22:52:01'),
(29, 32, 1, '', '2020-06-01 22:52:01', '2020-06-09 22:52:01'),
(30, 1, 1, '', '2020-06-08 22:52:59', '2020-06-09 22:52:59'),
(30, 6, 1, '', '2020-06-08 22:53:00', '2020-06-09 22:53:00'),
(30, 13, 1, '', '2020-06-08 22:53:01', '2020-06-09 22:53:01'),
(30, 17, 1, '', '2020-06-08 22:53:01', '2020-06-09 22:53:01'),
(30, 18, 1, '', '2020-06-08 22:53:01', '2020-06-09 22:53:01'),
(30, 31, 1, '', '2020-06-08 22:53:01', '2020-06-09 22:53:01'),
(30, 32, 1, '', '2020-06-08 22:53:01', '2020-06-09 22:53:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_presence`
--
ALTER TABLE `tb_presence`
  ADD PRIMARY KEY (`journal_id`,`student_id`),
  ADD KEY `student_presence` (`student_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_presence`
--
ALTER TABLE `tb_presence`
  ADD CONSTRAINT `presence_journal` FOREIGN KEY (`journal_id`) REFERENCES `tb_journal` (`journal_id`),
  ADD CONSTRAINT `student_presence` FOREIGN KEY (`student_id`) REFERENCES `tb_student` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
