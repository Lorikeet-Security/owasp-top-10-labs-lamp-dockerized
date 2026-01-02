DROP TABLE IF EXISTS `shuttle_bookings`;
CREATE TABLE IF NOT EXISTS `shuttle_bookings` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `uuid` varchar(255) DEFAULT NULL,
  `locale_id` int(10) unsigned DEFAULT NULL,
  `client_id` int(10) unsigned DEFAULT NULL,
  `location_id` int(10) unsigned DEFAULT NULL COMMENT 'Location ID',
  `dropoff_id` int(10) unsigned DEFAULT NULL COMMENT 'Location ID',
  `line_id` int(10) unsigned DEFAULT NULL,
  `traveling` enum('from','to') DEFAULT 'from',
  `distance` int(10) unsigned DEFAULT NULL,
  `booking_date` date default NULL,
  `booking_time` time DEFAULT NULL,
  `duration` int(10) unsigned DEFAULT NULL,
  `has_return` enum('T','F') DEFAULT 'F',
  `return_date` date default NULL,
  `return_time` time DEFAULT NULL,
  `return_line_id` int(10) unsigned DEFAULT NULL,
  `return_duration` int(10) unsigned DEFAULT NULL,
  `passengers` int(5) default NULL,
  `luggage` int(5) default NULL,
  `sub_total` decimal(9,2) unsigned default NULL,
  `tax` decimal(9,2) unsigned default NULL,
  `total` decimal(9,2) unsigned default NULL,
  `deposit` decimal(9,2) unsigned default NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `status` enum('confirmed','cancelled','pending') default 'pending',
  `txn_id` varchar(255) default NULL,
  `processed_on` datetime default NULL,
  `created` datetime default NULL,
  `ip` varchar(255) default NULL,
  `c_title` varchar(255) default NULL,
  `c_fname` varchar(255) default NULL,
  `c_lname` varchar(255) default NULL,
  `c_phone` varchar(255) default NULL,
  `c_email` varchar(255) default NULL,
  `c_company` varchar(255) default NULL,
  `c_notes` text default NULL,
  `c_address` varchar(255) default NULL,
  `c_city` varchar(255) default NULL,
  `c_state` varchar(255) default NULL,
  `c_zip` varchar(255) default NULL,
  `c_country` int(10) unsigned default NULL,
  `c_airline_company` varchar(255) default NULL,
  `c_departure_airline_company` varchar(255) default NULL,
  `c_flight_number` varchar(255) default NULL,
  `c_flight_time` varchar(255) default NULL,
  `c_departure_flight_number` varchar(255) default NULL,
  `c_departure_flight_time` varchar(255) default NULL,
  `c_destination_address` varchar(255) default NULL,
  `c_cruise_ship` varchar(255) default NULL,
  `c_terminal` varchar(255) DEFAULT NULL,
  `cc_type` blob,
  `cc_num` blob,
  `cc_exp_month` blob,
  `cc_exp_year` blob,
  `cc_code` blob,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uuid` (`uuid`),
  KEY `line_id` (`line_id`),
  KEY `location_id` (`location_id`),
  KEY `dropoff_id` (`dropoff_id`),
  KEY `return_line_id` (`return_line_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `shuttle_bookings_payments`;
CREATE TABLE IF NOT EXISTS `shuttle_bookings_payments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `booking_id` int(10) unsigned default NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `amount` decimal(9,2) unsigned DEFAULT NULL,
  `status` enum('paid','notpaid') DEFAULT 'paid',
  PRIMARY KEY  (`id`),
  KEY `booking_id` (`booking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `shuttle_clients`;
