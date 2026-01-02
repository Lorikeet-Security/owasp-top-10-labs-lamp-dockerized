<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-10">
                <h2><?php __('infoTimetablesTitle', false, true);?></h2>
            </div>
        </div><!-- /.row -->

        <p class="m-b-none"><i class="fa fa-info-circle"></i> <?php __('infoTimetablesDesc', false, true);?></p>
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
    	    $bodies_text = str_replace("{SIZE}", ini_get('post_max_size'), @$bodies[$error_code]);
    	    switch (true)
    	    {
    	        case in_array($error_code, array('ATB01', 'ATB03')):
    	            ?>
    				<div class="alert alert-success">
    					<i class="fa fa-check m-r-xs"></i>
    					<strong><?php echo @$titles[$error_code]; ?></strong>
    					<?php echo $bodies_text;?>
    				</div>
    				<?php
    				break;
                case in_array($error_code, array('ATB08', 'ATB04')):
    				?>
    				<div class="alert alert-danger">
    					<i class="fa fa-exclamation-triangle m-r-xs"></i>
    					<strong><?php echo @$titles[$error_code]; ?></strong>
    					<?php echo $bodies_text;?>
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
                    	if(pjAuth::factory('pjAdminTimetables', 'pjActionCreate')->hasAccess())
                    	{
                        	?>
                        	<a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminTimetable&amp;action=pjActionCreate" class="btn btn-primary"><i class="fa fa-plus"></i> <?php __('btnAddTimetable') ?></a>
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
pjGrid.hasAccessUpdate = <?php echo pjAuth::factory('pjAdminTimetables', 'pjActionUpdate')->hasAccess() ? 'true' : 'false';?>;
pjGrid.hasAccessView = <?php echo pjAuth::factory('pjAdminTimetables', 'pjActionSchedule')->hasAccess() ? 'true' : 'false';?>;
pjGrid.hasAccessDeleteSingle = <?php echo pjAuth::factory('pjAdminTimetables', 'pjActionDeleteTimetable')->hasAccess() ? 'true' : 'false';?>;
pjGrid.hasAccessDeleteMulti = <?php echo pjAuth::factory('pjAdminTimetables', 'pjActionDeleteTimetableBulk')->hasAccess() ? 'true' : 'false';?>;
var myLabel = myLabel || {};
myLabel.location = <?php x__encode('lblLocationDirection'); ?>;
myLabel.line = <?php x__encode('lblLine'); ?>;
myLabel.direction = <?php x__encode('lblDirection'); ?>;
myLabel.status = <?php x__encode('lblStatus'); ?>;
myLabel.active = <?php x__encode('u_statarr_ARRAY_T', false, true); ?>;
myLabel.inactive = <?php x__encode('u_statarr_ARRAY_F', false, true); ?>;
myLabel.delete_selected = <?php x__encode('delete_selected'); ?>;
myLabel.delete_confirmation = <?php x__encode('delete_confirmation'); ?>;
</script>