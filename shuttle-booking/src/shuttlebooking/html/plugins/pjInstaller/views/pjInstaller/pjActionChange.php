<div class="panel no-borders">
    <div class="panel-body">
    <?php
    $err = $controller->_get->toString('err');

    if (isset($tpl['status']))
    {
        switch ($tpl['status'])
        {
            case 1:
                ?>
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-triangle m-r-xs"></i>
                    <strong>Configuration error</strong>
                    Product is not installed yet. If you need to install, please <a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjInstaller&amp;action=pjActionStep1&amp;install=1">click here</a>.
                </div>
                <?php
                break;
            case 2:
                ?>
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-triangle m-r-xs"></i>
                    <strong>Configuration error</strong>
                    Installation path, folder and URL are the same.
                </div>
                <?php
                break;
            case 3:
                $title = 'Authorization required';
                $description = 'To see this page you need to login.';
                if ($err && isset($_SESSION[$controller->defaultErrors][$err]))
                {
                    $err = $_SESSION[$controller->defaultErrors][$err];
                    if (isset($err['text']))
                    {
                        $title = 'Authorization status';
                        $description = $err['text'];
                    }
                }
                ?>
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-triangle m-r-xs"></i>
                    <strong><?php echo $title ?></strong>
                    <?php echo $description ?>
                </div>

                <h2>Login</h2>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjInstaller&amp;action=pjActionChange" method="post" id="frmChangeLogin">
                    <input type="hidden" name="do_login" value="1" />

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Email: <span class="text-danger">*</span></label>
                                <input type="text" name="email" class="form-control" data-msg-required="Email address is required" data-msg-email="Valid email address is required" autocomplete="off" maxlength="255" />
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Captcha: <span class="text-danger">*</span></label>
                                <input type="text" name="captcha" class="form-control" maxlength="6" data-msg-required="Captcha is required" data-msg-remote="Captcha doesn't match" autocomplete="off" />
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <br/>
                                <img src="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjInstaller&amp;action=pjActionCaptcha&amp;rand=<?php echo rand(1,9999); ?>" alt="Captcha" class="i-captcha" title="Click to reload" />
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="clearfix">
                        <button class="ladda-button btn btn-primary btn-lg btn-phpjabbers-loader pull-left" data-style="zoom-in">
                            <span class="ladda-label">Log in</span>
                            <?php include $controller->getConstant('pjBase', 'PLUGIN_VIEWS_PATH') . 'pjLayouts/elements/button-animation.php'; ?>
                        </button>
                    </div><!-- /.clearfix -->
                </form>
                <?php
                break;
        }
    } else {
        if ($err && isset($_SESSION[$controller->defaultErrors][$err]))
        {
            $err = $_SESSION[$controller->defaultErrors][$err];
            switch ($err['status'])
            {
                case 'ERR':
                    ?>
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-triangle m-r-xs"></i>
                        <strong>Change has not been successfull</strong>
                        <?php echo @$err['text'] ?>
                    </div>
                    <?php
                    break;
                case 'OK':
                    ?>
                    <div class="alert alert-success">
                        <i class="fa fa-check m-r-xs"></i>
                        <strong>Change has been successfull</strong>
                        <?php echo @$err['text'] ?>
                    </div>
                    <?php
                    break;
            }
        }
        ?>
        <form action="" method="post" class="i-form" id="frmChange">
            <input type="hidden" name="do_change" value="1" />
            <input type="hidden" name="change_domain" value="0" />
            <input type="hidden" name="change_db" value="0" />
            <input type="hidden" name="change_paths" value="<?php echo (!$tpl['areTheSamePaths']) ? 1 : 0; ?>" />
            <fieldset>
                <legend>Domain</legend>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Domain: </label>
                            <span class="form-control-static"><?php echo $tpl['domain']; ?> (<a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="changeDomain">change</a>)</span>
                        </div>
                    </div>
                </div>

                <div class="row boxDomain" style="display: none;">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>New domain: <span class="text-danger">*</span></label>
                            <input name="new_domain" class="form-control" value="<?php echo pjSanitize::html($_SERVER['SERVER_NAME']); ?>" />
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Database</legend>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Current MySQL login details</label>
                            <span class="form-control-static"> (<a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="changeMySQL">change</a>)</span>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Hostname: </label>
                            <span class="form-control-static"><?php echo PJ_HOST; ?></span>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Username: </label>
                            <span class="form-control-static"><?php echo PJ_USER; ?></span>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Password: </label>
                            <span class="form-control-static"><?php echo str_repeat('*', 6); ?></span>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Database: </label>
                            <span class="form-control-static"><?php echo PJ_DB; ?></span>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Hostname: </label>
                            <span class="form-control-static"><?php echo PJ_HOST; ?></span>
                        </div>
                    </div>
                </div>

                <div class="row boxMySQL" style="display: none;">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>New MySQL login details</label>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Hostname: <span class="text-danger">*</span></label>
                            <input name="hostname" class="form-control" />
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Username: <span class="text-danger">*</span></label>
                            <input name="username" class="form-control" />
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Password: </label>
                            <input name="password" class="form-control" />
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Database: <span class="text-danger">*</span></label>
                            <input name="database" class="form-control" />
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Paths</legend>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Installation path and URL in config.inc.php file</label>
                            <?php
                            if (!$tpl['areTheSamePaths'])
                            {
                                ?><span class="form-control-static">&nbsp;</span><?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Folder Name: </label>
                            <span class="form-control-static"><?php echo PJ_INSTALL_FOLDER; ?></span>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Full URL: </label>
                            <span class="form-control-static"><?php echo PJ_INSTALL_URL; ?></span>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Server Path: </label>
                            <span class="form-control-static"><?php echo PJ_INSTALL_PATH; ?></span>
                        </div>
                    </div>
                </div>

                <?php if (!$tpl['areTheSamePaths']): ?>
                    <div class="row boxPaths">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Current path and URL</label>
                                <span class="form-control-static">(These will be set for your installation)</span>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Folder Name:</label>
                                <span class="form-control-static"><?php echo pjSanitize::html($tpl['paths']['install_folder']); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Full URL:</label>
                                <span class="form-control-static"><?php echo pjSanitize::html($tpl['paths']['install_url']); ?></span>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Server Path:</label>
                                <span class="form-control-static"><?php echo pjSanitize::html($tpl['paths']['install_path']); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </fieldset>

            <div class="hr-line-dashed"></div>

            <div class="clearfix">
                <p class="pull-left">Need help? <a href="https://www.phpjabbers.com/contact.php" target="_blank">Contact us</a></p>

                <input type="submit" value="Update installation" class="btn btn-primary pull-right" />
            </div><!-- /.clearfix -->
        </form>
        <?php
    }
    ?>
    </div>
</div>
