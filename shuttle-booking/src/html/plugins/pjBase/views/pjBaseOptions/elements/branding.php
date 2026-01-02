<div class="form-group<?php echo $rowClass; ?>">
	<label class="col-lg-3 col-md-4 control-label"><?php __('plugin_base_opt_' . $tpl['arr'][$i]['key']); ?></label>
	<div class="col-sm-9 col-md-8">
		<?php
		switch ($tpl['arr'][$i]['type'])
		{
			case 'string':
				?><input type="text" name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="form-control" value="<?php echo pjSanitize::html($tpl['arr'][$i]['value']); ?>"><?php
				break;
			case 'enum':
				if (in_array($tpl['arr'][$i]['key'], array('o_hide_phpjabbers_logo', 'o_hide_footer', 'o_hide_page')))
				{
					include dirname(__FILE__) . '/switch.php';

					if ($text = __('plugin_base_opt_' . $tpl['arr'][$i]['key'] . '_text', true))
					{
						?><p class="alert alert-warning m-t-xs alert-with-icon"> <i class="fa fa-warning"></i> <?php echo str_replace('{URL}', '<br>'.PJ_INSTALL_URL.'index.php?controller=pjBaseOptions&action=pjActionVisual', $text); ?></p><?php
					}
				}
				break;
		}
		?>
	</div>
</div>