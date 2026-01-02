
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'plugin_skrill_yesno_ARRAY_T', 'backend', 'plugin_skrill_yesno_ARRAY_T', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Yes', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'plugin_skrill_yesno_ARRAY_F', 'backend', 'plugin_skrill_yesno_ARRAY_F', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'No', 'plugin');

COMMIT;