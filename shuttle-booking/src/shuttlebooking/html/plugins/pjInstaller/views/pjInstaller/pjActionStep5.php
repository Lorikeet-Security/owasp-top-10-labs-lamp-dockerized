<?php
$STORAGE = &$_SESSION[$controller->defaultInstaller];
?>

<form action="index.php?controller=pjInstaller&amp;action=pjActionStep6&amp;install=1" method="post" id="frmStep5" class="wizard-big">
    <h2>Requires</h2>

    <fieldset></fieldset>

    <h2>MySQL Details</h2>

    <fieldset></fieldset>

    <h2>Install Paths</h2>

    <fieldset></fieldset>

    <h2>Admin Login</h2>

    <fieldset></fieldset>

    <h2>Install Progress</h2>

    <fieldset>
        <div class="alert alert-danger" style="display: none">
            <i class="fa fa-exclamation-triangle m-r-xs"></i>
            <strong>Installation error!</strong>
            <p></p>
        </div>

        <input type="hidden" name="step5" value="1" />

        <div class="m-b-md">
            <p></p>
        </div><!-- /.m-b-md -->

        <div class="hr-line-dashed"></div>

        <div class="table-responsive table-responsive-secondary">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Install Progress</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="text-muted">
                        <td>Generate Option file</td>
                        <td><i class="fa fa-check"></i></td>
                    </tr>

                    <tr class="text-muted">
                        <td>Create MySQL tables</td>
                        <td><i class="fa fa-check"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="hr-line-dashed"></div>

        <p>Need help? <a href="https://www.phpjabbers.com/contact.php" target="_blank">Contact us</a></p>
    </fieldset>

    <h2>Finish</h2>

    <fieldset></fieldset>
</form>