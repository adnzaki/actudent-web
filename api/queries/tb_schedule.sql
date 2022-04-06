-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2020 at 07:41 PM
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
-- Table structure for table `tb_schedule`
--

CREATE TABLE `tb_schedule` (
  `schedule_id` int(11) NOT NULL,
  `lessons_grade_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `schedule_semester` int(11) DEFAULT NULL,
  `schedule_day` varchar(20) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `schedule_start` varchar(10) DEFAULT NULL,
  `schedule_end` varchar(10) DEFAULT NULL,
  `schedule_order` int(11) DEFAULT NULL,
  `schedule_status` enum('active','inactive','','') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_schedule`
--

INSERT INTO `tb_schedule` (`schedule_id`, `lessons_grade_id`, `room_id`, `schedule_semester`, `schedule_day`, `duration`, `schedule_start`, `schedule_end`, `schedule_order`, `schedule_status`) VALUES
(56, 18, 5, 1, 'senin', 1, '07.00', '07.45', 0, 'active'),
(57, 17, 1, 1, 'senin', 1, '09.00', '09.45', 3, 'active'),
(58, 14, 5, 1, 'selasa', 2, '07.00', '08.30', 0, 'active'),
(59, 22, 1, 1, 'senin', 1, '08.15', '09.00', 2, 'active'),
(60, 13, 3, 1, 'selasa', 2, '07.00', '08.30', 0, 'active'),
(61, 11, 1, 1, 'selasa', 1, '08.30', '09.15', 1, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_schedule`
--
ALTER TABLE `tb_schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `lessons_grade` (`lessons_grade_id`),
  ADD KEY `room` (`room_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_schedule`
--
ALTER TABLE `tb_schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_schedule`
--
ALTER TABLE `tb_schedule`
  ADD CONSTRAINT `lessons_grade` FOREIGN KEY (`lessons_grade_id`) REFERENCES `tb_lessons_grade` (`lessons_grade_id`),
  ADD CONSTRAINT `room` FOREIGN KEY (`room_id`) REFERENCES `tb_room` (`room_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
