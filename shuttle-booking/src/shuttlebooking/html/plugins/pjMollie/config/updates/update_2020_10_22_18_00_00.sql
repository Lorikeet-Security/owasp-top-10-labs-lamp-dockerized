
START TRANSACTION;

ALTER TABLE `plugin_mollie` ADD `interval` varchar(255) default NULL AFTER `bank_id`;
ALTER TABLE `plugin_mollie` ADD `customer_id` varchar(255) default NULL AFTER `interval`;
ALTER TABLE `plugin_mollie` ADD `type` enum('regular','subscription') DEFAULT 'regular' AFTER `customer_id`;

COMMIT;