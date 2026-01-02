
START TRANSACTION;

SET @label := 'plugin_mollie_currency_note';

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES (NULL, 'plugin_mollie_currency_note', 'backend', @label, 'plugin', NULL)
ON DUPLICATE KEY UPDATE `fields`.`type` = 'backend', `label` = @label, `source` = 'plugin', `modified` = NULL;

SET @content := 'Please make sure you have set supported currency under your installation''s settings';

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`)
SELECT NULL, `id`, 'pjField', '::LOCALE::', 'title', @content, 'plugin'
FROM `fields` WHERE `key` = 'plugin_mollie_currency_note'
ON DUPLICATE KEY UPDATE `multi_lang`.`content` = @content, `source` = 'plugin';

COMMIT;