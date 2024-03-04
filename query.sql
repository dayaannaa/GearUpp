CREATE DATABASE gearup;

USE gearup;

CREATE TABLE `admin_account` (
  `admin_id` int PRIMARY KEY AUTO_INCREMENT,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
);

INSERT INTO admin_account VALUES (1, 'daniel.davis', 'admin'), 
                                 (2, 'diana.carreon', 'admin'), 
                                 (3, 'resty.cailao', 'admin'), 
                                 (4, 'renci.baloloy', 'admin')
;

CREATE TABLE `user_info` (
  `user_id` int PRIMARY KEY AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `user_image` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE calendar_event_master (
    `event_id` int PRIMARY KEY AUTO_INCREMENT,
    `event_name` VARCHAR(15) DEFAULT NULL,
    `event_start_date` DATE DEFAULT NULL,
    `event_end_date` DATE DEFAULT NULL,
    `event_start_time` TIME DEFAULT NULL,
    `event_end_time` TIME DEFAULT NULL,
    `event_color` VARCHAR(20)
);

CREATE TABLE `appointment` (
  `appointment_id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int,
  `event_id` INT,
  FOREIGN KEY (event_id) REFERENCES calendar_event_master(event_id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES user_info(user_id) ON DELETE CASCADE
);

CREATE TABLE `payment` (
  `payment_id` int PRIMARY KEY AUTO_INCREMENT,
  `appointment_id` INT,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  FOREIGN KEY (appointment_id) REFERENCES appointment(appointment_id) ON DELETE CASCADE
);

-- CREATE TABLE legends (
--     legend_id INT PRIMARY KEY AUTO_INCREMENT,
--     name VARCHAR(255) NOT NULL,
--     color VARCHAR(20) NOT NULL
-- );

CREATE TABLE `products` (
  `ProductID` int(11) PRIMARY KEY AUTO_INCREMENT,
  `ProductName` varchar(100) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `productImage` VARCHAR(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;