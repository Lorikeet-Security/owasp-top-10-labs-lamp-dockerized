<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-10">
                <h2><?php __('infoUpdateClientTitle', false, true);?></h2>
            </div>
        </div><!-- /.row -->

        <p class="m-b-none"><i class="fa fa-info-circle"></i> <?php __('infoUpdateClientDesc', false, true);?></p>
    </div><!-- /.col-md-12 -->
</div>
<?php
$u_statarr = __('u_statarr', true)
?>
<div class="row wrapper wrapper-content animated fadeInRight">
    <div class="col-lg-12">
    	<?php
    	$error_code = $controller->_get->toString('err');
    	if (!empty($error_code))
    	{
    	    $titles = __('error_titles', true);
    	    $bodies = __('error_bodies', true);
    	    switch (true)
    	    {
    	        case in_array($error_code, array('AC01', 'AC03')):
    	            ?>
    				<div class="alert alert-success">
    					<i class="fa fa-check m-r-xs"></i>
    					<strong><?php echo @$titles[$error_code]; ?></strong>
    					<?php echo @$bodies[$error_code]?>
    				</div>
    				<?php
    				break;
                case in_array($error_code, array('AC04', 'AC08')):
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
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminClients&amp;action=pjActionUpdate" method="post" id="frmUpdateClient">
                	<input type="hidden" name="client_update" value="1" />
                	<input type="hidden" name="id" value="<?php echo (int) $tpl['arr']['id']; ?>" />
                    <div class="row">
                    	<div class="col-lg-3 col-md-4 col-sm-6">
                    		<div class="form-group">
                                <label class="control-label"><?php __('lblClientTotalBookings'); ?></label>

                                <div class="clearfix">
                                    <p class="form-control-static"><?php echo $tpl['arr']['cnt_orders'];?> / <?php echo pjCurrency::formatPrice($tpl['arr']['total_amount']);?></p>
                                </div><!-- /.clearfix -->
                            </div><!-- /.form-group -->
                    	</div>
                    	<?php
                    	if($tpl['arr']['cnt_orders'] > 0)
                    	{
                    	    $created = $tpl['arr']['last_order'][0];
                    	    $id = $tpl['arr']['last_order'][1];
                        	?>
                        	<div class="col-lg-3 col-md-4 col-sm-6">
                        		<div class="form-group">
                                    <label class="control-label"><?php __('lblClientLastBooking'); ?></label>
    
                                    <div class="clearfix">
                                        <p class="form-control-static"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOrders&amp;action=pjActionUpdate&amp;id=<?php echo $id;?>"><?php echo date($tpl['option_arr']['o_date_format'], strtotime($created));?>, <?php echo date($tpl['option_arr']['o_time_format'], strtotime($created));?></a></p>
                                    </div><!-- /.clearfix -->
                                </div><!-- /.form-group -->
                        	</div>
                        	<?php
                    	}
                        ?>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblStatus'); ?></label>

                                <div class="clearfix">
                                    <div class="switch onoffswitch-data pull-left">
                                        <div class="onoffswitch">
                                            <input type="checkbox" class="onoffswitch-checkbox" id="status" name="status"<?php echo $tpl['arr']['status']=='T' ? ' checked' : NULL;?>>
                                            <label class="onoffswitch-label" for="status">
                                                <span class="onoffswitch-inner" data-on="<?php echo $u_statarr['T'];?>" data-off="<?php echo $u_statarr['F'];?>"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div><!-- /.clearfix -->
                            </div><!-- /.form-group -->
                        </div><!-- /.col-md-3 -->
					</div>
					<div class="hr-line-dashed"></div>
					<div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblBookingTitle'); ?></label>

                                <select name="title" id="title" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>">
                					<option value="">-- <?php __('lblChoose'); ?>--</option>
                					<?php
                					$name_titles = __('personal_titles', true, false);
                					foreach ($name_titles as $k => $v)
                					{
                						?><option value="<?php echo $k; ?>"<?php echo $tpl['arr']['title'] == $k ? ' selected="selected"' : NULL;?>><?php echo $v; ?></option><?php
                					}
                					?>
                				</select>
                            </div>
                        </div><!-- /.col-md-3 -->
						<?php
						$name_arr = pjUtil::splitName($tpl['arr']['name']);
						?>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblBookingFname'); ?></label>

                                <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars(stripslashes($name_arr[0])); ?>" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>" maxlength="255">
                            </div>
                        </div><!-- /.col-md-3 -->
                        
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblBookingLname'); ?></label>

                                <input type="text" id="lname" name="lname" value="<?php echo htmlspecialchars(stripslashes($name_arr[1])); ?>" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>" maxlength="255">
                            </div>
                        </div><!-- /.col-md-3 -->
                    
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('email'); ?></label>
								
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-at"></i></span>
                                	<input type="text" name="email" id="email" value="<?php echo htmlspecialchars(stripslashes($tpl['arr']['email'])); ?>" class="form-control email required" placeholder="info@domain.com" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>" maxlength="255">
                                </div>
                            </div>
                        </div><!-- /.col-md-3 -->
						<div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('pass'); ?></label>

								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                	<input type="password" name="password" id="password" value="<?php echo pjSanitize::html($tpl['arr']['password']); ?>" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>" maxlength="255">
                                </div>
                            </div>
                        </div><!-- /.col-md-3 -->
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblPhone'); ?></label>

								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                	<input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars(stripslashes($tpl['arr']['phone'])); ?>" class="form-control" placeholder="(123) 456-7890" maxlength="255">
                                </div>
                            </div>
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblBookingCompany'); ?></label>

                                <input type="text" name="company" id="company" value="<?php echo htmlspecialchars(stripslashes($tpl['arr']['company'])); ?>" class="form-control" maxlength="255">
                            </div>
                        </div><!-- /.col-md-3 -->
                    </div><!-- /.row -->

                    <div class="hr-line-dashed"></div>
                    
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblBookingAddress'); ?></label>

                                <input type="text" name="address" id="address" value="<?php echo htmlspecialchars(stripslashes($tpl['arr']['address'])); ?>" class="form-control" maxlength="255">
                            </div>
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblBookingCity'); ?></label>

                                <input type="text" name="city" id="city" value="<?php echo htmlspecialchars(stripslashes($tpl['arr']['city'])); ?>" class="form-control" maxlength="255">
                            </div>
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblBookingState'); ?></label>

                                <input type="text" name="state" id="state" value="<?php echo htmlspecialchars(stripslashes($tpl['arr']['state'])); ?>" class="form-control" maxlength="255">
                            </div>
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblBookingZip'); ?></label>

                                <input type="text" name="zip" id="zip" value="<?php echo htmlspecialchars(stripslashes($tpl['arr']['zip'])); ?>" class="form-control" maxlength="255">
                            </div>
                        </div><!-- /.col-md-3 -->

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblBookingCountry'); ?></label>

                                <select name="country_id" id="country_id" class="form-control">
                					<option value="">-- <?php __('lblChoose'); ?>--</option>
                					<?php
                					foreach ($tpl['country_arr'] as $v)
                					{
                						?><option value="<?php echo $v['id']; ?>"<?php echo $tpl['arr']['country_id'] == $v['id'] ? ' selected="selected"' : NULL;?>><?php echo stripslashes($v['country_title']); ?></option><?php
                					}
                					?>
                				</select>
                            </div>
                        </div><!-- /.col-md-3 -->
                    </div><!-- /.row -->

                    <div class="hr-line-dashed"></div>

                    <div class="clearfix">
                        <button type="submit" class="ladda-button btn btn-primary btn-lg btn-phpjabbers-loader pull-left" data-style="zoom-in" style="margin-right: 15px;">
                            <span class="ladda-label"><?php __('btnSave'); ?></span>
                            <?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
                        </button>
                        <a class="btn btn-white btn-lg pull-right" href="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminClients&action=pjActionIndex"><?php __('btnCancel'); ?></a>
                    </div><!-- /.clearfix -->
                </form>
            </div>
        </div>
    </div><!-- /.col-lg-12 -->
</div>
<script type="text/javascript">
var myLabel = myLabel || {};
myLabel.email_exists = <?php x__encode('email_taken'); ?>;
</script>