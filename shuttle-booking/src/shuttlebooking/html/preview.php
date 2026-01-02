<!DOCTYPE html>
<html dir="<?php echo isset($_GET['dir']) ? $_GET['dir'] : ''; ?>">
	<head>
		<title>Shuttle Booking Software - Preview</title>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <link href="core/framework/libs/pj/css/pj.bootstrap.min.css" type="text/css" rel="stylesheet" />
	    <link href="index.php?controller=pjFrontEnd&action=pjActionLoadCss<?php echo isset($_GET['theme']) ? '&theme=' . $_GET['theme'] : null;?>" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<div style="max-width: 1024px; padding: 15px 0">
			<script type="text/javascript" src="index.php?controller=pjFrontEnd&action=pjActionLoad<?php echo isset($_GET['theme']) ? '&theme=' . $_GET['theme'] : null;?>"></script>
		</div>
	</body>
</html>