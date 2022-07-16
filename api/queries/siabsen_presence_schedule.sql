CREATE TABLE IF NOT EXISTS tb_staff_presence_schedule(
	presence_schedule_id int PRIMARY KEY,
    staff_id int,
    presence_schedule_days varchar(50),
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)