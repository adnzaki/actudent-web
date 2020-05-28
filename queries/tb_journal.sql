-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2020 at 12:18 AM
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
-- Table structure for table `tb_journal`
--

CREATE TABLE `tb_journal` (
  `journal_id` int(11) NOT NULL,
  `schedule_id` int(11) DEFAULT NULL,
  `description` text,
  `date` varchar(12) NOT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_journal`
--

INSERT INTO `tb_journal` (`journal_id`, `schedule_id`, `description`, `date`, `created`, `modified`) VALUES
(1, 26, 'Hari ini kita belajar agama...', '2020-05-11', '2020-05-11 16:00:26', '2020-05-29 05:09:36'),
(2, 28, 'Cara bersosialisasi manusia..', '2020-05-26', '2020-05-26 12:05:23', '2020-05-29 05:09:51'),
(3, 29, 'Menghitung lingkaran', '2020-05-26', '2020-05-26 12:20:53', '2020-05-29 05:09:55'),
(4, 32, 'Mencari kosa kata baru hihii', '2020-05-26', '2020-05-26 12:29:35', '2020-05-29 05:09:57'),
(5, 26, 'Membaca surat-surat pendek', '2020-05-25', '2020-05-28 22:03:33', '2020-05-29 05:10:11'),
(6, 26, 'Mari belajar', '2020-06-01', '2020-05-29 05:05:51', '2020-05-29 05:10:36'),
(7, 26, 'Mengamalkan ajaran Nabi Muhammad dalam bentuk dakwah internal', '2020-05-18', '2020-05-29 05:15:41', '2020-05-29 05:16:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_journal`
--
ALTER TABLE `tb_journal`
  ADD PRIMARY KEY (`journal_id`),
  ADD KEY `schedule_journal` (`schedule_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_journal`
--
ALTER TABLE `tb_journal`
  MODIFY `journal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_journal`
--
ALTER TABLE `tb_journal`
  ADD CONSTRAINT `schedule_journal` FOREIGN KEY (`schedule_id`) REFERENCES `tb_schedule` (`schedule_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
