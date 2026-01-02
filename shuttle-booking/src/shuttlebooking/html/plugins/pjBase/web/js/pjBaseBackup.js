var jQuery_1_8_2 = jQuery_1_8_2 || jQuery.noConflict();
(function ($, undefined) {
	$(function () {
		var datagrid = ($.fn.datagrid !== undefined),
			$frmCreateBackup = $("#frmCreateBackup"),
			$document = $(document);

		function formatFile(val, obj) 
		{
			return ['<a href="index.php?controller=pjBaseBackup&action=pjActionDownload&id=', obj.id, '">', val, '</a>'].join("");
		}
		$frmCreateBackup.validate({
			
		});
		if ($("#grid").length > 0 && datagrid) {
			var gridOpts = {
				buttons: [
							{type: "download", url: "index.php?controller=pjBaseBackup&action=pjActionDownload&id={:id}"},
							{type: "delete", url: "index.php?controller=pjBaseBackup&action=pjActionDelete&id={:id}"}
						],
				columns: [{text: myLabel.backup_made, type: "text", sortable: true, editable: false},
				          {text: myLabel.data_type, type: "text", sortable: true, editable: false},
						  {text: myLabel.file_size, type: "text", sortable: true, editable: false},
				          {text: myLabel.file_name, type: "text", sortable: true, editable: false, renderer: formatFile}
				          ],
				dataUrl: "index.php?controller=pjBaseBackup&action=pjActionGet",
				dataType: "json",
				fields: ['created', 'type', 'size', 'id'],
				paginator: {
					actions: [
						{text: myLabel.delete_selected, url: "index.php?controller=pjBaseBackup&action=pjActionDeleteBulk", render: true, confirmation: myLabel.delete_confirmation}
					],
					gotoPage: true,
					paginate: true,
					total: true,
					rowCount: true
				},
				saveUrl: null,
				select: {
					field: "id",
					name: "record[]",
					cellClass: 'cell-width-2'
				}
			};
			
			var $grid = $("#grid").datagrid(gridOpts);
		}
		$document.on('change', '#frmBackup .onoffswitch-checkbox', function (e) {
			var set = $(this).is(':checked')? 1: 0;
			$.post('index.php?controller=pjBaseBackup&action=pjActionSetBackup', {"set" : set}).done(function (data) {
    			
    		});
		}).on("change", "#frmCreateBackup .onoffswitch-checkbox", function () {
			var haveChecked = $("#backup_database").is(":checked") || $("#backup_files").is(":checked");
			$(this).closest("form").find(":submit").prop("disabled", !haveChecked);
		});
	});
})(jQuery_1_8_2);