<?php
$url = (int) $tpl['arr']['is_test_mode'] === 1
	? "https://test.authorize.net/payment/payment" 
	: "https://accept.authorize.net/payment/payment";
?>
<form action="<?php echo $url; ?>" method="post" id="formAuthorizeNetPopup" name="formAuthorizeNetPopup" target="iframeAuthorizeNet">
	<input type="hidden" name="token" value="<?php echo $tpl['arr']['hostedPaymentToken']; ?>">
</form>

<div class="modal fade" id="modalAuthorizeNet" tabindex="-1" role="dialog" aria-labelledby="modalAuthorizeNetLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modalAuthorizeNetLabel">Authorize.NET</h4>
			</div>
			<div class="modal-body">
				<iframe name="iframeAuthorizeNet" id="iframeAuthorizeNet" width="100%" frameborder="0" scrolling="no"></iframe>
			</div>
		</div>
	</div>
</div>

<script>
(function($, undefined) {

	if (!window.AuthorizeNetPopup) {
		window.AuthorizeNetPopup = {};
	}
	
	if (!AuthorizeNetPopup.options) {
		AuthorizeNetPopup.options = {
			onPopupClosed: null
		};
	}

	AuthorizeNetPopup.onReceiveCommunication = function (querystr) {
		var params = parseQueryString(querystr.qstr);
		
		switch (params.action) {
		case "successfulSave":
			$("#modalAuthorizeNet").modal("hide");
			break;
		case "cancel":
			$("#modalAuthorizeNet").modal("hide");
			window.location.href = "<?php echo $tpl['arr']['cancel_url']; ?>";
			break;
		case "transactResponse":
			$("#modalAuthorizeNet").modal("hide");
			var response = JSON.parse(params.response);
			window.location.href = "<?php echo $tpl['arr']['notify_url']; ?>|transId=" + response.transId;
			break;
		case "resizeWindow":
			var w = parseInt(params["width"]);
			var h = parseInt(params["height"]);
			var ifrm = document.getElementById("iframeAuthorizeNet");
			ifrm.style.width = "100%";
			ifrm.style.height = h.toString() + "px";
			break;
		}
	};

	function parseQueryString(str) {
		var vars = [];
		var arr = str.split('&');
		var pair;
		for (var i = 0; i < arr.length; i++) {
			pair = arr[i].split('=');
			vars.push(pair[0]);
			vars[pair[0]] = unescape(pair[1]);
		}
		return vars;
	}

	$("#modalAuthorizeNet").on("show.bs.modal", function(e) {

		var $iframe = $("#iframeAuthorizeNet");
		var $form = $("#formAuthorizeNetPopup");
		
		$iframe.css({
			width: "100%",
			height: "578px"
		});

		$form.trigger("submit");
		
	}).on("hidden.bs.modal", function(e) {

		//$("#iframeAuthorizeNet").attr("src", "empty.html");
		
	});
	
	$("#modalAuthorizeNet").modal({
		backdrop: "static",
		keyboard: false
	}).modal("show");
	
})((window.pjQ && window.pjQ.jQuery) || jQuery);
</script>