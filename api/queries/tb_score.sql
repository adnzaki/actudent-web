-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2020 at 05:33 PM
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
-- Table structure for table `tb_score`
--

CREATE TABLE `tb_score` (
  `score_id` int(11) NOT NULL,
  `lessons_grade_id` int(11) NOT NULL,
  `score_type` enum('Teori','Praktik') NOT NULL,
  `score_category` enum('Tugas','UH','PTS','PAS','Kinerja','Proyek') NOT NULL,
  `score_description` varchar(250) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_score`
--

INSERT INTO `tb_score` (`score_id`, `lessons_grade_id`, `score_type`, `score_category`, `score_description`, `deleted`, `created`, `modified`) VALUES
(1, 13, 'Teori', 'Tugas', 'Tugas harian 1: Menggambar lingkaran', 0, '2020-08-10 14:02:57', '2020-08-10 14:02:57'),
(2, 13, 'Teori', 'UH', 'Ulangan harian pertama', 0, '2020-08-10 15:16:00', '2020-08-10 15:16:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_score`
--
ALTER TABLE `tb_score`
  ADD PRIMARY KEY (`score_id`),
  ADD KEY `score_lessons_grade` (`lessons_grade_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_score`
--
ALTER TABLE `tb_score`
  MODIFY `score_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_score`
--
ALTER TABLE `tb_score`
  ADD CONSTRAINT `score_lessons_grade` FOREIGN KEY (`lessons_grade_id`) REFERENCES `tb_lessons_grade` (`lessons_grade_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
