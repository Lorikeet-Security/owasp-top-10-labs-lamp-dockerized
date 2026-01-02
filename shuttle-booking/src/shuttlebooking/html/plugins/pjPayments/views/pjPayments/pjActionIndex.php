<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-6">
                <h2><?php __('plugin_payments_info_payment_title'); ?></h2>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 btn-group-languages">
                <?php if ($tpl['is_flag_ready']) : ?>
                <div class="multilang"></div>
                <?php endif; ?>
            </div>
        </div>
        <p class="m-b-none"><i class="fa fa-info-circle"></i><?php __('plugin_payments_info_payment_desc'); ?></p>
    </div>
</div>

<div class="fakeLanguageWrapper" style="display: none;">
    <?php
    foreach ($tpl['lp_arr'] as $v)
    {
        ?>
        <div class="<?php echo $tpl['is_flag_ready'] ? 'input-group ' : NULL;?>pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 1 ? 'block' : 'none'; ?>">
            <input type="text" class="form-control" name="i18n[<?php echo $v['id']; ?>][fake_field]" data-msg-required="<?php __('plugin_payments_required_field');?>">
            <?php if ($tpl['is_flag_ready']) : ?>
            <span class="input-group-addon pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="<?php echo pjSanitize::html($v['name']); ?>"></span>
            <?php endif; ?>
        </div>
        <?php
    }
    ?>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <?php
                    $payment_methods = __('payment_methods', true);
                    $sort_arr = array('paypal','authorize','paypal_express','2checkout','stripe','mollie','skrill','world_pay','braintree');
                    $active_arr = array();
                    $other_methods = array();
                    if(pjObject::getPlugin('pjPayments') !== NULL)
                    {
                        $active_arr = pjPayments::getActivePaymentMethods($controller->getForeignId());
                        $other_methods = pjPayments::getPaymentMethods();
                    }
                    if(!empty($active_arr))
                    {
                        ?>
                        <div class="m-t-sm m-b-lg">
                            <h2 class="m-n"><?php __('plugin_payments_active_payment_gateways');?></h2>
                        </div>
                        <div class="row">
                            <?php
                            if(pjObject::getPlugin('pjPayments') !== NULL)
                            {
                                $active_arr = pjUtil::sortArrayByArray($active_arr, $sort_arr);
                                foreach($active_arr as $payment_method => $name)
                                {
                                    if(!in_array($payment_method, array('cash', 'bank')))
                                    {
                                        $pjPlugin = pjPayments::getPluginName($payment_method);
                                        if(pjObject::getPlugin($pjPlugin) !== NULL)
                                        {
                                            ?>
                                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                                <a href="#" class="payment paymentLink active" data-method="<?php echo $payment_method;?>" title="<?php echo $name;?>"><img src="<?php echo PJ_IMG_PATH?>backend/payments/<?php echo $payment_method?>.png" alt="<?php echo $name;?>"></a>
                                            </div>
                                            <?php
                                        }
                                    }else{
                                        ?>
                                        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                            <a href="#" class="payment paymentLink active" data-method="<?php echo $payment_method;?>" title="<?php echo $name;?>"><img src="<?php echo PJ_IMG_PATH?>backend/payments/<?php echo $payment_method?>.png" alt="<?php echo $name;?>"></a>
                                        </div>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </div>
                        <?php
                    }
                    if(!empty($other_methods))
                    {
                        ?>
                        <div class="m-t-lg m-b-lg">
                            <h2 class="m-n"><?php __('plugin_payments_add_payment_gateways');?></h2>
                        </div>
                        <div class="row">
                            <?php
                            if(pjObject::getPlugin('pjPayments') !== NULL)
                            {
                                $other_methods = pjUtil::sortArrayByArray($other_methods, $sort_arr);
                                foreach($other_methods as $payment_method => $name)
                                {
                                    if(!array_key_exists($payment_method, $active_arr))
                                    {
                                        $pjPlugin = pjPayments::getPluginName($payment_method);
                                        if(pjObject::getPlugin($pjPlugin) !== NULL)
                                        {
                                            ?>
                                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                                <a href="#" class="payment paymentLink" data-method="<?php echo $payment_method;?>" title="<?php echo $name;?>"><img src="<?php echo PJ_IMG_PATH?>backend/payments/<?php echo $payment_method?>.png" alt="<?php echo $name;?>"></a>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                        <?php
                        if((array_key_exists('cash', $other_methods) && !array_key_exists('cash', $active_arr)) || (array_key_exists('bank', $other_methods) && !array_key_exists('bank', $active_arr)))
                        {
                            ?>
                            <div class="m-t-lg m-b-lg">
                                <h2 class="m-n"><?php __('script_offline_payment_methods');?></h2>
                            </div>
                            <div class="row">
                            	<?php
                            	if(array_key_exists('bank', $other_methods) && !array_key_exists('bank', $active_arr))
                            	{
                            	    ?>
                                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                        <a href="#" class="payment paymentLink" data-method="bank" title="<?php echo $payment_methods['bank'];?>"><img src="<?php echo PJ_IMG_PATH?>backend/payments/bank.png" alt="<?php echo $payment_methods['bank'];?>"></a>
                                    </div>
                                    <?php
                            	}
                            	if(array_key_exists('cash', $other_methods) && !array_key_exists('cash', $active_arr))
                            	{
                            	    ?>
                                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                        <a href="#" class="payment paymentLink" data-method="cash" title="<?php echo $payment_methods['cash'];?>"><img src="<?php echo PJ_IMG_PATH?>backend/payments/cash.png" alt="<?php echo $payment_methods['cash'];?>"></a>
                                    </div>
                                    <?php
                            	}
                            	?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="paymentModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div id="modalContent" class="modal-content">

        </div>
    </div>
</div>

<script type="text/javascript">
var myLabel = myLabel || {};
<?php if ($tpl['is_flag_ready']) : ?>
    var pjBaseLocale = pjBaseLocale || {};
    pjBaseLocale.langs = <?php echo $tpl['locale_str']; ?>;
    pjBaseLocale.flagPath = "<?php echo PJ_FRAMEWORK_LIBS_PATH; ?>pj/img/flags/";
<?php endif; ?>
</script>