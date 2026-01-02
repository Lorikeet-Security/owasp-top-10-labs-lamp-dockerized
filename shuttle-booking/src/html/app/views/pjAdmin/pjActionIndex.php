<div class="wrapper wrapper-content animated fadeInRight">
	<div class="ibox float-e-margins">
		<div class="ibox-title">
			<h5><?php __('dash_today');?></h5>
		</div>
		<div class="ibox-content">
			<div class="row">
				<div class="col-xs-6">
					<p class="h1 no-margins"><?php echo $tpl['cnt_new_reservations'];?></p>
					<small class="text-info"><?php $tpl['cnt_new_reservations'] != 1 ? __('lblNewReservationsToday') : __('lblNewReservationToday');?></small>        
				</div><!-- /.col-xs-6 -->
	
				<div class="col-xs-6">
					<p class="h1 no-margins"><?php echo $tpl['cnt_today_transfers'];?></p>
					<small class="text-info"><?php $tpl['cnt_today_transfers'] != 1 ? __('lblTransfersToday') : __('lblTransferToday');?></small>        
				</div><!-- /.col-xs-6 -->
			</div><!-- /.row -->
		</div>
	</div><!-- /.row -->
	
	<?php $statuses = __('booking_statuses', true, false);?>
	<div class="row">
		<div class="col-lg-6">
			<div class="ibox float-e-margins">
				<div class="ibox-content ibox-heading clearfix">
					<div class="pull-left">
						<h3><?php __('lblLatestReservations');?></h3>
					</div><!-- /.pull-left -->

					<div class="pull-right">
						<?php
						if(pjAuth::factory('pjAdminBookings', 'pjActionIndex')->hasAccess())
						{
    						?>
    						<a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionIndex" class="btn btn-primary btn-sm btn-outline m-n"><?php __('lblDashViewAll');?></a>
    						<?php
						}
    					?>
					</div><!-- /.pull-right -->
				</div>

				<div class="ibox-content inspinia-timeline">
					<?php if (count($tpl['latest_arr']) > 0) { ?>
						<?php foreach ($tpl['latest_arr'] as $k => $v) { ?>
						<div class="timeline-item">
							<div class="row">
								<div class="col-xs-12">
									<a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionUpdate&amp;id=<?php echo $v['id']; ?>">
										<p class="m-b-xs"><span><?php __('lblID')?>: </span><strong><?php echo pjSanitize::html($v['uuid']);?></strong></p>
										<p class="m-n"><em><span><?php __('lblCustomer')?>: </span><?php echo pjSanitize::html($v['name']);?></em></p>
										
										<p class="m-n">
											<span><?php __('lblPickup')?>: </span><?php echo date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], strtotime($v['booking_date'] . ', ' . $v['booking_time']));?>
											&nbsp;&nbsp;|&nbsp;&nbsp;
											<span><?php __('lblDuration')?>: </span><?php echo $v['traveling'] == 'from' ? (int) $v['duration_dropoff'] : (int) $v['duration_pickup'];?> <?php echo strtolower(__('lblMinutes',true, false));?>
										</p>
										
										<?php
        								if($v['has_return'] == 'T')
        								{ 
        									?>
        									<p class="m-n">
        										<span><?php __('lblReturn')?>: </span><?php echo date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], strtotime($v['return_date'] . ', ' . $v['return_time']));?>
        										&nbsp;&nbsp;|&nbsp;&nbsp;
        										<span><?php __('lblDuration')?>: </span><?php echo $v['traveling'] == 'from' ? (int) $v['duration_pickup'] : (int) $v['duration_droppoff'];?> <?php echo strtolower(__('lblMinutes',true, false));?>
        									</p>
        									<?php
        								}
        								if($v['traveling'] == 'from')
        								{ 
        									?>
        									<p class="m-n"><span><?php __('lblFrom')?>: </span><?php echo $v['from_location'];?></p>
        									<p class="m-n"><span><?php __('lblTo')?>: </span><?php echo $v['to_location'];?></p>
        									<?php
        								}else{
        									?>
        									<p class="m-n"><span><?php __('lblFrom')?>: </span><?php echo $v['to_location'];?></p>
        									<p class="m-n"><span><?php __('lblTo')?>: </span><?php echo $v['from_location'];?></p>
        									<?php
        								} 
        								?>
        								<p class="m-n"><em><span><?php __('lblLine')?>: </span><?php echo pjSanitize::html($v['line']);?></em></p>
										<?php
        								if($v['has_return'] == 'T')
        								{ 
        									?><p class="m-n"><em><span><?php __('lblReturnLine')?>: </span><?php echo $v['return_line'];?></em></p><?php
        								} 
        								?>
									</a>
								</div>
							</div>
						</div>
						<?php } ?>
					<?php } else { ?>
						<p><?php __('lblReservationsNotFound');?></p>
					<?php } ?>
				</div>
			</div>
		</div><!-- /.col-lg-6 -->
		
		<div class="col-lg-6">
			<div class="ibox float-e-margins">
				<div class="ibox-content ibox-heading clearfix">
					<div class="pull-left">
						<h3><?php __('lblTransfersToday');?></h3>
					</div><!-- /.pull-left -->

					<div class="pull-right">
						<?php
						if(pjAuth::factory('pjAdminBookings', 'pjActionIndex')->hasAccess())
						{
    						?>
    						<a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionIndex&amp;date=<?php echo pjDateTime::formatDate(date('Y-m-d'), 'Y-m-d', $tpl['option_arr']['o_date_format']);?>" class="btn btn-primary btn-sm btn-outline m-n"><?php __('lblDashViewAll');?></a>
    						<?php
						}
						if(pjAuth::factory('pjAdminBookings', 'pjActionPrint')->hasAccess())
						{
						    ?>
    						<a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionPrint&amp;today=yes"target="_blank" class="btn btn-primary btn-sm btn-outline m-n"><?php __('lblPrint');?></a>
    						<?php
						}
    					?>
					</div><!-- /.pull-right -->
				</div>

				<div class="ibox-content inspinia-timeline">
					<?php if (count($tpl['today_arr']) > 0) { ?>
						<?php foreach ($tpl['today_arr'] as $k => $v) { ?>
						<div class="timeline-item">
							<div class="row">
								<div class="col-xs-12">
									<a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionUpdate&amp;id=<?php echo $v['id']; ?>">
										<p class="m-b-xs"><span><?php __('lblID')?>: </span><strong><?php echo pjSanitize::html($v['uuid']);?></strong></p>
										<p class="m-n"><em><span><?php __('lblCustomer')?>: </span><?php echo pjSanitize::html($v['name']);?></em></p>
										
										<p class="m-n">
											<span><?php __('lblPickup')?>: </span><?php echo date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], strtotime($v['booking_date'] . ', ' . $v['booking_time']));?>
											&nbsp;&nbsp;|&nbsp;&nbsp;
											<span><?php __('lblDuration')?>: </span><?php echo $v['traveling'] == 'from' ? (int) $v['duration_dropoff'] : (int) $v['duration_pickup'];?> <?php echo strtolower(__('lblMinutes',true, false));?>
										</p>
										
										<?php
        								if($v['has_return'] == 'T')
        								{ 
        									?>
        									<p class="m-n">
        										<span><?php __('lblReturn')?>: </span><?php echo date($tpl['option_arr']['o_date_format'] . ', ' . $tpl['option_arr']['o_time_format'], strtotime($v['return_date'] . ', ' . $v['return_time']));?>
        										&nbsp;&nbsp;|&nbsp;&nbsp;
        										<span><?php __('lblDuration')?>: </span><?php echo $v['traveling'] == 'from' ? (int) $v['duration_pickup'] : (int) $v['duration_droppoff'];?> <?php echo strtolower(__('lblMinutes',true, false));?>
        									</p>
        									<?php
        								}
        								if($v['traveling'] == 'from')
        								{ 
        									?>
        									<p class="m-n"><span><?php __('lblFrom')?>: </span><?php echo $v['from_location'];?></p>
        									<p class="m-n"><span><?php __('lblTo')?>: </span><?php echo $v['to_location'];?></p>
        									<?php
        								}else{
        									?>
        									<p class="m-n"><span><?php __('lblFrom')?>: </span><?php echo $v['to_location'];?></p>
        									<p class="m-n"><span><?php __('lblTo')?>: </span><?php echo $v['from_location'];?></p>
        									<?php
        								} 
        								?>
        								<p class="m-n"><em><span><?php __('lblLine')?>: </span><?php echo pjSanitize::html($v['line']);?></em></p>
										<?php
        								if($v['has_return'] == 'T')
        								{ 
        									?><p class="m-n"><em><span><?php __('lblReturnLine')?>: </span><?php echo $v['return_line'];?></em></p><?php
        								} 
        								?>
									</a>
								</div>
							</div>
						</div>
						<?php } ?>
					<?php } else { ?>
						<p><?php __('lblReservationsNotFound');?></p>
					<?php } ?>
				</div>
			</div>
		</div><!-- /.col-lg-6 -->
	</div><!-- /.row -->
</div><!-- /.wrapper wrapper-content animated fadeInRight -->