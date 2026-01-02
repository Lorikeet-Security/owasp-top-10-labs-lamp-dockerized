<?php
$STORAGE = &$_SESSION[$controller->defaultInstaller];
?>

<form action="index.php?controller=pjInstaller&amp;action=pjActionStep5&amp;install=1" method="post" id="frmStep4" class="wizard-big">
    <h2>Requires</h2>

    <fieldset></fieldset>

    <h2>MySQL Details</h2>

    <fieldset></fieldset>

    <h2>Install Paths</h2>

    <fieldset></fieldset>

    <h2>Admin Login</h2>

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

        <input type="hidden" name="step4" value="1" />
        <input type="submit" style="display: none;">

        <div class="m-b-md">
            <p>Enter login details for product administration page. Once product is installed and you log in the administration page you will be able to change these details.</p>
        </div><!-- /.m-b-md -->

        <div class="hr-line-dashed"></div>

        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Email <span class="text-danger">*</span></label>
                    <input type="text" tabindex="1" name="admin_email" id="admin_email" class="form-control required" value="<?php echo isset($STORAGE['admin_email']) ? htmlspecialchars($STORAGE['admin_email']) : NULL; ?>" />
                </div>
            </div><!-- /.col-lg-6 -->

            <div class="col-lg-6">
                <div class="form-group">
                    <label>Password <span class="text-danger">*</span></label>
                    <input type="text" tabindex="2" name="admin_password" id="admin_password" class="form-control required" value="<?php echo isset($STORAGE['admin_password']) ? htmlspecialchars($STORAGE['admin_password']) : NULL; ?>" />
                </div>
            </div><!-- /.col-lg-6 -->
        </div>

        <div class="hr-line-dashed"></div>

        <p>Need help? <a href="https://www.phpjabbers.com/contact.php" target="_blank">Contact us</a></p>
    </fieldset>

    <h2>Install Progress</h2>

    <fieldset></fieldset>

    <h2>Finish</h2>

    <fieldset></fieldset>
</form>