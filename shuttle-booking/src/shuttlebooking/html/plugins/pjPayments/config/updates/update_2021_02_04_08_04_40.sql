
START TRANSACTION;

ALTER TABLE `plugin_payment_options` ADD COLUMN `type` enum('online', 'offline') DEFAULT 'online';

INSERT IGNORE INTO `plugin_payment_options` (`foreign_id`, `payment_method`, `is_active`, `type`) VALUES (1, 'cash', 1, 'offline');
INSERT IGNORE INTO `plugin_payment_options` (`foreign_id`, `payment_method`, `type`) VALUES (1, 'bank', 'offline');

COMMIT;