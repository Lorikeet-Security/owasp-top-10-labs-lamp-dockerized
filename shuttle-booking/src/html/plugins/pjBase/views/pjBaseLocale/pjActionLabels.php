<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-10">
                <h2><?php __('plugin_base_locale_infobox_labels_title'); ?></h2>
            </div>
        </div><!-- /.row -->

        <p class="m-b-none"><i class="fa fa-info-circle"></i> <?php __('plugin_base_locale_infobox_labels_desc'); ?></p>
    </div><!-- /.col-md-12 -->
</div>

<div class="row wrapper wrapper-content animated fadeInRight">
	<div class="col-lg-12">
		<div class="tabs-container">
			<?php include 'elements/menu.php'; ?>

			<div class="tab-content">
				<div class="tab-pane active">
					<div class="panel-body">
						<div class="ibox-content no-margins no-padding no-top-border">
    						<div class="row m-b-md">
                                <div class="col-md-4 col-sm-6">
                                    <form action="" method="get" class="form-horizontal frm-filter" data-variant="frontend">
    									<div class="input-group">
    										<input type="text" name="q" class="form-control" placeholder="<?php __('plugin_base_lbl_search', false, true); ?>">
    										<div class="input-group-btn">
    											<button class="btn btn-primary" type="submit">
    												<i class="fa fa-search"></i>
    											</button>
    										</div>
    									</div>
    								</form>
                                </div><!-- /.col-md-4 -->

                                <div class="col-md-4 col-sm-6">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn btn-primary btn-outline"><?php !!$tpl['is_ids_shown'] ? __('plugin_base_languages_advanced_on') : __('plugin_base_languages_advanced_off'); ?></a>
                                </div><!-- /.col-md-4 -->
                            </div><!-- /.row -->

                            <div id="collapseOne" class="collapse">
                                <div class="m-b-lg">
                                    <ul class="agile-list no-padding">
                                        <li class="success-element b-r-sm">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <?php if ($tpl['has_access_show_ids']): ?>
                                                        <div class="col-sm-6">
                                                            <h2><?php __('plugin_base_languages_advanced_title'); ?></h2>

                                                            <p><?php __('plugin_base_languages_advanced_desc'); ?></p>

                                                            <br>

                                                            <p class="lead"><?php __('plugin_base_languages_advanced_show_id'); ?>:</p>

                                                            <form action="" method="post" id="frmUpdateShowID"
                                                                data-title="<?php __('plugin_base_locale_showid_dialog_title', false, true); ?>"
                                                                data-text="<?php __('plugin_base_locale_showid_dialog_desc', false, true); ?>"
                                                                data-confirm="<?php __('plugin_base_btn_confirm', false, true); ?>"
                                                                data-cancel="<?php __('plugin_base_btn_cancel', false, true); ?>">
                                                                <input type="hidden" name="lang_show_id" value="1">
                                                                <div class="switch onoffswitch-data pull-left">
                                                                    <div class="onoffswitch">
                                                                        <input type="checkbox" class="onoffswitch-checkbox" id="show_id" name="show_id"<?php echo !!$tpl['is_ids_shown'] ? ' checked' : NULL; ?>>
                                                                        <label class="onoffswitch-label" for="show_id">
                                                                            <span class="onoffswitch-inner" data-on="<?php __('plugin_base_yesno_ARRAY_T', false, true); ?>" data-off="<?php __('plugin_base_yesno_ARRAY_F', false, true); ?>"></span>
                                                                            <span class="onoffswitch-switch"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div><!-- /.col-sm-6 -->

                                                        <div class="col-sm-6">
                                                            <iframe class="iframe-responsive" height="315" src="https://www.youtube.com/embed/objIMltecoQ" frameborder="0" allowfullscreen></iframe>
                                                        </div><!-- /.col-sm-6 -->
                                                    <?php else: ?>
                                                        <div class="col-sm-12">
                                                            <h3 class="font-bold"><?php __('plugin_base_access_denied_title'); ?></h3>
                                                            <div class="error-desc">
                                                                <?php __('plugin_base_access_denied_desc'); ?>
                                                            </div>
                                                        </div><!-- /.col-sm-6 -->
                                                    <?php endif; ?>
                                                </div><!-- /.row -->
                                            </div><!-- /.panel-body -->
                                        </li><!-- /.panel panel-primary -->
                                    </ul>
                                </div><!-- /.m-b-lg -->
                            </div><!-- /.collapse -->
                            
                            <div id="grid-frontend"></div>
                        </div><!-- /.ibox-content no-margins no-padding no-top-border -->
					</div><!-- /.panel-body -->
				</div><!-- /.tab-pane active -->
			</div><!-- /.tab-content -->
		</div><!-- /.tabs-container -->
	</div><!-- /.col-lg-12 -->
</div><!-- /.row wrapper wrapper-content animated fadeInRight -->

<div style="display: none" id="tmplLanguage">
	<div class="row">
		<div class="col-sm-3"><?php __('plugin_base_locale_translate_to'); ?></div>
		<div class="col-sm-9">
			<select class="form-control" id="locale_id">
			<?php 
			foreach ($tpl['menu_locale_arr'] as $item)
			{
				?><option value="<?php echo pjSanitize::html($item['id']); ?>"><?php echo pjSanitize::html($item['name']); ?></option><?php
			}
			?>
			</select>
		</div>
	</div>
</div>

<script>
var pjGrid = pjGrid || {};
var myLabel = myLabel || {};
myLabel.id = <?php x__encode('plugin_base_locale_id'); ?>;
myLabel.default_language = <?php echo pjBaseAppController::jsonEncode($tpl['default_language']); ?>;
myLabel.language = <?php x__encode('plugin_base_locale_translate_to'); ?>;
myLabel.field_type = <?php x__encode('plugin_base_locale_field_type'); ?>;
myLabel.showId = <?php echo (int) $tpl['is_ids_shown']; ?>;
</script>