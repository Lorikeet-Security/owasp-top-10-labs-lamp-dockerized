<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-10">
                <h2><?php __('plugin_base_infobox_permissions_title'); ?></h2>
            </div>
        </div><!-- /.row -->

        <p class="m-b-none"><i class="fa fa-info-circle"></i> <?php __('plugin_base_infobox_permissions_desc');?></p>
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
    		case in_array($error_code, array('PPR01')):
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
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row m-b-md">
                        <div class="col-md-4 col-sm-4">
                            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBasePermissions&amp;action=pjActionRolePermission" class="btn btn-warning btn-outline"><i class="fa fa-cog"></i> <?php __('plugin_base_btn_set_role_permission');?></a>
                        </div><!-- /.col-md-6 -->
                    </div>
    
                    <div id="grid"></div>
                    
                </div>
            </div>
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div>

<script type="text/javascript">
var myLabel = myLabel || {};
myLabel.title = <?php x__encode('plugin_base_permission_title'); ?>;
myLabel.key = <?php x__encode('plugin_base_permission_key'); ?>;
</script>