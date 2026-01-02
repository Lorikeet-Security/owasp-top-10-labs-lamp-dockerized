var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	$(function () {
		"use strict";
		var 
			$frmGeneralReport = $('#frmGeneralReport'),
			datepicker = ($.fn.datepicker !== undefined),
			tabs = ($.fn.tabs !== undefined),
			$tabs = $("#tabs"),
			tOpt = {
				select: function (event, ui) {
					$(":input[name='tab_id']").val(ui.panel.id);
				}
			};
		
		if ($tabs.length > 0 && tabs) {
			$tabs.tabs(tOpt);
		}
		
		if ($frmGeneralReport.length > 0) {
			$frmGeneralReport.validate({
				rules: {
					"date_from":{
						required: function(){
							if($('#date_to').val() == '' && $('#location_id').val() == '' && $('#fleet_id').val() == '')
							{
								return true;
							}else{
								return false;
							}
						}
					},
					"date_to":{
						required: function(){
							if($('#date_from').val() == '' && $('#location_id').val() == '' && $('#fleet_id').val() == '')
							{
								return true;
							}else{
								return false;
							}
						}
					}
				},
				errorPlacement: function (error, element) {
					error.insertAfter(element.parent());
				},
				onkeyup: false,
				errorClass: "err",
				wrapper: "em"
			});
		}
		
		$(document).on("focusin", ".datepick", function (e) {
			var minDate, 
				maxDate,
				$this = $(this),
				custom = {},
				o = {
					firstDay: $this.attr("rel"),
					dateFormat: $this.attr("rev")
				};
			switch ($this.attr("name")) {
				case "date_from":
					if($(".datepick[name='date_to']").val() != '')
					{
						maxDate = $(".datepick[name='date_to']").datepicker({
							firstDay: $this.attr("rel"),
							dateFormat: $this.attr("rev")
						}).datepicker("getDate");
						$(".datepick[name='date_to']").datepicker("destroy").removeAttr("id");
						if (maxDate !== null) {
							custom.maxDate = maxDate;
						}
					}
					break;
				case "date_to":
					if($(".datepick[name='date_from']").val() != '')
					{
						minDate = $(".datepick[name='date_from']").datepicker({
							firstDay: $this.attr("rel"),
							dateFormat: $this.attr("rev")
						}).datepicker("getDate");
						$(".datepick[name='date_from']").datepicker("destroy").removeAttr("id");
						if (minDate !== null) {
							custom.minDate = minDate;
						}
					}
					break;
			}
			$this.datepicker($.extend(o, custom));
		}).on("click", ".pj-form-field-icon-date", function (e) {
			var $dp = $(this).parent().siblings("input[type='text']");
			if ($dp.hasClass("hasDatepicker")) {
				$dp.datepicker("show");
			} else {
				$dp.trigger("focusin").datepicker("show");
			}
		}).on("change", "#location_id", function (e) {
			$('#fleet_id').val('');
		}).on("change", "#fleet_id", function (e) {
			$('#location_id').val('');
		});
	});
})(jQuery_1_8_2);