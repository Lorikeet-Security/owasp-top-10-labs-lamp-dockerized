<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-10">
                <h2><?php __('plugin_base_locale_infobox_ie_title'); ?></h2>
            </div>

        </div><!-- /.row -->

        <p class="m-b-none"><i class="fa fa-info-circle"></i> <?php __('plugin_base_locale_infobox_ie_desc'); ?></p>
    </div><!-- /.col-md-12 -->
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<?php
	$error_code = $controller->_get->toString('err');
	if (!empty($error_code))
    {
    	$titles = __('plugin_base_error_titles', true);
    	$bodies = __('plugin_base_error_bodies', true);
    	if($error_code == 'PAL20')
    	{
    	    ?>
    	    <div class="alert alert-success">
				<i class="fa fa-check m-r-xs"></i>
				<strong><?php echo @$titles[$error_code]; ?></strong>
				<?php echo @$bodies[$error_code]?>
			</div>
    	    <?php
    	}else{
    	    ?>
    	    <div class="alert alert-danger">
				<i class="fa fa-exclamation-triangle m-r-xs"></i>
				<strong><?php echo @$titles[$error_code]; ?></strong>
				<?php echo @$bodies[$error_code] . (isset($tpl['tm_text']) ? ' ' . $tpl['tm_text']: NULL);?>
			</div>
    	    <?php
    	}
    }
    ?>
    <div class="row">
    	<div class="col-lg-12">
    		<div class="tabs-container">
    			<ul class="nav nav-tabs">
    				<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseLocale&amp;action=pjActionIndex"><?php __('plugin_base_languages_tab_languages'); ?></a></li>
    				<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseLocale&amp;action=pjActionLabels"><?php __('plugin_base_languages_tab_labels'); ?></a></li>
    				<li class="active"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseLocale&amp;action=pjActionImportExport"><?php __('plugin_base_languages_tab_import_export'); ?></a></li>
    			</ul>
    			<div class="tab-content">
    				<div class="tab-pane active">
    					<div class="panel-body">
    						<div class="ibox-content no-margins no-padding no-top-border">
        						<form action="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjBaseLocale&amp;action=pjActionImport" method="post" class="form-horizontal">
                    				<input type="hidden" name="import" value="1" />
                    				<input type="hidden" name="key" value="<?php echo pjSanitize::html($controller->_get->toString('key')); ?>" />
                    				<?php
                    				$STORE = @$_SESSION[$controller->_get->toString('key')];
                    				if (isset($tpl['locale_arr']) && !empty($tpl['locale_arr']))
                    				{
                    					foreach ($tpl['locale_arr'] as $locale)
                    					{
                    						?><p><label><input type="checkbox" name="locale[]" value="<?php echo $locale['id']; ?>" checked="checked"<?php echo !is_array(@$STORE['locales']) || !in_array($locale['id'], $STORE['locales']) ? ' disabled="disabled"' : NULL; ?> /> <?php echo pjSanitize::html($locale['title'] . (!empty($locale['region']) ? sprintf(' (%s)', $locale['region']): NULL)); ?></label></p><?php
                    					}
                    				}
                    				?>
                    				<div class="form-group">
                    					<div class="col-sm-6">
                                            <button type="submit" class="ladda-button btn btn-primary btn-lg pull-left btn-phpjabbers-loader" data-style="zoom-in">
                                                <span class="ladda-label"><?php __('plugin_base_btn_import'); ?></span>
                                                <?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
                                            </button> 
                                        </div>
                                    </div>
                    			</form>
                            </div><!-- /.ibox-content no-margins no-padding no-top-border -->
    					</div><!-- /.panel-body -->
    				</div><!-- /.tab-pane active -->
    			</div><!-- /.tab-content -->
    		</div><!-- /.tabs-container -->
    	</div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
</div><!-- /.row wrapper wrapper-content animated fadeInRight -->

<script>
var myLabel = myLabel || {};
</script>