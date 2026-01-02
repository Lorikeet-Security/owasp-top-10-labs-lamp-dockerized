
START TRANSACTION;

ALTER TABLE `plugin_payment_options` ADD `is_test_mode` TINYINT(1) UNSIGNED NULL DEFAULT '0' AFTER `is_active`;
ALTER TABLE `plugin_payment_options` ADD `test_merchant_id` VARCHAR(255) NULL AFTER `is_test_mode`;
ALTER TABLE `plugin_payment_options` ADD `test_merchant_email` VARCHAR(255) NULL AFTER `test_merchant_id`;
ALTER TABLE `plugin_payment_options` ADD `test_public_key` VARCHAR(255) NULL AFTER `test_merchant_email`;
ALTER TABLE `plugin_payment_options` ADD `test_private_key` VARCHAR(255) NULL AFTER `test_public_key`;
ALTER TABLE `plugin_payment_options` ADD `test_tz` VARCHAR(255) NULL AFTER `test_private_key`;

COMMIT;