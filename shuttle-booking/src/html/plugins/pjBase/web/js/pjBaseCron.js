var jQuery_1_8_2 = jQuery_1_8_2 || jQuery.noConflict();
(function ($, undefined) {
	$(function () {
		var $document = $(document);

		$document.on("click", ".btn-run-now", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this);
			swal({
                title: myLabel.alert_title,
                text: myLabel.alert_text,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#11511a",
                confirmButtonText: myLabel.btn_confirm,
                cancelButtonText: myLabel.btn_cancel,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function (isConfirm) {
            	if (isConfirm) {
            		$.post('index.php?controller=pjBaseCron&action=pjActionExecute', {
            			"id" : $this.data('id')
            		}).done(function (data) {
            			swal.close();
            			if (data && data.status && data.status === 'OK') {
            				window.location.reload(true);
            			}
            		}).fail(function () {
            			swal.close();
            		});
            	}
            });
			return false;
		});
	});
})(jQuery_1_8_2);