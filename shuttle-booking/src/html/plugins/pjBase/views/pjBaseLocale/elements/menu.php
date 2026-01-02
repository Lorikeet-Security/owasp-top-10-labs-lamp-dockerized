<?php $action = $controller->_get->toString('action'); ?>
<ul class="nav nav-tabs">
    <?php if (pjAuth::factory('pjBaseLocale', 'pjActionIndex')->hasAccess()): ?>
        <li class="<?php echo $action == 'pjActionIndex'? 'active': null ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseLocale&amp;action=pjActionIndex"><?php __('plugin_base_languages_tab_languages'); ?></a></li>
    <?php endif; ?>

    <?php if (pjAuth::factory('pjBaseLocale', 'pjActionLabels')->hasAccess()): ?>
        <li class="<?php echo $action == 'pjActionLabels'? 'active': null ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseLocale&amp;action=pjActionLabels"><?php __('plugin_base_languages_tab_labels'); ?></a></li>
    <?php endif; ?>

    <?php if (pjAuth::factory('pjBaseLocale', 'pjActionImportExport')->hasAccess()): ?>
        <li class="<?php echo $action == 'pjActionImportExport'? 'active': null ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseLocale&amp;action=pjActionImportExport"><?php __('plugin_base_languages_tab_import_export'); ?></a></li>
    <?php endif; ?>
</ul>