-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2018 at 11:45 AM
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

--
-- Dumping data for table `tb_student`
--

INSERT INTO `tb_student` (`studentID`, `schoolID`, `studentNis`, `studentName`, `studentStatus`, `created`, `modified`) VALUES
(1, 1, '2015420022', 'Adnan Zaki', 1, '2018-10-19 03:07:10', '0000-00-00 00:00:00'),
(2, 1, '2015420003', 'Saka Putra Pratama', 1, '2018-10-19 09:38:22', '0000-00-00 00:00:00'),
(3, 1, '2015420004', 'Bima Sakti', 1, '2018-10-14 03:02:10', '0000-00-00 00:00:00'),
(4, 1, '2015420015', 'Widya Sari Wangi', 1, '2018-10-19 09:32:46', '0000-00-00 00:00:00'),
(5, 1, '2015420049', 'Joko Tole', 0, '2018-10-14 03:03:36', '0000-00-00 00:00:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
