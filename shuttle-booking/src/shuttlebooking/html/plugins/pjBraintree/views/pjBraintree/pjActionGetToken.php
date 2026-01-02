<header class="main">
	<div class="container wide">
		<div class="content slim">
			<div class="set">
				<div class="fill">
					<strong><?php __('plugin_braintree_site_name'); ?></strong>
				</div>

				<?php if(PJ_TEST_MODE): ?>
					<div class="fit">
						<a class="braintree" href="https://developers.braintreepayments.com/guides/drop-in" target="_blank"><?php __('plugin_braintree_braintree_name'); ?></a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="notice-wrapper">
		<?php if(isset($tpl['tm_text'])) : ?>
			<div class="show notice error notice-error">
				<span class="notice-message">
					<?php echo pjSanitize::html($tpl['tm_text']);?>
				<span>
			</div>
		<?php endif; ?>
	</div>
</header>
<?php
if (class_exists('pjInput'))
{
	$hash		= $controller->_post->toString('hash');
	$amount		= $controller->_post->toFloat('amount');
	$custom		= $controller->_post->toString('custom');
	$notify_url	= $controller->_post->toString('notify_url');
	$cancel_url	= $controller->_post->toString('cancel_url');
	$locale		= $controller->_post->toString('locale');
	$is_subscription = $controller->_post->has('is_subscription') && $controller->_post->toInt('is_subscription') == 1;
	if ($is_subscription)
	{
	    $first_name = $controller->_post->toString('first_name');
	    $last_name  = $controller->_post->toString('last_name');
	}
} else {
	$pjAppModel	= pjAppModel::factory();
	$hash		= @$_POST['hash'] ? $pjAppModel->escapeStr($_POST['hash']): null;
	$amount		= @$_POST['amount'] ? $pjAppModel->escapeStr($_POST['amount']): 0.00;
	$custom		= @$_POST['custom'] ? $pjAppModel->escapeStr($_POST['custom']): null;
	$notify_url	= @$_POST['notify_url'] ? $pjAppModel->escapeStr($_POST['notify_url']): null;
	$cancel_url	= @$_POST['cancel_url'] ? $pjAppModel->escapeStr($_POST['cancel_url']): null;
	$locale		= @$_POST['locale'] ? $pjAppModel->escapeStr($_POST['locale']): null;
	$is_subscription = isset($_POST['is_subscription']) && $_POST['is_subscription'] == 1;
	if ($is_subscription)
	{
	    $first_name = isset($_POST['first_name']) ? $pjAppModel->escapeStr($_POST['first_name']): null;
	    $last_name  = isset($_POST['last_name']) ? $pjAppModel->escapeStr($_POST['last_name']): null;
	}
}
$amount = number_format($amount, 2, '.', '');
 
if (!empty($amount) && !empty($hash) && !empty($custom) && !empty($notify_url))
{
	?>
	<div class="wrapper">
		<div class="checkout container">
			<header>
				<p><?php __('plugin_braintree_make_a_payment');?></p>
			</header>

			<form method="post" id="payment-form" action="">
				<input type="hidden" name="hash" value="<?php echo $hash; ?>">
				<input type="hidden" name="custom" value="<?php echo $custom; ?>">
				<input type="hidden" name="notify_url" value="<?php echo $notify_url; ?>">

				<section>
					<label for="amount">
						<span class="input-label"><?php __('plugin_braintree_amount');?></span>
						<div class="input-wrapper amount-wrapper">
							<input id="amount" name="amount" type="tel" min="1" readonly placeholder="<?php __('plugin_braintree_amount', false, true);?>" value="<?php echo $amount; ?>">
						</div>
					</label>
                    <?php 
                    if ($is_subscription)
                    {
                        ?>
                        <label for="first_name">
    						<span class="input-label"><?php __('plugin_braintree_first_name'); ?></span>
    						<div class="input-wrapper">
    							<input id="first_name" name="first_name" type="text" placeholder="<?php __('plugin_braintree_first_name', false, true); ?>" value="<?php echo $first_name; ?>">
    						</div>
    					</label>
    					
    					<label for="last_name">
    						<span class="input-label"><?php __('plugin_braintree_last_name'); ?></span>
    						<div class="input-wrapper">
    							<input id="last_name" name="last_name" type="text" placeholder="<?php __('plugin_braintree_last_name', false, true); ?>" value="<?php echo $last_name; ?>">
    						</div>
    					</label>
                        <?php
                    }
                    ?>
					<div class="bt-drop-in-wrapper">
						<div id="bt-dropin"></div>
					</div>
				</section>

				<input id="nonce" name="payment_method_nonce" type="hidden" />
				<button class="button" type="submit"><span><?php __('plugin_braintree_btn_pay_now');?></span></button>
				<a href="<?php echo $cancel_url ?>" target="_self"><span><?php __('plugin_braintree_btn_cancel');?></span></a>
			</form>
		</div>
	</div>
	<?php
} else {
	?>
	<div class="wrapper">
		<div class="checkout container">
			<div class="content">
				<div class="icon">
					<img src="<?php echo $controller->getConst('PLUGIN_IMG_PATH'); ?>fail.svg" alt="">
				</div>

				<h1><?php __('plugin_braintree_transaction_failed');?></h1>
				<section>
					<p><?php __('plugin_braintree_missing_parameters');?></p>
				</section>
			</div>
		</div>
	</div>
	<?php 
}
?>
<input type="hidden" id="braintree-client-token" value="<?php echo @$tpl['client_token']; ?>">