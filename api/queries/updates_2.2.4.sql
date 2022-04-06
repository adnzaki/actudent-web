ALTER TABLE `tb_parent` DROP PRIMARY KEY, ADD PRIMARY KEY (`parent_id`, `user_id`) USING BTREE; 

ALTER TABLE `tb_grade` ADD `rombel_dapodik_id` VARCHAR(50) NULL DEFAULT NULL AFTER `grade_status`; 

DROP TABLE `tb_user_language`, `tb_user_themes`, `tb_user_token`;

ALTER TABLE `tb_journal` ADD `journal_date` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_archive`; 