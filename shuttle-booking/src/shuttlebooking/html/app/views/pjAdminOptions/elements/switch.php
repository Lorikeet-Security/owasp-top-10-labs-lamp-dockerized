<div class="clearfix">
	<div class="switch onoffswitch-data pull-left">
		<div class="onoffswitch">
			<input type="checkbox" class="onoffswitch-checkbox" id="<?php echo $option['key'];?>" name="<?php echo $option['key'];?>"<?php echo 1 == $tpl['option_arr'][$option['key']] ? ' checked="checked"' : NULL;?>>
			<label class="onoffswitch-label" for="<?php echo $option['key'];?>">
				<span class="onoffswitch-inner" data-on="<?php __('plugin_base_yesno_ARRAY_T', false, true); ?>" data-off="<?php __('plugin_base_yesno_ARRAY_F', false, true); ?>"></span>
				<span class="onoffswitch-switch"></span>
			</label>
		</div>
	</div>
</div>
<input type="hidden" name="value-enum-<?php echo $option['key'];?>" value="<?php echo '1|0::' . $tpl['option_arr'][$option['key']];?>">