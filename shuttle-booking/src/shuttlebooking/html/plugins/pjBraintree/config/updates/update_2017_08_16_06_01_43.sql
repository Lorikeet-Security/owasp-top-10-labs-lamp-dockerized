
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_payment_label', 'backend', 'Plugin Braintree / Label', 'plugin', '2017-08-16 05:55:22');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Label', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_plugin_unavailable_title', 'backend', 'Plugin Braintree / Plugin unavailable', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Sorry!', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_plugin_unavailable_text', 'backend', 'Plugin Braintree / Plugin unavailable', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'The system does not support minimum software requirements.', 'plugin');

COMMIT;