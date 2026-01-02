var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	"use strict";
	$(function () {
		var $frmCreateLocation = $("#frmCreateLocation"),
			$frmUpdateLocation = $("#frmUpdateLocation"),
			multilang = ($.fn.multilang !== undefined),
			validate = ($.fn.validate !== undefined),
			datagrid = ($.fn.datagrid !== undefined);
		
		
		if ($frmCreateLocation.length > 0) {
			$frmCreateLocation.validate({
				
			});
		}
		if ($frmUpdateLocation.length > 0) {
			$frmUpdateLocation.validate({
				
			});
		}
		if ($frmCreateLocation.length > 0 || $frmUpdateLocation.length > 0) 
		{
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
			
			if(myLabel.locale_array.length > 0)
			{
				for(var i = 0; i < myLabel.locale_array.length ; i++)
				{
					var $address_element = $('#i18n_' + myLabel.locale_array[i] + '_address');
					var $form = $address_element.closest('form');
					if($address_element.length > 0)
					{
						var autocomplete_pickup = new google.maps.places.Autocomplete($address_element[0], {
							types: ["geocode"]
						});
						var pickup_field = document.getElementById('i18n_' + myLabel.locale_array[i] + '_address');
						google.maps.event.addDomListener(pickup_field, 'keydown', function(e) { 
						    if (e.keyCode == 13) { 
						        e.preventDefault(); 
						    }
						});
						google.maps.event.addListener(autocomplete_pickup, 'place_changed', function() {
							var place = autocomplete_pickup.getPlace();
							$form.find('input[name="lat"]').val(place.geometry.location.lat());
							$form.find('input[name="lng"]').val(place.geometry.location.lng());
						});
					}
				}
			}
		}
		if ($("#grid").length > 0 && datagrid) {
			var buttonOpts = [];
			var actionOptions = [];
			if(pjGrid.hasUpdate)
			{
				buttonOpts.push({type: "edit", url: "index.php?controller=pjAdminLocations&action=pjActionUpdate&id={:id}"});
			}
			if(pjGrid.hasDeleteSingle)
			{
				buttonOpts.push({type: "delete", url: "index.php?controller=pjAdminLocations&action=pjActionDeleteLocation&id={:id}"});
			}
			if(pjGrid.hasDeleteMulti)
			{
				actionOptions.push({text: myLabel.delete_selected, url: "index.php?controller=pjAdminLocations&action=pjActionDeleteLocationBulk", render: true, confirmation: myLabel.delete_confirmation});
			}
			var $grid = $("#grid").datagrid({
				buttons: buttonOpts,
				columns: [{text: myLabel.title, type: "text", sortable: true, editable: false},
				          {text: myLabel.address, type: "text", sortable: true, editable: false}],
				dataUrl: "index.php?controller=pjAdminLocations&action=pjActionGetLocation",
				dataType: "json",
				fields: ['title', 'address'],
				paginator: {
					actions: actionOptions,
					gotoPage: true,
					paginate: true,
					total: true,
					rowCount: true
				},
				saveUrl: "index.php?controller=pjAdminLocations&action=pjActionSaveLocation&id={:id}",
				select: {
					field: "id",
					name: "record[]",
					cellClass: 'cell-width-2'
				}
			});
		}
		
		$(document).on("click", ".btn-filter", function (e) {
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
			$grid.datagrid("load", "index.php?controller=pjAdminLocations&action=pjActionGetLocation", "title", "ASC", content.page, content.rowCount);
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
			$grid.datagrid("load", "index.php?controller=pjAdminLocations&action=pjActionGetLocation", "title", "ASC", content.page, content.rowCount);
			return false;
		});
		
	});
})(jQuery_1_8_2);