-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2021 at 08:40 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_actudent_sync`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_agenda`
--

CREATE TABLE `tb_agenda` (
  `agenda_id` int(11) NOT NULL,
  `agenda_name` varchar(250) DEFAULT NULL,
  `agenda_start` datetime DEFAULT NULL,
  `agenda_end` datetime DEFAULT NULL,
  `agenda_description` text DEFAULT NULL,
  `agenda_priority` enum('high','normal','low') DEFAULT NULL,
  `agenda_location` varchar(50) DEFAULT NULL,
  `agenda_attachment` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_agenda_user`
--

CREATE TABLE `tb_agenda_user` (
  `agenda_id` int(11) NOT NULL,
  `guests` text DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_chat`
--

CREATE TABLE `tb_chat` (
  `chat_id` int(11) NOT NULL,
  `chat_user_id` int(11) DEFAULT NULL,
  `sender` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `read_status` int(11) DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_chat_users`
--

CREATE TABLE `tb_chat_users` (
  `chat_user_id` int(11) NOT NULL,
  `participant_1` varchar(5) DEFAULT NULL,
  `participant_2` varchar(5) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_grade`
--

CREATE TABLE `tb_grade` (
  `grade_id` int(11) NOT NULL,
  `grade_name` varchar(20) DEFAULT NULL,
  `period_start` varchar(4) DEFAULT NULL,
  `period_end` varchar(4) DEFAULT NULL,
  `teacher_id` int(11) NOT NULL,
  `grade_status` tinyint(1) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_homework`
--

CREATE TABLE `tb_homework` (
  `journal_id` int(11) NOT NULL,
  `homework_title` varchar(300) DEFAULT NULL,
  `homework_description` varchar(500) DEFAULT NULL,
  `due_date` timestamp NULL DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_journal`
--

CREATE TABLE `tb_journal` (
  `journal_id` int(11) NOT NULL,
  `schedule_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_archive` int(11) NOT NULL DEFAULT 0,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_lessons`
--

CREATE TABLE `tb_lessons` (
  `lesson_id` int(11) NOT NULL,
  `lesson_code` varchar(50) NOT NULL,
  `lesson_name` varchar(100) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_lessons_grade`
--

CREATE TABLE `tb_lessons_grade` (
  `lessons_grade_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_parent`
--

CREATE TABLE `tb_parent` (
  `parent_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_family_card` varchar(18) DEFAULT NULL,
  `parent_father_name` varchar(100) DEFAULT NULL,
  `parent_mother_name` varchar(100) DEFAULT NULL,
  `parent_phone_number` varchar(15) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_presence`
--

CREATE TABLE `tb_presence` (
  `journal_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `presence_status` int(11) DEFAULT NULL,
  `presence_mark` varchar(300) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_room`
--

CREATE TABLE `tb_room` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(300) DEFAULT NULL,
  `room_code` varchar(50) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT 0,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_schedule`
--

CREATE TABLE `tb_schedule` (
  `schedule_id` int(11) NOT NULL,
  `lessons_grade_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `schedule_semester` int(11) DEFAULT NULL,
  `schedule_day` varchar(20) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `schedule_start` varchar(10) DEFAULT NULL,
  `schedule_end` varchar(10) DEFAULT NULL,
  `schedule_order` int(11) DEFAULT NULL,
  `schedule_status` enum('active','inactive','','') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_schedule_settings`
--

CREATE TABLE `tb_schedule_settings` (
  `schedule_setting_id` int(11) NOT NULL,
  `setting_name` varchar(100) DEFAULT NULL,
  `setting_value` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `school_letterhead` text DEFAULT NULL,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_school`
--

INSERT INTO `tb_school` (`school_id`, `school_name`, `school_type`, `school_address`, `school_telephone`, `school_status`, `school_domain`, `school_letterhead`, `created`, `modified`) VALUES
(1, 'SMK Negeri 999 Kota Bekasi', 'Sekolah Manengah Atas', 'Jl. Raya Pekayon No. 30', '(021) 800398493', 1, 'localhost', '{\r\n    \"city\": \"Bekasi\",\r\n    \"website\": \"smkn999kotabekasi.sch.id\",\r\n    \"email\": \"smkn999kotabekasi@yahoo.com\",\r\n    \"opd_logo\": \"logo-opd.png\",\r\n    \"school_logo\": \"logo-sekolah.png\",\r\n    \"opd_name\": \"Pemerintah Provinsi Jawa Barat\",\r\n    \"sub_opd_name\": \"Kantor Cabang Dinas Wilayah IV\",\r\n    \"headmaster\": \"Dr. Raihan, M.Pd.\",\r\n    \"headmaster_nip\": \"19631212 198410 1 012\",\r\n    \"co_headmaster\": \"Rino Swastika, S.Pd\",\r\n    \"co_headmaster_nip\": \"19631212 198410 1 012\"\r\n}', '2018-10-09 17:00:00', '2021-05-18 15:35:37');

-- --------------------------------------------------------

--
-- Table structure for table `tb_score`
--

CREATE TABLE `tb_score` (
  `score_id` int(11) NOT NULL,
  `lessons_grade_id` int(11) NOT NULL,
  `score_type` enum('Teori','Praktik') NOT NULL,
  `score_category` enum('Tugas','UH','PTS','PAS','Kinerja','Proyek') NOT NULL,
  `score_description` varchar(250) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_score_student`
--

CREATE TABLE `tb_score_student` (
  `score_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `score` decimal(10,2) NOT NULL,
  `score_note` text DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_staff`
--

CREATE TABLE `tb_staff` (
  `staff_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `staff_nik` varchar(20) DEFAULT NULL,
  `staff_name` varchar(50) DEFAULT NULL,
  `staff_phone` varchar(20) DEFAULT NULL,
  `staff_type` enum('teacher','staff') DEFAULT NULL,
  `staff_title` varchar(100) DEFAULT NULL,
  `staff_photo` text DEFAULT NULL,
  `staff_tag` tinyint(1) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_student`
--

CREATE TABLE `tb_student` (
  `student_id` int(11) NOT NULL,
  `student_nis` varchar(20) DEFAULT NULL,
  `student_name` varchar(100) DEFAULT NULL,
  `student_tag` tinyint(1) DEFAULT 1,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_student_grade`
--

CREATE TABLE `tb_student_grade` (
  `student_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `student_tag` tinyint(1) DEFAULT 1,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_student_parent`
--

CREATE TABLE `tb_student_parent` (
  `parent_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_timeline`
--

CREATE TABLE `tb_timeline` (
  `timeline_id` int(11) NOT NULL,
  `timeline_title` varchar(100) DEFAULT NULL,
  `timeline_content` text DEFAULT NULL,
  `timeline_date` datetime DEFAULT NULL,
  `timeline_status` enum('public','draft') DEFAULT NULL,
  `timeline_image` varchar(500) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_timeline_comments`
--

CREATE TABLE `tb_timeline_comments` (
  `timeline_comment_id` int(11) NOT NULL,
  `timeline_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_parent` int(11) DEFAULT NULL,
  `comment_content` text DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_timeline_likes`
--

CREATE TABLE `tb_timeline_likes` (
  `timeline_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_timelog`
--

CREATE TABLE `tb_timelog` (
  `log_id` int(11) NOT NULL,
  `student_nis` varchar(20) DEFAULT NULL,
  `verifymode` tinyint(4) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `iomode` tinyint(4) DEFAULT NULL,
  `created` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_level` tinyint(4) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `network` varchar(10) NOT NULL DEFAULT 'offline',
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `user_name`, `user_email`, `user_password`, `user_level`, `deleted`, `network`, `created`, `modified`) VALUES
(1, 'Adnan Zaki', 'admin@localhost', '$2y$10$gKk1sx1Jx/cXx2L8BolU4emqDn2Kg/zSr9hqOb7Syo5NpisY.QnwC', 1, 0, 'online', '2018-10-10 17:00:00', '2021-05-18 15:35:45');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_devices`
--

CREATE TABLE `tb_user_devices` (
  `device_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `device_type` varchar(100) DEFAULT NULL,
  `device_version` varchar(100) DEFAULT NULL,
  `fcm_registration_id` varchar(500) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_language`
--

CREATE TABLE `tb_user_language` (
  `user_lang_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_language` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user_language`
--

INSERT INTO `tb_user_language` (`user_lang_id`, `user_id`, `user_language`) VALUES
(1, 1, 'indonesia');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_themes`
--

CREATE TABLE `tb_user_themes` (
  `user_themes_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `theme` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_token`
--

CREATE TABLE `tb_user_token` (
  `token_id` int(11) NOT NULL,
  `token_value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_agenda`
--
ALTER TABLE `tb_agenda`
  ADD PRIMARY KEY (`agenda_id`),
  ADD KEY `agenda_author` (`user_id`);

--
-- Indexes for table `tb_agenda_user`
--
ALTER TABLE `tb_agenda_user`
  ADD PRIMARY KEY (`agenda_id`);

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
  ADD PRIMARY KEY (`chat_user_id`);

--
-- Indexes for table `tb_grade`
--
ALTER TABLE `tb_grade`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `wali_kelas` (`teacher_id`);

--
-- Indexes for table `tb_homework`
--
ALTER TABLE `tb_homework`
  ADD KEY `journal_homework` (`journal_id`);

--
-- Indexes for table `tb_journal`
--
ALTER TABLE `tb_journal`
  ADD PRIMARY KEY (`journal_id`),
  ADD KEY `schedule_journal` (`schedule_id`);

--
-- Indexes for table `tb_lessons`
--
ALTER TABLE `tb_lessons`
  ADD PRIMARY KEY (`lesson_id`);

--
-- Indexes for table `tb_lessons_grade`
--
ALTER TABLE `tb_lessons_grade`
  ADD PRIMARY KEY (`lessons_grade_id`),
  ADD KEY `fk_teacher_lesson` (`teacher_id`),
  ADD KEY `fk_grade_lesson` (`grade_id`),
  ADD KEY `fk_lesson` (`lesson_id`);

--
-- Indexes for table `tb_parent`
--
ALTER TABLE `tb_parent`
  ADD PRIMARY KEY (`parent_id`,`user_id`) USING BTREE,
  ADD KEY `fk_parent` (`user_id`);

--
-- Indexes for table `tb_presence`
--
ALTER TABLE `tb_presence`
  ADD PRIMARY KEY (`journal_id`,`student_id`),
  ADD KEY `student_presence` (`student_id`);

--
-- Indexes for table `tb_room`
--
ALTER TABLE `tb_room`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `tb_schedule`
--
ALTER TABLE `tb_schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `lessons_grade` (`lessons_grade_id`),
  ADD KEY `room` (`room_id`);

--
-- Indexes for table `tb_schedule_settings`
--
ALTER TABLE `tb_schedule_settings`
  ADD PRIMARY KEY (`schedule_setting_id`);

--
-- Indexes for table `tb_school`
--
ALTER TABLE `tb_school`
  ADD PRIMARY KEY (`school_id`);

--
-- Indexes for table `tb_score`
--
ALTER TABLE `tb_score`
  ADD PRIMARY KEY (`score_id`),
  ADD KEY `score_lessons_grade` (`lessons_grade_id`);

--
-- Indexes for table `tb_score_student`
--
ALTER TABLE `tb_score_student`
  ADD PRIMARY KEY (`score_id`,`student_id`),
  ADD KEY `score_student` (`student_id`);

--
-- Indexes for table `tb_staff`
--
ALTER TABLE `tb_staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `fk_staff_user` (`user_id`);

--
-- Indexes for table `tb_student`
--
ALTER TABLE `tb_student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `tb_student_grade`
--
ALTER TABLE `tb_student_grade`
  ADD PRIMARY KEY (`student_id`,`grade_id`),
  ADD KEY `fk_grade` (`grade_id`);

--
-- Indexes for table `tb_student_parent`
--
ALTER TABLE `tb_student_parent`
  ADD KEY `fk_student_parent` (`student_id`),
  ADD KEY `parent` (`parent_id`) USING BTREE;

--
-- Indexes for table `tb_timeline`
--
ALTER TABLE `tb_timeline`
  ADD PRIMARY KEY (`timeline_id`),
  ADD KEY `timeline_author` (`user_id`);

--
-- Indexes for table `tb_timeline_comments`
--
ALTER TABLE `tb_timeline_comments`
  ADD PRIMARY KEY (`timeline_comment_id`),
  ADD KEY `fk_timeline` (`timeline_id`),
  ADD KEY `comment_author` (`user_id`);

--
-- Indexes for table `tb_timeline_likes`
--
ALTER TABLE `tb_timeline_likes`
  ADD PRIMARY KEY (`timeline_id`,`user_id`),
  ADD KEY `like_author` (`user_id`);

--
-- Indexes for table `tb_timelog`
--
ALTER TABLE `tb_timelog`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tb_user_devices`
--
ALTER TABLE `tb_user_devices`
  ADD PRIMARY KEY (`device_id`),
  ADD KEY `user_device` (`user_id`);

--
-- Indexes for table `tb_user_language`
--
ALTER TABLE `tb_user_language`
  ADD PRIMARY KEY (`user_lang_id`),
  ADD KEY `fk_user_language` (`user_id`);

--
-- Indexes for table `tb_user_themes`
--
ALTER TABLE `tb_user_themes`
  ADD PRIMARY KEY (`user_themes_id`),
  ADD KEY `fk_user_themes` (`user_id`);

--
-- Indexes for table `tb_user_token`
--
ALTER TABLE `tb_user_token`
  ADD PRIMARY KEY (`token_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_agenda`
--
ALTER TABLE `tb_agenda`
  MODIFY `agenda_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_chat`
--
ALTER TABLE `tb_chat`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_chat_users`
--
ALTER TABLE `tb_chat_users`
  MODIFY `chat_user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_grade`
--
ALTER TABLE `tb_grade`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_journal`
--
ALTER TABLE `tb_journal`
  MODIFY `journal_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_lessons`
--
ALTER TABLE `tb_lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_lessons_grade`
--
ALTER TABLE `tb_lessons_grade`
  MODIFY `lessons_grade_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_parent`
--
ALTER TABLE `tb_parent`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6330;

--
-- AUTO_INCREMENT for table `tb_room`
--
ALTER TABLE `tb_room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_schedule`
--
ALTER TABLE `tb_schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_schedule_settings`
--
ALTER TABLE `tb_schedule_settings`
  MODIFY `schedule_setting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_school`
--
ALTER TABLE `tb_school`
  MODIFY `school_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_score`
--
ALTER TABLE `tb_score`
  MODIFY `score_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_staff`
--
ALTER TABLE `tb_staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_student`
--
ALTER TABLE `tb_student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7221;

--
-- AUTO_INCREMENT for table `tb_timeline`
--
ALTER TABLE `tb_timeline`
  MODIFY `timeline_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_timeline_comments`
--
ALTER TABLE `tb_timeline_comments`
  MODIFY `timeline_comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_timelog`
--
ALTER TABLE `tb_timelog`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6415;

--
-- AUTO_INCREMENT for table `tb_user_devices`
--
ALTER TABLE `tb_user_devices`
  MODIFY `device_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_user_language`
--
ALTER TABLE `tb_user_language`
  MODIFY `user_lang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_user_themes`
--
ALTER TABLE `tb_user_themes`
  MODIFY `user_themes_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_user_token`
--
ALTER TABLE `tb_user_token`
  MODIFY `token_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_agenda`
--
ALTER TABLE `tb_agenda`
  ADD CONSTRAINT `agenda_author` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_agenda_user`
--
ALTER TABLE `tb_agenda_user`
  ADD CONSTRAINT `fk_agenda` FOREIGN KEY (`agenda_id`) REFERENCES `tb_agenda` (`agenda_id`);

--
-- Constraints for table `tb_chat`
--
ALTER TABLE `tb_chat`
  ADD CONSTRAINT `chat_user` FOREIGN KEY (`chat_user_id`) REFERENCES `tb_chat_users` (`chat_user_id`);

--
-- Constraints for table `tb_grade`
--
ALTER TABLE `tb_grade`
  ADD CONSTRAINT `wali_kelas` FOREIGN KEY (`teacher_id`) REFERENCES `tb_staff` (`staff_id`);

--
-- Constraints for table `tb_homework`
--
ALTER TABLE `tb_homework`
  ADD CONSTRAINT `journal_homework` FOREIGN KEY (`journal_id`) REFERENCES `tb_journal` (`journal_id`);

--
-- Constraints for table `tb_journal`
--
ALTER TABLE `tb_journal`
  ADD CONSTRAINT `schedule_journal` FOREIGN KEY (`schedule_id`) REFERENCES `tb_schedule` (`schedule_id`);

--
-- Constraints for table `tb_lessons_grade`
--
ALTER TABLE `tb_lessons_grade`
  ADD CONSTRAINT `fk_grade_lesson` FOREIGN KEY (`grade_id`) REFERENCES `tb_grade` (`grade_id`),
  ADD CONSTRAINT `fk_lesson` FOREIGN KEY (`lesson_id`) REFERENCES `tb_lessons` (`lesson_id`),
  ADD CONSTRAINT `fk_teacher_lesson` FOREIGN KEY (`teacher_id`) REFERENCES `tb_staff` (`staff_id`);

--
-- Constraints for table `tb_parent`
--
ALTER TABLE `tb_parent`
  ADD CONSTRAINT `fk_parent` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_presence`
--
ALTER TABLE `tb_presence`
  ADD CONSTRAINT `presence_journal` FOREIGN KEY (`journal_id`) REFERENCES `tb_journal` (`journal_id`),
  ADD CONSTRAINT `student_presence` FOREIGN KEY (`student_id`) REFERENCES `tb_student` (`student_id`);

--
-- Constraints for table `tb_schedule`
--
ALTER TABLE `tb_schedule`
  ADD CONSTRAINT `lessons_grade` FOREIGN KEY (`lessons_grade_id`) REFERENCES `tb_lessons_grade` (`lessons_grade_id`),
  ADD CONSTRAINT `room` FOREIGN KEY (`room_id`) REFERENCES `tb_room` (`room_id`);

--
-- Constraints for table `tb_score`
--
ALTER TABLE `tb_score`
  ADD CONSTRAINT `score_lessons_grade` FOREIGN KEY (`lessons_grade_id`) REFERENCES `tb_lessons_grade` (`lessons_grade_id`);

--
-- Constraints for table `tb_score_student`
--
ALTER TABLE `tb_score_student`
  ADD CONSTRAINT `score_id` FOREIGN KEY (`score_id`) REFERENCES `tb_score` (`score_id`),
  ADD CONSTRAINT `score_student` FOREIGN KEY (`student_id`) REFERENCES `tb_student` (`student_id`);

--
-- Constraints for table `tb_staff`
--
ALTER TABLE `tb_staff`
  ADD CONSTRAINT `fk_staff_user` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_student_grade`
--
ALTER TABLE `tb_student_grade`
  ADD CONSTRAINT `fk_grade` FOREIGN KEY (`grade_id`) REFERENCES `tb_grade` (`grade_id`),
  ADD CONSTRAINT `fk_student` FOREIGN KEY (`student_id`) REFERENCES `tb_student` (`student_id`);

--
-- Constraints for table `tb_student_parent`
--
ALTER TABLE `tb_student_parent`
  ADD CONSTRAINT `fk_ortu` FOREIGN KEY (`parent_id`) REFERENCES `tb_parent` (`parent_id`),
  ADD CONSTRAINT `fk_student_parent` FOREIGN KEY (`student_id`) REFERENCES `tb_student` (`student_id`);

--
-- Constraints for table `tb_timeline`
--
ALTER TABLE `tb_timeline`
  ADD CONSTRAINT `timeline_author` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_timeline_comments`
--
ALTER TABLE `tb_timeline_comments`
  ADD CONSTRAINT `comment_author` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`),
  ADD CONSTRAINT `fk_timeline` FOREIGN KEY (`timeline_id`) REFERENCES `tb_timeline` (`timeline_id`);

--
-- Constraints for table `tb_timeline_likes`
--
ALTER TABLE `tb_timeline_likes`
  ADD CONSTRAINT `fk_timeline_like` FOREIGN KEY (`timeline_id`) REFERENCES `tb_timeline` (`timeline_id`),
  ADD CONSTRAINT `like_author` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_user_devices`
--
ALTER TABLE `tb_user_devices`
  ADD CONSTRAINT `user_device` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_user_language`
--
ALTER TABLE `tb_user_language`
  ADD CONSTRAINT `fk_user_language` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_user_themes`
--
ALTER TABLE `tb_user_themes`
  ADD CONSTRAINT `fk_user_themes` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
