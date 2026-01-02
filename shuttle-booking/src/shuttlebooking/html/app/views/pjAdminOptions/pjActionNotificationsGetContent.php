<?php
$titles = __('notifications_titles', true);
$sub_titles = __('notifications_subtitles', true);
$slug = sprintf("%s_%s_%s", $tpl['arr']['recipient'], $tpl['arr']['transport'], $tpl['arr']['variant']);
$is_ready = $tpl['arr']['transport'] != 'sms' || $tpl['is_sms_ready'];
$subject = $controller->_get->toString('variant') . '_subject_' . $controller->_get->toString('recipient');
$subject = str_replace('confirmation', 'confirm', $subject);
$message = $controller->_get->toString('variant') . '_tokens_' . $controller->_get->toString('recipient');
$message = str_replace('confirmation', 'confirm', $message);
?>
<form action="" method="post">
	<input type="hidden" name="id" value="<?php echo $tpl['arr']['id']; ?>">
	
	<div class="ibox float-e-margins settings-box">
		<div class="ibox-content ibox-heading">
			<h3><?php echo pjSanitize::html(@$titles[$slug]); ?></h3>
			<small><?php echo pjSanitize::html(@$sub_titles[$slug]); ?></small>
		</div>
		
		<div class="ibox-content">
			<div class="form-group">
				<label class="control-label"><?php __('notifications_is_active'); ?></label>
				<div class="row">
					<div class="col-lg-2 col-md-3">
						<div class="switch onoffswitch-data">
							<div class="onoffswitch">
								<input type="checkbox" class="onoffswitch-checkbox" id="is_active" name="is_active"<?php echo $tpl['arr']['is_active'] ? ' checked' : NULL; ?><?php echo $tpl['arr']['transport'] == 'sms' && !$tpl['is_sms_ready'] ? ' disabled' : NULL; ?>>
								<label class="onoffswitch-label" for="is_active">
									<span class="onoffswitch-inner" data-on="<?php __('lblYes', false, true); ?>" data-off="<?php __('lblNo', false, true); ?>"></span>
									<span class="onoffswitch-switch"></span>
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			if ($tpl['arr']['transport'] == 'email')
			{
				?>
				<div class="notification-area<?php echo $tpl['arr']['is_active'] && $is_ready ? NULL : ' hidden'; ?>">
					<div class="form-group">
						<label class="control-label"><?php __('notifications_subject'); ?></label>
						<?php
						foreach ($tpl['lp_arr'] as $v)
						{
							?>
							<div class="<?php echo $tpl['is_flag_ready'] ? 'input-group ' : NULL;?>pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
								<input type="text" name="i18n[<?php echo $v['id']; ?>][<?php echo $subject; ?>]" class="form-control" value="<?php echo pjSanitize::html(@$tpl['arr']['i18n'][$v['id']][$subject]); ?>">
								<?php if ($tpl['is_flag_ready']) : ?>
								<span class="input-group-addon pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="<?php echo pjSanitize::html($v['name']); ?>"></span>
								<?php endif; ?>
							</div>
							<?php
						}
						?>
					</div>
			
					<div class="form-group">
						<label class="control-label"><?php __('notifications_message'); ?></label>
						<?php
						foreach ($tpl['lp_arr'] as $v)
						{
							?>
							<div class="<?php echo $tpl['is_flag_ready'] ? 'input-group ' : NULL;?>pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
								<textarea name="i18n[<?php echo $v['id']; ?>][<?php echo $message; ?>]" class="form-control mceEditor"><?php echo htmlspecialchars(stripslashes(@$tpl['arr']['i18n'][$v['id']][$message])); ?></textarea>
								<?php if ($tpl['is_flag_ready']) : ?>
								<span class="input-group-addon pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="<?php echo pjSanitize::html($v['name']); ?>"></span>
								<?php endif; ?>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<?php 
			} else {
				$message = $controller->_get->toString('variant') . '_sms_' . $controller->_get->toString('recipient');
				$message = str_replace('confirmation', 'confirm', $message);
				?>
				<div class="notification-area<?php echo $tpl['arr']['is_active'] && $is_ready ? NULL : ' hidden'; ?>">
					<div class="form-group">
						<label class="control-label"><?php __('notifications_message'); ?></label>
						<?php
						foreach ($tpl['lp_arr'] as $v)
						{
							?>
							<div class="<?php echo $tpl['is_flag_ready'] ? 'input-group ' : NULL;?>pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
								<textarea name="i18n[<?php echo $v['id']; ?>][<?php echo $message; ?>]" class="form-control" rows="10"><?php echo htmlspecialchars(stripslashes(@$tpl['arr']['i18n'][$v['id']][$message])); ?></textarea>
								<?php if ($tpl['is_flag_ready']) : ?>
								<span class="input-group-addon pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="<?php echo pjSanitize::html($v['name']); ?>"></span>
								<?php endif; ?>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<?php 
			}
			?>
			<?php if ($tpl['arr']['transport'] == 'sms' && !$tpl['is_sms_ready']) { ?>
				<p class="alert alert-warning alert-with-icon no-margins"><i class="fa fa-warning m-r-xs"></i><?php __('plugin_base_sms_warning') ?></p>
			<?php } ?>
			<div class="notification-area<?php echo $tpl['arr']['is_active'] && $is_ready ? NULL : ' hidden'; ?>">
				<div class="hr-line-dashed"></div>
				
				<div class="clearfix">
                    <button type="submit" class="ladda-button btn btn-primary btn-lg pull-left btn-phpjabbers-loader" data-style="zoom-in">
                        <span class="ladda-label"><?php __('plugin_base_btn_save'); ?></span>
                        <?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
                    </button>
                </div>
			</div>
		</div>
	</div>
</form>