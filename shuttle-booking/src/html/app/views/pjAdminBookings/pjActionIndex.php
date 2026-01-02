<?php
$titles = __('error_titles', true);
$bodies = __('error_bodies', true);
$statuses = __('booking_statuses', true, true);
$week_start = isset($tpl['option_arr']['o_week_start']) && in_array((int) $tpl['option_arr']['o_week_start'], range(0,6)) ? (int) $tpl['option_arr']['o_week_start'] : 0;
$jqDateFormat = pjUtil::momentJsDateFormat($tpl['option_arr']['o_date_format']);
$months = __('months', true);
ksort($months);
$short_days = __('short_days', true);
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-10">
				<h2><?php __('infoReservationListTitle'); ?></h2>
			</div>
		</div>
		<p class="m-b-none"><i class="fa fa-info-circle"></i><?php __('infoReservationListDesc'); ?></p>
	</div>
</div>

<div id="datePickerOptions" style="display:none;" data-wstart="<?php echo (int) $tpl['option_arr']['o_week_start']; ?>" data-format="<?php echo $tpl['date_format']; ?>" data-months="<?php echo implode("_", $months);?>" data-days="<?php echo implode("_", $short_days);?>"></div>
        
<div class="wrapper wrapper-content animated fadeInRight">
	<?php
	$error_code = $controller->_get->toString('err');
	if (!empty($error_code))
	{
		switch (true)
		{
			case in_array($error_code, array('ABB01', 'ABB03')):
				?>
				<div class="alert alert-success">
					<i class="fa fa-check m-r-xs"></i>
					<strong><?php echo @$titles[$error_code]; ?></strong>
					<?php echo @$bodies[$error_code]?>
				</div>
				<?php 
				break;
			case in_array($controller->_get->toString('err'), array('ABB08', 'ABB04')):	
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
				<div class="ibox-content cardealer-no-border">
					<div class="row m-b-md">
						<div class="col-sm-3">
						<?php 
						if(pjAuth::factory('pjAdminBookings', 'pjActionCreate')->hasAccess())
						{
                        	?>
							<a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionCreate" class="btn btn-primary"><i class="fa fa-plus m-r-xs"></i> <?php __('btnAddEnquiry'); ?></a>
							<?php 
                        }
                        ?>
						</div>
						<div class="col-md-3 col-sm-5">
							<form action="" method="get" class="form-horizontal frm-filter">
								<div class="input-group">
									<input type="text" name="q" placeholder="<?php __('btnSearch', false, true); ?>" class="form-control">
									<div class="input-group-btn">
										<button class="btn btn-primary" type="submit">
											<i class="fa fa-search"></i>
										</button>
									</div>
								</div>
							</form>
                        </div>
                        <div class="col-md-2 col-sm-4">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn btn-primary btn-outline pj-button-detailed"><?php __('advance_search'); ?></a>
						</div>
						<div class="col-lg-2 col-lg-offset-2 col-md-4 col-sm-12 text-right">
							<select class="form-control btn-filter" name="filter_status" id="filter_status">
								<option value=""><?php __('lblAll'); ?></option>
								<option value="confirmed"><?php echo $statuses['confirmed']; ?></option>
								<option value="pending"><?php echo $statuses['pending']; ?></option>
								<option value="cancelled"><?php echo $statuses['cancelled']; ?></option>
							</select>
						</div>
					</div>				
					
					<div id="collapseOne" class="collapse">
						<div class="m-b-lg">
							<ul class="agile-list no-padding">
								<li class="success-element b-r-sm">
									<div class="panel-body">
										<form action="" method="get" class="frm-filter-advanced">
											
											<div class="row">
												<div class="col-md-4 col-md-4 col-sm-6">
													<div class="form-group">
														<label class="control-label"><?php __('lblPickupLocation'); ?></label>
														<select name="location_id" id="pickup_id" class="form-control">
                                							<option value="">-- <?php __('lblChoose'); ?>--</option>
                                							<?php
                                							foreach($tpl['pickup_arr'] as $k => $v)
                                							{
                                							    ?><option value="<?php echo $v['id'];?>"><?php echo pjSanitize::html($v['title']);?></option><?php
                                							} 
                                							?>
                                						</select>
													</div>
												</div><!-- /.col-md-4 -->
												<div class="col-md-4 col-md-4 col-sm-6">
													<div class="form-group">
														<label class="control-label"><?php __('lblDropoffLocation'); ?></label>
														<div id="trDropoffContainer">
    														<select name="dropoff_id" id="search_dropoff_id" class="form-control">
                                    							<option value="">-- <?php __('lblChoose'); ?>--</option>
                                    						</select>
                                						</div>
													</div>
												</div><!-- /.col-md-4 -->
												
												<div class="col-md-4 col-md-4 col-sm-6">
													<div class="form-group">
														<label class="control-label"><?php __('lblTransferDate'); ?></label>
														
														<div class="input-group date"
		                                                         data-provide="datepicker"
		                                                         data-date-autoclose="true"
		                                                         data-date-format="<?php echo $jqDateFormat ?>"
		                                                         data-date-week-start="<?php echo (int) $tpl['option_arr']['o_week_start'] ?>">
		                                                    <input type="text" name="date" id="date" class="form-control" autocomplete="off" readonly="readonly">
		                                                    <span class="input-group-addon">
		                                                        <span class="glyphicon glyphicon-calendar"></span>
		                                                    </span>
		                                                </div>
													</div>
												</div><!-- /.col-md-4 -->
											</div><!-- /.row -->
											
											<div class="row">
												<div class="col-md-4 col-md-4 col-sm-6">
													<div class="form-group">
														<label class="control-label"><?php __('email'); ?></label>
														<input type="text" id="email" name="email" class="form-control" />
													</div>
												</div><!-- /.col-md-4 -->
												<div class="col-md-4 col-md-4 col-sm-6">
													<div class="form-group">
														<label class="control-label"><?php __('lblName'); ?></label>
														<input type="text" id="name" name="name" class="form-control" />
													</div>
												</div><!-- /.col-md-4 -->
												
												<div class="col-md-4 col-md-4 col-sm-6">
													<div class="form-group">
														<label class="control-label"><?php __('lblPhone'); ?></label>
														
														<input type="text" id="phone" name="phone" class="form-control" />
													</div>
												</div><!-- /.col-md-4 -->
											</div><!-- /.row -->
											
											<div class="hr-line-dashed"></div>
											<button class="btn btn-primary" type="submit"><?php __('btnSearch'); ?></button>
											<button class="btn btn-primary btn-outline" type="reset"><?php __('btnCancel'); ?></button>
										</form>
									</div>
								</li>
							</ul>
						</div>
					</div>
                            
					<div id="grid"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
var pjGrid = pjGrid || {};
pjGrid.queryString = "";
<?php
if ($controller->_get->check('client_id') && $controller->_get->toInt('client_id') > 0)
{
    ?>pjGrid.queryString += "&client_id=<?php echo $controller->_get->toInt('client_id'); ?>";<?php
}
if ($controller->_get->check('date'))
{
    ?>pjGrid.queryString += "&date=<?php echo $controller->_get->toString('date'); ?>";<?php
}
?>
pjGrid.hasUpdate = <?php echo pjAuth::factory('pjAdminBookings', 'pjActionUpdate')->hasAccess() ? 'true' : 'false';?>;
pjGrid.hasDeleteSingle = <?php echo pjAuth::factory('pjAdminBookings', 'pjActionDeleteBooking')->hasAccess() ? 'true' : 'false';?>;
pjGrid.hasDeleteMulti = <?php echo pjAuth::factory('pjAdminBookings', 'pjActionDeleteBookingBulk')->hasAccess() ? 'true' : 'false';?>;
pjGrid.hasExport = <?php echo pjAuth::factory('pjAdminBookings', 'pjActionExportBooking')->hasAccess() ? 'true' : 'false';?>;
pjGrid.hasPrint = <?php echo pjAuth::factory('pjAdminBookings', 'pjActionPrint')->hasAccess() ? 'true' : 'false';?>;
var myLabel = myLabel || {};
myLabel.client = <?php x__encode('lblClient'); ?>;
myLabel.transfer_date_time = <?php x__encode('lblTransferDateTime'); ?>;
myLabel.transfer_destinations = <?php x__encode('lblTransferDestinations'); ?>;
myLabel.email = <?php x__encode('email'); ?>;
myLabel.status = <?php x__encode('lblStatus'); ?>;
myLabel.exported = <?php x__encode('lblExport'); ?>;
myLabel.print = <?php x__encode('lblPrint'); ?>;
myLabel.delete_selected = <?php x__encode('delete_selected'); ?>;
myLabel.delete_confirmation = <?php x__encode('delete_confirmation'); ?>;
myLabel.pending = "<?php echo $statuses['pending']; ?>";
myLabel.confirmed = "<?php echo $statuses['confirmed']; ?>";
myLabel.cancelled = "<?php echo $statuses['cancelled']; ?>";
</script>