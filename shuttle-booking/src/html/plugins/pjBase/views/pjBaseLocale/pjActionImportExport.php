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
    	if($error_code == 'PAL03')
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
				<?php echo @$bodies[$error_code];?>
			</div>
    	    <?php
    	}
    }
    ?>
	<div class="row">
    	<div class="col-lg-12">
    		<div class="tabs-container">
                <?php include 'elements/menu.php'; ?>

    			<div class="tab-content">
    				<div class="tab-pane active">
    					<div class="panel-body">
    						<div class="ibox-content no-margins no-padding no-top-border">
                                <?php if ($tpl['has_access_import'] || $tpl['has_access_export']): ?>
                                    <?php if ($tpl['has_access_import']): ?>
                                        <form id="frmImportConfirm" action="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjBaseLocale&amp;action=pjActionImportConfirm" method="post" class="form-horizontal" enctype="multipart/form-data">
                                            <input type="hidden" name="import" value="1" />
                                            <div class="m-t-sm m-b-sm">
                                                <h2><?php __('plugin_base_locale_lbl_import');?></h2>

                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label"><?php __('plugin_base_locale_delimiter'); ?></label>
                                                <div class="col-sm-6">
                                                    <select name="separator" class="form-control">
                                                    <?php
                                                    foreach (__('plugin_base_locale_separators', true) as $k => $v)
                                                    {
                                                        ?><option value="<?php echo $k; ?>"><?php echo pjSanitize::html($v); ?></option><?php
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label"><?php __('plugin_base_locale_browse_csv_file');?></label>

                                                <div class="col-sm-6">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <span class="btn btn-primary btn-outline btn-file"><span class="fileinput-new"><i class="fa fa-upload m-r-xs"></i><?php __('plugin_base_locale_select_file');?></span>
                                                        <span class="fileinput-exists"><i class="fa fa-upload m-r-xs"></i><?php __('plugin_base_locale_change_file');?></span><input name="file" type="file" class="fileinput required" data-msg-required="<?php __('plugin_base_validate_select_file', false, true);?>"/></span>
                                                        <span class="fileinput-filename"></span>

                                                        <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">x</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">&nbsp;</label>

                                                <div class="col-sm-6">
                                                    <button type="submit" class="ladda-button btn btn-primary btn-lg pull-left btn-phpjabbers-loader" data-style="zoom-in">
                                                        <span class="ladda-label"><?php __('plugin_base_btn_import'); ?></span>
                                                        <?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <br/><br/>
                                    <?php endif; ?>

                                    <?php if ($tpl['has_access_export']): ?>
                                        <form action="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjBaseLocale&amp;action=pjActionExport" method="post" class="form-horizontal" enctype="multipart/form-data">
                                            <input type="hidden" name="export" value="1" />
                                            <div class="m-t-sm m-b-sm">
                                                <h2><?php __('plugin_base_locale_lbl_export');?></h2>

                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label"><?php __('plugin_base_locale_delimiter'); ?></label>
                                                <div class="col-sm-6">
                                                    <select name="separator" class="form-control">
                                                    <?php
                                                    foreach (__('plugin_base_locale_separators', true) as $k => $v)
                                                    {
                                                        ?><option value="<?php echo $k; ?>"><?php echo pjSanitize::html($v); ?></option><?php
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">&nbsp;</label>

                                                <div class="col-sm-6">
                                                    <button type="submit" class="ladda-button btn btn-primary btn-lg pull-left btn-phpjabbers-loader" data-style="zoom-in">
                                                        <span class="ladda-label"><?php __('plugin_base_btn_export'); ?></span>
                                                        <?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <h3 class="font-bold"><?php __('plugin_base_access_denied_title'); ?></h3>
                                    <div class="error-desc">
                                        <?php __('plugin_base_access_denied_desc'); ?>
                                    </div>
                                <?php endif; ?>
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