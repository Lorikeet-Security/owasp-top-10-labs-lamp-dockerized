
START TRANSACTION;

ALTER TABLE `plugin_auth_users` DROP INDEX `email`;
ALTER TABLE `plugin_auth_users` ADD UNIQUE INDEX (`role_id`, `email`);

COMMIT;