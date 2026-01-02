
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'plugin_2checkout_payment_label', 'backend', 'Plugin 2checkout / Label', 'plugin', '2017-08-16 05:53:54');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Label', 'plugin');

COMMIT;