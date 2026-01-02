<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<style>
	table {
		border-collapse: collapse;
		margin: 15px 0;
	}
	th, td {
		border: solid 1px #333;
		padding: 5px;
		text-align: left;
	}
	</style>
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
		'controller' => 'pj2checkout',
		'action' => $action,
		'params' => $tpl['params'],
	));
	?>
	<table>
		<thead>
			<tr>
				<th>Key</th>
				<th>Value</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
	
	<button type="button" id="btn-submit">Submit</button>
	
	<script>
	(function () {
		var form = document.querySelector("form");
		if (form) {
			document.querySelector("#btn-submit").addEventListener("click", function(e) {
				this.disabled = true;
				form.submit();
			});

			add_row("action", form.action);
			
			for (var i = 0, iCnt = form.elements.length; i < iCnt; i += 1) {

				add_row(form.elements[i].name, form.elements[i].value);
			}
		}

		function add_row(key, value) {
			var td, tr;
			
			tr = document.createElement("TR");

			td = document.createElement("TD");
			td.innerText = key;
			tr.appendChild(td);

			td = document.createElement("TD");
			td.innerText = value;
			tr.appendChild(td);

			document.querySelector("tbody").appendChild(tr);
		}	
	})();
	</script>
	<?php
} else {
	?>
	<form method="get" action="">
		<input type="hidden" name="controller" value="pj2checkout">
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