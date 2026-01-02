
START TRANSACTION;

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_backup_types_ARRAY_database', 'arrays', 'plugin_backup_types_ARRAY_database', 'script', '2022-07-22 11:00:45');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'database', 'script');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_backup_types_ARRAY_files', 'arrays', 'plugin_backup_types_ARRAY_files', 'script', '2022-07-22 11:01:17');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'files', 'script');

COMMIT;