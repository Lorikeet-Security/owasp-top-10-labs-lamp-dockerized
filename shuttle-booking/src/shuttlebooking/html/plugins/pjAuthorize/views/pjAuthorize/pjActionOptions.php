<?php
if (isset($tpl['not_qualified']) && !empty($tpl['not_qualified']))
{
	?>
	<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-circle m-r-xs"></i><?php echo $tpl['not_qualified']; ?></div>
	<?php
}
$is_active = (int) $tpl['arr']['is_active'] === 1;
$is_test_mode = (int) $tpl['arr']['is_test_mode'] === 1;
?>
<div class="form-group">
    <label class="control-label col-lg-4"><?php __('plugin_authorize_allow'); ?></label>

    <div class="col-lg-8">
        <div class="switch m-t-xs">
            <div class="onoffswitch onoffswitch-data">
                <input id="payment_is_active" name="plugin_payment_options[authorize][is_active]" value="<?php echo @$tpl['arr']['is_active'];?>" type="hidden">
                <input class="onoffswitch-checkbox" id="enablePayment" name="enablePayment" type="checkbox"<?php echo $is_active ? ' checked' : NULL; ?>>
                <label class="onoffswitch-label" for="enablePayment">
                    <span class="onoffswitch-inner" data-on="<?php __('plugin_authorize_onoff_ARRAY_1', false, true);?>" data-off="<?php __('plugin_authorize_onoff_ARRAY_0', false, true);?>"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="hidden-area" style="display: <?php echo $is_active ? 'block' : 'none'; ?>">
