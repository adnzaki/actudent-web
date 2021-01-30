-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2021 at 12:54 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_actudent_main`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_subscription`
--

CREATE TABLE `tb_subscription` (
  `organization_id` int(11) NOT NULL,
  `subscription_type` enum('free','starter','standard','enhanced','enterprise') DEFAULT NULL,
  `subscription_expiration` datetime DEFAULT NULL,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_subscription`
--

INSERT INTO `tb_subscription` (`organization_id`, `subscription_type`, `subscription_expiration`, `created`, `modified`) VALUES
(1, 'standard', '2021-06-30 23:59:00', '2021-01-29 03:56:49', '2021-01-29 03:56:49'),
(2, 'free', '2021-06-30 23:59:00', '2021-01-29 03:56:49', '2021-01-29 03:56:49'),
(3, 'free', '2021-01-29 18:14:51', '2021-01-29 03:56:49', '2021-01-30 11:14:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_subscription`
--
ALTER TABLE `tb_subscription`
  ADD PRIMARY KEY (`organization_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_subscription`
--
ALTER TABLE `tb_subscription`
  ADD CONSTRAINT `fk_organization` FOREIGN KEY (`organization_id`) REFERENCES `tb_organization` (`organization_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
