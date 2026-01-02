
START TRANSACTION;

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_login_err_ARRAY_3', 'arrays', 'plugin_base_login_err_ARRAY_3', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Your account was disabled.', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_menu_countries', 'backend', 'Plugin Base / Menu / Countries', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Countries', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_infobox_countries_title', 'backend', 'Plugin Base / Infobox / Countries', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Countries', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_infobox_countries_desc', 'backend', 'Plugin Base / Infobox / Countries', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Use grid below to organize your country list.', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_infobox_add_country_title', 'backend', 'Plugin Base / Infobox / Add country', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add country', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_infobox_add_country_desc', 'backend', 'Plugin Base / Infobox / Add country desc', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Use form below to add a country.', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_infobox_update_country_title', 'backend', 'Plugin Base / Infobox / Update country', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Update country', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_infobox_update_country_desc', 'backend', 'Plugin Base / Infobox / Update country desc', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Use form below to update a country.', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_error_titles_ARRAY_PCY01', 'arrays', 'plugin_base_error_titles_ARRAY_PCY01', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Country updated', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_error_titles_ARRAY_PCY03', 'arrays', 'plugin_base_error_titles_ARRAY_PCY03', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Country added', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_error_titles_ARRAY_PCY04', 'arrays', 'plugin_base_error_titles_ARRAY_PCY04', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Country failed to add', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_error_titles_ARRAY_PCY08', 'arrays', 'plugin_base_error_titles_ARRAY_PCY08', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Country not found', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_error_bodies_ARRAY_PCY01', 'arrays', 'plugin_base_error_bodies_ARRAY_PCY01', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Country has been updated successfully.', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_error_bodies_ARRAY_PCY03', 'arrays', 'plugin_base_error_bodies_ARRAY_PCY03', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Country has been added successfully.', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_error_bodies_ARRAY_PCY04', 'arrays', 'plugin_base_error_bodies_ARRAY_PCY04', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Country has not been added successfully.', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_error_bodies_ARRAY_PCY08', 'arrays', 'plugin_base_error_bodies_ARRAY_PCY08', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Country you are looking for has not been found.', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_btn_add_country', 'backend', 'Plugin Base / Buttons / Add country', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Add country', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_country_name', 'backend', 'Plugin Base / Label / Country name', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Country name', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_alpha_2', 'backend', 'Plugin Base / Label / Alpha 2', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Alpha 2', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_alpha_3', 'backend', 'Plugin Base / Label / Alpha 3', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Alpha 3', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_duplicated_alpha_2', 'backend', 'Plugin Base / Label / Duplicated alpha 2', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Duplicated alpha 2', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_duplicated_alpha_3', 'backend', 'Plugin Base / Label / Duplicated alpha 3', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Duplicated alpha 3', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_infobox_user_profile_title', 'backend', 'Plugin Base / Infobox / User Profile', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'User Profile', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_infobox_user_profile_desc', 'backend', 'Plugin Base / Infobox / User Profile', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Reivew and update your profile.', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_menu_role_permissions', 'backend', 'Plugin Base / Menu / Role permissions', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Role permissions', 'plugin');

INSERT INTO `plugin_base_multi_lang` VALUES (NULL, 1, 'pjBaseOption', '::LOCALE::', 'o_failed_login_send_email_subject', 'Your account has been locked!', 'data');
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, 1, 'pjBaseOption', '::LOCALE::', 'o_failed_login_send_email_message', '<p>Dear {Name},</p>\r\n<p>We''ve detected {LoginAttempts} unsuccessful attempts to login your account.</p>\r\n<p>For security reasons we locked down your account.</p>\r\n<p>To unlock your account please contact us.</p>\r\n<p>Regards!</p>', 'data');

INSERT INTO `plugin_base_multi_lang` VALUES (NULL, 1, 'pjBaseOption', '::LOCALE::', 'o_failed_login_send_sms_message', 'Dear {Name}, your account has been locked. For more details contact us.', 'data');

INSERT INTO `plugin_base_multi_lang` VALUES (NULL, 1, 'pjBaseOption', '::LOCALE::', 'o_forgot_email_subject', 'Password reminder', 'data');
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, 1, 'pjBaseOption', '::LOCALE::', 'o_forgot_email_message', '<p>Dear {Name},</p>\r\n<p>We''ve just received a request to reset your password.</p>\r\n<p>To confirm this process is initiated from you please click the following link:<br /><a href="{URL}">{URL}</a></p>\r\n<p>Otherwise, you don''t need to do anything and ignore this email.</p>\r\n<p>Regards!</p>', 'data');

