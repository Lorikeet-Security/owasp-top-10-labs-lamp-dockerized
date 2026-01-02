
START TRANSACTION;

UPDATE `plugin_base_options` SET `is_visible`='0' WHERE `key`='o_smtp_sender';

INSERT IGNORE INTO `plugin_base_options` (`foreign_id`, `key`, `tab_id`, `value`, `label`, `type`, `order`, `is_visible`, `style`) VALUES
(1, 'o_smtp_seder_email_same_as_username', 3, 'Yes|No::Yes', 'Yes|No', 'enum', 9, 1, NULL);

UPDATE `plugin_base_options` SET `order` = 10 WHERE `key` = 'o_sender_email';

UPDATE `plugin_base_options` SET `order` = 11 WHERE `key` = 'o_sender_name';


SET @label := 'plugin_base_opt_o_smtp_seder_email_same_as_username';

INSERT INTO `plugin_base_fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_base_opt_o_smtp_seder_email_same_as_username', 'backend', @label, 'plugin', NULL)
ON DUPLICATE KEY UPDATE `plugin_base_fields`.`type` = 'backend', `label` = @label, `source` = 'plugin', `modified` = NULL;

SET @content := 'Same as SMTP Username';

INSERT INTO `plugin_base_multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`)
SELECT NULL, `id`, 'pjBaseField', '::LOCALE::', 'title', @content, 'plugin'
FROM `plugin_base_fields` WHERE `key` = 'plugin_base_opt_o_smtp_seder_email_same_as_username'
ON DUPLICATE KEY UPDATE `plugin_base_multi_lang`.`content` = @content, `source` = 'plugin';


INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_check_smtp_connection_title', 'backend', 'Plugin Base / Label / Check SMTP settings title', 'plugin', '2020-08-14 09:04:25');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Check SMTP settings', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_check_smtp_connection_text', 'backend', 'Plugin Base / Label / Check SMTP settings text', 'plugin', '2020-08-14 09:04:25');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Please wait while checking your SMTP settings...', 'plugin');


COMMIT;