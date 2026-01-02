<form id="form" action="#" class="wizard-big">
    <fieldset>
        <h2>Installation error!</h2>

        <fieldset>
            <div class="m-b-md">
                <p>Product is already installed. If you need to re-install it empty <span class="bold">app/config/config.inc.php</span> file.</p>

                <p><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjInstaller&amp;action=pjActionChange">Change installation domain or hosting account</a></p>
            </div><!-- /.m-b-md -->

            <div class="hr-line-dashed"></div>

            <p>Need help? <a href="https://www.phpjabbers.com/contact.php" target="_blank">Contact us</a></p>
        </fieldset>
    </fieldset>
</form><!-- /.middle-box -->