var jQuery_1_8_2 = jQuery_1_8_2 || jQuery.noConflict();
(function ($, undefined) {
	$(function () {
		var validate = ($.fn.validate !== undefined),
			$frmLogin = $('#frmLogin'),
			$frmForgot = $('#frmForgot'),
			$captchaContainer = $('#captchaContainer'),
			$document = $(document);

		if ($frmLogin.length && validate) {
			$frmLogin.validate({
				rules: {
					"login_captcha": {
					    required: true,
						remote: "index.php?controller=pjBase&action=pjActionCheckCaptcha"
					},
					"recaptcha": {
					    required: true,
						remote: "index.php?controller=pjBase&action=pjActionCheckReCaptcha"
					}
				},
				onkeyup: false,
				ignore: ':hidden:not([id^="captchaContainer"]:visible #recaptcha)',
				submitHandler: function (form) {
					var l = Ladda.create( $(form).find(":submit").get(0) );
					l.start();
					return true;
				}
			});

			$document.on( 'click', '.link-resend-password', function (e) {
			    if (e && e.preventDefault) {
                    e.preventDefault();
                }

                $.post("index.php?controller=pjBase&action=pjActionResendPassword", {
                    login_email: $(this).data('email')
                }).done(function (data) {
                    if (!(data && data.status)) {
                        swal("Error!", '', "error");
                    }
                    switch (data.status) {
                        case "OK":
                            swal("Success!", data.text, "success");
                            break;
                        case "ERR":
                            swal("Error!", data.text, "error");
                            break;
                    }
                });
            })
		}

		if ($frmForgot.length && validate) {
			$frmForgot.validate({
				rules: {
					"login_captcha": {
					    required: true,
						remote: "index.php?controller=pjBase&action=pjActionCheckCaptcha"
					},
					"recaptcha": {
					    required: true,
						remote: "index.php?controller=pjBase&action=pjActionCheckReCaptcha"
					}
				},
				onkeyup: false,
				ignore: ':hidden:not([id^="captchaContainer"]:visible #recaptcha)',
				submitHandler: function (form) {
					var l = Ladda.create( $(form).find(":submit").get(0) );
					l.start();
					return true;
				}
			});
		}

		$document.on('change', '#login_email', function (e) {
            if($(this).val() !== '')
            {
                $.get('index.php?controller=pjBase&action=pjActionCheckLoginEmail', {"login_email" : $(this).val()}).done(function (resp) {
                    if(resp)
                    {
                        if (resp.disable_form)
                        {
                            $('.alert:visible').hide();
                            $('#alertFormDisabled').html(resp.disable_form_text).show();

                            $frmLogin.find(':input,:submit').attr('disabled','disabled');
                        }
                        else if (resp.require_captcha)
                        {
                            if ($captchaContainer.length)
                            {
                                $captchaContainer.show();
                            }
                        }
                    }
                    else
                    {
                        if ($captchaContainer.length)
                        {
                            $captchaContainer.hide();
                        }
                    }
                });
            }
            else
            {
                if ($captchaContainer.length)
                {
                    $captchaContainer.hide();
                }
            }
        }).on("click", "img.captcha", function () {
        	var $this = $(this);
			$this.attr("src", $this.attr("src").replace(/(&?rand=)\d+/, "$1" + Math.ceil(Math.random() * 999999)));
        });

		if ($captchaContainer.length)
        {
            // Force temp captcha check on load because browsers pre-populate the fields on saved credentials.
            $('#login_email, #forgot_email').trigger('change');
        }
	});
})(jQuery_1_8_2);

function correctCaptcha(response) {
    var elem = jQuery_1_8_2("input[name='recaptcha']");
    elem.val(response);
    elem.valid();
}