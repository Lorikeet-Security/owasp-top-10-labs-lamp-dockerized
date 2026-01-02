<table class="table" cellspacing="0" cellpadding="0" style="width: 100%; margin-top: 10px;">
	<thead>
		<tr>
			<th style="width: 70px;"><?php __('lblBookingID');?></th>
			<th style="width: 120px;"><?php __('lblClient');?></th>
			<th style="width: 170px;"><?php __('lblDateAndTime');?></th>
			<th style="width: 150px;"><?php __('lblFromTo');?></th>
			<th style="width: 100px;"><?php __('lblLine');?></th>
			<th style="width: 100px;"><?php __('lblPassengers');?></th>
			<th style="width: 120px;"><?php __('lblPayment');?></th>
			<th colspan="2"><?php __('lblAdditionalInfo');?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		if(count($tpl['transfer_arr']) > 0)
		{
			$field_arr = array();
			$field_arr['c_phone'] = __('lblBookingPhone', true, false);
			$field_arr['c_email'] = __('lblBookingEmail', true, false);
			$field_arr['c_company'] = __('lblBookingCompany', true, false);
			$field_arr['c_notes'] = __('lblBookingNotes', true, false);
			$field_arr['c_address'] = __('lblBookingAddress', true, false);
			$field_arr['c_city'] = __('lblBookingCity', true, false);
			$field_arr['c_state'] = __('lblBookingState', true, false);
			$field_arr['c_zip'] = __('lblBookingZip', true, false);
			$field_arr['c_country'] = __('lblBookingCountry', true, false);
			$field_arr['c_airline_company'] = __('lblBookingAirlineCompany', true, false);
			$field_arr['c_departure_airline_company'] = __('lblDepartureAirlineCompany', true, false);
			$field_arr['c_flight_number'] = __('lblArrivalFlightNumber', true, false);
			$field_arr['c_flight_time'] = __('lblFlightArrivalTime', true, false);
			$field_arr['c_departure_flight_number'] = __('lblDepartureFlightNumber', true, false);
			$field_arr['c_departure_flight_time'] = __('lblFlightDepartureTime', true, false);
			$field_arr['c_destination_address'] = __('lblBookingDestAddress', true, false);
			$field_arr['c_cruise_ship'] = __('lblBookingCruiseShip', true, false);
			
			$name_titles = __('personal_titles', true, false);
			$statuses = __('booking_statuses', true, false);
			
			$row = 1;
			foreach($tpl['transfer_arr'] as $v)
			{
				$client_name_arr = array();
				$additional_arr = array();
				if(!empty($v['c_fname']) || !empty($v['fname']))
				{
					$client_name_arr[] = !empty($v['client_id']) ? pjSanitize::clean($v['fname']) : pjSanitize::clean($v['c_fname']);
				}
				if(!empty($v['c_lname']) || !empty($v['lname']))
				{
					$client_name_arr[] = !empty($v['client_id']) ? pjSanitize::clean($v['lname']) : pjSanitize::clean($v['c_lname']);
				}
				$total = pjCurrency::formatPrice($v['total']);
				$payment_methods = __('payment_methods', true, false);

				foreach($field_arr as $field => $title)
				{
					if(in_array($field, array('c_departure_airline_company', 'c_departure_flight_number', 'c_departure_flight_time')))
					{
						$v[$field] = NULL;
					}
					if(!empty($v[$field]))
					{
						if($field == 'c_notes')
						{
							$additional_arr[] = '<td>'.$title.'</td><td>'.nl2br($v[$field]).'</td>';
						}else{
							$additional_arr[] = '<td>'.$title.'</td><td>'.$v[$field].'</td>';
						}
					}
				}
				$row_span = count($additional_arr) > 0 ? count($additional_arr) : 1; 
				
				if(count($additional_arr) >= 2)
				{
					foreach($additional_arr as $k => $addition)
					{
						if($k == 0)
						{
							?>
							<tr class="<?php echo $row%2==0? 'even' : 'odd';?>">
								<td rowspan="<?php echo $row_span;?>"><?php echo !empty($v['uuid']) ? pjSanitize::clean($v['uuid']) . '<br/>' . $statuses[$v['status']] : '&nbsp;';?></td>
								<td rowspan="<?php echo $row_span;?>"><b><?php echo pjSanitize::clean($v['name']);?></b></td>
								<?php
								if($v['has_return'] == 'T')
								{ 
									?>
									<td rowspan="<?php echo $row_span;?>">
										<b>
											<?php echo date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], strtotime($v['booking_date'] . ', ' . $v['booking_time']));?>
											<br/>
											<?php __('lblReturnOn');?>: <?php echo date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], strtotime($v['return_date'] . ', ' . $v['return_time']));?>
										</b>
									</td>
									<?php
								}else{
									?>
									<td rowspan="<?php echo $row_span;?>"><b><?php echo date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], strtotime($v['booking_date'] . ', ' . $v['booking_time']));?></b></td>
									<?php
								}
								if($v['traveling'] == 'from')
								{ 
									?>
									<td rowspan="<?php echo $row_span;?>"><b><?php __('lblFrom');?>: <?php echo !empty($v['from_location']) ? $v['from_location'] : '&nbsp;';?></b><br/><b><?php __('lblTo');?>: <?php echo !empty($v['to_location']) ? $v['to_location'] : '&nbsp;';?></b></td>
									<?php
								}else{
									?>
									<td rowspan="<?php echo $row_span;?>"><b><?php __('lblFrom');?>: <?php echo !empty($v['to_location']) ? $v['to_location'] : '&nbsp;';?></b><br/><b><?php __('lblTo');?>: <?php echo !empty($v['from_location']) ? $v['from_location'] : '&nbsp;';?></b></td>
									<?php
								}
								if($v['has_return'] == 'T')
								{ 
									?>
									<td rowspan="<?php echo $row_span;?>"><?php echo pjSanitize::clean($v['line']);?><br/><b><?php __('lblReturnOn');?>:</b> <?php echo pjSanitize::clean($v['return_line']);?></td>
									<?php
								}else{
									?>
									<td rowspan="<?php echo $row_span;?>"><?php echo pjSanitize::clean($v['line']);?></td>
									<?php
								} 
								?>
								<td rowspan="<?php echo $row_span;?>"><?php echo $v['passengers'] . ' ' . ($v['passengers'] != 1 ? __('lblPassengers', true, false) : __('lblPassenger', true, false)) ;?></td>
								<td rowspan="<?php echo $row_span;?>"><b><?php echo __('lblTotal', true, false) . ': ' . $total;?></b><br/><?php __('lblVia'); ?> <?php echo $payment_methods[$v['payment_method']];?><br/><?php echo $statuses[$v['status']];?></td>
								<?php echo $addition;?>
							</tr>
							<?php
						}else{
							?>
							<tr class="<?php echo $row%2==0? 'even' : 'odd';?>">
								<?php echo $addition;?>
							</tr>
							<?php
						}
					}
				}else{
					?>
					<tr class="<?php echo $row%2==0? 'even' : 'odd';?>">
						<td><?php echo !empty($v['uuid']) ? pjSanitize::clean($v['uuid']) . '<br/>' . $statuses[$v['status']] : '&nbsp;';?></td>
						<td><b><?php echo pjSanitize::clean($v['name']);?></b></td>
						<?php
						if($v['has_return'] == 'T')
						{ 
							?>
							<td>
								<b>
									<?php echo date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], strtotime($v['booking_date'] . ', ' . $v['booking_time']));?>
									<br/>
									<?php __('lblReturnOn');?>: <?php echo date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], strtotime($v['return_date'] . ', ' . $v['return_time']));?>
								</b>
							</td>
							<?php
						}else{
							?>
							<td><b><?php echo date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], strtotime($v['booking_date'] . ', ' . $v['booking_time']));?></b></td>
							<?php
						}
						if($v['traveling'] == 'from')
						{ 
							?>
							<td><b><?php __('lblFrom');?>: <?php echo !empty($v['from_location']) ? $v['from_location'] : '&nbsp;';?></b><br/><b><?php __('lblTo');?>: <?php echo !empty($v['to_location']) ? $v['to_location'] : '&nbsp;';?></b></td>
							<?php
						}else{
							?>
							<td><b><?php __('lblFrom');?>: <?php echo !empty($v['to_location']) ? $v['to_location'] : '&nbsp;';?></b><br/><b><?php __('lblTo');?>: <?php echo !empty($v['from_location']) ? $v['from_location'] : '&nbsp;';?></b></td>
							<?php
						}
						if($v['has_return'] == 'T')
						{ 
							?>
							<td><?php echo pjSanitize::clean($v['line']);?><br/><b><?php __('lblReturnOn');?>:</b> <?php echo pjSanitize::clean($v['return_line']);?></td>
							<?php
						}else{
							?>
							<td><?php echo pjSanitize::clean($v['line']);?></td>
							<?php
						} 
						?>
						<td><?php echo $v['passengers'] . ' ' . ($v['passengers'] != 1 ? __('lblPassengers', true, false) : __('lblPassenger', true, false)) ;?></td>
						<?php
						if(!empty($v['payment_method']))
						{ 
							?>
							<td><b><?php echo __('lblTotal', true, false) . ': ' . $total;?></b><br/><?php __('lblVia'); ?> <?php echo $payment_methods[$v['payment_method']];?></td>
							<?php
						}else{
							?>
							<td><b><?php echo __('lblTotal', true, false) . ': ' . $total;?></b></td>
							<?php
						} 
						
						if(count($additional_arr) == 0)
						{
							?><td colspan="2">&nbsp;</td><?php
						}
						if(count($additional_arr) == 1)
						{
							echo join('', $additional_arr);
						} 
						?>
					</tr>
					<?php
				}
				$row++;
			}
		} else {
			?>
			<tr>
				<td colspan="10"><?php __('gridEmptyResult');?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>