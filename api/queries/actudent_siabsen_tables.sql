-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 24, 2022 at 08:48 PM
-- Server version: 10.5.15-MariaDB-cll-lve
-- PHP Version: 7.3.33

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
-- Table structure for table `tb_staff_presence`
--

CREATE TABLE `tb_staff_presence` (
  `presence_id` int(11) NOT NULL,
  `staff_id` int(10) NOT NULL,
  `presence_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `presence_tag` varchar(10) NOT NULL,
  `presence_lat` decimal(10,6) DEFAULT NULL,
  `presence_long` decimal(10,6) DEFAULT NULL,
  `presence_photo` decimal(10,0) DEFAULT NULL,
  `presence_valid` int(1) NOT NULL DEFAULT 1,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_staff_presence`
--

INSERT INTO `tb_staff_presence` (`presence_id`, `staff_id`, `presence_datetime`, `presence_tag`, `presence_lat`, `presence_long`, `presence_photo`, `presence_valid`, `created`, `modified`) VALUES
(1, 1, '2022-05-23 04:25:00', 'masuk', -6.287652, 106.983699, NULL, 1, '2022-05-24 08:29:38', NULL),
(2, 1, '2022-05-23 04:25:00', 'masuk', -6.228099, 106.806039, NULL, 1, '2022-05-24 08:30:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_staff_presence_config`
--

CREATE TABLE `tb_staff_presence_config` (
  `config_id` int(11) NOT NULL,
  `config_name` varchar(255) NOT NULL,
  `presence_starttime` time NOT NULL,
  `presence_endtime` time NOT NULL,
  `timelimit_allowed` int(11) NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `locationlimit_allowed` int(11) NOT NULL,
  `config_status` int(1) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_staff_presence_config`
--

INSERT INTO `tb_staff_presence_config` (`config_id`, `config_name`, `presence_starttime`, `presence_endtime`, `timelimit_allowed`, `latitude`, `longitude`, `locationlimit_allowed`, `config_status`, `created`, `modified`) VALUES
(1, 'default', '06:30:00', '16:00:00', 1800, -6.2876521, 106.9836992, 100, 1, '2022-05-17 17:25:58', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_staff_presence_permit`
--

CREATE TABLE `tb_staff_presence_permit` (
  `permit_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `permit_date` date NOT NULL,
  `permit_starttime` time DEFAULT NULL,
  `permit_endtime` time DEFAULT NULL,
  `permit_reason` varchar(255) DEFAULT NULL,
  `permit_photo` varchar(255) DEFAULT NULL,
  `permit_status` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_staff_presence`
--
ALTER TABLE `tb_staff_presence`
  ADD PRIMARY KEY (`presence_id`);

--
-- Indexes for table `tb_staff_presence_config`
--
ALTER TABLE `tb_staff_presence_config`
  ADD PRIMARY KEY (`config_id`);

--
-- Indexes for table `tb_staff_presence_permit`
--
ALTER TABLE `tb_staff_presence_permit`
  ADD PRIMARY KEY (`permit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_staff_presence`
--
ALTER TABLE `tb_staff_presence`
  MODIFY `presence_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_staff_presence_config`
--
ALTER TABLE `tb_staff_presence_config`
  MODIFY `config_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_staff_presence_permit`
--
ALTER TABLE `tb_staff_presence_permit`
  MODIFY `permit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
