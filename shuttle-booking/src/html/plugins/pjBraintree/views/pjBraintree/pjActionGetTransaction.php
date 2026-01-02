<header class="main">
    <div class="container wide">
        <div class="content slim">
            <div class="set">
                <div class="fill">
                    <a class="pseudoshop" href="#"><strong><?php __('front_site_name') ?></strong></a>
                </div>

                <div class="fit">
                    <a class="braintree" href="https://developers.braintreepayments.com/guides/drop-in" target="_blank"><?php __('plugin_braintree_braintree_name'); ?></a>
                </div>
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
if(isset($tpl['transaction']))
{ 
	$transaction = $tpl['transaction'];
	?>
	<div class="wrapper">
	    <div class="response container">
	        <div class="content">
	            <div class="icon">
	                <img src="<?php echo $controller->getConst('PLUGIN_IMG_PATH'); ?>fail.svg" alt="">
	            </div>
	
	            <h1><?php __('plugin_braintree_transaction_failed');?></h1>
	            <section>
	                <p><?php __('plugin_braintree_transaction_has_status');?> <?php echo $transaction['status']; ?></p>
	            </section>
	        </div>
	    </div>
	</div>
	
	<aside class="drawer dark">
	    <header>
	        <div class="content compact">
	            <a href="https://developers.braintreepayments.com" class="braintree" target="_blank"><?php __('plugin_braintree_braintree_name'); ?></a>
	            <h3><?php __('plugin_braintree_response'); ?></h3>
	        </div>
	    </header>
	
	    <article class="content compact">
	        <section>
	            <h5><?php __('plugin_braintree_transaction'); ?></h5>
	            <table cellpadding="0" cellspacing="0">
	                <tbody>
	                <tr>
	                    <td><?php __('plugin_braintree_trasaction_id'); ?></td>
	                    <td><?php echo $transaction['id']; ?></td>
	                </tr>
	                <tr>
	                    <td><?php __('plugin_braintree_trasaction_type'); ?></td>
	                    <td><?php echo $transaction['type']; ?></td>
	                </tr>
	                <tr>
	                    <td><?php __('plugin_braintree_trasaction_amount'); ?></td>
	                    <td><?php echo $transaction['amount']['value']; ?></td>
	                </tr>
	                <tr>
	                    <td><?php __('plugin_braintree_trasaction_status'); ?></td>
	                    <td><?php echo $transaction['status']; ?></td>
	                </tr>
	                </tbody>
	            </table>
	        </section>
	
	        <section>
                <?php
                if (class_exists('pjInput'))
                {
                    $hash = $controller->_get->toString('hash');
                    $custom = $controller->_get->toString('custom');
                    $notify_url = $controller->_get->toString('notify_url');
                } else {
                    $hash = @$_GET['hash'];
                    $custom = @$_GET['custom'];
                    $notify_url = @$_GET['notify_url'];
                }
                ?>
	            <form method="post" action="">
	                <input type="hidden" name="amount" value="<?php echo $transaction['amount']['value']; ?>">
	                <input type="hidden" name="hash" value="<?php echo $hash; ?>">
	                <input type="hidden" name="custom" value="<?php echo $custom; ?>">
	                <input type="hidden" name="notify_url" value="<?php echo $notify_url; ?>">
	                <button class="button secondary full" type="submit"><?php __('plugin_braintree_btn_try_again');?></button>
	            </form>
	        </section>
	    </article>
	</aside>
	<?php
} 
?>