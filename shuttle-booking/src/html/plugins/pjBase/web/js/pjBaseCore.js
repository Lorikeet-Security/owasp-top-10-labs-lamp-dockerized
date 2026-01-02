var jQuery_1_8_2 = jQuery_1_8_2 || jQuery.noConflict();
(function ($, undefined) {
	$(function () {
		"use strict";
		
		var validate = ($.fn.validate !== undefined);
		
		if (validate) {
			$.validator.setDefaults({
				highlight: function(element) {
					$(element).closest('.form-group').addClass('has-error');
				},
				unhighlight: function(element) {
					$(element).closest('.form-group').removeClass('has-error');
				},
				errorElement: 'span',
				errorClass: 'help-block',
				errorPlacement: function(error, element) {
					if (element.hasClass('select2-hidden-accessible')) {
                        error.insertAfter(element.next('.select2'));
                    } else if (element.parent('.input-group').length) {
						error.insertAfter(element.parent());
					} else if (element.parent().parent('.btn-group').length) {
                        error.insertAfter(element.parent().parent());
                    } else {
						error.insertAfter(element);
					}
			    },
                submitHandler: function (form) {
				    var ladda_buttons = $(form).find('.ladda-button');
				    if(ladda_buttons.length > 0)
                    {
                        var l = ladda_buttons.ladda();
                        l.ladda('start');
                    }
                    return true;
                }
			});
		}
		
		$.ajaxSetup({
			error: function (jqXHR, textStatus, errorThrown) {
				if (jqXHR.status === 401) {
					if (typeof swal === "function") {
						swal(errorThrown, "Authorization is required.", "error");
					}
				} else if (jqXHR.status === 403) {
					if (typeof swal === "function") {
						swal(errorThrown, "Requested operation is forbidden.", "error");
					}
				}
			}
		});
	});
})(jQuery_1_8_2);