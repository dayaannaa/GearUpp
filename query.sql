CREATE TABLE calendar_event_master {
    event_id int() PRIMARY KEY AUTO_INCREMENT,
    event_name VARCHAR(15) DEFAULT NULL,
    event_start_date DATE DEFAULT NULL,
    event_end_date DATE DEFAULT NULL
}