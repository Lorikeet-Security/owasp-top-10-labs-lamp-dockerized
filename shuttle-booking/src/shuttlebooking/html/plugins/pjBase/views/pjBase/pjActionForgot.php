


<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBase&amp;action=pjActionForgot" method="post" id="frmForgot" class="m-t" role="form" novalidate="novalidate">
    <input type="hidden" name="forgot_user" value="1">

    <h2><?php __('plugin_base_admin_forgot'); ?></h2>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-at"></i></span>

                    <input type="email" name="forgot_email" id="forgot_email" class="form-control form-control-lg required email" placeholder="<?php __('plugin_base_login_email', false, true); ?>" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>" data-msg-email="<?php __('plugin_base_email_invalid', false, true);?>">
                </div>
            </div>

            <?php if($tpl['option_arr']['o_forgot_use_captcha'] == 'Yes'): ?>
                <div id="captchaContainerPermanent">
                    <?php if($tpl['option_arr']['o_captcha_type'] == 'system'): ?>
                        <div class="form-group">
                            <div class="input-group input-group-captcha">
                                <input type="text" name="login_captcha" id="login_captcha" class="form-control form-control-lg required" placeholder="<?php __('plugin_base_login_captcha', false, true); ?>" autocomplete="off" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>" data-msg-remote="<?php __('plugin_base_captcha_incorrect', false, true);?>">

                                 <span class="input-group-addon">
                                    <img src="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjBase&amp;action=pjActionCaptcha&amp;rand=<?php echo rand(1, 99999); ?>" alt="Captcha" class="captcha" title="<?php __('plugin_base_captcha_reload', false, true); ?>">
                                </span>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="<?php echo $tpl['option_arr']['o_captcha_site_key']; ?>" data-callback="correctCaptcha"></div>
                            <input type="hidden" id="recaptcha" name="recaptcha" class="required" autocomplete="off" data-msg-required="<?php __('plugin_base_this_field_is_required', false, true);?>" data-msg-remote="<?php __('plugin_base_captcha_incorrect', false, true);?>"/>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="m-t-lg">
                <button type="submit" class="btn btn-primary btn-block btn-lg"><?php __('plugin_base_btn_send_password_reminder', false, true); ?></button>

                <div class="m-t-sm">
                    <a href="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjBase&action=pjActionLogin"><small><?php __('plugin_base_link_login'); ?></small></a>
                </div>
            </div><!-- /.row -->

            <?php
            if ($code = $controller->_get->toInt('err'))
            {
                $login_err = __('plugin_base_login_err', true);
                if(isset($login_err[$code]))
                {
                    ?><div class="alert alert-danger"><?php echo $login_err[$code]; ?></div><?php
                }
            }
            ?>
        </div><!-- /.col-sm-6 -->
    </div><!-- /.row -->

    <div class="welcome-section">
        <h3><?php __('plugin_base_login_welcome'); ?></h3>

        <p><?php __('plugin_base_login_welcome_prefix'); ?> <?php __('script_name') ?> v<?php echo PJ_SCRIPT_VERSION;?> <?php __('plugin_base_login_welcome_suffix'); ?></p>
    </div><!-- /.welcome-section -->
</form>