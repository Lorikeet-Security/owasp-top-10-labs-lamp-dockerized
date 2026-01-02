
START TRANSACTION;

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_authorize_private_key');
UPDATE `multi_lang` SET `content`='Authorize.Net signature key' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_authorize_private_key_text');
UPDATE `multi_lang` SET `content`='This is your Authorize.Net signature key.' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';



COMMIT;