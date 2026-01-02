
START TRANSACTION;

ALTER TABLE `plugin_auth_permissions` ADD COLUMN `inherit_id` int(10) unsigned DEFAULT NULL AFTER `parent_id`;

ALTER TABLE `plugin_auth_roles` ADD COLUMN `is_backend` enum('T','F') NOT NULL DEFAULT 'T' AFTER `role`;
ALTER TABLE `plugin_auth_roles` ADD COLUMN `is_admin` enum('T','F') NOT NULL DEFAULT 'F' AFTER `is_backend`;

UPDATE `plugin_auth_roles` SET `is_admin`='T';

ALTER TABLE `plugin_auth_permissions` ADD COLUMN `is_shown` enum('T','F') NOT NULL DEFAULT 'T';

SET @level_1_id := (SELECT `id` FROM `plugin_auth_permissions` WHERE `key`='pjBaseOptions');
INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_1_id, 'pjBaseCountries');
  SET @level_2_id := (SELECT LAST_INSERT_ID());
  INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_2_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Countries Menu', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjBaseCountries_pjActionCreate');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Create Country', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjBaseCountries_pjActionUpdate');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Update Country', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjBaseCountries_pjActionDeleteCountry');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Delete single Country', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjBaseCountries_pjActionDeleteCountryBulk');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Delete Multiple Countries', 'data');
    
    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`, `is_shown`) VALUES (NULL, @level_2_id, 'pjBaseCountries_pjActionIndex', 'F');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Countries List', 'data');
  
  	  INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`, `inherit_id`, `is_shown`) VALUES (NULL, NULL, 'pjBaseCountries_pjActionGetCountry', @level_3_id, 'F');
	
      INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`, `is_shown`) VALUES (NULL, @level_3_id, 'pjBaseCountries_pjActionStatusCountry', 'F');
      SET @level_4_id := (SELECT LAST_INSERT_ID());
      INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_4_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Revert country status', 'data');

INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`, `is_shown`) VALUES (NULL, @level_1_id, 'pjBaseUsers_pjActionIndex', 'F');
  SET @level_2_id := (SELECT LAST_INSERT_ID());
  INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_2_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Users List', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`, `is_shown`) VALUES (NULL, @level_2_id, 'pjBaseUsers_pjActionStatusUser', 'F');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Revert user status', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`, `is_shown`) VALUES (NULL, @level_2_id, 'pjBaseUsers_pjActionExportUser', 'F');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Export users', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`, `is_shown`) VALUES (NULL, @level_2_id, 'pjBaseUsers_pjActionUnlockAccount', 'F');
	SET @level_3_id := (SELECT LAST_INSERT_ID());
	INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Unlock user account', 'data');

INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, NULL, 'pjBaseUsers_pjActionProfile');
SET @level_1_id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_1_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Profile', 'data');
	
