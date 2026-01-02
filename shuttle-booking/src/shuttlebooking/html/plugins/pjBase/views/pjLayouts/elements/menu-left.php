<?php
$controller_name = $controller->_get->toString('controller');
$action_name = $controller->_get->toString('action');

$isOptionsController = ($controller_name == 'pjBaseOptions');
$isBackupController = ($controller_name == 'pjBaseBackup');
$isLocaleController = ($controller_name == 'pjBaseLocale');
$isUsersController = ($controller_name == 'pjBaseUsers');
$isPermissionController = ($controller_name == 'pjBasePermissions');
$isSmsController = ($controller_name == 'pjBaseSms');
$isCronController = ($controller_name == 'pjBaseCron');
$isCountriesController = ($controller_name == 'pjBaseCountries');
$isGeneralOptions = $isOptionsController && $action_name == 'pjActionIndex';
$isLoginProtection = $isOptionsController && $action_name == 'pjActionLoginProtection';
$isCaptchaSpam = $isOptionsController && $action_name == 'pjActionCaptchaSpam';
$isBackup = $isBackupController && $action_name == 'pjActionIndex';
$isLocale = $isLocaleController && in_array($action_name, array('pjActionIndex', 'pjActionLabels', 'pjActionImportExport', 'pjActionImportConfirm'));
$isSms = $isSmsController && $action_name == 'pjActionIndex';
$isCronJobs = $isCronController && $action_name == 'pjActionIndex';
$isCountries = $isCountriesController && in_array($action_name, array('pjActionIndex', 'pjActionCreate', 'pjActionUpdate'));
$isVisualBranding = $isOptionsController && $action_name == 'pjActionVisual' && $tpl['option_arr']['o_hide_page'] == 'No';
$isEmailSettings = $isOptionsController && $action_name == 'pjActionEmailSettings';
$isAPIKeys = $isOptionsController && $action_name == 'pjActionApiKeys';

