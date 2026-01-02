<?php
$is_test_mode = (int) $tpl['arr']['is_test_mode'] === 1;
$worldpay_url = $is_test_mode
	? 'https://secure-test.worldpay.com/wcc/purchase' 
	: 'https://secure.worldpay.com/wcc/purchase';
?>
<form action="<?php echo $worldpay_url; ?>" name="<?php echo $tpl['arr']['name']; ?>" id="<?php echo $tpl['arr']['id']; ?>" method="post" target="<?php echo $tpl['arr']['target']; ?>">
    <input type="hidden" name="testMode" value="<?php echo $is_test_mode ? 100 : 0; ?>">
	<input type="hidden" name="instId" value="<?php echo pjSanitize::html($tpl['arr']['merchant_id']); ?>">
	<input type="hidden" name="cartId" value="<?php echo pjSanitize::html($tpl['arr']['custom']); ?>">
	<input type="hidden" name="amount" value="<?php echo number_format($tpl['arr']['amount'], 2, '.', ''); ?>">
	<input type="hidden" name="currency" value="<?php echo $tpl['arr']['currency_code']; ?>">
    <input type="hidden" name="MC_uuid" value="<?php echo htmlspecialchars($tpl['arr']['custom']); ?>">
    <input type="hidden" name="MC_callback" value="<?php echo $tpl['arr']['notify_url']; ?>">
    <input type="hidden" name="lang" value="<?php echo $tpl['arr']['locale']; ?>">
</form>