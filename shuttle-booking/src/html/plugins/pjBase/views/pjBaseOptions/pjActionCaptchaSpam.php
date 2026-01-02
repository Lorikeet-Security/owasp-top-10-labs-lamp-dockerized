<?php
$spam_protection_arr = array();
if (isset($GLOBALS['CONFIG'], $GLOBALS['CONFIG']["spam_protection"])
    && is_array($GLOBALS['CONFIG']["spam_protection"])
    && !empty($GLOBALS['CONFIG']["spam_protection"]))
{
    $spam_protection_arr = $GLOBALS['CONFIG']["spam_protection"];
}
$haveWords = @$spam_protection_arr['banned_words'];
$haveIps = @$spam_protection_arr['banned_ips'];
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-lg-9 col-md-8 col-sm-6">
				<h2><?php __('plugin_base_infobox_captcha_spam_title'); ?></h2>
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 btn-group-languages">
				<?php if ($tpl['is_flag_ready'] && $haveWords) : ?>
				<div class="multilang"></div>
				<?php endif; ?>	
			</div>
		</div>
		<p class="m-b-none"><i class="fa fa-info-circle"></i><?php __('plugin_base_infobox_captcha_spam_desc'); ?></p>
	</div>
	
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<?php
	$error_code = $controller->_get->toString('err');
	if (!empty($error_code))
	{
		$titles = __('plugin_base_error_titles', true);
		$bodies = __('plugin_base_error_bodies', true);
		switch (true)
		{
			case in_array($error_code, array('PBS05')):
				?>
				<div class="alert alert-success">
					<i class="fa fa-check m-r-xs"></i>
					<strong><?php echo @$titles[$error_code]; ?></strong>
					<?php echo @$bodies[$error_code]?>
				</div>
				<?php 
				break;
			case in_array($error_code, array('')):	
				?>
				<div class="alert alert-danger">
					<i class="fa fa-exclamation-triangle m-r-xs"></i>
					<strong><?php echo @$titles[$error_code]; ?></strong>
					<?php echo @$bodies[$error_code]?>
				</div>
				<?php
				break;
		}
	}
	
	if (!$tpl['has_access_captcha'] && !$tpl['has_access_spam'])
	{
		?>
		<h3 class="font-bold"><?php __('plugin_base_access_denied_title'); ?></h3>
		<div class="error-desc">
			<?php __('plugin_base_access_denied_desc'); ?>
		</div>
		<?php
	} elseif (isset($tpl['_arr'])) {
		?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseOptions&amp;action=pjActionOptionsUpdate" method="post" class="form-horizontal" id="frmCaptchaSpam">
			<input type="hidden" name="options_update" value="1" />
			<input type="hidden" name="next_action" value="pjActionCaptchaSpam" />
				
			<?php 
			if ($tpl['has_access_captcha'])
			{
				?>						
				<div class="row">
				
					<div class="col-sm-6">
						<div class="ibox float-e-margins">
							<div class="ibox-content ibox-heading">
								<h3><?php __('plugin_base_options_captcha_title_front'); ?></h3>
								<small><?php __('plugin_base_options_captcha_desc_front'); ?></small>
							</div>
					
							<div class="ibox-content">
								<div class="form-group">
									<label class="control-label col-md-4"><?php __('plugin_base_opt_o_captcha_type_front'); ?></label>
									<div class="col-md-4 col-sm-12">
									<?php
									$tpl['arr'][$i] = $tpl['_arr']['o_captcha_type_front'];
									include dirname(__FILE__) . '/elements/enum.php';
									?>
									</div>
								</div>
								
								<div class="form-group box-front-system<?php echo strpos($tpl['_arr']['o_captcha_type_front']['value'], '::system') === false ? ' hidden' : NULL; ?>">
									<label class="control-label col-md-4"><?php __('plugin_base_opt_o_captcha_background_front'); ?></label>
									<div class="col-md-4 col-sm-12">
									<?php
									$tpl['arr'][$i] = $tpl['_arr']['o_captcha_background_front'];
									include dirname(__FILE__) . '/elements/background.php';
									?>
									</div>
								</div>
								
								<div class="form-group box-front-system<?php echo strpos($tpl['_arr']['o_captcha_type_front']['value'], '::system') === false ? ' hidden' : NULL; ?>">
									<label class="control-label col-md-4"><?php __('plugin_base_opt_o_captcha_mode_front'); ?></label>
									<div class="col-md-4 col-sm-12">
									<?php
									$tpl['arr'][$i] = $tpl['_arr']['o_captcha_mode_front'];
									include dirname(__FILE__) . '/elements/enum.php';
									?>
									</div>
								</div>
								<?php
								$box_length_class = ' hidden';
								if($tpl['_arr']['o_captcha_type_front']['value'] == 'system|google::system' && $tpl['_arr']['o_captcha_mode_front']['value'] == 'string|addition|subtraction|random_math::string')
								{
								    $box_length_class = '';
								}
								?>
								<div class="form-group box-front-system box-front-length<?php echo $box_length_class; ?>">
									<label class="control-label col-md-4 col-sm-12 col-xs-12"><?php __('plugin_base_opt_o_captcha_length_front'); ?></label>
									<div class="col-md-3 col-sm-6 col-xs-6">
									<?php
									$tpl['arr'][$i] = $tpl['_arr']['o_captcha_length_front'];
									?>
										<input type="text" name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="form-control field-int" value="<?php echo pjSanitize::html($tpl['arr'][$i]['value']); ?>">
									</div>
									<div class="col-md-3 col-sm-6 col-xs-6">
										<p class="m-t-xs"><?php __('plugin_base_lbl_symbols');?></p>
									</div>
								</div>
								
								<div class="form-group box-front-google<?php echo strpos($tpl['_arr']['o_captcha_type_front']['value'], '::google') === false ? ' hidden' : NULL; ?>">
									<label class="control-label col-md-4"><?php __('plugin_base_opt_o_captcha_site_key_front'); ?></label>
									<div class="col-md-8 col-sm-12">
									<?php
									$tpl['arr'][$i] = $tpl['_arr']['o_captcha_site_key_front'];
									?>
										<input type="text" name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="form-control" value="<?php echo pjSanitize::html($tpl['arr'][$i]['value']); ?>">
									</div>
								</div>
								
								<div class="form-group box-front-google<?php echo strpos($tpl['_arr']['o_captcha_type_front']['value'], '::google') === false ? ' hidden' : NULL; ?>">
									<label class="control-label col-md-4"><?php __('plugin_base_opt_o_captcha_secret_key_front'); ?></label>
									<div class="col-md-8 col-sm-12">
									<?php
									$tpl['arr'][$i] = $tpl['_arr']['o_captcha_secret_key_front'];
									?>
										<input type="text" name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="form-control" value="<?php echo pjSanitize::html($tpl['arr'][$i]['value']); ?>">
									</div>
								</div>
								
								<div class="hr-line-dashed"></div>
								
								<div class="row">
									<div class="col-md-offset-4 col-md-8">
										<button type="submit" class="ladda-button btn btn-primary btn-lg pull-left btn-phpjabbers-loader" data-style="zoom-in">
											<span class="ladda-label"><?php __('plugin_base_btn_save'); ?></span>
											<?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-sm-6">
						<div class="ibox float-e-margins">
							<div class="ibox-content ibox-heading">
								<h3><?php __('plugin_base_options_captcha_title'); ?></h3>
								<small><?php __('plugin_base_options_captcha_desc'); ?></small>
							</div>
					
							<div class="ibox-content">
								<div class="form-group">
									<label class="control-label col-md-4"><?php __('plugin_base_opt_o_captcha_type'); ?></label>
									<div class="col-md-4 col-sm-12">
									<?php
									$tpl['arr'][$i] = $tpl['_arr']['o_captcha_type'];
									include dirname(__FILE__) . '/elements/enum.php';
									?>
									</div>
								</div>
								
								<div class="form-group box-admin-system<?php echo strpos($tpl['_arr']['o_captcha_type']['value'], '::system') === false ? ' hidden' : NULL; ?>">
									<label class="control-label col-md-4"><?php __('plugin_base_opt_o_captcha_background'); ?></label>
									<div class="col-md-4 col-sm-12">
									<?php
									$tpl['arr'][$i] = $tpl['_arr']['o_captcha_background'];
									include dirname(__FILE__) . '/elements/background.php';
									?>
									</div>
								</div>
								
								<div class="form-group box-admin-system<?php echo strpos($tpl['_arr']['o_captcha_type']['value'], '::system') === false ? ' hidden' : NULL; ?>">
									<label class="control-label col-md-4"><?php __('plugin_base_opt_o_captcha_mode'); ?></label>
									<div class="col-md-4 col-sm-12">
									<?php
									$tpl['arr'][$i] = $tpl['_arr']['o_captcha_mode'];
									include dirname(__FILE__) . '/elements/enum.php';
									?>
									</div>
								</div>
								<?php
								$box_length_class = ' hidden';
								if($tpl['_arr']['o_captcha_type']['value'] == 'system|google::system' && $tpl['_arr']['o_captcha_mode']['value'] == 'string|addition|subtraction|random_math::string')
								{
								    $box_length_class = '';
								}
								?>
								<div class="form-group box-admin-system box-admin-length<?php echo $box_length_class; ?>">
									<label class="control-label col-md-4 col-sm-12 col-xs-12"><?php __('plugin_base_opt_o_captcha_length'); ?></label>
									<div class="col-md-3 col-sm-6 col-xs-6">
									<?php
									$tpl['arr'][$i] = $tpl['_arr']['o_captcha_length'];
									?>
										<input type="text" name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="form-control field-int" value="<?php echo pjSanitize::html($tpl['arr'][$i]['value']); ?>">
									</div>
									<div class="col-md-3 col-sm-6 col-xs-6">
										<p class="m-t-xs"><?php __('plugin_base_lbl_symbols');?></p>
									</div>
								</div>
								
								<div class="form-group box-admin-google<?php echo strpos($tpl['_arr']['o_captcha_type']['value'], '::google') === false ? ' hidden' : NULL; ?>">
									<label class="control-label col-md-4"><?php __('plugin_base_opt_o_captcha_site_key'); ?></label>
									<div class="col-md-8 col-sm-12">
									<?php
									$tpl['arr'][$i] = $tpl['_arr']['o_captcha_site_key'];
									?>
										<input type="text" name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="form-control" value="<?php echo pjSanitize::html($tpl['arr'][$i]['value']); ?>">
									</div>
								</div>
								
								<div class="form-group box-admin-google<?php echo strpos($tpl['_arr']['o_captcha_type']['value'], '::google') === false ? ' hidden' : NULL; ?>">
									<label class="control-label col-md-4"><?php __('plugin_base_opt_o_captcha_secret_key'); ?></label>
									<div class="col-md-8 col-sm-12">
									<?php
									$tpl['arr'][$i] = $tpl['_arr']['o_captcha_secret_key'];
									?>
										<input type="text" name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" class="form-control" value="<?php echo pjSanitize::html($tpl['arr'][$i]['value']); ?>">
									</div>
								</div>
								
								<div class="hr-line-dashed"></div>
								
								<div class="row">
									<div class="col-md-offset-4 col-md-8">
										<button type="submit" class="ladda-button btn btn-primary btn-lg pull-left btn-phpjabbers-loader" data-style="zoom-in">
											<span class="ladda-label"><?php __('plugin_base_btn_save'); ?></span>
											<?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				
				</div>
				<?php 
			}
			if ($tpl['has_access_spam'] && ($haveWords || $haveIps))
			{
				?>
				<div class="ibox float-e-margins">
					<div class="ibox-content ibox-heading">
						<h3><?php __('plugin_base_options_spam_title'); ?></h3>
						<small><?php __('plugin_base_options_spam_desc'); ?></small>
					</div>
			
					<div class="ibox-content">
					<?php
					if ($haveWords)
					{
						$tpl['arr'][$i] = $tpl['_arr']['o_spam_banned_words'];
						$tpl['arr']['i18n'] = $tpl['_arr']['i18n'];
						?>
						<div class="form-group">
							<label class="control-label col-md-3"><?php __('plugin_base_opt_o_spam_banned_words'); ?></label>
							<div class="col-md-9">
							<?php 
							foreach ($tpl['lp_arr'] as $v)
							{
								?>
								<div class="<?php echo $tpl['is_flag_ready'] ? 'input-group' : NULL;?> pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 1 ? '' : 'none'; ?>">
									<textarea name="i18n[<?php echo $v['id']; ?>][<?php echo $tpl['arr'][$i]['key'] ?>]" class="form-control" rows="10"><?php echo pjSanitize::html(@$tpl['arr']['i18n'][$v['id']][$tpl['arr'][$i]['key']]); ?></textarea>
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
					
					if ($haveIps)
					{
						$tpl['arr'][$i] = $tpl['_arr']['o_spam_banned_ip'];
						?>
						<div class="form-group">
							<label class="control-label col-md-3"><?php __('plugin_base_opt_o_spam_banned_ip'); ?></label>
							<div class="col-md-9">
								<textarea name="value-<?php echo $tpl['arr'][$i]['type']; ?>-<?php echo $tpl['arr'][$i]['key']; ?>" rows="10" class="form-control"><?php echo pjSanitize::html($tpl['arr'][$i]['value']); ?></textarea>
							</div>
						</div>
						<?php 
					}
					?>
						<div class="hr-line-dashed"></div>
						
						<div class="row">
							<div class="col-md-9 col-md-offset-3">
								<button type="submit" class="ladda-button btn btn-primary btn-lg btn-phpjabbers-loader" data-style="zoom-in">
									<span class="ladda-label"><?php __('plugin_base_btn_save'); ?></span>
									<?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
								</button>
							</div>
						</div>
					</div>
				</div>
				<?php 
			}
			?>
		</form>
		<?php 
	}
	?>
</div>

<script type="text/javascript">
var myLabel = myLabel || {};
myLabel.img_path = "<?php echo PJ_INSTALL_URL . $controller->getConst('PLUGIN_IMG_PATH') . 'captcha_patterns/';?>";
<?php if ($tpl['is_flag_ready']) : ?>
	var pjCmsLocale = pjCmsLocale || {};
	pjCmsLocale.langs = <?php echo $tpl['locale_str']; ?>;
	pjCmsLocale.flagPath = "<?php echo PJ_FRAMEWORK_LIBS_PATH; ?>pj/img/flags/";
<?php endif; ?>
</script>