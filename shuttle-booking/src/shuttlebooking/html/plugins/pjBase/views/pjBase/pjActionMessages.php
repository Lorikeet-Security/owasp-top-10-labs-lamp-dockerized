if (jQuery_1_8_2.multilang !== undefined) {
	jQuery_1_8_2.extend(jQuery_1_8_2.multilang.messages, {
		tooltip: "<?php __('multilangTooltip', false, true); ?>"
	});
}
<?php
$months = __('months', true);
$days = __('days', true);
?>
if (jQuery_1_8_2.datagrid !== undefined) {
	jQuery_1_8_2.extend(jQuery_1_8_2.datagrid.messages, {
		empty_result: "<?php __('plugin_base_grid_empty_result'); ?>",
		choose_action: "<?php __('plugin_base_grid_choose_action'); ?>",
		goto_page: "<?php __('plugin_base_grid_go_to_page'); ?>",
		total_prefix: "<?php __('plugin_base_grid_total_prefix'); ?>",
		total_suffix: "<?php __('plugin_base_grid_total_suffix'); ?>",
		show: "<?php __('plugin_base_grid_show'); ?>",
		total_items: "<?php __('plugin_base_grid_total_items'); ?>",
		items_per_page: "<?php __('plugin_base_grid_items_per_page'); ?>",
		prev_page: "<?php __('plugin_base_grid_prev_page'); ?>",
		prev: "<?php __('plugin_base_grid_prev'); ?>",
		next_page: "<?php __('plugin_base_grid_next_page'); ?>",
		next: "<?php __('plugin_base_grid_next'); ?>",
		month_names: ['<?php echo $months[1]; ?>', '<?php echo $months[2]; ?>', '<?php echo $months[3]; ?>', '<?php echo $months[4]; ?>', '<?php echo $months[5]; ?>', '<?php echo $months[6]; ?>', '<?php echo $months[7]; ?>', '<?php echo $months[8]; ?>', '<?php echo $months[9]; ?>', '<?php echo $months[10]; ?>', '<?php echo $months[11]; ?>', '<?php echo $months[12]; ?>'],
		day_names: ['<?php echo $days[1]; ?>', '<?php echo $days[2]; ?>', '<?php echo $days[3]; ?>', '<?php echo $days[4]; ?>', '<?php echo $days[5]; ?>', '<?php echo $days[6]; ?>', '<?php echo $days[0]; ?>'],
		action_empty_title: "<?php __('plugin_base_grid_action_empty_title'); ?>",
		action_empty_body: "<?php __('plugin_base_grid_action_empty_body'); ?>",
		delete_title: "<?php __('plugin_base_grid_delete_confirmation'); ?>",
		delete_text: "<?php __('plugin_base_grid_confirmation_title'); ?>",
		action_title: "<?php __('plugin_base_grid_action_title'); ?>",
		btn_ok: "<?php __('plugin_base_grid_btn_ok'); ?>",
		btn_cancel: "<?php __('plugin_base_grid_btn_cancel'); ?>",
		btn_delete: "<?php __('plugin_base_grid_btn_delete'); ?>",
		empty_date: "<?php __('plugin_base_grid_empty_date'); ?>",
		invalid_date: "<?php __('plugin_base_grid_invalid_date'); ?>"
	});
}