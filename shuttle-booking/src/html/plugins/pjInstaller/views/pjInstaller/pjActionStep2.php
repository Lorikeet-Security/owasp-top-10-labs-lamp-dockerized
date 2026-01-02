<?php
$STORAGE = &$_SESSION[$controller->defaultInstaller];
?>

<form action="index.php?controller=pjInstaller&amp;action=pjActionStep3&amp;install=1" method="post" id="frmStep2" class="wizard-big">
    <h2>Requires</h2>

    <fieldset></fieldset>

    <h2>MySQL Details</h2>

    <fieldset>
        <?php
        $hasErrors = FALSE;
        $err = $controller->_get->toString('err');
        if ($err && isset($_SESSION[$controller->defaultErrors][$err]))
        {
            ?>
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-triangle m-r-xs"></i>
                <strong>Installation error!</strong>
                <?php echo $_SESSION[$controller->defaultErrors][$err]; ?>
            </div>
            <?php
            $hasErrors = TRUE;
            $alert = array('status' => 'ERR', 'text' => strip_tags($_SESSION[$controller->defaultErrors][$err]));
        }
        ?>

        <input type="hidden" name="step2" value="1" />
        <input type="submit" style="display: none;">

        <div class="m-b-md">
            <p>Please enter MYSQL login details for your server. If you do not know these please contact your hosting company and ask them to provide you with correct details.</p>
	        <p>Alternatively, you can send us access to your hosting account control panel (the place where you manage your hosting account) and we can create MySQL database and user for you.</p>
        </div><!-- /.m-b-md -->

        <div class="hr-line-dashed"></div>

        <div class="form-group">
            <label>Hostname <span class="text-danger">*</span></label>

            <input type="text" tabindex="1" name="hostname" class="form-control required" value="<?php echo isset($STORAGE['hostname']) ? htmlspecialchars($STORAGE['hostname']) : 'localhost'; ?>" />
            <small>*Hostname could be hostname (domain or localhost) or IP address. You can also specify specific server port example.com:3307 or socket :/tmp/mysql</small>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Username <span class="text-danger">*</span></label>
                    <input type="text" tabindex="2" name="username" class="form-control required" value="<?php echo isset($STORAGE['username']) ? htmlspecialchars($STORAGE['username']) : NULL; ?>" />
                </div>
            </div><!-- /.col-lg-6 -->

            <div class="col-lg-6">
                <div class="form-group">
                    <label>Password</label>
                    <input type="text" tabindex="3" name="password" class="form-control" value="<?php echo isset($STORAGE['password']) ? htmlspecialchars($STORAGE['password']) : NULL; ?>" />
                </div>
            </div><!-- /.col-lg-6 -->

            <div class="col-lg-6">
                <div class="form-group">
                    <label>Database <span class="text-danger">*</span></label>
                    <input type="text" tabindex="4" name="database" class="form-control required" value="<?php echo isset($STORAGE['database']) ? htmlspecialchars($STORAGE['database']) : NULL; ?>" />
                </div>
            </div><!-- /.col-lg-6 -->

            <div class="col-lg-6">
                <div class="form-group">
                    <label>Table prefix</label>
                    <input type="text" tabindex="5" name="prefix" class="form-control" value="<?php echo isset($STORAGE['prefix']) ? htmlspecialchars($STORAGE['prefix']) : NULL; ?>" />

                    <small>* you can leave that blank or enter table prefix which will be added to all MySQL tables names</small>
                </div>
            </div><!-- /.col-lg-6 -->
        </div>

        <div class="hr-line-dashed"></div>

        <p>Need help? <a href="https://www.phpjabbers.com/contact.php" target="_blank">Contact us</a></p>
    </fieldset>

    <h2>Install Paths</h2>

    <fieldset></fieldset>

    <h2>Admin Login</h2>

    <fieldset></fieldset>

    <h2>Install Progress</h2>

    <fieldset></fieldset>

    <h2>Finish</h2>

    <fieldset></fieldset>
</form>