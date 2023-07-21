CREATE TABLE IF NOT EXISTS tb_holiday (
    id int PRIMARY KEY,
    holiday_name varchar(255),
    holiday_type ENUM('all', 'teacher', 'staff'),
    date_start date,
    date_end date,
    created timestamp DEFAULT CURRENT_TIMESTAMP,
    modified timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)