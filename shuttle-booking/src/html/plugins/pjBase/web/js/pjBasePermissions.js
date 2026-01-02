var jQuery_1_8_2 = jQuery_1_8_2 || jQuery.noConflict();
(function ($, undefined) {
	$(function () {
		var validate = ($.fn.validate !== undefined),
			multilang = ($.fn.multilang !== undefined),
			datagrid = ($.fn.datagrid !== undefined),
			$document = $(document);
		
		
		$(document).on( 'change', '.onoffswitch-checkbox', function (e) {
			var $this = $(this);
			var id = $(this).attr('data-id');
			var type = 'insert';
			if(!$(this).is(':checked'))
			{
				type = 'delete';
			}
			var post_data = null;
			if($('#role_id').length > 0)
			{
				post_data = {
						'permission_id': id,
						'role_id': $('#role_id').val(),
						'type': type
				};
			}
			if($('#user_id').length > 0)
			{
				post_data = {
						'permission_id': id,
						'user_id': $('#user_id').val(),
						'type': type
				};
			}
			$this.prop('disabled', true);
			$('#loader').parent().addClass('sk-loading');
			$.post("index.php?controller=pjBasePermissions&action=pjActionAjaxSet", post_data).done(function (data) {
				if(type == 'insert')
				{
					$('.permission-row-' + id).show();
				}else{
					$('.permission-row-' + id).hide();
					$('.permission-row-' + id).each(function(){
						$(this).find(":checkbox").each(function(){
							var that = $(this);
							var pid = that.attr('data-id');
							that.prop("checked", false);
							if($('.permission-row-' + pid).length > 0)
							{
								$('.permission-row-' + pid).hide();
							}
						});
					});
				}
			}).always(function () {
				$this.prop('disabled', false);
				$('#loader').parent().removeClass('sk-loading');
			});
		}).on("change", "#role_id", function (e) {
			window.location.href = "index.php?controller=pjBasePermissions&action=pjActionRolePermission&id=" + $(this).val();
		}).on("click", "#btnResetPermission", function (e) {
		    if (e && e.preventDefault) {
				e.preventDefault();
			}

			var user_id = $('#user_id').val();

			swal({
                title: myLabel.reset_permission_title,
                text: myLabel.reset_permission_text,
                type: "warning",
                showCancelButton: true,
                confirmButtonText: myLabel.btn_reset,
                cancelButtonText: myLabel.btn_cancel,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function () {
                $.post("index.php?controller=pjBasePermissions&action=pjActionResetPermission", {
                    user_id: user_id
                }).done(function (data) {
                    if (!(data && data.status)) {
                        swal("Error!", '', "error");
                    }
                    switch (data.status) {
                        case "OK":
                            swal("Success!", data.text, "success");

                            setTimeout(function(){
                                window.location.href = "index.php?controller=pjBasePermissions&action=pjActionUserPermission&id=" + user_id;
                            }, 2000);
                            break;
                        case "ERR":
                            swal("Error!", data.text, "error");
                            break;
                    }
                });
            });

			return false;
		});
	});
})(jQuery_1_8_2);