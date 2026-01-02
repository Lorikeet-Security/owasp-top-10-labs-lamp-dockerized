<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-10">
                <h2><?php __('infoLocationsTitle', false, true);?></h2>
            </div>
        </div><!-- /.row -->

        <p class="m-b-none"><i class="fa fa-info-circle"></i> <?php __('infoLocationsDesc', false, true);?></p>
    </div><!-- /.col-md-12 -->
</div>

<div class="row wrapper wrapper-content animated fadeInRight">
    <div class="col-lg-12">
    	<?php
    	$error_code = $controller->_get->toString('err');
    	if (!empty($error_code))
    	{
    	    $titles = __('error_titles', true);
    	    $bodies = __('error_bodies', true);
    	    switch (true)
    	    {
    	        case in_array($error_code, array('AL01', 'AL02')):
    	            ?>
    				<div class="alert alert-success">
    					<i class="fa fa-check m-r-xs"></i>
    					<strong><?php echo @$titles[$error_code]; ?></strong>
    					<?php echo @$bodies[$error_code]?>
    				</div>
    				<?php
    				break;
                case in_array($error_code, array('AL09', 'AT10')):
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
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="row m-b-md">
                    <div class="col-md-4">
                    	<?php
                    	if(pjAuth::factory('pjAdminLocations', 'pjActionCreate')->hasAccess())
                    	{
                        	?>
                        	<a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminLocations&amp;action=pjActionCreate" class="btn btn-primary"><i class="fa fa-plus"></i> <?php __('btnAddLocation') ?></a>
                        	<?php
                    	}
                        ?>
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
                </div><!-- /.row -->
				
				<div id="grid"></div>
            </div>
        </div>
    </div><!-- /.col-lg-12 -->
</div>

<?php
$filter = __('filter', true, false);
?>
<script type="text/javascript">
var pjGrid = pjGrid || {};
pjGrid.queryString = "";
pjGrid.hasUpdate = <?php echo pjAuth::factory('pjAdminLocations', 'pjActionUpdate')->hasAccess() ? 'true' : 'false';?>;
pjGrid.hasDeleteSingle = <?php echo pjAuth::factory('pjAdminLocations', 'pjActionDeleteLocation')->hasAccess() ? 'true' : 'false';?>;
pjGrid.hasDeleteMulti = <?php echo pjAuth::factory('pjAdminLocations', 'pjActionDeleteLocationBulk')->hasAccess() ? 'true' : 'false';?>;
var myLabel = myLabel || {};
myLabel.title = <?php x__encode('lblTitle'); ?>;
myLabel.address = <?php x__encode('lblAddress'); ?>;
myLabel.exported = <?php x__encode('lblExport'); ?>;
myLabel.status = <?php x__encode('lblStatus'); ?>;
myLabel.active = <?php x__encode('lblActive'); ?>;
myLabel.inactive = <?php x__encode('lblInactive'); ?>;
myLabel.delete_selected = <?php x__encode('delete_selected'); ?>;
myLabel.delete_confirmation = <?php x__encode('delete_confirmation'); ?>;
</script>