<?php
include_once dirname(__FILE__) . '/elements/header.php';

$SEARCH = @$_SESSION[$controller->defaultStore]['search'];
$STORE = @$_SESSION[$controller->defaultStore];
$FORM = @$_SESSION[$controller->defaultForm];
$traveling = $SEARCH['traveling'];
$index = $controller->_get->toInt('index');
?>
<div class="pjSbs-body">
	<form id="pjSbsPreviewForm_<?php echo $index;?>" action="#" method="post">
		<input type="hidden" name="sbs_preview" value="1" />
		
		<div class="pjSbs-box">
			<div class="pjSbs-box-title"><?php __('front_booking_details');?></div><!-- /.pjSbs-box-title -->
			
			<ul class="pjSbs-extras">
				<?php
				$pickup_datetime_ts = strtotime(pjDateTime::formatDate($SEARCH['booking_date'], $tpl['option_arr']['o_date_format']) . ' ' . $STORE['time']);
				$pickup_datetime_text = date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], $pickup_datetime_ts);
				if($traveling == 'from')
				{
					$dropoff_datetime_text = date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], $pickup_datetime_ts + $tpl['line_detail_arr']['duration_dropoff'] * 60);
				}else{
					$dropoff_datetime_text = date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], $pickup_datetime_ts + $tpl['line_detail_arr']['duration_pickup'] * 60);
				} 
				?>
				<li>
					<div class="row">
						<div class="col-sm-6 col-xs-12">
							<p>
								<span><?php __('front_pickup');?></span>
								<br/>
								<strong><?php echo $traveling == 'from' ? pjSanitize::html($tpl['from_location']['title']) : pjSanitize::html($tpl['to_location']['title']);?></strong>
								<br/>
								<small><?php echo $pickup_datetime_text;?></small>
							</p>
						</div><!-- /.col-sm-6 -->
						<div class="col-sm-6 col-xs-12">
							<p>
								<span><?php __('front_dropoff');?></span>
								<br/>
								<strong><?php echo $traveling == 'from' ? pjSanitize::html($tpl['to_location']['title']) : pjSanitize::html($tpl['from_location']['title']);?></strong>
								<br/>
								<small><?php echo $dropoff_datetime_text;?></small>
							</p>
						</div><!-- /.col-sm-6 -->
					</div><!-- /.row -->
				</li>
				<?php
				if(isset($SEARCH['has_return']))
				{
				    $return_pickup_datetime_ts = strtotime(pjDateTime::formatDate($SEARCH['return_date'], $tpl['option_arr']['o_date_format']) . ' ' . $STORE['return_time']);
					$return_pickup_datetime_text = date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], $return_pickup_datetime_ts);
					if($traveling == 'from')
					{
						$return_dropoff_datetime_text = date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], $return_pickup_datetime_ts + $tpl['return_line_detail_arr']['duration_pickup'] * 60);
					}else{
						$return_dropoff_datetime_text = date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], $return_pickup_datetime_ts + $tpl['return_line_detail_arr']['duration_dropoff'] * 60);
					}
					?>
					<li>
						<div class="row">
							<div class="col-sm-6 col-xs-12">
								<p>
									<span><?php __('front_pickup');?></span>
									<br/>
									<strong><?php echo pjSanitize::html($tpl['to_location']['title']);?></strong>
									<br/>
									<small><?php echo $return_pickup_datetime_text;?></small>
								</p>
							</div><!-- /.col-sm-6 -->
							<div class="col-sm-6 col-xs-12">
								<p>
									<span><?php __('front_dropoff');?></span>
									<br/>
									<strong><?php echo pjSanitize::html($tpl['from_location']['title']);?></strong>
									<br/>
									<small><?php echo $return_dropoff_datetime_text;?></small>
								</p>
							</div><!-- /.col-sm-6 -->
						</div><!-- /.row -->
					</li>
					<?php
				} 
				?>
				<li>
					<div class="row">
						<div class="col-sm-6 col-xs-12">
							<p>
								<span><?php __('front_passengers');?></span>
								<br/>
								<strong><?php echo $SEARCH['passengers']?></strong>
							</p>
						</div><!-- /.col-sm-6 -->
						<div class="col-sm-6 col-xs-12">
							<p>
								<span><?php __('front_distance');?></span>
								<br/>
								<strong><?php echo $SEARCH['distance'];?> <?php echo $tpl['option_arr']['o_mileage'] == 'km' ? 'km' : ($SEARCH['distance'] == 1 ? 'mile' : __('front_miles', true)) ;?></strong>
							</p>
						</div><!-- /.col-sm-6 -->
					</div>
				</li>
				<?php
				if($tpl['option_arr']['o_payment_disable'] == 'No' && isset($FORM['payment_method']) && $FORM['payment_method'] != '')
				{
				    $payment_methods = $tpl['payment_titles'];
					?>
					<li>
						<div class="row">
							<div class="<?php echo isset($FORM['payment_method']) && $FORM['payment_method'] == 'bank' ? 'col-sm-6' : 'col-sm-12';?> col-xs-12">
								<p>
									<span><?php __('front_payment_medthod'); ?></span>
									<br/>
									<strong><?php $payment_methods = __('payment_methods', true, false); echo $payment_methods[$FORM['payment_method']];?></strong>
								</p>
							</div><!-- /.col-sm-6 -->
							
							<div style="display: <?php echo isset($FORM['payment_method']) && $FORM['payment_method'] == 'bank' ? 'block' : 'none'; ?>">
								<div class="col-sm-6 col-xs-12">
									<p>
										<span><?php __('front_bank_account'); ?></span><br/>
				
										<strong>
											<?php echo nl2br(pjSanitize::html($tpl['bank_account'])); ?>
										</strong>
									</p>
								</div><!-- /.col-sm-6 -->
							</div>
						</div>
					</li>
					<?php
				} 
				?>
			</ul>
		</div><!-- .pjSbs-box -->
		<?php
		$subtotal = $tpl['price_arr']['sub_total'];
		$tax = $tpl['price_arr']['tax'];
		$total = $tpl['price_arr']['total'];
		$deposit = $tpl['price_arr']['deposit'];
		if(isset($SEARCH['has_return']))
		{
			$subtotal += $tpl['return_price_arr']['sub_total'];
			$tax += $tpl['return_price_arr']['tax'];
			$total += $tpl['return_price_arr']['total'];
			$deposit += $tpl['return_price_arr']['deposit'];
		} 
		?>
		<div class="pjSbs-box">
			<ul class="pjSbs-extras">
				<li>
					<div class="row">
						<div class="col-xs-6">
							<em><?php __('front_subtotal');?></em>
						</div><!-- /.col-md-6 -->
	
						<div class="col-md-2 col-md-offset-4 col-xs-6 text-right">
							<strong><?php echo pjCurrency::formatPrice($subtotal);?></strong>
						</div><!-- /.col-md-2 -->
					</div><!-- /.row -->
				</li>
				
				<li>
					<div class="row">
						<div class="col-xs-6">
							<em><?php __('front_tax');?></em>
						</div><!-- /.col-md-6 -->
	
						<div class="col-md-2 col-md-offset-4 col-xs-6 text-right">
							<strong><?php echo pjCurrency::formatPrice($tax);?></strong>
						</div><!-- /.col-md-2 -->
					</div><!-- /.row -->
				</li>
	
				<li>
					<div class="row">
						<div class="col-xs-6">
							<em><?php __('front_total');?></em>
						</div><!-- /.col-md-6 -->
	
						<div class="col-md-2 col-md-offset-4 col-xs-6 text-right">
							<strong><?php echo pjCurrency::formatPrice($total);?></strong>
						</div><!-- /.col-md-2 -->
					</div><!-- /.row -->
				</li>
	
				<li>
					<div class="row">
						<div class="col-xs-6">
							<em><?php __('front_deposit_required');?></em>
						</div><!-- /.col-md-6 -->
	
						<div class="col-md-2 col-md-offset-4 col-xs-6 text-right">
							<strong><?php echo pjCurrency::formatPrice($deposit);?></strong>
						</div><!-- /.col-md-2 -->
					</div><!-- /.row -->
				</li>
			</ul>
		</div><!-- pjSbs-box -->
		<div class="pjSbs-box">
	
			<div class="pjSbs-box-title"><?php __('front_personal_details');?></div><!-- /.pjSbs-box-title -->
			
			<div class="pjSbs-personal-details">
				<div class="row">
					<?php
					if (in_array($tpl['option_arr']['o_bf_include_title'], array(2, 3)) && isset($FORM['c_title']) && $FORM['c_title'] != '')
					{ 
						$title = NULL;
						$name_titles = __('personal_titles', true, false);
						if(isset($FORM['c_title']) && $FORM['c_title'] != '')
						{
							$title = $FORM['c_title'];
						}
						?>
						<div class="col-sm-6 col-xs-12">
							<p>
								<span><?php __('front_title'); ?>:</span>
		
								<strong><?php echo $name_titles[$title];?></strong>
							</p>
						</div><!-- /.col-sm-6 -->
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_include_fname'], array(2, 3)) && isset($FORM['c_fname']) && $FORM['c_fname'] != ''){
						?>
						<div class="col-sm-6 col-xs-12">
							<p>
								<span><?php __('front_fname'); ?></span>
								<strong>
									<?php echo isset($FORM['c_fname']) ? pjSanitize::clean($FORM['c_fname']) : null;?>
								</strong>
							</p>
						</div><!-- /.col-sm-6 -->
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_include_lname'], array(2, 3)) && isset($FORM['c_lname']) && $FORM['c_lname'] != ''){
						?>
						<div class="col-sm-6 col-xs-12">
							<p>
								<span><?php __('front_lname'); ?></span>
								<strong>
									<?php echo isset($FORM['c_lname']) ? pjSanitize::clean($FORM['c_lname']) : null;?>
								</strong>
							</p>
						</div><!-- /.col-sm-6 -->
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_include_phone'], array(2, 3)) && isset($FORM['c_phone']) && $FORM['c_phone'] != ''){
						?>
						<div class="col-sm-6 col-xs-12">
							<p>
								<span><?php __('front_phone'); ?></span>
								<strong>
									<?php echo isset($FORM['c_phone']) ? pjSanitize::clean($FORM['c_phone']) : null;?>
								</strong>
							</p>
						</div><!-- /.col-sm-6 -->
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_include_email'], array(2, 3)) && isset($FORM['c_email']) && $FORM['c_email'] != ''){ 
						?>
						<div class="col-sm-6 col-xs-12">
							<p>
								<span><?php __('front_email'); ?></span>
								<strong>
									<?php echo isset($FORM['c_email']) ? pjSanitize::clean($FORM['c_email']) : null;?>
								</strong>
							</p>
						</div><!-- /.col-sm-6 -->
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_include_company'], array(2, 3)) && isset($FORM['c_company']) && $FORM['c_company'] != ''){ 
						?>
						<div class="col-sm-6 col-xs-12">
							<p>
								<span><?php __('front_company'); ?></span>
								<strong>
									<?php echo isset($FORM['c_company']) ? pjSanitize::clean($FORM['c_company']) : null;?>
								</strong>
							</p>
						</div><!-- /.col-sm-6 -->
						<?php
					}
					
					if (in_array($tpl['option_arr']['o_bf_include_address'], array(2, 3)) && isset($FORM['c_address']) && $FORM['c_address'] != ''){ 
						?>
						<div class="col-sm-6 col-xs-12">
							<p>
								<span><?php __('front_address'); ?></span>
								<strong>
									<?php echo isset($FORM['c_address']) ? pjSanitize::clean($FORM['c_address']) : null;?>
								</strong>
							</p>
						</div><!-- /.col-sm-6 -->
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_include_city'], array(2, 3)) && isset($FORM['c_city']) && $FORM['c_city'] != ''){ 
						?>
						<div class="col-sm-6 col-xs-12">
							<p>
								<span><?php __('front_city'); ?></span>
								<strong>
									<?php echo isset($FORM['c_city']) ? pjSanitize::clean($FORM['c_city']) : null;?>
								</strong>
							</p>
						</div><!-- /.col-sm-6 -->
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_include_state'], array(2, 3)) && isset($FORM['c_state']) && $FORM['c_state'] != ''){ 
						?>
						<div class="col-sm-6 col-xs-12">
							<p>
								<span><?php __('front_state'); ?></span>
								<strong>
									<?php echo isset($FORM['c_state']) ? pjSanitize::clean($FORM['c_state']) : null;?>
								</strong>
							</p>
						</div><!-- /.col-sm-6 -->
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_include_zip'], array(2, 3)) && isset($FORM['c_country']) && $FORM['c_country'] != ''){ 
						?>
						<div class="col-sm-6 col-xs-12">
							<p>
								<span><?php __('front_zip'); ?></span>
								<strong>
									<?php echo isset($FORM['c_zip']) ? pjSanitize::clean($FORM['c_zip']) : null;?>
								</strong>
							</p>
						</div><!-- /.col-sm-6 -->
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_include_country'], array(2, 3)) && isset($FORM['c_country']) && $FORM['c_country'] != ''){ 
						?>
						<div class="col-sm-6 col-xs-12">
							<p>
								<span><?php __('front_country'); ?></span>
								<strong>
									<?php echo !empty($tpl['country_arr']) ? $tpl['country_arr']['country_title'] : null;?>
								</strong>
							</p>
						</div><!-- /.col-sm-6 -->
						<?php
					}
					?>
				</div><!-- /.row -->
				<?php
				if (in_array($tpl['option_arr']['o_bf_include_notes'], array(2, 3)) && isset($FORM['c_notes']) && $FORM['c_notes'] != ''){ 
					?>
					<p>
						<span><?php __('front_notes'); ?></span>
		
						<strong><?php echo isset($FORM['c_notes']) ? nl2br(pjSanitize::clean($FORM['c_notes'])) : null;?></strong>
					</p>
					<?php
				}
				if( (in_array($tpl['option_arr']['o_bf_include_airline_company'], array(2, 3)) && isset($FORM['c_airline_company']) && !empty($FORM['c_airline_company'])) ||
						(in_array($tpl['option_arr']['o_bf_include_flight_number'], array(2, 3)) && isset($FORM['c_flight_number']) && !empty($FORM['c_flight_number']) ) ||
						(in_array($tpl['option_arr']['o_bf_include_flight_time'], array(2, 3)) && isset($FORM['c_flight_time']) && !empty($FORM['c_flight_time']) ) ||
						(in_array($tpl['option_arr']['o_bf_include_terminal'], array(2, 3)) && isset($FORM['c_terminal']) && !empty($FORM['c_terminal']))
				){
					?>
					<div class="pjSbs-box-title"><?php __('front_flight_details');?></div><!-- /.pjSbs-box-title -->
			
					<div class="pjSbs-personal-details">
						<div class="row">
							<?php
							if (in_array($tpl['option_arr']['o_bf_include_airline_company'], array(2, 3)) && isset($FORM['c_airline_company']) && $FORM['c_airline_company'] != ''){
								?>
								<div class="col-sm-6 col-xs-12">
									<p>
										<span><?php __('front_airline_company'); ?></span>
										<strong>
											<?php echo isset($FORM['c_airline_company']) ? pjSanitize::clean($FORM['c_airline_company']) : null;?>
										</strong>
									</p>
								</div><!-- /.col-sm-6 -->
								<?php
							}
							if (in_array($tpl['option_arr']['o_bf_include_flight_number'], array(2, 3)) && isset($FORM['c_flight_number']) && $FORM['c_flight_number'] != ''){ 
								?>
								<div class="col-sm-6 col-xs-12">
									<p>
										<span><?php __('front_flight_number'); ?></span>
										<strong>
											<?php echo isset($FORM['c_flight_number']) ? pjSanitize::clean($FORM['c_flight_number']) : null;?>
										</strong>
									</p>
								</div><!-- /.col-sm-6 -->
								<?php
							}
							if (in_array($tpl['option_arr']['o_bf_include_flight_time'], array(2, 3)) && isset($FORM['c_flight_time']) && $FORM['c_flight_time'] != ''){ 
								?>
								<div class="col-sm-6 col-xs-12">
									<p>
										<span><?php $traveling == 'from' ? __('front_arrival_flight_time') : __('front_departure_flight_time');?></span>
										<strong>
											<?php echo isset($FORM['c_flight_time']) ? pjSanitize::clean($FORM['c_flight_time']) : null;?>
										</strong>
									</p>
								</div><!-- /.col-sm-6 -->
								<?php
							}
							if (in_array($tpl['option_arr']['o_bf_include_terminal'], array(2, 3)) && isset($FORM['c_terminal']) && $FORM['c_terminal'] != ''){
								?>
								<div class="col-sm-6 col-xs-12">
									<p>
										<span><?php __('front_terminal'); ?></span>
										<strong>
											<?php echo isset($FORM['c_terminal']) ? pjSanitize::clean($FORM['c_terminal']) : null;?>
										</strong>
									</p>
								</div><!-- /.col-sm-6 -->
								<?php
							} 
							?>
						</div>
					</div>
					<?php
				} 
				?>
				
			</div><!-- /.pjSbs-personal-details -->
		</div>
	
		<div class="pjSbs-body-actions">
			<div class="row">
				<div class="col-sm-3 col-xs-12">
					<a href="#" data-load="loadCheckout" class="btn btn-secondary btn-block pjSbsStepLink"><?php __('front_btn_back');?></a>
				</div><!-- /.col-sm-3 -->
	
				<div class="col-sm-3 col-sm-offset-6 col-xs-12">
					<input type="submit" value="<?php __('front_btn_confirm');?>" class="btn btn-primary btn-block" >
				</div><!-- /.col-sm-3 -->
			</div><!-- /.row -->
		</div><!-- /.pjSbs-body-actions -->
	</form>
</div><!-- /.pjSbs-body -->