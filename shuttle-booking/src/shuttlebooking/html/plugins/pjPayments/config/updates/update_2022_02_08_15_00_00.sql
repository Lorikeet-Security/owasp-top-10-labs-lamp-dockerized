
START TRANSACTION;

ALTER TABLE `plugin_payment_options` 
	MODIFY `private_key` text,
	MODIFY `test_private_key` text;
	
COMMIT;