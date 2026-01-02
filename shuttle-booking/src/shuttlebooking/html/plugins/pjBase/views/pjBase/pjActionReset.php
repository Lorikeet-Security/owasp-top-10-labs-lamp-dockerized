<?php
if ($code = $controller->_get->toInt('err'))
{
	?><h3><?php __('plugin_base_admin_reset'); ?></h3><?php
    $login_err = __('plugin_base_login_err', true);
    if(isset($login_err[$code]))
    {
        ?><div class="alert alert-danger" role="alert"><?php echo $login_err[$code]; ?></div><?php
    }
} elseif (isset($tpl['new_password'])) {
	?>
	<h3><?php __('plugin_base_admin_reset_success'); ?></h3>
	<div class="well"><?php echo pjSanitize::html($tpl['new_password']); ?></div>
	<?php 
}
?>
<a href="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjBase&action=pjActionLogin"><small><?php __('plugin_base_link_login'); ?></small></a>