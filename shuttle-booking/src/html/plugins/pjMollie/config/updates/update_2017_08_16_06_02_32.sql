
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_payment_label', 'backend', 'Plugin Mollie / Label', 'plugin', '2017-08-16 05:56:03');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Label', 'plugin');

COMMIT;