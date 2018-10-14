-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2018 at 01:21 PM
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
  `studentID` int(11) NOT NULL,
  `schoolID` int(11) DEFAULT NULL,
  `studentNis` varchar(20) DEFAULT NULL,
  `studentName` varchar(100) DEFAULT NULL,
  `studentStatus` tinyint(1) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_student`
--

INSERT INTO `tb_student` (`studentID`, `schoolID`, `studentNis`, `studentName`, `studentStatus`, `created`, `modified`) VALUES
(1, 1, '2015420002', 'Adnan Zaki', 1, '2018-10-14 09:59:09', '0000-00-00 00:00:00'),
(2, 1, '2015420003', 'Saka Putra', 1, '2018-10-14 10:01:39', '0000-00-00 00:00:00'),
(3, 1, '2015420004', 'Bima Sakti', 1, '2018-10-14 10:02:10', '0000-00-00 00:00:00'),
(4, 1, '2015420005', 'Widya Sari', 1, '2018-10-14 10:03:05', '0000-00-00 00:00:00'),
(5, 1, '2015420049', 'Joko Tole', 0, '2018-10-14 10:03:36', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_student`
--
ALTER TABLE `tb_student`
  ADD PRIMARY KEY (`studentID`),
  ADD KEY `fk_student_school` (`schoolID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_student`
--
ALTER TABLE `tb_student`
  MODIFY `studentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_student`
--
ALTER TABLE `tb_student`
  ADD CONSTRAINT `fk_student_school` FOREIGN KEY (`schoolID`) REFERENCES `tb_school` (`schoolID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
