<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-10">
				<h2><?php __('plugin_base_locale_infobox_languages_title'); ?></h2>
			</div>
		</div>
		<p class="m-b-none"><i class="fa fa-info-circle"></i> <?php __('plugin_base_locale_infobox_languages_desc'); ?></p>
	</div>
</div>

<div class="row wrapper wrapper-content animated fadeInRight">
	<div class="col-lg-12">
		<div class="tabs-container">
            <?php include 'elements/menu.php'; ?>

			<div class="tab-content">
				<div class="tab-pane active">
					<div class="panel-body">
						<div class="ibox-content no-margins no-padding no-top-border">
							<p class="m-b-md">
								<button type="button" class="btn btn-primary btn-add"><i class="fa fa-plus m-r-xs"></i> <?php __('plugin_base_btn_add_language'); ?></button>
							</p>
							<div id="grid-locales"></div>
						</div><!-- /.ibox-content no-margins no-padding no-top-border -->
					</div><!-- /.panel-body -->
				</div><!-- /.tab-pane active -->
			</div><!-- /.tab-content -->
		</div><!-- /.tabs-container -->
	</div><!-- /.col-lg-12 -->
</div><!-- /.row wrapper wrapper-content animated fadeInRight -->

<?php
$languages = array();
foreach ($tpl['language_arr'] as $item)
{
	$languages[] = '{value: "'.$item['iso'].'", label: "'.$item['title'].'"}';
}
?>
<script type="text/javascript">
var pjGrid = pjGrid || {};
pjGrid.languages = [];
<?php
if (count($languages) > 0)
{
	printf('pjGrid.languages.push('.join(",", $languages).');');
}
?>
var myLabel = myLabel || {};
myLabel.language = <?php x__encode('plugin_base_locale_lbl_language'); ?>;
myLabel.name = <?php x__encode('plugin_base_locale_lbl_frontend_title'); ?>;
myLabel.flag = <?php x__encode('plugin_base_locale_lbl_flag'); ?>;
myLabel.dir = <?php x__encode('plugin_base_locale_lbl_text_direction'); ?>;
myLabel.directions = <?php x__encode('plugin_base_locale_dir'); ?>;
myLabel.is_default = <?php x__encode('plugin_base_locale_lbl_is_default'); ?>;
myLabel.order = <?php x__encode('plugin_base_locale_lbl_order'); ?>;
myLabel.btn_reset = <?php x__encode('plugin_base_locale_btn_reset'); ?>;
myLabel.btn_cancel = <?php x__encode('plugin_base_btn_cancel'); ?>;
myLabel.btn_close = <?php x__encode('plugin_base_btn_close'); ?>;
myLabel.tooltip_reset = <?php x__encode('plugin_base_locale_tooltip_reset'); ?>;
myLabel.tooltip_upload = <?php x__encode('plugin_base_locale_tooltip_upload'); ?>;
myLabel.yes = <?php x__encode('plugin_base_yesno_ARRAY_T'); ?>;
myLabel.no = <?php x__encode('plugin_base_yesno_ARRAY_F'); ?>;
</script>