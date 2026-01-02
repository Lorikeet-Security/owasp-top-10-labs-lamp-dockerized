<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-10">
                <h2><?php __('infoPreviewTitle') ?></h2>
            </div>
        </div><!-- /.row -->

        <p class="m-b-none"><i class="fa fa-info-circle"></i> <?php __('infoPreviewDesc') ?></p>
    </div><!-- /.col-md-12 -->
</div>

<div class="row border-bottom bar-top">
    <div class="col-1of3">
        <a target="_blank" href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseLocale&amp;action=pjActionLabels" class="btn btn-secondary"><i class="fa fa-refresh m-r-xs"></i> <?php __('script_change_labels') ?></a>

        <div class="btn-group color-theme-group" role="group" aria-label="...">
            <button type="button" class="btn btn-secondary"data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-hand-o-up m-r-xs"></i> <?php __('lblChooseTheme') ?> <i class="fa fa-angle-down m-l-xs"></i></button>
            <ul class="dropdown-menu">
                <li>
                    <?php
                    $theme_arr = __('option_themes', true);
                    ksort($theme_arr);
                    $selected_theme = $tpl['option_arr']['o_theme'];
                    if($controller->_get->check('theme'))
                    {
                        $selected_theme = $controller->_get->toString('theme');
                    }
                    $i = 1;
                    foreach($theme_arr as $k => $v)
                    {
                        $is_used = false;
                        if('theme' . $k == $selected_theme)
                        {
                            $is_used = true;
                        }
                        $img = PJ_IMG_PATH . 'backend/themes/theme' . $k . '.jpg';
                        if(!is_file($img))
                        {
                            $img = PJ_IMG_PATH . 'backend/themes/theme.png';
                        }
                        ?>
                        <a href="preview.php?locale=<?php echo $controller->getLocaleId();?>&hide=0&theme=<?php echo 'theme' . $k; ?>" class="thumbnail<?php echo $is_used ? ' active' : null;?>" data-theme="<?php echo pjSanitize::html($v);?>" data-index="theme<?php echo $k; ?>">
                            <img src="<?php echo $img;?>" alt="">
                        </a>
                        <?php
                        if ($i % 2 == 0 && $i < count($theme_arr))
                        {
                            ?>
                            </li><li>
                            <?php
                        }
                        $i++;
                    }
                    ?>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-1of3 text-center">
        <a class="device-view active" href="#" data-device="desktop"><i class="fa fa-desktop"></i></a>

        <div class="device-view-holder">
            <a class="device-view" href="#" data-device="tablet" data-orientation="portrait"><i class="fa fa-tablet"></i></a>
            <a class="device-view device-view-rotate" href="#" data-device="tablet" data-orientation="landscape"><i class="fa fa-tablet"></i></a>
        </div>

        <div class="device-view-holder">
            <a class="device-view" href="#" data-device="phone" data-orientation="portrait"><i class="fa fa-mobile phone"></i></a>
            <a class="device-view device-view-rotate" href="#" data-device="phone" data-orientation="landscape"><i class="fa fa-mobile phone"></i></a>
        </div>
    </div>

    <div class="col-1of3 text-right">
        <a href="preview.php?locale=<?php echo $controller->getLocaleId();?>&hide=0&theme=<?php echo 'theme' . str_replace('theme', '', $selected_theme); ?>" class="btn btn-secondary open-new-window" target="_blank"><i class="fa fa-eye m-r-xs"></i> <?php __('script_preview_your_website') ?></a>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;action=pjActionInstall" class="btn btn-secondary"><i class="fa fa-wrench m-r-xs"></i> <?php __('script_install_your_website') ?></a>
    </div>
</div>

<iframe id="iframeEditor" class="iframe-editor" src="preview.php?locale=<?php echo $controller->getLocaleId();?>&hide=0&theme=<?php echo 'theme' . str_replace('theme', '', $selected_theme); ?>"></iframe>

<div id="iframeDevice" class="hidden">
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-sm-12">
			<div class="row">
				<div class="col-sm-10">
					<h2 id="device_title"></h2>
				</div>
			</div>
			<p class="m-b-none"><i class="fa fa-info-circle"></i> <span id="device_info"></span></p>
		</div>
	</div>

	<div class="row wrapper wrapper-content">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-content">
					<br>
					<div id="iframeHolder"></div>
					<br>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="hidden" id="phone_portrait"><?php __('plugin_base_editor_phone_portrait'); ?></div>
<div class="hidden" id="phone_landscape"><?php __('plugin_base_editor_phone_landscape'); ?></div>
<div class="hidden" id="tablet_portrait"><?php __('plugin_base_editor_tablet_portrait'); ?></div>
<div class="hidden" id="tablet_landscape"><?php __('plugin_base_editor_tablet_landscape'); ?></div>
<div class="hidden" id="phone_portrait_info"><?php __('plugin_base_editor_phone_portrait_info'); ?></div>
<div class="hidden" id="phone_landscape_info"><?php __('plugin_base_editor_phone_landscape_info'); ?></div>
<div class="hidden" id="tablet_portrait_info"><?php __('plugin_base_editor_tablet_portrait_info'); ?></div>
<div class="hidden" id="tablet_landscape_info"><?php __('plugin_base_editor_tablet_landscape_info'); ?></div>