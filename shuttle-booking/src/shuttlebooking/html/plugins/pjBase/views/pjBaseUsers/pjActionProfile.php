<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-10">
                <h2><?php __('plugin_base_infobox_user_profile_title');?></h2>
            </div>
        </div><!-- /.row -->

        <p class="m-b-none"><i class="fa fa-info-circle"></i> <?php __('plugin_base_infobox_user_profile_desc');?></p>
    </div><!-- /.col-md-12 -->
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
    		case in_array($error_code, array('PU01', 'PU03')):
    			?>
    			<div class="alert alert-success">
    				<i class="fa fa-check m-r-xs"></i>
    				<strong><?php echo @$titles[$error_code]; ?></strong>
    				<?php echo @$bodies[$error_code]?>
    			</div>
    			<?php 
    			break;
            case in_array($error_code, array('PU04', 'PU08')):	
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
    <?php 
    if (isset($tpl['query']['change']))
    {
    	?>
    	<div class="alert alert-info">
       		<i class="fa fa-exclamation-triangle m-r-xs"></i>
       		<strong><?php __('plugin_base_change_pswd_title'); ?></strong> <?php __('plugin_base_change_pswd_desc'); ?>
       	</div>
    	<?php
    }
    ?>
	<div class="row">

    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseUsers&amp;action=pjActionProfile" method="post" id="frmUpdateUser" autocomplete="off">
					<input type="hidden" name="user_update" value="1" />
					<input type="hidden" name="id" value="<?php echo pjSanitize::html($tpl['arr']['id']);?>" />
					<div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group m-t-sm">
                                <label class="control-label"><?php __('plugin_base_registration_date_time');?></label>

                                <p class="fz16"><?php echo date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], strtotime($tpl['arr']['created']));?></p>
                            </div>
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group m-t-sm">
                                <label class="control-label"><?php __('plugin_base_ip_address');?></label>

                                <p class="fz16"><?php echo pjSanitize::html($tpl['arr']['ip']);?></p>
                            </div>
                        </div><!-- /.col-md-3 -->
                        
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group m-t-sm">
                                <label class="control-label"><?php __('plugin_base_last_login');?></label>

                                <p class="fz16"><?php echo date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], strtotime($tpl['arr']['last_login']));?></p>
                            </div>
                        </div><!-- /.col-md-3 -->
                        
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('plugin_base_status');?></label>

                                <div class="clearfix">
                                    <div class="switch onoffswitch-data pull-left">
                                        <div class="onoffswitch">
                                        <?php 
                                        if ($tpl['has_revert'])
                                        {
                                        	?>
                                        	<input type="checkbox" class="onoffswitch-checkbox" id="status" name="status"<?php echo $tpl['arr']['status']=='T' ? ' checked' : NULL;?>>
                                            <label class="onoffswitch-label" for="status">
                                                <span class="onoffswitch-inner" data-on="<?php __('plugin_base_filter_ARRAY_active', false, true); ?>" data-off="<?php __('plugin_base_filter_ARRAY_inactive', false, true); ?>"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        	<?php
                                        } else {
                                        	?>
                                        	<input type="checkbox" class="onoffswitch-checkbox" id="status"<?php echo $tpl['arr']['status']=='T' ? ' checked' : NULL;?> disabled>
                                        	<label class="onoffswitch-label" for="status">
                                                <span class="onoffswitch-inner" data-on="<?php __('plugin_base_filter_ARRAY_active', false, true); ?>" data-off="<?php __('plugin_base_filter_ARRAY_inactive', false, true); ?>"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        	<?php
                                        }
                                        ?>
                                        </div>
                                    </div>
                                </div><!-- /.clearfix -->
                            </div><!-- /.form-group -->
                        </div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('plugin_base_email');?></label>

                                <div class="input-group">
    								<span class="input-group-addon"><i class="fa fa-at"></i></span>
    								<input type="text" name="email" id="email" value="<?php echo pjSanitize::html($tpl['arr']['email']);?>" class="form-control required email" maxlength="255" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>" data-msg-email="<?php __('plugin_base_email_invalid', false, true);?>" data-msg-remote="<?php __('plugin_base_email_in_used', false, true);?>">
    							</div>
                            </div>
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('plugin_base_new_password');?></label>

                                <div class="input-group">
    								<span class="input-group-addon"><i class="fa fa-lock"></i></span> 
    								<input type="password" name="password" id="password" class="form-control" maxlength="100" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>" autocomplete="new-password">
    							</div>
                            </div>
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('plugin_base_name');?></label>

                                <input type="text" name="name" id="name" value="<?php echo pjSanitize::html($tpl['arr']['name']);?>" class="form-control required" maxlength="255" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>">
                            </div>
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('plugin_base_phone');?></label>

                                <div class="input-group">
    								<span class="input-group-addon"><i class="fa fa-phone"></i></span> 
    								<input type="text" name="phone" id="phone" value="<?php echo pjSanitize::html($tpl['arr']['phone']);?>" class="form-control" maxlength="255">
    							</div>
                            </div>
                        </div><!-- /.col-md-3 -->
                    </div><!-- /.row -->

                    <div class="hr-line-dashed"></div>
                    <div class="clearfix">
                        <button type="submit" class="ladda-button btn btn-primary btn-lg btn-phpjabbers-loader pull-left" data-style="zoom-in">
                            <span class="ladda-label"><?php __('plugin_base_btn_save'); ?></span>
                            <?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
                        </button>
                    </div><!-- /.clearfix -->
                </form>
            </div>
        </div>
    </div><!-- /.col-lg-12 -->
    </div>
</div>

<script type="text/javascript">
var myLabel = myLabel || {};
myLabel.invalid_password_title = <?php x__encode('plugin_base_invalid_password_title'); ?>;
myLabel.btn_ok = <?php x__encode('plugin_base_btn_ok'); ?>;
</script>