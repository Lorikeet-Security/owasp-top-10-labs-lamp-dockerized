var jQuery_1_8_2 = jQuery_1_8_2 || jQuery.noConflict();
(function ($, undefined) {
	$(function () {
		"use strict";

		var validate = ($.fn.validate !== undefined),
			multilang = ($.fn.multilang !== undefined),
			$document = $(document),
			$frmGeneral = $('#frmGeneral'),
			$frmEmailSettings = $('#frmEmailSettings'),
			$frmVisual = $('#frmVisual'),
			$frmLoginProtection = $('#frmLoginProtection'),
			$frmCaptchaSpam = $('#frmCaptchaSpam'),
			$frmAPIKeys = $('#frmAPIKeys');
		
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
		
		if($('.mceEditor').length > 0)
        {
            if (window.tinyMCE !== undefined) {
                tinymce.init({
                    relative_urls : true,
                    remove_script_host : false,
                    convert_urls : true,
                    selector: "textarea.mceEditor",
                    theme: "modern",
                    browser_spellcheck : true,
                    contextmenu: false,
                    height: 350,
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
                });
            }
        }

		if ($frmGeneral.length && validate) {
			$frmGeneral.validate();
		}
		if ($frmVisual.length && validate) {
			$frmVisual.on("change", "#o_hide_footer", function () {
				var $related = $('input[name="value-string-o_footer_text"]').closest(".form-group");
				if ($(this).is(":checked")) {
					$related.addClass("hidden");
				} else {
					$related.removeClass("hidden");
				}
			}).validate();
		}
		if ($frmAPIKeys.length && validate) {
			$frmAPIKeys.validate();
		}
		if ($frmEmailSettings.length && validate) {
			$frmEmailSettings.validate({
				submitHandler: function(form){
					var $email_method = $("option:selected", $('select[name="value-enum-o_send_email"]')).val();
					if ($email_method == 'mail|smtp::smtp') {
						var ladda_buttons = $frmEmailSettings.find('.ladda-button');
					    if(ladda_buttons.length > 0)
	                    {
	                        var l = ladda_buttons.ladda();
	                        l.ladda('start');
	                    }
						swal({
			                title: myLabel.check_smtp_connection_title,
			                text: myLabel.check_smtp_connection_text,
			                type: "info",
			                showCancelButton: false,
			                showConfirmButton: false,
			                closeOnConfirm: false,
			                showLoaderOnConfirm: true
			            });						
						$.post('index.php?controller=pjBaseOptions&action=pjActionAjaxSmtp', $frmEmailSettings.find(':input[name*="-o_smtp_"]').serialize()).done(function (data) {
	            			if (data && data.status && data.status === 'OK') {
	            				form.submit();
	            			} else {
	            				swal({
	            	                title: myLabel.send_test_swal_error_title,
	            	                text: data.text,
	            	                showCancelButton: false,
	            	                confirmButtonColor: "#11511a",
	            	                confirmButtonText: myLabel.btn_ok,
	            	                closeOnConfirm: true,
	            	                showLoaderOnConfirm: false,
	            	                type: 'warning'
	            	            });
	            				if(ladda_buttons.length > 0)
	                            {
	            					l.ladda('stop');
	                            }
	            			}
	            		}).fail(function () {
	            			swal({
	        	                title: myLabel.send_test_swal_error_title,
	        	                text: myLabel.ajax_error_msg,
	        	                showCancelButton: false,
	        	                confirmButtonColor: "#11511a",
	        	                confirmButtonText: myLabel.btn_ok,
	        	                closeOnConfirm: true,
	        	                showLoaderOnConfirm: false,
	        	                type: 'warning'
	        	            });
	            			if(ladda_buttons.length > 0)
                            {
            					l.ladda('stop');
                            }
	            		});
						return false;
					} else {
						form.submit();
					}
				}
			});
		}
		if ($frmLoginProtection.length && validate) {
			$frmLoginProtection.on("change", 'select[name="value-enum-o_password_chars_used"]', function () {
				var $input = $("#o_password_capital_letter"),
					value = $(this).find("option:selected").val();
				if (/::digits$/.test(value)) {
					$input.prop("checked", false).trigger("change");
					$input.closest(".form-group").addClass("hidden");
				} else {
					$input.closest(".form-group").removeClass("hidden");
				}
			}).validate();
			
			$frmLoginProtection.find('select[name="value-enum-o_password_chars_used"]').trigger("change");
			
			if($(".field-int").length > 0)
			{
				$(".field-int").TouchSpin({
					verticalbuttons: true,
		            buttondown_class: 'btn btn-white',
		            buttonup_class: 'btn btn-white',
		            max: 4294967295
		        });
			}
		}
		if ($frmCaptchaSpam.length && validate) {
			$frmCaptchaSpam.validate();
			if($(".field-int").length > 0)
			{
				$(".field-int").TouchSpin({
					verticalbuttons: true,
		            buttondown_class: 'btn btn-white',
		            buttonup_class: 'btn btn-white',
		            min: 1,
		            max: 12,
		            step: 1
		        });
			}
			if($(".select-patterns").length > 0)
			{
				$(".select-patterns").select2({
					templateResult: formatData,
					templateSelection: formatData,
		        });
			}
		}
		function smtpSettings() {
			var $email_method = $("option:selected", $('select[name="value-enum-o_send_email"]')).val(),
				$is_checked = $('input[name="o_smtp_seder_email_same_as_username"]').is(":checked");
			$('input[name="value-string-o_sender_email"]').attr('readonly', false);
			$('.smtpRequiredFields').removeClass('required');
			if ($email_method == 'mail|smtp::smtp') {
				$('.smtpRequiredFields').addClass('required');
				if ($is_checked) {
	            	var $smtp_username = $('input[name="value-string-o_smtp_user"]').val();
	            	$('input[name="value-string-o_sender_email"]').val($smtp_username);
	            	$('input[name="value-string-o_sender_email"]').attr('readonly', true);
            	}
			}
		}
		function formatData (data) {
            if (data.id == 'plain') { 
            	return data.text; 
            }
            var $result= $('<span><img style="width: 50px;" src="'+myLabel.img_path + data.id +'"/> ' + data.text + '</span>');
            return $result;
        };
		$document.on('change', '.onoffswitch-checkbox', function (e) {
			var name = $(this).attr('name'),
                is_checked = $(this).is(':checked');
			if(is_checked)
			{
				$('input[name="value-enum-'+name+'"]').val('Yes|No::Yes');
				if(name == 'o_secure_login_2factor_auth')
                {
                    $('.boxTwoFactor').show();
                    $('.boxTwoFactor select').trigger('change');
                }
			}else{
				$('input[name="value-enum-'+name+'"]').val('Yes|No::No');
				if(name == 'o_secure_login_2factor_auth')
                {
                    $('.boxTwoFactor, .boxTwoFactorEmail, .boxTwoFactorSMS').hide();
                }
			}

			if(name == 'o_forgot_email_confirmation')
            {
                $('.boxForgotEmail').toggle(is_checked);
            }
            else if(name == 'o_forgot_sms_confirmation')
            {
                $('.boxForgotSMS').toggle(is_checked);
            }else if(name == 'o_forgot_contact_admin')
            {
                $('.boxContactAdminEmail').toggle(is_checked);
            }else if(name == 'o_failed_login_send_email')
            {
                $('.boxLoginFailedEmail').toggle(is_checked);
            }else if(name == 'o_failed_login_send_sms')
            {
                $('.boxLoginFailedSMS').toggle(is_checked);
            } else if(name == 'o_smtp_seder_email_same_as_username') {
            	smtpSettings();
            }
		}).on('change', '.boxTwoFactor select', function (e) {
			var value = $(this).val(),
				isSms = value === 'email|sms::sms';
            
			$('.boxTwoFactorEmail').toggle(value === 'email|sms::email');
            $('.boxTwoFactorSMS').toggle(isSms);
            
            if (isSms) {
            	$(".box-sms-warning").removeClass("hidden");
            } else {
            	$(".box-sms-warning").addClass("hidden");
            }
            
		}).on('click', '.theme', function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this),
				theme = $this.data('theme');
			
			$.post('index.php?controller=pjBaseOptions&action=pjActionUpdateTheme', {
				"theme": theme
			}).done(function (data) {
				if (data && data.status && data.status == 'OK') {
					$('.theme').removeClass('active');
					$this.addClass('active');
					
					var href,
						$head = $("head"),
						$current = $head.find('link[href*="/css/themes/theme"]');
					if ($current.length) {
						href = $current.attr("href");
						$current.remove();
						
						$("<link>", {
							"rel": "stylesheet",
							"href": href.replace(/\/css\/themes\/theme\d+\.css/, '/css/themes/' + theme + '.css')
						}).appendTo($head);
					}
				}
			});
		}).on("change", "select[name='value-enum-o_captcha_location']", function (e) {
			switch ($("option:selected", this).val()) {
			case 'admin|front::admin':
				$(".boxFrontEnd").hide();
				$(".boxAdminPanel").show();
				switch ($("select[name='value-enum-o_captcha_type']").val()) {
				case 'system|google::system':
					$(".boxCaptchaSystemAdmin").show();
					$(".boxCaptchaGoogleAdmin").hide();
					break;
				case 'system|google::google':
					$(".boxCaptchaSystemAdmin").hide();
					$(".boxCaptchaGoogleAdmin").show();
					break;
				}
				break;
			case 'admin|front::front':
				$(".boxFrontEnd").show();
				$(".boxAdminPanel").hide();
				switch ($("select[name='value-enum-o_captcha_type_front']").val()) {
				case 'system|google::system':
					$(".boxCaptchaSystemFront").show();
					$(".boxCaptchaGoogleFront").hide();
					break;
				case 'system|google::google':
					$(".boxCaptchaSystemFront").hide();
					$(".boxCaptchaGoogleFront").show();
					break;
				}
				break;
			}
		}).on("change", "select[name='value-enum-o_send_email']", function (e) {
			switch ($("option:selected", this).val()) {
				case 'mail|smtp::mail':
					$(".boxSmtp").addClass("hidden");
					break;
				case 'mail|smtp::smtp':
					$(".boxSmtp").removeClass("hidden");
					break;
			}
			smtpSettings();
		}).on("change", "select[name='value-enum-o_smtp_secure']", function (e) {			
			var $port = $('input[name="value-int-o_smtp_port"]');
			if (!$port.length) {
				return;
			}
			
			var value = $(this).find("option:selected").val();
			
			switch (true) {
			case /::none$/.test(value):
				$port.val(25);
				break;
			case /::ssl$/.test(value):
				$port.val(465);
				break;
			case /::tls$/.test(value):
				$port.val(587);
				break;
			}
		}).on("change", "input[name='value-string-o_smtp_user']", function () {			
			smtpSettings();
		}).on("change", "select[name='value-enum-o_captcha_mode']", function () {			
			switch ($(this).find("option:selected").val()) {
			case "string|addition|subtraction|random_math::string":
				$(".box-admin-length").removeClass("hidden");
				break;
			default:
				$(".box-admin-length").addClass("hidden");
			}		
		}).on("change", "select[name='value-enum-o_captcha_mode_front']", function () {			
			switch ($(this).find("option:selected").val()) {
			case "string|addition|subtraction|random_math::string":
				$(".box-front-length").removeClass("hidden");
				break;
			default:
				$(".box-front-length").addClass("hidden");
			}			
		}).on("change", "select[name='value-enum-o_captcha_type']", function (e) {
			switch ($(this).find("option:selected").val()) {
			case 'system|google::system':
				$(".box-admin-google").addClass("hidden");
				$(".box-admin-system").removeClass("hidden");
				if($('select[name="value-enum-o_captcha_mode"]').val() != 'string|addition|subtraction|random_math::string')
				{
					$(".box-admin-length").addClass("hidden");
				}
				break;
			case 'system|google::google':
				$(".box-admin-system").addClass("hidden");
				$(".box-admin-google").removeClass("hidden");
				break;
			}
		}).on("change", "select[name='value-enum-o_captcha_type_front']", function (e) {
			switch ($(this).find("option:selected").val()) {
			case 'system|google::system':
				$(".box-front-google").addClass("hidden");
				$(".box-front-system").removeClass("hidden");
				if($('select[name="value-enum-o_captcha_mode_front"]').val() != 'string|addition|subtraction|random_math::string')
				{
					$(".box-front-length").addClass("hidden");
				}
				break;
			case 'system|google::google':
				$(".box-front-system").addClass("hidden");
				$(".box-front-google").removeClass("hidden");
				break;
			}
		}).on("click", ".btnTestConnection", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this);
			swal({
                title: myLabel.test_smtp_title,
                type: "warning",
                text: myLabel.test_smtp_text,
                showCancelButton: true,
                confirmButtonColor: "#11511a",
                confirmButtonText: myLabel.btn_yes_connect,
                cancelButtonText: myLabel.btn_cancel,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function (isConfirm) {
            	if (isConfirm) {
            		var $cancelBtn = $(".sweet-alert.visible").find("button.cancel").hide();
            		$.post('index.php?controller=pjBaseOptions&action=pjActionAjaxSmtp', $this.closest('form').find(':input[name*="-o_smtp_"]').serialize()).done(function (data) {
            			$cancelBtn.show();
            			if (data && data.status && data.status === 'OK') {
            				swal('Success!', data.text, 'success');
            			} else {
            				swal({
            	                title: myLabel.send_test_swal_error_title,
            	                text: data.text,
            	                showCancelButton: false,
            	                confirmButtonColor: "#11511a",
            	                confirmButtonText: myLabel.btn_ok,
            	                closeOnConfirm: true,
            	                showLoaderOnConfirm: false,
            	                type: 'warning'
            	            });
            			}
            		}).fail(function () {
            			$cancelBtn.show();
            			swal({
        	                title: myLabel.send_test_swal_error_title,
        	                text: myLabel.ajax_error_msg,
        	                showCancelButton: false,
        	                confirmButtonColor: "#11511a",
        	                confirmButtonText: myLabel.btn_ok,
        	                closeOnConfirm: true,
        	                showLoaderOnConfirm: false,
        	                type: 'warning'
        	            });
            		});
            	}
            });
			return false;
		}).on("click", ".btnSendTestEmail", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this);
			$frmEmailSettings.find('input[name="email"]').val("");
			swal({
                title: myLabel.send_test_email_title,
                html: true,
                text: "<span class='sweet-desc'>"+myLabel.send_test_email_text+"</span>  <label class='col-lg-4 control-label'>"+myLabel.send_test_email_address+":</label> <div class='col-lg-8'><input type='email' id='email_address' name='email_address' class='form-control' /></div>",
                showCancelButton: true,
                confirmButtonColor: "#11511a",
                confirmButtonText: myLabel.btn_send_email,
                cancelButtonText: myLabel.btn_cancel,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function (isConfirm) {
            	if (isConfirm) {
            		var $cancelBtn = $(".sweet-alert.visible").find("button.cancel").hide();
            		var email_address = $('#email_address').val();
            		$frmEmailSettings.find('input[name="email"]').val(email_address);
            		$.post('index.php?controller=pjBaseOptions&action=pjActionAjaxSend', $frmEmailSettings.serialize()).done(function (data) {
            			$cancelBtn.show();
            			if (data && data.status && data.status === 'OK') {
            				swal({
            	                title: myLabel.send_test_swal_msg_title,
            	                text: data.text,
            	                showCancelButton: false,
            	                confirmButtonColor: "#11511a",
            	                confirmButtonText: myLabel.btn_ok,
            	                closeOnConfirm: true,
            	                showLoaderOnConfirm: false,
            	                type: 'success'
            	            });
            			} else {
            				swal({
            	                title: myLabel.send_test_swal_error_title,
            	                text: data.text,
            	                showCancelButton: false,
            	                confirmButtonColor: "#11511a",
            	                confirmButtonText: myLabel.btn_ok,
            	                closeOnConfirm: true,
            	                showLoaderOnConfirm: false,
            	                type: 'warning'
            	            });
            			}
            		}).fail(function () {
            			$cancelBtn.show();
            			swal({
        	                title: myLabel.send_test_swal_error_title,
        	                text: myLabel.ajax_error_msg,
        	                showCancelButton: false,
        	                confirmButtonColor: "#11511a",
        	                confirmButtonText: myLabel.btn_ok,
        	                closeOnConfirm: true,
        	                showLoaderOnConfirm: false,
        	                type: 'warning'
        	            });
            		});
            	}
            });
			return false;
		}).on("click", ".btn-verify", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var option_key = $(this).attr('data-key'),
                option_value = $('[name$="-' + option_key + '"]').val();

			$('#verify-container-' + option_key).html('');
			$.post('index.php?controller=pjAdmin&action=pjActionVerifyAPIKey', {
			    "key": option_key,
			    "value": option_value
			}).done(function (data) {
                if (data && data.status && data.status === 'OK') {
                    swal(data.text, '', 'success');
                } else {
                    swal(data.text, '', 'warning');
                }

                if (data.html)
                {
                    $('#verify-container-' + option_key).html(data.html);
                }
            }).fail(function () {
                swal(myLabel.send_test_swal_error_title, 'An unexpected error occurred.', 'warning');
            });
			return false;
		});
	});
})(jQuery_1_8_2);