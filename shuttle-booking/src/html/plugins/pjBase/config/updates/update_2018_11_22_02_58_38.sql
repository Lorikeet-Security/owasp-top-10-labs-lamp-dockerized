
START TRANSACTION;

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_ajax_error', 'backend', 'Plugin Base / Label / Ajax request error', 'plugin', '2018-11-22 01:49:22');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'An unexpected error occurred.', 'plugin');

COMMIT;