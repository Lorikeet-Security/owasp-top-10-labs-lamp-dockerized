<?php
$enum_arr = __('plugin_base_enum_background', true);
$patterns_folder = $controller->getConst('PLUGIN_IMG_PATH') . 'captcha_patterns/';
$files = scandir($patterns_folder);
natsort($files);
?>
<select name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="form-control select-patterns">
	<option value="plain"<?php echo $tpl['arr'][$i]['value'] == 'plain' ? ' selected="selected"' : NULL;?>><?php echo $enum_arr['plain'];?></option>
	<?php
	foreach($files as $file)
	{
		if(is_file($patterns_folder . $file))
		{
			?><option value="<?php echo $file;?>"<?php echo $tpl['arr'][$i]['value'] == $file ? ' selected="selected"' : NULL;?>><?php echo $file;?></option><?php
		}
	}
	?>
</select>