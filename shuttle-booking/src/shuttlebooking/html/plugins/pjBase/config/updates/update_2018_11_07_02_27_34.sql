
START TRANSACTION;

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_send_test_swal_success_title', 'backend', 'Success!', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Success!', 'script');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_send_test_swal_smg_title', 'backend', 'Email sent!', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Email sent!', 'script');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_send_test_swal_error_title', 'backend', 'Error!', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Error!', 'script');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_email_text_ARRAY_1', 'arrays', 'plugin_base_email_text_ARRAY_1', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Missing headers.', 'script');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_email_text_ARRAY_2', 'arrays', 'plugin_base_email_text_ARRAY_2', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Invalid request.', 'script');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_email_text_ARRAY_3', 'arrays', 'plugin_base_email_text_ARRAY_3', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Missing, empty or invalid parameters.', 'script');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_email_text_ARRAY_4', 'arrays', 'plugin_base_email_text_ARRAY_4', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Connection has been established successfully.', 'script');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_email_text_ARRAY_5', 'arrays', 'plugin_base_email_text_ARRAY_5', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Connection fails.', 'script');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_email_text_ARRAY_6', 'arrays', 'plugin_base_email_text_ARRAY_6', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Email address is missing.', 'script');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_email_text_ARRAY_7', 'arrays', 'plugin_base_email_text_ARRAY_7', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Email address is not valid.', 'script');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_email_text_ARRAY_8', 'arrays', 'plugin_base_email_text_ARRAY_8', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Email failed to sent.', 'script');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_email_text_ARRAY_9', 'arrays', 'plugin_base_email_text_ARRAY_9', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Test email has been sent to', 'script');

COMMIT;