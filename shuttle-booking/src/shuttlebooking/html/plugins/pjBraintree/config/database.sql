START TRANSACTION;

INSERT INTO `plugin_payment_options` (`payment_method`) VALUES ('braintree');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'payment_methods_ARRAY_braintree', 'arrays', 'payment_methods_ARRAY_braintree', 'script');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Braintree', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_braintree_payment_title', 'frontend', 'Braintree plugin / Payment title', 'script');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Braintree payment', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_braintree_allow', 'backend', 'Braintree plugin / Allow Braintree Payments', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Allow Braintree payments', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_braintree_merchant_id', 'backend', 'Braintree plugin / Merchant ID', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Braintree merchant ID:', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_braintree_merchant_id_text', 'backend', 'Braintree plugin / Merchant ID Text', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'This is your Braintree merchant ID.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_braintree_public_key', 'backend', 'Braintree plugin / Public Key', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Braintree public key:', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_braintree_public_key_text', 'backend', 'Braintree plugin / Public Key Text', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'This is your Braintree public key.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_braintree_private_key', 'backend', 'Braintree plugin / Private Key', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Braintree private key:', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`) VALUES
  (NULL, 'plugin_braintree_private_key_text', 'backend', 'Braintree plugin / Private Key Text', 'plugin');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
  (NULL, @id, 'pjField', '::LOCALE::', 'title', 'This is your Braintree private key.', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'payment_plugin_messages_ARRAY_braintree', 'arrays', 'payment_plugin_messages_ARRAY_braintree', 'script', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Your order is saved. Redirecting to Braintree...', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_header_title', 'backend', 'Braintree plugin / Braintree Payment', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Braintree Payment', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_site_name', 'backend', 'Braintree plugin / Site name', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Site Name', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_braintree_name', 'backend', 'Braintree plugin / Braintree', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Braintree', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_make_a_payment', 'backend', 'Braintree plugin / Make a payment', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Make a payment with Braintree using PayPal or a card', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_amount', 'backend', 'Braintree plugin / Amount', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Amount', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_btn_pay_now', 'backend', 'Braintree plugin / Pay Now', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Pay Now', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_btn_cancel', 'backend', 'Braintree plugin / Cancel', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Cancel', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_transaction_failed', 'backend', 'Braintree plugin / Transaction Failed', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Transaction Failed', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_missing_parameters', 'backend', 'Braintree plugin / Post parameters are missing.', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Post parameters are missing.', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_transaction_has_status', 'backend', 'Braintree plugin / Transaction has status of', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Your transaction has a status of', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_response', 'backend', 'Braintree plugin / Response', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Response', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_transaction', 'backend', 'Braintree plugin / Transaction', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Transaction', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_trasaction_id', 'backend', 'Braintree plugin / ID', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'ID', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_trasaction_type', 'backend', 'Braintree plugin / Type', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Type', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_trasaction_amount', 'backend', 'Braintree plugin / Amount', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Amount', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_trasaction_status', 'backend', 'Braintree plugin / Status', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Status', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_payment', 'backend', 'Braintree plugin / Payment', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Payment', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_card_type', 'backend', 'Braintree plugin / Card type', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Card type', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_card_exp', 'backend', 'Braintree plugin / Card expiration', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Card expiration', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_card_holder_name', 'backend', 'Braintree plugin / Card holder name', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Card holder name', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_card_location', 'backend', 'Braintree plugin / Customer location', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Customer location', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_customer_details', 'backend', 'Braintree plugin / Customer details', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Customer details', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_cust_id', 'backend', 'Braintree plugin / ID', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'ID', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_cust_fname', 'backend', 'Braintree plugin / First name', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'First name', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_cust_lname', 'backend', 'Braintree plugin / Last name', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Last name', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_cust_email', 'backend', 'Braintree plugin / Email', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Email', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_cust_company', 'backend', 'Braintree plugin / Company', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Company', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_cust_website', 'backend', 'Braintree plugin / Website', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Website', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_cust_phone', 'backend', 'Braintree plugin / Phone', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Phone', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_cust_fax', 'backend', 'Braintree plugin / Fax', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Fax', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_btn_try_again', 'backend', 'Braintree plugin / Try Again', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Try Again', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_hash_error', 'backend', 'Braintree plugin / Hash value is not correct.', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Hash value is not correct.', 'script');

INSERT INTO `fields` VALUES (NULL, 'plugin_braintree_config_missing', 'backend', 'Braintree plugin / Configuration parameters are missing.', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Configuration parameters are missing.', 'script');

COMMIT;