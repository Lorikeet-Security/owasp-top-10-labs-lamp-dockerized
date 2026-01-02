<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-10">
                <h2><?php __('plugin_base_infobox_sms_settings_title');?></h2>
            </div>
        </div><!-- /.row -->

        <p class="m-b-none"><i class="fa fa-info-circle"></i> <?php __('plugin_base_infobox_sms_settings_desc');?></p>
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
    		case in_array($error_code, array('PSS01')):
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
    <div class="tabs-container tabs-reservations m-b-lg">
        <ul class="nav nav-tabs" role="tablist">
            <?php if ($tpl['has_access_settings']): ?>
                <li role="presentation" class="active"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="true"><?php __('plugin_base_sms_tab_settings');?></a></li>
            <?php endif; ?>
            <?php if ($tpl['has_access_list']): ?>
                <li role="presentation" class="<?php echo $tpl['has_access_settings']? null: 'active'; ?>"><a href="#message-sent" aria-controls="message-sent" role="tab" data-toggle="tab" aria-expanded="false"><?php __('plugin_base_sms_tab_messages_sent');?></a></li>
            <?php endif; ?>
        </ul>

        <div class="tab-content">
            <?php if ($tpl['has_access_settings']): ?>
                <div role="tabpanel" class="tab-pane active" id="settings">
                    <div class="panel-body">
                        <form id="frmSms" name="frmSms" action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseSms&amp;action=pjActionIndex" method="post" class="form-horizontal">
                            <input type="hidden" name="sms_post" value="1" />
                            <input type="hidden" name="number" value="" />
                            <p class="alert alert-info alert-with-icon m-t-xs"> <i class="fa fa-info-circle"></i><?php __('plugin_base_sms_infobox_api_settings');?></p>

                            <br>
                            
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php __('plugin_base_sms_api_username', false, true);?></label>
								<div class="col-sm-6">
									<input type="text" id="plugin_sms_api_username" name="plugin_sms_api_username" value="<?php echo !empty($tpl['option_arr']['plugin_sms_api_username']) ? $tpl['option_arr']['plugin_sms_api_username'] : NULL;?>" class="form-control">
								</div><!-- /.col-sm-6 -->
							</div><!-- /.form-group -->
							
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php __('plugin_base_sms_api_key', false, true);?></label>
								<div class="col-sm-6">
									<input type="text" id="plugin_sms_api_key" name="plugin_sms_api_key" value="<?php echo !empty($tpl['option_arr']['plugin_sms_api_key']) ? $tpl['option_arr']['plugin_sms_api_key'] : NULL;?>" class="form-control">
								</div><!-- /.col-sm-6 -->
							</div><!-- /.form-group -->
							
							<div class="form-group">
								<label class="col-sm-3 control-label"></label>
								<div class="col-sm-6">
									<a href="#" class="btn btn-primary btn-outline btnTestSms"><i class="fa fa-mobile m-r-xs"></i> <?php __('plugin_base_btn_send_test_message');?></a>
									<a href="#" class="btn btn-primary btn-outline btnVerify"><i class="fa fa-check-circle-o m-r-xs"></i> <?php __('plugin_base_btn_verify_your_key');?></a>
								</div><!-- /.col-sm-6 -->
							</div><!-- /.form-group -->
							
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php __('plugin_base_sms_country_code', false, true);?></label>
								<div class="col-sm-6">
									<input type="text" id="plugin_sms_country_code" name="plugin_sms_country_code" value="<?php echo !empty($tpl['option_arr']['plugin_sms_country_code']) ? $tpl['option_arr']['plugin_sms_country_code'] : NULL;?>" class="form-control">
								</div><!-- /.col-sm-6 -->
							</div><!-- /.form-group -->
							
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php __('plugin_base_sms_phone_number_length', false, true);?></label>
								<div class="col-sm-6">
									<input type="text" id="plugin_sms_phone_number_length" name="plugin_sms_phone_number_length" value="<?php echo !empty($tpl['option_arr']['plugin_sms_phone_number_length']) ? $tpl['option_arr']['plugin_sms_phone_number_length'] : NULL;?>" class="form-control digits" data-msg-digits="<?php __('plugin_base_digits_validation');?>">
									<small><?php __('plugin_base_sms_phone_number_length_note', false, true);?></small>
								</div><!-- /.col-sm-6 -->
							</div><!-- /.form-group -->
							
							<div class="hr-line-dashed"></div>
							
							<div class="clearfix">
                                <button type="submit" class="ladda-button btn btn-primary btn-lg pull-left btn-phpjabbers-loader" data-style="zoom-in">
                                    <span class="ladda-label"><?php __('plugin_base_btn_save'); ?></span>
                                    <?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
                                </button>
                            </div>
							
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($tpl['has_access_list']): ?>
                <div role="tabpanel" class="tab-pane<?php echo $tpl['has_access_settings']? null: ' active'; ?>" id="message-sent">
                    <div class="panel-body ibox-content">
                        <div class="row m-b-md">
                            <div class="col-md-4 col-md-offset-4">
                                <form action="" method="get" class="form-horizontal frm-filter">
                                    <div class="input-group">
                                        <input type="text" name="q" placeholder="<?php __('plugin_base_btn_search', false, true); ?>" class="form-control">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- /.col-md-3 -->
                        </div><!-- /.row -->

                        <div id="grid"></div>

                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script type="text/javascript">
var pjGrid = pjGrid || {};
var myLabel = myLabel || {};
myLabel.created = <?php x__encode('plugin_base_sms_date_time_sent'); ?>;
myLabel.number = <?php x__encode('plugin_base_sms_number'); ?>;
myLabel.text = <?php x__encode('plugin_base_sms_message'); ?>;
myLabel.status = <?php x__encode('plugin_base_sms_status'); ?>;

myLabel.test_sms_title = <?php x__encode('plugin_base_sms_test_sms_title'); ?>;
myLabel.test_sms_text = <?php x__encode('plugin_base_sms_test_sms_text'); ?>;
myLabel.test_sms_number = <?php x__encode('plugin_base_sms_number'); ?>;
myLabel.btn_send_sms = <?php x__encode('plugin_base_btn_send_sms'); ?>;
myLabel.btn_cancel = <?php x__encode('plugin_base_btn_cancel'); ?>;
</script>