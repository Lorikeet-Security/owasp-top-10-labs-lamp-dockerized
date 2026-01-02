<?php
$STORAGE = @$_SESSION[$controller->defaultInstaller];
$missing = $warning = array();
if (!PJ_DISABLE_MYSQL_CHECK && !$tpl['mysql_check'])
{
	$warning[] = 'MySQL database is not detected.';
}
if (!$tpl['session_check'])
{
	$missing[] = 'PHP SESSION does not work for your hosting account. Please, contact your hosting company and ask them to fix it.';
}
if (!$tpl['folder_check'])
{
	$missing = array_merge($missing, $tpl['folder_arr']);
}
if (!$tpl['dependencies_check'])
{
	$missing = array_merge($missing, $tpl['dependencies_arr']);
}
if (!$tpl['fn_check'])
{
	$missing = array_merge($missing, $tpl['fn_arr']);
}
?>
<form action="index.php?controller=pjInstaller&amp;action=pjActionStep2&amp;install=1" method="post" id="frmStep1" class="wizard-big">
    <h2>Requires</h2>

    <fieldset>
        <?php
        $title = count($missing) > 0 ? 'Installation error!' : 'Warning!';
        $notices = array_merge($missing, $warning);
        if (!empty($notices))
        {
            ?>
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-triangle m-r-xs"></i>
                <strong><?php echo $title; ?></strong>
                <?php
                foreach ($notices as $item)
                {
                    ?><p class="t10"><?php echo $item; ?></p><?php
                }
                ?>
            </div>

            <div class="hr-line-dashed"></div>
            <?php
        }
        ?>

        <input type="hidden" name="step1" value="1" />

        <div class="m-b-md">
            <p>Bellow you can see server software required to install our product. This is server based software and should be supported by your hosting company. If any of the software below is not supported you should contact your hosting company and ask them to upgrade your hosting plan.</p>
        </div><!-- /.m-b-md -->

        <div class="hr-line-dashed"></div>

        <div class="table-responsive table-responsive-secondary">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Check</th>
                        <th>Version</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>PHP</td>
                        <td>
                            5.4.0
                            <input type="hidden" name="php_version" value="<?php echo $tpl['php_check'] === true ? 1 : 0; ?>" />
                        </td>
                        <?php if ($tpl['php_check'] === true): ?>
                            <td class="text-info"><i class="fa fa-check"></i> Ok</td>
                        <?php else: ?>
                            <td class="text-danger"><i class="fa fa-times"></i> Fail</td>
                        <?php endif; ?>
                    </tr>

                    <?php if (!PJ_DISABLE_MYSQL_CHECK) : ?>
                    <tr>
                        <td>MySQL</td>
                        <td>
                            5.0
                            <input type="hidden" name="mysql_version" value="<?php echo $tpl['mysql_check'] === true ? 1 : 0; ?>" />
                        </td>
                        <?php if ($tpl['mysql_check'] === true): ?>
                            <td class="text-info"><i class="fa fa-check"></i> Ok</td>
                        <?php else: ?>
                            <td class="text-danger"><i class="fa fa-times"></i> Fail</td>
                        <?php endif; ?>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td>PHP Sessions</td>
                        <td>
                            -
                            <input type="hidden" name="php_session" value="<?php echo $tpl['session_check'] === true ? 1 : 0; ?>" />
                        </td>
                        <?php if ($tpl['session_check'] === true): ?>
                            <td class="text-info"><i class="fa fa-check"></i> Ok</td>
                        <?php else: ?>
                            <td class="text-danger"><i class="fa fa-times"></i> Fail</td>
                        <?php endif; ?>
                    </tr>

                    <tr>
                        <td>Dependencies</td>
                        <td>
                            -
                            <input type="hidden" name="dependencies" value="<?php echo $tpl['dependencies_check'] === true ? 1 : 0; ?>" />
                        </td>
                        <?php if ($tpl['dependencies_check'] === true): ?>
                            <td class="text-info"><i class="fa fa-check"></i> Ok</td>
                        <?php else: ?>
                            <td class="text-danger"><i class="fa fa-times"></i> Fail</td>
                        <?php endif; ?>
                    </tr>
				
					<tr>
						<td>System functions</td>
						<td>
							-
							<input type="hidden" name="system" value="<?php echo $tpl['fn_check'] ? 1 : 0; ?>" />
						</td>
						<?php if ($tpl['fn_check']) : ?>
							<td class="text-info"><i class="fa fa-check"></i> Ok</td>
						<?php else: ?>
							<td class="text-danger"><i class="fa fa-times"></i> Fail</td>
						<?php endif; ?>
					</tr>
                </tbody>
            </table>
        </div>

        <div class="hr-line-dashed"></div>

        <p>Need help? <a href="https://www.phpjabbers.com/contact.php" target="_blank">Contact us</a></p>
    </fieldset>

    <h2>MySQL Details</h2>

    <fieldset></fieldset>

    <h2>Install Paths</h2>

    <fieldset></fieldset>

    <h2>Admin Login</h2>

    <fieldset></fieldset>

    <h2>Install Progress</h2>

    <fieldset></fieldset>

    <h2>Finish</h2>

    <fieldset></fieldset>
</form>