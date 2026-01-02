<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-md-10">
				<h2><?php __('plugin_base_infobox_api_keys_title'); ?></h2>
			</div>
		</div>
		<p class="m-b-none"><i class="fa fa-info-circle"></i><?php __('plugin_base_infobox_api_keys_desc'); ?></p>
	</div>

</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<?php
	$error_code = $controller->_get->toString('err');
	if (!empty($error_code))
    {
    	$titles = __('plugin_base_error_titles', true);
    	$bodies = __('plugin_base_error_bodies', true);
    	switch (true)
    	{
    		case in_array($error_code, array('PBS06')):
    			?>
    			<div class="alert alert-success">
    				<i class="fa fa-check m-r-xs"></i>
    				<strong><?php echo @$titles[$error_code]; ?></strong>
    				<?php echo @$bodies[$error_code]?>
    			</div>
    			<?php
    			break;
    		case in_array($error_code, array('')):
    			?>
    			<div class="alert alert-danger">
    				<i class="fa fa-exclamation-triangle m-r-xs"></i>
    				<strong><?php echo @$titles[$error_code]; ?></strong>
    				<?php echo @$bodies[$error_code]?>
    			</div>
    			<?php
    			break;
    	}
    }
    ?>
    <div class="row">
    	<div class="col-lg-12">
    		<div class="ibox float-e-margins">
    			<div class="ibox-content">
    				<?php
    				if (isset($tpl['arr']))
    				{
    				    if (is_array($tpl['arr']))
    				    {
    				        $count = count($tpl['arr']);
    				        if ($count > 0)
    				        {
                                ?>
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseOptions&amp;action=pjActionOptionsUpdate" method="post" class="form-horizontal" id="frmAPIKeys">
                    				<input type="hidden" name="options_update" value="1" />
                    				<input type="hidden" name="next_action" value="pjActionApiKeys" />
                    				<?php
                    				$api_key_arr = array();
                    				if (isset($GLOBALS['CONFIG'], $GLOBALS['CONFIG']["api_keys"])
                    				    && is_array($GLOBALS['CONFIG']["api_keys"])
                    				    && !empty($GLOBALS['CONFIG']["api_keys"]))
                    				{
                    				    $api_key_arr = $GLOBALS['CONFIG']["api_keys"];
                    				}
                    				for ($i = 0; $i < $count; $i++)
                    				{
                    				    if (!empty($api_key_arr))
                    				    {
                    				        if($api_key_arr['google_api_key'] == false && in_array($tpl['arr'][$i]['key'], array('o_google_maps_api_key')))
                    				        {
                    				            continue;
                    				        }
                    				    }
                    				    if(in_array($tpl['arr'][$i]['key'], array('o_google_geocoding_api_key')))
                    				    {
                    				        continue;
                    				    }
                        				?>
                                        <div class="row">
                                            <div class="col-lg-8 col-lg-offset-2">
                                                <h2 class="m-b-md"><?php __('plugin_base_opt_' . $tpl['arr'][$i]['key']); ?></h2>

                                                <?php if ($info_text = __('plugin_base_opt_' . $tpl['arr'][$i]['key'] . '_text', true)): ?>
                                                    <p class="alert alert-info alert-with-icon m-t-xs">
                                                        <i class="fa fa-info-circle"></i> <?php echo $info_text ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div><!-- /.col-lg-8 -->
                                        </div>

                        				<div class="form-group">
                                        	<label class="col-lg-2 control-label"><?php __('plugin_base_api_key'); ?></label>

                                        	<div class="col-sm-8">
                                        		<div class="m-b-md">
                                            		<?php
                                            		switch ($tpl['arr'][$i]['type'])
                                            		{
                                            			case 'string':
                                            			        ?><input type="text" name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="form-control" value="<?php echo pjSanitize::html($tpl['arr'][$i]['value']); ?>"><?php
                                            				break;
                                            			case 'text':
                                            				?><textarea name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="form-control"><?php echo pjSanitize::html($tpl['arr'][$i]['value']); ?></textarea><?php
                                            				break;
                                            			case 'int':
                                            				?><input type="text" name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="form-control field-int" value="<?php echo pjSanitize::html($tpl['arr'][$i]['value']); ?>"><?php
                                            				break;
                                            			case 'float':
                                            				?><input type="text" name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="form-control field-float number" value="<?php echo number_format($tpl['arr'][$i]['value'], 2) ?>"><?php
                                            				break;
                                            		}
                                            		?>
                                            	</div>
                                        		<div class="row">
                                                    <div class="col-lg-4">
                                                        <a href="#" class="btn btn-primary btn-outline btn-verify" data-key="<?php echo $tpl['arr'][$i]['key'];?>"> <?php __('plugin_base_btn_verify_key');?></a>
                                                    </div><!-- /.col-lg-4 -->

                                                    <div id="verify-container-<?php echo $tpl['arr'][$i]['key'] ?>" class="col-lg-8"></div><!-- /.col-lg-8 -->
                                                </div><!-- /.row -->
                                        	</div>
                                        </div>

                                        <div class="hr-line-dashed"></div>
                                        <?php
                    				}
                                    ?>
                                    <div class="clearfix">
                						<button type="submit" class="ladda-button btn btn-primary btn-lg pull-left btn-phpjabbers-loader" data-style="zoom-in">
                                            <span class="ladda-label"><?php __('plugin_base_btn_save'); ?></span>
                                            <?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
                                        </button>
                    				</div>
                    			</form>
                                <?php
    				        }else{
    				            ?><h2><?php __('plugin_base_no_api_keys_added'); ?></h2><?php
    				        }
    				    }
    				}
    				?>
    			</div><!-- /.ibox-content -->
    		</div><!-- /.ibox float-e-margins -->
    	</div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.wrapper wrapper-content animated fadeInRight -->