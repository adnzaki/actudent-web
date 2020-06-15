-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2020 at 07:42 PM
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
  `is_archive` int(11) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_journal`
--

INSERT INTO `tb_journal` (`journal_id`, `schedule_id`, `description`, `is_archive`, `created`, `modified`) VALUES
(25, 56, 'persamaan linear', 0, '2020-06-01 00:00:55', '2020-06-05 00:00:55'),
(26, 57, 'Belajar mengaji', 1, '2020-06-01 00:03:37', '2020-06-05 20:43:26'),
(27, 58, 'Menyikapi negara yang sedang kritis karena corona..', 1, '2020-06-08 22:39:47', '2020-06-09 22:49:53'),
(28, 60, 'Belajar logika matematika', 1, '2020-06-08 22:51:16', '2020-06-09 23:01:16'),
(29, 61, 'Mempelajari tafsir surat An-Nas', 1, '2020-06-01 22:51:57', '2020-06-09 23:01:17'),
(30, 61, 'Mengamalkan isi surat Al-Ikhlas', 1, '2020-06-08 22:52:56', '2020-06-09 23:01:17');

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
  MODIFY `journal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
