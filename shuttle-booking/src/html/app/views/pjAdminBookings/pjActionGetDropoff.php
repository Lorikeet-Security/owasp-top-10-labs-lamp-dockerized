<?php
if($controller->_get->check('for_search'))
{
	?>
	<select name="dropoff_id" id="search_dropoff_id" class="form-control" data-msg-required="<?php __('plugin_base_this_field_is_required');?>">
		<option value="">-- <?php __('lblChoose'); ?>--</option>
		<?php
		if(isset($tpl['pd_arr']))
		{
			foreach($tpl['pd_arr'] as $v)
			{
				?><option value="<?php echo $v['id'];?>"><?php echo pjSanitize::html($v['title']);?></option><?php
			}
		} 
		?>
	</select>
	<?php
} else {
	?>
	<select name="dropoff_id" id="dropoff_id" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required');?>">
		<option value="">-- <?php __('lblChoose'); ?>--</option>
		<?php
		if(isset($tpl['pd_arr']))
		{
			foreach($tpl['pd_arr'] as $v)
			{
				?><option value="<?php echo $v['id'];?>"><?php echo pjSanitize::html($v['title']);?></option><?php
			}
		} 
		?>
	</select>
	<?php
} 
?>