<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php __('script_name') ?> by Parrot CTFs</title>
    <?php
    $cnt = count($controller->getCss());
    foreach ($controller->getCss() as $i => $css)
    {
        echo '<link rel="stylesheet" href="'.(isset($css['remote']) && $css['remote'] ? NULL : PJ_INSTALL_URL).$css['path'].$css['file'].'">';
        echo "\n";
        if ($i < $cnt - 1)
        {
            echo "\t";
        }
    }
    ?>
</head>
<body class="light-grey-bg">

<div id="wrapper">
    <div class="main">
        <div class="container">
            <div class="middle-box login-box animated fadeInDown">
                <?php require $content_tpl; ?>

                <div class="login-img-background">
                    <img src="<?php echo pjObject::getConstant('pjBase', 'PLUGIN_IMG_PATH'); ?>phpjabbers-logo1.jpg" alt="PHPJabbers">
                </div><!-- /.login-img-background -->
            </div><!-- /.middle-box --> 
            
            <div class="login-box-footer animated fadeInDown">
                <div class="m-t-lg text-right">
                    <?php
                    if($tpl['option_arr']['o_hide_footer'] == 'No')
                    {
                        if(!empty($tpl['option_arr']['o_footer_text']))
                        {
                            echo pjSanitize::html($tpl['option_arr']['o_footer_text']);
                        }else{
                            ?>
                            Copyright <a href="http://shuttlebooking.pctfs"> Shutle Booking </a> &copy; <?php echo date("Y"); ?>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div><!-- /.login-box-footer -->
        </div><!-- /.container -->
    </div><!-- /.main -->
</div><!-- /#wrapper -->

<?php
    $cnt = count($controller->getJs());
    foreach ($controller->getJs() as $i => $js)
    {
        echo '<script src="'.(isset($js['remote']) && $js['remote'] ? NULL : PJ_INSTALL_URL).$js['path'].$js['file'].'"></script>';
        echo "\n";
        if ($i < $cnt - 1)
        {
            echo "\t";
        }
    }
    ?>
</body>
</html>
