<?php 
$is_active = (int) $tpl['arr']['is_active'] === 1;
$is_test_mode = (int) $tpl['arr']['is_test_mode'] === 1;
?>
<div class="form-group">
	<label class="control-label col-lg-4"><?php __('plugin_braintree_allow'); ?></label>

	<div class="col-lg-8">
		<div class="switch m-t-xs">
			<div class="onoffswitch onoffswitch-data">
				<input id="payment_is_active" name="plugin_payment_options[braintree][is_active]" value="<?php echo @$tpl['arr']['is_active'];?>" type="hidden">
				<input class="onoffswitch-checkbox" id="enablePayment" name="enablePayment" type="checkbox"<?php echo $is_active ? ' checked' : NULL; ?>>
				<label class="onoffswitch-label" for="enablePayment">
					<span class="onoffswitch-inner" data-on="<?php __('plugin_braintree_yesno_ARRAY_T', false, true);?>" data-off="<?php __('plugin_braintree_yesno_ARRAY_F', false, true);?>"></span>
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
		<label class="control-label col-lg-4"><?php __('plugin_braintree_payment_label'); ?></label>
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
					name="i18n[<?php echo $v['id']; ?>][braintree]" 
					value="<?php echo pjSanitize::html(@$tpl['i18n'][$v['id']]['braintree']); ?>">
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
		<div class="form-group pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 1 ? NULL : 'none'; ?>">
			<label class="control-label col-lg-4"><?php __('plugin_braintree_payment_label'); ?></label>
			<div class="col-lg-8">
				<div class="input-group">
					<input type="text" class="form-control" name="i18n[<?php echo $v['id']; ?>][braintree]" value="<?php echo pjSanitize::html(@$tpl['i18n'][$v['id']]['braintree']); ?>">
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
	<label class="control-label col-lg-4"><?php __('plugin_braintree_test_mode'); ?></label>

	<div class="col-lg-8">
		<div class="switch m-t-xs">
			<div class="onoffswitch onoffswitch-data">
				<input id="payment_is_test_mode" name="plugin_payment_options[braintree][is_test_mode]" value="<?php echo @$tpl['arr']['is_test_mode']; ?>" type="hidden">
				<input class="onoffswitch-checkbox" id="enableTestMode" name="enableTestMode" type="checkbox"<?php echo $is_test_mode ? ' checked' : NULL; ?>>
				<label class="onoffswitch-label" for="enableTestMode">
					<span class="onoffswitch-inner" data-on="<?php __('plugin_braintree_onoff_ARRAY_1', false, true);?>" data-off="<?php __('plugin_braintree_onoff_ARRAY_0', false, true);?>"></span>
					<span class="onoffswitch-switch"></span>
				</label>
			</div>
		</div>
	</div>
</div>
<div class="form-group hidden-area live-area" style="display: <?php echo $is_active && !$is_test_mode ? 'block' : 'none'; ?>">
	<label class="control-label col-lg-4"><?php __('plugin_braintree_merchant_id'); ?></label>

	<div class="col-lg-8">
		<input type="text" name="plugin_payment_options[braintree][merchant_id]" value="<?php echo pjSanitize::html(@$tpl['arr']['merchant_id']); ?>" class="form-control required" maxlength="255">
		<p class="small"><?php __('plugin_braintree_merchant_id_text'); ?></p>
	</div>
</div>
<div class="form-group hidden-area live-area" style="display: <?php echo $is_active && !$is_test_mode ? 'block' : 'none'; ?>">
	<label class="control-label col-lg-4"><?php __('plugin_braintree_public_key'); ?></label>

	<div class="col-lg-8">
		<input type="text" name="plugin_payment_options[braintree][public_key]" value="<?php echo pjSanitize::html(@$tpl['arr']['public_key']); ?>" class="form-control required" maxlength="255">
		<p class="small"><?php __('plugin_braintree_public_key_text'); ?></p>
	</div>
</div>
<div class="form-group hidden-area live-area" style="display: <?php echo $is_active && !$is_test_mode ? 'block' : 'none'; ?>">
	<label class="control-label col-lg-4"><?php __('plugin_braintree_private_key'); ?></label>

	<div class="col-lg-8">
		<input type="text" name="plugin_payment_options[braintree][private_key]" value="<?php echo pjSanitize::html(@$tpl['arr']['private_key']); ?>" class="form-control required" maxlength="255">
		<p class="small"><?php __('plugin_braintree_private_key_text'); ?></p>
	</div>
</div>
<?php
if(!defined("PJ_USE_SUBSCRIPTION"))
{
    ?>
    <div class="form-group hidden-area live-area" style="display: <?php echo $is_active && !$is_test_mode ? 'block' : 'none'; ?>">
    	<label class="control-label col-lg-4"><?php __('plugin_braintree_plan_id'); ?></label>
    
    	<div class="col-lg-8">
    		<input type="text" name="plugin_payment_options[braintree][merchant_email]" value="<?php echo pjSanitize::html(@$tpl['arr']['merchant_email']); ?>" class="form-control required" maxlength="255">
    		<p class="small"><?php __('plugin_braintree_plan_id_text'); ?></p>
    	</div>
    </div>
    <?php
}
?>

<div class="form-group hidden-area test-area" style="display: <?php echo $is_active && $is_test_mode ? 'block' : 'none'; ?>">
	<label class="control-label col-lg-4"><?php __('plugin_braintree_merchant_id'); ?></label>

	<div class="col-lg-8">
		<input type="text" name="plugin_payment_options[braintree][test_merchant_id]" value="<?php echo pjSanitize::html(@$tpl['arr']['test_merchant_id']); ?>" class="form-control required" maxlength="255">
		<p class="small"><?php __('plugin_braintree_merchant_id_text'); ?></p>
	</div>
</div>
<div class="form-group hidden-area test-area" style="display: <?php echo $is_active && $is_test_mode ? 'block' : 'none'; ?>">
	<label class="control-label col-lg-4"><?php __('plugin_braintree_public_key'); ?></label>

	<div class="col-lg-8">
		<input type="text" name="plugin_payment_options[braintree][test_public_key]" value="<?php echo pjSanitize::html(@$tpl['arr']['test_public_key']); ?>" class="form-control required" maxlength="255">
		<p class="small"><?php __('plugin_braintree_public_key_text'); ?></p>
	</div>
</div>
<div class="form-group hidden-area test-area" style="display: <?php echo $is_active && $is_test_mode ? 'block' : 'none'; ?>">
	<label class="control-label col-lg-4"><?php __('plugin_braintree_private_key'); ?></label>

	<div class="col-lg-8">
		<input type="text" name="plugin_payment_options[braintree][test_private_key]" value="<?php echo pjSanitize::html(@$tpl['arr']['test_private_key']); ?>" class="form-control required" maxlength="255">
		<p class="small"><?php __('plugin_braintree_private_key_text'); ?></p>
	</div>
</div>
<?php
if(!defined("PJ_USE_SUBSCRIPTION"))
{
    ?>
    <div class="form-group hidden-area test-area" style="display: <?php echo $is_active && $is_test_mode ? 'block' : 'none'; ?>">
    	<label class="control-label col-lg-4"><?php __('plugin_braintree_plan_id'); ?></label>
    
    	<div class="col-lg-8">
    		<input type="text" name="plugin_payment_options[braintree][test_merchant_email]" value="<?php echo pjSanitize::html(@$tpl['arr']['test_merchant_email']); ?>" class="form-control required" maxlength="255">
    		<p class="small"><?php __('plugin_braintree_plan_id_text'); ?></p>
    	</div>
    </div>
    <?php
}
?>