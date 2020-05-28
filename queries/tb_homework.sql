-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2020 at 12:18 AM
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
-- Table structure for table `tb_homework`
--

CREATE TABLE `tb_homework` (
  `journal_id` int(11) NOT NULL,
  `homework_title` varchar(300) DEFAULT NULL,
  `homework_description` varchar(500) DEFAULT NULL,
  `due_date` timestamp NULL DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_homework`
--

INSERT INTO `tb_homework` (`journal_id`, `homework_title`, `homework_description`, `due_date`, `created`, `modified`) VALUES
(2, 'bergaul', 'cobalah bergaul dengan temanmu', '2020-06-02 16:59:00', '2020-05-28 15:01:50', '2020-05-28 15:01:50'),
(3, 'menghitung uang baba', 'coba hitung uang baba yg terselip di mana-mana', '2020-05-28 16:59:00', '2020-05-26 05:20:53', '2020-05-26 05:20:53'),
(4, 'Menulis puisi', 'Bisakah anda menulis puisi seperti adnan zaki? huhu', '2020-06-04 16:59:00', '2020-05-26 05:29:36', '2020-05-28 08:43:42'),
(5, 'Hafalan', 'Menghafal 3 surat terakhir dalam juz amma (juz 30)', '2020-06-08 16:59:00', '2020-05-28 15:03:34', '2020-05-28 15:03:34'),
(7, 'Berdakwah di rumah', 'Siswa harus bisa menerapkan konsep-konsep dakwa Nabi Muhammad dari rumah dan mengumpulkan tugasnya dalam bentuk laporan bagaimana respon keluarga terhadap dakwah tersebut.', '2020-06-01 16:59:00', '2020-05-28 22:15:41', '2020-05-28 22:15:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_homework`
--
ALTER TABLE `tb_homework`
  ADD PRIMARY KEY (`journal_id`),
  ADD KEY `journal_homework` (`journal_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_homework`
--
ALTER TABLE `tb_homework`
  ADD CONSTRAINT `journal_homework` FOREIGN KEY (`journal_id`) REFERENCES `tb_journal` (`journal_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
