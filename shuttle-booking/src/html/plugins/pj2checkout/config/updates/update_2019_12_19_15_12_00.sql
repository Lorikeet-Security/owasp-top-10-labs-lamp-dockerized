
START TRANSACTION;

SET @label := '2checkout plugin / Direct Return';

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES (NULL, 'plugin_2checkout_direct_return', 'backend', @label, 'plugin', NULL)
ON DUPLICATE KEY UPDATE `fields`.`type` = 'backend', `label` = @label, `source` = 'plugin', `modified` = NULL;

SET @content := 'Please set "Direct Return" to "Header Redirect" in your 2checkout account.';

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`)
SELECT NULL, `id`, 'pjField', '::LOCALE::', 'title', @content, 'plugin'
FROM `fields` WHERE `key` = 'plugin_2checkout_direct_return'
ON DUPLICATE KEY UPDATE `multi_lang`.`content` = @content, `source` = 'plugin';

SET @label := '2checkout plugin / Approved URL';

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES (NULL, 'plugin_2checkout_approved_url', 'backend', @label, 'plugin', NULL)
ON DUPLICATE KEY UPDATE `fields`.`type` = 'backend', `label` = @label, `source` = 'plugin', `modified` = NULL;

SET @content := 'Approved URL';

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`)
SELECT NULL, `id`, 'pjField', '::LOCALE::', 'title', @content, 'plugin'
FROM `fields` WHERE `key` = 'plugin_2checkout_approved_url'
ON DUPLICATE KEY UPDATE `multi_lang`.`content` = @content, `source` = 'plugin';

COMMIT;