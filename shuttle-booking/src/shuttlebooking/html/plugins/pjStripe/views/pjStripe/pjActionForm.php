<script>
(function () {
	function loadScript(url, callback) {
	    var script = document.createElement("script");
	    script.type = "text/javascript";
	    script.async = true;
	    if (script.readyState) {
	        script.onreadystatechange = function () {
	            if (script.readyState === "loaded" || script.readyState === "complete") {
	                script.onreadystatechange = null;
	                if (callback && typeof callback === "function") {
	                    callback();
	                }
	            }
	        };
	    } else {
	        script.onload = function () {
	            if (callback && typeof callback === "function") {
	                callback();
	            }
	        };
	    }
	    script.src = url;
	    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(script);
	}

	function stripeCallback() {
		var stripe = Stripe('<?php echo pjSanitize::html(@$tpl['arr']['public_key']); ?>');
	
		stripe.redirectToCheckout({
			sessionId: '<?php echo @$tpl['session_id']; ?>'
		}).then(function (result) {
			// If `redirectToCheckout` fails due to a browser or network
			// error, display the localized error message to your customer
			// using `result.error.message`.
		});
	}

	if (!window.Stripe) {
		loadScript('https://js.stripe.com/v3/', stripeCallback);
	} else {
		stripeCallback();
	}
})();
</script>