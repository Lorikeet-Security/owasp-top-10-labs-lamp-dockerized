<div style="margin: 0 auto; width: 100%;">
	<?php
	$cancel_err = __('cancel_err', true, false);
	$payment_methods = __('payment_methods', true, false);
	if (isset($tpl['status']))
	{
		switch ($tpl['status'])
		{
			case 1:
				?><p><?php echo $cancel_err[1]; ?></p><?php
				break;
			case 2:
				?><p><?php echo $cancel_err[2]; ?></p><?php
				break;
			case 3:
				?><p><?php echo $cancel_err[3]; ?></p><?php
				break;
			case 4:
				?><p><?php echo $cancel_err[4]; ?></p><?php
				break;
		}
	} else {
		
		if ($controller->_get->check('err'))
		{
		    switch ($controller->_get->toInt('err'))
			{
				case 200:
					?><p><?php echo $cancel_err[200]; ?></p><?php
					break;
			}
		}
		
		if (isset($tpl['arr']))
		{
			$name_titles = __('personal_titles', true, false);
			$booking_date = NULL;
			if (isset($tpl['arr']['booking_date']) && !empty($tpl['arr']['booking_date']))
			{
			    $tm = strtotime($tpl['arr']['booking_date'] . ', ' . $tpl['arr']['booking_time']);
				$booking_date = date($tpl['option_arr']['o_date_format'], $tm) . ", " . date($tpl['option_arr']['o_time_format'], $tm);
			}
			?>
			<table class="table" cellspacing="2" cellpadding="5" style="width: 100%">
				<thead>
					<tr>
						<th colspan="2" style="text-transform: uppercase; text-align: left"><?php __('front_booking_details'); ?></th>
					</tr>
				</thead>
				<tbody>	
					<tr>
						<td><?php __('front_booking_id'); ?></td>
						<td><?php echo $tpl['arr']['uuid']; ?></td>
					</tr>
					<tr>
						<td><?php __('front_date_time'); ?></td>
						<td><?php echo $booking_date; ?></td>
					</tr>
					<tr>
						<td><?php __('front_pickup'); ?></td>
						<td><?php echo $tpl['arr']['traveling'] == 'from' ? pjSanitize::html($tpl['arr']['from_location']) : pjSanitize::html($tpl['arr']['to_location']); ?> (<?php echo $tpl['arr']['traveling'] == 'from' ? pjSanitize::html($tpl['arr']['from_address']) : pjSanitize::html($tpl['arr']['to_address']); ?>)</td>
					</tr>
					<tr>
						<td><?php __('front_dropoff'); ?></td>
						<td><?php echo $tpl['arr']['traveling'] == 'from' ? pjSanitize::html($tpl['arr']['to_location']) : pjSanitize::html($tpl['arr']['from_location']); ?> (<?php echo $tpl['arr']['traveling'] == 'from' ? pjSanitize::html($tpl['arr']['to_address']) : pjSanitize::html($tpl['arr']['from_address']); ?>)</td>
					</tr>
					<tr>
						<td><?php __('front_ride'); ?></td>
						<td><?php echo pjSanitize::html($tpl['arr']['line']); ?></td>
					</tr>
					<?php
					if($tpl['arr']['has_return'] == 'T')
					{
						$return_booking_date = NULL;
						if (isset($tpl['arr']['return_date']) && !empty($tpl['arr']['return_date']))
						{
							$tm = strtotime($tpl['arr']['return_date'] . ', ' . $tpl['arr']['return_time']);
							$return_booking_date = date($tpl['option_arr']['o_date_format'], $tm) . ", " . date($tpl['option_arr']['o_time_format'], $tm);
						}
						?>
						<tr>
							<th colspan="2" style="text-transform: uppercase; text-align: left"><?php __('front_return_trip'); ?></td>
						</tr>
						<tr>
							<td><?php __('front_date_time'); ?></td>
							<td><?php echo $return_booking_date; ?></td>
						</tr>
						<tr>
							<td><?php __('front_pickup'); ?></td>
							<td><?php echo $tpl['arr']['traveling'] == 'from' ? pjSanitize::html($tpl['arr']['to_location']) : pjSanitize::html($tpl['arr']['from_location']); ?> (<?php echo $tpl['arr']['traveling'] == 'from' ? pjSanitize::html($tpl['arr']['to_address']) : pjSanitize::html($tpl['arr']['from_address']); ?>)</td>
						</tr>
						<tr>
							<td><?php __('front_dropoff'); ?></td>
							<td><?php echo $tpl['arr']['traveling'] == 'from' ? pjSanitize::html($tpl['arr']['from_location']) : pjSanitize::html($tpl['arr']['to_location']); ?> (<?php echo $tpl['arr']['traveling'] == 'from' ? pjSanitize::html($tpl['arr']['from_address']) : pjSanitize::html($tpl['arr']['to_address']); ?>)</td>
						</tr>
						<tr>
							<td><?php __('front_ride'); ?></td>
							<td><?php echo pjSanitize::html($tpl['arr']['return_line']); ?></td>
						</tr>
						<?php
					} 
					?>
					<tr>
						<td><?php __('front_distance'); ?></td>
						<td><?php echo (int) @$tpl['arr']['distance']; ?> km</td>
					</tr>
					
					<tr>
						<td><?php __('front_passengers'); ?></td>
						<td><?php echo @$tpl['arr']['passengers']; ?></td>
					</tr>					
					<?php
					if(!empty($tpl['arr']['c_notes']))
					{ 
						?>
						<tr>
							<td><?php __('front_notes'); ?></td>
							<td><?php echo isset($tpl['arr']['c_notes']) ? nl2br(pjSanitize::clean($tpl['arr']['c_notes'])) : null;?></td>
						</tr>
						<?php
					} 
					?>
					<tr>
						<td><?php __('front_payment_medthod');?></td>
						<td><?php echo !empty($tpl['arr']['payment_method']) ? $payment_methods[$tpl['arr']['payment_method']] : '&nbsp;'; ?></td>
					</tr>
					<tr>
						<td><?php __('front_subtotal'); ?></td>
						<td><?php echo pjCurrency::formatPrice($tpl['arr']['sub_total']); ?></td>
					</tr>
					<tr>
						<td><?php __('front_tax'); ?></td>
						<td><?php echo pjCurrency::formatPrice($tpl['arr']['tax']); ?></td>
					</tr>
					<tr>
						<td><?php __('front_total'); ?></td>
						<td><?php echo pjCurrency::formatPrice($tpl['arr']['total']); ?></td>
					</tr>
					<tr>
						<td><?php __('front_deposit_required'); ?></td>
						<td><?php echo pjCurrency::formatPrice($tpl['arr']['deposit']); ?></td>
					</tr>
					<?php
					if($tpl['arr']['payment_method'] == 'paypal')
					{ 
						?>
						<tr>
							<td><?php __('front_label_txn_id'); ?></td>
							<td><?php echo stripslashes($tpl['arr']['txn_id']); ?></td>
						</tr>
						<tr>
							<td><?php __('front_processed_on'); ?></td>
							<td><?php echo !empty($tpl['arr']['processed_on']) ? date($tpl['option_arr']['o_date_format'], strtotime($tpl['arr']['processed_on'])) . ' ' . date($tpl['option_arr']['o_time_format'], strtotime($tpl['arr']['processed_on'])) : null; ?></td>
						</tr>
						<?php
					} 
					$name_arr = pjUtil::splitName($tpl['client']['name']);
					?>
					<tr>
						<th colspan="2" style="text-transform: uppercase; text-align: left"><?php __('front_personal_details'); ?></td>
					</tr>
					<tr>
						<td><?php __('front_title'); ?></td>
						<td><?php echo !empty($tpl['client']['title']) ? $name_titles[$tpl['client']['title']] : null; ?></td>
					</tr>
					<tr>
						<td><?php __('front_fname'); ?></td>
						<td><?php echo pjSanitize::clean($name_arr[0]); ?></td>
					</tr>
					<tr>
						<td><?php __('front_lname'); ?></td>
						<td><?php echo pjSanitize::clean($name_arr[1]); ?></td>
					</tr>
					<tr>
						<td><?php __('front_phone'); ?></td>
						<td><?php echo pjSanitize::clean($tpl['client']['phone']); ?></td>
					</tr>
					<tr>
						<td><?php __('front_email'); ?></td>
						<td><?php echo pjSanitize::clean($tpl['client']['email']); ?></td>
					</tr>
					<tr>
						<td><?php __('front_company'); ?></td>
						<td><?php echo pjSanitize::clean($tpl['client']['company']); ?></td>
					</tr>
					
					<tr>
						<td><?php __('front_address'); ?></td>
						<td><?php echo pjSanitize::clean($tpl['client']['address']); ?></td>
					</tr>
					<tr>
						<td><?php __('front_city'); ?></td>
						<td><?php echo pjSanitize::clean($tpl['client']['city']); ?></td>
					</tr>
					<tr>
						<td><?php __('front_state'); ?></td>
						<td><?php echo pjSanitize::clean($tpl['client']['state']); ?></td>
					</tr>
					<tr>
						<td><?php __('front_zip'); ?></td>
						<td><?php echo pjSanitize::clean($tpl['client']['zip']); ?></td>
					</tr>
					<tr>
						<td><?php __('front_country'); ?></td>
						<td><?php echo pjSanitize::clean($tpl['client']['country_title']); ?></td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td>&nbsp;</td>
						<td>
							<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjFrontEnd&amp;action=pjActionCancel" method="post">
								<input type="hidden" name="booking_cancel" value="1" />
								<input type="hidden" name="id" value="<?php echo $controller->_get->toInt('id'); ?>" />
								<input type="hidden" name="hash" value="<?php echo $controller->_get->toString('hash'); ?>" />
								<input type="submit" value="<?php __('front_btn_cancel'); ?>" />
							</form>
						</td>
					</tr>
				</tfoot>
			</table>
			<?php
		}
	}
	?>
</div>
	