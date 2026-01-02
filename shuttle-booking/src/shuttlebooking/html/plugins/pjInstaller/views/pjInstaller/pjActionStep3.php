<?php
$STORAGE = &$_SESSION[$controller->defaultInstaller];
?>

<form action="index.php?controller=pjInstaller&amp;action=pjActionStep4&amp;install=1" method="post" id="frmStep3" class="wizard-big">
    <h2>Requires</h2>

    <fieldset></fieldset>

    <h2>MySQL Details</h2>

    <fieldset></fieldset>

    <h2>Install Paths</h2>

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

        if (isset($tpl['warning']))
        {
            ?>
            <div class="alert alert-warning">
                <i class="fa fa-info-circle m-r-xs"></i>
                <strong>Warning!</strong>
                If you proceed with the installation your current database tables and all the data will be deleted.
            </div>
            <?php
        }
        ?>

        <input type="hidden" name="step3" value="1" />
        <input type="submit" style="display: none;">

        <div class="m-b-md">
            <p>We've detected the following server paths where product is uploaded. Most probably you will not have to change these paths.</p>
        </div><!-- /.m-b-md -->

        <div class="hr-line-dashed"></div>

        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Folder Name <span class="text-danger">*</span></label>
                    <input type="text" tabindex="1" name="install_folder" class="form-control required" value="<?php echo isset($tpl['paths']) ? $tpl['paths']['install_folder'] : htmlspecialchars(@$STORAGE['install_folder']); ?>" />
                </div>

                <div class="form-group">
                    <label>Full URL <span class="text-danger">*</span></label>
                    <input type="text" tabindex="2" name="install_url" class="form-control required" value="<?php echo isset($tpl['paths']) ? $tpl['paths']['install_url'] : htmlspecialchars(@$STORAGE['install_url']); ?>" />
                </div>

                <div class="form-group">
                    <label>Server Path <span class="text-danger">*</span></label>
                    <input type="text" tabindex="3" name="install_path" class="form-control required" value="<?php echo isset($tpl['paths']) ? $tpl['paths']['install_path'] : htmlspecialchars(@$STORAGE['install_path']); ?>" />
                </div>
            </div><!-- /.col-lg-6 -->

            <div class="col-lg-6">
                <h3>Examples</h3>

                <p>If the product is uploaded in <strong>http://www.website.com/script/</strong> <br> then Folder name should be <strong>/script/</strong> <br> Full URL should be: <strong>http://www.website.com/script/</strong></p>

                <p>If the product is uploaded in <strong>http://www.website.com/folder/script/</strong> <br> then Folder name should be <strong>/folder/script/</strong> <br> Full URL should be: <strong>http://www.website.com/folder/script/</strong></p>
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->

        <div class="hr-line-dashed"></div>

        <p>Need help? <a href="https://www.phpjabbers.com/contact.php" target="_blank">Contact us</a></p>
    </fieldset>

    <h2>Admin Login</h2>

    <fieldset></fieldset>

    <h2>Install Progress</h2>

    <fieldset></fieldset>

    <h2>Finish</h2>

    <fieldset></fieldset>
</form>