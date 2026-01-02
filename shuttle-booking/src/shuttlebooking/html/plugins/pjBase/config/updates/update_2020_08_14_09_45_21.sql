
START TRANSACTION;

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_sms_country_code', 'backend', 'Plugin Base / Label / Default Country Code', 'plugin', '2020-08-14 09:04:25');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Default Country Code', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_sms_phone_number_length', 'backend', 'Plugin Base / Label / Phone number length', 'plugin', '2020-08-14 09:18:33');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Phone Number Length', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_digits_validation', 'backend', 'Plugin Base / Please enter only digits.', 'plugin', '2020-08-14 09:23:58');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Please enter only digits.', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_sms_phone_number_length_note', 'backend', 'Plugin Base / Label / Phone number length note', 'plugin', '2020-08-14 09:26:24');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'If the given phone number length is less than this number of digits, the default country code will be added to the phone number.', 'plugin');

COMMIT;