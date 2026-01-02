<?php
$months = __('months', true);
ksort($months);
$short_days = __('short_days', true);
?>
<div id="datePickerOptions" style="display:none;" data-wstart="<?php echo (int) $tpl['option_arr']['o_week_start']; ?>" data-format="<?php echo $tpl['date_format']; ?>" data-months="<?php echo implode("_", $months);?>" data-days="<?php echo implode("_", $short_days);?>"></div>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-lg-9 col-md-8 col-sm-6">
				<h2><?php __('infoUpdateBookingTitle');?></h2>
			</div>
		</div><!-- /.row -->

		<p class="m-b-none"><i class="fa fa-info-circle"></i> <?php __('infoUpdateBookingDesc');?></p>
	</div><!-- /.col-md-12 -->
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-8">
			<div class="tabs-container tabs-reservations m-b-lg">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionUpdate" method="post" class="form pj-form" id="frmUpdateBooking">
					<input type="hidden" name="booking_update" value="1" />
					<input type="hidden" name="id" value="<?php echo $tpl['arr']['id'];?>" />
					
					<ul class="nav nav-tabs" role="tablist">
        				<li role="presentation" class="active"><a class="nav-tab-booking-details" href="#tab-booking-details" aria-controls="booking-details" role="tab" data-toggle="tab"><?php __('lblBookingDetails');?></a></li>
        				<li role="presentation"><a class="nav-tab-client-details" href="#tab-client-details" aria-controls="client-details" role="tab" data-toggle="tab"><?php __('lblClientDetails');?></a></li>
        			</ul>
        			<div class="tab-content">
        				<div role="tabpanel" class="tab-pane active" id="tab-booking-details">
        					<div class="panel-body">
        						<div class="row">
        							<div class="col-md-4 col-sm-6">
        								<div class="form-group">
                                            <label class="control-label"><?php __('lblUniqueID');?></label>
            								<input type="text" id="uuid" name="uuid" value="<?php echo pjSanitize::clean($tpl['arr']['uuid']); ?>" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required');?>"/>
                                        </div>
        							</div>
        							<div class="col-md-4 col-sm-6">
        								<div class="form-group">
                                            <label class="control-label"><?php __('lblIpAddress');?></label>
            								<p class="form-control-static"><?php echo pjSanitize::html($tpl['arr']['ip']);?></p>
                                        </div>
        							</div>
        							<div class="col-md-4 col-sm-6">
        								<div class="form-group">
                                            <label class="control-label"><?php __('lblCreatedOn');?></label>
            								<p class="form-control-static"><?php echo date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], strtotime($tpl['arr']['created']));?></p>
                                        </div>
        							</div>
        						</div>
        						<div class="row">
        							<div class="col-md-4 col-sm-6">
        								<div class="form-group">
                                            <label class="control-label"><?php __('lblDirection');?></label>
            								<div class="form-horizontal">
            									<label class="normal-label m-t-xs">
                                                	<input type="radio" name="traveling" id="traveling_from" value="from" <?php echo $tpl['arr']['traveling'] == 'from' ? ' checked="checked"' : NULL;?> class="m-r-xs i-checks pps"/> <span class="m-l-xs"><?php __('lblTravelingFrom');?></span>
                                                </label>
                								<label class="normal-label m-t-xs">
                                                	<input type="radio" name="traveling" id="traveling_to" value="to" <?php echo $tpl['arr']['traveling'] == 'to' ? ' checked="checked"' : NULL;?>class="m-r-xs i-checks pps"/> <span class="m-l-xs"><?php __('lblTravelingTo');?></span>
                                                </label>
                                            </div>
                                        </div>
        							</div><!-- /.col-md-3 -->
        							
        							<div class="col-md-4 col-sm-6">
        								<div class="form-group">
                                            <label class="control-label"><?php __('lblStatus');?></label>
            								<select name="status" id="status" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required');?>">
                								<option value="">-- <?php __('lblChoose'); ?>--</option>
                								<?php
                								foreach (__('booking_statuses', true, false) as $k => $v)
                								{
                									?><option value="<?php echo $k; ?>"<?php echo $tpl['arr']['status'] == $k ? ' selected="selected"' : NULL;?>><?php echo $v; ?></option><?php
                								}
                								?>
                							</select>
                                        </div>
        							</div><!-- /.col-md-3 -->
        							
        							<?php
                        			$plugins_payment_methods = pjObject::getPlugin('pjPayments') !== NULL? pjPayments::getPaymentMethods(): array();
                        			$haveOnline = $haveOffline = false;
                        			foreach ($tpl['payment_titles'] as $k => $v)
                        			{
                        			    if( $k != 'cash' && $k != 'bank' )
                        			    {
                        			        if( (int) $tpl['payment_option_arr'][$k]['is_active'] == 1)
                        			        {
                        			            $haveOnline = true;
                        			            break;
                        			        }
                        			    }
                        			}
                        			foreach ($tpl['payment_titles'] as $k => $v)
                        			{
                        			    if( $k == 'cash' || $k == 'bank' )
                        			    {
                        			        if( (int) $tpl['payment_option_arr'][$k]['is_active'] == 1)
                        			        {
                        			            $haveOffline = true;
                        			            break;
                        			        }
                        			    }
                        			}
                        			?>
                        			<div class="col-md-4 col-sm-6">
        								<div class="form-group">
        									<label class="control-label"><?php __('lblPaymentMethod');?></label>
        	
        									<select name="payment_method" id="payment_method" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>">
        										<option value="">-- <?php __('lblChoose'); ?>--</option>
        										<?php
                                				if ($haveOnline && $haveOffline)
                                				{
                                				    ?><optgroup label="<?php __('script_online_payment_gateway', false, true); ?>"><?php
                                                }
                                                foreach ($tpl['payment_titles'] as $k => $v)
                                                {
                                                    if($k == 'cash' || $k == 'bank' ){
                                                        continue;
                                                    }
                                                    if (array_key_exists($k, $plugins_payment_methods))
                                                    {
                                                        if(!isset($tpl['payment_option_arr'][$k]['is_active']) || (isset($tpl['payment_option_arr']) && $tpl['payment_option_arr'][$k]['is_active'] == 0) )
                                                        {
                                                            continue;
                                                        }
                                                    }
                                                    ?><option value="<?php echo $k; ?>"<?php echo isset($tpl['arr']['payment_method']) && $tpl['arr']['payment_method']==$k ? ' selected="selected"' : NULL;?>><?php echo $v; ?></option><?php
                                                }
                                                if ($haveOnline && $haveOffline)
                                                {
                                                    ?>
                                                	</optgroup>
                                                	<optgroup label="<?php __('script_offline_payment', false, true); ?>">
                                                	<?php 
                                                }
                                                foreach ($tpl['payment_titles'] as $k => $v)
                                                {
                                                    if( $k == 'cash' || $k == 'bank' )
                                                    {
                                                        if( (int) $tpl['payment_option_arr'][$k]['is_active'] == 1)
                                                        {
                                                            ?><option value="<?php echo $k; ?>"<?php echo isset($tpl['arr']['payment_method']) && $tpl['arr']['payment_method']==$k ? ' selected="selected"' : NULL;?>><?php echo $v; ?></option><?php
                                                        }
                                                    }
                                                }
                                                if ($haveOnline && $haveOffline)
                                                {
                                                    ?></optgroup><?php
                                                }
                                				?>
        									</select>
        								</div>
        							</div><!-- /.col-md-3 -->
        						</div>
        						<div class="row">
        							<div class="col-md-4 col-sm-6">
        								<div class="form-group">
        									<label class="control-label"><?php __('lblLocation');?></label>
        									<select name="location_id" id="location_id" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required');?>">
                								<option value="">-- <?php __('lblChoose'); ?>--</option>
                								<?php
                								foreach($tpl['da_arr'] as $k => $v)
                								{
                									?><option value="<?php echo $v['id'];?>"<?php echo $tpl['arr']['location_id']==$v['id'] ? ' selected="selected"' : NULL;?>><?php echo pjSanitize::html($v['title']);?></option><?php
                								} 
                								?>
                							</select>
        								</div>
        							</div><!-- /.col-md-3 -->
        							
        							<div class="col-md-4 col-sm-6">
        								<div class="form-group">
        									<label class="control-label trLocationLabel trLocation-from"style="display:<?php echo $tpl['arr']['traveling'] == 'to' ? 'none' : NULL;?>;"><?php __('lblDropoffLocation');?></label><label class="control-label trLocationLabel trLocation-to" style="display:<?php echo $tpl['arr']['traveling'] == 'from' ? 'none' : NULL;?>;"><?php __('lblPickupLocation');?></label>
        									<div id="trDropoffContainer">
        										<select name="dropoff_id" id="dropoff_id" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required');?>">
                    								<option value="">-- <?php __('lblChoose'); ?>--</option>
                    								<?php
                    								if(isset($tpl['pd_arr']))
                    								{
                    									foreach($tpl['pd_arr'] as $v)
                    									{
                    										?><option value="<?php echo $v['id'];?>"<?php echo $tpl['arr']['dropoff_id'] == $v['id'] ? ' selected="selected"' : NULL;?>><?php echo pjSanitize::html($v['title']);?></option><?php
                    									}
                    								} 
                    								?>
                    							</select>
        									</div>
        								</div>
        							</div><!-- /.col-md-3 -->
        							
        							<div class="col-md-4 col-sm-6">
        								<div class="form-group">
        									<label class="control-label"><?php __('lblPassengers');?></label>
        									<input type="text" id="passengers" name="passengers" value="<?php echo $tpl['arr']['passengers'];?>" class="form-control touchspin3 required digits" data-value="0" data-msg-digits="<?php __('lblPositiveNumber'); ?>" data-msg-required="<?php __('plugin_base_this_field_is_required');?>"/>
        								</div>
        							</div>
        						</div><!-- /.row -->
        						
        						<div class="row">
        							<div class="col-md-4 col-sm-6">
        								<div class="form-group">
        									<label class="control-label"><?php __('lblDeparture');?></label>
        	
        									<div class="input-group">
        										<input type="text" class="form-control required datepick" name="booking_date" id="booking_date" value="<?php echo date($tpl['option_arr']['o_date_format'], strtotime($tpl['arr']['booking_date']));?>" readonly="readonly" data-msg-required="<?php __('plugin_base_this_field_is_required');?>">
        	
        										<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
        									</div>
        								</div>
        							</div><!-- /.col-md-3 -->
        							
        							<div class="col-md-4 col-sm-6">
        								<div class="form-group">
        									<label class="control-label"><?php __('lblLine');?></label>
        	
        									<div id="trLineWrapper">
                    							<select name="line_id" id="line_id" class="form-control required">
                    								<option value="">-- <?php __('lblChoose'); ?>--</option>
                    								<?php
                    								$capacity = 0;
                    								if(isset($tpl['line_arr']))
                    								{
                    									foreach($tpl['line_arr'] as $v)
                    									{
                    										if($tpl['arr']['line_id'] == $v['id'])
                    										{
                    											?><option value="<?php echo $v['id'];?>" selected="selected"><?php echo pjSanitize::html($v['title']);?></option><?php
                    											$capacity = (int) $v['seats'];
                    										}else{
                    											?><option value="<?php echo $v['id'];?>"><?php echo pjSanitize::html($v['title']);?></option><?php
                    										}
                    									}
                    								} 
                    								?>
                    							</select>
                    						</div>
        								</div>
        							</div><!-- /.col-md-3 -->
        							
        							<?php
                					$duration = 0;
                					$duration_text = '';
                					$price_per_person = 0;
                					$price_per_person_format = '';
                					if(!empty($tpl['line_detail_arr']))
                					{
                						$line_arr = $tpl['line_detail_arr'];
                						if($tpl['arr']['traveling'] == 'from')
                						{
                							$duration = (int) $line_arr['duration_dropoff'];
                							$price_per_person = $line_arr['price_dropoff'];
                							$duration_text = (int) $line_arr['duration_dropoff'] . ' ' . __('lblMinutes', true);
                							$price_per_person_format = pjCurrency::formatPrice($line_arr['price_dropoff']) . ' ' . __('lblPerPerson', true);
                						}else{
                							$duration = (int) $line_arr['duration_pickup'];
                							$price_per_person = $line_arr['price_pickup'];
                							$duration_text = (int) $line_arr['duration_pickup'] . ' ' . __('lblMinutes', true);
                							$price_per_person_format = pjCurrency::formatPrice($line_arr['price_pickup']) . ' ' . __('lblPerPerson', true);
                						}
                					} 
                					?>
        							
        							<div class="col-md-4 col-sm-6">
        								<div class="form-group">
        									<label class="control-label"><?php __('lblAvailableTime');?></label>
        	
        									<div id="trTimeWrapper">
                    							<select name="booking_time" id="booking_time" class="form-control required">
                    								<?php
                    								if(isset($tpl['timetable_arr']))
                    								{
                    									if(!empty($tpl['timetable_arr']))
                    									{
                    										?>
                    										<option value="">-- <?php __('lblChoose'); ?>--</option>
                    										<?php
                    										$time_arr = explode("|", $tpl['timetable_arr']['time']);
                    										foreach($time_arr as $time)
                    										{
                    											$time_ts = strtotime($time);
                    											if($tpl['arr']['traveling'] == 'to')
                    											{
                    												$time_ts = $time_ts - ($duration * 60);
                    											}
                    											$iso_time = date('H:i', $time_ts);
                    											$disabled = '';
                    											if(array_key_exists($iso_time, $tpl['booked_time_arr']) && $tpl['booked_time_arr'][$iso_time] + $tpl['arr']['passengers'] > $capacity )
                    											{
                    												$disabled = ' disabled';
                    											}
                    											?><option value="<?php echo $iso_time;?>"<?php echo $iso_time == date('H:i', strtotime($tpl['arr']['booking_time'])) ? ' selected="selected"' : NULL;?><?php echo $disabled;?>><?php echo date($tpl['option_arr']['o_time_format'], $time_ts);?></option><?php
                    										}
                    									}else{
                    										?><option value="">-- <?php __('lblNoAvailableTime'); ?>--</option><?php
                    									}
                    								} else {
                    									?><option value="">-- <?php __('lblChoose'); ?>--</option><?php
                    								}
                    								?>
                    							</select>
                    						</div>
        								</div>
        							</div><!-- /.col-md-3 -->
        						</div><!-- /.row -->
        						
        						<div class="row">
        							<div class="col-md-4 col-sm-6">
        								<div class="form-group">
                                            <label class="control-label"><?php __('lblReturnTrip'); ?></label>
            
                                            <div class="clearfix">
                                                <div class="switch onoffswitch-data pull-left">
                                                    <div class="onoffswitch">
                                                        <input type="checkbox" class="onoffswitch-checkbox" id="has_return" name="has_return"<?php echo $tpl['arr']['has_return'] == 'T' ? ' checked="checked"' : NULL;?>>
                                                        <label class="onoffswitch-label" for="has_return">
                                                            <span class="onoffswitch-inner" data-on="<?php __('_yesno_ARRAY_T');?>" data-off="<?php __('_yesno_ARRAY_F');?>"></span>
                                                            <span class="onoffswitch-switch"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div><!-- /.clearfix -->
                                        </div><!-- /.form-group -->
        							</div><!-- /.col-md-3 -->
        						</div><!-- /.row -->
        						
        						<div class="row" id="trReturnWrapper" style="display: <?php echo $tpl['arr']['has_return'] == 'T' ? '' : 'none';?>;">
        							<div class="col-md-4 col-sm-6">
        								<div class="form-group">
        									<label class="control-label"><?php __('lblReturnDateTime');?></label>
        	
        									<div class="input-group">
        										<input type="text" class="form-control datepick<?php echo $tpl['arr']['has_return'] == 'T' ? ' required' : NULL;?>" name="return_date" id="return_date" value="<?php echo $tpl['arr']['has_return'] == 'T' ? date($tpl['option_arr']['o_date_format'], strtotime($tpl['arr']['return_date'])) : NULL;?>" readonly="readonly" data-msg-required="<?php __('plugin_base_this_field_is_required');?>">
        	
        										<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
        									</div>
        								</div>
        							</div><!-- /.col-md-3 -->
        							
        							<div class="col-md-4 col-sm-6">
        								<div class="form-group">
        									<label class="control-label"><?php __('lblReturnLine');?></label>
        	
        									<div id="trReturnLineWrapper">
                    							<select name="return_line_id" id="return_line_id" class="form-control<?php echo $tpl['arr']['has_return'] == 'T' ? ' required' : NULL;?>">
                    								<option value="">-- <?php __('lblChoose'); ?>--</option>
                    								<?php
                									$return_capacity = 0;
                									if(isset($tpl['line_arr']))
                									{
                										foreach($tpl['line_arr'] as $v)
                										{
                											if($tpl['arr']['return_line_id'] == $v['id'])
                											{
                												?><option value="<?php echo $v['id'];?>" selected="selected"><?php echo pjSanitize::html($v['title']);?></option><?php
                												$return_capacity = (int) $v['seats'];
                											}else{
                												?><option value="<?php echo $v['id'];?>"><?php echo pjSanitize::html($v['title']);?></option><?php
                											}
                										}
                									} 
                									?>
                    							</select>
                    						</div>
        								</div>
        							</div><!-- /.col-md-3 -->
        							<?php
            						$return_duration = 0;
            						$return_duration_text = '';
            						$return_price_per_person = 0;
            						$return_price_per_person_format = '';
            						if(!empty($tpl['return_line_detail_arr']))
            						{
            							$line_arr = $tpl['return_line_detail_arr'];
            							if($tpl['arr']['traveling'] == 'from')
            							{
            								$return_duration = (int) $line_arr['duration_pickup'] ;
            								$return_price_per_person = $line_arr['price_pickup'];
            								$return_duration_text = (int) $line_arr['duration_pickup'] . ' ' . __('lblMinutes', true);
            								$return_price_per_person_format = pjCurrency::formatPrice($line_arr['price_pickup']) . ' ' . __('lblPerPerson', true);
            							}else{
            								$return_duration = (int) $line_arr['duration_dropoff'] ;
            								$return_price_per_person = $line_arr['price_dropoff'];
            								$return_duration_text = (int) $line_arr['duration_dropoff'] . ' ' . __('lblMinutes', true);
            								$return_price_per_person_format = pjCurrency::formatPrice($line_arr['price_dropoff']) . ' ' . __('lblPerPerson', true);
            							}
            						} 
            						?>
        							<div class="col-md-4 col-sm-6">
        								<div class="form-group">
        									<label class="control-label"><?php __('lblReturnAvailableTime');?></label>
        	
        									<div id="trReturnTimeWrapper">
                    							<select name="return_time" id="return_time" class="form-control<?php echo $tpl['arr']['has_return'] == 'T' ? ' required' : NULL;?>">
                    								<?php
                									if(isset($tpl['return_timetable_arr']))
                									{
                										if(!empty($tpl['return_timetable_arr']))
                										{
                											?>
                											<option value="">-- <?php __('lblChoose'); ?>--</option>
                											<?php
                											$time_arr = explode("|", $tpl['return_timetable_arr']['time']);
                											$traveling = $tpl['arr']['traveling'] == 'from' ? 'to' : 'from';
                											foreach($time_arr as $time)
                											{
                												$time_ts = strtotime($time);
                												if($traveling == 'to')
                												{
                													$time_ts = $time_ts - ($return_duration * 60);
                												}
                												$iso_time = date('H:i', $time_ts);
                												$disabled = '';
                												if(array_key_exists($iso_time, $tpl['return_booked_time_arr']) && $tpl['return_booked_time_arr'][$iso_time] + $tpl['arr']['passengers'] > $return_capacity )
                												{
                													$disabled = ' disabled';
                												}
                												?><option value="<?php echo date('H:i', $time_ts);?>"<?php echo date('H:i', $time_ts) == date('H:i', strtotime($tpl['arr']['return_time'])) ? ' selected="selected"' : NULL;?><?php echo $disabled;?>><?php echo date($tpl['option_arr']['o_time_format'], $time_ts);?></option><?php
                											}
                										}else{
                											?><option value="">-- <?php __('lblNoAvailableTime'); ?>--</option><?php
                										}
                									} else {
                										?><option value="">-- <?php __('lblChoose'); ?>--</option><?php
                									}
                									?>
                    							</select>
                    						</div>
        								</div>
        							</div><!-- /.col-md-3 -->
        						</div><!-- /.row -->
        						
        						<div class="hr-line-dashed"></div>
        	
        						<div class="clearfix">
        							 <button type="submit" class="ladda-button btn btn-primary btn-lg btn-phpjabbers-loader" data-style="zoom-in">
                            			<span class="ladda-label"><?php __('btnSave', false, true); ?></span>
                            			<?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
                            		</button>
    	                             <button type="button" class="btn btn-white btn-lg pull-right" onclick="window.location.href='<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminBookings&action=pjActionIndex';"><?php __('btnCancel'); ?></button>
        						</div><!-- /.clearfix -->
        					</div><!-- /.panel-body -->
        				</div><!-- /.tab-pane -->
        				
        				<div role="tabpanel" class="tab-pane" id="tab-client-details">
        					<div class="panel-body">
                				<div class="form-group">
                                    <label class="control-label"><?php __('lblClient'); ?></label>
        
                                    <div class="clearfix">
                                        <div class="switch onoffswitch-data pull-left">
                                            <div class="onoffswitch onoffswitch-client">
                                                <input type="checkbox" class="onoffswitch-checkbox" id="new_client" name="new_client">
        
                                                <label class="onoffswitch-label" for="new_client">
                                                    <span class="onoffswitch-inner" data-on="<?php __('lblNewClient'); ?>" data-off="<?php __('lblExistingClient'); ?>"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div><!-- /.clearfix -->
                                </div><!-- /.form-group -->
                                <div class="current-client-area">
                                    	
                        			<div class="form-group">
                                        <label class="control-label"><?php __('lblExistingClient'); ?></label>
                                        <div class="row">
                                    		<div class="col-md-10">
                                                <select name="client_id" id="client_id" class="form-control select-item fdRequired" data-msg-required="<?php __('tr_field_required', false, true);?>">
                									<option value="">-- <?php __('lblChoose'); ?>--</option>
                									<?php
                									foreach ($tpl['client_arr'] as $v)
                									{
                										$email_phone = array();
                										if(!empty($v['c_email']))
                										{
                											$email_phone[] = stripslashes($v['c_email']);
                										}
                										if(!empty($v['c_phone']))
                										{
                											$email_phone[] = stripslashes($v['c_phone']);
                										}
                										?><option value="<?php echo $v['id']; ?>"<?php echo $v['id'] == $tpl['arr']['client_id'] ? ' selected="selected"' : NULL;?>><?php echo pjSanitize::clean($v['c_name']); ?> (<?php echo join(" | ", $email_phone); ?>)</option><?php
                									}
                									?>
                								</select>
        									</div>
                							<div class="col-md-2">
                                    			<a id="pjFdEditClient" class="btn btn-primary btn-outline btn-sm m-l-xs" href="#" target="blank" data-href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminClients&amp;action=pjActionUpdate&id={ID}" style="display:none;"><i class="fa fa-pencil"></i></a>
                                    		</div>
                                       </div>
                                	</div>
                                </div><!-- /.hidden-area -->
                                
                                <div class="hr-line-dashed"></div>
                                
                                <div class="new-client-area" style="display:none;">
                                	
                                	<?php
                                	ob_start();
                                	$field = 0;
                                	if (in_array($tpl['option_arr']['o_bf_include_title'], array(2, 3)))
                                	{
                                	    $title_arr = pjUtil::getTitles();
                                	    $name_titles = __('personal_titles', true, false);
                                	    ?>
        							    <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label"><?php __('lblBookingTitle'); ?></label>
        
                                                <select id="c_title" name="c_title" class="form-control<?php echo ($tpl['option_arr']['o_bf_include_title'] == 3) ? ' fdRequired required' : NULL; ?>" data-msg-required="<?php __('tr_field_required', false, true);?>">
            										<option value="">----</option>
            										<?php
            										$title_arr = pjUtil::getTitles();
            										$name_titles = __('personal_titles', true, false);
            										foreach ($title_arr as $v)
            										{
            											?><option value="<?php echo $v; ?>"><?php echo $name_titles[$v]; ?></option><?php
            										}
            										?>
            									</select>
                                            </div>
                                        </div><!-- /.col-md-3 -->
        							    <?php
        							    $field++;
        							}
        							if (in_array($tpl['option_arr']['o_bf_include_fname'], array(2, 3)))
        							{
        							    ?>
        							    <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label"><?php __('lblBookingFname'); ?></label>
        
                                                <input type="text" name="c_fname" id="c_fname" class="form-control<?php echo $tpl['option_arr']['o_bf_include_fname'] == 3 ? ' fdRequired required' : NULL; ?>" data-msg-required="<?php __('tr_field_required', false, true);?>"/>
                                            </div>
                                        </div><!-- /.col-md-3 -->
        							    <?php
        							    $field++;
        							}
        							if (in_array($tpl['option_arr']['o_bf_include_lname'], array(2, 3)))
        							{
        							    ?>
        							    <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label"><?php __('lblBookingLname'); ?></label>
        
                                                <input type="text" name="c_lname" id="c_lname" class="form-control<?php echo $tpl['option_arr']['o_bf_include_lname'] == 3 ? ' fdRequired required' : NULL; ?>" data-msg-required="<?php __('tr_field_required', false, true);?>"/>
                                            </div>
                                        </div><!-- /.col-md-3 -->
        							    <?php
        							    $field++;
        							}
        							if (in_array($tpl['option_arr']['o_bf_include_email'], array(2, 3)))
        							{
        							    ?>
        							    <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label"><?php __('lblBookingEmail'); ?></label>
        
                                                <input type="text" name="c_email" id="c_email" class="form-control email<?php echo $tpl['option_arr']['o_bf_include_email'] == 3 ? ' fdRequired required' : NULL; ?>" data-msg-required="<?php __('tr_field_required', false, true);?>"/>
                                            </div>
                                        </div><!-- /.col-md-3 -->
        							    <?php
        							    $field++;
        							}
        							if($field == 4)
        							{
        							    $ob_fields = ob_get_contents();
        							    ob_end_clean();
        							    ?>
        							    <div class="row">
        							    	<?php echo $ob_fields;?>
        							    </div><!-- /.row -->
        							    <?php
        							    ob_start();
        							    $field = 0;
        							}
        							if (in_array($tpl['option_arr']['o_bf_include_email'], array(2, 3)))
        							{
        							    ?>
        							    <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label"><?php __('lblBookingPassword'); ?></label>
        
                                                <input type="password" name="c_password" id="c_password" class="form-control<?php echo $tpl['option_arr']['o_bf_include_email'] == 3 ? ' fdRequired required' : NULL; ?>" data-msg-required="<?php __('tr_field_required', false, true);?>"/>
                                            </div>
                                        </div><!-- /.col-md-3 -->
        							    <?php
        							    $field++;
        							}
        							if($field == 4)
        							{
        							    $ob_fields = ob_get_contents();
        							    ob_end_clean();
        							    ?>
        							    <div class="row">
        							    	<?php echo $ob_fields;?>
        							    </div><!-- /.row -->
        							    <?php
        							    ob_start();
        							    $field = 0;
        							}
        							if (in_array($tpl['option_arr']['o_bf_include_phone'], array(2, 3)))
        							{
        							    ?>
        							    <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label"><?php __('lblBookingPhone'); ?></label>
        
                                                <input type="text" name="c_phone" id="c_phone" class="form-control<?php echo $tpl['option_arr']['o_bf_include_phone'] == 3 ? ' fdRequired required' : NULL; ?>" data-msg-required="<?php __('tr_field_required', false, true);?>"/>
                                            </div>
                                        </div><!-- /.col-md-3 -->
        							    <?php
        							    $field++;
        							}
        							if($field == 4)
        							{
        							    $ob_fields = ob_get_contents();
        							    ob_end_clean();
        							    ?>
        							    <div class="row">
        							    	<?php echo $ob_fields;?>
        							    </div><!-- /.row -->
        							    <?php
        							    ob_start();
        							    $field = 0;
        							}
        							if (in_array($tpl['option_arr']['o_bf_include_company'], array(2, 3)))
        							{
        							    ?>
        							    <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label"><?php __('lblBookingCompany'); ?></label>
        
                                                <input type="text" name="c_company" id="c_company" class="form-control<?php echo $tpl['option_arr']['o_bf_include_company'] == 3 ? ' fdRequired required' : NULL; ?>" data-msg-required="<?php __('tr_field_required', false, true);?>"/>
                                            </div>
                                        </div><!-- /.col-md-3 -->
        							    <?php
        							    $field++;
        							}
        							if($field == 4)
        							{
        							    $ob_fields = ob_get_contents();
        							    ob_end_clean();
        							    ?>
        							    <div class="row">
        							    	<?php echo $ob_fields;?>
        							    </div><!-- /.row -->
        							    <?php
        							    ob_start();
        							    $field = 0;
        							}
        							if (in_array($tpl['option_arr']['o_bf_include_address'], array(2, 3)))
        							{
        							    ?>
        							    <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label"><?php __('lblBookingAddress'); ?></label>
        
                                                <input type="text" name="c_address" id="c_address" class="form-control<?php echo $tpl['option_arr']['o_bf_include_address'] == 3 ? ' fdRequired required' : NULL; ?>" data-msg-required="<?php __('tr_field_required', false, true);?>"/>
                                            </div>
                                        </div><!-- /.col-md-3 -->
        							    <?php
        							    $field++;
        							}
        							if($field == 4)
        							{
        							    $ob_fields = ob_get_contents();
        							    ob_end_clean();
        							    ?>
        							    <div class="row">
        							    	<?php echo $ob_fields;?>
        							    </div><!-- /.row -->
        							    <?php
        							    ob_start();
        							    $field = 0;
        							}
        							if (in_array($tpl['option_arr']['o_bf_include_city'], array(2, 3)))
        							{
        							    ?>
        							    <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label"><?php __('lblBookingCity'); ?></label>
        
                                                <input type="text" name="c_city" id="c_city" class="form-control<?php echo $tpl['option_arr']['o_bf_include_city'] == 3 ? ' fdRequired required' : NULL; ?>" data-msg-required="<?php __('tr_field_required', false, true);?>"/>
                                            </div>
                                        </div><!-- /.col-md-3 -->
        							    <?php
        							    $field++;
        							}
        							if($field == 4)
        							{
        							    $ob_fields = ob_get_contents();
        							    ob_end_clean();
        							    ?>
        							    <div class="row">
        							    	<?php echo $ob_fields;?>
        							    </div><!-- /.row -->
        							    <?php
        							    ob_start();
        							    $field = 0;
        							}
        							if (in_array($tpl['option_arr']['o_bf_include_state'], array(2, 3)))
        							{
        							    ?>
        							    <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label"><?php __('lblBookingState'); ?></label>
        
                                                <input type="text" name="c_state" id="c_state" class="form-control<?php echo $tpl['option_arr']['o_bf_include_state'] == 3 ? ' fdRequired required' : NULL; ?>" data-msg-required="<?php __('tr_field_required', false, true);?>"/>
                                            </div>
                                        </div><!-- /.col-md-3 -->
        							    <?php
        							    $field++;
        							}
        							if($field == 4)
        							{
        							    $ob_fields = ob_get_contents();
        							    ob_end_clean();
        							    ?>
        							    <div class="row">
        							    	<?php echo $ob_fields;?>
        							    </div><!-- /.row -->
        							    <?php
        							    ob_start();
        							    $field = 0;
        							}
        							if (in_array($tpl['option_arr']['o_bf_include_zip'], array(2, 3)))
        							{
        							    ?>
        							    <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label"><?php __('lblBookingZip'); ?></label>
        
                                                <input type="text" name="c_zip" id="c_zip" class="form-control<?php echo $tpl['option_arr']['o_bf_include_zip'] == 3 ? ' fdRequired required' : NULL; ?>" data-msg-required="<?php __('tr_field_required', false, true);?>"/>
                                            </div>
                                        </div><!-- /.col-md-3 -->
        							    <?php
        							    $field++;
        							}
        							if($field == 4)
        							{
        							    $ob_fields = ob_get_contents();
        							    ob_end_clean();
        							    ?>
        							    <div class="row">
        							    	<?php echo $ob_fields;?>
        							    </div><!-- /.row -->
        							    <?php
        							    ob_start();
        							    $field = 0;
        							}
        							if (in_array($tpl['option_arr']['o_bf_include_country'], array(2, 3)))
        							{
        							    ?>
        							    <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label"><?php __('lblBookingCountry'); ?></label>
        
                                                <select name="c_country" id="c_country" class="form-control select-item<?php echo $tpl['option_arr']['o_bf_include_country'] == 3 ? ' fdRequired required' : NULL; ?>" data-msg-required="<?php __('tr_field_required', false, true);?>">
                									<option value="">-- <?php __('lblChoose'); ?>--</option>
                									<?php
                									foreach ($tpl['country_arr'] as $v)
                									{
                										?><option value="<?php echo $v['id']; ?>"><?php echo pjSanitize::html($v['name']); ?></option><?php
                									}
                									?>
                								</select>
                                            </div>
                                        </div><!-- /.col-md-3 -->
        							    <?php
        							    $field++;
        							}
        							if($field > 0)
        							{
        							    $ob_fields = ob_get_contents();
        							    ob_end_clean();
        							    ?>
        							    <div class="row">
        							    	<?php echo $ob_fields;?>
        							    </div><!-- /.row -->
        							    <?php
        							}
                                	?>
                                </div><!-- /.new-client-area -->
                                
                                <?php
                                ob_start();
                                $field = 0;
                                
        						if (in_array($tpl['option_arr']['o_bf_include_airline_company'], array(2, 3)))
        						{
        						    ?>
        						    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label"><?php __('lblBookingAirlineCompany'); ?></label>
        
                                            <input type="text" name="c_airline_company" id="c_airline_company" value="<?php echo pjSanitize::html($tpl['arr']['c_airline_company']);?>" class="form-control<?php echo $tpl['option_arr']['o_bf_include_airline_company'] == 3 ? ' required' : NULL; ?>" />
                                        </div>
                                    </div><!-- /.col-md-3 -->
        						    <?php
        						    $field++;
        						}
        						if (in_array($tpl['option_arr']['o_bf_include_flight_number'], array(2, 3)))
        						{
        						    ?>
        						    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label"><?php __('lblArrivalFlightNumber'); ?></label>
        
                                            <input type="text" name="c_flight_number" id="c_flight_number" value="<?php echo pjSanitize::html($tpl['arr']['c_flight_number']);?>" class="form-control<?php echo $tpl['option_arr']['o_bf_include_flight_number'] == 3 ? ' required' : NULL; ?>" />
                                        </div>
                                    </div><!-- /.col-md-3 -->
        						    <?php
        						    $field++;
        						}
        						if (in_array($tpl['option_arr']['o_bf_include_flight_time'], array(2, 3)))
        						{
        						    ?>
        						    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label"><?php __('lblFlightArrivalTime'); ?></label>
                                            
                                            <div class="input-group clockpicker" data-rel="from">
        										<span class="input-group-addon">
        											<span class="glyphicon glyphicon-time" aria-hidden="true"></span>
        										</span>
        										<input type="text" name="c_flight_time" id="c_flight_time" value="<?php echo date($tpl['option_arr']['o_time_format'], strtotime($tpl['arr']['c_flight_time'])); ?>" class="form-control<?php echo $tpl['option_arr']['o_bf_include_flight_time'] == 3 ? ' required' : NULL; ?>" readonly="readonly"/>
        									</div>
                                        </div>
                                    </div><!-- /.col-md-3 -->
        						    <?php
        						    $field++;
        						}
        						if($field == 4)
        						{
        						    $ob_fields = ob_get_contents();
        						    ob_end_clean();
        						    ?>
        						    <div class="row">
        						    	<?php echo $ob_fields;?>
        						    </div><!-- /.row -->
        						    <?php
        						    ob_start();
        						    $field = 0;
        						}
        						if (in_array($tpl['option_arr']['o_bf_include_terminal'], array(2, 3)))
        						{
        						    ?>
        						    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label"><?php __('lblBookingTerminal'); ?></label>
        
                                            <input type="text" name="c_terminal" id="c_terminal" value="<?php echo pjSanitize::html($tpl['arr']['c_terminal']);?>" class="form-control<?php echo $tpl['option_arr']['o_bf_include_terminal'] == 3 ? ' required' : NULL; ?>" />
                                        </div>
                                    </div><!-- /.col-md-3 -->
        						    <?php
        						    $field++;
        						}
        						if($field > 0)
        						{
        						    $ob_fields = ob_get_contents();
        						    ob_end_clean();
        						    ?>
        						    <div class="row">
        						    	<?php echo $ob_fields;?>
        						    </div><!-- /.row -->
        						    <?php
        						}
        						if (in_array($tpl['option_arr']['o_bf_include_notes'], array(2, 3)))
        						{
        						    ?>
        						    <div class="row">
            						    <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label"><?php __('lblBookingNotes'); ?></label>
            
                                                <textarea name="c_notes" id="c_notes" rows="4" class="form-control<?php echo $tpl['option_arr']['o_bf_include_notes'] == 3 ? ' required' : NULL; ?>"></textarea>
                                            </div>
                                        </div><!-- /.col-md-3 -->
                                    </div>
        						    <?php
        						}
                                ?>
                                
                                <div class="hr-line-dashed"></div>
                                <div class="clearfix">
                                    <button type="submit" class="ladda-button btn btn-primary btn-lg btn-phpjabbers-loader pull-left" data-style="zoom-in" style="margin-right: 15px;">
                                        <span class="ladda-label"><?php __('btnSave'); ?></span>
                                        <?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
                                    </button>
                                    <a class="btn btn-white btn-lg pull-right" href="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminBookings&action=pjActionIndex"><?php __('btnCancel'); ?></a>
                                </div><!-- /.clearfix -->
                			</div><!-- /.panel-body -->
        				</div><!-- /.tab-pane -->
        			</div><!-- /.tab-content -->
        			
					<input type="hidden" id="sub_total" name="sub_total" value="<?php echo $tpl['arr']['sub_total'];?>" data-price="<?php echo $price_per_person;?>" data-return_price="<?php echo $return_price_per_person;?>"/>
					<input type="hidden" id="tax" name="tax" value="<?php echo $tpl['arr']['tax'];?>" />
					<input type="hidden" id="total" name="total" value="<?php echo $tpl['arr']['total'];?>" />
					<input type="hidden" id="deposit" name="deposit" value="<?php echo $tpl['arr']['deposit'];?>" />
					
                    <input type="hidden" id="price_per_person" name="price_per_person" value="<?php echo $price_per_person;?>"/>
					<input type="hidden" id="return_price_per_person" name="return_price_per_person" value="<?php echo $return_price_per_person;?>"/>
		            
				</form>
			</div><!-- /.tabs-container tabs-reservations m-b-lg -->
		</div><!-- /.col-lg-8 -->
		
		<div class="col-lg-4">
			<?php
        	$bg_class = 'bg-' . $tpl['arr']['status'];
        	?>
        	<div id="pjFdPriceWrapper" class="panel no-borders">
        		<div class="panel-heading <?php echo $bg_class;?>">
                    <p class="lead m-n">
                        <i class="fa fa-check"></i> <?php __('lblStatus');?>: <span class="pull-right status-text"><?php __('booking_statuses_ARRAY_' . $tpl['arr']['status'])?></span>
                    </p>
                </div>
                <div class="panel-body">
                	
                	<p class="lead m-b-xs"><span><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionConfirmation&amp;id=<?php echo $tpl['arr']['id']; ?>" data-remote="false" data-toggle="modal" data-target="#modalConfirmation" class="btn btn-primary btn-md btn-block btn-outline"><i class="fa fa-bell-o"></i> <?php __('lblResendConfirmation'); ?></a></span></p>

                    <p class="lead m-b-xs text-right"><span><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionPrint&amp;id=<?php echo $tpl['arr']['id']; ?>" class="btn btn-primary btn-block btn-md btn-outline" target="_blank"><i class="fa fa-print"></i> <?php __('lblPrintReservation'); ?></a></span></p>

                    <p class="lead m-b-xs text-right"><span><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionSendSms&amp;id=<?php echo $tpl['arr']['id']; ?>" data-remote="false" data-toggle="modal" data-target="#modalSendSMS" class="btn btn-primary btn-block btn-md btn-outline"><i class="fa fa-bell-o"></i> <?php __('lblSendSMSNotification'); ?></a></span></p>

                    <div class="hr-line-dashed"></div>
                        
                    <p class="lead m-b-md">
                        <?php __('lblSubTotal');?>: <span id="sub_total_label" class="pull-right"><?php echo pjCurrency::formatPrice($tpl['arr']['sub_total']);?></span>
                    </p>
                    <p class="lead m-b-md">
                        <?php __('lblTax');?>: <span id="tax_label" class="pull-right"><?php echo pjCurrency::formatPrice($tpl['arr']['tax']);?></span>
                    </p>
                    <div class="hr-line-dashed"></div>
                    <h3 class="lead m-b-md">
                        <?php __('lblTotal');?>: <span id="total_label" class="pull-right"><?php echo pjCurrency::formatPrice($tpl['arr']['total']);?></span>
                    </h3>
                    <p class="lead m-b-md">
                        <?php __('lblDeposit');?>: <span id="deposit_label" class="pull-right"><?php echo pjCurrency::formatPrice($tpl['arr']['deposit']);?></span>
                    </p>
                </div><!-- /.panel-body -->
        	</div>
		</div><!-- /.col-lg-4 -->
	</div><!-- /.row -->
