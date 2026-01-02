<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize" href="#"><i class="fa fa-bars"></i> </a>
        </div>

        <ul class="nav navbar-top-links navbar-right">
            <li>
                <span><?php echo str_replace('{NAME}', pjSanitize::html($_SESSION[$controller->defaultUser]['name']), __('plugin_base_header_welcome', true)) ?></span>
            </li>
		
            <li>
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBaseUsers&amp;action=pjActionProfile">
                    <i class="fa fa-user"></i> <?php __('plugin_base_menu_profile'); ?>
                </a>
            </li>

            <li>
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBase&amp;action=pjActionLogout">
                    <i class="fa fa-sign-out"></i> <?php __('plugin_base_menu_logout'); ?>
                </a>
            </li>
        </ul>
    </nav><!-- / Navbar Top -->
</div><!-- /.row -->