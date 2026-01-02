<?php 
$titles = __('error_titles', true);
$bodies = __('error_bodies', true);
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
		<h2><?php echo __('infoBookingFormTitle', true); ?></h2>
        <p class="m-b-none"><i class="fa fa-info-circle"></i><?php echo __('infoBookingFormDesc', true); ?></p>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <?php
	$error_code = $controller->_get->toString('err');
	if (!empty($error_code))
    {
    	$titles = __('error_titles', true);
    	$bodies = __('error_bodies', true);
    	switch (true)
    	{
    		case in_array($error_code, array('AO03')):
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
                if (!empty($tpl['group_1_arr']) || !empty($tpl['group_2_arr']) || !empty($tpl['group_3_arr']))
				{
                    ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;action=pjActionUpdate" method="post" id="frmUpdateOptions">
                        <input type="hidden" name="options_update" value="1" />
                        <input type="hidden" name="tab" value="2" />
                        <input type="hidden" name="next_action" value="pjActionBookingForm" />

                        <div class="row">
							<?php
							foreach ($tpl['group_1_arr'] as $option)
							{
							    ?>
							    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
								    <div class="form-group">
                                        <label class="control-label"><?php __('opt_' . $option['key']); ?></label>
                                        <?php
                                        include dirname(__FILE__) . '/elements/enum.php';
                                        ?>
                                    </div><!-- /.form-group -->
                                </div>
							    <?php
							}
							?>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="row">
							<?php
							foreach ($tpl['group_2_arr'] as $option)
							{
							    ?>
							    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
								    <div class="form-group">
                                        <label class="control-label"><?php __('opt_' . $option['key']); ?></label>
                                        <?php
                                        include dirname(__FILE__) . '/elements/enum.php';
                                        ?>
                                    </div><!-- /.form-group -->
                                </div>
							    <?php
							}
							?>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="row">
							<?php
							foreach ($tpl['group_3_arr'] as $option)
							{
							    ?>
							    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
								    <div class="form-group">
                                        <label class="control-label"><?php __('opt_' . $option['key']); ?></label>
                                        <?php
                                        include dirname(__FILE__) . '/elements/enum.php';
                                        ?>
                                    </div><!-- /.form-group -->
                                </div>
							    <?php
							}
							?>
						</div>
						<div class="hr-line-dashed"></div>

                        <div class="clearfix">
                            <button class="ladda-button btn btn-primary btn-lg pull-left btn-phpjabbers-loader" data-style="zoom-in">
                                <span class="ladda-label"><?php __('plugin_base_btn_save'); ?></span>
                                <?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
                            </button>
                        </div>
                    </form>
                    <?php
                }
                ?>
            </div>
        </div>
    </div><!-- /.col-lg-12 -->
    </div>
</div>