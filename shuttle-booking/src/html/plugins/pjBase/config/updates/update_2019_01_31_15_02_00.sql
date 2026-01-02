
START TRANSACTION;

INSERT INTO `plugin_base_options` (`foreign_id`, `key`, `tab_id`, `value`, `label`, `type`, `order`, `is_visible`, `style`) VALUES
(1, 'o_google_geocoding_api_key', 10, NULL, NULL, 'string', 1, 1, NULL);

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_opt_o_google_geocoding_api_key', 'backend', 'Plugin Base / Options / Google Geocoding API Key', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Google Geocoding API Key', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_opt_o_google_geocoding_api_key_text', 'backend', 'Plugin Base / Options / Google Geocoding API Key', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Enter your Google Geocoding API key here in order for Google maps to work with your system. If you do not have such key <a href="https://developers.google.com/maps/documentation/geocoding/get-api-key" target="_blank">get a key here.</a>', 'plugin');

SET @id := (SELECT `id` FROM `plugin_base_fields` WHERE `key`='plugin_base_opt_o_google_maps_api_key');
UPDATE `plugin_base_multi_lang` SET `content`='Google Map API Key' WHERE `foreign_id`=@id AND `model`='pjBaseField' AND `field`='title';


COMMIT;