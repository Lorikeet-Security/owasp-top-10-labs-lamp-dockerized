
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'plugin_skrill_payment_label', 'backend', 'Plugin Skrill / Label', 'plugin', '2017-08-16 05:58:23');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Label', 'plugin');

COMMIT;