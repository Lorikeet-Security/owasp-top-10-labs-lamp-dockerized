
START TRANSACTION;

INSERT INTO `plugin_payment_options` (`payment_method`) VALUES ('world_pay');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'payment_methods_ARRAY_world_pay', 'arrays', 'payment_methods_ARRAY_world_pay', 'script');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'WorldPay', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_world_pay_payment_title', 'frontend', 'WorldPay plugin / Payment title', 'script');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'WorldPay payment', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_world_pay_allow', 'backend', 'WorldPay plugin / Allow WorldPay Payments', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Allow WorldPay payments', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_world_pay_merchant_id', 'backend', 'WorldPay plugin / Installation ID', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'WorldPay installation ID:', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_world_pay_merchant_id_text', 'backend', 'WorldPay plugin / Installation ID Text', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'This is your WorldPay installation ID.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_world_pay_private_key', 'backend', 'WorldPay plugin / Payment Response Password', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'WorldPay payment response password:', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_world_pay_private_key_text', 'backend', 'WorldPay plugin / Payment Response Password Text', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'This is the payment response password from your WorldPay account.<br/>1. Log in to the Merchant Interface.<br/>2. Select ''Installations'' from the left hand navigation.<br/>3. Choose an installation and select the ''Integration Setup'' button for either the TEST or PRODUCTION environment.<br/>4. Enter a password into the ''Payment Response Password'' input field.<br/>5. Check the ''Enable Payment Response'' checkbox.<br/>6. Enter ''&lt;wpdisplay item=MC_callback&gt;'' into the ''Payment Response URL'' input field.<br/>7. Select the ''Save Changes'' button.', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'payment_plugin_messages_ARRAY_world_pay', 'arrays', 'payment_plugin_messages_ARRAY_world_pay', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Your order is saved. Redirecting to WorldPay...', 'script');

COMMIT;