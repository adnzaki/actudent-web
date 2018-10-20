-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2018 at 04:14 PM
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
(13, 1, '2015190029', 'Wahyudi', 1, '2018-10-20 13:53:06', '2018-10-19 17:00:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
