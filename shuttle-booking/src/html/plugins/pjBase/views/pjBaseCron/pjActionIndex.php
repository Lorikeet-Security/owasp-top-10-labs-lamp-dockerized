<?php $statuses = __('plugin_base_filter'); ?>

<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-md-10">
				<h2><?php __('plugin_base_infobox_cron_jobs_title'); ?></h2>
			</div>
		</div>
		<p class="m-b-none"><i class="fa fa-info-circle"></i><?php __('plugin_base_infobox_cron_jobs_desc'); ?></p>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	
    <div class="row">
    	<div class="col-lg-12">
    		<div class="ibox float-e-margins">
    			<div class="ibox-content">
    				<form method="get" class="form-horizontal" id="form">
                        <div class="m-t-md m-b-lg">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h2><i class="fa fa-server text-secondary"></i> <?php __('plugin_base_server_path');?>:</h2>
                                    <h3><strong><?php echo PJ_INSTALL_PATH . "cron.php" ?></strong></h3>
                                </div><!-- /.col-lg-6 -->

                                <div class="col-lg-6">
                                    <h2><i class="fa fa-link text-secondary"></i> <?php __('plugin_base_cron_url');?>:</h2>
                                    <h3><strong><?php echo PJ_INSTALL_URL . 'cron.php' ?></strong></h3>
                                </div><!-- /.col-lg-6 -->
                            </div><!-- /.row -->
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="table-responsive table-responsive-secondary">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><?php __('plugin_base_cron_type');?></th>
                                        <th><?php __('plugin_base_cron_status');?></th>
                                        <th><?php __('plugin_base_cron_interval');?></th>
                                        <th><?php __('plugin_base_cron_next_run');?></th>
                                        <th><?php __('plugin_base_cron_last_run');?></th>
                                        <th><?php __('plugin_base_cron_status');?></th>
                                    </tr>
                                </thead>
                        
                                <tbody>
                                	<?php
                                	if(!empty($tpl['arr']))
                                	{
                                	    $periods = __('plugin_base_cron_periods', true);
                                	    foreach($tpl['arr'] as $v)
                                	    {
                                	        $next_run = $last_run = __('plugin_base_lbl_na', true);
                                	        if(!empty($v['last_run']))
                                	        {
                                    	        $last_run = date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], strtotime($v['last_run']));
                                	        }
                                	        if(!empty($v['next_run']))
                                	        {
                                    	        $next_run = date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], strtotime($v['next_run']));
                                	        }
                                	        $cron_title = @__($v['controller'].'_'.$v['action'], true, true);
                                	        ?>
                                	        <tr>
                                                <td><?php echo !empty($cron_title) ? $cron_title : $v['name'];?></td>
                                                <td>
                                                    <?php if ($v['is_active']): ?>
                                                        <div role="button" tabindex="0" aria-disabled="false" class="btn btn-primary btn-xs no-margins"><i class="fa fa-check"></i> <?php echo $statuses['active'] ?></div>
                                                    <?php else: ?>
                                                        <div role="button" tabindex="0" aria-disabled="false" class="btn btn-default btn-xs no-margins"><i class="fa fa-times"></i> <?php echo $statuses['inactive'] ?></div>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo (int) $v['interval'];?> <?php echo $periods[$v['period']];?></td>
                                                <td>
                                                    <span class="m-r-sm"><?php echo $next_run;?></span>
                                                    <?php if ($tpl['has_execute']) : ?>
	                                                    <?php if ($v['is_active']): ?>
	                                                        <button type="button" class="btn btn-sm btn-primary btn-outline no-margins btn-run-now" data-id="<?php echo $v['id'];?>"><i class="fa fa-play m-r-xs"></i> <?php __('plugin_base_cron_run_now');?></button>
	                                                    <?php else: ?>
	                                                        <button type="button" class="btn btn-sm btn-default btn-outline no-margins" disabled="disabled"><i class="fa fa-play m-r-xs"></i> <?php __('plugin_base_cron_run_now');?></button>
	                                                    <?php endif; ?>
													<?php endif; ?>
                                                </td>
                                                <td><?php echo $last_run;?></td>
                                                <td><?php echo !empty($v['status']) ? pjSanitize::html($v['status']) : __('plugin_base_lbl_na');?></td>
                                            </tr>
                                	        <?php
                                	    }
                                	}else{
                                	    ?>
                                	    <tr>
                                	    	<td colspan="5"><?php __('plugin_base_cron_no_cron_jobs');?></td>
                                	    </tr>
                                	    <?php
                                	}
                                	?>
                                </tbody>
                            </table>
                        </div>
                    </form>
    			</div><!-- /.ibox-content -->
    		</div><!-- /.ibox float-e-margins -->
    	</div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.wrapper wrapper-content animated fadeInRight -->

<script type="text/javascript">
var myLabel = myLabel || {};
myLabel.alert_title = <?php x__encode('plugin_base_cront_alert_title'); ?>;
myLabel.alert_text = <?php x__encode('plugin_base_cront_alert_text'); ?>;
myLabel.btn_confirm = <?php x__encode('plugin_base_btn_confirm'); ?>;
myLabel.btn_cancel = <?php x__encode('plugin_base_btn_cancel'); ?>;
</script>