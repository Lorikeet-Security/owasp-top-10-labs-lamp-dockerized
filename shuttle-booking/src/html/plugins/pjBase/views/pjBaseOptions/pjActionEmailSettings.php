<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-10">
				<h2><?php __('plugin_base_infobox_email_settings_title'); ?></h2>
			</div>
		</div>
		<p class="m-b-none"><i class="fa fa-info-circle"></i><?php __('plugin_base_infobox_email_settings_desc'); ?></p>
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
    		case in_array($error_code, array('PBS03')):
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
    ?>
    <div class="row">
    	<div class="col-lg-12">
    		<div class="ibox float-e-margins">
    			<div class="ibox-content">
    				<?php
    				if (isset($tpl['arr']) && is_array($tpl['arr']) && !empty($tpl['arr']))
    				{
                        ?>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseOptions&amp;action=pjActionOptionsUpdate" method="post" class="form-horizontal" id="frmEmailSettings">
                            <input type="hidden" name="options_update" value="1" />
                            <input type="hidden" name="next_action" value="pjActionEmailSettings" />
                            <input type="hidden" name="email" value="" />
                            <?php
                            foreach ($tpl['arr'] as $i => $option)
                            {
                            	if ($option['key'] == 'o_smtp_sender') continue;
                                $rowClass = $attrSenderEmail = $requiredClass = NULL;
                                if (in_array($option['key'], array('o_smtp_host', 'o_smtp_port', 'o_smtp_user', 'o_smtp_pass', 'o_smtp_auth', 'o_smtp_secure', 'o_smtp_sender', 'o_smtp_seder_email_same_as_username')))
                                {
                                    $rowClass = " boxSmtp hidden";
                                    switch ($tpl['option_arr']['o_send_email'])
                                    {
                                        case 'smtp':
                                        	$rowClass = " boxSmtp";
                                            break;
                                    }
                                }
                                if ($tpl['option_arr']['o_send_email'] == 'smtp' && $option['key'] == 'o_sender_email' && $tpl['option_arr']['o_smtp_seder_email_same_as_username'] == 'Yes') {
                                	$attrSenderEmail = ' readonly="readonly"';
                                }
                                if (in_array($option['key'], array('o_smtp_host', 'o_smtp_port', 'o_smtp_user'))) {
                                	$requiredClass = ' smtpRequiredFields';	
                                }
                                if ($tpl['option_arr']['o_send_email'] == 'smtp' || $option['key'] == 'o_sender_email') {
                                	$requiredClass .= ' required';	
                                }
                                ?>
                                <div class="form-group<?php echo $rowClass; ?>">

                                    <label class="col-sm-3 control-label"><?php __('plugin_base_opt_' . $option['key']); ?></label>
                                    <div class="col-sm-9">
                                        <?php
                                        switch ($option['type'])
                                        {
                                            case 'string':
                                                ?><input type="text" <?php echo $attrSenderEmail;?> name="value-<?php echo $option['type']; ?>-<?php echo $option['key']; ?>" class="form-control <?php echo $requiredClass;?> <?php echo $option['key'] == 'o_sender_email'? ' email': null; ?>" value="<?php echo pjSanitize::html($option['value']); ?>" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>" data-msg-email="<?php __('plugin_base_email_invalid', false, true);?>"><?php
                                                break;
                                            case 'text':
                                                ?><textarea name="value-<?php echo $option['type']; ?>-<?php echo $option['key']; ?>" class="form-control"><?php echo pjSanitize::html($option['value']); ?></textarea><?php
                                                break;
                                            case 'int':
                                                ?><input type="text" name="value-<?php echo $option['type']; ?>-<?php echo $option['key']; ?>" class="form-control field-int" value="<?php echo pjSanitize::html($option['value']); ?>"><?php
                                                break;
                                            case 'float':
                                                ?><input type="text" name="value-<?php echo $option['type']; ?>-<?php echo $option['key']; ?>" class="form-control field-float number" value="<?php echo number_format($option['value'], 2) ?>"><?php
                                                break;
                                            case 'enum':
                                            	if (in_array($option['key'], array('o_smtp_seder_email_same_as_username'))) {
                                            		include dirname(__FILE__) . '/elements/switch.php';
                                            	} else { 
	                                                ?><select name="value-<?php echo $option['type']; ?>-<?php echo $option['key']; ?>" class="form-control">
	                                                <?php
	                                                $default = explode("::", $option['value']);
	                                                $enum = explode("|", $default[0]);
	
	                                                $enumLabels = array();
	                                                if ($option['key'] == 'o_currency_place') {
	                                                    $currency_places = __('plugin_base_currency_places', true);
	                                                    $enumLabels = array($currency_places['front'], $currency_places['back']);
	                                                } else {
	                                                    if (!empty($option['label']) && strpos($option['label'], "|") !== false)
	                                                    {
	                                                        $enumLabels = explode("|", $option['label']);
	                                                    }
	                                                }
	                                                foreach ($enum as $k => $el)
	                                                {
	                                                    if ($default[1] == $el)
	                                                    {
	                                                        ?><option value="<?php echo $default[0].'::'.$el; ?>" selected="selected"><?php echo array_key_exists($k, $enumLabels) ? pjSanitize::html($enumLabels[$k]) : pjSanitize::html($el); ?></option><?php
	                                                    } else {
	                                                        ?><option value="<?php echo $default[0].'::'.$el; ?>"><?php echo array_key_exists($k, $enumLabels) ? pjSanitize::html($enumLabels[$k]) : pjSanitize::html($el); ?></option><?php
	                                                    }
	                                                }
                                            	}
                                                ?>
                                                </select>
                                                <?php
                                                break;
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-md-offset-4 col-lg-9 col-md-8">
                                    <button type="button" class="btn btn-primary btn-outline btnTestConnection boxSmtp<?php echo $tpl['option_arr']['o_send_email'] == 'mail' ? ' hidden' : NULL; ?>"><i class="fa fa-exchange m-r-xs"></i><?php __('plugin_base_test_connection');?></button>
                                    <button type="button" class="btn btn-primary btn-outline btnSendTestEmail"><i class="fa fa-envelope m-r-xs"></i><?php __('plugin_base_send_test_email');?></button>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="clearfix">
                                <button type="submit" class="ladda-button btn btn-primary btn-lg pull-left btn-phpjabbers-loader" data-style="zoom-in">
                                    <span class="ladda-label"><?php __('plugin_base_btn_save'); ?></span>
                                    <?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
                                </button>
                            </div>
                        </form>
                        <?php
    				}
    				?>
    			</div><!-- /.ibox-content -->
    		</div><!-- /.ibox float-e-margins -->
    	</div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.wrapper wrapper-content animated fadeInRight -->

<script type="text/javascript">
var myLabel = myLabel || {};

myLabel.test_smtp_title = <?php x__encode('plugin_base_test_smtp_title'); ?>;
myLabel.test_smtp_text = <?php x__encode('plugin_base_test_smtp_text'); ?>;
myLabel.send_test_email_title = <?php x__encode('plugin_base_send_test_email_title'); ?>;
myLabel.send_test_email_text = <?php x__encode('plugin_base_send_test_email_text'); ?>;
myLabel.send_test_email_address = <?php x__encode('plugin_base_send_test_email_address'); ?>;
myLabel.send_test_swal_error_title = <?php x__encode('plugin_base_send_test_swal_error_title'); ?>;
myLabel.send_test_swal_msg_title = <?php x__encode('plugin_base_send_test_swal_smg_title'); ?>;
myLabel.send_test_swal_success_title = <?php x__encode('plugin_base_send_test_swal_success_title'); ?>;
myLabel.ajax_error_msg = <?php x__encode('plugin_base_ajax_error'); ?>;
myLabel.check_smtp_connection_title = <?php x__encode('plugin_base_check_smtp_connection_title'); ?>;
myLabel.check_smtp_connection_text = <?php x__encode('plugin_base_check_smtp_connection_text'); ?>;
myLabel.btn_yes_connect = <?php x__encode('plugin_base_btn_yes_connect'); ?>;
myLabel.btn_send_email = <?php x__encode('plugin_base_btn_send_email'); ?>;
myLabel.btn_cancel = <?php x__encode('plugin_base_btn_cancel'); ?>;
myLabel.btn_ok = <?php x__encode('plugin_base_btn_ok'); ?>;
</script>