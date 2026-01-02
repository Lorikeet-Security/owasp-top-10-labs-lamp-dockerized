<select name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="form-control">
    <?php
    $default = explode("::", $tpl['arr'][$i]['value']);
    $enum = explode("|", $default[0]);
    
    $enumLabels = array();
    if ($tpl['arr'][$i]['key'] == 'o_secure_login_send_password_to') {
    	$enum_arr = __('plugin_base_enum_send_to', true);
    	$enumLabels = array($enum_arr['email'], $enum_arr['sms']);
    }
    if (empty($enumLabels) && !empty($tpl['arr'][$i]['label']) && strpos($tpl['arr'][$i]['label'], "|") !== false)
    {
        $enumLabels = explode("|", $tpl['arr'][$i]['label']);
    }
    
    $enum_arr = __('plugin_base_enum_arr', true);
    
    foreach ($enum as $k => $el)
    {
    	if ($default[1] == $el)
    	{
    		?><option value="<?php echo $default[0].'::'.$el; ?>" selected="selected"><?php echo isset($enum_arr[$el]) ? $enum_arr[$el] : (array_key_exists($k, $enumLabels) ? pjSanitize::html($enumLabels[$k]) : pjSanitize::html($el)); ?></option><?php
    	} else {
    		?><option value="<?php echo $default[0].'::'.$el; ?>"><?php echo isset($enum_arr[$el]) ? $enum_arr[$el] : (array_key_exists($k, $enumLabels) ? pjSanitize::html($enumLabels[$k]) : pjSanitize::html($el)); ?></option><?php
    	}
    }
    ?>
</select>