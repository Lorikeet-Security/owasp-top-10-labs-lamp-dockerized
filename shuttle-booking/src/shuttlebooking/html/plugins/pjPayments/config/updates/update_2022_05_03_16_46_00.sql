
START TRANSACTION;

ALTER TABLE `plugin_payment_options` ADD `is_hold_on` TINYINT(1) UNSIGNED NULL DEFAULT '0' AFTER `is_active`;

COMMIT;