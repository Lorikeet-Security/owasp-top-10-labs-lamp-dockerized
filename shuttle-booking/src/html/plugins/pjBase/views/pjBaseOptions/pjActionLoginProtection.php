<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-lg-9 col-md-8 col-sm-6">
                <h2><?php __('plugin_base_infobox_login_protection_title');?></h2>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 btn-group-languages">
                <?php if ($tpl['is_flag_ready']) : ?>
				<div class="multilang"></div>
				<?php endif; ?>
        	</div>
		</div>
		<p class="m-b-none"><i class="fa fa-info-circle"></i><?php __('plugin_base_infobox_login_protection_desc'); ?></p>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<?php
	$error_code = $controller->_get->toString('err');
	if (!empty($error_code))
    {
    	$titles = __('plugin_base_error_titles', true);
    	$bodies = __('plugin_base_error_bodies', true);
    	switch (true)
    	{
    		case in_array($error_code, array('PBS04')):
    			?>
    			<div class="alert alert-success">
    				<i class="fa fa-check m-r-xs"></i>
    				<strong><?php echo @$titles[$error_code]; ?></strong>
    				<?php echo @$bodies[$error_code]?>
    			</div>
    			<?php 
    			break;
    		case in_array($error_code, array('')):	
    			?>
    			<div class="alert alert-danger">
    				<i class="fa fa-exclamation-triangle m-r-xs"></i>
    				<strong><?php echo @$titles[$error_code]; ?></strong>
    				<?php echo @$bodies[$error_code]?>
    			</div>
    			<?php
    			break;
    	}
    }
    
    $haveSmsApiKey = isset($tpl['option_arr']['plugin_sms_api_key']) && !empty($tpl['option_arr']['plugin_sms_api_key']);
    ?>
    <div class="row">
    	<div class="col-lg-12">
    		<div class="ibox float-e-margins">
    			<div class="ibox-content">
    				<?php
                    if (!$tpl['has_access_password'] && !$tpl['has_access_secure_login'] && !$tpl['has_access_failed_login'] && !$tpl['has_access_forgot'])
                    {
                        ?>
                        <h3 class="font-bold"><?php __('plugin_base_access_denied_title'); ?></h3>
                        <div class="error-desc">
                            <?php __('plugin_base_access_denied_desc'); ?>
                        </div>
                        <?php
                    }
    				elseif (isset($tpl['arr']))
    				{
    				    if (is_array($tpl['arr']))
    				    {
    				        $count = count($tpl['arr']);
    				        if ($count > 0)
    				        {
                                ?>
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseOptions&amp;action=pjActionOptionsUpdate" 
                                	method="post" class="form-horizontal" id="frmLoginProtection" data-sms-ready="<?php echo (int) $haveSmsApiKey; ?>">
                    				<input type="hidden" name="options_update" value="1" />
                    				<input type="hidden" name="next_action" value="pjActionLoginProtection" />
                    				<?php
                    				for ($i = 0; $i < $count; $i++)
                    				{
                    				    if (in_array(@$tpl['arr'][$i]['key'], array('o_password_change_every_unit', 'o_failed_login_disbale_form_unit', 'o_failed_login_disable_form_after', 'o_failed_login_send_email_subject', 'o_failed_login_send_sms_after',
                    				    	'o_secure_login_2factor_auth', 'o_secure_login_send_password_to', 'o_secure_login_send_password_to_email_subject', 'o_secure_login_send_password_to_email_message',
                    				    )))
                    				    {
                    				        continue;
                    				    }
                    				    $rowClass = NULL;
                    				    $rowStyle = NULL;
                    				    if (in_array(@$tpl['arr'][$i]['key'], array('o_secure_login_send_password_to')))
                    				    {
                    				        $rowClass = " boxTwoFactor";
                    				        $rowStyle = "display: none";
                    				        switch ($tpl['option_arr']['o_secure_login_2factor_auth'])
                    				        {
                    				            case 'Yes':
                    				                $rowStyle = NULL;
                    				                break;
                    				        }
                    				    }
                    				    if (in_array(@$tpl['arr'][$i]['key'], array('o_secure_login_send_password_to_email_subject', 'o_secure_login_send_password_to_email_message')))
                    				    {
                    				        $rowClass = " boxTwoFactorEmail";
                    				        $rowStyle = "display: none";
                    				        if ($tpl['option_arr']['o_secure_login_2factor_auth'] == 'Yes' && $tpl['option_arr']['o_secure_login_send_password_to'] == 'email')
                    				        {
                    				            $rowStyle = NULL;
                    				        }
                    				    }
                    				    if (in_array(@$tpl['arr'][$i]['key'], array('o_secure_login_send_password_to_sms_message')))
                    				    {
                    				        $rowClass = " boxTwoFactorSMS";
                    				        $rowStyle = "display: none";
                    				        if ($tpl['option_arr']['o_secure_login_2factor_auth'] == 'Yes' && $tpl['option_arr']['o_secure_login_send_password_to'] == 'sms')
                    				        {
                    				            $rowStyle = NULL;
                    				        }
                    				    }
                    				    
                    				    if (@$tpl['arr'][$i]['key'] == 'o_failed_login_send_sms_after' && !$haveSmsApiKey)
                    				    {
                    				    	?>
                    				    	<div class="form-group">
                    				    		<div class="col-sm-9 col-sm-offset-3 no-margins">
                    				    			<div class="alert alert-warning" role="alert"><i class="fa fa-warning m-r-xs"></i></div>
                    				    		</div>
                    				    	</div>
                    				    	<?php
										}
                    				    
                    				    if(@$tpl['arr'][$i]['key'] == 'o_password_min_length')
                    				    {
                    				        if ($tpl['has_access_password'])
                                            {
                                                ?>
                                                <div class="m-t-sm m-b-sm">
                                                    <h2><?php __('plugin_base_options_password_title');?></h2>

                                                    <p class="alert alert-info alert-with-icon m-t-xs"><i class="fa fa-info-circle"></i> <?php __('plugin_base_options_password_desc');?></p>
                                                </div>
                                                <?php
                                            }
                    				    }else if(@$tpl['arr'][$i]['key'] == 'o_secure_login_use_captcha'){
                    				        if ($tpl['has_access_secure_login'])
                                            {
                                                ?>
                                                <?php if ($tpl['has_access_password']): ?>
                                                    <div class="hr-line-dashed"></div>
                                                	<div class="form-group m-b-none">
                                                		<div class="col-sm-9 col-sm-offset-3">
                                                			<button type="submit" class="ladda-button btn btn-primary btn-lg btn-phpjabbers-loader" data-style="zoom-in">
                	                                            <span class="ladda-label"><?php __('plugin_base_btn_save'); ?></span>
                	                                            <?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
                	                                        </button>
                                                		</div>
                                                	</div>
                                                <?php endif; ?>
                                                <div class="m-t-sm m-b-sm">
                                                    <h2><?php __('plugin_base_options_secure_login_title');?></h2>

                                                    <p class="alert alert-info alert-with-icon m-t-xs"><i class="fa fa-info-circle"></i> <?php __('plugin_base_options_secure_login_desc');?></p>
                                                </div>
                                                <?php
                                            }
                    				    }else if(@$tpl['arr'][$i]['key'] == 'o_failed_login_lock_after'){
                    				        if ($tpl['has_access_failed_login'])
                                            {
                                                ?>
                                                <?php if ($tpl['has_access_password'] || $tpl['has_access_secure_login']): ?>
                                                	<div class="hr-line-dashed"></div>
                                                	<div class="form-group m-b-none">
                                                		<div class="col-sm-9 col-sm-offset-3">
                                                			<button type="submit" class="ladda-button btn btn-primary btn-lg btn-phpjabbers-loader" data-style="zoom-in">
                	                                            <span class="ladda-label"><?php __('plugin_base_btn_save'); ?></span>
                	                                            <?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
                	                                        </button>
                                                		</div>
                                                	</div>
                                                <?php endif; ?>
                                                <div class="m-t-sm m-b-sm">
                                                    <h2><?php __('plugin_base_options_failed_login_title');?></h2>

                                                    <p class="alert alert-info alert-with-icon m-t-xs"><i class="fa fa-info-circle"></i> <?php __('plugin_base_options_failed_login_desc');?></p>
                                                </div>
                                                <?php
                                            }
                    				    }else if(@$tpl['arr'][$i]['key'] == 'o_forgot_email_confirmation'){
                    				        if ($tpl['has_access_forgot'])
                                            {
                                                ?>
                                                <?php if ($tpl['has_access_password'] || $tpl['has_access_secure_login'] || $tpl['has_access_failed_login']): ?>
                                                    <div class="hr-line-dashed"></div>
                                                    <div class="form-group m-b-none">
                                                		<div class="col-sm-9 col-sm-offset-3">
                                                			<button type="submit" class="ladda-button btn btn-primary btn-lg btn-phpjabbers-loader" data-style="zoom-in">
                	                                            <span class="ladda-label"><?php __('plugin_base_btn_save'); ?></span>
                	                                            <?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
                	                                        </button>
                                                		</div>
                                                	</div>
                                                <?php endif; ?>
                                                <div class="m-t-sm m-b-sm">
                                                    <h2><?php __('plugin_base_options_forgot_password_title');?></h2>

                                                    <p class="alert alert-info alert-with-icon m-t-xs"><i class="fa fa-info-circle"></i> <?php __('plugin_base_options_forgot_password_desc');?></p>
                                                </div>
                                                <?php
                                            }
                    				    }
                    				    elseif (in_array(@$tpl['arr'][$i]['key'], array('o_forgot_email_subject', 'o_forgot_email_message')))
                    				    {
                    				        $rowClass = " boxForgotEmail";
                    				        $rowStyle = "display: none";
                    				        if ($tpl['option_arr']['o_forgot_email_confirmation'] == 'Yes')
                    				        {
                    				            $rowStyle = NULL;
                    				        }
                    				    }
                    				    elseif (in_array(@$tpl['arr'][$i]['key'], array('o_forgot_sms_message')))
                    				    {
                    				        $rowClass = " boxForgotSMS";
                    				        $rowStyle = "display: none";
                    				        if ($tpl['option_arr']['o_forgot_sms_confirmation'] == 'Yes')
                    				        {
                    				            $rowStyle = NULL;
                    				        }
                    				    }elseif (in_array(@$tpl['arr'][$i]['key'], array('o_forgot_contact_admin_message', 'o_forgot_contact_admin_subject')))
                    				    {
                    				        $rowClass = " boxContactAdminEmail";
                    				        $rowStyle = "display: none";
                    				        if ($tpl['option_arr']['o_forgot_contact_admin'] == 'Yes')
                    				        {
                    				            $rowStyle = NULL;
                    				        }
                    				    }elseif (in_array(@$tpl['arr'][$i]['key'], array('o_failed_login_send_email_after', 'o_failed_login_send_email_subject', 'o_failed_login_send_email_message'))){
                    				        $rowClass = " boxLoginFailedEmail";
                    				        $rowStyle = "display: none";
                    				        if ($tpl['option_arr']['o_failed_login_send_email'] == 'Yes')
                    				        {
                    				            $rowStyle = NULL;
                    				        }
                    				    }elseif (in_array(@$tpl['arr'][$i]['key'], array('o_failed_login_send_sms_message')))
                    				    {
                    				        $rowClass = " boxLoginFailedSMS";
                    				        $rowStyle = "display: none";
                    				        if ($tpl['option_arr']['o_failed_login_send_sms'] == 'Yes')
                    				        {
                    				            $rowStyle = NULL;
                    				        }
                    				    }
                        				?>

                                        <?php if (
                                            (!is_null(@$tpl['arr'][$i]['key']) && strpos(@$tpl['arr'][$i]['key'], 'o_password_') !== false && $tpl['has_access_password']) ||
                                            (!is_null(@$tpl['arr'][$i]['key']) && strpos(@$tpl['arr'][$i]['key'], 'o_secure_login_') !== false && $tpl['has_access_secure_login']) ||
                                            (!is_null(@$tpl['arr'][$i]['key']) && strpos(@$tpl['arr'][$i]['key'], 'o_failed_login_') !== false && $tpl['has_access_failed_login']) ||
                                            (!is_null(@$tpl['arr'][$i]['key']) && strpos(@$tpl['arr'][$i]['key'], 'o_forgot_') !== false && $tpl['has_access_forgot'])
                                        ): ?>
                                        <?php if(@$tpl['arr'][$i]['key'] == 'o_failed_login_send_email_message'): ?>
                                            <div class="form-group<?php echo $rowClass; ?>" style="<?php echo $rowStyle; ?>">
                                                <label class="col-sm-3 control-label"><?php __('plugin_base_opt_o_failed_login_send_email_subject'); ?></label>
                                                <div class="col-sm-9">
                                                    <div class="row">
                                                        <div class="col-md-7">
                                                            <?php 
                                							foreach ($tpl['lp_arr'] as $v)
                                							{
                                								?>
                                								<div class="<?php echo $tpl['is_flag_ready'] ? 'input-group' : NULL;?> pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 1 ? '' : 'none'; ?>">
                                									<input type="text" name="i18n[<?php echo $v['id']; ?>][o_failed_login_send_email_subject]" class="form-control" value="<?php echo pjSanitize::html(@$tpl['arr']['i18n'][$v['id']]['o_failed_login_send_email_subject']); ?>">
                                									<?php if ($tpl['is_flag_ready']) : ?>
                                									<span class="input-group-addon pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="<?php echo pjSanitize::html($v['name']); ?>"></span>
                                									<?php endif; ?>
                                								</div>
                                								<?php
                                							}
                                							?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                        				<div class="form-group<?php echo $rowClass; ?>" style="<?php echo $rowStyle; ?>">
                                        	<label class="col-sm-3 control-label"><?php __('plugin_base_opt_' . $tpl['arr'][$i]['key']); ?></label>
                                        	<div class="col-sm-9">
                                        		<?php
                                        		switch ($tpl['arr'][$i]['type'])
                                        		{
                                        			case 'string':
                                        			    if (in_array($tpl['arr'][$i]['key'], array('o_secure_login_send_password_to_email_subject', 'o_forgot_email_subject', 'o_forgot_contact_admin_subject'))) {
                                        			        ?>
                                                            <div class="row">
                                                                <div class="col-md-7">
                                                                    <?php 
                                        							foreach ($tpl['lp_arr'] as $v)
                                        							{
                                        								?>
                                        								<div class="<?php echo $tpl['is_flag_ready'] ? 'input-group' : NULL;?> pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 1 ? '' : 'none'; ?>">
                                        									<input type="text" name="i18n[<?php echo $v['id']; ?>][<?php echo $tpl['arr'][$i]['key'] ?>]" class="form-control" value="<?php echo pjSanitize::html(@$tpl['arr']['i18n'][$v['id']][$tpl['arr'][$i]['key']]); ?>">
                                        									<?php if ($tpl['is_flag_ready']) : ?>
                                        									<span class="input-group-addon pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="<?php echo pjSanitize::html($v['name']); ?>"></span>
                                        									<?php endif; ?>
                                        								</div>
                                        								<?php
                                        							}
                                        							?>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        } else {
                                                            ?><input type="text" name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="form-control" value="<?php echo pjSanitize::html($tpl['arr'][$i]['value']); ?>"><?php
                                                        }
                                        				break;
                                        			case 'text':
                                        			    if (in_array($tpl['arr'][$i]['key'], array('o_failed_login_send_email_message', 'o_secure_login_send_password_to_email_message', 'o_forgot_email_message', 'o_forgot_contact_admin_message'))) {
                                                            ?>
                                                            <div class="row">
                                        						<div class="col-md-7 mce-md">
                                                                    <?php 
                                        							foreach ($tpl['lp_arr'] as $v)
                                        							{
                                        								?>
                                        								<div class="<?php echo $tpl['is_flag_ready'] ? 'input-group' : NULL;?> pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 1 ? '' : 'none'; ?>">
                                        									<textarea name="i18n[<?php echo $v['id']; ?>][<?php echo $tpl['arr'][$i]['key'] ?>]" class="form-control mceEditor" style="width: 100%; height: 260px;"><?php echo pjSanitize::html(@$tpl['arr']['i18n'][$v['id']][$tpl['arr'][$i]['key']]); ?></textarea>
                                        									<?php if ($tpl['is_flag_ready']) : ?>
                                        									<span class="input-group-addon pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="<?php echo pjSanitize::html($v['name']); ?>"></span>
                                        									<?php endif; ?>
                                        								</div>
                                        								<?php
                                        							}
                                        							?>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <h3 class="m-b-md"><?php __('plugin_base_available_tokens') ?>:</h3>

                                                                    <div class="row">
                                                                        <?php echo __("opt_{$tpl['arr'][$i]['key']}_text") ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                        			    }elseif (in_array($tpl['arr'][$i]['key'], array('o_failed_login_send_sms_message', 'o_secure_login_send_password_to_sms_message', 'o_forgot_sms_message'))) {
                                        			    	
                                        			    	if (in_array($tpl['arr'][$i]['key'], array('o_failed_login_send_sms_message', 'o_forgot_sms_message')))
                                        			    	{
                                        			    		?>
                                        			        	<div class="alert alert-warning alert-with-icon<?php echo $haveSmsApiKey ? ' hidden' : NULL; ?>" role="alert"><i class="fa fa-warning m-r-xs"></i><?php __('plugin_base_sms_warning'); ?></div>
	                                        			        <?php
                                        					}
                                        			    	
                                                            ?>
                                                            <div class="row">
                                        						<div class="col-md-7">
                                                                   <?php 
                                        							foreach ($tpl['lp_arr'] as $v)
                                        							{
                                        								?>
                                        								<div class="<?php echo $tpl['is_flag_ready'] ? 'input-group' : NULL;?> pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 1 ? '' : 'none'; ?>">
                                        									<textarea name="i18n[<?php echo $v['id']; ?>][<?php echo $tpl['arr'][$i]['key'] ?>]" class="form-control" rows="10"><?php echo pjSanitize::html(@$tpl['arr']['i18n'][$v['id']][$tpl['arr'][$i]['key']]); ?></textarea>
                                        									<?php if ($tpl['is_flag_ready']) : ?>
                                        									<span class="input-group-addon pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="<?php echo pjSanitize::html($v['name']); ?>"></span>
                                        									<?php endif; ?>
                                        								</div>
                                        								<?php
                                        							}
                                        							?>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <h3 class="m-b-md"><?php __('plugin_base_available_tokens') ?>:</h3>

                                                                    <div class="row">
                                                                        <?php echo __("opt_{$tpl['arr'][$i]['key']}_text") ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                        				    ?><textarea name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="form-control"><?php echo pjSanitize::html($tpl['arr'][$i]['value']); ?></textarea><?php
                                        			    }
                                        				break;
                                        			case 'int':
                                        			    if (in_array($tpl['arr'][$i]['key'], array('o_password_min_length', 'o_password_change_every', 'o_failed_login_lock_after', 'o_failed_login_disable_form', 'o_failed_login_required_captcha_after', 'o_failed_login_send_email_after', 'o_failed_login_send_sms_after'))) 
                                        			    {
                                        			        ?>
                                        			        <div class="row">
                                        						<div class="col-md-3">
                                        							<input type="text" name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="form-control field-int" value="<?php echo pjSanitize::html($tpl['arr'][$i]['value']); ?>">
                                        						</div>
                                            			        <?php
                                            			        if($tpl['arr'][$i]['key'] == 'o_password_change_every')
                                            			        {
                                            			            ?>
                                            			            <div class="col-md-3">
                                                			            <select name="value-enum-o_password_change_every_unit" class="form-control" aria-invalid="false">
                                                			            	<?php
                                    										$default = explode("::", $tpl['o_arr']['o_password_change_every_unit']['value']);
                                    										$enum = explode("|", $default[0]);
                                    										$enumLabels = array();
                                    										$password_every = __('plugin_base_password_every', true);
                                    										$enumLabels = array($password_every['days'], $password_every['weeks'], $password_every['months']);
                                    										if (empty($enumLabels) && !empty($tpl['o_arr']['o_password_change_every_unit']['label']) && strpos($tpl['o_arr']['o_password_change_every_unit']['label'], "|") !== false)
                                    										{
                                    											$enumLabels = explode("|", $tpl['o_arr']['o_password_change_every_unit']['label']);
                                    										}
                                    										foreach ($enum as $k => $el)
                                    										{
                                    											?><option value="<?php echo $default[0].'::'.$el; ?>"<?php echo $default[1] == $el ? ' selected="selected"' : NULL; ?>><?php echo array_key_exists($k, $enumLabels) ? pjSanitize::html($enumLabels[$k]) : pjSanitize::html($el); ?></option><?php
                                    										}
                                    										?>
            															</select>
            														</div>
                                            			            <?php
                                            			        }
                                            			        if($tpl['arr'][$i]['key'] == 'o_failed_login_disable_form')
                                            			        {
                                            			            ?>
                                            			            <div class="col-md-3">
                                                			            <select name="value-enum-o_failed_login_disbale_form_unit" class="form-control" aria-invalid="false">
                                                			            	<?php
                                    										$default = explode("::", $tpl['o_arr']['o_failed_login_disbale_form_unit']['value']);
                                    										$enum = explode("|", $default[0]);
                                    										$enumLabels = array();
                                    										$enum_arr = __('plugin_base_enum_disable_units', true);
                                    										$enumLabels = array($enum_arr['minutes'], $enum_arr['hours'], $enum_arr['days'], $enum_arr['weeks'], $enum_arr['months']);
                                    										if (empty($enumLabels) && !empty($tpl['o_arr']['o_failed_login_disbale_form_unit']['label']) && strpos($tpl['o_arr']['o_failed_login_disbale_form_unit']['label'], "|") !== false)
                                    										{
                                    											$enumLabels = explode("|", $tpl['o_arr']['o_failed_login_disbale_form_unit']['label']);
                                    										}
                                    										foreach ($enum as $k => $el)
                                    										{
                                    											?><option value="<?php echo $default[0].'::'.$el; ?>"<?php echo $default[1] == $el ? ' selected="selected"' : NULL; ?>><?php echo array_key_exists($k, $enumLabels) ? pjSanitize::html($enumLabels[$k]) : pjSanitize::html($el); ?></option><?php
                                    										}
                                    										?>
            															</select>
            														</div>
            														<div class="col-md-3">
                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                <p class="m-t-xs"><?php __('plugin_base_label_after');?></p>
                                                                            </div><!-- /.col-md-3 -->
                            
                                                                            <div class="col-md-9">
                                                                                <input type="text" name="value-enum-o_failed_login_disable_form_after" class="form-control field-int" value="<?php echo pjSanitize::html($tpl['o_arr']['o_failed_login_disable_form_after']['value']); ?>">
                                                                            </div><!-- /.col-md-9 -->
                                                                        </div><!-- /.row -->
                                                                    </div><!-- /.col-md-4 -->
                                                                    <div class="col-md-3">
                                                                        <p class="m-t-xs"><?php __('plugin_base_failed_login_attempts');?></p>
                                                                    </div><!-- /.col-md-4 -->
                                            			            <?php
                                            			        }
                                            			        if (in_array($tpl['arr'][$i]['key'], array('o_failed_login_lock_after', 'o_failed_login_required_captcha_after', 'o_failed_login_send_email_after', 'o_failed_login_send_sms_after')))
                                            			        {
                                            			            ?><p class="m-t-xs"><?php __('plugin_base_failed_login_attempts');?></p><?php
                                            			        }
                                            			        ?>
                                        			        </div>
                                        			        <?php
                                        			    }else{
                                        				    ?><input type="text" name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="form-control field-int" value="<?php echo pjSanitize::html($tpl['arr'][$i]['value']); ?>"><?php
                                        			    }
                                        				break;
                                        			case 'float':
                                        				?><input type="text" name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="form-control field-float number" value="<?php echo number_format($tpl['arr'][$i]['value'], 2) ?>"><?php
                                        				break;
                                        			case 'enum':
                                        			    if (in_array($tpl['arr'][$i]['key'], array('o_password_chars_used', 'o_secure_login_send_password_to')))
                                        			    {
                                        			        ?>
                                        			        <div class="row">
                                        						<div class="col-md-3">
                                        							<?php include dirname(__FILE__) . '/elements/enum.php';?>
                                        						</div>
                                        					</div>
                                        					<?php 
                                        					if (in_array($tpl['arr'][$i]['key'], array('o_secure_login_send_password_to')))
                                        					{
	                                        					?>
	                                        					<div class="m-t-sm box-sms-warning<?php echo $haveSmsApiKey ? ' hidden' : NULL; ?>">
	                                        			        	<div class="alert alert-warning alert-with-icon no-margins" role="alert"><i class="fa fa-warning m-r-xs"></i><?php __('plugin_base_sms_warning'); ?></div>
	                                        			        </div>
	                                        			        <?php
                                        					}
                                        			    }else if(in_array($tpl['arr'][$i]['key'], array('o_password_special_symbol', 'o_password_capital_letter', 
                                        			        'o_secure_login_use_captcha', 'o_secure_login_1_active_login', 'o_secure_login_2factor_auth',
                                        			        'o_forgot_email_confirmation','o_forgot_contact_admin','o_forgot_use_captcha','o_forgot_sms_confirmation',
                                        			        'o_failed_login_send_email', 'o_failed_login_send_sms'
                                        			    ))){
                                        			        include dirname(__FILE__) . '/elements/switch.php';
                                        			    }else{
                                        			        include dirname(__FILE__) . '/elements/enum.php';
                                        			    }
                                        				break;
                                        		}
                                        		?>
                                        	</div>
                                        </div>
                                        <?php endif; ?>
                                        <?php
                    				}
                                    ?>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group m-b-none">
                                    	<div class="col-sm-9 col-sm-offset-3">
	                						<button class="ladda-button btn btn-primary btn-lg btn-phpjabbers-loader" data-style="zoom-in">
	                                            <span class="ladda-label"><?php __('plugin_base_btn_save'); ?></span>
	                                            <?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
	                                        </button>
                                        </div>
                    				</div>
                    			</form>
                                <?php    				            
    				        }
    				    }
    				}
    				?>
    			</div><!-- /.ibox-content -->
    		</div><!-- /.ibox float-e-margins -->
    	</div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.wrapper wrapper-content animated fadeInRight -->

<?php if ($tpl['is_flag_ready']) : ?>
<script type="text/javascript">
var myLabel = myLabel || {};
var pjCmsLocale = pjCmsLocale || {};
pjCmsLocale.langs = <?php echo $tpl['locale_str']; ?>;
pjCmsLocale.flagPath = "<?php echo PJ_FRAMEWORK_LIBS_PATH; ?>pj/img/flags/";
myLabel.localeId = "<?php echo $controller->getLocaleId(); ?>";
</script>
<?php endif; ?>