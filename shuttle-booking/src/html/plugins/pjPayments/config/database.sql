
DROP TABLE IF EXISTS `plugin_payment_options`;
CREATE TABLE IF NOT EXISTS `plugin_payment_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `foreign_id` int(10) unsigned DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `merchant_id` VARCHAR (255) DEFAULT NULL,
  `merchant_email` VARCHAR (255) DEFAULT NULL,
  `public_key` VARCHAR (255) DEFAULT NULL,
  `private_key` VARCHAR (255) DEFAULT NULL,
  `tz` int(10) DEFAULT NULL,
  `success_url` VARCHAR (255) DEFAULT NULL,
  `failure_url` VARCHAR (255) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `is_active` BOOLEAN DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `foreign_id` (`foreign_id`,`payment_method`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'tabPaymentOptions', 'backend', 'Label / Payment Options', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Payment Options', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'infoPaymentOptionsTitle', 'backend', 'Infobox / Payment Options Title', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Payment Options', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'infoPaymentOptionsBody', 'backend', 'Infobox / Payment Options Body', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Edit the options for the supported payment gateways and then click Save.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'allow_payment_method_ARRAY_1', 'arrays', 'allow_payment_method_ARRAY_1', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Yes', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'allow_payment_method_ARRAY_0', 'arrays', 'allow_payment_method_ARRAY_0', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'No', 'plugin');