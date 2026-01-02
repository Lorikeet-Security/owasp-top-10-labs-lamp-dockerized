
START TRANSACTION;

SET @label := 'plugin_base_sms_test_invalid_method';

INSERT INTO `plugin_base_fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_base_sms_test_invalid_method', 'backend', @label, 'plugin', NULL)
ON DUPLICATE KEY UPDATE `plugin_base_fields`.`type` = 'backend', `label` = @label, `source` = 'plugin', `modified` = NULL;

SET @content := 'HTTP method not allowed.';

INSERT INTO `plugin_base_multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`)
SELECT NULL, `id`, 'pjBaseField', '::LOCALE::', 'title', @content, 'plugin'
FROM `plugin_base_fields` WHERE `key` = 'plugin_base_sms_test_invalid_method'
ON DUPLICATE KEY UPDATE `plugin_base_multi_lang`.`content` = @content, `source` = 'plugin';

SET @label := 'plugin_base_sms_test_empty_api_key';

INSERT INTO `plugin_base_fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_base_sms_test_empty_api_key', 'backend', @label, 'plugin', NULL)
ON DUPLICATE KEY UPDATE `plugin_base_fields`.`type` = 'backend', `label` = @label, `source` = 'plugin', `modified` = NULL;

SET @content := 'API key is empty.';

INSERT INTO `plugin_base_multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`)
SELECT NULL, `id`, 'pjBaseField', '::LOCALE::', 'title', @content, 'plugin'
FROM `plugin_base_fields` WHERE `key` = 'plugin_base_sms_test_empty_api_key'
ON DUPLICATE KEY UPDATE `plugin_base_multi_lang`.`content` = @content, `source` = 'plugin';

SET @label := 'plugin_base_sms_test_empty_number';

INSERT INTO `plugin_base_fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_base_sms_test_empty_number', 'backend', @label, 'plugin', NULL)
ON DUPLICATE KEY UPDATE `plugin_base_fields`.`type` = 'backend', `label` = @label, `source` = 'plugin', `modified` = NULL;

SET @content := 'Number is empty.';

INSERT INTO `plugin_base_multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`)
SELECT NULL, `id`, 'pjBaseField', '::LOCALE::', 'title', @content, 'plugin'
FROM `plugin_base_fields` WHERE `key` = 'plugin_base_sms_test_empty_number'
ON DUPLICATE KEY UPDATE `plugin_base_multi_lang`.`content` = @content, `source` = 'plugin';

COMMIT;