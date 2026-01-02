
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'plugin_payments_add_payment_gateways', 'backend', 'Plugin Payments / Add other Payment Gateways', 'plugin', '2017-08-09 01:59:17');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Add other Payment Gateways', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'plugin_payments_active_payment_gateways', 'backend', 'Plugin Payments / Active Payment Gateways', 'plugin', '2017-08-09 01:59:43');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Active Payment Gateways', 'plugin');

COMMIT;