CREATE TABLE IF NOT EXISTS `shuttle_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `foreign_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `country_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `shuttle_lines`;
CREATE TABLE IF NOT EXISTS `shuttle_lines` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` int(10) unsigned DEFAULT NULL,
  `seats` int(5) unsigned DEFAULT NULL,
  `source_path` varchar(255) DEFAULT NULL,
  `thumb_path` varchar(255) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `location_id` (`location_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `shuttle_line_details`;
CREATE TABLE IF NOT EXISTS `shuttle_line_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `line_id` int(10) unsigned DEFAULT NULL,
  `location_id` int(10) unsigned DEFAULT NULL,
  `duration_pickup` int(5) DEFAULT NULL,
  `duration_dropoff` int(5) DEFAULT NULL,
  `price_pickup` decimal(9,2) DEFAULT NULL,
  `price_dropoff` decimal(9,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `line_id` (`line_id`),
  KEY `location_id` (`location_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `shuttle_timetable`;
CREATE TABLE IF NOT EXISTS `shuttle_timetable` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `line_id` int(10) unsigned DEFAULT NULL,
  `location_id` int(10) unsigned DEFAULT NULL,
  `direction` enum('arriving','departing') DEFAULT 'departing',
  `every` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `status` enum('T','F') NOT NULL DEFAULT 'T',
  PRIMARY KEY (`id`),
  KEY `line_id` (`line_id`),
  KEY `location_id` (`location_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `shuttle_locations`;
CREATE TABLE IF NOT EXISTS `shuttle_locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('DA','PD') NOT NULL DEFAULT 'DA',
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `status` enum('T','F') NOT NULL DEFAULT 'T',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `shuttle_options`;
CREATE TABLE IF NOT EXISTS `shuttle_options` (
  `foreign_id` int(10) unsigned NOT NULL DEFAULT '0',
  `key` varchar(255) NOT NULL DEFAULT '',
  `tab_id` tinyint(3) unsigned DEFAULT NULL,
  `value` text,
  `label` text,
  `type` enum('string','text','int','float','enum','bool') NOT NULL DEFAULT 'string',
  `order` int(10) unsigned DEFAULT NULL,
  `is_visible` tinyint(1) unsigned DEFAULT '1',
  `style` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`foreign_id`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `shuttle_notifications`;
CREATE TABLE IF NOT EXISTS `shuttle_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recipient` enum('client','admin') DEFAULT NULL,
  `transport` enum('email','sms') DEFAULT NULL,
  `variant` varchar(30) DEFAULT NULL,
  `is_active` tinyint(1) unsigned DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `recipient` (`recipient`,`transport`,`variant`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `shuttle_notifications` (`id`, `recipient`, `transport`, `variant`, `is_active`) VALUES
(1, 'client', 'email', 'confirmation', 1),
(2, 'client', 'email', 'payment', 1),
(3, 'client', 'email', 'cancel', 1),
(4, 'client', 'email', 'account', 1),
(5, 'client', 'email', 'forgot', 1),
(6, 'client', 'sms', 'confirmation', 1),
(7, 'admin', 'email', 'confirmation', 1),
(8, 'admin', 'email', 'payment', 1),
(9, 'admin', 'email', 'cancel', 1),
(10, 'admin', 'sms', 'confirmation', 1),
(11, 'admin', 'sms', 'payment', 1),
(12, 'admin', 'email', 'account', 1);

INSERT INTO `shuttle_options` (`foreign_id`, `key`, `tab_id`, `value`, `label`, `type`, `order`, `is_visible`, `style`) VALUES
(1, 'o_mileage', 2, 'miles|km::km', 'Miles|Km', 'enum', 1, 1, NULL),
(1, 'o_deposit_payment', 2, '10.00', NULL, 'int', 2, 1, NULL),
(1, 'o_tax_payment', 2, '10.00', NULL, 'int', 4, 1, NULL),
(1, 'o_booking_status', 2, 'confirmed|pending|cancelled::pending', 'Confirmed|Pending|Cancelled', 'enum', 5, 1, NULL),
(1, 'o_payment_status', 2, 'confirmed|pending|cancelled::confirmed', 'Confirmed|Pending|Cancelled', 'enum', 6, 1, NULL),
(1, 'o_thankyou_page', 2, 'http://www.phpjabbers.com', NULL, 'string', 8, 1, NULL),
(1, 'o_vehicle_per_page', 2, '5', NULL, 'int', 9, 1, NULL),
(1, 'o_payment_disable', 2, 'Yes|No::No', 'Yes|No', 'enum', 10, 1, NULL),

(1, 'o_bf_include_title', 4, '1|2|3::1', 'No|Yes|Yes (required)', 'enum', 1, 1, NULL),
(1, 'o_bf_include_fname', 4, '1|2|3::3', 'No|Yes|Yes (required)', 'enum', 2, 1, NULL),
(1, 'o_bf_include_lname', 4, '1|2|3::3', 'No|Yes|Yes (required)', 'enum', 3, 1, NULL),
(1, 'o_bf_include_phone', 4, '1|2|3::3', 'No|Yes|Yes (required)', 'enum', 4, 1, NULL),
(1, 'o_bf_include_email', 4, '1|2|3::3', 'No|Yes|Yes (required)', 'enum', 5, 1, NULL),
(1, 'o_bf_include_company', 4, '1|2|3::2', 'No|Yes|Yes (required)', 'enum', 6, 1, NULL),
(1, 'o_bf_include_address', 4, '1|2|3::2', 'No|Yes|Yes (required)', 'enum', 7, 1, NULL),
(1, 'o_bf_include_notes', 4, '1|2|3::2', 'No|Yes|Yes (required)', 'enum', 8, 1, NULL),
(1, 'o_bf_include_promo', 4, '1|2|3::2', 'No|Yes|Yes (required)', 'enum', 9, 0, NULL),
(1, 'o_bf_include_city', 4, '1|2|3::2', 'No|Yes|Yes (required)', 'enum', 10, 1, NULL),
(1, 'o_bf_include_state', 4, '1|2|3::2', 'No|Yes|Yes (required)', 'enum', 11, 1, NULL),
(1, 'o_bf_include_zip', 4, '1|2|3::2', 'No|Yes|Yes (required)', 'enum', 12, 1, NULL),
(1, 'o_bf_include_country', 4, '1|2|3::2', 'No|Yes|Yes (required)', 'enum', 13, 1, NULL),
(1, 'o_bf_include_airline_company', 4, '1|2|3::2', 'No|Yes|Yes (required)', 'enum', 14, 1, NULL),
(1, 'o_bf_include_flight_number', 4, '1|2|3::2', 'No|Yes|Yes (required)', 'enum', 15, 1, NULL),
(1, 'o_bf_include_flight_time', 4, '1|2|3::2', 'No|Yes|Yes (required)', 'enum', 16, 1, NULL),
(1, 'o_bf_include_terminal', 4, '1|2|3::2', 'No|Yes|Yes (required)', 'enum', 18, 1, NULL),
(1, 'o_bf_include_captcha', 4, '1|2|3::3', 'No|Yes|Yes (required)', 'enum', 19, 1, NULL),

(1, 'o_theme', 99, 'theme1|theme2|theme3|theme4|theme5|theme6|theme7|theme8|theme9|theme10::theme1', 'Theme 1|Theme 2|Theme 3|Theme 4|Theme 5|Theme 6|Theme 7|Theme 8|Theme 9|Theme 10', 'enum', NULL, 0, NULL),
(1, 'o_terms', 5, '', NULL, 'text', 1, 1, NULL),
(1, 'o_multi_lang', 99, '1|0::1', NULL, 'enum', NULL, 0, NULL),
(1, 'o_fields_index', 99, 'd874fcc5fe73b90d770a544664a3775d', NULL, 'string', NULL, 0, NULL);

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'addLocale', 'backend', 'Add language', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add language', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'adminForgot', 'backend', 'Forgot password', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Password reminder', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'adminLogin', 'backend', 'Admin Login', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Admin Login', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'backend', 'backend', 'Backend titles', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Back-end titles', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'booking_statuses_ARRAY_cancelled', 'arrays', 'booking_statuses_ARRAY_cancelled', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Cancelled', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'booking_statuses_ARRAY_confirmed', 'arrays', 'booking_statuses_ARRAY_confirmed', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Confirmed', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'booking_statuses_ARRAY_pending', 'arrays', 'booking_statuses_ARRAY_pending', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Pending', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnAdd', 'backend', 'Button Add', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add +', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnAddClient', 'backend', 'Button / Add client', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add client', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnAddDropoffLocation', 'backend', 'Button / Add pick-up / drop off location', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add pick-up / drop off location', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnAddEnquiry', 'backend', 'Button / Add enquiry', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add enquiry', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnAddLine', 'backend', 'Button / Add line', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add line', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnAddLocation', 'backend', 'Buttons / Add location', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add location', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnAddTime', 'backend', 'Button / Add time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnAddTimetable', 'backend', 'button / Add timetable', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add timetable', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnAddTransfer', 'backend', 'Button / Add transfer', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add transfer', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnAddUser', 'backend', 'Button / Add user', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add user', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnAddVehicle', 'backend', 'Button / Add vehicle', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add vehicle', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnBack', 'backend', 'Button Back', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', '« Back', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnBackup', 'backend', 'Button Backup', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Backup', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnCancel', 'backend', 'Button Cancel', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Cancel', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnContinue', 'backend', 'Button Continue', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Continue', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnDelete', 'backend', 'Button Delete', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnEdit', 'backend', 'Button / Edit', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Edit', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnGenerate', 'backend', 'Button / Generate', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Generate', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnLogin', 'backend', 'Login', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Login', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnPreview', 'backend', 'Button / Preview', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Preview', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnRemove', 'backend', 'Button / Remove', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Remove', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnReset', 'backend', 'Reset', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Reset', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnSave', 'backend', 'Save', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Save', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnSearch', 'backend', 'Search', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Search', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnSend', 'backend', 'Button Send', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Send', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnUpdate', 'backend', 'Update', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Update', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btnUseThisTheme', 'backend', 'Button / Use this theme', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Use this theme', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'buttons_ARRAY_cancel', 'arrays', 'buttons_ARRAY_cancel', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Cancel', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'buttons_ARRAY_copy', 'arrays', 'buttons_ARRAY_copy', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Copy', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'buttons_ARRAY_no', 'arrays', 'buttons_ARRAY_no', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'No', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'buttons_ARRAY_set', 'arrays', 'buttons_ARRAY_set', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Set', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'buttons_ARRAY_yes', 'arrays', 'buttons_ARRAY_yes', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Yes', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'cancel_err_ARRAY_1', 'arrays', 'cancel_err_ARRAY_1', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Missing parameters', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'cancel_err_ARRAY_2', 'arrays', 'cancel_err_ARRAY_2', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Reservation with such ID does not exist.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'cancel_err_ARRAY_200', 'arrays', 'cancel_err_ARRAY_200', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Reservation has been cancelled successfully.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'cancel_err_ARRAY_3', 'arrays', 'cancel_err_ARRAY_3', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Security hash did not match.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'cancel_err_ARRAY_4', 'arrays', 'cancel_err_ARRAY_4', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Your reservation was already cancelled.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'cc_types_ARRAY_AmericanExpress', 'arrays', 'cc_types_ARRAY_AmericanExpress', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'American Express', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'cc_types_ARRAY_Maestro', 'arrays', 'cc_types_ARRAY_Maestro', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Maestro', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'cc_types_ARRAY_MasterCard', 'arrays', 'cc_types_ARRAY_MasterCard', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'MasterCard', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'cc_types_ARRAY_Visa', 'arrays', 'cc_types_ARRAY_Visa', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Visa', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'created', 'backend', 'Created', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'DateTime', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'days_ARRAY_0', 'arrays', 'days_ARRAY_0', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Sunday', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'days_ARRAY_1', 'arrays', 'days_ARRAY_1', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Monday', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'days_ARRAY_2', 'arrays', 'days_ARRAY_2', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Tuesday', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'days_ARRAY_3', 'arrays', 'days_ARRAY_3', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Wednesday', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'days_ARRAY_4', 'arrays', 'days_ARRAY_4', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Thursday', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'days_ARRAY_5', 'arrays', 'days_ARRAY_5', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Friday', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'days_ARRAY_6', 'arrays', 'days_ARRAY_6', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Saturday', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'day_names_ARRAY_0', 'arrays', 'day_names_ARRAY_0', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'S', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'day_names_ARRAY_1', 'arrays', 'day_names_ARRAY_1', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'M', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'day_names_ARRAY_2', 'arrays', 'day_names_ARRAY_2', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'T', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'day_names_ARRAY_3', 'arrays', 'day_names_ARRAY_3', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'W', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'day_names_ARRAY_4', 'arrays', 'day_names_ARRAY_4', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'T', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'day_names_ARRAY_5', 'arrays', 'day_names_ARRAY_5', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'F', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'day_names_ARRAY_6', 'arrays', 'day_names_ARRAY_6', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'S', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'day_short_names_ARRAY_0', 'arrays', 'day_short_names_ARRAY_0', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Su', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'day_short_names_ARRAY_1', 'arrays', 'day_short_names_ARRAY_1', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Mo', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'day_short_names_ARRAY_2', 'arrays', 'day_short_names_ARRAY_2', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Tu', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'day_short_names_ARRAY_3', 'arrays', 'day_short_names_ARRAY_3', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'We', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'day_short_names_ARRAY_4', 'arrays', 'day_short_names_ARRAY_4', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Th', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'day_short_names_ARRAY_5', 'arrays', 'day_short_names_ARRAY_5', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Fr', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'day_short_names_ARRAY_6', 'arrays', 'day_short_names_ARRAY_6', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Sa', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'delete_confirmation', 'backend', 'Label / delete confirmation', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Are you sure that you want to delete selected record(s)?', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'delete_selected', 'backend', 'Label / Delete selected', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete selected', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'email', 'backend', 'E-Mail', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Email', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'emailForgotBody', 'backend', 'Email / Forgot Body', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Dear {Name},Your password: {Password}', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'emailForgotSubject', 'backend', 'Email / Forgot Subject', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Password reminder', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'email_taken', 'backend', 'Label / email taken', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Email address was already used.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AA10', 'arrays', 'error_bodies_ARRAY_AA10', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Given email address is not associated with any account.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AA11', 'arrays', 'error_bodies_ARRAY_AA11', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'For further instructions please check your mailbox.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AA12', 'arrays', 'error_bodies_ARRAY_AA12', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'We are sorry, please try again later.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AA13', 'arrays', 'error_bodies_ARRAY_AA13', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'All the changes made to your profile have been saved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AB01', 'arrays', 'error_bodies_ARRAY_AB01', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc at ligula non arcu dignissim pretium. Praesent in magna nulla, in porta leo.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AB02', 'arrays', 'error_bodies_ARRAY_AB02', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'All backup files have been saved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AB03', 'arrays', 'error_bodies_ARRAY_AB03', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'No option was selected.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AB04', 'arrays', 'error_bodies_ARRAY_AB04', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Backup not performed.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AB09', 'arrays', 'error_bodies_ARRAY_AB09', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Reservation confirmation has been sent successfully to the client.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AB10', 'arrays', 'error_bodies_ARRAY_AB10', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'We are sorry that the confirmation email could not be sent successfully.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AB11', 'arrays', 'error_bodies_ARRAY_AB11', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'SMS has been sent to client.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AB12', 'arrays', 'error_bodies_ARRAY_AB12', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'We are sorry that the SMS could not be sent to client successfully.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_ABB01', 'arrays', 'error_bodies_ARRAY_ABB01', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'All changes made to the reservation have been saved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_ABB03', 'arrays', 'error_bodies_ARRAY_ABB03', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New reservation has been added to the list.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_ABB04', 'arrays', 'error_bodies_ARRAY_ABB04', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'We are sorry that the reservation could not bee added successfully.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_ABB08', 'arrays', 'error_bodies_ARRAY_ABB08', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'We are sorry that the reservation you are looking is missing.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AC01', 'arrays', 'error_bodies_ARRAY_AC01', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'All the changes made to this client have been saved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AC03', 'arrays', 'error_bodies_ARRAY_AC03', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'All the changes made to this client have been saved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AC04', 'arrays', 'error_bodies_ARRAY_AC04', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'We are sorry, but the client has not been added.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AC08', 'arrays', 'error_bodies_ARRAY_AC08', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Client your looking for is missing.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AF01', 'arrays', 'error_bodies_ARRAY_AF01', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'All changes made to the vehicle have been saved successfully.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AF03', 'arrays', 'error_bodies_ARRAY_AF03', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'A new vehicle has been added to the list.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AF04', 'arrays', 'error_bodies_ARRAY_AF04', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'We are sorry that the new vehicle has not been added successfully.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AF05', 'arrays', 'error_bodies_ARRAY_AF05', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New vehicle could not be added because image size too large and your server cannot upload it. Maximum allowed size is {SIZE}. Please, upload smaller image.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AF06', 'arrays', 'error_bodies_ARRAY_AF06', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'The vehicle could not be updated because image size too large and your server cannot upload it. Maximum allowed size is {SIZE}. Please, upload smaller image.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AF08', 'arrays', 'error_bodies_ARRAY_AF08', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'We are sorry that the vehicle you are looking for is missing.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AF09', 'arrays', 'error_bodies_ARRAY_AF09', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New vehicle has been added, but uploaded image is too big. Please, upload smaller image.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AF10', 'arrays', 'error_bodies_ARRAY_AF10', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Uploaded image is too big. Please, upload smaller image.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AF11', 'arrays', 'error_bodies_ARRAY_AF11', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'The uploaded file actually is not a image file. Please upload another image.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AL01', 'arrays', 'error_bodies_ARRAY_AL01', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'All changes you made to the location have been saved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AL03', 'arrays', 'error_bodies_ARRAY_AL03', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New location has been added successfully.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AL04', 'arrays', 'error_bodies_ARRAY_AL04', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Entry wasn''t saved. Please try again!', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AL08', 'arrays', 'error_bodies_ARRAY_AL08', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'We are sorry that location you are looking is missing.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AL09', 'arrays', 'error_bodies_ARRAY_AL09', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'All changes made to the prices have been saved successfully.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_ALC01', 'arrays', 'error_bodies_ARRAY_ALC01', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'All the changes made to titles have been saved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_ALN01', 'arrays', 'error_bodies_ARRAY_ALN01', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'All changes made to the line have been saved successfully.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_ALN03', 'arrays', 'error_bodies_ARRAY_ALN03', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'A new line has been added to the list.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_ALN04', 'arrays', 'error_bodies_ARRAY_ALN04', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'We are sorry that the new line has not been added successfully.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_ALN05', 'arrays', 'error_bodies_ARRAY_ALN05', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New line could not be added because image size too large and your server cannot upload it. Maximum allowed size is {SIZE}. Please, upload smaller image.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_ALN06', 'arrays', 'error_bodies_ARRAY_ALN06', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'The line could not be updated because image size too large and your server cannot upload it. Maximum allowed size is {SIZE}. Please, upload smaller image.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_ALN08', 'arrays', 'error_bodies_ARRAY_ALN08', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'We are sorry that the line you are looking for is missing.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_ALN09', 'arrays', 'error_bodies_ARRAY_ALN09', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New line has been added, but uploaded image is too big. Please, upload smaller image.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_ALN10', 'arrays', 'error_bodies_ARRAY_ALN10', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Uploaded image is too big. Please, upload smaller image.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_ALN11', 'arrays', 'error_bodies_ARRAY_ALN11', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'The uploaded file actually is not a image file. Please upload another image.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AO01', 'arrays', 'error_bodies_ARRAY_AO01', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'All changes made to the options page have been saved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AO02', 'arrays', 'error_bodies_ARRAY_AO02', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'All changes made have been saved successfully.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AO03', 'arrays', 'error_bodies_ARRAY_AO03', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'All changes made to the reservation form settings have been saved successfully.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AO04', 'arrays', 'error_bodies_ARRAY_AO04', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'All changes made to the notifications have been saved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AO05', 'arrays', 'error_bodies_ARRAY_AO05', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'All changes to the Terms have been saved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AR01', 'arrays', 'error_bodies_ARRAY_AR01', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'The report cannot be generated because you did not set "Date from" or "Date to", or you did not select "Pick-up location" or "Vehicle" as well.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_ATB01', 'arrays', 'error_bodies_ARRAY_ATB01', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'All changes made to the timetable have been saved successfully.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_ATB03', 'arrays', 'error_bodies_ARRAY_ATB03', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'A new timetable has been added to the list.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_ATB04', 'arrays', 'error_bodies_ARRAY_ATB04', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'We are sorry that the new timetable has not been added successfully.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_ATB08', 'arrays', 'error_bodies_ARRAY_ATB08', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'We are sorry that the timetable you are looking for is missing.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AU01', 'arrays', 'error_bodies_ARRAY_AU01', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'All the changes made to this user have been saved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AU03', 'arrays', 'error_bodies_ARRAY_AU03', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'All the changes made to this user have been saved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AU04', 'arrays', 'error_bodies_ARRAY_AU04', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'We are sorry, but the user has not been added.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_bodies_ARRAY_AU08', 'arrays', 'error_bodies_ARRAY_AU08', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'User your looking for is missing.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AA10', 'arrays', 'error_titles_ARRAY_AA10', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Account not found!', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AA11', 'arrays', 'error_titles_ARRAY_AA11', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Password send!', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AA12', 'arrays', 'error_titles_ARRAY_AA12', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Password not send!', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AA13', 'arrays', 'error_titles_ARRAY_AA13', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Profile updated!', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AB01', 'arrays', 'error_titles_ARRAY_AB01', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Backup', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AB02', 'arrays', 'error_titles_ARRAY_AB02', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Backup complete!', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AB03', 'arrays', 'error_titles_ARRAY_AB03', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Backup failed!', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AB04', 'arrays', 'error_titles_ARRAY_AB04', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Backup failed!', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AB09', 'arrays', 'error_titles_ARRAY_AB09', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Confirmation sent', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AB10', 'arrays', 'error_titles_ARRAY_AB10', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Confirmation not sent', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AB11', 'arrays', 'error_titles_ARRAY_AB11', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'SMS sent', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AB12', 'arrays', 'error_titles_ARRAY_AB12', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'SMS not sent', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_ABB01', 'arrays', 'error_titles_ARRAY_ABB01', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Reservation updated', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_ABB03', 'arrays', 'error_titles_ARRAY_ABB03', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Reservation added', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_ABB04', 'arrays', 'error_titles_ARRAY_ABB04', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Reservation failed to add', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_ABB08', 'arrays', 'error_titles_ARRAY_ABB08', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Reservation not found', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AC01', 'arrays', 'error_titles_ARRAY_AC01', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Client updated!', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AC03', 'arrays', 'error_titles_ARRAY_AC03', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Client added!', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AC04', 'arrays', 'error_titles_ARRAY_AC04', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Client failed to add.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AC08', 'arrays', 'error_titles_ARRAY_AC08', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Client not found.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AF01', 'arrays', 'error_titles_ARRAY_AF01', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Vehicle updated', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AF03', 'arrays', 'error_titles_ARRAY_AF03', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Vehicle added', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AF04', 'arrays', 'error_titles_ARRAY_AF04', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Vehicle failed to add', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AF05', 'arrays', 'error_titles_ARRAY_AF05', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Image size too large', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AF06', 'arrays', 'error_titles_ARRAY_AF06', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Image size too large', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AF08', 'arrays', 'error_titles_ARRAY_AF08', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Vehicle not found', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AF09', 'arrays', 'error_titles_ARRAY_AF09', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'File size exceeded', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AF10', 'arrays', 'error_titles_ARRAY_AF10', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'File size exceeded', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AF11', 'arrays', 'error_titles_ARRAY_AF11', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Wrong file type', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AL01', 'arrays', 'error_titles_ARRAY_AL01', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Changes have been saved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AL03', 'arrays', 'error_titles_ARRAY_AL03', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Location added!', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AL04', 'arrays', 'error_titles_ARRAY_AL04', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Error!', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AL08', 'arrays', 'error_titles_ARRAY_AL08', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Location not found', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AL09', 'arrays', 'error_titles_ARRAY_AL09', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Prices updated', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_ALN01', 'arrays', 'error_titles_ARRAY_ALN01', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Line updated', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_ALN03', 'arrays', 'error_titles_ARRAY_ALN03', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Line added', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_ALN04', 'arrays', 'error_titles_ARRAY_ALN04', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Line failed to add', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_ALN05', 'arrays', 'error_titles_ARRAY_ALN05', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Image size too large', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_ALN06', 'arrays', 'error_titles_ARRAY_ALN06', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Image size too large', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_ALN08', 'arrays', 'error_titles_ARRAY_ALN08', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Line not found', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_ALN09', 'arrays', 'error_titles_ARRAY_ALN09', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'File size exceeded', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_ALN10', 'arrays', 'error_titles_ARRAY_ALN10', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'File size exceeded', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_ALN11', 'arrays', 'error_titles_ARRAY_ALN11', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Wrong file type', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AO01', 'arrays', 'error_titles_ARRAY_AO01', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Options saved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AO02', 'arrays', 'error_titles_ARRAY_AO02', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiry options have been changed.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AO03', 'arrays', 'error_titles_ARRAY_AO03', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Reservation form settings updated', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AO04', 'arrays', 'error_titles_ARRAY_AO04', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Notifications updated', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AO05', 'arrays', 'error_titles_ARRAY_AO05', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Changes saved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AR01', 'arrays', 'error_titles_ARRAY_AR01', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Missing parameters', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_ATB01', 'arrays', 'error_titles_ARRAY_ATB01', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Timetable updated', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_ATB03', 'arrays', 'error_titles_ARRAY_ATB03', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Timetable added', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_ATB04', 'arrays', 'error_titles_ARRAY_ATB04', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Timetable failed to add', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_ATB08', 'arrays', 'error_titles_ARRAY_ATB08', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Timetable not found', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AU01', 'arrays', 'error_titles_ARRAY_AU01', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'User updated!', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AU03', 'arrays', 'error_titles_ARRAY_AU03', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'User added!', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AU04', 'arrays', 'error_titles_ARRAY_AU04', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'User failed to add.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'error_titles_ARRAY_AU08', 'arrays', 'error_titles_ARRAY_AU08', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'User not found.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'filter_ARRAY_active', 'arrays', 'filter_ARRAY_active', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Active', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'filter_ARRAY_inactive', 'arrays', 'filter_ARRAY_inactive', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Inactive', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'forgot_err_ARRAY_100', 'arrays', 'login_err_ARRAY_100', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Email does not exist in the system.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'forgot_err_ARRAY_101', 'arrays', 'forgot_err_ARRAY_101', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Your account is disabled.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'forgot_err_ARRAY_102', 'arrays', 'forgot_err_ARRAY_102', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Missing parameters.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'forgot_err_ARRAY_200', 'arrays', 'forgot_err_ARRAY_200', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'The password was already sent to your mail box.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'frontend', 'backend', 'Front-end titles', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Front-end titles', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_address', 'frontend', 'Label / Address', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Address', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_agree', 'frontend', 'Label / Agreement', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'I have read and accepted reservation', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_airline', 'frontend', 'Label / Airline', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Airline', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_airline_company', 'frontend', 'Label / Arrival airline company', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Arrival airline company', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_all_inclusive', 'frontend', 'Label / All inclusive for only', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'All inclusive for only', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_already_logged_in', 'frontend', 'Label / You already logged in.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'You already logged in.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_arrival_flight_number', 'frontend', 'Label / Arrival flight number', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Arrival flight number', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_arrival_flight_time', 'frontend', 'Label / Flight arrival time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Flight arrival time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_arriving_in_msg', 'frontend', 'Label / Arriving in message', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Arriving in {LOC} at {TIME}', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_avail_dropoff_locations', 'frontend', 'Label / Available drop-off locations', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Available drop-off locations', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_avail_pickup_locations', 'frontend', 'Label / Available pickup locations', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Available pickup locations', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_back', 'frontend', 'Label / Back', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Back', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_booking_created', 'frontend', 'Label / Booking created', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiry created', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_booking_details', 'frontend', 'Label / Booking Details', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiry Details', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_booking_id', 'frontend', 'Label / Booking ID', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiry ID', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_btn_back', 'frontend', 'Button / Back', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Back', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_btn_book', 'frontend', 'Button / Book', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Book', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_btn_cancel', 'frontend', 'button / Cancel', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Cancel', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_btn_checkout', 'frontend', 'Button / Checkout', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Checkout', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_btn_close', 'frontend', 'Button / Close', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Close', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_btn_confirm', 'frontend', 'Button / Confirm', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Confirm', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_btn_login', 'frontend', 'Button / Login', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Login', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_btn_preview', 'frontend', 'Button / Preview', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Preview', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_btn_send', 'frontend', 'Button / Send', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Send', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_btn_start_over', 'frontend', 'Button / Star over', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Star over', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_captcha', 'frontend', 'Label / Captcha', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Captcha', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_cc_code', 'frontend', 'Label / CC code', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'CC code', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_cc_exp', 'frontend', 'Label / CC expiration date', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'CC expiration date', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_cc_num', 'frontend', 'Label / CC Number', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'CC Number', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_cc_type', 'frontend', 'Label / CC Type', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'CC Type', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_change', 'frontend', 'Label / Change', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Change', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_checkout', 'frontend', 'Label / Checkout', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Checkout', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_choose', 'frontend', 'Label / Choose', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Choose', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_choose_airport', 'frontend', 'Label / Choose Airport Transfer', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Choose Airport Transfer', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_choose_provider', 'frontend', 'Label / Choose provider & service', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Choose provider & service', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_city', 'frontend', 'Label / City', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'City', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_company', 'frontend', 'Label / Company', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Company', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_confirm', 'frontend', 'Label / Confirm', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Confirm', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_country', 'frontend', 'Label / Country', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Country', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_cruise_ship', 'frontend', 'Label / Cruise ship', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Cruise ship', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_date_time', 'frontend', 'Label / Date time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Date time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_departure', 'frontend', 'Label / Departure', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Departure', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_departure_airline_company', 'frontend', 'Label / Departure airline company', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Departure airline company', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_departure_flight_number', 'frontend', 'Label / Departure flight number', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Departure flight number', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_departure_flight_time', 'frontend', 'Label / Flight departure time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Flight departure time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_deposit_required', 'frontend', 'Label / Deposit required', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Deposit required', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_destination_address', 'frontend', 'Label / Complete destination address', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Complete destination address', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_digits_validation', 'frontend', 'Lable / Please enter only digits.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Please enter only digits.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_distance', 'frontend', 'Lable / Distance', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Distance', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_dropoff', 'frontend', 'Lable / Drop-off', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Drop-off', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_duration', 'frontend', 'Label / Duration', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Duration', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_email', 'frontend', 'Label / Email', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Email', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_email_does_not_exist', 'frontend', 'Label / Email does not exist.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Email does not exist.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_existing_client', 'frontend', 'Label / Existing client', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Existing client', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_exp_month', 'frontend', 'Label / Expiration month is required.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Expiration month is required.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_exp_year', 'frontend', 'Label / Expiration year is required.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Expiration year is required.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_flight_departure_time', 'frontend', 'Label / Flight departure time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Flight departure time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_flight_details', 'frontend', 'label / Flight details', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Flight details', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_flight_details_desc', 'frontend', 'Label / Flight details description', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'If you choose airport transfer service, please enter your flight details below.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_flight_number', 'frontend', 'Label / Arrival flight number', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Flight number', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_flight_time', 'frontend', 'Label / Flight arrival time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Flight time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_fname', 'frontend', 'Label / First name', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'First name', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_forgot_password', 'frontend', 'Label / Forgot password?', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Forgot password?', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_from', 'frontend', 'Label / From', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Select pick-up', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_includes_all_taxes', 'frontend', 'Label / Includes all taxes and fees', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Includes all taxes and fees', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_incorrect_captcha', 'frontend', 'Label / Captcha is not correct.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Captcha is not correct.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_incorrect_password', 'frontend', 'Label / Password is not correct.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Password is not correct.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_invalid_date', 'frontend', 'Label / Invalid date time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'The return date time cannot be less than pick-up date time.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_invalid_date_msg', 'frontend', 'Label / The departure date cannot be after the return date.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'The departure date cannot be after the return date.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_invalid_email', 'frontend', 'Label / Invalid email', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Invalid email', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_invalid_time_msg', 'frontend', 'Label / The pickup time for the return trip cannot be less than the departure time.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'The pickup time for the return trip cannot be less than the departure time.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_km', 'frontend', 'Label / km', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'km', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_link_forgot_password', 'frontend', 'Link / Forgot password?', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Forgot password?', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_link_login', 'frontend', 'Link / Login', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Login', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_lname', 'frontend', 'Label / Last name', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Last name', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_login_message', 'frontend', 'Label / Login message', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'If you have an account, click {STAG}here{ETAG} to log in.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_logout_message', 'frontend', 'Label / Logout message', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'You already logged in, click {STAG}here{ETAG} to logout.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_messages_ARRAY_0', 'arrays', 'front_messages_ARRAY_0', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Reservation is being processed...', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_messages_ARRAY_1', 'arrays', 'front_messages_ARRAY_1', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Your reservation is saved. Redirecting to PayPal...', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_messages_ARRAY_2', 'arrays', 'front_messages_ARRAY_2', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Your reservation is saved. Redirecting to Authorize.net...', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_messages_ARRAY_3', 'arrays', 'front_messages_ARRAY_3', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Your reservation is saved successfully. Click on Start Over button to start new reservation.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_messages_ARRAY_4', 'arrays', 'front_messages_ARRAY_4', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Reservation failed to save. [STAG]Start over[ETAG].', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_messages_ARRAY_5', 'arrays', 'front_messages_ARRAY_5', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Error! [STAG]Start over[ETAG].', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_miles', 'frontend', 'Label / miles', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'miles', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_minutes', 'frontend', 'Label / minutes', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'minutes', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_new_client', 'frontend', 'Label / New client', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New client', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_notes', 'frontend', 'Label / Notes', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Notes', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_no_available_shuttles', 'frontend', 'There are no available shuttles', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'There are no available shuttles', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_no_fleet_found', 'frontend', 'Label / No fleet found', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'There are no vehicles found.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_on', 'frontend', 'Label / On', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Returning on', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_passenger', 'frontend', 'Label / Passenger', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Passenger', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_passengers', 'frontend', 'Label / Passengers', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Passengers', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_password', 'frontend', 'Label / Password', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Password', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_password_sent', 'frontend', 'Label / The password has been sent to your email address.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'The password has been sent to your email address.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_payment_medthod', 'frontend', 'Label / Payment method', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Payment method', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_personal_details', 'frontend', 'Label / Personal Details', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Personal Details', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_phone', 'frontend', 'Label / Phone', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Phone', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_pickup', 'frontend', 'Lable / Pick-up', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Pick-up', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_pieces_of_luggage', 'frontend', 'Label / Pieces of luggage', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Pieces of luggage', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_piece_of_luggage', 'frontend', 'Label / Piece of luggage', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Piece of luggage', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_plan_your_ride', 'frontend', 'Label / Plan your ride', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Choose Airport Transfer', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_preview', 'frontend', 'Label / Preview', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Preview', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_price', 'frontend', 'Label / Price', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Price', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_price_for_all_passengers', 'frontend', 'Label / Price for all passengers', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Price for all passengers', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_processed_on', 'frontend', 'Label / Processed on', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Processed on', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_required_field', 'frontend', 'Label / This field is required.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'This field is required.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_returning_on', 'frontend', 'Lable / Returning on', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Returning on', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_return_on', 'frontend', 'Label / Return on', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Returning on', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_return_trip', 'frontend', 'Label / Return trip', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Return trip', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_ride', 'frontend', 'Label / Ride', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Ride', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_search', 'frontend', 'Label / Search', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Get a quote', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_search_again', 'frontend', 'Label / Search again', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Search again', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_select_date_warning', 'frontend', 'Label / Select date warning', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Select date warning', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_select_departure_time', 'frontend', 'Label / Select departure time from {LOC}', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Select departure time from {LOC}', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_select_dropoff_lcoation', 'frontend', 'Label / Select drop-off location', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Select drop-off location', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_select_pickup_lcoation', 'frontend', 'Label / Select pickup location', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Select pickup location', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_select_pickup_time', 'frontend', 'Label / Select pickup time from {LOC}', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Select pickup time from {LOC}', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_select_return_time_msg', 'frontend', 'Label / Please select the time for return trip..', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Please select time for the return trip.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_select_time', 'frontend', 'Label / Select time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Select time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_select_time_msg', 'frontend', 'Label / Please select your time.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Please select departure time.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_select_vehicle_type', 'frontend', 'Label / Select Vehicle Type', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Select Vehicle Type', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_single_ride', 'frontend', 'Label / Single ride', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Single ride', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_state', 'frontend', 'Label / State', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'State', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_subtotal', 'frontend', 'Label / Subtotal', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Subtotal', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_tax', 'frontend', 'Label / Tax', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Tax', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_terminal', 'frontend', 'labe / Terminal / Gate', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Terminal / Gate', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_terms_conditions', 'frontend', 'Label / Terms and conditions', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Terms and conditions', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_terms_title', 'frontend', 'Label / Terms and Conditions', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Terms and Conditions', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_title', 'frontend', 'Label / Title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Title', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_to', 'frontend', 'Label / To', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Select drop-off', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_total', 'frontend', 'Label / Total', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Total', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_total_price', 'frontend', 'Label / total price', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'total price', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_transfer_reservation', 'frontend', 'Label / Transfer Reservation', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Transfer Reservation', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_transfer_text', 'frontend', 'Label / Transfer title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Transfers from {FROM} to {TO} on {DATE} for {PASSENGERS} passengers', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_transfer_text_1', 'frontend', 'Label / Transfer title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Transfers from {FROM} to {TO} on {DATE} for {PASSENGERS} passenger', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_traveling_from', 'frontend', 'Label / Traveling from', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Traveling from', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_traveling_to', 'frontend', 'Label / Traveling to', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Traveling to', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_travel_distance', 'frontend', 'Label / Travel distance', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Travel distance', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_txn_id', 'frontend', 'Label / Paypal Transaction ID', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Paypal Transaction ID', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_with', 'frontend', 'Label / With', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'With', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_your_account_disabled', 'frontend', 'Label / Your account is disabled.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', ' Your account is disabled.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_zip', 'frontend', 'Label / Zip', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Zip', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'gridActionTitle', 'backend', 'Grid / Action Title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Action confirmation', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'gridBtnCancel', 'backend', 'Grid / Button Cancel', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Cancel', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'gridBtnDelete', 'backend', 'Grid / Button Delete', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'gridBtnOk', 'backend', 'Grid / Button OK', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'OK', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'gridChooseAction', 'backend', 'Grid / Choose Action', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Choose Action', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'gridConfirmationTitle', 'backend', 'Grid / Confirmation Title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Are you sure you want to delete selected record?', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'gridDeleteConfirmation', 'backend', 'Grid / Delete confirmation', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete confirmation', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'gridEmptyResult', 'backend', 'Grid / Empty resultset', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'No records found', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'gridGotoPage', 'backend', 'Grid / Go to page', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Go to page:', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'gridItemsPerPage', 'backend', 'Grid / Items per page', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Items per page', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'gridNext', 'backend', 'Grid / Next', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Next »', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'gridNextPage', 'backend', 'Grid / Next page', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Next page', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'gridPrev', 'backend', 'Grid / Prev', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', '« Prev', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'gridPrevPage', 'backend', 'Grid / Prev page', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Prev page', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'gridTotalItems', 'backend', 'Grid / Total items', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Total items:', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoAddBookingDesc', 'backend', 'Infobox / Add new reservation', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add a new booking / enquiry to the system below.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoAddBookingTitle', 'backend', 'Infobox / Add new reservation', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add enquiry', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoAddClientDesc', 'backend', 'Infobox / Add client', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Fill in the form below and click "Save" button to add new client.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoAddClientTitle', 'backend', 'Infobox / Add client', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add client', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoAddFleetDesc', 'backend', 'Infobox / Add new fleet', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Fill the form to add a new vehicle to the system. Vehicles are important because they correspond with your services. For example, you may add either a private taxi, minibus, limousine or all, depending on the transfer services you offer.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoAddFleetTitle', 'backend', 'Infobox / Add new fleet', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New vehicle', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoAddLineDesc', 'backend', 'Infobox / Add line', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Fill in the form below and click "Save" button to add new line. You can also add as many as locations for the line.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoAddLineTitle', 'backend', 'Infobox / Add line', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add line', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoAddLocationDesc', 'backend', 'Infobox / Add new location desc', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Fill in the form below and click Save button to add new location.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoAddLocationTitle', 'backend', 'Infobox / Add new location', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add location', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoAddTimetableDesc', 'backend', 'Infobox / New timetable', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Fill in the form below and click "Save" to add new timetable.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoAddTimetableTitle', 'backend', 'Infobox / New timetable', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New timetable', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoAddUserDesc', 'backend', 'Infobox / Add user', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Fill in the form below and "save" to add a new user.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoAddUserTitle', 'backend', 'Infobox / Add user', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add user', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoBookingFormDesc', 'backend', 'Infobox / Reservation form options', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Use the drop-downs to set value for each of the fields below. Select ''Yes'' or ''No'' if you want a field to be displayed or not, and ''Yes (Required)'', if you''d like that field to be mandatory.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoBookingFormTitle', 'backend', 'Infobox / Reservation form options', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Checkout form', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoClientsDesc', 'backend', 'Infobox / List of clients', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'You can see below the list of clients. You can edit a specific client by clicking on the pencil icon on the corresponding entry.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoClientsTitle', 'backend', 'Infobox / List of clients', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'List of clients', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoConfirmation2Desc', 'backend', 'Infobox / Notifications description', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'There are three types of auto-responder messages you can send to both clients and admins. The first one will be triggered after a new enquiry is submitted via the software. The second one will be sent to confirm a successful payment and the third one - after a service has been canceled. You may enable or disable all auto-responders separately as well as personalize the message using the tokens below. <br/><br/><div class="float_left w200">{Title}<br/>{FirstName}<br/>{LastName}<br/>{Email}<br/>{Phone}<br/>{Notes}<br/>{Country}<br/>{City}<br/>{State}<br/>{Zip}<br/>{Address}<br/>{Company}</div><div class="float_left w250">{DateTime}<br/>{ReturnDateTime}<br/>{From}<br/>{To}<br/>{Line}<br/>{ReturnLine}<br/>{Passengers}<br/>{Distance}<br/>{Duration}<br/>{ReturnDuration}<br/>{UniqueID}<br/>{SubTotal}<br/>{Deposit}</div><div class="float_left w250">{Password}<br/>{Airline}<br/>{FlightNumber}<br/>{ArrivalTime}<br/>{Terminal}<br/>{PaymentMethod}<br/>{CCType}<br/>{CCNum}<br/>{CCExp}<br/>{CCSec}<br/>{CancelURL}<br/>{Tax}<br/>{Total}</div>', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoConfirmationDesc', 'backend', 'Infobox / Notifications description', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'There are three types of auto-responder messages you can send to both clients and admins. The first one will be triggered after a new enquiry is submitted via the software. The second one will be sent to confirm a successful payment and the third one - after a service has been canceled. You may enable or disable all auto-responders separately as well as personalize the message using the tokens below. <br/><br/><div class="float_left w200">{Title}<br/>{FirstName}<br/>{LastName}<br/>{Email}<br/>{Phone}<br/>{Notes}<br/>{Country}<br/>{City}<br/>{State}<br/>{Zip}<br/>{Address}<br/>{Company}</div><div class="float_left w250">{DateTime}<br/>{ReturnDateTime}<br/>{From}<br/>{To}<br/>{Line}<br/>{ReturnLine}<br/>{Passengers}<br/>{Distance}<br/>{Duration}<br/>{ReturnDuration}<br/>{UniqueID}<br/>{SubTotal}<br/>{Deposit}</div><div class="float_left w250">{Password}<br/>{Airline}<br/>{FlightNumber}<br/>{ArrivalTime}<br/>{Terminal}<br/>{PaymentMethod}<br/>{CCType}<br/>{CCNum}<br/>{CCExp}<br/>{CCSec}<br/>{CancelURL}<br/>{Tax}<br/>{Total}</div>', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoFleetsDesc', 'backend', 'Infobox / Fleets description', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Below is a list of all vehicles you have added to the system. All active vehicles can be booked on the front-end. Vehicles are important because they correspond with your services. For example, you may add either a private taxi, minibus, limousine or all, depending on the transfer services you offer. To edit vehicle details, click the pencil icon corresponding to the row. To add a new one, go to the above tab “Add new”. ', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoFleetsTitle', 'backend', 'Infobox / Fleets title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'List of vehicles', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoGeneralDesc', 'backend', 'Infobox / General Report', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'The general report summarizes your data using criteria such as pick-up location and vehicles. The report shows you the total number of enquiries, passengers served, luggage carried, traveling distance, amount collected via the system, as well as create comparison between the one-way and the round-trip bookings during the selected period of time.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoGeneralTitle', 'backend', 'Infobox / General Report', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Generate report', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoLinesDesc', 'backend', 'Infogox / Lines', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Below is the list of defined lines. If you want to add new line, click on the button "+ Add line".', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoLinesTitle', 'backend', 'Infogox / Lines', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Lines', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoListingAddressBody', 'backend', 'Infobox / Listing Address Body', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', '', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoListingAddressTitle', 'backend', 'Infobox / Listing Address Title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Location and address', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoListingBookingsBody', 'backend', 'Infobox / Listing Bookings Body', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiries', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoListingBookingsTitle', 'backend', 'Infobox / Listing Bookings Title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiries', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoListingContactBody', 'backend', 'Infobox / Listing Contact Body', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Listing Contact Body', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoListingContactTitle', 'backend', 'Infobox / Listing Contact Title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Listing Contact Title', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoListingExtendBody', 'backend', 'Infobox / Extend exp.date Body', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Extend exp.date Body', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoListingExtendTitle', 'backend', 'Infobox / Extend exp.date Title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Extend exp.date Title', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoListingPricesBody', 'backend', 'Infobox / Listing Prices Body', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Listing Prices Body', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoListingPricesTitle', 'backend', 'Infobox / Listing Prices Title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Listing Prices Title', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoLocalesArraysBody', 'backend', 'Locale / Languages Array Body', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Languages Array Body', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoLocalesArraysTitle', 'backend', 'Locale / Languages Array Title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Languages Arrays Title', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoLocalesBackendBody', 'backend', 'Infobox / Locales Backend Body', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Languages Backend Body', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoLocalesBackendTitle', 'backend', 'Infobox / Locales Backend Title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Languages Backend Title', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoLocalesBody', 'backend', 'Infobox / Locales Body', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Languages Body', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoLocalesFrontendBody', 'backend', 'Infobox / Locales Frontend Body', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Languages Frontend Body', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoLocalesFrontendTitle', 'backend', 'Infobox / Locales Frontend Title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Languages Frontend Title', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoLocalesTitle', 'backend', 'Infobox / Locales Title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Languages Title', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoLocationsDesc', 'backend', 'Infobox / Locations description', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'You can see below the list of locations. If you want to add new locations, click on the button "+ Add location".', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoLocationsTitle', 'backend', 'Infobox / Locations title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Locations', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoPickupLocationDesc', 'backend', 'Infobox / Pickup Location Report', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'In this form, you can select a specific location to generate the report. You will find in the report all of enquiries that will be transferred within the date range for selected pick-up location.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoPickupLocationTitle', 'backend', 'Infobox / Pickup Location Report', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Pick-up Location Report', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoPreviewInstallDesc', 'backend', 'Infobox / Preview Intall', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'There are multiple color schemes available for the frontend layout. Click on each of the thumbnails below to preview it. Click on "Use this theme" to apply the theme. Then scroll down and grab the Install code and put it on your web page.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoPreviewInstallTitle', 'backend', 'Infobox / Preview Intall', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Preview front-end and install on your site', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoResendEmailDesc', 'backend', 'Infobox / Re-send confirmation', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'On the form below, you can make any change on the content to be sent to client for confirming the reservation.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoResendEmailTitle', 'backend', 'Infobox / Re-send confirmation', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Re-send confirmation', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoReservationDesc', 'backend', 'Infobox / Reservation options', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Customise your own transfer enquiry system by using the options below. You can enable/disable payments, specify a percentage of security deposit and taxes, and more.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoReservationListDesc', 'backend', 'Infobox / Reservations list', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Below is a list of all customer enquiries made via the system. Here you can filter enquiries by status, re-order the list, search by multiple criteria, export and print the list. To see enquiry and client details, click the pencil icon corresponding to the row. To add a new one, go to the above tab “Add new”. ', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoReservationListTitle', 'backend', 'Infobox / Reservations list', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'List of enquiries', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoReservationTitle', 'backend', 'Infobox / Reservation options', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiry options', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoSendSmsDesc', 'backend', 'Label / Send SMS notification', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'On the form below, you can make any change on the content message that will be sent to client for confirming the reservation.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoSendSmsTitle', 'backend', 'Label / Send SMS notification', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Send SMS notification', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoTermsDesc', 'backend', 'Infobox / Terms and Conditions', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'You can add your own terms to the system. Make sure you have switched the languages (if any), before you edit the information. ', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoTermsTitle', 'backend', 'Infobox / Terms and Conditions', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add your own terms', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoTimetablesDesc', 'backend', 'Infobox / Timetables', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Below is the list of timetables. If you want to add new timetable, click "+ Add timetable".', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoTimetablesTitle', 'backend', 'Infobox / Timetables', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Timetables', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoUpdateBookingDesc', 'backend', 'Infobox / Update booking', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'See enqiry and client details below.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoUpdateBookingTitle', 'backend', 'Infobox / Update booking', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiry details', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoUpdateClientDesc', 'backend', 'Infobox / Update', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'You can make any changes on the form below and click "Save" button to edit client information.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoUpdateClientTitle', 'backend', 'Infobox / Update', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Update client', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoUpdateFleetDesc', 'backend', 'Infobox / Update fleet', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'You can make changes to the fields below for all languages you have added to the system. Make sure you have switched the languages (if any) using the flag system, before you edit the information.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoUpdateFleetTitle', 'backend', 'Infobox / Update fleet', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Edit vehicle', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoUpdateLineDesc', 'backend', 'Infobox / Update line', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'You can make any changes on the form below and click "Save" to update line information.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoUpdateLineTitle', 'backend', 'Infobox / Update line', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Update line', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoUpdateLocationDesc', 'backend', 'Infobox / Update location description', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'You can make any changes on the form below and click "Save" button to update location information.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoUpdateLocationTitle', 'backend', 'Infobox / Update location title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Update location', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoUpdatePriceDesc', 'backend', 'Label / Prices', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Set transfer fees using the table below.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoUpdatePriceTitle', 'backend', 'Label / Prices', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Prices', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoUpdateTimetableDesc', 'backend', 'Infobox / Update timetable', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'You can make any changes on the form below and click "Save" to update information of the timetable.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoUpdateTimetableTitle', 'backend', 'Infobox / Update timetable', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Update timetable', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoUpdateUserDesc', 'backend', 'Infobox / Update user', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'You can make any changes on the form below and click "Save" button to update user information.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoUpdateUserTitle', 'backend', 'Infobox / Update user', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Update user', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoUsersDesc', 'backend', 'Infobox / Users', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Below is a list of all users. You can add new users, edit user details and change user status. ', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoUsersTitle', 'backend', 'Infobox / Users', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Users', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoVehicleDesc', 'backend', 'Infobox / Vehicle Report', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'You can select which vehicle to view report. In this report, you will find all of enquiries that will be transferred within the date range for selected vehicle.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoVehicleTitle', 'backend', 'Infobox / Vehicle Report', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Vehicle Report', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblAddClient', 'backend', 'Label / Add client', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add client', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblAddFleet', 'backend', 'Label / Add fleet', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add new', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblAdditionalInfo', 'backend', 'Label / Additional info', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Additional info', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblAddLocation', 'backend', 'Label / Add location', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add new', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblAddReservation', 'backend', 'Label / Add reservation', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add new', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblAddress', 'backend', 'Label / Address', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Address', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblAddUser', 'backend', 'Add user', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add user', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblAll', 'backend', 'Label / All', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'All', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblArrivalFlightNumber', 'backend', 'Label / Arrival flight number', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Arrival flight number', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblArriving', 'backend', 'Lable / Arriving', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Arriving', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblArrivingAt', 'backend', 'Label / Arriving at', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Arriving at', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblArrivingTime', 'backend', 'Label / Arriving time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Arriving at {LOC} at', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblAvailableTime', 'backend', 'Label / Available time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Available time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBackupDatabase', 'backend', 'Backup / Database', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Backup database', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBackupFiles', 'backend', 'Backup / Files', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Backup files', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBookingAddress', 'backend', 'Label / Address', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Address', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBookingAirlineCompany', 'backend', 'Label / Airline company', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Airline company', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBookingCity', 'backend', 'Label / City', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'City', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBookingCompany', 'backend', 'Label / Company', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Company', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBookingCountry', 'backend', 'Label / Country', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Country', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBookingCruiseShip', 'backend', 'Label / Cruise ship', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Cruise ship', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBookingDestAddress', 'backend', 'Label / Complete destination address', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Complete destination address', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBookingDetails', 'backend', 'Label / Reservation details', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiry details', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBookingEmail', 'backend', 'Label / Email', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Email', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBookingFlightNumber', 'backend', 'Label / Flight number', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Flight number', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBookingFlightTime', 'backend', 'Label / Flight Time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Flight arriving from / departure to', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBookingFname', 'backend', 'Label / First name', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'First name', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBookingID', 'backend', 'Label / Booking ID', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiry ID', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBookingLname', 'backend', 'Label / Last name', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Last name', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBookingNotes', 'backend', 'Label / Notes', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Notes', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBookingPhone', 'backend', 'Label / Phone', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Phone', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBookingState', 'backend', 'Label / State', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'State', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBookingTerminal', 'backend', 'Label / Terminal / Gate', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Terminal / Gate', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBookingTitle', 'backend', 'Label / Title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Title', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblBookingZip', 'backend', 'Label / Zip', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Zip', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblCancelledReservations', 'backend', 'Label / Cancelled Reservations', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Cancelled Enquiries', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblCCCode', 'backend', 'Label / CC code', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'CC code', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblCCExp', 'backend', 'Label / CC expiration date', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'CC expiration date', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblCCNum', 'backend', 'Label / CC number', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'CC number', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblCCType', 'backend', 'Label / CC Type', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'CC Type', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblChoose', 'backend', 'Choose', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Choose', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblChooseTheme', 'backend', 'Lable / Choose theme', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Choose theme', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblClient', 'backend', 'Label / Client', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Client', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblClientDetails', 'backend', 'Label / Client details', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Client details', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblConfirmedReservations', 'backend', 'Label / Confirmed Reservations', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Confirmed Enquiries', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblCopyDropoff', 'backend', 'Label / Copy Drop-off Locations', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Copy Drop-off Locations', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblCopyLocation', 'backend', 'Label / copy location', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'or copy from another location', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblCount', 'backend', 'Label / Count', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Count', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblCreatedOn', 'backend', 'Label / Created on', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Created on', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblCurrentlyInUse', 'backend', 'Lable / Currently in use', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Currently in use', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblCustomer', 'backend', 'Label / Customer', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Customer', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDashLastLogin', 'backend', 'Label / Last login', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Last login', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDashViewAll', 'backend', 'Label / view all', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'view all', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDate', 'backend', 'Label / Date', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Date', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDateAndTime', 'backend', 'Label / Date & Time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Date & Time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDateFrom', 'backend', 'Label / Date from', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Date from', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDateTime', 'backend', 'Label / Pickup date & time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Pickup date & time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDateTo', 'backend', 'Label / Date to', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Date to', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDays', 'backend', 'Days', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'days', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDelete', 'backend', 'Delete', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDeleteConfirmation', 'backend', 'Label / Delete confirmation', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Are you sure that you want to delete the image?', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDeleteDropoff', 'backend', 'Label / Delete drop-off location', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete drop-off location', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDeleteDropoffConfirm', 'backend', 'Label / Delete confirmation', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Theer are enquiries made for this drop-off. Are you sure that you want to delete it?', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDeleteImage', 'backend', 'Label / Delete image', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete image', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDeparting', 'backend', 'Lable / Departing', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Departing', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDepartingAt', 'backend', 'Label / Departing at', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Departing at', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDepartingFrom', 'backend', 'Label / Departing from', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Departing from', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDepartingTime', 'backend', 'Label / Departing time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Departing from {LOC} at', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDeparture', 'backend', 'Lable / Departure', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Departure', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDepartureAirlineCompany', 'backend', 'Label / Departure airline company', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Departure airline company', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDepartureArrivalLocation', 'backend', 'Lable / Departure / Arrival location', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Departure / Arrival location', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDepartureFlightNumber', 'backend', 'Label / Departure flight number', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Departure flight number', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDeposit', 'backend', 'Label / Deposit', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Deposit', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDescription', 'backend', 'Label / Description', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Description', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDestinationTrips', 'backend', 'Label / Destinations Trips', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Destinations Trips (confirmed reservations only)', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDetails', 'backend', 'Label / Details', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Details', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDirection', 'backend', 'Label / Direction', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Direction', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDistance', 'backend', 'Label / Distance', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Distance', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDropoff', 'backend', 'Label / Drop-off', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Drop-off', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDropoffLocation', 'backend', 'Label / Drop-off location', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Drop-off location', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDropoffTime', 'backend', 'Label / Drop-off time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Drop-off time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDuplicatedUniqueID', 'backend', 'Label / Duplicated Unique ID', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Unique ID was already used.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDuration', 'backend', 'Label / Duration', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Duration', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblEditDropoff', 'backend', 'Label / Edit drop-off', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Edit drop-off', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblEnquiries', 'backend', 'Label / Enquiries', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiries', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblError', 'backend', 'Error', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Error', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblEvery', 'backend', 'Lable / Every', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Every', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblExistingClient', 'backend', 'Label / Existing client', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Existing client', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblExport', 'backend', 'Export', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Export', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblFleet', 'backend', 'Label / Fleet', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Vehicle', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblFlightArrivalTime', 'backend', 'Label / Flight arrival time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Flight arrival time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblFlightDepartureTime', 'backend', 'Label / Flight departure time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Flight departure time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblFlightTime', 'backend', 'Label / Flight time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Flight time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblForgot', 'backend', 'Forgot password', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Forgot password', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblFrom', 'backend', 'Label / From', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'From', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblFromPickupLocation', 'backend', 'Label / From pick-up location', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'From pick-up location', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblFromTo', 'backend', 'Label / From / To', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'From / To', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblGeneralReport', 'backend', 'Label / General Report', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Reports', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblGeneralReservationsReport', 'backend', 'Label / General Reservations Report', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'General Enquiries Report', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblHere', 'backend', 'Label / here', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'here', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblID', 'backend', 'Label / ID', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'ID', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblIfDropoff', 'backend', 'Lable / if drop off', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'if drop off', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblIfPickup', 'backend', 'Lable / if pick-up', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'if pick-up', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblImage', 'backend', 'Label / Image', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Image', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblInstallCode', 'backend', 'Lable / Install code', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Install code', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblInstallConfig', 'backend', 'Label / Installation configuration', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Installation configuration', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblInstallConfigHide', 'backend', 'Button / Hide language selector ', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Hide language selector ', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblInstallConfigLocale', 'backend', 'Label / Select language', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Select language', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblInstallJs1_body', 'backend', 'Label / Installation', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'To embed the software into a web page, please follow the steps below. Set the language configuration first, then copy the integration code and paste into your HTML page, whenever you want the software to appear.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblInstallJs1_title', 'backend', 'Label / Installation', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Installation', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblIp', 'backend', 'IP address', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'IP address', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblIpAddress', 'backend', 'Label / IP address', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'IP address', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblIsActive', 'backend', 'Is Active', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Is confirmed', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblKm', 'backend', 'Label / Km', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Km', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblLatestReservations', 'backend', 'Label / Latest Reservations', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'latest enquiries', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblLegendEmails', 'backend', 'Label / Emails', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Emails', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblLegendSMS', 'backend', 'Label / SMS', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'SMS', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblLine', 'backend', 'Label / Line', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Line', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblLocation', 'backend', 'Label / Location', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Location', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblLocationDirection', 'backend', 'Label / Location & Direction', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Location & Direction', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblLuggage', 'backend', 'Label / Luggage', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Luggage', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblLuggageCaried', 'backend', 'Label / Luggage Carried', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Luggage Carried', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblManageFleet', 'backend', 'Label / Manage fleet', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Manage vehicle', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblMaximum', 'backend', 'Label / maximum', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'maximum', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblMaxNumber', 'backend', 'Label / Maximum number', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Number cannot be greater than maximum value.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblMaxPassenger', 'backend', 'Label / Maximum passenger', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Maximum passenger', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblMinPassenger', 'backend', 'Label / Minimum passenger', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Minimum passenger', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblMins', 'backend', 'Label / mins', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'mins', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblMinutes', 'backend', 'Label / Minutes', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Minutes', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblName', 'backend', 'Name', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Name', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblNewClient', 'backend', 'Label / New client', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New client', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblNewReservationsToday', 'backend', 'Label / new reservations today', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'new enquiries today', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblNewReservationToday', 'backend', 'Label / new reservation today', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'new enquiry today', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblNo', 'backend', 'No', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'No', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblNoAvailableTime', 'backend', 'Label / There is no available time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'There is no available time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblNoLinesAvailable', 'backend', 'Label / No lines available for this location', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'No lines available for this location', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblOneWayReservations', 'backend', 'Label / One-way Reservations', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'One-way', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblOneWayRoundTrip', 'backend', 'Label / One-way vs Round-trip Reservations', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'One-way vs Round-trip (confirmed reservations only)', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblOption', 'backend', 'Option', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Option', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblOptionAdministrator', 'backend', 'Label / Administrator', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Administrator', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblOptionClient', 'backend', 'Label / Client', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Client', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblOptionList', 'backend', 'Option list', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Option list', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPassenger', 'backend', 'Label / Passenger', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Passenger', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPassengers', 'backend', 'Label / Passengers', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Passengers', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPassengersPer', 'backend', 'Label / Passengers per reservation', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Passengers per reservation (confirmed reservations only)', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPassengersServed', 'backend', 'Label / Passengers Served', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Passengers Served', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPayment', 'backend', 'Label / Payment', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Payment', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPaymentMethod', 'backend', 'Label / Payment method', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Payment method', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPerPerson', 'backend', 'Label / per person', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'per person', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPhone', 'backend', 'Label / Phone', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Phone', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPickup', 'backend', 'Label / Pickup', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Pickup', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPickupDate', 'backend', 'Label / Pickup date', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Pickup date', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPickupDropoff', 'backend', 'Label / Pickup / Dropoff', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Pickup / Dropoff', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPickupLocation', 'backend', 'Label / Pickup location', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Pick-up location', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPickupLocationReport', 'backend', 'Label / Pickup Location Report', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Pick-up Location Report', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPickupTime', 'backend', 'Label / Pick-up time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Pick-up time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPositiveNumber', 'backend', 'Label / Enter a positive number.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enter a positive number.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPrice', 'backend', 'Label / Price', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Price', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPricePerPerson', 'backend', 'Lable / Price per person', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Price per person', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPrices', 'backend', 'Label / Prices', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Prices', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPriceStatusEnd', 'backend', 'Label / Prices have been saved.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Prices have been saved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPriceStatusFail', 'backend', 'Label / Prices could not be saved.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Prices could not be saved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPriceStatusStart', 'backend', 'Label / Please wait while prices are saved.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Please wait while prices are saved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPrint', 'backend', 'Label / Print', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Print', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblPrintReservation', 'backend', 'Label / Print Reservation', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Print Reservation', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblReminderMessage', 'backend', 'Label / Message', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Message', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblReminderSubject', 'backend', 'Label / Subject', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Subject', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblReminderTo', 'backend', 'Label / To', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'To', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblReportPickupLocation', 'backend', 'Label / Report by Pickup Location', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Report by Pick-up Location', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblReportVehicle', 'backend', 'Label / Vehicle Report', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Vehicle Report', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblResendConfirmation', 'backend', 'Label / Re-send confirmation', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Re-send confirmation', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblReservationPrint', 'backend', 'Label / Print Reservation', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Print Reservation', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblReservationPrintList', 'backend', 'Label / Reservations Print List', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiries Print List', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblReservations', 'backend', 'Label / Reservations', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiries', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblReservationsNotFound', 'backend', 'Label / Reservations not found', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Not found', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblReservationsToday', 'backend', 'Label / Reservations Today', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'enquiries today', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblReturn', 'backend', 'Label / Return', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Return', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblReturnAvailableTime', 'backend', 'Label / Return available time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Return available time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblReturnDateTime', 'backend', 'Label / Return date & time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Return date & time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblReturnDuration', 'backend', 'Label / Return duration', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Return duration', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblReturnLine', 'backend', 'Label / Return line', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Return line', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblReturnOn', 'backend', 'Label / Return on', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Returning on', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblReturnPricePerPerson', 'backend', 'Label / Return price per person', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Return price per person', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblReturnTrip', 'backend', 'Label / Return trip', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Return trip', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblRole', 'backend', 'Role', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Role', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblRoundTrip', 'backend', 'Label / roundtrip', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'roundtrip', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblRoundTripReservations', 'backend', 'Label / Round-trip Reservations', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Round-trip', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblSeats', 'backend', 'Lable / Seats', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Seats', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblSendSMSNotification', 'backend', 'Label / Send SMS notification', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Send SMS notification', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblSetPrices', 'backend', 'Label / Set prices', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Set prices', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblSingle', 'backend', 'Label / single', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'single', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblSmsMessage', 'backend', 'Label / SMS message', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'SMS message', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblStatus', 'backend', 'Status', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Status', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblStatusEnd', 'backend', 'Label / Locations have been saved.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Locations have been saved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblStatusFail', 'backend', 'Label / Locations could not be saved.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Locations could not be saved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblStatusStart', 'backend', 'Label / Please wait while locations are saved.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Please wait while locations are saved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblStatusTitle', 'backend', 'Label / Status', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Status', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblSubTotal', 'backend', 'Label / Sub-total', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Sub-total', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblTax', 'backend', 'Label / Tax', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Tax', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblThumb', 'backend', 'Label / Thumb', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Thumb', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblTime', 'backend', 'Label / Time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblTitle', 'backend', 'Label / Title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Title', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblTo', 'backend', 'Label / To', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'To', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblToCollect', 'backend', 'Label / To collect', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'To collect', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblTodayTransfers', 'backend', 'Label / Today Transfers', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Today''s Transfers', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblToDropoffLocation', 'backend', 'Label / To drop-off location', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'To drop-off location', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblTotal', 'backend', 'Label / Total', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Total', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblTotalAmount', 'backend', 'Label / Total Amount', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Total Amount', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblTotalReservations', 'backend', 'Label / Total Reservations', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Total Enquiries', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblTransfer', 'frontend', 'Label / Transfer', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Transfer', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblTransferDate', 'backend', 'Label / Transfer date', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Transfer date', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblTransferDateTime', 'backend', 'Label / Transfer Date & Time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Transfer Date & Time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblTransferDestinations', 'backend', 'Label / Transfer Destinations', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Transfer Destinations', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblTransfersToday', 'backend', 'Label / Transfers Today', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'transfers today', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblTransferToday', 'backend', 'Label / Transfer Today', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'transfer today', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblTravelingFrom', 'backend', 'Label / Traveling from', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Traveling from', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblTravelingTo', 'backend', 'Label / Traveling to', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Traveling to', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblType', 'backend', 'Type', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Type', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblUniqueID', 'backend', 'Label / Unique ID', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiry ID', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblUpdateClient', 'backend', 'Label / Update client', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Update client', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblUpdateFleet', 'backend', 'Label / Update fleet', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Edit vehicle', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblUpdateLocation', 'backend', 'Label / Update location', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Edit transfer', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblUpdateReservation', 'backend', 'Label / Update reservation', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Edit ', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblUpdateUser', 'backend', 'Update user', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Update user', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblUserCreated', 'backend', 'User / Registration Date & Time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Registration date/time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblValidNumberMessage', 'backend', 'Options / Please enter a valid currency.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Please enter a valid currency.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblValue', 'backend', 'Value', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Value', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblVehicle', 'backend', 'Label / Vehicle', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Vehicle', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblVehicleReport', 'backend', 'Label / Vehicle Report', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Vehicle Report', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblVehicleUsed', 'backend', 'Label / Vehicle Used', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Vehicle Used', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblVia', 'backend', 'Label / via', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'via', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblYes', 'backend', 'Yes', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Yes', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lnkBack', 'backend', 'Link Back', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Back', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'localeArrays', 'backend', 'Locale / Arrays titles', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Arrays titles', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'locales', 'backend', 'Languages', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Languages', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'locale_flag', 'backend', 'Locale / Flag', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Flag', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'locale_is_default', 'backend', 'Locale / Is default', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Is default', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'locale_order', 'backend', 'Locale / Order', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Order', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'locale_title', 'backend', 'Locale / Title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Title', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'location_types_ARRAY_DA', 'arrays', 'location_types_ARRAY_DA', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Departure / Arrival location', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'location_types_ARRAY_PD', 'arrays', 'location_types_ARRAY_PD', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Pick-up / Drop off location', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'login_err_ARRAY_1', 'arrays', 'login_err_ARRAY_1', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Wrong username or password', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'login_err_ARRAY_2', 'arrays', 'login_err_ARRAY_2', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Access denied', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'login_err_ARRAY_3', 'arrays', 'login_err_ARRAY_3', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Account is disabled', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuBackup', 'backend', 'Menu Backup', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Backup', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuClients', 'backend', 'Menu / Clients', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Clients', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuDashboard', 'backend', 'Menu Dashboard', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Dashboard', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuFleets', 'backend', 'Menu / Fleets', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Vehicles', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuGeneral', 'backend', 'Menu / General', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'General', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuInstall', 'backend', 'Menu / Install', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Install', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuInstallPreview', 'backend', 'Menu / Preview & Install', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Preview & Install', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuLang', 'backend', 'Menu Multi lang', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Multi Lang', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuLines', 'backend', 'Menu / Lines', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Lines', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuLocales', 'backend', 'Menu Languages', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Languages', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuLocations', 'backend', 'Menu / Locations', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Locations', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuLogout', 'backend', 'Menu Logout', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Logout', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuNews', 'backend', 'Menu / News', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'News', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuNotifications', 'backend', 'Menu / Notifications', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Notifications', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuOptions', 'backend', 'Menu Options', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Options', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuPlugins', 'backend', 'Menu Plugins', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Plugins', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuPreview', 'backend', 'Menu / Preview', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Preview', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuProfile', 'backend', 'Menu Profile', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Profile', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuReports', 'backend', 'Menu / Reports', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Reports', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuReservation', 'backend', 'Menu / Reservation', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiries', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuReservationForm', 'backend', 'Menu / Checkout form', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Checkout form', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuReservations', 'backend', 'Menu / Reservations', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiries', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuTerms', 'backend', 'Menu / Terms', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Terms', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuTimetable', 'backend', 'Menu / Timetable', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Timetable', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuUsers', 'backend', 'Menu Users', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Users', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'months_ARRAY_1', 'arrays', 'months_ARRAY_1', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'January', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'months_ARRAY_10', 'arrays', 'months_ARRAY_10', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'October', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'months_ARRAY_11', 'arrays', 'months_ARRAY_11', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'November', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'months_ARRAY_12', 'arrays', 'months_ARRAY_12', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'December', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'months_ARRAY_2', 'arrays', 'months_ARRAY_2', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'February', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'months_ARRAY_3', 'arrays', 'months_ARRAY_3', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'March', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'months_ARRAY_4', 'arrays', 'months_ARRAY_4', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'April', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'months_ARRAY_5', 'arrays', 'months_ARRAY_5', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'May', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'months_ARRAY_6', 'arrays', 'months_ARRAY_6', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'June', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'months_ARRAY_7', 'arrays', 'months_ARRAY_7', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'July', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'months_ARRAY_8', 'arrays', 'months_ARRAY_8', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'August', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'months_ARRAY_9', 'arrays', 'months_ARRAY_9', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'September', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'multilangTooltip', 'backend', 'MultiLang / Tooltip', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Select a language by clicking on the corresponding flag and update existing translation.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'option_themes_ARRAY_1', 'arrays', 'option_themes_ARRAY_1', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Theme 1', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'option_themes_ARRAY_10', 'arrays', 'option_themes_ARRAY_10', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Theme 10', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'option_themes_ARRAY_2', 'arrays', 'option_themes_ARRAY_2', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Theme 2', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'option_themes_ARRAY_3', 'arrays', 'option_themes_ARRAY_3', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Theme 3', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'option_themes_ARRAY_4', 'arrays', 'option_themes_ARRAY_4', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Theme 4', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'option_themes_ARRAY_5', 'arrays', 'option_themes_ARRAY_5', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Theme 5', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'option_themes_ARRAY_6', 'arrays', 'option_themes_ARRAY_6', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Theme 6', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'option_themes_ARRAY_7', 'arrays', 'option_themes_ARRAY_7', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Theme 7', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'option_themes_ARRAY_8', 'arrays', 'option_themes_ARRAY_8', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Theme 8', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'option_themes_ARRAY_9', 'arrays', 'option_themes_ARRAY_9', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Theme 9', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_allow_authorize', 'backend', 'Options / Allow payments with Authorize.net ', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Allow payments with Authorize.net ', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_allow_bank', 'backend', 'Options / Allow bank account', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Provide Bank account details for wire transfers', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_allow_cash', 'backend', 'Options / Allow payment with cash', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Allow payment with cash', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_allow_creditcard', 'backend', 'Options / Allow credit card', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Collect Credit Card details for offline processing ', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_allow_paypal', 'backend', 'Options / Allow payment', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Allow payments with Paypal ', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_authorize_md5_hash', 'backend', 'Options / Authorize.net MD5 hash ', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Authorize.net MD5 hash ', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_authorize_merchant_id', 'backend', 'Options / Authorize.net merchant ID  ', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Authorize.net merchant ID', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_authorize_timezone', 'backend', 'Options / Authorize.net time zone ', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Authorize.net time zone', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_authorize_transkey', 'backend', 'Options / Authorize.net transaction key ', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Authorize.net transaction key ', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_bank_account', 'backend', 'Options / Bank account', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Bank account', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_bf_include_address', 'backend', 'Options / Address', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Address', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_bf_include_airline_company', 'backend', 'Options / Airline company', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Airline company', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_bf_include_captcha', 'backend', 'Options / Captcha', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Captcha', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_bf_include_city', 'backend', 'Options / City', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'City', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_bf_include_company', 'backend', 'Options / Company', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Company', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_bf_include_country', 'backend', 'Options / Country', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Country', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_bf_include_cruise_ship', 'backend', 'Options / Cruise ship', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Cruise ship', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_bf_include_destination_address', 'backend', 'Options / Complete destination address', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Complete destination address', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_bf_include_email', 'backend', 'Options / Email', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Email', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_bf_include_flight_number', 'backend', 'Options / Flight number', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Flight number', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_bf_include_flight_time', 'backend', 'Options / Flight time', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Flight arrival / departure time', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_bf_include_fname', 'backend', 'Options / First name', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'First name', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_bf_include_lname', 'backend', 'Options / Last name', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Last name', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_bf_include_notes', 'backend', 'Options / Notes', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Notes', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_bf_include_phone', 'backend', 'Options / Phone', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Phone', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_bf_include_state', 'backend', 'Options / State', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'State', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_bf_include_terminal', 'backend', 'Options / Terminal / Gate', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Terminal / Gate', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_bf_include_title', 'backend', 'Options / Title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Title', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_bf_include_zip', 'backend', 'Options / Zip', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Zip', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_booking_status', 'backend', 'Options / Booking status', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New enquiry status if not paid. ', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_currency', 'backend', 'Options / Currency', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Currency', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_currency_format', 'backend', 'Options / Currency format', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Currency format', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_date_format', 'backend', 'Options / Date format', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Date format', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_deposit_payment', 'backend', 'Options / Deposit payment', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Deposit payment', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_address', 'frontend', 'Options / Email account for email notiications', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Email account for email notiications', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_cancel', 'backend', 'Options / Send cancellation email', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Send cancellation email', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_cancel_message', 'backend', 'Options / Cancel confirmation message', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Message body', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_cancel_subject', 'backend', 'Options / Cancel confirmation subject', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Subject', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_cancel_text', 'backend', 'Options / Send cancellation email', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Select ''Yes'' if you want the system to send automatic email to the client after a service has been canceled. ', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_client_account', 'backend', 'Options / New client account email', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New client account email', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_client_account_message', 'backend', 'Options / Subject', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Message body', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_client_account_message_text', 'backend', 'Options / Account tokens', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Available Tokens:<br/><br/>{Title}<br/>{FirstName}<br/>{LastName}<br/>{Email}<br/>{Password}<br/>{Phone}', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_client_account_subject', 'backend', 'Options / Subject', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Subject', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_client_account_text', 'backend', 'Options / New client account email', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Select "Yes" if you want the system to send automatic emails to clients after client accounts are created', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_confirmation', 'backend', 'Options / New reservation received email', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New enquiry is received', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_confirmation_message', 'backend', 'Options / Reservation confirmation message', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Message body', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_confirmation_message_text', 'backend', 'Options / Reservation confirmation message', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', '<u>Available Tokens:</u><br/><br/>{Title}<br/>{FirstName}<br/>{LastName}<br/>{Email}<br/>{Phone}<br/>{Notes}<br/>{Country}<br/>{City}<br/>{State}<br/>{Zip}<br/>{Address}<br/>{Company}<br/>{Date}<br/>{From}<br/>{To}<br/>{Fleet}<br/>{Passengers}<br/>{Luggage}<br/>{UniqueID}<br/>{SubTotal}<br/>{Tax}<br/>{Total}<br/>{Deposit}<br/>{PaymentMethod}<br/>{CCType}<br/>{CCNum}<br/>{CCExp}<br/>{CCSec}<br/>{CancelURL}', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_confirmation_subject', 'backend', 'Options / Reservation confirmation subject', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Subject', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_confirmation_text', 'backend', 'Options / New reservation received email', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Select ''Yes'' if you want an auto-responder to be sent to clients after submiting new enquiry.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_forgot_message', 'backend', 'Options / Subject', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Password recovery email message', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_forgot_message_text', 'backend', 'Options / Account tokens', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Available Tokens:<br/><br/>{Title}<br/>{FirstName}<br/>{LastName}<br/>{Email}<br/>{Password}<br/>{Phone}', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_forgot_subject', 'backend', 'Options / Subject', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Password recovery email subject', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_payment', 'backend', 'Options / Send payment confirmation email', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Payment confirmation email', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_payment_message', 'backend', 'Options / Payment confirmation message', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Message body', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_payment_message_text', 'backend', 'Options / Payment confirmation message', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', '<u>Available Tokens:</u><br/><br/>{Title}<br/>{FirstName}<br/>{LastName}<br/>{Email}<br/>{Phone}<br/>{Notes}<br/>{Country}<br/>{City}<br/>{State}<br/>{Zip}<br/>{Address}<br/>{Company}<br/>{Date}<br/>{From}<br/>{To}<br/>{Fleet}<br/>{Passengers}<br/>{Luggage}<br/>{UniqueID}<br/>{SubTotal}<br/>{Tax}<br/>{Total}<br/>{Deposit}<br/>{PaymentMethod}<br/>{CCType}<br/>{CCNum}<br/>{CCExp}<br/>{CCSec}<br/>{CancelURL}', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_payment_subject', 'backend', 'Options / Payment confirmation subject', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Subject', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_email_payment_text', 'backend', 'Options / Send payment confirmation email', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Select ''Yes'' if you want a confirmation email to be sent to clients after successful payment is made.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_google_api_key', 'backend', 'Options / Google API key', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Google API key', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_mileage', 'backend', 'Options / Mileage', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Mileage', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_payment_disable', 'backend', 'Options / Payment disable', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Select ''Yes'' if you want to disable payments.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_payment_status', 'backend', 'Options / Payment status', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New enquiry status if paid.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_paypal_address', 'backend', 'Options / Paypal address', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'PayPal business email address ', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_send_email', 'backend', 'opt_o_send_email', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Send email', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_sms_confirmation_message', 'backend', 'Options / Reservation reminder SMS', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'SMS notifications', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_sms_confirmation_message_text', 'backend', 'Options / Reservation reminder SMS', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'You can also send personalized SMS notifications via the each enquiry page. Available Tokens:<br/><br/>{FirstName}<br/>{LastName}<br/>{Date}<br/>{From}<br/>{To}<br/>{Line}<br/>{Passengers}', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_smtp_host', 'backend', 'opt_o_smtp_host', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'SMTP Host', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_smtp_pass', 'backend', 'opt_o_smtp_pass', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'SMTP Password', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_smtp_port', 'backend', 'opt_o_smtp_port', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'SMTP Port', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_smtp_user', 'backend', 'opt_o_smtp_user', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'SMTP Username', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_tax_payment', 'backend', 'Options / Tax payment', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Tax payment', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_terms', 'backend', 'Options / Terms and Conditions', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Terms and conditions', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_thankyou_page', 'backend', 'Options / Thank you page', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'URL for the web page where your clients will be redirected after PayPal or Authorize.net payment ', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_timezone', 'backend', 'Options / Timezone', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Timezone', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_time_format', 'backend', 'Options / Time format', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Time format', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_vehicle_per_page', 'backend', 'Options / Vehicles per page', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Number of vehicles shown per page on the front-end.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'opt_o_week_start', 'backend', 'Options / First day of the week', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'First day of the week', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pass', 'backend', 'Password', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Password', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'payment_methods_ARRAY_bank', 'arrays', 'payment_methods_ARRAY_bank', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Bank account', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'payment_methods_ARRAY_cash', 'arrays', 'payment_methods_ARRAY_cash', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Cash', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'payment_methods_ARRAY_creditcard', 'arrays', 'payment_methods_ARRAY_creditcard', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Credit card', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'payment_methods_ARRAY_paypal', 'arrays', 'payment_methods_ARRAY_paypal', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'PayPal', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'personal_titles_ARRAY_dr', 'arrays', 'personal_titles_ARRAY_dr', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Dr.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'personal_titles_ARRAY_miss', 'arrays', 'personal_titles_ARRAY_miss', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Miss', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'personal_titles_ARRAY_mr', 'arrays', 'personal_titles_ARRAY_mr', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Mr.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'personal_titles_ARRAY_mrs', 'arrays', 'personal_titles_ARRAY_mrs', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Mrs.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'personal_titles_ARRAY_ms', 'arrays', 'personal_titles_ARRAY_ms', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Ms.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'personal_titles_ARRAY_other', 'arrays', 'personal_titles_ARRAY_other', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Other', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'personal_titles_ARRAY_prof', 'arrays', 'personal_titles_ARRAY_prof', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Prof.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'personal_titles_ARRAY_rev', 'arrays', 'personal_titles_ARRAY_rev', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Rev.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pj_email_taken', 'backend', 'Users / Email already taken', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Email address is already taken.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pj_number_validation', 'backend', 'Label / Please enter a valid number.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Please enter a valid number.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'plugin_backup_size', 'backend', 'Plugin / Size', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Size', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'plugin_backup_sizeXXXXXX', 'backend', 'Plugin / Size', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'SizeXXXX', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'plugin_country_revert_status', 'backend', 'Plugin / Revert status', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Revert status', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'revert_status', 'backend', 'Revert status', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Revert status', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'script_name', 'backend', 'Label / Shuttle Booking Software', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Shuttle Booking Software', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'short_days_ARRAY_0', 'arrays', 'short_days_ARRAY_0', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Su', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'short_days_ARRAY_1', 'arrays', 'short_days_ARRAY_1', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Mo', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'short_days_ARRAY_2', 'arrays', 'short_days_ARRAY_2', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Tu', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'short_days_ARRAY_3', 'arrays', 'short_days_ARRAY_3', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'We', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'short_days_ARRAY_4', 'arrays', 'short_days_ARRAY_4', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Th', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'short_days_ARRAY_5', 'arrays', 'short_days_ARRAY_5', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Fr', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'short_days_ARRAY_6', 'arrays', 'short_days_ARRAY_6', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Sa', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'short_months_ARRAY_1', 'arrays', 'short_months_ARRAY_1', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Jan', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'short_months_ARRAY_10', 'arrays', 'short_months_ARRAY_10', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Oct', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'short_months_ARRAY_11', 'arrays', 'short_months_ARRAY_11', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Nov', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'short_months_ARRAY_12', 'arrays', 'short_months_ARRAY_12', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Dec', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'short_months_ARRAY_2', 'arrays', 'short_months_ARRAY_2', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Feb', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'short_months_ARRAY_3', 'arrays', 'short_months_ARRAY_3', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Mar', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'short_months_ARRAY_4', 'arrays', 'short_months_ARRAY_4', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Apr', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'short_months_ARRAY_5', 'arrays', 'short_months_ARRAY_5', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'May', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'short_months_ARRAY_6', 'arrays', 'short_months_ARRAY_6', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Jun', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'short_months_ARRAY_7', 'arrays', 'short_months_ARRAY_7', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Jul', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'short_months_ARRAY_8', 'arrays', 'short_months_ARRAY_8', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Aug', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'short_months_ARRAY_9', 'arrays', 'short_months_ARRAY_9', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Sep', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'status_ARRAY_1', 'arrays', 'status_ARRAY_1', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'You are not loged in.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'status_ARRAY_123', 'arrays', 'status_ARRAY_123', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Your hosting account does not allow uploading such a large image.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'status_ARRAY_2', 'arrays', 'status_ARRAY_2', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Access denied. You have not requisite rights to.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'status_ARRAY_3', 'arrays', 'status_ARRAY_3', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Empty resultset.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'status_ARRAY_7', 'arrays', 'status_ARRAY_7', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'The operation is not allowed in demo mode.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'status_ARRAY_996', 'arrays', 'status_ARRAY_996', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'No property for the enquiry found', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'status_ARRAY_997', 'arrays', 'status_ARRAY_997', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'No enquiry  found', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'status_ARRAY_998', 'arrays', 'status_ARRAY_998', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'No permisions to edit the enquiry.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'status_ARRAY_999', 'arrays', 'status_ARRAY_999', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'No permisions to edit the property', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'status_ARRAY_9997', 'arrays', 'status_ARRAY_9997', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'E-Mail address already exist', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'status_ARRAY_9998', 'arrays', 'status_ARRAY_9998', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Your registration was successfull. Your account needs to be approved.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'status_ARRAY_9999', 'arrays', 'status_ARRAY_9999', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Your registration was successfull.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'tabDetails', 'backend', 'Tab / Details', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Details', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'tabSchedule', 'backend', 'Tab / Schedule', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Schedule', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_-10800', 'arrays', 'timezones_ARRAY_-10800', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT-03:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_-14400', 'arrays', 'timezones_ARRAY_-14400', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT-04:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_-18000', 'arrays', 'timezones_ARRAY_-18000', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT-05:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_-21600', 'arrays', 'timezones_ARRAY_-21600', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT-06:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_-25200', 'arrays', 'timezones_ARRAY_-25200', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT-07:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_-28800', 'arrays', 'timezones_ARRAY_-28800', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT-08:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_-32400', 'arrays', 'timezones_ARRAY_-32400', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT-09:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_-3600', 'arrays', 'timezones_ARRAY_-3600', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT-01:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_-36000', 'arrays', 'timezones_ARRAY_-36000', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT-10:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_-39600', 'arrays', 'timezones_ARRAY_-39600', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT-11:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_-43200', 'arrays', 'timezones_ARRAY_-43200', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT-12:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_-7200', 'arrays', 'timezones_ARRAY_-7200', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT-02:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_0', 'arrays', 'timezones_ARRAY_0', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_10800', 'arrays', 'timezones_ARRAY_10800', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT+03:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_14400', 'arrays', 'timezones_ARRAY_14400', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT+04:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_18000', 'arrays', 'timezones_ARRAY_18000', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT+05:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_21600', 'arrays', 'timezones_ARRAY_21600', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT+06:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_25200', 'arrays', 'timezones_ARRAY_25200', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT+07:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_28800', 'arrays', 'timezones_ARRAY_28800', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT+08:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_32400', 'arrays', 'timezones_ARRAY_32400', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT+09:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_3600', 'arrays', 'timezones_ARRAY_3600', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT+01:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_36000', 'arrays', 'timezones_ARRAY_36000', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT+10:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_39600', 'arrays', 'timezones_ARRAY_39600', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT+11:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_43200', 'arrays', 'timezones_ARRAY_43200', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT+12:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_46800', 'arrays', 'timezones_ARRAY_46800', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT+13:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'timezones_ARRAY_7200', 'arrays', 'timezones_ARRAY_7200', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'GMT+02:00', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'tr_email_invalid', 'backend', 'Label / Email address is invalid.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Email address is invalid.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'tr_field_required', 'backend', 'Label / This field is required.', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'This field is required.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'url', 'backend', 'URL', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'URL', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'user', 'backend', 'Username', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Username', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'u_statarr_ARRAY_F', 'arrays', 'u_statarr_ARRAY_F', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Inactive', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'u_statarr_ARRAY_T', 'arrays', 'u_statarr_ARRAY_T', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Active', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, '_yesno_ARRAY_F', 'arrays', '_yesno_ARRAY_F', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'No', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, '_yesno_ARRAY_T', 'arrays', '_yesno_ARRAY_T', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Yes', 'script');

INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, NULL, 'pjAdmin_pjActionIndex');

INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, NULL, 'pjAdminClients');
SET @level_1_id := (SELECT LAST_INSERT_ID());

  INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_1_id, 'pjAdminClients_pjActionIndex');
  SET @level_2_id := (SELECT LAST_INSERT_ID());

    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminClients_pjActionCreate');
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminClients_pjActionUpdate');
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminClients_pjActionDeleteClient');
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminClients_pjActionDeleteClientBulk');
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminClients_pjActionStatusClient'); 
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminClients_pjActionExportClient');
    
INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, NULL, 'pjAdminLocations');
SET @level_1_id := (SELECT LAST_INSERT_ID());

  INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_1_id, 'pjAdminLocations_pjActionIndex');
  SET @level_2_id := (SELECT LAST_INSERT_ID());

    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminLocations_pjActionCreate');
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminLocations_pjActionUpdate');
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminLocations_pjActionDeleteLocation');
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminLocations_pjActionDeleteLocationBulk'); 
    
INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, NULL, 'pjAdminLines');
SET @level_1_id := (SELECT LAST_INSERT_ID());

  INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_1_id, 'pjAdminLines_pjActionIndex');
  SET @level_2_id := (SELECT LAST_INSERT_ID());

    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminLines_pjActionCreate');
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminLines_pjActionUpdate');
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminLines_pjActionDeleteLine');
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminLines_pjActionDeleteLineBulk');
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminLines_pjActionStatusLine'); 
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminLines_pjActionExportLine');
    
INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, NULL, 'pjAdminTimetable');
SET @level_1_id := (SELECT LAST_INSERT_ID());

  INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_1_id, 'pjAdminTimetable_pjActionIndex');
  SET @level_2_id := (SELECT LAST_INSERT_ID());

    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminTimetable_pjActionCreate');
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminTimetable_pjActionUpdate');
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminTimetable_pjActionDeleteTimetable');
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminTimetable_pjActionSchedule');
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminTimetable_pjActionDeleteTimetableBulk');
    
INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, NULL, 'pjAdminBookings');
SET @level_1_id := (SELECT LAST_INSERT_ID());

  INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_1_id, 'pjAdminBookings_pjActionIndex');
  SET @level_2_id := (SELECT LAST_INSERT_ID());

    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminBookings_pjActionCreate');
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminBookings_pjActionUpdate');
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminBookings_pjActionDeleteBooking');
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminBookings_pjActionDeleteBookingBulk');
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminBookings_pjActionExportBooking');
    INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjAdminBookings_pjActionPrint');
    
INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, NULL, 'pjAdminOptions_pjActionPreview');
INSERT INTO `shuttle_plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, NULL, 'pjAdminOptions_pjActionInstall');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminLocations', 'backend', 'pjAdminLocations', 'script', '2022-05-23 04:09:49');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Locations Menu', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminLocations_pjActionIndex', 'backend', 'pjAdminLocations_pjActionIndex', 'script', '2022-05-23 04:10:13');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Locations List', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminLocations_pjActionCreate', 'backend', 'pjAdminLocations_pjActionCreate', 'script', '2022-05-23 04:10:28');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add Location', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminLocations_pjActionUpdate', 'backend', 'pjAdminLocations_pjActionUpdate', 'script', '2022-05-23 04:10:53');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Update Location', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminLocations_pjActionDeleteLocation', 'backend', 'pjAdminLocations_pjActionDeleteLocation', 'script', '2022-05-23 04:11:10');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete Single Location', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminLocations_pjActionDeleteLocationBulk', 'backend', 'pjAdminLocations_pjActionDeleteLocationBulk', 'script', '2022-05-23 04:11:22');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete Multiple Locations', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'menuEnquiries', 'backend', 'Menu / Enquiries', 'script', '2022-05-23 04:13:08');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiries', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdmin_pjActionIndex', 'backend', 'pjAdmin_pjActionIndex', 'script', '2022-05-23 07:46:36');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Dashboard Menu', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminClients', 'backend', 'pjAdminClients', 'script', '2022-05-23 07:46:54');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Clients Menu', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminClients_pjActionIndex', 'backend', 'pjAdminClients_pjActionIndex', 'script', '2022-05-23 07:47:12');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Clients List', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminClients_pjActionCreate', 'backend', 'pjAdminClients_pjActionCreate', 'script', '2022-05-23 07:47:24');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add client', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminClients_pjActionUpdate', 'backend', 'pjAdminClients_pjActionUpdate', 'script', '2022-05-23 07:47:37');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Update client', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminClients_pjActionDeleteClient', 'backend', 'pjAdminClients_pjActionDeleteClient', 'script', '2022-05-23 07:47:50');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete single client', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminClients_pjActionDeleteClientBulk', 'backend', 'pjAdminClients_pjActionDeleteClientBulk', 'script', '2022-05-23 07:48:05');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete multiple clients', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminClients_pjActionStatusClient', 'backend', 'pjAdminClients_pjActionStatusClient', 'script', '2022-05-23 07:48:40');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Revert clients status', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminClients_pjActionExportClient', 'backend', 'pjAdminClients_pjActionExportClient', 'script', '2022-05-23 07:48:53');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Export clients', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminLines', 'backend', 'pjAdminLines', 'script', '2022-05-23 09:47:58');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Lines Menu', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminLines_pjActionIndex', 'backend', 'pjAdminLines_pjActionIndex', 'script', '2022-05-23 09:48:09');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Lines List', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminLines_pjActionCreate', 'backend', 'pjAdminLines_pjActionCreate', 'script', '2022-05-23 09:48:20');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add line', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminLines_pjActionUpdate', 'backend', 'pjAdminLines_pjActionUpdate', 'script', '2022-05-23 09:48:32');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Update line', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminLines_pjActionDeleteLine', 'backend', 'pjAdminLines_pjActionDeleteLine', 'script', '2022-05-23 09:48:43');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete single line', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminLines_pjActionDeleteLineBulk', 'backend', 'pjAdminLines_pjActionDeleteLineBulk', 'script', '2022-05-23 09:48:56');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete multiple lines', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminLines_pjActionStatusLine', 'backend', 'pjAdminLines_pjActionStatusLine', 'script', '2022-05-23 09:49:21');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Revert lines status', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminLines_pjActionExportLine', 'backend', 'pjAdminLines_pjActionExportLine', 'script', '2022-05-23 09:49:32');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Export lines', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblSelectImage', 'backend', 'Label / Select image', 'script', '2022-05-23 10:26:21');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Select image', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblChangeImage', 'backend', 'Label / Change image', 'script', '2022-05-23 10:26:35');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Change image', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'btn_delete_image', 'backend', 'Button / Delete image', 'script', '2022-05-27 11:00:41');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete image', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminTimetable', 'backend', 'pjAdminTimetable', 'script', '2022-05-30 03:05:51');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Timetable Menu', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminTimetable_pjActionIndex', 'backend', 'pjAdminTimetable_pjActionIndex', 'script', '2022-05-30 03:06:03');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Timetable List', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminTimetable_pjActionCreate', 'backend', 'pjAdminTimetable_pjActionCreate', 'script', '2022-05-30 03:06:17');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add new timetable', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminTimetable_pjActionUpdate', 'backend', 'pjAdminTimetable_pjActionUpdate', 'script', '2022-05-30 03:06:30');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Update timetable', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminTimetable_pjActionDeleteTimetable', 'backend', 'pjAdminTimetable_pjActionDeleteTimetable', 'script', '2022-05-30 03:06:44');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete single timetable', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminTimetable_pjActionSchedule', 'backend', 'pjAdminTimetable_pjActionSchedule', 'script', '2022-05-30 03:06:56');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Schedule', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminTimetable_pjActionDeleteTimetableBulk', 'backend', 'pjAdminTimetable_pjActionDeleteTimetableBulk', 'script', '2022-05-30 03:07:13');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete multiple timetables', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'script_menu_payments', 'backend', 'script_menu_payments', 'script', '2022-05-30 08:45:48');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Payments', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDisablePayments', 'backend', 'lblDisablePayments', 'script', '2022-05-30 12:28:56');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Disable payments', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblDisablePaymentsText', 'backend', 'lblDisablePaymentsText', 'script', '2022-05-30 12:29:09');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'You can disable online payments and only accept bookings.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblThankYouPage', 'backend', 'lblThankYouPage', 'script', '2022-05-30 12:30:00');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Thank you page', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'mileage_enum_ARRAY_miles', 'arrays', 'mileage_enum_ARRAY_miles', 'script', '2022-05-30 12:34:24');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'miles', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'mileage_enum_ARRAY_km', 'arrays', 'mileage_enum_ARRAY_km', 'script', '2022-05-30 12:34:34');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'km', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'script_infobox_notifications_title', 'backend', 'Infobox / Notifications', 'script', '2022-02-14 09:34:21');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Notifications', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'script_infobox_notifications_desc', 'backend', 'Infobox / Notifications', 'script', '2022-02-14 09:34:38');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Email notifications will be sent to people who make a booking after the booking form is completed or/and payment is made. If you leave subject field blank no email will be sent.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_main_title', 'backend', 'notifications_main_title', 'script', '2022-02-14 09:35:07');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Notifications', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_main_subtitle', 'backend', 'notifications_main_subtitle', 'script', '2022-02-14 09:35:49');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Automated messages are sent both to client and administrator(s) on specific events. Select message type to edit it - enable/disable or just change message text. For SMS notifications you need to enable SMS service. ', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_recipient', 'backend', 'notifications_recipient', 'script', '2022-02-14 09:36:08');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Recipient', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'recipients_ARRAY_client', 'arrays', 'recipients_ARRAY_client', 'script', '2022-02-14 09:36:47');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Client', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'recipients_ARRAY_admin', 'arrays', 'recipients_ARRAY_admin', 'script', '2022-02-14 09:37:04');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Administrator', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_tokens_note', 'backend', 'notifications_tokens_note', 'script', '2022-02-14 09:37:38');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Personalize the message by including any of the available tokens and it will be replaced with corresponding data.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_tokens', 'backend', 'notifications_tokens', 'script', '2022-02-14 09:37:59');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Available tokens', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_msg_to_client', 'backend', 'notifications_msg_to_client', 'script', '2022-02-14 09:55:23');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Messages sent to Clients', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_msg_to_default', 'backend', 'notifications_msg_to_default', 'script', '2022-02-14 09:55:36');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Messages sent', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_msg_to_admin', 'backend', 'notifications_msg_to_admin', 'script', '2022-02-14 09:55:50');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Messages sent to Admin', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_status', 'backend', 'notifications_status', 'script', '2022-02-14 09:56:23');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Status', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_send', 'backend', 'notifications_send', 'script', '2022-02-14 09:57:13');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Send', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_do_not_send', 'backend', 'notifications_do_not_send', 'script', '2022-02-14 09:57:27');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Do not send', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_ARRAY_admin_email_cancel', 'arrays', 'notifications_ARRAY_admin_email_cancel', 'script', '2022-02-14 10:32:55');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Send Cancellation email', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_ARRAY_admin_email_confirmation', 'arrays', 'notifications_ARRAY_admin_email_confirmation', 'script', '2022-02-14 10:33:40');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New enquiry received email', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_ARRAY_admin_email_payment', 'arrays', 'notifications_ARRAY_admin_email_payment', 'script', '2022-02-14 10:34:15');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Send payment confirmation email', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_ARRAY_admin_email_account', 'arrays', 'notifications_ARRAY_admin_email_account', 'script', '2022-02-14 10:36:35');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New client account email', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_ARRAY_admin_sms_confirmation', 'arrays', 'notifications_ARRAY_admin_sms_confirmation', 'script', '2022-02-14 10:37:21');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New enquiry received SMS', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_ARRAY_admin_sms_payment', 'arrays', 'notifications_ARRAY_admin_sms_payment', 'script', '2022-02-14 10:37:37');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Payment confirmation SMS', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_ARRAY_client_email_account', 'arrays', 'notifications_ARRAY_client_email_account', 'script', '2022-02-14 10:38:05');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New client account email', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_ARRAY_client_email_cancel', 'arrays', 'notifications_ARRAY_client_email_cancel', 'script', '2022-02-14 10:38:31');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Send cancellation email', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_ARRAY_client_email_confirmation', 'arrays', 'notifications_ARRAY_client_email_confirmation', 'script', '2022-02-14 10:38:54');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New enquiry received email', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_ARRAY_client_email_forgot', 'arrays', 'notifications_ARRAY_client_email_forgot', 'script', '2022-02-14 10:39:13');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Send forgot password email', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_ARRAY_client_email_payment', 'arrays', 'notifications_ARRAY_client_email_payment', 'script', '2022-02-14 10:39:31');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Send payment confirmation email', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_ARRAY_client_sms_confirmation', 'arrays', 'notifications_ARRAY_client_sms_confirmation', 'script', '2022-02-14 10:39:56');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New enquiry received SMS', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_titles_ARRAY_admin_email_cancel', 'arrays', 'notifications_titles_ARRAY_admin_email_cancel', 'script', '2022-02-14 10:41:34');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Send Cancellation email sent to Admin', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_titles_ARRAY_admin_email_confirmation', 'arrays', 'notifications_titles_ARRAY_admin_email_confirmation', 'script', '2022-02-14 10:42:05');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New Enquiry Received email sent to Admin', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_titles_ARRAY_admin_email_payment', 'arrays', 'notifications_titles_ARRAY_admin_email_payment', 'script', '2022-02-14 10:42:24');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Send Payment Confirmation email sent to Admin', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_titles_ARRAY_admin_sms_confirmation', 'arrays', 'notifications_titles_ARRAY_admin_sms_confirmation', 'script', '2022-02-14 10:43:13');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiry Confirmation SMS sent to Admin', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_titles_ARRAY_admin_sms_payment', 'arrays', 'notifications_titles_ARRAY_admin_sms_payment', 'script', '2022-02-14 10:43:30');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Payment Confirmation SMS sent to Admin', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_titles_ARRAY_admin_email_account', 'arrays', 'notifications_titles_ARRAY_admin_email_account', 'script', '2022-02-14 10:45:07');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Send New Client Account email sent to Admin', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_subtitles_ARRAY_admin_email_cancel', 'arrays', 'notifications_subtitles_ARRAY_admin_email_cancel', 'script', '2022-02-14 10:46:35');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'This message is sent to the administrator when a client cancels an enquiry.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_subtitles_ARRAY_admin_email_confirmation', 'arrays', 'notifications_subtitles_ARRAY_admin_email_confirmation', 'script', '2022-02-14 10:47:11');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'This message is sent to the administrator when a new enquiry is made.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_subtitles_ARRAY_admin_email_payment', 'arrays', 'notifications_subtitles_ARRAY_admin_email_payment', 'script', '2022-02-14 10:47:47');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'This message is sent to the administrator when a payment for a new enquiry is made.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_subtitles_ARRAY_admin_sms_confirmation', 'arrays', 'notifications_subtitles_ARRAY_admin_sms_confirmation', 'script', '2022-02-14 10:48:22');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'This SMS is sent to administrator when a new enquiry is made.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_subtitles_ARRAY_admin_sms_payment', 'arrays', 'notifications_subtitles_ARRAY_admin_sms_payment', 'script', '2022-02-14 10:49:12');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'This SMS is sent to administrator when a payment is made for a new enquiry.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_subtitles_ARRAY_admin_email_account', 'arrays', 'notifications_subtitles_ARRAY_admin_email_account', 'script', '2022-02-14 10:49:48');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'This message is sent to the administrator when a new client account created.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_titles_ARRAY_client_email_cancel', 'arrays', 'notifications_titles_ARRAY_client_email_cancel', 'script', '2022-02-14 10:51:01');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiry Cancellation email sent to Client', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_subtitles_ARRAY_client_email_cancel', 'arrays', 'notifications_subtitles_ARRAY_client_email_cancel', 'script', '2022-02-14 10:51:30');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'This message is sent to the client when a client cancels an enquiry.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_titles_ARRAY_client_email_confirmation', 'arrays', 'notifications_titles_ARRAY_client_email_confirmation', 'script', '2022-02-14 10:52:26');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiry Confirmation email sent to Client', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_subtitles_ARRAY_client_email_confirmation', 'arrays', 'notifications_subtitles_ARRAY_client_email_confirmation', 'script', '2022-02-14 10:52:48');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'This message is sent to client when a new enquiry is made.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_titles_ARRAY_client_email_payment', 'arrays', 'notifications_titles_ARRAY_client_email_payment', 'script', '2022-02-14 10:53:24');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Payment Confirmation email sent to Client', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_subtitles_ARRAY_client_email_payment', 'arrays', 'notifications_subtitles_ARRAY_client_email_payment', 'script', '2022-02-14 10:53:44');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'This message is sent to the client when a payment is made for a new enquiry.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_titles_ARRAY_client_email_forgot', 'arrays', 'notifications_titles_ARRAY_client_email_forgot', 'script', '2022-02-14 10:54:07');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Send forgot password email to Client', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_subtitles_ARRAY_client_email_forgot', 'arrays', 'notifications_subtitles_ARRAY_client_email_forgot', 'script', '2022-02-14 10:55:16');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'This message is sent to client when he requests for password recovery.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_titles_ARRAY_client_email_account', 'arrays', 'notifications_titles_ARRAY_client_email_account', 'script', '2022-02-14 10:56:12');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'New client account email sent to Client', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_subtitles_ARRAY_client_email_account', 'arrays', 'notifications_subtitles_ARRAY_client_email_account', 'script', '2022-02-14 10:56:27');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'This message is sent to the client when new account is created.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_titles_ARRAY_client_sms_confirmation', 'arrays', 'notifications_titles_ARRAY_client_sms_confirmation', 'script', '2022-02-14 10:57:16');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiry Confirmation SMS sent to Client', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_subtitles_ARRAY_client_sms_confirmation', 'arrays', 'notifications_subtitles_ARRAY_client_sms_confirmation', 'script', '2022-02-14 10:58:07');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'This SMS is sent to client when a new enquiry is made.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_is_active', 'backend', 'notifications_is_active', 'script', '2022-02-14 10:58:52');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Send this message', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_subject', 'backend', 'notifications_subject', 'script', '2022-02-14 10:59:28');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Subject', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'notifications_message', 'backend', 'notifications_message', 'script', '2022-02-14 10:59:40');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Message', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'script_change_labels', 'backend', 'script_change_labels', 'script', '2022-06-07 09:57:59');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Change Labels', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'script_preview_your_website', 'backend', 'script_preview_your_website', 'script', '2022-06-07 09:58:37');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Open in new window', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'script_install_your_website', 'backend', 'script_install_your_website', 'script', '2022-06-07 09:59:02');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Install your website', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoInstallTitle', 'backend', 'infoInstallTitle', 'script', '2022-06-07 10:00:08');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Integration Code', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'infoInstallDesc', 'backend', 'infoInstallDesc', 'script', '2022-06-07 10:00:21');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Follow the instructions below to install the script on your website.', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminOptions_pjActionPreview', 'backend', 'pjAdminOptions_pjActionPreview', 'script', '2022-06-07 10:14:30');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Preview Menu', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminOptions_pjActionInstall', 'backend', 'pjAdminOptions_pjActionInstall', 'script', '2022-06-07 10:14:42');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Install Menu', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminBookings', 'backend', 'pjAdminBookings', 'script', '2022-06-07 10:15:03');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiries Menu', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminBookings_pjActionIndex', 'backend', 'pjAdminBookings_pjActionIndex', 'script', '2022-06-07 10:15:59');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enquiries List', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminBookings_pjActionCreate', 'backend', 'pjAdminBookings_pjActionCreate', 'script', '2022-06-07 10:16:16');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add Enquiry\r\n', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminBookings_pjActionUpdate', 'backend', 'pjAdminBookings_pjActionUpdate', 'script', '2022-06-07 10:16:30');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Edit Enquiry', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminBookings_pjActionDeleteBooking', 'backend', 'pjAdminBookings_pjActionDeleteBooking', 'script', '2022-06-07 10:16:48');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete single enquiry', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminBookings_pjActionDeleteBookingBulk', 'backend', 'pjAdminBookings_pjActionDeleteBookingBulk', 'script', '2022-06-07 10:17:06');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete multiple enquiries', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminBookings_pjActionExportBooking', 'backend', 'pjAdminBookings_pjActionExportBooking', 'script', '2022-06-07 10:17:23');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Export Enquiries', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'pjAdminBookings_pjActionPrint', 'backend', 'pjAdminBookings_pjActionPrint', 'script', '2022-06-07 10:17:35');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Print', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'advance_search', 'backend', 'advance_search', 'script', '2022-06-08 11:43:56');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Advance Search', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'script_online_payment_gateway', 'backend', 'script_online_payment_gateway', 'script', '2022-06-10 09:01:52');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Online payments', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'script_offline_payment', 'backend', 'script_offline_payment', 'script', '2022-06-10 09:02:40');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Offline payments', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'booking_confirmation_title', 'backend', 'booking_confirmation_title', 'script', '2022-06-13 08:35:35');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Send Confirmation Email', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'front_bank_account', 'frontend', 'front_bank_account', 'script', '2022-06-13 12:33:20');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Bank acount', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'dash_today', 'backend', 'dash_today', 'script', '2022-06-14 08:15:22');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Today', 'script');

INSERT INTO `shuttle_plugin_base_fields` VALUES (NULL, 'lblEmailNotificationNotSet', 'backend', 'lblEmailNotificationNotSet', 'script', '2022-06-16 09:30:55');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `shuttle_plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'The notifiation content have not set yet.', 'script');