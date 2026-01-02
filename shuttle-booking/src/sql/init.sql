-- MySQL 5.7 compatible init for shuttle-booking
USE `shuttle`;

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `sbshuttle_bookings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) DEFAULT NULL,
  `locale_id` int(11) unsigned DEFAULT NULL,
  `client_id` int(11) unsigned DEFAULT NULL,
  `location_id` int(11) unsigned DEFAULT NULL,
  `dropoff_id` int(11) unsigned DEFAULT NULL,
  `line_id` int(11) unsigned DEFAULT NULL,
  `traveling` enum('from','to') DEFAULT 'from',
  `distance` int(11) unsigned DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `booking_time` time DEFAULT NULL,
  `duration` int(11) unsigned DEFAULT NULL,
  `has_return` enum('T','F') DEFAULT 'F',
  `return_date` date DEFAULT NULL,
  `return_time` time DEFAULT NULL,
  `return_line_id` int(11) unsigned DEFAULT NULL,
  `return_duration` int(11) unsigned DEFAULT NULL,
  `passengers` int(11) DEFAULT NULL,
  `luggage` int(11) DEFAULT NULL,
  `sub_total` decimal(9,2) unsigned DEFAULT NULL,
  `tax` decimal(9,2) unsigned DEFAULT NULL,
  `total` decimal(9,2) unsigned DEFAULT NULL,
  `deposit` decimal(9,2) unsigned DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `status` enum('confirmed','cancelled','pending') DEFAULT 'pending',
  `txn_id` varchar(255) DEFAULT NULL,
  `processed_on` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `c_title` varchar(255) DEFAULT NULL,
  `c_fname` varchar(255) DEFAULT NULL,
  `c_lname` varchar(255) DEFAULT NULL,
  `c_phone` varchar(255) DEFAULT NULL,
  `c_email` varchar(255) DEFAULT NULL,
  `c_company` varchar(255) DEFAULT NULL,
  `c_notes` text,
  `c_address` varchar(255) DEFAULT NULL,
  `c_city` varchar(255) DEFAULT NULL,
  `c_state` varchar(255) DEFAULT NULL,
  `c_zip` varchar(255) DEFAULT NULL,
  `c_country` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
