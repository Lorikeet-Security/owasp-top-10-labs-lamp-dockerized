
START TRANSACTION;

INSERT INTO `fields` VALUES (NULL, 'plugin_authorize_pay_btn_title', 'backend', 'plugin_authorize_pay_btn_title', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Pay', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'plugin_authorize_continue_btn_title', 'backend', 'plugin_authorize_continue_btn_title', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Continue', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'plugin_authorize_cancel_btn_title', 'backend', 'plugin_authorize_cancel_btn_title', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Cancel', 'plugin');

INSERT INTO `fields` VALUES (NULL, 'plugin_authorize_silent_post_url', 'backend', 'plugin_authorize_silent_post_url', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `multi_lang` VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Authorize.net Silent post URL', 'plugin');

COMMIT;