<?php
$tpl['arr']['amount'] = number_format($tpl['arr']['amount'], 2, '.', '');
$tmp = $tpl['arr']['amount'].$tpl['arr']['custom'].$tpl['arr']['notify_url'].$tpl['arr']['private_key'];
$hash = hash('sha256', $tmp);
?>
<form method="post" action="" style="display: inline" name="<?php echo $tpl['arr']['name']; ?>" id="<?php echo $tpl['arr']['id']; ?>">
	<input type="hidden" name="amount" value="<?php echo $tpl['arr']['amount']; ?>">
	<input type="hidden" name="custom" value="<?php echo $tpl['arr']['custom']; ?>">
	<input type="hidden" name="notify_url" value="<?php echo $tpl['arr']['notify_url']; ?>">
	<input type="hidden" name="cancel_url" value="<?php echo $tpl['arr']['cancel_url']; ?>">
	<input type="hidden" name="locale" value="<?php echo $tpl['arr']['locale']; ?>">
	<input type="hidden" name="first_name" value="<?php echo pjSanitize::html(@$tpl['arr']['first_name']); ?>">
	<input type="hidden" name="last_name" value="<?php echo pjSanitize::html(@$tpl['arr']['last_name']); ?>">
	<input type="hidden" name="is_subscription" value="1">
	<input type="hidden" name="hash" value="<?php echo $hash; ?>">
	<?php
	if (isset($tpl['arr']['submit']))
	{
		?><input type="submit" value="<?php echo htmlspecialchars(@$tpl['arr']['submit']); ?>" class="<?php echo @$tpl['arr']['submit_class']; ?>" /><?php
	}
	?>
</form>

<div class="modal fade" id="modalBraintree" tabindex="-1" role="dialog" aria-labelledby="modalBraintreeLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modalBraintreeLabel">Braintree</h4>
			</div>
			<div class="modal-body">
				
			</div>
		</div>
	</div>
</div>

<link rel="stylesheet" href="<?php echo PJ_INSTALL_URL . $controller->getConst('PLUGIN_CSS_PATH'); ?>app.css">
<script src="<?php echo PJ_INSTALL_URL . $controller->getConst('PLUGIN_JS_PATH'); ?>braintree.js"></script>
<script src="https://js.braintreegateway.com/web/dropin/1.25.0/js/dropin.min.js"></script>
<script>
(function($, undefined) {

	$.ajaxSetup({
		xhrFields: {
			withCredentials: true
		}
	});

	var session_id,
		isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor),
		getSessionId = function () {
			return sessionStorage.getItem("session_id") == null ? "" : sessionStorage.getItem("session_id");
		},
		createSessionId = function () {
			if (getSessionId() === "") {
				sessionStorage.setItem("session_id", "<?php echo session_id(); ?>");
			}
		},
		modalOpts = {
			backdrop: "static",
			keyboard: false
		};

	if (isSafari) {
		createSessionId();
		session_id = getSessionId();
	} else {
		session_id = "";
	}

	$("#pjOnlinePaymentForm_braintree").on("submit", function(e) {

		e.preventDefault();

		var $form = $(this),
			$modal = $("#modalBraintree");
		
		$.post("<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjBraintree&action=pjActionGetToken&session_id=" + session_id, $form.serialize()).done(function(data) {

			$modal.find(".modal-body").html(data);
			$modal.modal(modalOpts).modal("show");
		});

		return false;
	});

	$("#modalBraintree").on("shown.bs.modal", function(e) {
		var $modal = $(this),
			$body = $modal.find(".modal-body");
		
		var form = document.querySelector('#payment-form');
		braintree.dropin.create({
			authorization: $modal.find("#braintree-client-token").val(),
			selector: '#bt-dropin'
		}, function (createErr, instance) {
			if (createErr) {
				console.log('Create Error', createErr);

				var submit = form.querySelector("button[type='submit']");
				if (submit) {
					submit.disabled = true;
				}
				
				return;
			}

			form.addEventListener('submit', function (event) {
				event.preventDefault();

				instance.requestPaymentMethod(function (err, payload) {
					if (err) {
						console.log('Request Payment Method Error', err);
						return;
					}

					var submit = form.querySelector("button[type='submit']");
					if (submit) {
						submit.disabled = true;
					}

					// Add the nonce to the form and submit
					document.querySelector('#nonce').value = payload.nonce;

					$.post("<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjBraintree&action=pjActionGetCustomer&session_id=" + session_id, $(form).serialize()).done(function(data) {

						if (!(data && data.status)) {
							return;
						}
						
						if (data.status === "OK") {

							$modal.modal("hide");
							window.location.href = data.url;

						} else if (data.status === "FAIL") {

							$modal.modal("hide");
							$.get("<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjBraintree&action=pjActionGetTransaction&session_id=" + session_id, {
								id: data.id,
								notify_url: data.notify_url,
								custom: data.custom,
								hash: data.hash
							}).done(function(data) {
								$body.html(data);
								$modal.modal(modalOpts).modal("show");
							});
								
						} else if (data.status === "ERR") {

							$modal.modal("hide");
							$.post("<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjBraintree&action=pjActionGetToken&session_id=" + session_id + "&tm=" + data.tm).done(function(data) {
								$body.html(data);
								$modal.modal(modalOpts).modal("show");
							});
						}
					});
				});
			});
		});

		var checkout = new Demo({
			formID: 'payment-form'
		});
	});
	
})((window.pjQ && window.pjQ.jQuery) || jQuery);
</script>