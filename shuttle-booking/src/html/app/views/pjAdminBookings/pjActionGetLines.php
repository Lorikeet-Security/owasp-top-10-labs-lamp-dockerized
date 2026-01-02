<select name="<?php echo $controller->_get->check('has_return') ? 'return_' : NULL;?>line_id" id="<?php echo $controller->_get->check('has_return') ? 'return_' : NULL;?>line_id" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required');?>">
	<option value="">-- <?php __('lblChoose'); ?>--</option>
	<?php
	if(isset($tpl['line_arr']))
	{
		foreach($tpl['line_arr'] as $v)
		{
			?><option value="<?php echo $v['id'];?>"><?php echo pjSanitize::html($v['title']);?></option><?php
		}
	} 
	?>
</select>
