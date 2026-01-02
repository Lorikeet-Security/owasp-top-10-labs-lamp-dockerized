<?php
switch ($tpl['type']) {
	case 'general':
		?>
		<p class="b10">
			<label class="tr-content bold fs13"><?php __('lblGeneralReservationsReport')?></label>
		</p>
		<?php
		if(isset($_POST['date_from']))
		{
			?>
			<p class="b10">
				<label class="tr-content bold"><?php __('lblDateFrom')?>: <?php echo $_POST['date_from'];?></label>
			</p>
			<?php
		}
		if(isset($_POST['date_to']))
		{ 
			?>
			<p class="b20">	
				<label class="tr-content bold"><?php __('lblDateTo')?>: <?php echo $_POST['date_to'];?></label>
			</p>
			<?php
		}
	;
	break;
	case 'location':
		?>
		<p class="b10">
			<label class="tr-content bold fs13"><?php __('lblReportPickupLocation')?></label>
		</p>
		<?php
		if(isset($_POST['date_from']))
		{
			?>
			<p class="b10">
				<label class="tr-content bold"><?php __('lblDateFrom')?>: <?php echo $_POST['date_from'];?></label>
			</p>
			<?php
		}
		if(isset($_POST['date_to']))
		{ 
			?>
			<p class="b10">	
				<label class="tr-content bold"><?php __('lblDateTo')?>: <?php echo $_POST['date_to'];?></label>
			</p>
			<?php
		} 
		?>
		<p class="b20">	
			<label class="tr-content bold b10"><?php __('lblPickupLocation')?>: <?php echo $tpl['location_report']['location']['pickup_location'];?></label>
		</p>
		<?php
	;
	break;
	case 'vehicle':
		?>
		<p class="b10">
			<label class="tr-content bold fs13"><?php __('lblReportVehicle')?></label>
		</p>
		<?php
		if(isset($_POST['date_from']))
		{
			?>
			<p class="b10">
				<label class="tr-content bold"><?php __('lblDateFrom')?>: <?php echo $_POST['date_from'];?></label>
			</p>
			<?php
		}
		if(isset($_POST['date_to']))
		{ 
			?>
			<p class="b10">	
				<label class="tr-content bold"><?php __('lblDateTo')?>: <?php echo $_POST['date_to'];?></label>
			</p>
			<?php
		} 
		?>
		<p class="b20">	
			<label class="tr-content bold b10"><?php __('lblVehicle')?>: <?php echo $tpl['vehicle_report']['fleet_arr']['fleet'];?></label>
		</p>
		<?php
	;
	break;
}
include_once PJ_VIEWS_PATH . 'pjAdminReports/elements/'.$tpl['type'].'.php';
?>