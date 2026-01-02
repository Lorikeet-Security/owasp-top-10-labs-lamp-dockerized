<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
<?php 
$type = false;
if (class_exists('pjInput'))
{
	$type = $controller->_get->toString('type');	
	
} else {
	if (isset($tpl['query']['type']))
	{
		$type = $tpl['query']['type'];
	}
}

if ($type && in_array($type, array(1,2)))
{
	$action = $type == 1 ? 'pjActionForm' : 'pjActionSubscribe';
	$controller->requestAction(array(
		'controller' => 'pjStripe',
		'action' => $action,
		'params' => $tpl['params'],
	));
} else {
	?>
	<form method="get" action="">
		<input type="hidden" name="controller" value="pjStripe">
		<input type="hidden" name="action" value="pjActionTest">
		<?php 
		foreach ($tpl['qs'] as $k => $v)
		{
			?><input type="hidden" name="<?php echo pjSanitize::html($k); ?>" value="<?php echo pjSanitize::html($v); ?>">
			<?php
		}
		?>
		<p>
			<label>
				<input type="radio" name="type" value="1" checked> Standard (one-time) payment
			</label>
		</p>
		<p>
			<label>
				<input type="radio" name="type" value="2"> Subscription payment
			</label>
		</p>
		<p>
			<button type="submit">Test</button>
		</p>
	</form>
	<?php
}
?>
</body>
</html>