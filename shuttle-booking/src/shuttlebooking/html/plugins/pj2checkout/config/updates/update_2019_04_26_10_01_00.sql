
START TRANSACTION;


UPDATE `fields` SET `source`='plugin' WHERE `key` IN ('payment_methods_ARRAY_2checkout','plugin_2checkout_payment_title','payment_plugin_messages_ARRAY_2checkout');

SET @id := (SELECT `id` FROM `fields` WHERE `key`='payment_plugin_messages_ARRAY_2checkout');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';


COMMIT;