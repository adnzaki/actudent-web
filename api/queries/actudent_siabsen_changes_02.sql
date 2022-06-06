ALTER TABLE `tb_staff_presence_permit` CHANGE `permit_status` `permit_status` 
ENUM('submitted','pending','approved','rejected') 
CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL; 