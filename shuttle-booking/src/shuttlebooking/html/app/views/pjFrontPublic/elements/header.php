<div class="pjSbs-head">
	<div class="row">
		<div class="col-sm-4 col-xs-8">
			<select class="form-control pjSbsMenu">
				<?php
				$action = $controller->_get->toString('action');
				switch ($action) {
					case 'pjActionSearch':
						?>
						<option value="loadSearch" selected="selected"><?php __('front_choose_airport');?></option>
						<option value="loadLines" disabled="disabled"><?php __('front_select_vehicle_type');?></option>
						<option value="loadCheckout" disabled="disabled"><?php __('front_checkout');?></option>
						<option value="loadPreview" disabled="disabled"><?php __('front_preview');?></option>
						<?php
					break;
					case 'pjActionLines':
						?>
						<option value="loadSearch"><?php __('front_choose_airport');?></option>
						<option value="loadLines" selected="selected"><?php __('front_select_vehicle_type');?></option>
						<option value="loadCheckout" disabled="disabled"><?php __('front_checkout');?></option>
						<option value="loadPreview" disabled="disabled"><?php __('front_preview');?></option>
						<?php
					break;
					
					case 'pjActionCheckout':
						?>
						<option value="loadSearch"><?php __('front_choose_airport');?></option>
						<option value="loadLines"><?php __('front_select_vehicle_type');?></option>
						<option value="loadCheckout" selected="selected"><?php __('front_checkout');?></option>
						<option value="loadPreview" disabled="disabled"><?php __('front_preview');?></option>
						<?php
					break;
					case 'pjActionPreview':
					case 'pjActionGetPaymentForm':
						?>
						<option value="loadSearch"><?php __('front_choose_airport');?></option>
						<option value="loadLines"><?php __('front_select_vehicle_type');?></option>
						<option value="loadCheckout"><?php __('front_checkout');?></option>
						<option value="loadPreview" selected="selected"><?php __('front_preview');?></option>
						<?php
					break;
				} 
				?>
			</select>
		</div>
		<?php if ((!$controller->_get->check('hide') || $controller->_get->toInt('hide') === 0) && isset($tpl['locale_arr']) && is_array($tpl['locale_arr']) && count($tpl['locale_arr']) > 1) : ?>
		<?php
		$selected_title = null;
		$selected_src = NULL;
		foreach ($tpl['locale_arr'] as $locale)
		{
			if ($controller->getLocaleId() == $locale['id'])
			{
				$selected_title = $locale['language_iso'];
				$lang_iso = explode("-", $selected_title);
				if(isset($lang_iso[1]))
				{
					$selected_title = $lang_iso[1];
				}
				if (!empty($locale['flag']) && is_file(PJ_INSTALL_PATH . $locale['flag']))
				{
					$selected_src = PJ_INSTALL_URL . $locale['flag'];
				} elseif (!empty($locale['file']) && is_file(PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $locale['file'])) {
					$selected_src = PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $locale['file'];
				}
				break;
			}
		}
		?>
		<div class="col-sm-4 col-xs-4 pull-right">
			<div class="btn-group pull-right">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<img src="<?php echo $selected_src; ?>" alt="">
					<?php echo $selected_title; ?>
					<span class="caret"></span>
				</button>

				<ul class="dropdown-menu">
					<?php
					foreach ($tpl['locale_arr'] as $locale)
					{
						$selected_src = NULL;
						if (!empty($locale['flag']) && is_file(PJ_INSTALL_PATH . $locale['flag']))
						{
							$selected_src = PJ_INSTALL_URL . $locale['flag'];
						} elseif (!empty($locale['file']) && is_file(PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $locale['file'])) {
							$selected_src = PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $locale['file'];
						}
						?>
						<li<?php echo $controller->getLocaleId() == $locale['id'] ? ' active' : NULL; ?>>
							<a href="#" class="pjSbsLocale" data-id="<?php echo $locale['id']; ?>" data-dir="<?php echo $locale['dir']; ?>">
								<img src="<?php echo $selected_src; ?>" alt="">
								<?php echo pjSanitize::html($locale['name']); ?>
							</a>
						</li>
						<?php
					}
					?>
				</ul>
			</div>
		</div><!-- /.col-sm-4 -->
		<?php endif;?>
	</div><!-- /.row -->
</div><!-- /.pjSbs-head -->