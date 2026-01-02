var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	$(function () {
		"use strict";
		var $frmCreateLine = $("#frmCreateLine"),
			$frmUpdateLine = $("#frmUpdateLine"),
			datagrid = ($.fn.datagrid !== undefined);
		
		
		if ($frmCreateLine.length > 0 || $frmUpdateLine.length > 0) {
			$(".field-int").TouchSpin({
	            verticalbuttons: true,
	            buttondown_class: 'btn btn-white',
	            buttonup_class: 'btn btn-white',
	            min: 1,
	            max: 4294967295
			});
		}
		if ($frmCreateLine.length > 0) {
			$frmCreateLine.validate({
				
			});
		}
		if ($frmUpdateLine.length > 0) {
			$frmUpdateLine.validate({
				
			});
		}
		
		function formatImage(val, obj) {
			var src = val != null ? val : 'app/web/img/backend/no-image.png';
			return ['<a href="index.php?controller=pjAdminLines&action=pjActionUpdate&id=', obj.id ,'"><img src="', src, '" style="width: 100px" /></a>'].join("");
		}
		if ($("#grid").length > 0 && datagrid) {
			
			var buttonOpts = [];
			var actionOpts = [];
			if(pjGrid.hasUpdate)
			{
				buttonOpts.push({type: "edit", url: "index.php?controller=pjAdminLines&action=pjActionUpdate&id={:id}"});
			}
			if(pjGrid.hasDeleteSingle)
			{
				buttonOpts.push({type: "delete", url: "index.php?controller=pjAdminLines&action=pjActionDeleteLine&id={:id}"});
			}
			if(pjGrid.hasDeleteMulti)
			{
				actionOpts.push({text: myLabel.delete_selected, url: "index.php?controller=pjAdminLines&action=pjActionDeleteLineBulk", render: true, confirmation: myLabel.delete_confirmation});
			}
			var $grid = $("#grid").datagrid({
				buttons: buttonOpts,
				columns: [{text: myLabel.thumb, type: "text", sortable: false, editable: false, renderer: formatImage},
				          {text: myLabel.title, type: "text", sortable: true, editable: pjGrid.hasUpdate},
				          {text: myLabel.location, type: "text", sortable: true, editable: false},
				          {text: myLabel.seats, type: "text", sortable: true, editable: false, align: "center"}],
				dataUrl: "index.php?controller=pjAdminLines&action=pjActionGetLine",
				dataType: "json",
				fields: ['thumb_path', 'title', 'location', 'seats'],
				paginator: {
					actions: actionOpts,
					gotoPage: true,
					paginate: true,
					total: true,
					rowCount: true
				},
				saveUrl: "index.php?controller=pjAdminLines&action=pjActionSaveLine&id={:id}",
				select: {
					field: "id",
					name: "record[]",
					cellClass: 'cell-width-2'
				}
			});
		}
		
		$(document).on("click", ".btn-all", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			$(this).addClass("pj-button-active").siblings(".pj-button").removeClass("pj-button-active");
			var content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache");
			$.extend(cache, {
				status: "",
				q: ""
			});
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjAdminLines&action=pjActionGetLine", content.column, content.direction, content.page, content.rowCount);
			return false;
		}).on("click", ".btn-filter", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this),
				content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache"),
				obj = {};
			$this.addClass("pj-button-active").siblings(".pj-button").removeClass("pj-button-active");
			obj.status = "";
			obj[$this.data("column")] = $this.data("value");
			$.extend(cache, obj);
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjAdminLines&action=pjActionGetLine", content.column, content.direction, content.page, content.rowCount);
			return false;
		}).on("submit", ".frm-filter", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this),
				content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache");
			$.extend(cache, {
				q: $this.find("input[name='q']").val()
			});
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjAdminLines&action=pjActionGetLine", content.column, content.direction, content.page, content.rowCount);
			return false;
		}).on("click", '.btnAddLocation', function(e){
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var clone_text = $('#pjSbsLineTableClone').find('tbody').html(),
				index = 'new_' + Math.ceil(Math.random() * 999999);
			clone_text = clone_text.replace(/\{INDEX\}/g, index);
			clone_text = clone_text.replace(/\{SPINNER\}/g, 'field-int');
			
			$('#pjSbsLineTable').append(clone_text);
			$('#trLocation_' + index).find(".field-int").TouchSpin({
	            verticalbuttons: true,
	            buttondown_class: 'btn btn-white',
	            buttonup_class: 'btn btn-white',
	            min: 1,
	            max: 4294967295
			});
		}).on("click", ".linkRemoveRow", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $tr = $(this).closest('tr');
			$tr.css("backgroundColor", "#FFB4B4").fadeOut("slow", function () {
				$tr.remove();
			});
		}).on("click", ".pj-delete-image", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			
			var id = $(this).attr('data-id');
			var $this = $(this);
			swal({
				title: myLabel.alert_title,
				text: myLabel.alert_text,
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: myLabel.btn_delete,
				cancelButtonText: myLabel.btn_cancel,
				closeOnConfirm: false,
				showLoaderOnConfirm: true
			}, function () {
				$.post($this.attr("href"), {id: id}).done(function (data) {
					if (!(data && data.status)) {
						
					}
					switch (data.status) {
					case "OK":
						swal.close();
						$('.pj-type-image').remove();
						break;
					}
				});
			});
		});
	});
})(jQuery_1_8_2);