
START TRANSACTION;

SET @label := 'Braintree plugin / First Name';

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES (NULL, 'plugin_braintree_first_name', 'backend', @label, 'plugin', NULL)
ON DUPLICATE KEY UPDATE `fields`.`type` = 'backend', `label` = @label, `source` = 'plugin', `modified` = NULL;

SET @content := 'First Name';

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`)
SELECT NULL, `id`, 'pjCmsField', '::LOCALE::', 'title', @content, 'plugin'
FROM `fields` WHERE `key` = 'plugin_braintree_first_name'
ON DUPLICATE KEY UPDATE `multi_lang`.`content` = @content, `source` = 'plugin';

SET @label := 'Braintree plugin / Last Name';

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES (NULL, 'plugin_braintree_last_name', 'backend', @label, 'plugin', NULL)
ON DUPLICATE KEY UPDATE `fields`.`type` = 'backend', `label` = @label, `source` = 'plugin', `modified` = NULL;

SET @content := 'Last Name';

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`)
SELECT NULL, `id`, 'pjCmsField', '::LOCALE::', 'title', @content, 'plugin'
FROM `fields` WHERE `key` = 'plugin_braintree_last_name'
ON DUPLICATE KEY UPDATE `multi_lang`.`content` = @content, `source` = 'plugin';

COMMIT;