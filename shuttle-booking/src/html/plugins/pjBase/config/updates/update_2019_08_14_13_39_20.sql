
START TRANSACTION;

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_error_titles_ARRAY_PBU08', 'arrays', 'plugin_base_error_titles_ARRAY_PBU08', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Backup failed!', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_error_bodies_ARRAY_PBU08', 'arrays', 'plugin_base_error_bodies_ARRAY_PBU08', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'The files could not be backed up correctly. Please try again!', 'plugin');

COMMIT;