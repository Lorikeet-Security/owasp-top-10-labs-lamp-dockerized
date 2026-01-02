<?php
$capacity = 0;
$duration = 0;
$duration_text = '';
$price_per_person = 0;
$price_per_person_format = '';
if(!empty($tpl['line_detail_arr']))
{
	$line_arr = $tpl['line_detail_arr'];
	if($tpl['traveling'] == 'from')
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
	$capacity = (int) $tpl['line']['seats'];
}
ob_start(); 	
?>
<select name="<?php echo $controller->_get->check('has_return') ? 'return_time' : 'booking_time';?>" id="<?php echo $controller->_get->check('has_return') ? 'return_time' : 'booking_time';?>" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required');?>">
	<?php
	if(isset($tpl['timetable_arr']))
	{
		if(!empty($tpl['timetable_arr']))
		{
			?>
			<option value="">-- <?php __('lblChoose'); ?>--</option>
			<?php
			$iso_date = pjDateTime::formatDate($controller->_get->toString('booking_date'), $tpl['option_arr']['o_date_format']);
			$time_arr = explode("|", $tpl['timetable_arr']['time']);
			foreach($time_arr as $time)
			{
				$time_ts = strtotime($time);
				if($tpl['traveling'] == 'to')
				{
					$time_ts = $time_ts - ($duration * 60);
				}
				$disabled = '';
				$iso_time = date('H:i', $time_ts);
				$time_ts = strtotime($iso_date . ' ' . $iso_time);
				if((array_key_exists($iso_time, $tpl['booked_time_arr']) && ($tpl['booked_time_arr'][$iso_time] + $cotnroller->_get->toInt('passengers') > $capacity) ) || $time_ts < time())
				{
					$disabled = ' disabled';
				}
				?><option value="<?php echo $iso_time;?>"<?php echo $disabled;?>><?php echo date($tpl['option_arr']['o_time_format'], $time_ts);?></option><?php
			}
		}else{
			?><option value="">-- <?php __('lblNoAvailableTime'); ?>--</option><?php
		}
	} else {
		?><option value="">-- <?php __('lblChoose'); ?>--</option><?php
	}
	?>
</select>
<?php
$timetable = ob_get_contents();
ob_end_clean();

pjAppController::jsonResponse(compact('timetable', 'duration','duration_text', 'price_per_person', 'price_per_person_format'));
?>
