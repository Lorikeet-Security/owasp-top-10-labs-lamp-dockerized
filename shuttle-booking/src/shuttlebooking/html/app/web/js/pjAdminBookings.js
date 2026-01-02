var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	$(function () {
		"use strict";
		var 
			$frmCreateBooking = $('#frmCreateBooking'),
			$frmUpdateBooking = $('#frmUpdateBooking'),
			$modalConfirmation = $("#modalConfirmation"),
			$modalSendSMS = $("#modalSendSMS"),
			select2 = ($.fn.select2 !== undefined),
			datepicker = ($.fn.datepicker !== undefined),
			datagrid = ($.fn.datagrid !== undefined);
	
		if ($('#datePickerOptions').length) {
        	$.fn.datepicker.dates['en'] = {
        		days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
    		    daysMin: $('#datePickerOptions').data('days').split("_"),
    		    daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
    		    months: $('#datePickerOptions').data('months').split("_"),
    		    monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    		    format: $('#datePickerOptions').data('format'),
            	weekStart: parseInt($('#datePickerOptions').data('wstart'), 10),
    		};
        };
		if ($frmCreateBooking.length > 0 || $frmUpdateBooking.length > 0) 
		{
			jQuery.validator.addMethod("pjNumber", function(value, element) {
				var currency_format = parseInt($(element).attr('data-currency_format'), 10);
				var regex = /^((\d+)|(\d{1,3})(\,\d{3}|)*)(\.\d{1,2}|)$/;
				if(currency_format == 1)
				{
					regex = /^((\d+)|(\d{1,3})(\,\d{3}|)*)(\.\d{1,2}|)$/;
				}else if(currency_format == 2){
					regex = /^((\d+)|(\d{1,3})(\ \d{3}|)*)(\.\d{1,2}|)$/;
				}else if(currency_format == 3){
					regex = /^((\d+)|(\d{1,3})(\.\d{3}|)*)(\,\d{1,2}|)$/;
				}else if(currency_format == 4){
					regex = /^((\d+)|(\d{1,3})(\ \d{3}|)*)(\,\d{1,2}|)$/;
				}
				if(regex.test(value))
				{
					return true;
				}else{
					if(currency_format == 3 || currency_format == 4)
					{
						regex = /^((\d+)|(\d{1,3})(\\d{3}|)*)(\.\d{1,2}|)$/;
						if(regex.test(value))
						{
							return true;
						}else{
							return false;
						}
					}else{
						return false;
					}
				}
			});
			$.validator.addMethod('positiveNumber', function (value) { 
				return Number(value) >= 0;
			}, myLabel.positive_number);
			
			$.validator.addMethod('maximumNumber', function (value, element) { 
				var data = parseInt($(element).attr('data-value'), 10);
				if(Number(value) > data)
				{
					return false;
				}else{
					return true;
				}
			}, myLabel.max_number);
			if ($('.clockpicker').length) {
	        	$('.clockpicker').clockpicker({
	                twelvehour: myLabel.showperiod,
	                autoclose: true,
	                afterDone: function() {
	                	   
	                }
	            });
	        };
			if($('#client_id').length == 0)
			{
				$('.clientRequired').addClass('required');
			}
			$frmCreateBooking.validate({
				
			});
			$frmUpdateBooking.validate({
				rules:{
					uuid: {
						required: true,
						remote: "index.php?controller=pjAdminBookings&action=pjActionCheckID&id=" + $frmUpdateBooking.find("input[name='id']").val()
					}
				},
				messages:{
					uuid: {
						remote: myLabel.duplicated_id
					}
				},
			});
			
			if($(".touchspin3").length > 0)
			{
				$(".touchspin3").TouchSpin({
					verticalbuttons: true,
		            buttondown_class: 'btn btn-white',
		            buttonup_class: 'btn btn-white',
		            max: 4294967295,
		            min: 1
		        });
			}
			if($('.i-checks').length > 0)
			{
				$('.i-checks').iCheck({
		            checkboxClass: 'icheckbox_square-green',
		            radioClass: 'iradio_square-green'
		        });
				$('input').on('ifChanged', function (event) { $(event.target).trigger('change'); });
			}
			
	        if ($('.datepick').length > 0) {
	        	$('.datepick').datepicker({autoclose: true}).on('changeDate', function (selected) {
	        		
	            });
	        }
	        if (select2 && $(".select-item").length) {
	            $(".select-item").select2({
	            	placeholder: "-- " + myLabel.choose + " --",
	                allowClear: true
	            });
	        };
		}
		function formatStatus (str, obj) {
			switch (obj.status)
            {
                case 'confirmed':
                	return '<div class="btn bg-confirmed btn-xs no-margins"><i class="fa fa-check"></i> ' + myLabel.confirmed + '</div>';
                    break;
                case 'pending':
                	return '<div class="btn bg-pending btn-xs no-margins"><i class="fa fa-exclamation-triangle"></i> ' + myLabel.pending + '</div>';
                    break;
                case 'cancelled':
                	return '<div class="btn bg-cancelled btn-xs no-margins"><i class="fa fa-times"></i> ' + myLabel.cancelled + '</div>'; 
                    break;
            }

			return str;
		}
		if ($("#grid").length > 0 && datagrid) {
			var buttonOpts = [];
			var actionOpts = [];
			if(pjGrid.hasDeleteMulti)
			{
				actionOpts.push({text: myLabel.delete_selected, url: "index.php?controller=pjAdminBookings&action=pjActionDeleteBookingBulk", render: true, confirmation: myLabel.delete_confirmation});
			}
			if(pjGrid.hasExport)
			{
				actionOpts.push({text: myLabel.exported, url: "index.php?controller=pjAdminBookings&action=pjActionExportBooking", render: false, ajax: false});
			}
			if(pjGrid.hasPrint)
			{
				actionOpts.push({text: myLabel.print, url: "javascript:void(0);", render: false});
			}
			if(pjGrid.hasUpdate)
			{
				buttonOpts.push({type: "edit", url: "index.php?controller=pjAdminBookings&action=pjActionUpdate&id={:id}"});
			}
			if(pjGrid.hasDeleteSingle)
			{
				buttonOpts.push({type: "delete", url: "index.php?controller=pjAdminBookings&action=pjActionDeleteBooking&id={:id}"});
			}
			
			var $grid = $("#grid").datagrid({
				buttons: buttonOpts,
				columns: [
				          {text: myLabel.client, type: "text", sortable: false},
				          {text: myLabel.transfer_date_time, type: "text", sortable: false},
				          {text: myLabel.transfer_destinations, type: "text", sortable: false},
				          {text: myLabel.status, type: "text", sortable: true, editable: false, renderer: formatStatus, applyClass: "btn btn-xs no-margin bg"}],
				dataUrl: "index.php?controller=pjAdminBookings&action=pjActionGetBooking" + pjGrid.queryString,
				dataType: "json",
				fields: ['client', 'date_time', 'pickup_dropoff', 'status'],
				paginator: {
					actions: actionOpts,
					gotoPage: true,
					paginate: true,
					total: true,
					rowCount: true
				},
				saveUrl: "index.php?controller=pjAdminBookings&action=pjActionSaveBooking&id={:id}",
				select: {
					field: "id",
					name: "record[]",
					cellClass: 'cell-width-2'
				}
			});
		}
		
		$(document).on("click", ".pj-button-detailed, .pj-button-detailed-arrow", function (e) {
			e.stopPropagation();
			$(".pj-form-filter-advanced").toggle();
		}).on("submit", ".frm-filter-advanced", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var obj = {},
				$this = $(this),
				arr = $this.serializeArray(),
				content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache");
			for (var i = 0, iCnt = arr.length; i < iCnt; i++) {
				obj[arr[i].name] = arr[i].value;
			}
			$.extend(cache, obj);
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjAdminBookings&action=pjActionGetBooking", "created", "DESC", content.page, content.rowCount);
			return false;
		}).on("reset", ".frm-filter-advanced", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			$(".pj-button-detailed").trigger("click");
			$('#pickup_id').val('');
			$('#search_dropoff_id').val('');
			$('#date').val('');
			$('#email').val('');
			$('#name').val('');
			$('#phone').val('');
			var obj = {},
				$this = $(this),
				arr = $this.serializeArray(),
				content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache");
			for (var i = 0, iCnt = arr.length; i < iCnt; i++) {
				obj[arr[i].name] = arr[i].value;
			}
			cache.q = "";
			$.extend(cache, obj);
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjAdminBookings&action=pjActionGetBooking", "id", "DESC", content.page, content.rowCount);
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
				date: "",
				dropoff_id: "",
				location_id: "",
				name: "",
				phone: "",
				email: ""
			});
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjAdminBookings&action=pjActionGetBooking", "created", "DESC", content.page, content.rowCount);
			return false;
		}).on("change", "#filter_status", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this),
				content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache"),
				obj = {};
			obj.status = $this.val();
			$.extend(cache, obj);
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjAdminBookings&action=pjActionGetBooking", "created", "DESC", content.page, content.rowCount);
			return false;
		}).on("change", "#location_id", function (e) {
			getDropoff();
			if($(this).val() != '')
			{
				$(this).valid();
			}
		}).on("change", "input[name='traveling']", function (e) {
			getLines();
			var traveling = $('input[name=traveling]:checked' ).val();
			$('.trLocationLabel').hide();
			$('.trLocation-'+traveling).show();
			if($('#has_return').is(':checked'))
			{
				getReturnLines();
			}
		}).on("change", "#dropoff_id", function (e) {
			getLines();
			if($('#has_return').is(':checked'))
			{
				getReturnLines();
			}
			if($(this).val() != '')
			{
				$(this).valid();
			}
		}).on("change", "#line_id", function (e) {
			getAvailTimes();
			if($(this).val() != '')
			{
				$(this).valid();
			}
		}).on("change", "#return_line_id", function (e) {
			if($('#has_return').is(':checked'))
			{
				getReturnAvailTimes();
			}
			if($(this).val() != '')
			{
				$(this).valid();
			}
		}).on("click", "#has_return", function (e) {
			if($(this).is(':checked'))
			{
				$('#trReturnWrapper').show();
				$('#return_date').addClass('required');
				$('#return_line_id').addClass('required');
				$('#return_booking_time').addClass('required');
				getReturnLines();
			}else{
				$('#trReturnWrapper').hide();
				$('#return_date').val("").removeClass('required');
				$('#return_line_id').val("").removeClass('required');
				$('#return_booking_time').val("").removeClass('required');
				$('#sub_total').attr("data-return_price", '0');
			}
			calPrice();
		}).on("change", "#passengers", function (e) {
			calPrice();
		}).on("change", ".onoffswitch-client .onoffswitch-checkbox", function (e) {
			if ($(this).prop('checked')) {
                $('.current-client-area').hide();
                $('.current-client-area').find('.fdRequired').removeClass('required');
                $('.new-client-area').show();
                $('.new-client-area').find('.fdRequired').addClass('required');
            }else {
                $('.current-client-area').show();
                $('.current-client-area').find('.fdRequired').addClass('required');
                $('.new-client-area').hide();
                $('.new-client-area').find('.fdRequired').removeClass('required');
                $('#c_email').val("").valid();
            }
		}).on("change", "#pickup_id", function (e) {
			$.get("index.php?controller=pjAdminBookings&action=pjActionGetDropoff", {
				location_id: $(this).val(),
				for_search: 1
			}).done(function (data) {
				$("#trDropoffContainer").html(data);
			});	
		}).on("change", "#status", function (e) {
			var $pjFdPriceWrapper = $('#pjFdPriceWrapper');
			var value = $("#status option:selected").val();
			var text = $("#status option:selected").text();
			var bg_class = 'bg-' + value;
			if(value == 'not_confirmed')
			{
				bg_class = 'bg-cancelled';
			}
			$pjFdPriceWrapper.find('.panel-heading').removeClass("bg-pending").removeClass("bg-cancelled").removeClass("bg-confirmed").addClass(bg_class);
			$pjFdPriceWrapper.find('.status-text').html(text);
		});
		
		$("#grid").on("click", 'a.pj-paginator-action:last', function (e) {
			e.preventDefault();
			var booking_id = $('.pj-table-select-row:checked').map(function(e){
				 return $(this).val();
			}).get();
			if(booking_id != '' && booking_id != null)
			{
				window.open('index.php?controller=pjAdminBookings&action=pjActionPrint&record=' + booking_id,'_blank');
			}	
			return false;
		});
		function getDropoff()
		{
			$.get("index.php?controller=pjAdminBookings&action=pjActionGetDropoff", {
				location_id: $('#location_id').val()
			}).done(function (data) {
				$("#trDropoffContainer").html(data);
				getLines();
				if($('#has_return').is(':checked'))
				{
					getReturnLines();
				}
			});	
		}
		function getLines()
		{
			if($('#dropoff_id').val() != '')
			{
				var opts = {
						location_id: $('#location_id').val(),
						dropoff_id: $('#dropoff_id').val(),
						passengers: $('#passengers').val()
					};
				$.get("index.php?controller=pjAdminBookings&action=pjActionGetLines", opts).done(function (data) {
					$('#trLineWrapper').html(data);
					getAvailTimes();
				});	
			}
		}
		function getAvailTimes()
		{
			var $form = $('#location_id').closest('form');
			var id = null;
			if($form.find('input[name="id"]').length > 0)
			{
				id = $form.find('input[name="id"]').val();
			}
			var opts = {
					location_id: $('#location_id').val(),
					dropoff_id: $('#dropoff_id').val(),
					line_id: $('#line_id').val(),
					booking_date: $('#booking_date').val(),
					passengers: $('#passengers').val(),
					traveling: $('input[name=traveling]:checked').val(),
					id: id
				};
			$.get("index.php?controller=pjAdminBookings&action=pjActionGetTimes", opts).done(function (data) {
				$('#trTimeWrapper').html(data.timetable);
				$('#sub_total').attr('data-price', data.price_per_person);
				if(parseInt(data.duration, 10) > 0)
				{
					$('#tr_duration').html(data.duration_text);
				}else{
					$('#tr_duration').html("");
				}
				if(parseFloat(data.price_per_person) > 0)
				{
					$('#tr_price_per_person').html(data.price_per_person_format).parent().parent().show();
				}else{
					$('#tr_price_per_person').html("").parent().parent().hide();
				}
				calPrice();
			});	
		}
		function getReturnLines()
		{
			if($('#dropoff_id').val() != '')
			{
				var opts = {
						location_id: $('#location_id').val(),
						dropoff_id: $('#dropoff_id').val(),
						has_return: 1
					};
				$.get("index.php?controller=pjAdminBookings&action=pjActionGetLines", opts).done(function (data) {
					$('#trReturnLineWrapper').html(data);
					getReturnAvailTimes();
				});	
			}
		}
		function getReturnAvailTimes()
		{
			var $form = $('#location_id').closest('form');
			var id = null;
			if($form.find('input[name="id"]').length > 0)
			{
				id = $form.find('input[name="id"]').val();
			}
			var opts = {
					location_id: $('#location_id').val(),
					dropoff_id: $('#dropoff_id').val(),
					line_id: $('#return_line_id').val(),
					booking_date: $('#return_date').val(),
					passengers: $('#passengers').val(),
					traveling: $('input[name=traveling]:checked').val() == 'from' ? 'to' : 'from',
					has_return: 1,
					id: id
				};
			$.get("index.php?controller=pjAdminBookings&action=pjActionGetTimes", opts).done(function (data) {
				$('#trReturnTimeWrapper').html(data.timetable);
				$('#sub_total').attr('data-return_price', data.price_per_person);
				if(parseInt(data.duration, 10) > 0)
				{
					$('#tr_return_duration').html(data.duration_text);
				}else{
					$('#tr_return_duration').html("");
				}
				if(parseFloat(data.price_per_person) > 0)
				{
					$('#tr_return_price_per_person').html(data.price_per_person_format).parent().parent().show();
				}else{
					$('#tr_return_price_per_person').html("").parent().parent().hide();
				}
				calPrice();
			});	
		}
		function calPrice()
		{
			var $form = null;
			if($frmCreateBooking.length > 0)
			{
				$form = $frmCreateBooking;
			}
			if($frmUpdateBooking.length > 0)
			{
				$form = $frmUpdateBooking;
			}
			var price_per_person = 0;
			var return_price_per_person = 0;
			
			var attr_price = $('#sub_total').attr('data-price');
			var attr_return_price = $('#sub_total').attr('data-return_price');
			
			if (typeof attr_price !== 'undefined' && attr_price !== false) 
			{
				price_per_person = attr_price;
			}
			if (typeof attr_return_price !== 'undefined' && attr_return_price !== false) 
			{
				return_price_per_person = attr_price;
			}
			
			$form.find('input[name="price_per_person"]').val(price_per_person);
			$form.find('input[name="return_price_per_person"]').val(return_price_per_person);
			
			$.post("index.php?controller=pjAdminBookings&action=pjActionGetPrices", $form.serialize()).done(function (data) {
				$('#sub_total').val(data.sub_total);
				$('#tax').val(data.tax);
				$('#total').val(data.total);
				$('#deposit').val(data.deposit);
				
				$('#sub_total_label').html(data.sub_total_format);
				$('#tax_label').html(data.tax_format);
				$('#total_label').html(data.total_format);
				$('#deposit_label').html(data.deposit_format);
			});
		}
		
		if ($modalConfirmation.length > 0) {
            $modalConfirmation.on("show.bs.modal", function(e) {
                var link = $(e.relatedTarget);

                $(this).find(".modal-body").load(link.attr("href"), function (e) {
                    var $frmConfirmation = $('form', $modalConfirmation);

                    if ($modalConfirmation.find('.multilang').length) {
                    	var locale = $frmConfirmation.data("locale"),
                    		$el = $modalConfirmation.find('.pj-form-langbar-item[data-index="' + locale + '"]');
                    	if ($el.length) {
                    		$el.trigger('click');
                    	} else {
                    		$modalConfirmation.find('.pj-form-langbar-item[data-index]:first').trigger('click');                    		
                    	}
                    }
                    
                    $frmConfirmation.validate({
                        ignore: "",
                        submitHandler: function(e) {
                            $.post("index.php?controller=pjAdminBookings&action=pjActionConfirmation", $frmConfirmation.serialize()).done(function (resp) {
                                if (resp.code !== undefined && parseInt(resp.code, 10) === 200) {
                                    $modalConfirmation.modal('hide');
                                    swal("Success!", resp.text, "success");
                                } else {
                                    swal("Error!", resp.text, "error");
                                }
                            });
                        }
                    });

                    attachTinyMce.call(null);
                });
            }).on('click', '.btn-primary', function (e) {
                $modalConfirmation.find('form').trigger('submit');
            });
		}
		
		if ($modalSendSMS.length > 0) {
			$modalSendSMS.on("show.bs.modal", function(e) {
                var link = $(e.relatedTarget);

                $(this).find(".modal-body").load(link.attr("href"), function (e) {
                    var $frmSendSMS = $('form', $modalSendSMS);

                    $frmSendSMS.validate({
                        ignore: "",
                        submitHandler: function(e) {
                            $.post("index.php?controller=pjAdminBookings&action=pjActionSendSms", $frmSendSMS.serialize()).done(function (resp) {
                                if (resp.code !== undefined && parseInt(resp.code, 10) === 200) {
                                	$modalSendSMS.modal('hide');
                                    swal("Success!", resp.text, "success");
                                } else {
                                    swal("Error!", resp.text, "error");
                                }
                            });
                        }
                    });
                });
            }).on('click', '.btn-primary', function (e) {
            	$modalSendSMS.find('form').trigger('submit');
            });
		}
		
		function attachTinyMce(options) {
			
			if (window.tinyMCE !== undefined) {				
				tinymce.EditorManager.editors = [];
				var defaults = {
                    relative_urls : false,
                    remove_script_host : false,
                    convert_urls : true,
                    selector: "textarea#mceEditor",
                    theme: "modern",
                    browser_spellcheck : true,
                    contextmenu: false,
                    height: 330,
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
                    image_advtab: true,
                    menubar: "file edit insert view table tools",
                    setup: function (editor) {
                        editor.on('change', function (e) {
                            editor.editorManager.triggerSave();
                        });
                    }
                };

				var settings = $.extend({}, defaults, options);

				tinymce.init(settings);
			}
		}
	});
})(jQuery_1_8_2);