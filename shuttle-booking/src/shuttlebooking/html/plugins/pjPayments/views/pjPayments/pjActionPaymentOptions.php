<?php
$payment_method = $controller->_get->toString('payment_method');
$active_arr = array();
if(pjObject::getPlugin('pjPayments') !== NULL)
{
    $active_arr = pjPayments::getActivePaymentMethods($controller->getForeignId());
}
?>
<form id="frmPaymentOptions" action="?" method="post" class="form-horizontal">
	<input type="hidden" id="options_update" name="options_update" value="1"/>
	<input type="hidden" id="payment_method" name="payment_method" value="<?php echo $payment_method;?>"/>           	
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only"><?php __('plugin_base_btn_close');?></span></button>
		
		<div class="modal-image">
			<span class="payment active">
				<img src="<?php echo PJ_IMG_PATH?>backend/payments/<?php echo $payment_method?>.png">
			</span>
		</div><!-- /.modal-image -->
		
	</div>

	<div class="modal-body">
		<?php
		if(!in_array($payment_method, array('bank', 'cash')))
		{
			$pjPlugin = pjPayments::getPluginName($payment_method);
			if(pjObject::getPlugin($pjPlugin) !== NULL)
			{
			    $controller->requestAction(array('controller' => $pjPlugin, 'action' => 'pjActionOptions', 'params' => array('foreign_id' => $controller->getForeignId(), 'fid' => $controller->getForeignId())));
			}
		}else{
		    ?>
			<div class="form-group">
				<label class="control-label col-lg-4"><?php __('plugin_payment_allow_' . $payment_method); ?></label>
				
				<div class="col-lg-8">
					<div class="switch m-t-xs">
						<div class="onoffswitch onoffswitch-data">
							<input id="payment_is_active" name="is_active" value="<?php echo array_key_exists($payment_method, $active_arr) ? '1' : '0';?>"  type="hidden" />
							<input class="onoffswitch-checkbox" id="enablePayment" name="enablePayment" type="checkbox"<?php echo array_key_exists($payment_method, $active_arr) ? ' checked="checked"' : NULL; ?>>
							<label class="onoffswitch-label" for="enablePayment">
								<span class="onoffswitch-inner" data-on="<?php __('allow_payment_method_ARRAY_1', false, true);?>" data-off="<?php __('allow_payment_method_ARRAY_0', false, true);?>"></span>
								<span class="onoffswitch-switch"></span>
							</label>
						</div>
					</div>
				</div><!-- /.col-lg-4 -->
			</div><!-- /.form-group -->
			<div class="hidden-area" style="display: <?php echo array_key_exists($payment_method, $active_arr) ? 'block' : 'none'; ?>">
				<?php
				foreach ($tpl['lp_arr'] as $v)
				{
					?>
					<div class="form-group pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 1 ? 'block' : 'none'; ?>">
						<label class="control-label col-lg-4"><?php __('plugin_paypal_payment_label'); ?></label>
						<div class="col-lg-8">
							<div class="input-group">
								<input type="text" class="form-control<?php echo (int) $v['is_default'] === 0 ? NULL : ' required'; ?>" name="i18n[<?php echo $v['id']; ?>][<?php echo $payment_method;?>]" value="<?php echo pjSanitize::html($tpl['i18n'][$v['id']][$payment_method]); ?>">
								<?php if ($tpl['is_flag_ready']) : ?>
								<span class="input-group-addon pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="<?php echo pjSanitize::html($v['name']); ?>"></span>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<?php 
				}
				?>
			</div>
			<?php
			if($payment_method == 'bank')
			{
				?>
                <div class="hidden-area" style="display: <?php echo array_key_exists($payment_method, $active_arr) ? 'block' : 'none'; ?>">
					<?php
					foreach ($tpl['lp_arr'] as $v)
					{
						?>
						<div class="form-group pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 1 ? 'block' : 'none'; ?>">
							<label class="control-label col-lg-4"><?php __('plugin_payments_bank_account'); ?></label>
							<div class="col-lg-8">
								<div class="input-group">
                                    <textarea name="i18n_options[<?php echo $v['id']; ?>][o_bank_account]" class="form-control<?php echo (int) $v['is_default'] === 0 ? NULL : ' required'; ?>"><?php echo htmlspecialchars(stripslashes(@$tpl['i18n_options'][$v['id']]['o_bank_account'])); ?></textarea>
									<?php if ($tpl['is_flag_ready']) : ?>
									<span class="input-group-addon pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="<?php echo pjSanitize::html($v['name']); ?>"></span>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<?php
					}
					?>
				</div>
				<?php
			}
		} 
		?>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-white" data-dismiss="modal"><?php __('plugin_base_btn_close');?></button>
		<button type="button" class="btn btn-primary" id="btnSavePaymentOptions"><?php __('plugin_base_btn_save');?></button>
	</div>
</form>