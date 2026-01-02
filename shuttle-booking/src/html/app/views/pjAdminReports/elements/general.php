<?php
$reservations = $tpl['general_report']['reservations'];
$passengers = $tpl['general_report']['passengers'];
$luggage = $tpl['general_report']['luggage'];
$amount = $tpl['general_report']['amount'];
$one_way = $tpl['general_report']['one_way'];
$round_trip = $tpl['general_report']['round_trip'];
$per_arr = $tpl['general_report']['per_arr'];

if($_GET['action'] == 'pjActionIndex')
{
	?>
	<p class="block b15">
		<label class="tr-content fs13 bold"><?php __('lblGeneralReservationsReport')?></label>
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
	<label class="tr-content bold"><?php __('lblPassengersPer')?></label>
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
		for($k = 1; $k <= 11; $k++)
		{
			$passengers = '';
			if($k < 11)
			{
				if($k == 1)
				{
					$passengers = $k . ' ' . strtolower(__('lblPassenger',true, false));
				}else{
					$passengers = $k . ' ' . strtolower(__('lblPassengers',true, false));
				}
			}else{
				$passengers = '10+ ' . strtolower(__('lblPassengers',true, false));
			}
			?>
			<tr>
				<td><?php echo $passengers; ?></td>
				<td><?php echo isset($per_arr[$k]['reservations']) ? $per_arr[$k]['reservations'] : 0;?></td>
				<td><?php echo isset($per_arr[$k]['percentage1']) ? $per_arr[$k]['percentage1'] : 0.00;?>%</td>
				<td><?php echo pjUtil::formatCurrencySign(number_format((isset($per_arr[$k]['amount']) ? $per_arr[$k]['amount'] : 0), 2), $tpl['option_arr']['o_currency']);?></td>
				<td><?php echo isset($per_arr[$k]['percentage2']) ? $per_arr[$k]['percentage2'] : 0.00;?>%</td>
			</tr>
			<?php
		} 
		?>
	</tbody>
</table>
<?php
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