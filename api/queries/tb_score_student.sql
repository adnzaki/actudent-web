-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 07, 2020 at 02:53 PM
-- Server version: 10.3.23-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u1018042_smkn11kotabekasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_score_student`
--

CREATE TABLE `tb_score_student` (
  `score_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `score` decimal(10,2) NOT NULL,
  `score_note` text DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_score_student`
--
ALTER TABLE `tb_score_student`
  ADD PRIMARY KEY (`score_id`,`student_id`),
  ADD KEY `score_student` (`student_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_score_student`
--
ALTER TABLE `tb_score_student`
  ADD CONSTRAINT `score_id` FOREIGN KEY (`score_id`) REFERENCES `tb_score` (`score_id`),
  ADD CONSTRAINT `score_student` FOREIGN KEY (`student_id`) REFERENCES `tb_student` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
