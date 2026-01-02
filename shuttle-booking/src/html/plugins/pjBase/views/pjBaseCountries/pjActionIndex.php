<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-10">
                <h2><?php __('plugin_base_infobox_countries_title'); ?></h2>
            </div>
        </div><!-- /.row -->

        <p class="m-b-none"><i class="fa fa-info-circle"></i> <?php __('plugin_base_infobox_countries_desc');?></p>
    </div><!-- /.col-md-12 -->
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
    		case in_array($error_code, array('PCY01', 'PCY03')):
    			?>
    			<div class="alert alert-success">
    				<i class="fa fa-check m-r-xs"></i>
    				<strong><?php echo @$titles[$error_code]; ?></strong>
    				<?php echo @$bodies[$error_code]?>
    			</div>
    			<?php 
    			break;
            case in_array($error_code, array('PCY04', 'PCY08')):	
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
                    <div class="row m-b-md">
                        <div class="col-md-4 col-sm-4">
                            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseCountries&amp;action=pjActionCreate" class="btn btn-primary"><i class="fa fa-plus"></i> <?php __('plugin_base_btn_add_country');?></a>
                        </div><!-- /.col-md-6 -->
    
                        <div class="col-md-4 col-sm-8">
                        	<form action="" method="get" class="form-horizontal frm-filter">
								<div class="input-group">
									<input type="text" name="q" placeholder="<?php __('plugin_base_btn_search', false, true); ?>" class="form-control">
									<div class="input-group-btn">
										<button class="btn btn-primary" type="submit">
											<i class="fa fa-search"></i>
										</button>
									</div>
								</div>
							</form>
                        </div><!-- /.col-md-3 -->
    
                        <div class="col-md-4 text-right">
                            <div class="btn-group" role="group" aria-label="...">
                                <button type="button" class="btn btn-default btn-all"><?php __('plugin_base_lbl_all');?></button>
                                <button type="button" class="btn btn-default btn-filter" data-column="status" data-value="T"><i class="fa fa-check"></i> <?php __('plugin_base_filter_ARRAY_active'); ?></button>
                                <button type="button" class="btn btn-default btn-filter" data-column="status" data-value="F"><i class="fa fa-times"></i> <?php __('plugin_base_filter_ARRAY_inactive'); ?></button>
                            </div>
                        </div><!-- /.col-md-6 -->
                    </div>
    
                    <div id="grid"></div>
                    
                </div>
            </div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div>

<script type="text/javascript">
var pjGrid = pjGrid || {};
pjGrid.has_revert = <?php echo (int) $tpl['has_revert']; ?>;
var myLabel = myLabel || {};
myLabel.country_name = <?php x__encode('plugin_base_country_name'); ?>;
myLabel.alpha_2 = <?php x__encode('plugin_base_alpha_2'); ?>;
myLabel.alpha_3 = <?php x__encode('plugin_base_alpha_3'); ?>;
myLabel.status = <?php x__encode('plugin_base_status'); ?>;
myLabel.revert_status = <?php x__encode('plugin_base_revert_status'); ?>;
myLabel.active = <?php x__encode('plugin_base_filter_ARRAY_active'); ?>;
myLabel.inactive = <?php x__encode('plugin_base_filter_ARRAY_inactive'); ?>;
myLabel.delete_selected = <?php x__encode('plugin_base_delete_selected'); ?>;
myLabel.delete_confirmation = <?php x__encode('plugin_base_delete_confirmation'); ?>;
</script>