(function ($, undefined) {
    $(function () {
    	"use strict";
    	var validate = ($.fn.validate !== undefined),
	        multilang = ($.fn.multilang !== undefined),
	        $document = $(document);
    	
    	if (multilang && 'pjBaseLocale' in window) {
			$(".multilang").multilang({
				langs: pjBaseLocale.langs,
				flagPath: pjBaseLocale.flagPath,
				tooltip: "",
				select: function (event, ui) {
					$("input[name='locale_id']").val(ui.index);
				}
			});
		}
    	
    	$document.on("change", 'select[name^="plugin_payment_options["][data-box]', function (e) {
            var box = $('[class="' + $(this).attr('data-box') + '"]'),
                is_active = parseInt($(this).val(), 10) == 1;
            box.toggle(is_active);
            box.find('input:not(.optional-po)').toggleClass('required', is_active);
            box.find('input[name$="merchant_email]"]').toggleClass('email', is_active);
        }).on("click", ".paymentLink", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var select_locale_id = null;
			var payment_method = $(this).attr('data-method');
			$('.pj-form-langbar-item').each(function(){
				if($(this).hasClass('btn-primary'))
				{
					select_locale_id = $(this).attr('data-index');
				}
			});
			$.get("index.php?controller=pjPayments&action=pjActionPaymentOptions", {
				"payment_method": payment_method
			}).done(function (data) {
				$('#modalContent').html(data);
				if (multilang && typeof pjBaseLocale != "undefined")
				{
					var $multilangWrap = $('#modalContent').find('.pj-multilang-wrap');
					$multilangWrap.each(function(e){
						var locale_id = $(this).attr('data-index');
						if(locale_id == select_locale_id)
						{
							$(this).show();
						}else{
							$(this).hide();
						}
					})
				}
				$('#paymentModal').modal('show');
			});
			return false;
		}).on("click", "#btnSavePaymentOptions", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			$.post("index.php?controller=pjPayments&action=pjActionPaymentOptions", $('#frmPaymentOptions').serialize()).done(function (data) {
				$('#paymentModal').modal('hide');
				window.location.href = "index.php?controller=pjPayments&action=pjActionIndex";
			});
			return false;
		}).on( 'change', '#enablePayment', function (e) {
			if ($(this).prop('checked')) {
                $('.hidden-area').show();
                $('#payment_is_active').val(1);
                $("#enableTestMode").trigger("change");
            }else {
                $('.hidden-area').hide();
                $('#payment_is_active').val(0);
            }
		}).on("change", "#enableTestMode", function (e) {
			if ($(this).is(":checked")) {
                $(".test-area").show();
                $(".live-area").hide();
                $("#payment_is_test_mode").val(1);
            } else {
                $(".test-area").hide();
                $(".live-area").show();
                $("#payment_is_test_mode").val(0);
            }
		});
    });
})(jQuery_1_8_2);