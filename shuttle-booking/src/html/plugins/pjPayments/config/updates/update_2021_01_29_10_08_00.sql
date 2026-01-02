
START TRANSACTION;

DELETE FROM `plugin_payment_options` WHERE `payment_method` IN ('cash', 'bank');

COMMIT;