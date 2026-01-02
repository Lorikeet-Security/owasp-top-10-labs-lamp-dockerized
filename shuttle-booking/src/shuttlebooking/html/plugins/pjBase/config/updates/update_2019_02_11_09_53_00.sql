
START TRANSACTION;


SET @id := (SELECT `id` FROM `plugin_base_fields` WHERE `key`='plugin_base_opt_o_google_maps_api_key');
UPDATE `plugin_base_multi_lang` SET `content`='Google Maps API Browser key' WHERE `foreign_id`=@id AND `model`='pjBaseField' AND `field`='title';

SET @id := (SELECT `id` FROM `plugin_base_fields` WHERE `key`='plugin_base_opt_o_google_geocoding_api_key');
UPDATE `plugin_base_multi_lang` SET `content`='Google Maps API Server key' WHERE `foreign_id`=@id AND `model`='pjBaseField' AND `field`='title';

UPDATE `plugin_base_fields` SET `source`='plugin' WHERE `key` IN ('plugin_base_send_test_swal_success_title','plugin_base_send_test_swal_smg_title','plugin_base_send_test_swal_error_title','plugin_base_email_text_ARRAY_1','plugin_base_email_text_ARRAY_2','plugin_base_email_text_ARRAY_3','plugin_base_email_text_ARRAY_4','plugin_base_email_text_ARRAY_5','plugin_base_email_text_ARRAY_6','plugin_base_email_text_ARRAY_7','plugin_base_email_text_ARRAY_8','plugin_base_email_text_ARRAY_9','plugin_base_api_key_text_ARRAY_100','plugin_base_api_key_text_ARRAY_101','plugin_base_api_key_text_ARRAY_102','plugin_base_api_key_text_ARRAY_103','plugin_base_api_key_text_ARRAY_200','plugin_base_sms_key_text_ARRAY_100','plugin_base_sms_key_text_ARRAY_101','plugin_base_sms_key_text_ARRAY_4','plugin_base_validate_select_file');

COMMIT;