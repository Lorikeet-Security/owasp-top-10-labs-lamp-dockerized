<div class="clearfix">
	<div class="switch onoffswitch-data pull-left">
		<div class="onoffswitch">
			<input type="checkbox" class="onoffswitch-checkbox" id="<?php echo $tpl['arr'][$i]['key'];?>" name="<?php echo $tpl['arr'][$i]['key'];?>"<?php echo 'Yes' == $tpl['option_arr'][$tpl['arr'][$i]['key']] ? ' checked="checked"' : NULL;?>>
			<label class="onoffswitch-label" for="<?php echo $tpl['arr'][$i]['key'];?>">
				<span class="onoffswitch-inner" data-on="<?php __('plugin_base_yesno_ARRAY_T', false, true); ?>" data-off="<?php __('plugin_base_yesno_ARRAY_F', false, true); ?>"></span>
				<span class="onoffswitch-switch"></span>
			</label>
		</div>
	</div>
</div>
<input type="hidden" name="value-enum-<?php echo $tpl['arr'][$i]['key'];?>" value="<?php echo 'Yes|No::' . $tpl['option_arr'][$tpl['arr'][$i]['key']];?>">