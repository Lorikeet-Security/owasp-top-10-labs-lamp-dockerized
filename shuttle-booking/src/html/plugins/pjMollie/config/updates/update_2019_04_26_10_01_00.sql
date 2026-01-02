
START TRANSACTION;


UPDATE `fields` SET `source`='plugin' WHERE `key` IN ('payment_methods_ARRAY_mollie');
SET @id := (SELECT `id` FROM `fields` WHERE `key`='payment_methods_ARRAY_mollie');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

UPDATE `fields` SET `source`='plugin' WHERE `key` IN ('plugin_mollie_methods_ARRAY_ideal');
SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_mollie_methods_ARRAY_ideal');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

UPDATE `fields` SET `source`='plugin' WHERE `key` IN ('plugin_mollie_methods_ARRAY_mistercash');
SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_mollie_methods_ARRAY_mistercash');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

UPDATE `fields` SET `source`='plugin' WHERE `key` IN ('plugin_mollie_methods_ARRAY_sofort');
SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_mollie_methods_ARRAY_sofort');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

UPDATE `fields` SET `source`='plugin' WHERE `key` IN ('plugin_mollie_methods_ARRAY_creditcard');
SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_mollie_methods_ARRAY_creditcard');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

UPDATE `fields` SET `source`='plugin' WHERE `key` IN ('plugin_mollie_methods_ARRAY_banktransfer');
SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_mollie_methods_ARRAY_banktransfer');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

UPDATE `fields` SET `source`='plugin' WHERE `key` IN ('plugin_mollie_methods_ARRAY_directdebit');
SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_mollie_methods_ARRAY_directdebit');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

UPDATE `fields` SET `source`='plugin' WHERE `key` IN ('plugin_mollie_methods_ARRAY_belfius');
SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_mollie_methods_ARRAY_belfius');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

UPDATE `fields` SET `source`='plugin' WHERE `key` IN ('plugin_mollie_methods_ARRAY_bitcoin');
SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_mollie_methods_ARRAY_bitcoin');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

UPDATE `fields` SET `source`='plugin' WHERE `key` IN ('plugin_mollie_methods_ARRAY_podiumcadeaukaart');
SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_mollie_methods_ARRAY_podiumcadeaukaart');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

UPDATE `fields` SET `source`='plugin' WHERE `key` IN ('plugin_mollie_methods_ARRAY_paysafecard');
SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_mollie_methods_ARRAY_paysafecard');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

UPDATE `fields` SET `source`='plugin' WHERE `key` IN ('plugin_mollie_methods_ARRAY_paypal');
SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_mollie_methods_ARRAY_paypal');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

UPDATE `fields` SET `source`='plugin' WHERE `key` IN ('plugin_mollie_methods_ARRAY_kbc');
SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_mollie_methods_ARRAY_kbc');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

UPDATE `fields` SET `source`='plugin' WHERE `key` IN ('plugin_mollie_payment_title');

UPDATE `fields` SET `source`='plugin' WHERE `key` IN ('payment_plugin_messages_ARRAY_mollie');
SET @id := (SELECT `id` FROM `fields` WHERE `key`='payment_plugin_messages_ARRAY_mollie');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

UPDATE `fields` SET `source`='plugin' WHERE `key` IN ('plugin_mollie_ideal_bank_id');
SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_mollie_ideal_bank_id');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

UPDATE `fields` SET `source`='plugin' WHERE `key` IN ('plugin_mollie_ideal_bank_choose');
SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_mollie_ideal_bank_choose');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

UPDATE `fields` SET `source`='plugin' WHERE `key` IN ('plugin_mollie_method');
SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_mollie_method');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_mollie_method_allow');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_mollie_method_empty');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_mollie_method_required');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_mollie_button_submit');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';


COMMIT;