<!doctype html>
<html>
<head>
	<title>IFrame Communicator</title>
	<meta charset="utf-8">
<!--
To securely communicate between our Accept Hosted form and your web page,
we need a communicator page which will be hosted on your site alongside
your checkout/payment page. You can provide the URL of the communicator
page in your token request, which will allow Authorize.Net to embed the
communicator page in the payment form, and send JavaScript messaging through
your communicator page to a listener script on your main page.

This page contains a JavaScript that listens for events from the payment
form and passes them to an event listener in the main page.
-->
	<script>
	function callParentFunction(str) {
		if (str 
			&& str.length > 0 
			&& window.parent 
			&& window.parent.parent 
			&& window.parent.parent.AuthorizeNetPopup 
			&& window.parent.parent.AuthorizeNetPopup.onReceiveCommunication) {
			var referrer = document.referrer;
			window.parent.parent.AuthorizeNetPopup.onReceiveCommunication({qstr : str , parent : referrer});
		}
	}
	
	function receiveMessage(event) {
		if (event && event.data) {
			callParentFunction(event.data);
		}
	}
	
	if (window.addEventListener) {
		window.addEventListener("message", receiveMessage, false);
	} else if (window.attachEvent) {
		window.attachEvent("onmessage", receiveMessage);
	}
	
	if (window.location.hash && window.location.hash.length > 1) {
		callParentFunction(window.location.hash.substring(1));
	}
	</script>
</head>
<body>
</body>
</html>