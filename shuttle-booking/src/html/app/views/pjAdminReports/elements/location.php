<?php
$reservations = $tpl['location_report']['reservations'];
$passengers = $tpl['location_report']['passengers'];
$luggage = $tpl['location_report']['luggage'];
$amount = $tpl['location_report']['amount'];
$one_way = $tpl['location_report']['one_way'];
$round_trip = $tpl['location_report']['round_trip'];
$dest_arr = $tpl['location_report']['dest_arr'];
$vehicle_arr = $tpl['location_report']['vehicle_arr']; 

$dropoff_arr = $tpl['location_report']['dropoff_arr'];
$table_fleet_arr = $tpl['location_report']['table_fleet_arr'];

if($_GET['action'] == 'pjActionIndex')
{
	?>
	<p class="block b15">
		<label class="tr-content fs13 bold"><?php __('lblReportPickupLocation')?></label>
	</p>
	<?php
} 
?>
<table cellpadding="0" cellspacing="0" border="0" class="table b20">
	<tbody>
		<tr>
			<td style="width: 150px;">&nbsp;</td>
			<td><?php __('lblReservations');?></td>
			<td><?php __('lblPassengersServed');?></td>
			<td><?php __('lblLuggageCaried');?></td>
			<td><?php __('lblTotalAmount');?></td>
		</tr>
		<tr>
			<td><?php __('lblTotalReservations');?></td>
			<td class="center"><?php echo $reservations['total'];?></td>
			<td class="center"><?php echo $passengers['total'];?></td>
			<td class="center"><?php echo $luggage['total'];?></td>
			<td><?php echo pjUtil::formatCurrencySign(number_format($amount['total'], 2), $tpl['option_arr']['o_currency']);?></td>
		</tr>
		<tr>
			<td><?php __('lblConfirmedReservations');?></td>
			<td class="center"><?php echo $reservations['confirmed'];?></td>
			<td class="center"><?php echo $passengers['confirmed'];?></td>
			<td class="center"><?php echo $luggage['confirmed'];?></td>
			<td><?php echo pjUtil::formatCurrencySign(number_format($amount['confirmed'], 2), $tpl['option_arr']['o_currency']);?></td>
		</tr>
		<tr>
			<td><?php __('lblCancelledReservations');?></td>
			<td class="center"><?php echo $reservations['cancelled'];?></td>
			<td class="center"><?php echo $passengers['cancelled'];?></td>
			<td class="center"><?php echo $luggage['cancelled'];?></td>
			<td><?php echo pjUtil::formatCurrencySign(number_format($amount['cancelled'], 2), $tpl['option_arr']['o_currency']);?></td>
		</tr>
	</tbody>
</table>

<p>
	<label class="tr-content bold"><?php __('lblOneWayRoundTrip')?></label>
</p>
<table cellpadding="0" cellspacing="0" border="0" class="table b20">
	<tbody>
		<tr>
			<td style="width: 150px;">&nbsp;</td>
			<td><?php __('lblReservations');?></td>
			<td class="center" style="width: 80px;">%</td>
			<td><?php __('lblTotalAmount');?></td>
			<td class="center" style="width: 80px;">%</td>
		</tr>
		<tr>
			<td><?php __('lblOneWayReservations');?></td>
			<td class="center"><?php echo $one_way['reservations'];?></td>
			<td><?php echo $one_way['rerv_percentage'];?>%</td>
			<td><?php echo pjUtil::formatCurrencySign(number_format($one_way['amount'], 2), $tpl['option_arr']['o_currency']);?></td>
			<td><?php echo $one_way['amount_percentage'];?>%</td>
		</tr>
		<tr>
			<td><?php __('lblRoundTripReservations');?></td>
			<td class="center"><?php echo $round_trip['reservations'];?></td>
			<td><?php echo $round_trip['rerv_percentage'];?>%</td>
			<td><?php echo pjUtil::formatCurrencySign(number_format($round_trip['amount'], 2), $tpl['option_arr']['o_currency']);?></td>
			<td><?php echo $round_trip['amount_percentage'];?>%</td>
		</tr>
	</tbody>
