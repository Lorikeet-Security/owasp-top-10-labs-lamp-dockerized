
START TRANSACTION;

UPDATE `fields` SET `source`='plugin' WHERE `key` IN ('payment_methods_ARRAY_braintree','plugin_braintree_payment_title','payment_plugin_messages_ARRAY_braintree');



SET @id := (SELECT `id` FROM `fields` WHERE `key`='payment_plugin_messages_ARRAY_braintree');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_header_title');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_site_name');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_braintree_name');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_make_a_payment');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_amount');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_btn_pay_now');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_btn_cancel');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_transaction_failed');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_missing_parameters');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_transaction_has_status');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_response');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_transaction');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_trasaction_id');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_trasaction_type');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_trasaction_amount');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_trasaction_status');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_payment');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_card_type');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_card_exp');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_card_holder_name');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_card_location');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_customer_details');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_cust_id');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_cust_fname');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_cust_lname');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_cust_email');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_cust_company');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_cust_website');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_cust_phone');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_cust_fax');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_btn_try_again');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_hash_error');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';

SET @id := (SELECT `id` FROM `fields` WHERE `key`='plugin_braintree_config_missing');
UPDATE `multi_lang` SET `source`='plugin' WHERE `foreign_id`=@id AND `model`='pjField' AND `field`='title';


COMMIT;