
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'plugin_world_pay_payment_label', 'backend', 'Plugin WorldPay / Label', 'plugin', '2017-08-16 05:59:41');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Label', 'plugin');

COMMIT;