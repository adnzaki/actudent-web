-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 15, 2023 at 09:14 PM
-- Server version: 10.6.14-MariaDB-cll-lve
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u1018042_actudent_main`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_organization_database`
--

CREATE TABLE `tb_organization_database` (
  `organization_id` int(11) NOT NULL,
  `database_name` varchar(100) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `crerated` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_organization_database`
--

INSERT INTO `tb_organization_database` (`organization_id`, `database_name`, `status`, `crerated`, `modified`) VALUES
(4, 'u1018042_demo_next', 1, '2023-08-08 02:08:37', '2023-08-08 02:08:37'),
(7, 'u1018042_epresence_dev', 1, '2022-10-27 17:07:58', '2022-10-27 17:50:28'),
(8, 'u1018042_siabsen_smkn11kotabekasi', 1, '2022-10-27 17:08:07', '2022-10-27 17:08:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_organization_database`
--
ALTER TABLE `tb_organization_database`
  ADD PRIMARY KEY (`organization_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_organization_database`
--
ALTER TABLE `tb_organization_database`
  ADD CONSTRAINT `FK__tb_organization` FOREIGN KEY (`organization_id`) REFERENCES `tb_organization` (`organization_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
