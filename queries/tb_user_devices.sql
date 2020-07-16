-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 15, 2020 at 01:55 PM
-- Server version: 10.2.32-MariaDB
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
-- Database: `u1018042_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_devices`
--

CREATE TABLE `tb_user_devices` (
  `device_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `device_type` varchar(100) DEFAULT NULL,
  `device_version` varchar(100) DEFAULT NULL,
  `fcm_registration_id` varchar(500) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user_devices`
--

INSERT INTO `tb_user_devices` (`device_id`, `user_id`, `device_type`, `device_version`, `fcm_registration_id`, `status`, `created`, `modified`) VALUES
(1, 30, 'ANDROID', '28', 'cE6Yd6kxRrm74bY4TeUPPf:APA91bFKOTg6uMN1JyAO37ytAfe1vBmYQ2gTLs8JIVKtJwWU02pp7xymjDgNjevEdmREKudI2trzJIUk_dk_LMyD_rAH_NgJYwAgpyKjYachjOAkHOGDtJFSrg6KVNxD0g8KI9CxSm8a', 1, '2020-06-30 08:59:03', '2020-07-15 00:32:15'),
(2, 13, 'ANDROID', '22', 'c-YZKEFAQiyOw6clw_Te5V:APA91bHTXYu1VowS715yDVaP1X5tW1wJAQjrJIFdPEfKYGN0Cyw3WmWPaEIteTpCNV81ZNnO7tEy1mUFZSCk1WxPn-dLbdLVYQwfqm0yz8V3B7zN5-lYdKI-Q4icJWgr_idEnQjaVkdJ', 0, '2020-06-30 10:12:35', '2020-07-11 01:57:19'),
(3, 53, 'ANDROID', '22', 'fhOk-f5zRmezHH5WoW9LIm:APA91bGzEQw8GACRUzwHDnKA3fBO6AgdEZi2-m0ORkQjJufKpGdb7NNd5dPCc2mRkprifnzXhoNP7bpDBIqvQHSBRbbfv7JheZph1f65GWTeTi6eh6Rh_uhZun2Ln4ag_GXWOz8yshpG', 1, '2020-07-10 06:27:35', '2020-07-14 23:59:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_user_devices`
--
ALTER TABLE `tb_user_devices`
  ADD PRIMARY KEY (`device_id`),
  ADD KEY `user_device` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_user_devices`
--
ALTER TABLE `tb_user_devices`
  MODIFY `device_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_user_devices`
--
ALTER TABLE `tb_user_devices`
  ADD CONSTRAINT `user_device` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
