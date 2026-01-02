<!doctype html>
<html>
	<head>
		<title>Install Wizard</title>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<?php
		foreach ($controller->getCss() as $css)
		{
			echo '<link type="text/css" rel="stylesheet" href="'.$css['path'].htmlspecialchars($css['file']).'" />';
		}
		
		foreach ($controller->getJs() as $js)
		{
			echo '<script src="'.$js['path'].htmlspecialchars($js['file']).'"></script>';
		}
		?>
	</head>
	<body class="gray-bg">
        <div class="page-wrapper">
            <div class="header">
                <div class="container">
                    <a href="#" class="header-logo">Installer</a>
                </div><!-- /.container -->
            </div><!-- /.header -->

            <div class="main">
                <div class="container" id="container">
                    <div class="text-center m-b-md">
                        <h1>Install Wizard</h1>
                    </div><!-- /.text-center -->

                    <div id="middle">
                    <?php require $content_tpl; ?>
                    </div>
                </div><!-- /.container -->
            </div><!-- /.main -->
        </div>
	</body>
</html>