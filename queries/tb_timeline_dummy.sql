-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2020 at 07:51 PM
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
-- Dumping data for table `tb_timeline`
--

INSERT INTO `tb_timeline` (`timeline_id`, `timeline_title`, `timeline_content`, `timeline_date`, `timeline_status`, `timeline_image`, `user_id`, `created`, `modified`) VALUES
(1, 'Selamat datang di Actudent!', 'Kami warga sekolah sangat bahagia dengan adanya aplikasi ini', '2020-06-25 00:28:57', 'public', 'img_1593019738_d45047e928e09e6842cb.jpg', 1, '2020-06-25 00:28:57', '2020-06-25 00:28:59'),
(2, 'Ceritakan banyak hal tentang sekolah anda', 'Di dalam fitur timeline ini anda bisa dengan bebas membagikan banyak cerita tentang sekolah anda kepada guru dan orang tua murid yang menggunakan aplikasi Actudent. Jadikan semua informasi up-to date!', '2020-06-25 00:30:29', 'draft', 'img_1593019829_c42a90bd8c90163afe03.jpeg', 1, '2020-06-25 00:30:29', '2020-06-25 00:30:29');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
