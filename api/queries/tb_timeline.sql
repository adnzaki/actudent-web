-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.4.24-MariaDB - Source distribution
-- Server OS:                    Linux
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table db_actudent.tb_timeline
CREATE TABLE IF NOT EXISTS `tb_timeline` (
  `timeline_id` int(11) NOT NULL AUTO_INCREMENT,
  `timeline_title` varchar(100) DEFAULT NULL,
  `timeline_content` text DEFAULT NULL,
  `timeline_date` datetime DEFAULT NULL,
  `timeline_status` enum('public','draft') DEFAULT NULL,
  `timeline_image` varchar(500) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`timeline_id`),
  KEY `timeline_author` (`user_id`),
  CONSTRAINT `timeline_author` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table db_actudent.tb_timeline: ~4 rows (approximately)
INSERT INTO `tb_timeline` (`timeline_id`, `timeline_title`, `timeline_content`, `timeline_date`, `timeline_status`, `timeline_image`, `user_id`, `deleted`, `created`, `modified`) VALUES
	(1, 'Selamat datang di Actudent!', 'Kami warga sekolah sangat bahagia dengan adanya aplikasi ini', '2020-06-30 21:40:29', 'public', 'img_1593528032_857e09b06a5a9d189b74.jpg', 1, 0, '2020-06-25 00:28:57', '2020-06-30 21:40:32'),
	(2, 'Ceritakan banyak hal tentang sekolah anda', 'Di dalam fitur timeline ini anda bisa dengan bebas membagikan banyak cerita tentang sekolah anda kepada guru dan orang tua murid yang menggunakan aplikasi Actudent. Jadikan semua informasi up-to date!', '2020-06-30 21:39:29', 'public', 'img_1593527976_53f1c747b348f72f7539.jpg', 1, 0, '2020-06-25 00:30:29', '2020-06-30 21:39:37'),
	(3, 'Buat kabar terbaru di mana saja! ', 'Tahukah kamu, postingan ini dibuat hanya dengan menggunakan sebuah ponsel!', '2020-06-30 21:43:08', 'public', 'img_1593528157_93bbdc6e76b3c7cdf617.jpg', 1, 0, '2020-06-30 21:42:33', '2020-06-30 21:43:08'),
	(4, 'Istirahat sejenak, mulailah bercerita', 'Luangkan waktu anda dan cobalah untuk lebih banyak berbagi dengan orang di sekitar anda, termasuk para orang tua siswa.', '2020-07-02 00:56:27', 'public', 'img_1593557529_b8eadabe1142c315a8b0.jpg', 1, 0, '2020-06-30 21:45:01', '2020-07-02 00:56:27');

-- Dumping structure for table db_actudent.tb_timeline_comments
CREATE TABLE IF NOT EXISTS `tb_timeline_comments` (
  `timeline_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `timeline_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_parent` int(11) DEFAULT NULL,
  `comment_content` text DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`timeline_comment_id`),
  KEY `fk_timeline` (`timeline_id`),
  KEY `comment_author` (`user_id`),
  CONSTRAINT `comment_author` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`),
  CONSTRAINT `fk_timeline` FOREIGN KEY (`timeline_id`) REFERENCES `tb_timeline` (`timeline_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table db_actudent.tb_timeline_comments: ~0 rows (approximately)

-- Dumping structure for table db_actudent.tb_timeline_likes
CREATE TABLE IF NOT EXISTS `tb_timeline_likes` (
  `timeline_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`timeline_id`,`user_id`),
  KEY `like_author` (`user_id`),
  CONSTRAINT `fk_timeline_like` FOREIGN KEY (`timeline_id`) REFERENCES `tb_timeline` (`timeline_id`),
  CONSTRAINT `like_author` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_actudent.tb_timeline_likes: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
