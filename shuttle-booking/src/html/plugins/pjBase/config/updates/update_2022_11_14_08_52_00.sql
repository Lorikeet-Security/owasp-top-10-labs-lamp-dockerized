
START TRANSACTION;


SET @id := (SELECT `id` FROM `plugin_base_fields` WHERE `key`='plugin_base_sms_infobox_api_settings');
UPDATE `plugin_base_multi_lang` SET `content`='To send SMS you need a valid API Key from <a href="https://clicksend.com/?u=366773">ClickSend</a>. If you have one, enter it in the box below. Click on "Verify your key" button to check if key is valid. Click on "Send a test message" button to send a test message to your phone.' WHERE `foreign_id`=@id AND `model`='pjBaseField' AND `field`='title';


COMMIT;