<div class="m-b-sm">
	<div class="row">
		<div class="col-lg-4 col-md-9 col-sm-8">
			<h3><?php 
			if ($tpl['query']['recipient'] == 'client')
			{
				__('notifications_msg_to_client');
			} elseif ($tpl['query']['recipient'] == 'admin') {
				__('notifications_msg_to_admin');
			} else {
				__('notifications_msg_to_default');
			}
			?></h3>
		</div>

		<div class="col-lg-4 col-md-3 col-sm-4">
			<h3 class="hidden-xs"><?php __('notifications_status'); ?></h3>
		</div>
	</div>
</div>
<?php 
$titles = __('notifications', true);
foreach ($tpl['arr'] as $k => $item)
{
	$slug = sprintf("%s_%s_%s", $item['recipient'], $item['transport'], $item['variant']);
	?>
	<div class="row">
		<div class="col-lg-4 col-md-9 col-sm-8">
			<div class="form-group">
				<div class="radio radio-primary m-n">
					<input type="radio" id="variant_<?php echo $item['transport']; ?>_<?php echo $item['variant']; ?>" value="<?php echo $item['variant']; ?>" 
						name="variant" data-transport="<?php echo $item['transport']; ?>"<?php echo (!isset($tpl['query']['transport'], $tpl['query']['variant']) && !$k) || (isset($tpl['query']['transport'], $tpl['query']['variant']) && $tpl['query']['transport'] == $item['transport'] && $tpl['query']['variant'] == $item['variant']) ? ' checked' : NULL; ?>>
					<label for="variant_<?php echo $item['transport']; ?>_<?php echo $item['variant']; ?>"><?php echo pjSanitize::html(@$titles[$slug]); ?></label>
				</div>
			</div>
		</div>
	
		<div class="col-lg-4 col-md-3 col-sm-4">
			<div class="form-group">
			<?php 
			if ($item['is_active'])
			{
				?><span class="label label-success label-outline"><i class="fa fa-check"></i> <?php __('notifications_send'); ?></span><?php
			} else {
				?><span class="label label-danger label-outline"><i class="fa fa-times"></i> <?php __('notifications_do_not_send'); ?></span><?php
			}
			?>
			</div>
		</div>
	</div>
	<?php 
}
?>