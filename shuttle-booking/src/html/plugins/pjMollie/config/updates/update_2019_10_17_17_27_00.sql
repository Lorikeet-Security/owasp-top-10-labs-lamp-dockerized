
START TRANSACTION;

SET @label := 'plugin_mollie_test_mode';

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES (NULL, 'plugin_mollie_test_mode', 'backend', @label, 'plugin', NULL)
ON DUPLICATE KEY UPDATE `fields`.`type` = 'backend', `label` = @label, `source` = 'plugin', `modified` = NULL;

SET @content := 'Test mode';

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`)
SELECT NULL, `id`, 'pjField', '::LOCALE::', 'title', @content, 'plugin'
FROM `fields` WHERE `key` = 'plugin_mollie_test_mode'
ON DUPLICATE KEY UPDATE `multi_lang`.`content` = @content, `source` = 'plugin';

SET @label := 'plugin_mollie_onoff';

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES (NULL, 'plugin_mollie_onoff_ARRAY_1', 'arrays', @label, 'plugin', NULL)
ON DUPLICATE KEY UPDATE `fields`.`type` = 'arrays', `label` = @label, `source` = 'plugin', `modified` = NULL;

SET @content := 'On';

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`)
SELECT NULL, `id`, 'pjField', '::LOCALE::', 'title', @content, 'plugin'
FROM `fields` WHERE `key` = 'plugin_mollie_onoff_ARRAY_1'
ON DUPLICATE KEY UPDATE `multi_lang`.`content` = @content, `source` = 'plugin';

SET @label := 'plugin_mollie_onoff';

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES (NULL, 'plugin_mollie_onoff_ARRAY_0', 'arrays', @label, 'plugin', NULL)
ON DUPLICATE KEY UPDATE `fields`.`type` = 'arrays', `label` = @label, `source` = 'plugin', `modified` = NULL;

SET @content := 'Off';

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`)
SELECT NULL, `id`, 'pjField', '::LOCALE::', 'title', @content, 'plugin'
FROM `fields` WHERE `key` = 'plugin_mollie_onoff_ARRAY_0'
ON DUPLICATE KEY UPDATE `multi_lang`.`content` = @content, `source` = 'plugin';

COMMIT;