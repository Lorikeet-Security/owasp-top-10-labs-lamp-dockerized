(function ($, undefined) {
	$(function () {
		var $frmStep0 = $('#frmStep0'),
            $frmStep1 = $('#frmStep1'),
			$frmStep2 = $('#frmStep2'),
			$frmStep3 = $('#frmStep3'),
			$frmStep4 = $('#frmStep4'),
			$frmStep5 = $('#frmStep5'),
			$frmStep6 = $('#frmStep6'),
			$frmChangeLogin = $('#frmChangeLogin'),
			$frmChange = $('#frmChange'),
			validate = ($.fn.validate !== undefined);

		if (validate) {
			$.validator.setDefaults({
                ignore: "",
                onkeyup: false,
				errorPlacement: function (error, element)
                {
                    element.before(error);
                },
                submitHandler: function (form) {
				    disableButtons();

                    return true;
                }
			});
		}

		var stepOpts = {
		    startIndex: 0,
		    headerTag: "h2",
            bodyTag: "fieldset",
            enableKeyNavigation: true,
            labels: {
                next: "Continue",
                previous: "Back"
            },
            onInit: function (event, currentIndex) {
		        var $prev = $('[href="#previous"]'),
		            $next = $('[href="#next"]');
		        if ($prev.length > 0)
                {
                    $prev.attr('tabindex', 98);
                }
                if ($next.length > 0)
                {
                    $next.attr('tabindex', 99);
                }
            },
            onStepChanging: function (event, currentIndex, newIndex)
            {
                if($('.actions ul li.btnDisabled').length)
                {
                    return false;
                }

                // Previous step
                if (currentIndex > newIndex)
                {
                    disableButtons();
                    var step = newIndex + 1;
                    window.location = 'index.php?controller=pjInstaller&action=pjActionStep' + step;
                    return false;
                }

                var form = $(this);

                form.submit();
            }
        };

		if ($frmStep0.length && validate) {
            $frmStep0.steps(stepOpts);
        }
		
		if ($frmStep1.length && validate) {
		    $.validator.addMethod("version", function (value, element, param) {
				if (value.length !== 1) {
					return false;
				}
				return value === "1";
			}, "The system does not support minimum software requirements");

		    var rules = {
                php_version: "version",
                php_session: "version",
                dependencies: "version",
                system: "version"
            };

            if ($("input[name='mysql_version']").length) {
                rules.mysql_version = "version";
            }

		    $frmStep1.steps(stepOpts).validate({
				rules: rules
			});
		}
		if ($frmStep2.length && validate) {
			
			$.validator.addMethod("prefix", function (value, element, param) {
				if (value.length == 0) {
					return true;
				}
				if (value.length > 30) {
					return false;
				}
				var re = /\.|\/|\\|\s|\W/;
				return !re.test(value)
			}, "Prefix must be no more than 30 characters long and could contain only digits, letters, and '_'");

			$frmStep2.steps($.extend(stepOpts, {
				startIndex: 1
			})).validate({
                rules: {
					prefix: "prefix"
				}
			});
		}
		
		if ($frmStep3.length && validate) {
		    $frmStep3.steps($.extend(stepOpts, {
				startIndex: 2
			})).validate();
		}
		
		if ($frmStep4.length && validate) {
		    $frmStep4.steps($.extend(stepOpts, {
				startIndex: 3
			})).validate({
                rules: {
					admin_email: {
						required: true,
						email: true
					},
					admin_password: "required"
				}
			});
		}
		
		function enableButtons() {
			$('.actions ul li').removeClass('disabled btnDisabled');
		}

		function disableButtons() {
		    $('.actions ul li').addClass('disabled btnDisabled');
		}
		
		if ($frmStep5.length && validate) {
		    $frmStep5.steps($.extend(stepOpts, {
				startIndex: 4,
                labels: {
                    next: "Install",
                    previous: "Back"
                }
			})).validate({
                submitHandler: function(form) {
                    disableButtons();

					$(".alert").hide().find("p").html("");
					$(form).find('tr').removeClass('text-info').removeClass('text-danger').addClass('text-muted');
					var $ready = $(form).find("table .fa");
					$ready.removeClass('fa-spinner fa-spin').removeClass('fa-times').addClass('fa-check');

					$ready.eq(0).addClass("fa-spinner fa-spin");
					$.post("index.php?controller=pjInstaller&action=pjActionSetConfig&install=1").done(function (data) {
						if (data.code == 200) {
						    $ready.eq(0).closest('tr').removeClass('text-muted').addClass('text-info');
							$ready.eq(0).removeClass("fa-spinner fa-spin").addClass("fa-check");
							$ready.eq(1).addClass("fa-spinner fa-spin");
							$.post("index.php?controller=pjInstaller&action=pjActionSetDb&install=1").done(function (data) {
								if (data.code == 200) {
									$ready.eq(1).closest('tr').removeClass('text-muted').addClass('text-info');
									$ready.eq(1).removeClass("fa-spinner fa-spin").addClass("fa-check");
									form.submit();
								} else {
									$ready.eq(1).closest('tr').removeClass('text-muted').addClass('text-danger');
									$ready.eq(1).removeClass('fa-spinner fa-spin').addClass('fa-times');
									enableButtons();
									$(".alert").find("p").html(data.text).end().show();
								}
							}).fail(function () {
								enableButtons();
							});
						} else {
							$ready.eq(0).closest('tr').removeClass('text-muted').addClass('text-danger');
							$ready.eq(0).removeClass('fa-spinner fa-spin').addClass('fa-times');
							enableButtons();
							$(".alert").find("p").html(data.text).end().show();
						}
					}).fail(function () {
						enableButtons();
					});
				}
			});
		}

		if ($frmStep6.length) {
		    $frmStep6.steps($.extend(stepOpts, {
				startIndex: 5,
                onStepChanging: function (event, currentIndex, newIndex)
                {
                    return false;
                },
                onFinishing: function (event, currentIndex) {
                    window.location = 'index.php?controller=pjBase&action=pjActionLogin';
                }
			}));
		}
		
		if ($frmChangeLogin.length && validate) {
			$frmChangeLogin.on('click', '.i-captcha', function () {
				var $this = $(this);
				$this.attr('src', $this.attr('src').replace(/rand=\d+/, 'rand=' + Math.floor(Math.random() * 9999)));
			}).validate({
				rules: {
					email: {
						required: true,
						email: true
					},
					captcha: {
						required: true,
						maxlength: 6,
						remote: "index.php?controller=pjInstaller&action=pjActionCheckCaptcha"
					}
				}
			});
		}
		
		if ($frmChange.length && validate) {
			$frmChange.on('click', '.changeDomain', function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var $box = $('.boxDomain'),
					$input = $('input[name="change_domain"]');
				if ($box.is(':visible')) {
					$box.hide();
					$input.val('0');
				} else {
					$box.show();
					$input.val('1');
				}
				return false;
			}).on('click', '.changeMySQL', function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var $box = $('.boxMySQL'),
					$input = $('input[name="change_db"]');
				if ($box.is(':visible')) {
					$box.hide();
					$input.val('0');
				} else {
					$box.show();
					$input.val('1');
				}
				return false;
			}).validate({
                ignore: ':hidden',
				rules: {
					new_domain: "required",
					hostname: "required",
					username: "required",
					database: "required"
				}
			});
		}
		
	});
})(jQuery);