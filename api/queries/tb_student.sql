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
-- Table structure for table `tb_student`
--

CREATE TABLE `tb_student` (
  `student_id` int(11) NOT NULL,
  `student_nis` varchar(20) DEFAULT NULL,
  `student_name` varchar(100) DEFAULT NULL,
  `student_tag` tinyint(1) DEFAULT '1',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_student`
--

INSERT INTO `tb_student` (`student_id`, `student_nis`, `student_name`, `student_tag`, `deleted`, `created`, `modified`) VALUES
(1, '2015420022', 'Adnan Zaki keren', 1, 0, '2018-10-20 04:19:34', '0000-00-00 00:00:00'),
(2, '2015420003', 'Saka Putra ', 1, 0, '2018-10-20 03:23:30', '0000-00-00 00:00:00'),
(3, '2015420004', 'Bima Sakti', 1, 0, '2018-10-14 03:02:10', '0000-00-00 00:00:00'),
(4, '2015420015', 'Widya Sari Wangi', 1, 0, '2018-10-19 09:32:46', '0000-00-00 00:00:00'),
(5, '2015420049', 'Joko Tole', 1, 1, '2020-02-10 03:58:02', '2020-02-17 05:41:48'),
(6, '2014310039', 'Dani Rusmawan', 1, 0, '2018-10-20 03:11:18', '2018-10-19 17:00:00'),
(7, '2014310012', 'Mukhlisin', 1, 0, '2018-10-20 03:11:23', '2018-10-19 17:00:00'),
(8, '2015310028', 'Rino Ardiansyah', 1, 0, '2018-10-20 04:20:22', '2018-10-19 17:00:00'),
(9, '2015310029', 'Raju Herningtyas Pratama', 1, 0, '2018-10-20 03:11:44', '2018-10-19 17:00:00'),
(10, '2014310088', 'Ridwan Kamil', 1, 0, '2018-10-20 03:11:48', '2018-10-19 17:00:00'),
(11, '2015310098', 'Firhan Yudha', 1, 0, '2018-10-20 13:53:06', '2018-10-19 17:00:00'),
(12, '2014220038', 'Try Albahri', 1, 0, '2018-10-20 13:53:06', '2018-10-19 17:00:00'),
(13, '2015190029', 'Wahyudi', 1, 0, '2018-10-20 13:53:06', '2018-10-19 17:00:00'),
(14, '2015310124', 'Kipiir', 1, 0, '2018-11-13 16:53:15', '2020-02-10 16:05:45'),
(17, '2837893745', 'Dennis Septianto', 1, 0, '2020-02-18 07:45:41', '2020-02-18 07:45:41'),
(18, '192009008', 'Johnson Saputra', 1, 0, '2020-02-19 04:57:03', '2020-02-19 04:57:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_student`
--
ALTER TABLE `tb_student`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_student`
--
ALTER TABLE `tb_student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
