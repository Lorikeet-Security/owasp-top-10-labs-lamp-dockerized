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
	?>
	<div class="ui-tabs ui-widget ui-widget-content ui-corner-all b10">
		<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			<li class="ui-state-default ui-corner-top"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminTimetable&amp;action=pjActionUpdate&amp;id=<?php echo (int)$tpl['arr']['id'];?>"><?php __('tabDetails'); ?></a></li>
			<li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminTimetable&amp;action=pjActionSchedule&amp;id=<?php echo (int)$tpl['arr']['id'];?>"><?php __('tabSchedule'); ?></a></li>
		</ul>
	</div>
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminTimetable&amp;action=pjActionSchedule" method="post" id="frmSchedule" class="pj-form form" enctype="multipart/form-data">
		
		<div class="clear_both">
			<?php
			$time_arr = explode("|", $tpl['arr']['time']);
			$label = $tpl['arr']['direction'] == 'arriving' ? __('lblArrivingTime', true) : __('lblDepartingTime', true);
			$label = str_replace("{LOC}", $tpl['arr']['title'], $label);
			?>
			<p>
				<label class="block float_left t6 r10"><?php echo $label; ?></label>
				<span class="inline-block">
					<select name="schedule_time" id="schedule_time" class="pj-form-field w150" data-line_id="<?php echo $tpl['arr']['line_id'];?>" data-direction="<?php echo $tpl['arr']['direction'];?>">
						<?php
						foreach($time_arr as $k => $time)
						{
							?><option value="<?php echo $time;?>"><?php echo date($tpl['option_arr']['o_time_format'], strtotime($time));?></option><?php
						} 
						?>
					</select>
				</span>
			</p>
			<div id="pjScheduleWrapper">
				
			</div>
		</div>
	</form>
	
	<script type="text/javascript">
	var myLabel = myLabel || {};
	</script>
	<?php
}
?>