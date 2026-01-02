
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'plugin_paypal_express_payment_label', 'backend', 'Plugin PaypalExpress / Label', 'plugin', '2017-08-16 05:57:32');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Label', 'plugin');

COMMIT;