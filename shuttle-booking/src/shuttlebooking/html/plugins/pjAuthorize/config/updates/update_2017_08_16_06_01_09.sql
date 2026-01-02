
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'plugin_authorize_payment_label', 'backend', 'Plugin Authorize / Label', 'plugin', '2017-08-16 05:54:25');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Label', 'plugin');

COMMIT;