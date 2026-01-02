<div class="pjSbs-head">
	<div class="row">
		<div class="col-sm-12 col-xs-12">
			&nbsp;
		</div>
	</div>
</div>
<div class="pjSbs-body">
	<div class="row">
		<div class="col-sm-12 text-center">
			<?php
			if (isset($tpl['get']['payment_method']))
			{
			    $status = __('front_messages', true, false);
			    if(isset($tpl['params']['plugin']) && !empty($tpl['params']['plugin']))
			    {
			        $payment_messages = __('payment_plugin_messages');
			        ?>
                    <p class="text-success text-center"><?php echo isset($payment_messages[$tpl['arr']['payment_method']]) ? $payment_messages[$tpl['arr']['payment_method']]: $front_messages[1];?></p>
                    <?php
                    if (pjObject::getPlugin($tpl['params']['plugin']) !== NULL)
                    {
                        $controller->requestAction(array('controller' => $tpl['params']['plugin'], 'action' => 'pjActionForm', 'params' => $tpl['params']));
                    }
                }else{
                    switch ($tpl['arr']['payment_method'])
                    {
                        case 'bank':
                        case 'creditcard':
                        case 'cash':
                        default:
                            ?><p class="text-success text-center"><?php echo $status[3]; ?></p><?php
                    }
                }
			}
			
			if($tpl['get']['payment_method'] == 'bank' || $tpl['get']['payment_method'] == 'creditcard' || $tpl['get']['payment_method'] == 'cash' || $tpl['option_arr']['o_payment_disable'] == 'Yes') 
			{
				?>
				<input type="button" class="btn btn-primary pjSbsBtnStartOver" value="<?php __('front_btn_start_over')?>" />
				<?php
			} 
			?>
		</div>
	</div>
</div>