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
            <strong>Database Update</strong>
            You can update either to specified database version or more than just one.
        </div>

        <div id="grid"></div>

        <button type="button" class="btn btn-primary btn-execute-all" style="display: none">Execute</button>

        <div id="dialogExecuteAll" style="display: none" title="Execute confirmation">Are you sure you want to execute file(s) that are not executed yet?
            <label class="error" style="display: none"></label>
        </div>

        <div id="dialogExecute" style="display: none" title="Execute confirmation">Are you sure you want to execute selected file?
            <label class="error" style="display: none"></label>
        </div>

        <div id="dialogNotice" style="display: none" title="System notice"></div>

        <script type="text/javascript">
        var myLabel = myLabel || {};
        myLabel.name = 'File name';
        myLabel.label = 'Refers to';
        myLabel.dt = 'Executed on';
        myLabel.execute = 'Execute';
        myLabel.execute_selected = 'Execute Selected';
        myLabel.confirm_selected = 'Are you sure you want to execute selected file(s)?';
        </script>
        <?php
    }
    ?>
    </div>
</div>