<?php 
$titles = __('error_titles', true);
$bodies = __('error_bodies', true);
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-6">
                <h2><?php __('infoTermsTitle'); ?></h2>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 btn-group-languages">
                <?php if ($tpl['is_flag_ready']) : ?>
				<div class="multilang"></div>
				<?php endif; ?>
        	</div>
        </div><!-- /.row -->

        <p class="m-b-none"><i class="fa fa-info-circle"></i><?php __('infoTermsDesc'); ?></p>
    </div><!-- /.col-md-12 -->
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<?php
	$error_code = $controller->_get->toString('err');
	if (!empty($error_code))
	{
	    $titles = __('error_titles', true);
	    $bodies = __('error_bodies', true);
	    switch (true)
	    {
	        case in_array($error_code, array('AO05')):
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
	if (isset($tpl['arr']) && is_array($tpl['arr']) && !empty($tpl['arr']))
	{
        $locale = $controller->_get->toInt('locale') ?: NULL;
        if (is_null($locale))
        {
            foreach ($tpl['lp_arr'] as $v)
            {
                if ($v['is_default'] == 1)
                {
                    $locale = $v['id'];
                    break;
                }
            }
        }
        if (is_null($locale))
        {
            $locale = @$tpl['lp_arr'][0]['id'];
        }
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form id="frmUpdateOptions" action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;action=pjActionUpdate" class="form-horizontal" method="post">
                            <input type="hidden" name="options_update" value="1" />
                            <input type="hidden" name="tab" value="5" />
                            <input type="hidden" name="next_action" value="pjActionTerm" />
    
                            <div class="row">
                                <div class="col-lg-11">
                                    <div class="form-group">
                                        <label class="col-lg-3 col-md-4 control-label"><?php __('opt_o_terms') ?></label>
    
                                        <div class="col-lg-9 col-md-8 mce-md">
                                            <?php
                                            foreach ($tpl['lp_arr'] as $v)
                                            {
                                                ?>
                                                <div class="<?php echo $tpl['is_flag_ready'] ? 'input-group ' : NULL;?>pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : 'table'; ?>">
                                                    <textarea name="i18n[<?php echo $v['id']; ?>][o_terms]" class="form-control mceEditor" style="width: 400px; height: 260px;"><?php echo !empty($tpl['arr']['i18n'][$v['id']]['o_terms']) ? htmlspecialchars(stripslashes(@$tpl['arr']['i18n'][$v['id']]['o_terms'])) : NULL; ?></textarea>
                                                    <?php if ($tpl['is_flag_ready']) : ?>
                                                    <span class="input-group-addon pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="<?php echo pjSanitize::html($v['name']); ?>"></span>
                                                    <?php endif; ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div><!-- /.col-lg-8 -->
                            </div><!-- /.row -->
    
                            <div class="hr-line-dashed"></div>
    
                            <div class="row">
                            	<div class="col-lg-11">
                            		<div class="row">
                            			<div class="col-lg-9 col-lg-offset-3 col-md-8 col-md-offset-4">
    			                            <button type="submit" class="ladda-button btn btn-primary btn-lg btn-phpjabbers-loader" data-style="zoom-in">
    			                                <span class="ladda-label"><?php __('plugin_base_btn_save'); ?></span>
    			                                <?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
    			                            </button>
    									</div>
    	                            </div>
                                </div>
                            </div><!-- /.clearfix -->
                        </form>
                    </div>
                </div>
            </div><!-- /.col-lg-12 -->
        </div>
        <?php
	}
	?>
</div>
<script type="text/javascript">
<?php if ($tpl['is_flag_ready']) : ?>
	var pjCmsLocale = pjCmsLocale || {};
	pjCmsLocale.langs = <?php echo $tpl['locale_str']; ?>;
	pjCmsLocale.flagPath = "<?php echo PJ_FRAMEWORK_LIBS_PATH; ?>pj/img/flags/";
<?php endif; ?>
</script>