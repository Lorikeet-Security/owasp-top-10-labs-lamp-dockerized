
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'plugin_paypal_express_plugin_unavailable_title', 'backend', 'Plugin PaypalExpress / Plugin unavailable', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Sorry!', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'plugin_paypal_express_plugin_unavailable_text', 'backend', 'Plugin PaypalExpress / Plugin unavailable', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'The system does not support minimum software requirements.', 'plugin');

COMMIT;