</table>

<p>
	<label class="tr-content bold"><?php __('lblDestinationTrips')?></label>
</p>
<table cellpadding="0" cellspacing="0" border="0" class="table b20">
	<tbody>
		<tr>
			<td style="width: 150px;">&nbsp;</td>
			<td><?php __('lblReservations');?></td>
			<td class="center" style="width: 80px;">%</td>
			<td><?php __('lblTotalAmount');?></td>
			<td class="center" style="width: 80px;">%</td>
		</tr>
		<?php
		foreach($dropoff_arr as $k => $v)
		{ 
			?>
			<tr>
				<td><?php echo $v['dropoff_location'];?></td>
				<td><?php echo isset($dest_arr[$v['id']]['reservations']) ? $dest_arr[$v['id']]['reservations'] : 0;?></td>
				<td><?php echo isset($dest_arr[$v['id']]['percentage1']) ? $dest_arr[$v['id']]['percentage1'] : 0.00;?>%</td>
				<td><?php echo pjUtil::formatCurrencySign(number_format((isset($dest_arr[$v['id']]['amount']) ? $dest_arr[$v['id']]['amount'] : 0), 2), $tpl['option_arr']['o_currency']);?></td>
				<td><?php echo isset($dest_arr[$v['id']]['percentage2']) ? $dest_arr[$v['id']]['percentage2'] : 0.00;?>%</td>
			</tr>
			<?php
		} 
		?>
	</tbody>
</table>

<p>
	<label class="tr-content bold"><?php __('lblVehicleUsed')?></label>
</p>
<?php
foreach($table_fleet_arr as $fleet_arr)
{ 
	?>
	<table cellpadding="0" cellspacing="0" border="0" class="table b20">
		<tbody>
			<tr>
				<td style="width: 150px;">&nbsp;</td>
				<?php
				foreach($fleet_arr as $k => $v)
				{
					?><td><?php echo $v['fleet']?></td><?php
				} 
				?>
			</tr>
			<?php
			$total = array();
			foreach($dropoff_arr as $v)
			{ 
				?>
				<tr>
					<td><?php echo $v['dropoff_location']?></td>
					<?php
					foreach($fleet_arr as $k => $fleet)
					{
						?><td class="center"><?php echo isset($vehicle_arr[$v['id']][$fleet['id']]) ? $vehicle_arr[$v['id']][$fleet['id']] : 0;?></td><?php
						if(isset($total[$fleet['id']]))
						{
							$total[$fleet['id']] += isset($vehicle_arr[$v['id']][$fleet['id']]) ? $vehicle_arr[$v['id']][$fleet['id']] : 0;
						}else{
							$total[$fleet['id']] = isset($vehicle_arr[$v['id']][$fleet['id']]) ? $vehicle_arr[$v['id']][$fleet['id']] : 0;
						} 
					} 
					?>
				</tr>
				<?php
			} 
			?>
			<tr>
				<td><?php __('lblTotal');?></td>
				<?php
				foreach($fleet_arr as $fleet)
				{
					?><td class="center"><?php echo $total[$fleet['id']]; ?></td><?php
				} 
				?>
			</tr>
		</tbody>
	</table>
	<?php
}
if (isset($_POST['generate_report']))
{ 
	?>
	<form target="_blank" action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminReports&amp;action=pjActionPrint" method="post" class="form pj-form" id="frmPrintReport">
		<input type="hidden" name="date_from" value="<?php echo !empty($_POST['date_from']) ? $_POST['date_from'] : NULL;?>"/>
		<input type="hidden" name="date_to" value="<?php echo !empty($_POST['date_to']) ? $_POST['date_to'] : NULL;?>"/>
		<input type="hidden" name="location_id" value="<?php echo !empty($_POST['location_id']) ? $_POST['location_id'] : NULL;?>"/>
		<input type="hidden" name="fleet_id" value="<?php echo !empty($_POST['fleet_id']) ? $_POST['fleet_id'] : NULL;?>"/>
		<input type="submit" value="<?php __('lblPrint', false, true); ?>" class="pj-button" />
	</form>
	<?php
} 
?>