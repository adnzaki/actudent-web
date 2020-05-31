-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2020 at 02:31 PM
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
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_journal`
--

INSERT INTO `tb_journal` (`journal_id`, `schedule_id`, `description`, `created`, `modified`) VALUES
(14, 26, 'Mempelajari sirah Nabi Muhammad ', '2020-05-25 19:04:38', '2020-05-31 19:04:38'),
(15, 27, 'Memahami pola sosial menyimpang', '2020-05-25 19:09:34', '2020-05-31 19:09:34'),
(16, 30, 'Memahami pola sosial menyimpang', '2020-05-25 19:13:01', '2020-05-31 19:13:01'),
(17, 28, 'Pelajaran sosial', '2020-05-26 19:15:06', '2020-05-31 19:15:07'),
(18, 32, 'Belajar membaca', '2020-05-26 19:29:39', '2020-05-31 19:29:39');

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
  MODIFY `journal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
