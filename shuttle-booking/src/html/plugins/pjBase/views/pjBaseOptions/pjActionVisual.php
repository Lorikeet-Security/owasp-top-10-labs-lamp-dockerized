<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-12">
				<h2><?php __('plugin_base_infobox_visual_branding_title'); ?></h2>
			</div>
		</div>
		<p class="m-b-none"><i class="fa fa-info-circle"></i><?php __('plugin_base_infobox_visual_branding_desc'); ?></p>
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
			case in_array($error_code, array('PBS02')):
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
	?>
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-content">
					<?php
					if (isset($tpl['arr']) && is_array($tpl['arr']) && ($count = count($tpl['arr'])) > 0)
					{
						?>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseOptions&amp;action=pjActionOptionsUpdate" method="post" class="form-horizontal" id="frmVisual">
							<input type="hidden" name="options_update" value="1" />
							<input type="hidden" name="next_action" value="pjActionVisual" />
							<?php
							for ($i = 0; $i < $count; $i++)
							{
								$rowClass = NULL;
								if ($tpl['arr'][$i]['key'] == 'o_footer_text' && $tpl['option_arr']['o_hide_footer'] == 'Yes')
								{
									$rowClass = " hidden";
								}
								
								if (in_array($tpl['arr'][$i]['key'], array('o_hide_phpjabbers_logo', 'o_hide_footer', 'o_hide_page', 'o_footer_text')))
								{
									$branding = dirname(__FILE__) . '/elements/branding.php';
									if (is_file($branding))
									{
										include $branding;
									}
									continue;
								}
								?>
								<div class="form-group<?php echo $rowClass; ?>">
								
									<label class="col-lg-3 col-md-4 control-label"><?php __('plugin_base_opt_' . $tpl['arr'][$i]['key']); ?></label>
									<div class="col-sm-9 col-md-8">
									<?php
									if ($tpl['arr'][$i]['key'] == 'o_base_theme')
									{
										$default = explode("::", $tpl['arr'][$i]['value']);
										$enum = explode("|", $default[0]);
										$labels = explode("|", $tpl['arr'][$i]['label']);
										?>
										<div class="row">
										<?php
										foreach ($enum as $k => $el)
										{
											$img = PJ_IMG_PATH . 'backend/themes/cms-theme' . ($k + 1) . '.jpg';
											if(!is_file($img))
											{
												$img = PJ_IMG_PATH . 'backend/themes/theme.png';
											}
											?>
											<div class="col-md-2 col-sm-3 col-xs-6">
												<a href="#" class="thumbnail theme<?php echo $tpl['option_arr']['o_base_theme']==$el ? ' active' : NULL;?>" data-theme="<?php echo $el;?>">
													<img src="<?php echo $img ?>" alt="<?php echo pjSanitize::html(@$labels[$k]); ?>" class="img-responsive">
												</a>
											</div>
											<?php
										}
										?>
										</div>
										<?php
									}
									?>
									</div>
								</div>
								<?php
							}
							?>
							<div class="hr-line-dashed"></div>
							<div class="clearfix">
								<button class="ladda-button btn btn-primary btn-lg pull-left btn-phpjabbers-loader" data-style="zoom-in">
									<span class="ladda-label"><?php __('plugin_base_btn_save'); ?></span>
									<?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
								</button>
							</div>
						</form>
						<?php								
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
var myLabel = myLabel || {};
</script>