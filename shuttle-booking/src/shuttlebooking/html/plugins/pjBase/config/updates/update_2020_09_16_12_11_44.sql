
START TRANSACTION;

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_ip_blocked_msg', 'backend', 'Plugin Base / Label / We are sorry that your IP address was blocked.', 'plugin', '2020-08-14 09:04:25');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'We are sorry that your IP address was blocked.', 'plugin');

COMMIT;