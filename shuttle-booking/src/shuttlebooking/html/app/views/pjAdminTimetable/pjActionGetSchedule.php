<?php
if(isset($tpl['line_detail_arr']))
{ 
	?>
	<table class="pj-table" cellpadding="0" cellspacing="0" style="width: 100%">
		<thead>
			<tr>
				<th style="width: 250px;">&nbsp;</th>
				<th style="width: 190px;"><?php $_GET['direction'] == 'arriving' ? __('lblPickupTime') : __('lblDropoffTime'); ?></th>
				<th style="width: 190px;"><?php __('lblPrice'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$time_ts = strtotime($_GET['time']);
			foreach($tpl['line_detail_arr'] as $v)
			{
				if($_GET['direction'] == 'arriving')
				{
					$price = pjUtil::formatCurrencySign(pjUtil::convertToCurrencyFormat($v['price_pickup'], $tpl['option_arr']), $tpl['option_arr']['o_currency']);
					$duration_ts = (int) $v['duration_pickup'] * 60;
					$time_format = date( $tpl['option_arr']['o_time_format'], ($time_ts - $duration_ts));
				}else{
					$price = pjUtil::formatCurrencySign(pjUtil::convertToCurrencyFormat($v['price_dropoff'], $tpl['option_arr']), $tpl['option_arr']['o_currency']);
					$duration_ts = (int) $v['duration_dropoff'] * 60;
					$time_format = date( $tpl['option_arr']['o_time_format'], ($time_ts + $duration_ts));
				}
				?>
				<tr>
					<td><?php echo pjSanitize::html($v['title']);?></td>
					<td><?php echo $time_format;?></td>
					<td><?php echo $price;?></td>
				</tr>
				<?php
			} 
			?>
		</tbody>
	</table>
	<?php
} 
?>