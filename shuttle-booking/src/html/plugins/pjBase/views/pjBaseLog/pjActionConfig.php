<div class="row wrapper wrapper-content animated fadeInRight">
    <?php
	$error_code = $controller->_get->toString('err');
	if (!empty($error_code))
    {
    	$titles = __('plugin_base_error_titles', true);
    	$bodies = __('plugin_base_error_bodies', true);
    	switch (true)
    	{
    		case in_array($error_code, array('PLG01')):
    			?>
    			<div class="alert alert-success">
    				<i class="fa fa-check m-r-xs"></i>
    				<strong><?php echo @$titles[$error_code]; ?></strong>
    				<?php echo @$bodies[$error_code]?>
    			</div>
    			<?php
    			break;
    		case in_array($error_code, array()):
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

	<div class="col-lg-12">
		<div class="tabs-container">
            <?php include 'elements/menu.php'; ?>

			<div class="tab-content">
				<div class="tab-pane active">
					<div class="panel-body">
						<div class="ibox-content no-margins no-padding no-top-border">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseLog&amp;action=pjActionConfig" method="post" class="form-horizontal">
                                <input type="hidden" name="update_config" value="1" />

                                <?php
                                foreach ($tpl['data'] as $file)
                                {
                                    preg_match('/(\w+)\.controller\.php/', $file, $match);
                                    if (isset($match[1]))
                                    {
                                        ?>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><?php echo $match[1]; ?></label>
                                            <div class="col-sm-9">
                                                <div class="clearfix">
                                                    <div class="switch onoffswitch-data pull-left">
                                                        <div class="onoffswitch">
                                                            <input type="checkbox" class="onoffswitch-checkbox" id="controller_<?php echo $match[1] ?>" name="filename[]" value="<?php echo $match[1]; ?>" <?php echo in_array($match[1], $tpl['config_arr']) ? ' checked="checked"' : NULL; ?>>
                                                            <label class="onoffswitch-label" for="controller_<?php echo $match[1] ?>">
                                                                <span class="onoffswitch-inner" data-on="Yes" data-off="No"></span>
                                                                <span class="onoffswitch-switch"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>

                                <div class="hr-line-dashed"></div>

                                <div class="clearfix">
                                    <button class="ladda-button btn btn-primary btn-lg pull-left btn-phpjabbers-loader" data-style="zoom-in">
                                        <span class="ladda-label"><?php __('plugin_base_btn_save'); ?></span>
                                        <?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
                                    </button>
                                </div>
                            </form>
						</div><!-- /.ibox-content no-margins no-padding no-top-border -->
					</div><!-- /.panel-body -->
				</div><!-- /.tab-pane active -->
			</div><!-- /.tab-content -->
		</div><!-- /.tabs-container -->
	</div><!-- /.col-lg-12 -->
</div><!-- /.row wrapper wrapper-content animated fadeInRight -->