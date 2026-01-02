
START TRANSACTION;

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_error_titles_ARRAY_PBU07', 'arrays', 'plugin_base_error_titles_ARRAY_PBU07', 'plugin', '2019-08-14 09:43:34');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Backup failed!', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_error_bodies_ARRAY_PBU07', 'arrays', 'plugin_base_error_bodies_ARRAY_PBU07', 'plugin', '2019-08-14 09:45:09');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'The database content could not be added into the backup file. Please try again.', 'plugin');

COMMIT;