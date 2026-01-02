
START TRANSACTION;

ALTER TABLE `plugin_auth_users` ADD COLUMN `current_login` datetime DEFAULT NULL AFTER `last_login`;

COMMIT;