<?php
if (defined("PJ_WEBSITE_VERSION"))
{
	?>
	<div class="form-group">
		<label class="control-label col-lg-4"><?php __('plugin_authorize_payment_label'); ?></label>
		<div class="col-lg-8">
			<div class="i18n-group">
			<?php
			foreach ($tpl['lp_arr'] as $v)
			{
				?>
				<input 
					type="text" 
					class="form-control i18n-control<?php echo $v['id'] != @$tpl['locale_id'] ? ' hidden' : NULL; ?><?php echo $v['is_default'] ? ' required' : NULL; ?>"
					data-id="<?php echo $v['id']; ?>"
					data-iso="<?php echo $v['language_iso']; ?>" 
					name="i18n[<?php echo $v['id']; ?>][authorize]" 
					value="<?php echo pjSanitize::html(@$tpl['i18n'][$v['id']]['authorize']); ?>">
				<?php
			}
			?>
			</div>
		</div>
	</div>
    <?php
} else {
    foreach ($tpl['lp_arr'] as $v)
    {
        ?>
        <div class="form-group pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 1 ? 'block' : 'none'; ?>">
            <label class="control-label col-lg-4"><?php __('plugin_authorize_payment_label'); ?></label>
            <div class="col-lg-8">
                <div class="input-group">
                    <input type="text" class="form-control" name="i18n[<?php echo $v['id']; ?>][authorize]" value="<?php echo pjSanitize::html(@$tpl['i18n'][$v['id']]['authorize']); ?>">
                    <?php if ($tpl['is_flag_ready']) : ?>
                    <span class="input-group-addon pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="<?php echo pjSanitize::html($v['name']); ?>"></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
</div>

<div class="form-group hidden-area" style="display: <?php echo $is_active ? 'block' : 'none'; ?>">
    <label class="control-label col-lg-4"><?php __('plugin_authorize_test_mode'); ?></label>

    <div class="col-lg-8">
        <div class="switch m-t-xs">
            <div class="onoffswitch onoffswitch-data">
                <input id="payment_is_test_mode" name="plugin_payment_options[authorize][is_test_mode]" value="<?php echo @$tpl['arr']['is_test_mode']; ?>" type="hidden">
                <input class="onoffswitch-checkbox" id="enableTestMode" name="enableTestMode" type="checkbox"<?php echo $is_test_mode ? ' checked' : NULL; ?>>
                <label class="onoffswitch-label" for="enableTestMode">
                    <span class="onoffswitch-inner" data-on="<?php __('plugin_authorize_onoff_ARRAY_1', false, true);?>" data-off="<?php __('plugin_authorize_onoff_ARRAY_0', false, true);?>"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="form-group hidden-area live-area" style="display: <?php echo $is_active && !$is_test_mode ? 'block' : 'none'; ?>">
    <label class="control-label col-lg-4"><?php __('plugin_authorize_merchant_id'); ?></label>

    <div class="col-lg-8">
        <input type="text" name="plugin_payment_options[authorize][merchant_id]" value="<?php echo pjSanitize::html(@$tpl['arr']['merchant_id']); ?>" class="form-control required" maxlength="255">
        <p class="small"><?php __('plugin_authorize_merchant_id_text'); ?></p>
    </div>
</div>
<div class="form-group hidden-area live-area" style="display: <?php echo $is_active && !$is_test_mode ? 'block' : 'none'; ?>">
    <label class="control-label col-lg-4"><?php __('plugin_authorize_public_key'); ?></label>

    <div class="col-lg-8">
        <input type="text" name="plugin_payment_options[authorize][public_key]" value="<?php echo pjSanitize::html(@$tpl['arr']['public_key']); ?>" class="form-control required" maxlength="255">
        <p class="small"><?php __('plugin_authorize_public_key_text'); ?></p>
    </div>
</div>
<div class="form-group hidden">
    <label class="control-label col-lg-4"><?php __('plugin_authorize_private_key'); ?></label>

    <div class="col-lg-8">
        <input type="text" name="plugin_payment_options[authorize][private_key]" value="<?php echo pjSanitize::html(@$tpl['arr']['private_key']); ?>" class="form-control" maxlength="255">
        <p class="small"><?php __('plugin_authorize_private_key_text'); ?></p>
    </div>
</div>
<div class="form-group hidden-area live-area" style="display: <?php echo $is_active && !$is_test_mode ? 'block' : 'none'; ?>">
    <label class="control-label col-lg-4"><?php __('plugin_authorize_tz'); ?></label>

    <div class="col-lg-8">
        <select name="plugin_payment_options[authorize][tz]" class="form-control required">
            <?php
            $locations = array();
            $zones = timezone_identifiers_list();
            foreach ($zones as $zone_name)
            {
                $zone = explode('/', $zone_name);
                if ($zone[0] == 'Africa' || $zone[0] == 'America' || $zone[0] == 'Antarctica' || $zone[0] == 'Arctic' || $zone[0] == 'Asia' || $zone[0] == 'Atlantic' || $zone[0] == 'Australia' || $zone[0] == 'Europe' || $zone[0] == 'Indian' || $zone[0] == 'Pacific')
                {
                    if (isset($zone[1]) != '')
                    {
                        $locations[$zone[0]][$zone[0]. '/' . $zone[1]] = str_replace('_', ' ', $zone[1]) . ' (UTC' . pjTimezone::getTimezoneOffset($zone_name) . ')';
                    }
                }
            }

            foreach($locations as $continent => $cities)
            {
                ?>
                <optgroup label="<?php echo pjSanitize::html($continent);?>">
                    <?php
                    foreach($cities as $pair => $city)
                    {
                        ?>
                        <option value="<?php echo $pair;?>"<?php echo $pair != $tpl['arr']['tz'] ? NULL : ' selected="selected"'; ?>><?php echo $city;?></option>
                        <?php
                    }
                    ?>
                </optgroup>
                <?php
            }
            ?>
        </select>
        <p class="small"><?php __('plugin_authorize_tz_text'); ?></p>
    </div>
</div>


<div class="form-group hidden-area test-area" style="display: <?php echo $is_active && $is_test_mode ? 'block' : 'none'; ?>">
    <label class="control-label col-lg-4"><?php __('plugin_authorize_merchant_id'); ?></label>

    <div class="col-lg-8">
        <input type="text" name="plugin_payment_options[authorize][test_merchant_id]" value="<?php echo pjSanitize::html(@$tpl['arr']['test_merchant_id']); ?>" class="form-control required" maxlength="255">
        <p class="small"><?php __('plugin_authorize_merchant_id_text'); ?></p>
    </div>
</div>
<div class="form-group hidden-area test-area" style="display: <?php echo $is_active && $is_test_mode ? 'block' : 'none'; ?>">
    <label class="control-label col-lg-4"><?php __('plugin_authorize_public_key'); ?></label>

    <div class="col-lg-8">
        <input type="text" name="plugin_payment_options[authorize][test_public_key]" value="<?php echo pjSanitize::html(@$tpl['arr']['test_public_key']); ?>" class="form-control required" maxlength="255">
        <p class="small"><?php __('plugin_authorize_public_key_text'); ?></p>
    </div>
</div>
<div class="form-group hidden">
    <label class="control-label col-lg-4"><?php __('plugin_authorize_private_key'); ?></label>

    <div class="col-lg-8">
        <input type="text" name="plugin_payment_options[authorize][test_private_key]" value="<?php echo pjSanitize::html(@$tpl['arr']['test_private_key']); ?>" class="form-control" maxlength="255">
        <p class="small"><?php __('plugin_authorize_private_key_text'); ?></p>
    </div>
</div>
<div class="form-group hidden-area test-area" style="display: <?php echo $is_active && $is_test_mode ? 'block' : 'none'; ?>">
    <label class="control-label col-lg-4"><?php __('plugin_authorize_tz'); ?></label>

    <div class="col-lg-8">
        <select name="plugin_payment_options[authorize][test_tz]" class="form-control required">
            <?php
            $locations = array();
            $zones = timezone_identifiers_list();
            foreach ($zones as $zone_name)
            {
                $zone = explode('/', $zone_name);
                if ($zone[0] == 'Africa' || $zone[0] == 'America' || $zone[0] == 'Antarctica' || $zone[0] == 'Arctic' || $zone[0] == 'Asia' || $zone[0] == 'Atlantic' || $zone[0] == 'Australia' || $zone[0] == 'Europe' || $zone[0] == 'Indian' || $zone[0] == 'Pacific')
                {
                    if (isset($zone[1]) != '')
                    {
                        $locations[$zone[0]][$zone[0]. '/' . $zone[1]] = str_replace('_', ' ', $zone[1]) . ' (UTC' . pjTimezone::getTimezoneOffset($zone_name) . ')';
                    }
                }
            }

            foreach ($locations as $continent => $cities)
            {
                ?>
                <optgroup label="<?php echo pjSanitize::html($continent);?>">
                    <?php
                    foreach($cities as $pair => $city)
                    {
                        ?>
                        <option value="<?php echo $pair;?>"<?php echo $pair != $tpl['arr']['test_tz'] ? NULL : ' selected="selected"'; ?>><?php echo $city;?></option>
                        <?php
                    }
                    ?>
                </optgroup>
                <?php
            }
            ?>
        </select>
        <p class="small"><?php __('plugin_authorize_tz_text'); ?></p>
    </div>
</div>

<div class="form-group hidden-area" style="display: <?php echo $is_active ? 'block' : 'none'; ?>">
    <label class="control-label col-lg-4"><?php __('plugin_authorize_silent_post_url'); ?></label>

    <div class="col-lg-8">
    	<p class="form-control-static" style="word-break: break-all"><?php echo PJ_INSTALL_URL . 'payments_webhook.php?payment_method=authorize'; ?></p>
    </div>
</div>