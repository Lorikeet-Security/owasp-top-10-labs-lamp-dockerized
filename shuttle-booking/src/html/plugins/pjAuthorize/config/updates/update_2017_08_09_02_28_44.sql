
START TRANSACTION;

INSERT INTO `plugin_payment_options` (`payment_method`) VALUES ('authorize');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_authorize_payment_title', 'frontend', 'Authorize.NET plugin / Payment title', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Authorize.NET payment', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_authorize_allow', 'backend', 'Authorize.NET plugin / Allow Authorize Payments', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Allow Authorize.net payments', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_authorize_merchant_id', 'backend', 'Authorize.NET plugin / Merchant ID', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Authorize.Net merchant ID:', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_authorize_merchant_id_text', 'backend', 'Authorize.NET plugin / Merchant ID Text', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'This is your Authorize.Net merchant ID.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_authorize_public_key', 'backend', 'Authorize.NET plugin / Trans Key', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Authorize.Net transaction key:', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_authorize_public_key_text', 'backend', 'Authorize.NET plugin / Trans Key Text', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'This is your Authorize.Net transaction key.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_authorize_tz', 'backend', 'Authorize.NET plugin / Time Zone', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Authorize.Net time zone:', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_authorize_tz_text', 'backend', 'Authorize.NET plugin / Time Zone Text', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Enter the time zone that your Authorize.Net account uses.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_authorize_private_key', 'backend', 'Authorize.NET plugin / Authorize MD5 Hash', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Authorize.Net MD5 Hash value:', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_authorize_private_key_text', 'backend', 'Authorize.NET plugin / Authorize MD5 Hash Text', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'This is your Authorize.Net MD5 hash value.', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'payment_plugin_messages_ARRAY_authorize', 'arrays', 'payment_plugin_messages_ARRAY_authorize', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Your order is saved. Redirecting to Authorize.Net...', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES (NULL, 'payment_methods_ARRAY_authorize', 'arrays', 'payment_methods_ARRAY_authorize', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Authorize.NET', 'plugin');

COMMIT;