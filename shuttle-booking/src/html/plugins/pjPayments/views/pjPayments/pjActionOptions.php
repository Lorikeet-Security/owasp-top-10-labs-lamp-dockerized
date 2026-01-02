<?php
pjUtil::printNotice(__('infoPaymentOptionsTitle', true), __('infoPaymentOptionsBody', true));
?>
<table cellpadding="0" cellspacing="0" class="pj-table" style="width: 100%">
    <?php
    foreach(pjPayments::getPaymentMethods() as $payment_method => $name)
    {
        $pjPlugin = pjPayments::getPluginName($payment_method);
        if(pjObject::getPlugin($pjPlugin) !== NULL)
        {
            $controller->requestAction(array('controller' => $pjPlugin, 'action' => 'pjActionOptions', 'params' => $controller->getParams()));
        }
    }
    ?>
    <tr>
        <td></td>
        <td><input type="submit" value="<?php __('btnSave'); ?>" class="pj-button" /></td>
    </tr>
</table>