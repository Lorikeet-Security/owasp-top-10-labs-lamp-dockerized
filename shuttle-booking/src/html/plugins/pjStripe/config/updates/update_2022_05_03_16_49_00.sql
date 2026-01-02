
START TRANSACTION;

SET @label := 'Stripe plugin / Enable authorization';

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES (NULL, 'plugin_stripe_is_hold_on', 'backend', @label, 'plugin', NULL)
ON DUPLICATE KEY UPDATE `fields`.`type` = 'backend', `label` = @label, `source` = 'plugin', `modified` = NULL;

SET @content := 'Enable authorization';

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`)
SELECT NULL, `id`, 'pjField', '::LOCALE::', 'title', @content, 'plugin'
FROM `fields` WHERE `key` = 'plugin_stripe_is_hold_on'
ON DUPLICATE KEY UPDATE `multi_lang`.`content` = @content, `source` = 'plugin';

COMMIT;