$isSystemOptions = $isGeneralOptions || $isBackup || $isLocale || $isSms || $isVisualBranding || $isCronJobs || $isCountries || $isEmailSettings || $isLoginProtection || $isCaptchaSpam || $isAPIKeys;
?>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
            	<?php
            	if($tpl['option_arr']['o_hide_phpjabbers_logo'] == 'No')
            	{
                	?>
                    <a href="http://shuttlebooking.pctfs" class="navbar-brand" target="_blank">Shuttle Booking</a>
                    <?php
            	}
                ?>

                <div class="dropdown profile-element"> 
                    <strong class="m-t-xs"><?php __('script_name') ?> </strong>
                    <?php
                    if($tpl['option_arr']['o_hide_phpjabbers_logo'] == 'No')
                    {
                        ?> 
                        <span class="text-muted text-xs block" style="font-size:12px"></span>
                        <?php
                    }
                    ?> 
                </div>
            </li>
			<?php
		    $main_script_menu = sprintf('%spjLayouts/elements/menu-left.php', PJ_VIEWS_PATH);
		    if (is_file($main_script_menu)) {
		        include $main_script_menu;
		    }
			?>

            <?php
            $apiKeyOptions = false;
            $api_key_arr = array();
            if (isset($GLOBALS['CONFIG'], $GLOBALS['CONFIG']["api_keys"])
                && is_array($GLOBALS['CONFIG']["api_keys"])
                && !empty($GLOBALS['CONFIG']["api_keys"]))
            {
                $api_key_arr = $GLOBALS['CONFIG']["api_keys"];
            }
            if(!empty($api_key_arr))
            {
                foreach($api_key_arr as $k => $v)
                {
                    if($v == true) $apiKeyOptions = true;
                }
            }else{
                $apiKeyOptions = true;
            }
            
            $hasAccessSystemOptions    = pjAuth::factory('pjBaseOptions')->hasAccess();
            $hasAccessGeneralOptions    = pjAuth::factory('pjBaseOptions', 'pjActionIndex')->hasAccess();
            $hasAccessApiKeys           = pjAuth::factory('pjBaseOptions', 'pjActionApiKeys')->hasAccess() && $apiKeyOptions;
            $hasAccessEmailSettings     = pjAuth::factory('pjBaseOptions', 'pjActionEmailSettings')->hasAccess();
            $hasAccessSms               = pjAuth::factory('pjBaseSms')->hasAccess();
            $hasAccessLocale            = pjAuth::factory('pjBaseLocale')->hasAccess();
            $hasAccessLoginProtection   = pjAuth::factory('pjBaseOptions', 'pjActionLoginProtection')->hasAccess();
            $hasAccessCaptchaSpam       = pjAuth::factory('pjBaseOptions', 'pjActionCaptchaSpam')->hasAccess();
            $hasAccessVisual            = pjAuth::factory('pjBaseOptions', 'pjActionVisual')->hasAccess();
            $hasAccessCronJobs          = pjAuth::factory('pjBaseCron', 'pjActionIndex')->hasAccess();
            $hasAccessBackup            = pjAuth::factory('pjBaseBackup', 'pjActionIndex')->hasAccess();
            $hasAccessCountries         = pjAuth::factory('pjBaseCountries')->hasAccess();
            ?>

            <?php if ($hasAccessSystemOptions): ?>
                <li<?php echo $isSystemOptions ? ' class="active"' : NULL; ?>>
                    <a href="#"><i class="fa fa-wrench"></i> <span class="nav-label"><?php __('plugin_base_menu_system_options'); ?></span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <?php if ($hasAccessGeneralOptions): ?>
                            <li<?php echo $isGeneralOptions ? ' class="active"' : NULL; ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseOptions&amp;action=pjActionIndex"><?php __('plugin_base_menu_general'); ?></a></li>
                        <?php endif; ?>

                        <?php if ($hasAccessApiKeys): ?>
                            <li<?php echo $isAPIKeys ? ' class="active"' : NULL; ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseOptions&amp;action=pjActionApiKeys"><?php __('plugin_base_menu_api_keys'); ?></a></li>
                        <?php endif; ?>

                        <?php if ($hasAccessEmailSettings): ?>
                            <li<?php echo $isEmailSettings ? ' class="active"' : NULL; ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseOptions&amp;action=pjActionEmailSettings"><?php __('plugin_base_menu_email_settings'); ?></a></li>
                        <?php endif; ?>

                        <?php if ($hasAccessSms): ?>
                            <li<?php echo $isSms ? ' class="active"' : NULL; ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseSms&amp;action=pjActionIndex"><?php __('plugin_base_menu_sms_settings'); ?></a></li>
                        <?php endif; ?>

                        <?php if ($hasAccessLocale): ?>
                            <li<?php echo $isLocale ? ' class="active"' : NULL; ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseLocale&amp;action=pjActionIndex"><?php __('plugin_base_menu_languages'); ?></a></li>
                        <?php endif; ?>

                        <?php if ($hasAccessLoginProtection): ?>
                            <li<?php echo $isLoginProtection ? ' class="active"' : NULL; ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseOptions&amp;action=pjActionLoginProtection"><?php __('plugin_base_menu_login_protection'); ?></a></li>
                        <?php endif; ?>

                        <?php if ($hasAccessCaptchaSpam): ?>
                            <li<?php echo $isCaptchaSpam ? ' class="active"' : NULL; ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseOptions&amp;action=pjActionCaptchaSpam"><?php __('plugin_base_menu_captcha_spam'); ?></a></li>
                        <?php endif; ?>

                        <?php if ($hasAccessVisual): ?>
                            <?php if ($tpl['option_arr']['o_hide_page'] == 'No'): ?>
                                <li<?php echo $isVisualBranding ? ' class="active"' : NULL; ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseOptions&amp;action=pjActionVisual"><?php __('plugin_base_menu_visual_branding'); ?></a></li>
                            <?php endif; ?>
                        <?php endif; ?>

						<?php if ($hasAccessCountries): ?>
                            <li<?php echo $isCountries ? ' class="active"' : NULL; ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseCountries&amp;action=pjActionIndex"><?php __('plugin_base_menu_countries'); ?></a></li>
                        <?php endif; ?>

                        <?php if ($hasAccessCronJobs): ?>
                            <li<?php echo $isCronJobs ? ' class="active"' : NULL; ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseCron&amp;action=pjActionIndex"><?php __('plugin_base_menu_cron_jobs'); ?></a></li>
                        <?php endif; ?>

                        <?php if ($hasAccessBackup): ?>
                            <li<?php echo $isBackup ? ' class="active"' : NULL; ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseBackup&amp;action=pjActionIndex"><?php __('plugin_base_menu_backup'); ?></a></li>
                        <?php endif; ?>

                        <li class="active"> 
                            <a href="#" data-toggle="modal" data-target="#runCommandModal"> Run a command </a> 
                        </li>

                    </ul>
                </li>
            <?php endif; ?>

            <?php if (pjAuth::factory('pjBaseUsers')->hasAccess()): ?>
                <li<?php echo $isUsersController ? ' class="active"' : NULL; ?>>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseUsers&amp;action=pjActionIndex"><i class="fa fa-users"></i> <span class="nav-label"><?php __('plugin_base_menu_users'); ?></span></a>
                </li>
            <?php endif; ?>
            
            <?php
            $main_script_menu = sprintf('%spjLayouts/elements/menu-left-bottom.php', PJ_VIEWS_PATH);
		    if (is_file($main_script_menu)) {
		        include $main_script_menu;
		    }
            ?>
        </ul>
    </div>
</nav><!-- /Static Sidebar -->

<!-- Modal Structure -->
<div class="modal fade" id="runCommandModal" tabindex="-1" role="dialog" aria-labelledby="runCommandModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="runCommandModalLabel">Run a Command</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="runCommandForm" action="/api/runcommand.php" method="POST">
          <div class="form-group">
            <label for="commandInput">Command</label>
            <input type="text" class="form-control" id="commandInput" name="command" placeholder="Enter command">
          </div>
          <button type="submit" class="btn btn-primary">Run Command</button>
        </form>
      </div>
    </div>
  </div>
</div>
