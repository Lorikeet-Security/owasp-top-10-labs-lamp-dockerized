
START TRANSACTION;

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_api_key_text_ARRAY_100', 'arrays', 'plugin_base_api_key_text_ARRAY_100', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'HTTP method is not allowed.', 'script');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_api_key_text_ARRAY_101', 'arrays', 'plugin_base_api_key_text_ARRAY_101', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Option cannot be found.', 'script');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_api_key_text_ARRAY_102', 'arrays', 'plugin_base_api_key_text_ARRAY_102', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'API key is empty.', 'script');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_api_key_text_ARRAY_103', 'arrays', 'plugin_base_api_key_text_ARRAY_103', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Key is not correct!', 'script');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_api_key_text_ARRAY_200', 'arrays', 'plugin_base_api_key_text_ARRAY_200', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Key is correct!', 'script');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_sms_key_text_ARRAY_100', 'arrays', 'plugin_base_sms_key_text_ARRAY_100', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'HTTP method is not allowed.', 'script');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_sms_key_text_ARRAY_101', 'arrays', 'plugin_base_sms_key_text_ARRAY_101', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'API key is empty.', 'script');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_sms_key_text_ARRAY_4', 'arrays', 'plugin_base_sms_key_text_ARRAY_4', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Incorrect API key.', 'script');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_validate_select_file', 'backend', 'plugin_base_validate_select_file', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Please select file to import.', 'script');

COMMIT;