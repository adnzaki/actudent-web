-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2020 at 05:43 AM
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
-- Table structure for table `tb_chat`
--

CREATE TABLE `tb_chat` (
  `chat_id` int(11) NOT NULL,
  `chat_user_id` int(11) DEFAULT NULL,
  `sender` int(11) DEFAULT NULL,
  `content` text,
  `delivery_status` int(11) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_chat`
--

INSERT INTO `tb_chat` (`chat_id`, `chat_user_id`, `sender`, `content`, `delivery_status`, `created`) VALUES
(1, 1, 1, 'halo firhan', 0, '2020-12-06 12:10:02'),
(2, 1, 4, 'halo zaki', 0, '2020-12-06 12:13:52'),
(3, 1, 1, 'apa kabar?', 0, '2020-12-06 12:14:26'),
(4, 2, 2, 'halo zaki keren', 0, '2020-12-09 23:40:31');

-- --------------------------------------------------------

--
-- Table structure for table `tb_chat_users`
--

CREATE TABLE `tb_chat_users` (
  `chat_user_id` int(11) NOT NULL,
  `participant` varchar(5) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_chat_users`
--

INSERT INTO `tb_chat_users` (`chat_user_id`, `participant`, `created`) VALUES
(1, '1,4', '2020-12-06 12:09:27'),
(2, '2,1', '2020-12-06 12:12:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_chat`
--
ALTER TABLE `tb_chat`
  ADD PRIMARY KEY (`chat_id`),
  ADD KEY `chat_user` (`chat_user_id`);

--
-- Indexes for table `tb_chat_users`
--
ALTER TABLE `tb_chat_users`
  ADD PRIMARY KEY (`chat_user_id`),
  ADD KEY `participant` (`participant`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_chat`
--
ALTER TABLE `tb_chat`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_chat_users`
--
ALTER TABLE `tb_chat_users`
  MODIFY `chat_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_chat`
--
ALTER TABLE `tb_chat`
  ADD CONSTRAINT `chat_user` FOREIGN KEY (`chat_user_id`) REFERENCES `tb_chat_users` (`chat_user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
