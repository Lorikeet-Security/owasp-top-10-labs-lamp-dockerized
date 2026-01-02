
START TRANSACTION;

INSERT IGNORE INTO `plugin_base_options` (`foreign_id`, `key`, `tab_id`, `value`, `label`, `type`, `order`, `is_visible`, `style`) VALUES
(1, 'o_smtp_sender', 3, NULL, NULL, 'string', 8, 1, NULL);

UPDATE `plugin_base_options` SET `order` = 9 WHERE `key` = 'o_sender_email';

UPDATE `plugin_base_options` SET `order` = 10 WHERE `key` = 'o_sender_name';

SET @label := 'plugin_base_opt_o_smtp_sender';

INSERT INTO `plugin_base_fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_base_opt_o_smtp_sender', 'backend', @label, 'plugin', NULL)
ON DUPLICATE KEY UPDATE `plugin_base_fields`.`type` = 'backend', `label` = @label, `source` = 'plugin', `modified` = NULL;

SET @content := 'SMTP Sender';

INSERT INTO `plugin_base_multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`)
SELECT NULL, `id`, 'pjBaseField', '::LOCALE::', 'title', @content, 'plugin'
FROM `plugin_base_fields` WHERE `key` = 'plugin_base_opt_o_smtp_sender'
ON DUPLICATE KEY UPDATE `plugin_base_multi_lang`.`content` = @content, `source` = 'plugin';

COMMIT;