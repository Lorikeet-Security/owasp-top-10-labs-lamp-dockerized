<?php
$titles = __('error_titles', true);
$bodies = __('error_bodies', true); 
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-lg-9 col-md-8 col-sm-6">
				<h2><?php __('infoReservationTitle');?></h2>
			</div>
		</div><!-- /.row -->

		<p class="m-b-none"><i class="fa fa-info-circle"></i><?php __('infoReservationDesc');?></p>
	</div><!-- /.col-md-12 -->
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<?php
	$error_code = $controller->_get->toString('err');
	if (!empty($error_code))
    {
    	switch ($error_code)
    	{
    		case in_array($error_code, array('AO02')):
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
					
					<form id="frmUpdateOptions" action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;action=pjActionUpdate" method="post" class="form-horizontal">
						<input type="hidden" name="options_update" value="1" />
						<input type="hidden" name="tab" value="2" />
						<input type="hidden" name="next_action" value="pjActionBooking" />
						
						<div class="form-group">
							<label class="col-sm-3 control-label"><?php __('opt_o_mileage');?></label>

							<div class="col-lg-5 col-sm-7">
								<div class="row">
									<div class="col-sm-6">
										<select class="form-control" name="value-enum-o_mileage">
											<?php foreach (__('mileage_enum', true) as $k => $v) { ?>
												<option value="confirmed|pending|cancelled::<?php echo $k;?>" <?php echo $tpl['option_arr']['o_mileage'] == $k ? 'selected="selected"' : null;?>><?php echo pjSanitize::html($v);?></option>
											<?php } ?>            
										</select>
									</div><!-- /.col-sm-6 -->
								</div><!-- /.row -->

							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label"><?php __('opt_o_deposit_payment');?></label>

							<div class="col-lg-5 col-sm-7">
								<div class="row">
									<div class="col-sm-6">
										<div class="input-group">
											<input class="form-control number" type="text" value="<?php echo $tpl['option_arr']['o_deposit_payment']?>" name="value-float-o_deposit_payment" data-msg-number="<?php __('jquery_validation_ARRAY_number', true);?>"> 

											<span class="input-group-addon"><i class="fa fa-percent"></i></span> 
										</div>
									</div><!-- /.col-sm-6 -->
								</div><!-- /.row -->
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php __('opt_o_tax_payment');?></label>

							<div class="col-lg-5 col-sm-7">
								<div class="row">
									<div class="col-sm-6">
										<div class="input-group">
											<input class="form-control number" type="text" value="<?php echo $tpl['option_arr']['o_tax_payment']?>" name="value-float-o_tax_payment" data-msg-number="<?php __('jquery_validation_ARRAY_number', true);?>"> 

											<span class="input-group-addon"><i class="fa fa-percent"></i></span> 
										</div>
									</div><!-- /.col-sm-6 -->
								</div><!-- /.row -->
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label"><?php __('opt_o_booking_status');?></label>

							<div class="col-lg-5 col-sm-7">
								<div class="row">
									<div class="col-sm-6">
										<select class="form-control" name="value-enum-o_booking_status">
											<?php foreach (__('booking_statuses', true) as $k => $v) { ?>
												<option value="confirmed|pending|cancelled::<?php echo $k;?>" <?php echo $tpl['option_arr']['o_booking_status'] == $k ? 'selected="selected"' : null;?>><?php echo pjSanitize::html($v);?></option>
											<?php } ?>            
										</select>
									</div><!-- /.col-sm-6 -->
								</div><!-- /.row -->

							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php __('opt_o_payment_status');?></label>

							<div class="col-lg-5 col-sm-7">
								<div class="row">
									<div class="col-sm-6">
										<select class="form-control" name="value-enum-o_payment_status">
											<?php foreach (__('booking_statuses', true) as $k => $v) { ?>
												<option value="confirmed|pending|cancelled::<?php echo $k;?>" <?php echo $tpl['option_arr']['o_payment_status'] == $k ? 'selected="selected"' : null;?>><?php echo pjSanitize::html($v);?></option>
											<?php } ?>            
										</select>
									</div><!-- /.col-sm-6 -->
								</div><!-- /.row -->

							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php __('lblDisablePayments'); ?></label>

							<div class="col-lg-5 col-sm-7">
								<div class="row">
									<div class="col-sm-6">
										<div class="switch m-t-xs">
											<div class="onoffswitch onoffswitch-yn">
				                                <input class="onoffswitch-checkbox" id="value-enum-o_payment_disable" name="value-enum-o_payment_disable" type="checkbox"<?php echo $tpl['option_arr']['o_payment_disable'] == 'Yes' ? ' checked="checked"' : NULL; ?> value="Yes|No::Yes">
				                                <label class="onoffswitch-label" for="value-enum-o_payment_disable">
				                                    <span class="onoffswitch-inner"></span>
				                                    <span class="onoffswitch-switch"></span>
				                                </label>
				                            </div>
										</div>
									</div><!-- /.col-sm-6 -->
								</div><!-- /.row -->

								<small><?php __('lblDisablePaymentsText');?></small>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label"><?php __('lblThankYouPage');?></label>

							<div class="col-lg-5 col-sm-7">
								<div class="row">
									<div class="col-sm-12">
										<div class="input-group">
            								<span class="input-group-addon"><i class="fa fa-globe"></i></span> 
            								<input class="form-control" value="<?php echo $tpl['option_arr']['o_thankyou_page']?>" name="value-string-o_thank_you_page" type="text">
            							</div>
            							<small><?php __('lblThankYouPageText');?></small>
									</div><!-- /.col-sm-6 -->
								</div><!-- /.row -->
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label"><?php __('opt_o_vehicle_per_page');?></label>

							<div class="col-lg-5 col-sm-7">
								<div class="row">
									<div class="col-sm-6">
										<input class="form-control field-int" value="<?php echo $tpl['option_arr']['o_vehicle_per_page']?>" name="value-string-o_vehicle_per_page" type="text">
									</div><!-- /.col-sm-6 -->
								</div><!-- /.row -->
							</div>
						</div>
						
						<div class="hr-line-dashed"></div>

						<div class="clearfix">
							<button class="ladda-button btn btn-primary btn-lg btn-phpjabbers-loader" data-style="zoom-in">
								<span class="ladda-label"><?php __('plugin_base_btn_save'); ?></span>
								<?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>