SET @level_2_id := (SELECT `id` FROM `plugin_auth_permissions` WHERE `key` = 'pjBasePermissions_pjActionUserPermission' LIMIT 1);
INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`, `inherit_id`) VALUES (NULL, NULL, 'pjBasePermissions_pjActionAjaxSet', @level_2_id);

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseBackup_pjActionBackup', 'backend', 'pjBaseBackup_pjActionBackup', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Do back-up files', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseBackup_pjActionDelete', 'backend', 'pjBaseBackup_pjActionDelete', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete back-up file', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseBackup_pjActionDeleteBulk', 'backend', 'pjBaseBackup_pjActionDeleteBulk', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete multiple back-up files', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseBackup_pjActionDownload', 'backend', 'pjBaseBackup_pjActionDownload', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Download back-up file', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseBackup_pjActionIndex', 'backend', 'pjBaseBackup_pjActionIndex', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Back-up Menu', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseCountries', 'backend', 'pjBaseCountries', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Countries Menu', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseCountries_pjActionCreate', 'backend', 'pjBaseCountries_pjActionCreate', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Create Country', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseCountries_pjActionDeleteCountry', 'backend', 'pjBaseCountries_pjActionDeleteCountry', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete single Country', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseCountries_pjActionDeleteCountryBulk', 'backend', 'pjBaseCountries_pjActionDeleteCountryBulk', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete Multiple Countries', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseCountries_pjActionIndex', 'backend', 'pjBaseCountries_pjActionIndex', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Countries List', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseCountries_pjActionStatusCountry', 'backend', 'pjBaseCountries_pjActionStatusCountry', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Revert country status', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseCountries_pjActionUpdate', 'backend', 'pjBaseCountries_pjActionUpdate', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Update Country', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseCron_pjActionExecute', 'backend', 'pjBaseCron_pjActionExecute', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Execute Cron Job', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseCron_pjActionIndex', 'backend', 'pjBaseCron_pjActionIndex', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Cron Jobs Menu', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseLocale', 'backend', 'pjBaseLocale', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Languages Menu', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseLocale_pjActionDeleteLocale', 'backend', 'pjBaseLocale_pjActionDeleteLocale', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete Language', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseLocale_pjActionImportExport', 'backend', 'pjBaseLocale_pjActionImportExport', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Import / Export', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseLocale_pjActionImportExport_export', 'backend', 'pjBaseLocale_pjActionImportExport_export', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Export', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseLocale_pjActionImportExport_import', 'backend', 'pjBaseLocale_pjActionImportExport_import', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Import', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseLocale_pjActionIndex', 'backend', 'pjBaseLocale_pjActionIndex', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Languages List', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseLocale_pjActionLabels', 'backend', 'pjBaseLocale_pjActionLabels', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Labels', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseLocale_pjActionLabels_showIds', 'backend', 'pjBaseLocale_pjActionLabels_showIds', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Advanced Translation ON/OFF', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseLocale_pjActionSaveLocale', 'backend', 'pjBaseLocale_pjActionSaveLocale', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add & Update Language', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseOptions_pjActionApiKeys', 'backend', 'pjBaseOptions_pjActionApiKeys', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'API Keys', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseOptions_pjActionCaptchaSpam', 'backend', 'pjBaseOptions_pjActionCaptchaSpam', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Captcha & SPAM', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseOptions_pjActionCaptchaSpam_captcha', 'backend', 'pjBaseOptions_pjActionCaptchaSpam_captcha', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Captcha Settings', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseOptions_pjActionCaptchaSpam_spam', 'backend', 'pjBaseOptions_pjActionCaptchaSpam_spam', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'SPAM Protection', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseOptions_pjActionEmailSettings', 'backend', 'pjBaseOptions_pjActionEmailSettings', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Email Settings', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseOptions', 'backend', 'pjBaseOptions', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'System Options Menu', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseOptions_pjActionIndex', 'backend', 'pjBaseOptions_pjActionIndex', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'General Menu', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseOptions_pjActionLoginProtection', 'backend', 'pjBaseOptions_pjActionLoginProtection', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Login & Protection', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseOptions_pjActionLoginProtection_failed_login', 'backend', 'pjBaseOptions_pjActionLoginProtection_failed_login', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Failed Login Settings', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseOptions_pjActionLoginProtection_forgot', 'backend', 'pjBaseOptions_pjActionLoginProtection_forgot', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Forgot Password Settings', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseOptions_pjActionLoginProtection_password', 'backend', 'pjBaseOptions_pjActionLoginProtection_password', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Password Strength Settings', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseOptions_pjActionLoginProtection_secure_login', 'backend', 'pjBaseOptions_pjActionLoginProtection_secure_login', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Secure Login Settings', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseOptions_pjActionVisual', 'backend', 'pjBaseOptions_pjActionVisual', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Visual & Branding', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBasePermissions_pjActionUserPermission', 'backend', 'pjBasePermissions_pjActionUserPermission', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Update User Permissions', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseSms', 'backend', 'pjBaseSms', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'SMS Settings Menu', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseSms_pjActionIndex_list', 'backend', 'pjBaseSms_pjActionIndex_list', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'View list of messages sent', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseSms_pjActionIndex_settings', 'backend', 'pjBaseSms_pjActionIndex_settings', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'SMS Settings', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseUsers', 'backend', 'pjBaseUsers', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Users Menu', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseUsers_pjActionCreate', 'backend', 'pjBaseUsers_pjActionCreate', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Create User', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseUsers_pjActionDeleteUser', 'backend', 'pjBaseUsers_pjActionDeleteUser', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete single user', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseUsers_pjActionDeleteUserBulk', 'backend', 'pjBaseUsers_pjActionDeleteUserBulk', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete multiple users', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseUsers_pjActionExportUser', 'backend', 'pjBaseUsers_pjActionExportUser', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Export users', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseUsers_pjActionIndex', 'backend', 'pjBaseUsers_pjActionIndex', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Users List', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseUsers_pjActionProfile', 'backend', 'pjBaseUsers_pjActionProfile', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Profile', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseUsers_pjActionStatusUser', 'backend', 'pjBaseUsers_pjActionStatusUser', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Revert user status', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseUsers_pjActionUnlockAccount', 'backend', 'pjBaseUsers_pjActionUnlockAccount', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Unlock user account', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjBaseUsers_pjActionUpdate', 'backend', 'pjBaseUsers_pjActionUpdate', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Update User', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjVouchers', 'backend', 'pjVouchers', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Vouchers Menu', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjVouchers_pjActionCreate', 'backend', 'pjVouchers_pjActionCreate', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add vouchers', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjVouchers_pjActionDeleteVoucher', 'backend', 'pjVouchers_pjActionDeleteVoucher', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete single voucher', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjVouchers_pjActionDeleteVoucherBulk', 'backend', 'pjVouchers_pjActionDeleteVoucherBulk', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete multiple vouchers', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjVouchers_pjActionExportVoucher', 'backend', 'pjVouchers_pjActionExportVoucher', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Export vouchers', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'pjVouchers_pjActionUpdate', 'backend', 'pjVouchers_pjActionUpdate', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Edit vouchers', 'plugin');

INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`, `is_shown`) VALUES (NULL, @level_2_id, 'pjBaseCountries_pjActionIndex', 'F');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Countries List', 'data');
  
  	  INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`, `inherit_id`, `is_shown`) VALUES (NULL, NULL, 'pjBaseCountries_pjActionGetCountry', @level_3_id, 'F');
	
      INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`, `is_shown`) VALUES (NULL, @level_3_id, 'pjBaseCountries_pjActionStatusCountry', 'F');
      SET @level_4_id := (SELECT LAST_INSERT_ID());
      INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_4_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Revert country status', 'data');

COMMIT;