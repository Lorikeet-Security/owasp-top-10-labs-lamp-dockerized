
START TRANSACTION;

INSERT IGNORE INTO `plugin_payment_options` (`foreign_id`, `payment_method`, `is_active`) VALUES (1, 'cash', 1);
INSERT IGNORE INTO `plugin_payment_options` (`foreign_id`, `payment_method`) VALUES (1, 'bank');

INSERT INTO `fields` VALUES (NULL, 'plugin_payments_info_payment_title', 'backend', 'plugin_payments_info_payment_title', 'plugin', '2020-09-01 14:50:57');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Payment Options', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'plugin_payments_info_payment_desc', 'backend', 'plugin_payments_info_payment_desc', 'plugin', '2020-09-01 14:51:16');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Here you can choose your payment methods and set payment gateway accounts and payment preferences. Note that for cash payments the system will not be able to collect deposit amount online.', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'plugin_payments_required_field', 'backend', 'plugin_payments_required_field', 'plugin', '2020-09-01 14:52:23');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'This field is required.', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'plugin_payment_allow_cash', 'backend', 'plugin_payment_allow_cash', 'plugin', '2020-09-01 15:54:28');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Allow cash payments', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'plugin_payment_allow_bank', 'backend', 'plugin_payment_allow_bank', 'plugin', '2020-09-01 15:59:56');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Provide Bank account details for wire transfers', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'plugin_payments_bank_account', 'backend', 'plugin_payments_bank_account', 'plugin', '2020-09-01 16:03:06');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Bank account', 'plugin');

COMMIT;