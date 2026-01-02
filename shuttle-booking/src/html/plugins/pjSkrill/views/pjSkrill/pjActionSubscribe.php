<form action="https://pay.skrill.com" name="<?php echo $tpl['arr']['name']; ?>" id="<?php echo $tpl['arr']['id']; ?>" method="post" target="<?php echo $tpl['arr']['target']; ?>">
    <input type="hidden" name="pay_to_email" value="<?php echo pjSanitize::html($tpl['arr']['merchant_email']); ?>">
    <input type="hidden" name="status_url" value="<?php echo $tpl['arr']['notify_url'];?>">
    <input type="hidden" name="return_url" value="<?php echo $tpl['arr']['notify_url'];?>">
    <input type="hidden" name="cancel_url" value="<?php echo $tpl['arr']['cancel_url'];?>">
    <input type="hidden" name="transaction_id" value="<?php echo pjSanitize::html($tpl['arr']['custom']); ?>">
    <input type="hidden" name="amount" value="">
    <input type="hidden" name="currency" value="<?php echo pjSanitize::html($tpl['arr']['currency_code']); ?>">
    <input type="hidden" name="detail1_description" value="<?php echo pjSanitize::html($tpl['arr']['item_name']); ?>">
    <input type="hidden" name="firstname" value="<?php echo pjSanitize::html($tpl['arr']['first_name']); ?>">
    <input type="hidden" name="lastname" value="<?php echo pjSanitize::html($tpl['arr']['last_name']); ?>">
    <input type="hidden" name="pay_from_email" value="<?php echo pjSanitize::html($tpl['arr']['email']); ?>">
    <input type="hidden" name="language" value="<?php echo pjSanitize::html($tpl['arr']['locale']); ?>">
    <input type="hidden" name="rec_amount" value="<?php echo pjSanitize::html($tpl['arr']['amount']); ?>">
    <input type="hidden" name="rec_period" value="<?php echo pjSanitize::html($tpl['arr']['rec_period']); ?>">
    <input type="hidden" name="rec_cycle" value="<?php echo pjSanitize::html($tpl['arr']['rec_cycle']); ?>">
    <input type="hidden" name="rec_status_url" value="<?php echo $tpl['arr']['notify_url'];?>">
    <input type="hidden" name="rec_status_url2" value="<?php echo $tpl['arr']['notify_url'];?>">
    <input type="hidden" name="rec_trial_subscription" value="false">
</form>