INSERT INTO `plugin_base_multi_lang` VALUES (NULL, 1, 'pjBaseOption', '::LOCALE::', 'o_forgot_sms_message', 'Reset your password: {URL}', 'data');

INSERT INTO `plugin_base_multi_lang` VALUES (NULL, 1, 'pjBaseOption', '::LOCALE::', 'o_forgot_contact_admin_subject', 'Password reminder was used', 'data');
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, 1, 'pjBaseOption', '::LOCALE::', 'o_forgot_contact_admin_message', '<p>Password reminder was sent to {Name} with email {Email}.</p>', 'data');


INSERT INTO `plugin_base_fields` VALUES (NULL, 'opt_o_forgot_sms_message_text', 'backend', 'Plugin Base / Options / Forgot password SMS message text', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', '<div class="col-xs-6"><p>{Name}</p><p>{Email}</p><p>{Phone}</p><p>{URL}</p></div>', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'opt_o_forgot_contact_admin_message_text', 'backend', 'Plugin Base / Options / Contact admin email message text', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', '<div class="col-xs-6"><p>{Name}</p><p>{Email}</p><p>{Phone}</p><p>{URL}</p></div>', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_choose_action', 'backend', 'Plugin Base / Choose Action', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Choose Action', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_go_to_page', 'backend', 'Plugin Base / Go to page', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Go to page:', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_total_items', 'backend', 'Plugin Base / Total items', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Total items:', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_items_per_page', 'backend', 'Plugin Base / Items per page', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Items per page', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_prev_page', 'backend', 'Plugin Base / Prev page', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Prev page', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_prev', 'backend', 'Plugin Base / Prev', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', '&laquo; Prev', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_next_page', 'backend', 'Plugin Base / Next page', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Next page', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_next', 'backend', 'Plugin Base / Next', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Next &raquo;', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_delete_confirmation', 'backend', 'Plugin Base / Delete confirmation', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete confirmation', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_confirmation_title', 'backend', 'Plugin Base / Confirmation Title', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Are you sure you want to delete selected record?', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_action_title', 'backend', 'Plugin Base / Action Title', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Action confirmation', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_btn_ok', 'backend', 'Plugin Base / Button OK', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'OK', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_btn_cancel', 'backend', 'Plugin Base / Button Cancel', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Cancel', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_btn_delete', 'backend', 'Plugin Base / Button Delete', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Delete', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_empty_result', 'backend', 'Plugin Base / Empty resultset', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'No records found', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_total_prefix', 'backend', 'Plugin Base / of', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'of', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_total_suffix', 'backend', 'Plugin Base / total', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'total', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_show', 'backend', 'Plugin Base / Show', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Show', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_empty_date', 'backend', 'Plugin Base / (empty date)', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', '(empty date)', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_invalid_date', 'backend', 'Plugin Base / (invalid date)', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', '(invalid date)', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_role_arr_ARRAY_1', 'arrays', 'Plugin Base / Administrator', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Administrator', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_role_arr_ARRAY_2', 'arrays', 'Plugin Base / Regular User', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Regular User', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_enum_arr_ARRAY_letters', 'arrays', 'Plugin Base / Letters only', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Letters only', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_enum_arr_ARRAY_digits', 'arrays', 'Plugin Base / Letters only', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Digits only', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_enum_arr_ARRAY_both', 'arrays', 'Plugin Base / Letters only', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Letter & Digits', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_enum_arr_ARRAY_system', 'arrays', 'Plugin Base / System', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'System', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_enum_arr_ARRAY_google', 'arrays', 'Plugin Base / Google', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Google', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_enum_arr_ARRAY_string', 'arrays', 'Plugin Base / String', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'String', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_enum_arr_ARRAY_addition', 'arrays', 'Plugin Base / Addition', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Addition', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_enum_arr_ARRAY_subtraction', 'arrays', 'Plugin Base / Subtraction', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Subtraction', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_enum_arr_ARRAY_random_math', 'arrays', 'Plugin Base / Random math', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Random math', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_action_empty_title', 'backend', 'Plugin Base / No records selected', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'No records selected', 'plugin');

INSERT INTO `plugin_base_fields` VALUES (NULL, 'plugin_base_grid_action_empty_body', 'backend', 'Plugin Base / You need to select at least a single record', 'plugin', NULL);
SET @id := (SELECT LAST_INSERT_ID());
INSERT INTO `plugin_base_multi_lang` VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'You need to select at least a single record', 'plugin');

COMMIT;