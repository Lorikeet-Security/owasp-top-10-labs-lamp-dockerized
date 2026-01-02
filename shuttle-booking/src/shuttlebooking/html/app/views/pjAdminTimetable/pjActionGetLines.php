<label class="control-label"><?php __('lblLine');?></label>
<select name="line_id" id="line_id" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required'); ?>">
	<?php
	if(isset($tpl['line_arr']) && count($tpl['line_arr']) > 0)
	{
		?><option value="">-- <?php __('lblChoose'); ?>--</option><?php
		foreach($tpl['line_arr'] as $v)
		{
			?><option value="<?php echo $v['id'];?>"><?php echo $v['title'];?></option><?php
		}
	} else {
		?><option value="">-- <?php __('lblNoLinesAvailable'); ?>--</option><?php
	}
	?>
</select>