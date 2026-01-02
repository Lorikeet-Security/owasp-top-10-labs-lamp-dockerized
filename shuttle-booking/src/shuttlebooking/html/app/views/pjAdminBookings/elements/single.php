<div style="overflow: hidden; margin-bottom: 16px;">
	<div style="width: 48%;margin-right: 4%;float:left;">
		<table class="table" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom: 40px;">
			<thead>
				<tr>
					<th colspan="2"><?php __('lblClientDetails');?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$statuses = __('booking_statuses', true, false);
				$payment_methods = __('payment_methods', true, false);
				$name_titles = __('personal_titles', true, false);
				$client_name_arr = array();
				if(!empty($pickup_arr['c_fname']) || !empty($pickup_arr['fname']))
				{
					$client_name_arr[] = !empty($pickup_arr['client_id']) ? pjSanitize::clean($pickup_arr['fname']) : pjSanitize::clean($pickup_arr['c_fname']);
				}
				if(!empty($pickup_arr['c_lname']) || !empty($pickup_arr['lname']))
				{
					$client_name_arr[] = !empty($pickup_arr['client_id']) ? pjSanitize::clean($pickup_arr['lname']) : pjSanitize::clean($pickup_arr['c_lname']);
				}
				if(!empty($pickup_arr['name']))
				{
					?>
					<tr class="bold">
						<td style="width:40%;"><?php __('lblName', false, false);?></td>
						<td style="width:60%;"><?php echo pjSanitize::clean($pickup_arr['name']);?></td>
					</tr>
					<?php
				}
				if(!empty($pickup_arr['email']))
				{
					?>
					<tr>
						<td style="width:40%;"><?php __('lblBookingEmail', false, false);?></td>
						<td style="width:60%;"><?php echo pjSanitize::clean($pickup_arr['email']);?></td>
					</tr>
					<?php
				}
				if(!empty($pickup_arr['phone']))
				{
					?>
					<tr>
						<td style="width:40%;"><?php __('lblBookingPhone', false, false);?></td>
						<td style="width:60%;"><?php echo pjSanitize::clean($pickup_arr['phone']);?></td>
					</tr>
					<?php
				}
				if(!empty($pickup_arr['company']))
				{
					?>
					<tr>
						<td style="width:40%;"><?php __('lblBookingCompany', false, false);?></td>
						<td style="width:60%;"><?php echo pjSanitize::clean($pickup_arr['company']);?></td>
					</tr>
					<?php
				}
				if(!empty($pickup_arr['c_notes']))
				{
					?>
					<tr>
						<td style="width:40%;"><?php __('lblBookingNotes', false, false);?></td>
						<td style="width:60%;"><?php echo nl2br(pjSanitize::clean($pickup_arr['c_notes']));?></td>
					</tr>
					<?php
				}
				if(!empty($pickup_arr['address']))
				{
					?>
					<tr>
						<td style="width:40%;"><?php __('lblBookingAddress', false, false);?></td>
						<td style="width:60%;"><?php echo pjSanitize::clean($pickup_arr['address']);?></td>
					</tr>
					<?php
				}
				if(!empty($pickup_arr['city']))
				{
					?>
					<tr>
						<td style="width:40%;"><?php __('lblBookingCity', false, false);?></td>
						<td style="width:60%;"><?php echo pjSanitize::clean($pickup_arr['city']);?></td>
					</tr>
					<?php
				}
				if(!empty($pickup_arr['state']))
				{
					?>
					<tr>
						<td style="width:40%;"><?php __('lblBookingState', false, false);?></td>
						<td style="width:60%;"><?php echo pjSanitize::clean($pickup_arr['state']);?></td>
					</tr>
					<?php
				}
				if(!empty($pickup_arr['zip']))
				{
					?>
					<tr>
						<td style="width:40%;"><?php __('lblBookingZip', false, false);?></td>
						<td style="width:60%;"><?php echo pjSanitize::clean($pickup_arr['zip']);?></td>
					</tr>
					<?php
				}
				if(!empty($pickup_arr['country']))
				{
					?>
					<tr>
						<td style="width:40%;"><?php __('lblBookingCountry', false, false);?></td>
						<td style="width:60%;"><?php echo pjSanitize::clean($pickup_arr['country']);?></td>
					</tr>
					<?php
				} 
				?>
			</tbody>
		</table>
	</div>
	<div style="width: 48%;float:right;">
		<table class="table" cellspacing="0" cellpadding="0" style="width: 100%; margin-bottom: 40px;">
			<thead>
				<tr>
					<th colspan="2"><?php __('lblTransfer');?>: <?php echo count($tpl['transfer_arr']) == 2 ? __('lblRoundTrip') : __('lblSingle');?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td style="width:40%;"><?php __('lblPassengers', false, false);?></td>
					<td style="width:60%;"><?php echo $pickup_arr['passengers'];?></td>
				</tr>				
				<tr>
					<td style="width:40%;"><?php __('lblPayment', false, false);?></td>
					<td style="width:60%;"><?php echo pjCurrency::formatPrice($pickup_arr['total']);?> / <?php echo $payment_methods[$pickup_arr['payment_method']];?></td>
				</tr>
				<tr>
					<td style="width:40%;"><?php __('lblStatus', false, false);?></td>
					<td style="width:60%;"><?php echo $statuses[$pickup_arr['status']];?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div style="overflow: hidden; margin-bottom: 16px;">
	<div style="width: 48%;margin-right: 4%;float:left;">
		<table class="table" cellspacing="0" cellpadding="0" style="width: 100%;">
			<thead>
				<tr>
					<th colspan="2"><?php __('lblPickup');?></th>
				</tr>
			</thead>
			<tbody>
				<tr class="bold">
					<td style="width:40%;"><?php __('lblDateAndTime', false, false);?></td>
					<td style="width:60%;"><?php echo date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], strtotime($pickup_arr['booking_date'] . ' ' . $pickup_arr['booking_time']));?></td>
				</tr>
				<tr>
					<td style="width:40%;"><?php __('lblFrom', false, false);?></td>
					<td style="width:60%;"><?php echo $pickup_arr['traveling'] == 'from' ? $pickup_arr['from_location'] : $pickup_arr['to_location'];?><br/><?php echo $pickup_arr['traveling'] == 'from' ? $pickup_arr['from_address'] : $pickup_arr['to_address'];?></td>
				</tr>
				<tr>
					<td style="width:40%;"><?php __('lblTo', false, false);?></td>
					<td style="width:60%;"><?php echo $pickup_arr['traveling'] == 'from' ? $pickup_arr['to_location'] : $pickup_arr['from_location'];?><br/><?php echo $pickup_arr['traveling'] == 'from' ? $pickup_arr['to_address'] : $pickup_arr['from_address'];?></td>
				</tr>
				<?php
				if(!empty($pickup_arr['c_airline_company']))
				{
					?>
					<tr>
						<td style="width:40%;"><?php __('lblBookingAirlineCompany', false, false);?></td>
						<td style="width:60%;"><?php echo pjSanitize::clean($pickup_arr['c_airline_company']);?></td>
					</tr>
					<?php
				}
				if(!empty($pickup_arr['c_flight_number']))
				{
					?>
					<tr>
						<td style="width:40%;"><?php __('lblBookingFlightNumber', false, false);?></td>
						<td style="width:60%;"><?php echo pjSanitize::clean($pickup_arr['c_flight_number']);?></td>
					</tr>
					<?php
				}
				if(!empty($pickup_arr['c_flight_time']))
				{
					?>
					<tr>
						<td style="width:40%;"><?php __('lblFlightTime', false, false);?></td>
						<td style="width:60%;"><?php echo date($tpl['option_arr']['o_time_format'], strtotime($pickup_arr['c_flight_time']));?></td>
					</tr>
					<?php
				}
				if(!empty($pickup_arr['c_destination_address']))
				{
					?>
					<tr>
						<td style="width:40%;"><?php __('lblBookingDestAddress', false, false);?></td>
						<td style="width:60%;"><?php echo pjSanitize::clean($pickup_arr['c_destination_address']);?></td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>
	<div style="width: 48%;float:right;">
		<?php
		if($pickup_arr['has_return'] == 'T')
		{
			?>
			<table class="table" cellspacing="0" cellpadding="0" style="width: 100%;">
				<thead>
					<tr>
						<th colspan="2"><?php __('lblReturn');?></th>
					</tr>
				</thead>
				<tbody>
					<tr class="bold">
						<td style="width:40%;"><?php __('lblDateAndTime', false, false);?></td>
						<td style="width:60%;"><?php echo date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], strtotime($pickup_arr['return_date'] . ' ' . $pickup_arr['return_time']));?></td>
					</tr>
					<tr>
						<td style="width:40%;"><?php __('lblFrom', false, false);?></td>
						<td style="width:60%;"><?php echo $pickup_arr['traveling'] == 'from' ? $pickup_arr['to_location'] : $pickup_arr['from_location'];?><br/><?php echo $pickup_arr['traveling'] == 'from' ? $pickup_arr['to_address'] : $pickup_arr['from_address'];?></td>
					</tr>
					<tr>
						<td style="width:40%;"><?php __('lblTo', false, false);?></td>
						<td style="width:60%;"><?php echo $pickup_arr['traveling'] == 'from' ? $pickup_arr['from_location'] : $pickup_arr['to_location'];?><br/><?php echo $pickup_arr['traveling'] == 'from' ? $pickup_arr['from_address'] : $pickup_arr['to_address'];?></td>
					</tr>
				</tbody>
			</table>
			<?php
		} 
		?>
	</div>
</div>