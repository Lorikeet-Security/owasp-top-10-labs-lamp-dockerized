<div id="paypal-button-container"></div>

<script>
(function () {
	
	function loadScript(url, callback) {
		var script = document.createElement("script");
		script.type = "text/javascript";
		script.async = true;
		if (script.readyState) {
			script.onreadystatechange = function () {
				if (script.readyState == "loaded" || script.readyState == "complete") {
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
		(document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]).appendChild(script);
	}
	
	function paypalCallback() {
		
		paypal.Buttons({
			// Set up the transaction
			createSubscription: function(data, actions) {
				return actions.subscription.create({
	      			'plan_id': '<?php echo $tpl['plan_id']; ?>'
				});
	  		},
			// Finalize the transaction
			onApprove: function(data, actions) {
				var node = document.getElementById("paypal-button-container");
				if (node.parentNode) {
					node.parentNode.removeChild(node);
				}
				
				// Show a success message to the buyer

				var fd;
				
				if (window.FormData) {
					fd = new FormData();
					fd.append("subscriptionID", data.subscriptionID);
				} else {
					fd = "subscriptionID=" + encodeURIComponent(data.subscriptionID);
				}
				
				if (window.fetch) {
					
					return fetch("<?php echo @$tpl['arr']['notify_url']; ?>", {
						method: "POST",
						mode: "cors",
						redirect: "manual",
						body: fd
					}).then(function(response) {
						return response.text();
					}).then(function(text) {
						console.log(text);
						window.location.href = "<?php echo @$tpl['arr']['return_url']; ?>";
					});

				} else {

					var xhr = new XMLHttpRequest();
					xhr.open("POST", "<?php echo @$tpl['arr']['notify_url']; ?>", true);
					xhr.onload = function(e) {
						console.log(e);
						if (this.status == 200) {
							window.location.href = "<?php echo @$tpl['arr']['return_url']; ?>";
						}
					};
					xhr.send(fd)
				}
			}
		}).render("#paypal-button-container");
	}

	if (!window.paypal) {
		loadScript("https://www.paypal.com/sdk/js?client-id=<?php echo @$tpl['arr']['merchant_id']; ?>&currency=<?php echo @$tpl['arr']['currency_code']; ?>&vault=true", paypalCallback);
	} else {
		paypalCallback();
	}
})();
</script>