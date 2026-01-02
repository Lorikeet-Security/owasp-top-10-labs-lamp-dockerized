<?php
$login_email = NULL;
$second_factor = false;
if ($controller->session->has($controller->defaultLoginEmail) && $controller->_get->toInt('msg') > 0)
{
	$second_factor = true;
    $login_email = $controller->session->getData($controller->defaultLoginEmail);
}
$login_2_factor = $tpl['option_arr']['o_secure_login_2factor_auth'];
$login_2_factor = 'No'; // just for sure
$use_captcha = $tpl['option_arr']['o_secure_login_use_captcha'] == 'Yes';
?>

<div id="alertFormDisabled" class="alert alert-danger" style="display: none;"></div>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBase&amp;action=pjActionLogin" method="post" id="frmLogin" class="m-t" role="form" novalidate="novalidate">
    <input type="hidden" name="login_user" value="1">

    <?php
    if($login_2_factor == 'Yes' && $second_factor == false)
    {
        ?>
        <input type="hidden" name="two_factor" value="1">
        <?php
    }
    ?>
    
    <h2><?php __('plugin_base_admin_login'); ?></h2>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-at"></i></span>

                    <input type="email" name="login_email" id="login_email" value="<?php echo $login_email;?>" class="form-control form-control-lg required email" placeholder="<?php __('plugin_base_login_email', false, true); ?>" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>" data-msg-email="<?php __('plugin_base_email_invalid', false, true);?>">
                </div>
            </div>

            <?php if($login_2_factor == 'No' || $second_factor == true): ?>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                        <input type="password" name="login_password" id="login_password" class="form-control form-control-lg required" placeholder="<?php __('plugin_base_login_password', false, true); ?>" autocomplete="off" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>">
                    </div>

                    <?php if($second_factor): ?>
                        <a href="#" class="link-resend-password" data-email="<?php echo $login_email ?>"><small><?php __('plugin_base_link_resend_password'); ?></small></a>
                    <?php endif; ?>
                </div>

                <div id="<?php echo $use_captcha? 'captchaContainerPermanent': 'captchaContainer'; ?>" style="display: <?php echo $use_captcha? 'block': 'none'; ?>">
                    <?php if($tpl['option_arr']['o_captcha_type'] == 'system'): ?>

                        <div class="form-group">
                            <div class="input-group input-group-captcha">
                                <input type="text" name="login_captcha" id="login_captcha" class="form-control form-control-lg required" placeholder="<?php __('plugin_base_login_captcha', false, true); ?>" autocomplete="off" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>" data-msg-remote="<?php __('plugin_base_captcha_incorrect', false, true);?>">

                                <span class="input-group-addon">
                                    <img src="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjBase&amp;action=pjActionCaptcha&amp;rand=<?php echo rand(1, 99999); ?>" alt="Captcha" class="captcha" title="<?php __('plugin_base_captcha_reload', false, true); ?>">
                                </span>
                            </div>
                        </div><!-- /.form-group -->
                    <?php else: ?>
                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="<?php echo $tpl['option_arr']['o_captcha_site_key']; ?>" data-callback="correctCaptcha"></div>
                            <input type="hidden" id="recaptcha" name="recaptcha" class="required" autocomplete="off" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>" data-msg-remote="<?php __('plugin_base_captcha_incorrect', false, true);?>"/>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="row m-t-lg">
                <div class="col-lg-6">
                    <button type="submit" class="btn btn-primary btn-block btn-lg"><?php __('plugin_base_btn_login', false, true); ?></button>
                </div><!-- /.col-lg-6 -->

                <div class="col-lg-6">
                    <div class="m-t-sm">
                        <?php if($login_2_factor == 'No'): ?>
                            <a href="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjBase&action=pjActionForgot"><small><?php __('plugin_base_link_forgot_password'); ?></small></a>
                        <?php endif; ?>
                    </div>
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->

            <?php
            if ($controller->_get->toInt('err') > 0)
            {
                $login_err = __('plugin_base_login_err', true);
                $code = $controller->_get->toInt('err');
                if(isset($login_err[$code]))
                {
                    if($code == 5)
                    {
                        $message = sprintf($login_err[$code], (int)$tpl['option_arr']['o_failed_login_lock_after']);
                    }else{
                        $message = $login_err[$code];
                    }
                    ?><div class="alert alert-danger"><?php echo $message; ?></div><?php
                }
            }
            elseif ($controller->_get->toInt('msg') > 0)
            {
                $login_err = __('plugin_base_login_err', true);
                $code = $controller->_get->toInt('msg');
                if(isset($login_err[$code]))
                {
                    ?><div class="alert alert-success"><?php echo $login_err[$code]; ?></div><?php
                }
            }

            $login_email = NULL;
            $second_factor = false;
            if ($controller->session->has($controller->defaultLoginEmail) && $controller->_get->toInt('msg') > 0)
            {
                $second_factor = true;
                ?>
                <div class="alert alert-success">
                    <?php
                    if($tpl['option_arr']['o_secure_login_send_password_to'] == 'email')
                        __('plugin_base_two_factor_auth_email_title');
                    else
                        __('plugin_base_two_factor_auth_sms_title');
                    ?>
                </div>
                <?php
                $login_email = $controller->session->getData($controller->defaultLoginEmail);
            }
            ?>
        </div><!-- /.col-sm-6 -->
    </div><!-- /.row -->

    <div class="welcome-section">
        <h3><?php __('plugin_base_login_welcome'); ?></h3>

        <p><?php __('plugin_base_login_welcome_prefix'); ?> <?php __('script_name') ?> v<?php echo PJ_SCRIPT_VERSION;?> <?php __('plugin_base_login_welcome_suffix'); ?></p>
    </div><!-- /.welcome-section -->
</form>


