
START TRANSACTION;

INSERT INTO `plugin_base_options` (`foreign_id`, `key`, `tab_id`, `value`, `label`, `type`, `order`, `is_visible`, `style`) VALUES
(1, 'plugin_sms_country_code', 99, NULL, NULL, 'string', NULL, 0, 'string'),
(1, 'plugin_sms_phone_number_length', 99, NULL, NULL, 'string', NULL, 0, 'string');

COMMIT;