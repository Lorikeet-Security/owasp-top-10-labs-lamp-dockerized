<div class="ibox float-e-margins">
    <div class="ibox-content">
        <?php
        if (isset($tpl['status']))
        {
            switch ($tpl['status'])
            {
                case 2:
                    ?>
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-triangle m-r-xs"></i>
                        <strong>Login required</strong>
                        In order to access this page you need to log in first.
                    </div>
                    <?php
                    break;
            }
        } else {
            ?>
            <div class="alert alert-warning">
                <i class="fa fa-info-circle m-r-xs"></i>
                <strong>Plugin Install</strong>
                Use this tool to install plugins added after initial script installation.
            </div>

            <div id="grid"></div>

            <div id="dialogInstall" style="display: none" title="Install confirmation">Are you sure you want to install selected plugin?
                <label class="error" style="display: none"></label>
            </div>

            <div id="dialogNotice" style="display: none" title="System notice"></div>

            <script type="text/javascript">
            var myLabel = myLabel || {};
            myLabel.name = 'Plugin';
            myLabel.dt = 'Installed on';
            myLabel.install = 'Install';
            myLabel.uninstall = 'Uninstall';
            </script>
            <?php
        }
        ?>
    </div>
</div>