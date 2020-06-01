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
  `journal_filled` varchar(5) NOT NULL DEFAULT 'OFF'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_schedule`
--

INSERT INTO `tb_schedule` (`schedule_id`, `lessons_grade_id`, `room_id`, `schedule_semester`, `schedule_day`, `duration`, `schedule_start`, `schedule_end`, `journal_filled`) VALUES
(1, 18, 1, 1, 'senin', 2, '07.00', '08.30', 'OFF'),
(8, 22, 1, 1, 'selasa', 2, '07.00', '08.30', 'OFF'),
(9, 23, 1, 1, 'selasa', 1, '08.30', '09.15', 'OFF'),
(10, 14, 1, 1, 'selasa', 2, '09.35', '11.05', 'OFF'),
(11, 18, 1, 1, 'selasa', 1, '11.05', '11.50', 'OFF'),
(12, 25, 1, 1, 'selasa', 2, '12.50', '14.20', 'OFF'),
(13, 18, 1, 1, 'rabu', 2, '07.00', '08.30', 'OFF'),
(14, 17, 1, 1, 'rabu', 1, '08.30', '09.15', 'OFF'),
(15, 22, 1, 1, 'rabu', 2, '09.35', '11.05', 'OFF'),
(16, 25, 1, 1, 'senin', 1, '08.30', '09.15', 'OFF'),
(17, 24, 1, 1, 'kamis', 2, '07.00', '08.30', 'OFF'),
(18, 23, 1, 1, 'kamis', 1, '08.30', '09.15', 'OFF'),
(19, 22, 1, 1, 'kamis', 2, '09.35', '11.05', 'OFF'),
(20, 14, 1, 1, 'kamis', 1, '11.05', '11.50', 'OFF'),
(21, 17, 1, 1, 'kamis', 2, '12.50', '14.20', 'OFF'),
(22, 17, 1, 1, 'jumat', 2, '07.00', '08.30', 'OFF'),
(23, 23, 1, 1, 'jumat', 1, '08.30', '09.15', 'OFF'),
(24, 14, 1, 1, 'sabtu', 2, '07.00', '08.30', 'OFF'),
(25, 24, 1, 1, 'sabtu', 1, '08.30', '09.15', 'OFF'),
(26, 11, 1, 1, 'senin', 2, '07.00', '08.30', 'ON'),
(27, 12, 1, 1, 'senin', 1, '08.30', '09.15', 'ON'),
(28, 19, 1, 1, 'selasa', 2, '07.00', '08.30', 'ON'),
(30, 12, 1, 1, 'senin', 1, '09.35', '10.20', 'ON'),
(32, 20, 2, 1, 'selasa', 1, '08.30', '09.15', 'ON'),
(33, 21, 2, 1, 'selasa', 2, '09.45', '11.15', 'OFF'),
(34, 26, 2, 1, 'rabu', 2, '07.00', '08.30', 'OFF'),
(35, 19, 3, 1, 'rabu', 1, '08.30', '09.15', 'OFF'),
(36, 20, 5, 1, 'rabu', 2, '09.35', '11.05', 'OFF'),
(37, 27, 3, 1, 'kamis', 2, '07.00', '08.30', 'OFF'),
(38, 29, 4, 1, 'kamis', 1, '08.30', '09.15', 'OFF'),
(39, 29, 4, 1, 'kamis', 2, '08.30', '10.00', 'OFF'),
(40, 28, 1, 1, 'kamis', 1, '10.00', '10.45', 'OFF'),
(41, 28, 1, 1, 'kamis', 1, '11.45', '12.30', 'OFF'),
(42, 11, 1, 1, 'kamis', 1, '12.30', '13.15', 'OFF'),
(43, 23, 2, 1, 'jumat', 1, '09.15', '10.00', 'OFF'),
(44, 26, 3, 1, 'jumat', 2, '07.00', '08.30', 'OFF'),
(45, 12, 5, 1, 'jumat', 2, '08.50', '10.20', 'OFF');

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
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

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
