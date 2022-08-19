-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 19, 2022 at 11:02 AM
-- Server version: 10.5.16-MariaDB-cll-lve
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u1018042_epresence_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_agenda_presence`
--

CREATE TABLE `tb_agenda_presence` (
  `presence_id` int(11) NOT NULL,
  `agenda_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `presence_datetime` datetime NOT NULL,
  `presence_lat` decimal(10,6) DEFAULT NULL,
  `presence_long` decimal(10,6) DEFAULT NULL,
  `presence_photo` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_agenda_presence`
--
ALTER TABLE `tb_agenda_presence`
  ADD PRIMARY KEY (`presence_id`),
  ADD KEY `constraint_agenda` (`agenda_id`),
  ADD KEY `constraint_agenda_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_agenda_presence`
--
ALTER TABLE `tb_agenda_presence`
  MODIFY `presence_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_agenda_presence`
--
ALTER TABLE `tb_agenda_presence`
  ADD CONSTRAINT `constraint_agenda` FOREIGN KEY (`agenda_id`) REFERENCES `tb_agenda` (`agenda_id`),
  ADD CONSTRAINT `constraint_agenda_user` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
