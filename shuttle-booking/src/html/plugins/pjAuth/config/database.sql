DROP TABLE IF EXISTS `plugin_auth_login_attempts`;
CREATE TABLE IF NOT EXISTS `plugin_auth_login_attempts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `plugin_auth_permissions`;
CREATE TABLE IF NOT EXISTS `plugin_auth_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `key` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `plugin_auth_roles`;
CREATE TABLE IF NOT EXISTS `plugin_auth_roles` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(255) DEFAULT NULL,
  `status` enum('T','F') NOT NULL DEFAULT 'T',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `plugin_auth_roles_permissions`;
CREATE TABLE IF NOT EXISTS `plugin_auth_roles_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_id` (`role_id`,`permission_id`),
  KEY `permission_id` (`permission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `plugin_auth_users`;
CREATE TABLE IF NOT EXISTS `plugin_auth_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` blob,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `pswd_modified` datetime DEFAULT NULL,
  `status` enum('T','F') NOT NULL DEFAULT 'T',
  `is_active` enum('T','F') NOT NULL DEFAULT 'F',
  `locked` enum('T','F') NOT NULL DEFAULT 'F',
  `login_token` varchar(255) DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `role_id` (`role_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `plugin_auth_users_permissions`;
CREATE TABLE IF NOT EXISTS `plugin_auth_users_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`permission_id`),
  KEY `permission_id` (`permission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `plugin_auth_roles` (`id`, `role`, `status`) VALUES
(1, 'Administrator', 'T'),
(2, 'Regular User', 'T');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_auth_pwd_error_ARRAY_100', 'arrays', 'plugin_auth_pwd_error_ARRAY_100', 'plugin', '2017-11-30 10:27:11');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Password minimum length should be %u.', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_auth_pwd_error_ARRAY_101', 'arrays', 'plugin_auth_pwd_error_ARRAY_101', 'plugin', '2017-11-30 10:28:43');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Password must contain letters only.', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_auth_pwd_error_ARRAY_105', 'arrays', 'plugin_auth_pwd_error_ARRAY_105', 'plugin', '2017-11-30 10:29:23');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Password must contain at least one capital letter.', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_auth_pwd_error_ARRAY_102', 'arrays', 'plugin_auth_pwd_error_ARRAY_102', 'plugin', '2017-11-30 10:29:39');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Password must contain digits only.', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_auth_pwd_error_ARRAY_103', 'arrays', 'plugin_auth_pwd_error_ARRAY_103', 'plugin', '2017-11-30 10:30:05');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Password must contain at least one letter and one digit.', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_auth_pwd_error_ARRAY_104', 'arrays', 'plugin_auth_pwd_error_ARRAY_104', 'plugin', '2017-11-30 10:30:39');
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Password must contain at least one special character.', 'plugin');

INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, NULL, 'pjBaseOptions');
SET @level_1_id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_1_id, 'pjAuthPermission', '::LOCALE::', 'title', 'System Options Menu', 'data');

  INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_1_id, 'pjBaseOptions_pjActionIndex');
  SET @level_2_id := (SELECT LAST_INSERT_ID());
  INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_2_id, 'pjAuthPermission', '::LOCALE::', 'title', 'General Menu', 'data');

  INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_1_id, 'pjBaseOptions_pjActionApiKeys');
  SET @level_2_id := (SELECT LAST_INSERT_ID());
  INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_2_id, 'pjAuthPermission', '::LOCALE::', 'title', 'API Keys', 'data');

  INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_1_id, 'pjBaseOptions_pjActionEmailSettings');
  SET @level_2_id := (SELECT LAST_INSERT_ID());
  INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_2_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Email Settings', 'data');

  INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_1_id, 'pjBaseSms');
  SET @level_2_id := (SELECT LAST_INSERT_ID());
  INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_2_id, 'pjAuthPermission', '::LOCALE::', 'title', 'SMS Settings Menu', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjBaseSms_pjActionIndex_settings');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'SMS Settings', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjBaseSms_pjActionIndex_list');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'View list of messages sent', 'data');

  INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_1_id, 'pjBaseLocale');
  SET @level_2_id := (SELECT LAST_INSERT_ID());
  INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_2_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Languages Menu', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjBaseLocale_pjActionIndex');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Languages List', 'data');

      INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_3_id, 'pjBaseLocale_pjActionSaveLocale');
      SET @level_4_id := (SELECT LAST_INSERT_ID());
      INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_4_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Add & Update Language', 'data');

      INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_3_id, 'pjBaseLocale_pjActionDeleteLocale');
      SET @level_4_id := (SELECT LAST_INSERT_ID());
      INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_4_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Delete Language', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjBaseLocale_pjActionLabels');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Labels', 'data');

      INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_3_id, 'pjBaseLocale_pjActionLabels_showIds');
      SET @level_4_id := (SELECT LAST_INSERT_ID());
      INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_4_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Advanced Translation ON/OFF', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjBaseLocale_pjActionImportExport');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Import / Export', 'data');

      INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_3_id, 'pjBaseLocale_pjActionImportExport_import');
      SET @level_4_id := (SELECT LAST_INSERT_ID());
      INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_4_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Import', 'data');

      INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_3_id, 'pjBaseLocale_pjActionImportExport_export');
      SET @level_4_id := (SELECT LAST_INSERT_ID());
      INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_4_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Export', 'data');

  INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_1_id, 'pjBaseOptions_pjActionLoginProtection');
  SET @level_2_id := (SELECT LAST_INSERT_ID());
  INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_2_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Login & Protection', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjBaseOptions_pjActionLoginProtection_password');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Password Strength Settings', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjBaseOptions_pjActionLoginProtection_secure_login');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Secure Login Settings', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjBaseOptions_pjActionLoginProtection_failed_login');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Failed Login Settings', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjBaseOptions_pjActionLoginProtection_forgot');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Forgot Password Settings', 'data');

  INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_1_id, 'pjBaseOptions_pjActionCaptchaSpam');
  SET @level_2_id := (SELECT LAST_INSERT_ID());
  INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_2_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Captcha & SPAM', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjBaseOptions_pjActionCaptchaSpam_captcha');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Captcha Settings', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjBaseOptions_pjActionCaptchaSpam_spam');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'SPAM Protection', 'data');

  INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_1_id, 'pjBaseOptions_pjActionVisual');
  SET @level_2_id := (SELECT LAST_INSERT_ID());
  INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_2_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Visual & Branding', 'data');

  INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_1_id, 'pjBaseCron_pjActionIndex');
  SET @level_2_id := (SELECT LAST_INSERT_ID());
  INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_2_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Cron Jobs Menu', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjBaseCron_pjActionExecute');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Execute Cron Job', 'data');

  INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_1_id, 'pjBaseBackup_pjActionIndex');
  SET @level_2_id := (SELECT LAST_INSERT_ID());
  INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_2_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Back-up Menu', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjBaseBackup_pjActionBackup');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Do back-up files', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjBaseBackup_pjActionDownload');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Download back-up file', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjBaseBackup_pjActionDelete');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Delete back-up file', 'data');

    INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_2_id, 'pjBaseBackup_pjActionDeleteBulk');
    SET @level_3_id := (SELECT LAST_INSERT_ID());
    INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_3_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Delete multiple back-up files', 'data');

INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, NULL, 'pjBaseUsers');
SET @level_1_id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_1_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Users Menu', 'data');

  INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_1_id, 'pjBaseUsers_pjActionCreate');
  SET @level_2_id := (SELECT LAST_INSERT_ID());
  INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_2_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Create User', 'data');

  INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_1_id, 'pjBaseUsers_pjActionUpdate');
  SET @level_2_id := (SELECT LAST_INSERT_ID());
  INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_2_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Update User', 'data');

  INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_1_id, 'pjBasePermissions_pjActionUserPermission');
  SET @level_2_id := (SELECT LAST_INSERT_ID());
  INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_2_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Update User Permissions', 'data');

  INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_1_id, 'pjBaseUsers_pjActionDeleteUser');
  SET @level_2_id := (SELECT LAST_INSERT_ID());
  INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_2_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Delete single user', 'data');

  INSERT INTO `plugin_auth_permissions` (`id`, `parent_id`, `key`) VALUES (NULL, @level_1_id, 'pjBaseUsers_pjActionDeleteUserBulk');
  SET @level_2_id := (SELECT LAST_INSERT_ID());
  INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @level_2_id, 'pjAuthPermission', '::LOCALE::', 'title', 'Delete multiple users', 'data');
	

	