
START TRANSACTION;

INSERT INTO `plugin_payment_options` (`payment_method`) VALUES ('2checkout');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'payment_methods_ARRAY_2checkout', 'arrays', 'payment_methods_ARRAY_2checkout', 'script');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', '2checkout', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_2checkout_payment_title', 'frontend', '2checkout plugin / Payment title', 'script');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', '2checkout payment', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_2checkout_allow', 'backend', '2checkout plugin / Allow 2checkout Payments', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Allow 2checkout payments', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_2checkout_merchant_id', 'backend', '2checkout plugin / Merchant ID', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', '2checkout merchant ID:', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_2checkout_merchant_id_text', 'backend', '2checkout plugin / Merchant ID Text', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'This is your 2checkout account number.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_2checkout_private_key', 'backend', '2checkout plugin / 2checkout Secret Word', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', '2checkout secret word:', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_2checkout_private_key_text', 'backend', '2checkout plugin / 2checkout MD5 Hash Text', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'This is your 2checkout secret word.', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'payment_plugin_messages_ARRAY_2checkout', 'arrays', 'payment_plugin_messages_ARRAY_2checkout', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Your order is saved. Redirecting to 2checkout payment gateway...', 'script');

COMMIT;