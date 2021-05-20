-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2020 at 02:06 PM
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
-- Table structure for table `tb_school`
--

CREATE TABLE `tb_school` (
  `school_id` int(11) NOT NULL,
  `school_name` varchar(300) NOT NULL,
  `school_type` enum('Sekolah Dasar','Sekolah Menengah Pertama','Sekolah Manengah Atas') NOT NULL,
  `school_address` varchar(500) DEFAULT NULL,
  `school_telephone` varchar(30) DEFAULT NULL,
  `school_status` tinyint(1) NOT NULL,
  `school_domain` varchar(255) NOT NULL,
  `school_letterhead` text,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_school`
--

INSERT INTO `tb_school` (`school_id`, `school_name`, `school_type`, `school_address`, `school_telephone`, `school_status`, `school_domain`, `school_letterhead`, `created`, `modified`) VALUES
(1, 'SMK Negeri 11 Kota Bekasi', 'Sekolah Manengah Atas', 'Jl. Mutiara Raya Blok A No. 81a', '(021) 29286271 ', 1, 'smkn11kotabekasi.actudent.com', '{\r\n    \"city\": \"Bekasi\",\r\n    \"website\": \"smkn11kotabekasi.sch.id\",\r\n    \"email\": \"smkn11_kotabekasi@yahoo.com\",\r\n    \"opd_logo\": \"logo-opd.png\",\r\n    \"school_logo\": \"logo-sekolah.png\",\r\n    \"opd_name\": \"Pemerintah Provinsi Jawa Barat\",\r\n    \"sub_opd_name\": \"Kantor Cabang Dinas Wilayah IV\",\r\n    \"headmaster\": \"Drs. RIADI, M.Pd.\",\r\n    \"headmaster_nip\": \"19661007 200212 1 001\",\r\n    \"co_headmaster\": \"SLAMET AKHMAD S, S.Pd\",\r\n    \"co_headmaster_nip\": \"19661014 200501 1 001\"\r\n}', '2018-10-09 17:00:00', '2020-07-07 12:03:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_school`
--
ALTER TABLE `tb_school`
  ADD PRIMARY KEY (`school_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_school`
--
ALTER TABLE `tb_school`
  MODIFY `school_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
