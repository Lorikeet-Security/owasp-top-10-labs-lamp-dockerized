
START TRANSACTION;

SET @id := (SELECT `id` FROM `plugin_base_fields` WHERE `key` = 'pjBaseUsers_pjActionStatusUser');
UPDATE `plugin_base_multi_lang` SET `content` = 'Revert multiple users status' WHERE `foreign_id` = @id AND `model` = "pjBaseField" AND `field` = "title";


COMMIT;