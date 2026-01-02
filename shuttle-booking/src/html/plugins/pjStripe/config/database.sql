DROP TABLE IF EXISTS `plugin_stripe`;
CREATE TABLE IF NOT EXISTS `plugin_stripe` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `foreign_id` int(10) unsigned DEFAULT NULL,
  `stripe_id` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `amount` decimal(9,2) unsigned DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `foreign_id` (`foreign_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `plugin_payment_options` (`payment_method`) VALUES ('stripe');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'payment_methods_ARRAY_stripe', 'arrays', 'payment_methods_ARRAY_stripe', 'script');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Stripe', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_stripe_payment_title', 'frontend', 'Stripe plugin / Payment title', 'script');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Stripe payment', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_stripe_allow', 'backend', 'Stripe plugin / Allow Stripe Payments', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Allow Stripe payments', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_stripe_public_key', 'backend', 'Stripe plugin / Public Key', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Stripe public key:', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_stripe_public_key_text', 'backend', 'Stripe plugin / Public Key Text', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'This is your Stripe public key.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_stripe_private_key', 'backend', 'Stripe plugin / Secret Key', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Stripe secret key:', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_stripe_private_key_text', 'backend', 'Stripe plugin / Secret Key Text', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'This is your Stripe secret key.', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'payment_plugin_messages_ARRAY_stripe', 'arrays', 'payment_plugin_messages_ARRAY_stripe', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Your order is saved. Redirecting to Stripe Checkout...', 'script');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES 
(NULL, 'plugin_stripe_menu_payments', 'backend', 'Stripe plugin / Payments', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES 
(NULL, @id, 'pjField', '::LOCALE::', 'title', 'Payments', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES 
(NULL, 'plugin_stripe_info_title', 'backend', 'Stripe plugin / Stripe payments', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES 
(NULL, @id, 'pjField', '::LOCALE::', 'title', 'Payment details', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES 
(NULL, 'plugin_stripe_foreign_id', 'backend', 'Stripe plugin / Foreign ID', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES 
(NULL, @id, 'pjField', '::LOCALE::', 'title', 'Foreign ID', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES 
(NULL, 'plugin_stripe_stripe_id', 'backend', 'Stripe plugin / Stripe ID', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES 
(NULL, @id, 'pjField', '::LOCALE::', 'title', 'Stripe ID', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES 
(NULL, 'plugin_stripe_token', 'backend', 'Stripe plugin / Token', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES 
(NULL, @id, 'pjField', '::LOCALE::', 'title', 'Token', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES 
(NULL, 'plugin_stripe_created', 'backend', 'Stripe plugin / Created', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES 
(NULL, @id, 'pjField', '::LOCALE::', 'title', 'Date / Time', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES 
(NULL, 'plugin_stripe_amount', 'backend', 'Stripe plugin / Amount', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES 
(NULL, @id, 'pjField', '::LOCALE::', 'title', 'Amount', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES 
(NULL, 'plugin_stripe_currency', 'backend', 'Stripe plugin / Currency', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES 
(NULL, @id, 'pjField', '::LOCALE::', 'title', 'Currency', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES 
(NULL, 'plugin_stripe_btn_view', 'backend', 'Stripe plugin / Button view', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES 
(NULL, @id, 'pjField', '::LOCALE::', 'title', 'View', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES 
(NULL, 'plugin_stripe_btn_close', 'backend', 'Stripe plugin / Button close', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES 
(NULL, @id, 'pjField', '::LOCALE::', 'title', 'Close', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES 
(NULL, 'plugin_stripe_description', 'backend', 'Stripe plugin / Description', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES 
(NULL, @id, 'pjField', '::LOCALE::', 'title', 'Description', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES 
(NULL, 'plugin_stripe_msg', 'backend', 'Stripe plugin / Redirect message', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES 
(NULL, @id, 'pjField', '::LOCALE::', 'title', 'If your browser does not redirects you in 3 seconds, please click the button below.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES 
(NULL, 'plugin_stripe_submit', 'backend', 'Stripe plugin / Pay with Stripe', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES 
(NULL, @id, 'pjField', '::LOCALE::', 'title', 'Pay with Stripe', 'plugin');