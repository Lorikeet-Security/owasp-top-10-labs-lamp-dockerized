<form action="" method="get" name="plugin_mollie_payment_form" id="plugin_mollie_payment_form" target="<?php echo $tpl['arr']['target']; ?>"></form>

<div class="modal fade" id="modalMollie" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md" role="document">
		<form id="<?php echo pjSanitize::html(@$tpl['arr']['id']); ?>" action="" method="post" class="form-horizontal modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="myModalLabel"><?php __('plugin_mollie_payment_title') ?></h4>
			</div>

			<div class="modal-body">
				<input type="hidden" name="failure_url" value="<?php echo pjSanitize::html(@$tpl['arr']['failure_url']); ?>">
				<input type="hidden" name="foreign_id" value="<?php echo pjSanitize::html(@$tpl['arr']['foreign_id']); ?>">
				<input type="hidden" name="custom" value="<?php echo pjSanitize::html(@$tpl['arr']['custom']); ?>">
				<input type="hidden" name="notify_url" value="<?php echo pjSanitize::html(@$tpl['arr']['notify_url']); ?>">
				<input type="hidden" name="amount" value="<?php echo pjSanitize::html(@$tpl['arr']['amount']); ?>">
				<input type="hidden" name="interval" value="<?php echo pjSanitize::html(@$tpl['arr']['interval']); ?>">
				<input type="hidden" name="customer_id" value="<?php echo pjSanitize::html(@$tpl['arr']['customer_id']); ?>">
				<input type="hidden" name="sequence_type" value="first">
				<input type="hidden" name="currency" value="<?php echo pjSanitize::html(@$tpl['arr']['currency_code']); ?>">
				<input type="hidden" name="description" value="<?php echo pjSanitize::html(@$tpl['arr']['description']); ?>">
				<input type="hidden" name="public_key" value="<?php echo pjSanitize::html(@$tpl['arr']['public_key']); ?>">
				<input type="hidden" name="locale" value="<?php echo pjSanitize::html(@$tpl['arr']['locale']); ?>">

				<?php
				$methods = __('plugin_mollie_methods', true);
				$methods = array_intersect_key($methods, $tpl['method_arr']);
				?>
				<div class="form-group">
					<label for="" class="col-lg-2 col-md-2 col-sm-2 col-xs-4 control-label"><?php __('plugin_mollie_method'); ?></label>

					<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
						<select name="mollie_method" class="form-control required" data-msg-required="<?php echo __('plugin_mollie_method_required', true);?>">
							<?php if(count($methods) == 1): ?>
								<?php foreach ($methods as $k => $v): ?>
									<option value="<?php echo $k; ?>" selected="selected" data-auto-submit="1"><?php echo $v; ?></option>
								<?php endforeach; ?>
							<?php else: ?>
								<option value=""><?php __('plugin_mollie_method_empty'); ?></option>
								<?php foreach ($methods as $k => $v): ?>
									<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
						<div class="help-block with-errors"><ul class="list-unstyled"></ul></div>
					</div>
				</div>

				<?php if(array_key_exists('ideal', $methods)): ?>
					<?php
					$issuers = $controller->requestAction(array(
						'controller' => 'pjMollie', 
						'action' => 'pjActionGetAvailUsers', 
						'params' => array(
							'public_key' => $tpl['arr']['public_key']
						)), array('return')); 
					?>
					<div class="form-group vrMollieIDeal" style="display: none;">
						<label for="" class="col-lg-2 col-md-2 col-sm-2 col-xs-4 control-label"><?php __('plugin_mollie_ideal_bank_id'); ?></label>

						<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
							<select name="ideal_bank_id" class="form-control">
								<option value=""><?php __('plugin_mollie_ideal_bank_choose'); ?></option>
								<?php foreach ($issuers as $issuer): ?>
								<option value="<?php echo pjSanitize::html($issuer['id']); ?>"><?php echo pjSanitize::html($issuer['name']); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<div class="modal-footer">
				<button type="submit" class="btn btn-default"><?php __('plugin_mollie_button_submit'); ?></button>
			</div>
		</form>
	</div>
</div>
	
<script>
(function ($, undefined) {
	var $form = $('#<?php echo $tpl['arr']['id']; ?>');
	if ($form.length) {
		if ($.fn.validate !== undefined) {
			$form.validate({
				rules: {
					"mollie_method": "required"
				},
				submitHandler: function (form) {
					$.post("<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjMollie&action=pjActionGetUrl", $(form).serialize()).done(function (data) {
						$('#plugin_mollie_payment_form')
							.attr('action', data.url)
							.trigger('submit');
					});
					return false;
				}
			});
		}

		if ($form.find('select[name="mollie_method"] option[data-auto-submit="1"]').length)
		{
			// Submit the form automatically without showing the modal when there is only one available Mollie method.
			$form.trigger('submit');
		} else {
			$(document).on("change", 'select[name="mollie_method"]', function (e) {
				$('.vrMollieIDeal').toggle($(this).val() === 'ideal');
			});

			$("#modalMollie").on("hidden.bs.modal", function () {
				// Cancel the order if the popup is closed by user.
				$('<input>').attr({
					type: 'hidden',
					name: 'cancel_hash',
					value: '<?php echo pjSanitize::html(@$tpl['arr']['cancel_hash']); ?>'
				}).appendTo($form);
				$form.trigger('submit');
			});

			$('#modalMollie .modal-dialog').css('z-index', 1040);
			$('#modalMollie').modal("show");
		}
	}
})((window.pjQ && window.pjQ.jQuery) || jQuery);
</script>