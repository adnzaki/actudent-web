ALTER TABLE `tb_staff_presence_config` CHANGE `presence_starttime` `presence_timein` TIME NOT NULL; 
ALTER TABLE `tb_staff_presence_config` CHANGE `presence_endtime` `presence_timeout` TIME NOT NULL; 