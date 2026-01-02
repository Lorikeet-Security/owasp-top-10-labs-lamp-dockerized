
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'plugin_stripe_payment_label', 'backend', 'Plugin Stripe / Label', 'plugin', '2017-08-16 05:58:58');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Label', 'plugin');

COMMIT;