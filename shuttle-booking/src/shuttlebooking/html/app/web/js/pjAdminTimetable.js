var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	$(function () {
		"use strict";
		var $frmCreateTimetable = $("#frmCreateTimetable"),
			$frmUpdateTimetable = $("#frmUpdateTimetable"),
			$frmSchedule = $('#frmSchedule'),			
			dialog = ($.fn.dialog !== undefined),
			datagrid = ($.fn.datagrid !== undefined);
		
		
		if ($frmCreateTimetable.length > 0) {
			$frmCreateTimetable.validate({
				
			});
		}
		if ($frmUpdateTimetable.length > 0) {
			$frmUpdateTimetable.validate({
				
			});
		}
		if ($frmCreateTimetable.length > 0 || $frmUpdateTimetable.length > 0)
		{
			if($('.i-checks').length > 0)
			{
				$('.i-checks').iCheck({
		            checkboxClass: 'icheckbox_square-green',
		            radioClass: 'iradio_square-green'
		        });
				$('input').on('ifChanged', function (event) { 
					$('.pjTimeLabel').hide();
					$('.pjTimeLabel-' + event.target.value).show();
				});
			}
			if ($('.clockpicker').length) {
	        	$('.clockpicker').clockpicker({
	                twelvehour: myLabel.showperiod,
	                autoclose: true,
	                afterDone: function() {
	                	   
	                }
	            });
	        };
		}
		if ($frmSchedule.length > 0) {
			getSchedule();	
		}
		function getSchedule()
		{
			var opts = {
					time: $('#schedule_time').val(),
					line_id: $('#schedule_time').data('line_id'),
					direction: $('#schedule_time').data('direction'),
				};
			$.get("index.php?controller=pjAdminTimetable&action=pjActionGetSchedule", opts).done(function (data) {
				$('#pjScheduleWrapper').html(data);
			});
		}
		if ($("#grid").length > 0 && datagrid) {
			var buttonOpts = [];
			var actionOpts = [];
			if(pjGrid.hasAccessView)
			{
				buttonOpts.push({type: "eye", target: '_blank', url: "index.php?controller=pjAdminTimetable&action=pjActionSchedule&id={:id}"});
			}
			if(pjGrid.hasAccessUpdate)
			{
				buttonOpts.push({type: "edit", url: "index.php?controller=pjAdminTimetable&action=pjActionUpdate&id={:id}"});
			}
			if(pjGrid.hasAccessDeleteSingle)
			{
				buttonOpts.push({type: "delete", url: "index.php?controller=pjAdminTimetable&action=pjActionDeleteTimetable&id={:id}"});
			}
			if(pjGrid.hasAccessDeleteMulti)
			{
				actionOpts.push({text: myLabel.delete_selected, url: "index.php?controller=pjAdminTimetable&action=pjActionDeleteTimetableBulk", render: true, confirmation: myLabel.delete_confirmation});
			}
			
			var $grid = $("#grid").datagrid({
				buttons: buttonOpts,
				columns: [
				          {text: myLabel.line, type: "text", sortable: true, editable: false},
				          {text: myLabel.location, type: "text", sortable: false, editable: false},
				          {text: myLabel.status, type: "toggle", sortable: true, editable: pjGrid.hasAccessUpdate, positiveLabel: myLabel.active, positiveValue: "T", negativeLabel: myLabel.inactive, negativeValue: "F"}
				         ],
				dataUrl: "index.php?controller=pjAdminTimetable&action=pjActionGetTimetable",
				dataType: "json",
				fields: ['line', 'direction', 'status'],
				paginator: {
					actions: actionOpts,
					gotoPage: true,
					paginate: true,
					total: true,
					rowCount: true
				},
				saveUrl: "index.php?controller=pjAdminTimetable&action=pjActionSaveTimetable&id={:id}",
				select: {
					field: "id",
					name: "record[]",
					cellClass: 'cell-width-2'
				}
			});
		}
		
		$(document).on("submit", ".frm-filter", function (e) {
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
			$grid.datagrid("load", "index.php?controller=pjAdminTimetable&action=pjActionGetTimetable", content.column, content.direction, content.page, content.rowCount);
			return false;
		}).on("change", "#location_id", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			$.get(["index.php?controller=pjAdminTimetable&action=pjActionGetLines", "&location_id=", $(this).val()].join("")).done(function (data) {
				$('#pjLineWrapper').html(data);
			});
			return false;
		}).on("click", '.pjAddTime', function(e){
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var clone_text = $('#pjTimeClone').html(),
				index = 'new_' + Math.ceil(Math.random() * 999999);
			clone_text = clone_text.replace(/\{INDEX\}/g, index);
			clone_text = clone_text.replace(/\{TIMEPICKER\}/g, 'pjTimePicker');
			
			$('#pjTimeWrapper').append(clone_text);
			$('#pjTimeWrapper').find('.clockpicker').clockpicker({
                twelvehour: myLabel.showperiod,
                autoclose: true
            });
			$('#time_' + index).focus();
		}).on("click", ".linkRemoveRow", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $tr = $(this).closest('.pjTimeCell');
			$tr.fadeOut("slow", function () {
				$tr.remove();
			});
		}).on("change", "#schedule_time", function (e) {
			getSchedule();
		});
	});
})(jQuery_1_8_2);