</div><!-- /.wrapper wrapper-content animated fadeInRight -->

<div class="modal fade" id="modalConfirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only"><?php __('plugin_base_btn_close') ?></span>
                </button>
                <h4 class="modal-title" id="myModalLabel" style="line-height: 34px; margin-right: 50px;">
                    <?php __('booking_confirmation_title') ?>
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body"></div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"><?php __('btnSend') ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php __('plugin_base_btn_close') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSendSMS" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only"><?php __('plugin_base_btn_close') ?></span>
                </button>
                <h4 class="modal-title" id="myModalLabel" style="line-height: 34px; margin-right: 50px;">
                    <?php __('lblSendSMSNotification') ?>
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body"></div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"><?php __('btnSend') ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php __('plugin_base_btn_close') ?></button>
            </div>
        </div>
    </div>
</div>

<?php
$show_period = 'false';
if((strpos($tpl['option_arr']['o_time_format'], 'a') > -1 || strpos($tpl['option_arr']['o_time_format'], 'A') > -1))
{
    $show_period = 'true';
}
?>
<script type="text/javascript">
	
var myLabel = myLabel || {};
myLabel.showperiod = <?php echo $show_period; ?>;
myLabel.choose = <?php x__encode('lblChoose'); ?>;
myLabel.maximum = <?php echo x__encode('lblMaximum', true, false)?>;
myLabel.positive_number = <?php x__encode('lblPositiveNumber'); ?>;
myLabel.max_number = <?php x__encode('lblMaxNumber'); ?>;
	
</script>