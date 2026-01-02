<?php $action = $controller->_get->toString('action'); ?>
<ul class="nav nav-tabs">
    <?php if (pjAuth::factory('pjBaseLog', 'pjActionIndex')->hasAccess()): ?>
        <li class="<?php echo $action == 'pjActionIndex'? 'active': null ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseLog&amp;action=pjActionIndex"><?php __('plugin_base_log_menu_log'); ?></a></li>
    <?php endif; ?>

    <?php if (pjAuth::factory('pjBaseLog', 'pjActionConfig')->hasAccess()): ?>
        <li class="<?php echo $action == 'pjActionConfig'? 'active': null ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseLog&amp;action=pjActionConfig"><?php __('plugin_base_log_menu_config'); ?></a></li>
    <?php endif; ?>
</ul>