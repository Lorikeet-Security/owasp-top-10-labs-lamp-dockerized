START TRANSACTION;

DROP TABLE IF EXISTS `plugin_mollie`;
CREATE TABLE IF NOT EXISTS `plugin_mollie` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `foreign_id` int(10) unsigned default NULL,
  `method` varchar(255) default NULL,
  `amount` decimal(9,2) unsigned default NULL,
  `txn_id` varchar(255) default NULL,
  `ref_id` varchar(255) default NULL,
  `bank_id` varchar(255) default NULL,
  `processed_on` datetime default NULL,
  `status` enum('paid','notpaid') DEFAULT 'notpaid',
  `created` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `foreign_id` (`foreign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `plugin_mollie_options`;
CREATE TABLE IF NOT EXISTS `plugin_mollie_options` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `foreign_id` int(10) unsigned default NULL,
  `method` varchar(255) default NULL,
  `is_active` BOOLEAN DEFAULT 0,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `foreign_id` (`foreign_id`,`method`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `plugin_payment_options` (`payment_method`) VALUES ('mollie');

INSERT INTO `fields` VALUES (NULL, 'payment_methods_ARRAY_mollie', 'arrays', 'payment_methods_ARRAY_mollie', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Mollie', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_methods_ARRAY_ideal', 'arrays', 'plugin_mollie_methods_ARRAY_ideal', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Mollie iDEAL', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_methods_ARRAY_mistercash', 'arrays', 'plugin_mollie_methods_ARRAY_mistercash', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Mollie Bancontact/Mister Cash', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_methods_ARRAY_sofort', 'arrays', 'plugin_mollie_methods_ARRAY_sofort', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Mollie SOFORT Banking', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_methods_ARRAY_creditcard', 'arrays', 'plugin_mollie_methods_ARRAY_creditcard', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Mollie Creditcard', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_methods_ARRAY_banktransfer', 'arrays', 'plugin_mollie_methods_ARRAY_banktransfer', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Mollie Bank transfer', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_methods_ARRAY_directdebit', 'arrays', 'plugin_mollie_methods_ARRAY_directdebit', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Mollie SEPA Direct Debit', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_methods_ARRAY_belfius', 'arrays', 'plugin_mollie_methods_ARRAY_belfius', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Mollie Belfius', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_methods_ARRAY_bitcoin', 'arrays', 'plugin_mollie_methods_ARRAY_bitcoin', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Mollie Bitcoin', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_methods_ARRAY_podiumcadeaukaart', 'arrays', 'plugin_mollie_methods_ARRAY_podiumcadeaukaart', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Mollie PODIUM', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_methods_ARRAY_paysafecard', 'arrays', 'plugin_mollie_methods_ARRAY_paysafecard', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Mollie Paysafecard', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_methods_ARRAY_paypal', 'arrays', 'plugin_mollie_methods_ARRAY_paypal', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Mollie PayPal', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_methods_ARRAY_kbc', 'arrays', 'plugin_mollie_methods_ARRAY_kbc', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Mollie KBC/CBC', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_payment_title', 'frontend', 'Mollie plugin / Payment title', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Mollie payment', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_allow', 'backend', 'Mollie plugin / Allow Mollie Payments', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Allow Mollie payments', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_public_key', 'backend', 'Mollie plugin / API Key', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Mollie API Key:', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_public_key_text', 'backend', 'Mollie plugin / API Key Text', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'This is your Mollie API key.', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_failure_url', 'backend', 'Mollie plugin / Error page URL', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Mollie error page:', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_description', 'backend', 'Mollie plugin / Mollie payment description', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Mollie payment description:', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'payment_plugin_messages_ARRAY_mollie', 'arrays', 'payment_plugin_messages_ARRAY_mollie', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Your order is saved. Redirecting to Mollie...', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_ideal_bank_id', 'frontend', 'plugin_mollie_ideal_bank_id', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Bank', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_ideal_bank_choose', 'frontend', 'plugin_mollie_ideal_bank_choose', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Select bank or later', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_method', 'frontend', 'plugin_mollie_method', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Method', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_method_allow', 'backend', 'Mollie plugin / Allow Mollie Methods', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Allow Mollie methods', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_method_empty', 'frontend', 'plugin_mollie_method_empty', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', '-- Payment method --', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_method_required', 'frontend', 'plugin_mollie_method_required', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Payment method is required.', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_mollie_button_submit', 'frontend', 'plugin_mollie_button_submit', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Submit', 'script');

COMMIT;