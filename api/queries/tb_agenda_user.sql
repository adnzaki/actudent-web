-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2019 at 10:03 PM
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

--
-- Dumping data for table `tb_agenda_user`
--

INSERT INTO `tb_agenda_user` (`agenda_id`, `guests`, `created`, `modified`) VALUES
(6, '5,4,13', '2019-06-26 16:51:51', '2019-06-26 16:51:51'),
(7, '12,8,9,10', '2019-06-26 17:01:06', '2019-06-26 17:01:06'),
(30, '12,10,11', '2019-08-08 12:07:44', '2019-08-08 12:07:44'),
(31, '11,4,8,6', '2019-08-09 02:23:29', '2019-08-09 02:23:29');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
