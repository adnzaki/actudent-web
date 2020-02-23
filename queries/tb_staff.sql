-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2020 at 10:20 AM
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
-- Table structure for table `tb_staff`
--

CREATE TABLE `tb_staff` (
  `staff_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `staff_nik` varchar(20) DEFAULT NULL,
  `staff_name` varchar(50) DEFAULT NULL,
  `staff_phone` varchar(20) DEFAULT NULL,
  `staff_type` enum('teacher','staff') DEFAULT NULL,
  `staff_tag` tinyint(1) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_staff`
--

INSERT INTO `tb_staff` (`staff_id`, `user_id`, `staff_nik`, `staff_name`, `staff_phone`, `staff_type`, `staff_tag`, `deleted`, `created`, `modified`) VALUES
(1, 4, '123456789', 'Firhan Yudha P.', '08230298484', 'teacher', 1, 0, '2020-02-12 12:37:26', NULL),
(2, 12, '987654321', 'Uus Rusmawan Prasetyo', '083290489348', 'teacher', 1, 0, '2020-02-12 12:38:09', '2020-02-23 06:57:04'),
(3, 13, '2093847283', 'Sudrajat Drajat', '089889878476', 'teacher', 1, 0, '2020-02-23 06:55:07', '2020-02-23 06:55:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_staff`
--
ALTER TABLE `tb_staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `fk_staff_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_staff`
--
ALTER TABLE `tb_staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_staff`
--
ALTER TABLE `tb_staff`
  ADD CONSTRAINT `fk_staff_user` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
