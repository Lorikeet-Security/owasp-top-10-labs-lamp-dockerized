<?php
if (isset($tpl['status']))
{
	$status = __('status', true);
	switch ($tpl['status'])
	{
		case 2:
			pjUtil::printNotice(NULL, $status[2]);
			break;
	}
} else {
	if(isset($tpl['ERR']))
	{
		$titles = __('error_titles', true);
		$bodies = __('error_bodies', true);
		pjUtil::printNotice(@$titles[$tpl['ERR']], @$bodies[$tpl['ERR']]);
	}
	$week_start = isset($tpl['option_arr']['o_week_start']) && in_array((int) $tpl['option_arr']['o_week_start'], range(0,6)) ? (int) $tpl['option_arr']['o_week_start'] : 0;
	$jqDateFormat = pjUtil::jqDateFormat($tpl['option_arr']['o_date_format']); 
	?>
	
	<?php
	pjUtil::printNotice(__('infoGeneralTitle', true, false), __('infoGeneralDesc', true, false));  
	?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminReports&amp;action=pjActionIndex" method="post" class="form pj-form" id="frmGeneralReport">
		<input type="hidden" name="generate_report" value="1" />
		
		<p>
			<label class="title"><?php __('lblDateFrom'); ?>:</label>
			<span class="inline-block pj-form-field-custom pj-form-field-custom-after r5">
				<input type="text" id="date_from" name="date_from" class="pj-form-field pointer w80 datepick" readonly="readonly" rel="<?php echo $week_start; ?>" rev="<?php echo $jqDateFormat; ?>" value="<?php echo isset($_POST['date_from']) ? $_POST['date_from'] : NULL;?>"/>
				<span class="pj-form-field-after"><abbr class="pj-form-field-icon-date"></abbr></span>
			</span>
		</p>
		
		<p>
			<label class="title"><?php __('lblDateTo'); ?>:</label>
			<span class="inline-block pj-form-field-custom pj-form-field-custom-after r5">
				<input type="text" id="date_to" name="date_to" class="pj-form-field pointer w80 datepick" readonly="readonly" rel="<?php echo $week_start; ?>" rev="<?php echo $jqDateFormat; ?>" value="<?php echo isset($_POST['date_to']) ? $_POST['date_to'] : NULL;?>"/>
				<span class="pj-form-field-after"><abbr class="pj-form-field-icon-date"></abbr></span>
			</span>
		</p>
		<p>
			<label class="title"><?php __('lblPickupLocation'); ?>:</label>
			<span class="inline-block">
				<select name="location_id" id="location_id" class="pj-form-field">
					<option value="">-- <?php __('lblAll'); ?>--</option>
					<?php
					foreach($tpl['pickup_arr'] as $k => $v)
					{
						?><option value="<?php echo $v['id'];?>"<?php echo isset($_POST['location_id']) ? ($_POST['location_id'] == $v['id'] ? ' selected="selected"' : NULL) : NULL;?>><?php echo $v['pickup_location'];?></option><?php
					} 
					?>
				</select>
			</span>
		</p>
		<p>
			<label class="title"><?php __('lblVehicle'); ?>:</label>
			<span class="inline-block">
				<select name="fleet_id" id="fleet_id" class="pj-form-field">
					<option value="">-- <?php __('lblAll'); ?>--</option>
					<?php
					foreach($tpl['fleet_arr'] as $k => $v)
					{
						?><option value="<?php echo $v['id'];?>"<?php echo isset($_POST['fleet_id']) ? ($_POST['fleet_id'] == $v['id'] ? ' selected="selected"' : NULL) : NULL;?>><?php echo $v['fleet'];?></option><?php
					} 
					?>
				</select>
			</span>
		</p>
		<p>
			<label class="title">&nbsp;</label>
			<input type="submit" value="<?php __('btnGenerate', false, true); ?>" class="pj-button" />
		</p>
	</form>	
	
	<div class="trReportContainer">
		<?php
		if(isset($tpl['type']))
		{
			include_once PJ_VIEWS_PATH . 'pjAdminReports/elements/'.$tpl['type'].'.php';
		}
		?>
	</div>
	<?php
}
?>