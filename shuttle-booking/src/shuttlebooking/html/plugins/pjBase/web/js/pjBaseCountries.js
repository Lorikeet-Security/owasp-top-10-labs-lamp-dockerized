var jQuery_1_8_2 = jQuery_1_8_2 || jQuery.noConflict();
(function ($, undefined) {
	$(function () {
		"use strict";
		var $frmCreateCountry = $("#frmCreateCountry"),
			$frmUpdateCountry = $("#frmUpdateCountry"),
			validate = ($.fn.validate !== undefined),
			multilang = ($.fn.multilang !== undefined),
			datagrid = ($.fn.datagrid !== undefined);

		if (multilang && 'pjCmsLocale' in window) {
			$(".multilang").multilang({
				langs: pjCmsLocale.langs,
				flagPath: pjCmsLocale.flagPath,
				tooltip: "",
				select: function (event, ui) {
					$("input[name='locale_id']").val(ui.index);
				}
			});
		}
		if ($frmCreateCountry.length > 0 && validate) {
			$frmCreateCountry.validate({
				rules: {
					alpha_2: {
						rangelength: [2,2],
						remote: "index.php?controller=pjBaseCountries&action=pjActionCheckAlpha"
					},
					alpha_3: {
						rangelength: [3,3],
						remote: "index.php?controller=pjBaseCountries&action=pjActionCheckAlpha"
					}
				},
				invalidHandler: function (event, validator) {
				    $(".pj-multilang-wrap").each(function( index ) {
						if($(this).attr('data-index') == myLabel.localeId)
						{
							$(this).css('display','block');
						}else{
							$(this).css('display','none');
						}
					});
					$(".pj-form-langbar-item").each(function( index ) {
						if($(this).attr('data-index') == myLabel.localeId)
						{
							$(this).addClass('btn-primary');
						}else{
							$(this).removeClass('btn-primary');
						}
					});
				},
				ignore: ""
			});
		}
		if ($frmUpdateCountry.length > 0 && validate) {
			$frmUpdateCountry.validate({
				rules: {
					alpha_2: {
						rangelength: [2,2],
						remote: "index.php?controller=pjBaseCountries&action=pjActionCheckAlpha&id=" + $frmUpdateCountry.find("input[name='id']").val()
					},
					alpha_3: {
						rangelength: [3,3],
						remote: "index.php?controller=pjBaseCountries&action=pjActionCheckAlpha&id=" + $frmUpdateCountry.find("input[name='id']").val()
					}
				},
				invalidHandler: function (event, validator) {
				    $(".pj-multilang-wrap").each(function( index ) {
						if($(this).attr('data-index') == myLabel.localeId)
						{
							$(this).css('display','block');
						}else{
							$(this).css('display','none');
						}
					});
					$(".pj-form-langbar-item").each(function( index ) {
						if($(this).attr('data-index') == myLabel.localeId)
						{
							$(this).addClass('btn-primary');
						}else{
							$(this).removeClass('btn-primary');
						}
					});
				},
				ignore: ""
			});
		}
		
		if ($("#grid").length > 0 && datagrid) {
			var actions = [
				   {text: myLabel.delete_selected, url: "index.php?controller=pjBaseCountries&action=pjActionDeleteCountryBulk", render: true, confirmation: myLabel.delete_confirmation},
				   {text: myLabel.revert_status, url: "index.php?controller=pjBaseCountries&action=pjActionStatusCountry", render: true}					   
				];
			if (!pjGrid.has_revert) {
				actions = [
				   {text: myLabel.delete_selected, url: "index.php?controller=pjBaseCountries&action=pjActionDeleteCountryBulk", render: true, confirmation: myLabel.delete_confirmation}
				];
			}
			var $grid = $("#grid").datagrid({
				buttons: [{type: "edit", url: "index.php?controller=pjBaseCountries&action=pjActionUpdate&id={:id}"},
				          {type: "delete", url: "index.php?controller=pjBaseCountries&action=pjActionDeleteCountry&id={:id}"}
				          ],
				columns: [{text: myLabel.country_name, type: "text", sortable: true, editable: true, editableWidth: 300},
				          {text: myLabel.alpha_2, type: "text", sortable: true, editable: true, editableWidth: 100},
				          {text: myLabel.alpha_3, type: "text", sortable: true, editable: true, editableWidth: 100},
				          {text: myLabel.status, type: "toggle", sortable: true, editable: true, positiveLabel: myLabel.active, positiveValue: "T", negativeLabel: myLabel.inactive, negativeValue: "F"}],
				dataUrl: "index.php?controller=pjBaseCountries&action=pjActionGetCountry",
				dataType: "json",
				fields: ['name', 'alpha_2', 'alpha_3', 'status'],
				paginator: {
					actions: actions,
					gotoPage: true,
					paginate: true,
					total: true,
					rowCount: true
				},
				saveUrl: "index.php?controller=pjBaseCountries&action=pjActionSaveCountry&id={:id}",
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
			$(this).addClass("btn-primary active").removeClass("btn-default")
				.siblings(".btn").removeClass("btn-primary active").addClass("btn-default");
			var content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache");
			$.extend(cache, {
				status: "",
				q: "",
				page: 1
			});
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", $grid.data('datagrid').settings.dataUrl, content.column, content.direction, content.page, content.rowCount);
			return false;
		}).on("click", ".btn-filter", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this),
				content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache"),
				obj = {};
			$this.addClass("btn-primary active").removeClass("btn-default")
				.siblings(".btn").removeClass("btn-primary active").addClass("btn-default");
			obj.status = "";
			obj[$this.data("column")] = $this.data("value");
			$.extend(cache, obj);
			$.extend(cache, {
				page: 1
			});
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", $grid.data('datagrid').settings.dataUrl, content.column, content.direction, content.page, content.rowCount);
			return false;
		}).on("submit", ".frm-filter", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this),
				content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache");
			$.extend(cache, {
				q: $this.find("input[name='q']").val(),
				page: 1
			});
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", $grid.data('datagrid').settings.dataUrl, content.column, content.direction, content.page, content.rowCount);
			return false;
		});
	});
})(jQuery_1_8_2);