<?php
$titles = __('error_titles', true);
$bodies = __('error_bodies', true);
$u_statarr = __('u_statarr', true);
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-6">
                <h2><?php echo __('infoUpdateTimetableTitle', true);?></h2>
            </div>
            
        </div>

        <p class="m-b-none"><i class="fa fa-info-circle"></i> <?php echo __('infoUpdateTimetableDesc', true); ?></p>
    </div>
</div>

<div class="row wrapper wrapper-content animated fadeInRight">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminTimetable&amp;action=pjActionUpdate" method="post" id="frmUpdateTimetable" class="form pj-form" autocomplete="off" enctype="multipart/form-data">
				<input type="hidden" name="timetable_update" value="1" />
				<input type="hidden" name="id" value="<?php echo (int)$tpl['arr']['id'];?>" />
            	<div class="ibox-content">
            		<div class="row">
            			<div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblStatus'); ?></label>

                                <div class="clearfix">
                                    <div class="switch onoffswitch-data pull-left">
                                        <div class="onoffswitch">
                                            <input type="checkbox" class="onoffswitch-checkbox" id="status" name="status"<?php echo $tpl['arr']['status']=='T' ? ' checked="checked"' : NULL;?>>
                                            <label class="onoffswitch-label" for="status">
                                                <span class="onoffswitch-inner" data-on="<?php echo $u_statarr['T'];?>" data-off="<?php echo $u_statarr['F'];?>"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div><!-- /.clearfix -->
                            </div><!-- /.form-group -->
                        </div><!-- /.col-md-3 -->
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php __('lblDepartureArrivalLocation');?></label>
            					<select name="location_id" id="location_id" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required'); ?>">
            						<option value="">-- <?php __('lblChoose'); ?>--</option>
            						<?php
            						foreach($tpl['da_arr'] as $k => $v)
            						{
            							?><option value="<?php echo $v['id'];?>"<?php echo $v['id'] == $tpl['arr']['location_id'] ? ' selected="selected"' : NULL;?>><?php echo $v['title'];?></option><?php
            						} 
            						?>
            					</select>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div id="pjLineWrapper" class="form-group">
                                <label class="control-label"><?php __('lblLine');?></label>
								<select name="line_id" id="line_id" class="form-control required" data-msg-required="<?php __('plugin_base_this_field_is_required'); ?>">
            						<option value="">-- <?php __('lblChoose'); ?>--</option>
            						<?php
            						if(isset($tpl['line_arr']))
            						{
            							foreach($tpl['line_arr'] as $v)
            							{
            								?><option value="<?php echo $v['id'];?>"<?php echo $v['id'] == $tpl['arr']['line_id'] ? ' selected="selected"' : NULL;?>><?php echo $v['title'];?></option><?php
            							}
            						} 
            						?>
            					</select>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div id="pjLineWrapper" class="form-group">
                                <label class="control-label"><?php __('lblDirection');?></label>
								<div class="form-horizontal">
									<label class="normal-label m-t-xs">
                                    	<input type="radio" name="direction" id="direcion_arriving" value="arriving" <?php echo $tpl['arr']['direction'] == 'arriving' ? ' checked="checked"': NULL;?> class="m-r-xs i-checks pps"/> <span class="m-l-xs"><?php __('lblArriving');?></span>
                                    </label>
    								<label class="normal-label m-t-xs">
                                    	<input type="radio" name="direction" id="direcion_departing" value="departing" <?php echo $tpl['arr']['direction'] == 'departing' ? ' checked="checked"': NULL;?> class="m-r-xs i-checks pps"/> <span class="m-l-xs"><?php __('lblDeparting');?></span>
                                    </label>
                                    
                                </div>
                            </div>
                        </div>
                    </div><!-- /.row --> 
                    
                    <div class="hr-line-dashed"></div>
                     
                    <div class="row">  
                        <div class="col-lg-6 col-md-6 col-sm-12">
                        	<div class="form-group">
                                <label class="control-label"><?php __('lblEvery');?></label>
								<div class="form-horizontal">
									<?php
									$days = __('days', true, true);
									$week_days = explode("|", $tpl['arr']['every']);
									foreach($days as $k => $v)
									{ 
									    ?>
									    <label class="normal-label m-t-xs">
                                        	<input type="checkbox" name="every[]" id="every_<?php echo $k?>" value="<?php echo $k?>"<?php echo in_array($k, $week_days) ? ' checked="checked"' : NULL;?> class="i-checks"/> <span class="m-l-xs"><?php echo $v;?></span>
                                        </label>
									    <?php
									}
									?>
									
                                </div>
                            </div>
                        </div>
					</div><!-- /.row -->
					
					<?php 
					$time_arr = explode("|", $tpl['arr']['time']);
					$index = 'new_' . rand(1, 999999);
					?>
					<div class="hr-line-dashed"></div>
						<div class="row">
    						<div class="col-lg-12 col-md-12 col-sm-12">
                            	<div class="form-group">
                                    <label class="control-label pjTimeLabel pjTimeLabel-arriving" style="display:<?php echo $tpl['arr']['direction'] == 'arriving' ? '': 'none';?>;"><?php __('lblArrivingAt');?></label>
                                    <label class="control-label pjTimeLabel pjTimeLabel-departing" style="display:<?php echo $tpl['arr']['direction'] == 'departing' ? '': 'none';?>;"><?php __('lblDepartingAt');?></label>
    								<div id="pjTimeWrapper" class="form-horizontal">
    									<?php
    									foreach($time_arr as $k => $time)
    									{ 
    									    $index = 'new_' . rand(1, 999999);
    									    if($k > 0)
    									    {
    									        ?>
    									  		<div class="pjTimeCell">
                									<div class="input-group clockpicker">
                                                        <input type="text" id="time_<?php echo $index;?>" name="time[<?php echo $index;?>]" value="<?php echo date($tpl['option_arr']['o_time_format'], strtotime($time));?>" class="form-control required" readonly data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>"/>
                                                        
                                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                    </div>
                                                    <a href="#" class="btn btn-outline btn-danger linkRemoveRow"><i class="fa fa-trash"></i></a>
                                                </div>      
    									        <?php
    									    }else{
    									        ?>
    									  		<div class="pjTimeCell">
                									<div class="input-group clockpicker">
                                                        <input type="text" id="time_<?php echo $index;?>" name="time[<?php echo $index;?>]" value="<?php echo date($tpl['option_arr']['o_time_format'], strtotime($time));?>" class="form-control required" readonly data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>"/>
                                                        
                                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                    </div>
                                                </div>      
    									        <?php
    									    }
    									}
    									?>
                                    </div>
                                </div>
                                <p>
                                	<a href="#" class="btn btn-primary btn-outline pjAddTime"><i class="fa fa-plus"></i> <?php __('btnAddTime'); ?></a>
                                </p>
                            </div>
						</div><!-- /.row -->
					<div class="hr-line-dashed"></div>
					
					<div class="clearfix">
						<button type="submit" class="ladda-button btn btn-primary btn-lg btn-phpjabbers-loader pull-left" data-style="zoom-in">
							<span class="ladda-label"><?php __('btnSave', false, true); ?></span>
							<?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
						</button>
	
						<button type="button" class="btn btn-white btn-lg pull-right" onclick="window.location.href='<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjAdminTimetable&action=pjActionIndex';"><?php __('btnCancel'); ?></button>
					</div>
	            </div>
			</form>
        </div>
    </div>
</div>
<div id="pjTimeClone" style="display: none;">	
	<div class="pjTimeCell">
    	<div class="input-group clockpicker">
            <input type="text" id="time_{INDEX}" name="time[{INDEX}]" class="form-control required" readonly data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>"/>
            
            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
        </div>
        <a href="#" class="btn btn-outline btn-danger linkRemoveRow"><i class="fa fa-trash"></i></a>
    </div>
</div>
<?php
$show_period = 'false';
if((strpos($tpl['option_arr']['o_time_format'], 'a') > -1 || strpos($tpl['option_arr']['o_time_format'], 'A') > -1))
{
    $show_period = 'true';
}
?>
<script type="text/javascript">
var myLabel = myLabel || {};
myLabel.showperiod = <?php echo $show_period; ?>;
myLabel.field_required = <?php x__encode('tr_field_required', false, true); ?>;
myLabel.positive_number = <?php x__encode('lblPositiveNumber', false, true); ?>;
myLabel.choose = <?php x__encode('lblChoose', false, true); ?>;
</script>