var jQuery_1_8_2 = jQuery_1_8_2 || jQuery.noConflict();
(function ($, undefined) {
	$(function () {
		var validate = ($.fn.validate !== undefined),
			spinner = ($.fn.spinner !== undefined),
			multilang = ($.fn.multilang !== undefined),
			datagrid = ($.fn.datagrid !== undefined),
			$document = $(document),
			$frmSms = $('#frmSms');
		
		if ($frmSms.length && validate) {
			$frmSms.validate({
				submitHandler: function (form) {
					var l = Ladda.create( $(form).find(":submit").get(0) );
					l.start();
					return true;
				}
			});
		}
		
		if ($("#grid").length > 0 && datagrid) 
		{
			var gridOpts = {
					buttons: [],
					columns: [{text: myLabel.created, type: "text", sortable: true, editable: false},
					          {text: myLabel.number, type: "text", sortable: true, editable: false},
					          {text: myLabel.text, type: "text", sortable: true, editable: false},
					          {text: myLabel.status, type: "text", sortable: true, editable: false}
					          ],
					dataUrl: "index.php?controller=pjBaseSms&action=pjActionGetSms",
					dataType: "json",
					fields: ['created', 'number', 'text', 'status'],
					paginator: {
						actions: [],
						gotoPage: true,
						paginate: true,
						total: true,
						rowCount: true
					}
				};
				
			var $grid = $("#grid").datagrid(gridOpts);
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
			$grid.datagrid("load", "index.php?controller=pjBaseSms&action=pjActionGetSms", "id", "ASC", content.page, content.rowCount);
			return false;
		}).on("click", ".btnTestSms", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			$frmSms.find('input[name="number"]').val("");
			swal({
                title: myLabel.test_sms_title,
                html: true,
                text: "<span class='sweet-desc'>"+myLabel.test_sms_text+"</span>  <label class='col-lg-4 control-label'>"+myLabel.test_sms_number+":</label> <div class='col-lg-8'><input type='text' id='test_sms_number' name='test_sms_number' class='form-control' /></div>",
                showCancelButton: true,
                confirmButtonColor: "#11511a",
                confirmButtonText: myLabel.btn_send_sms,
                cancelButtonText: myLabel.btn_cancel,
                closeOnConfirm: false
            }, function () {
            	var number = $('#test_sms_number').val();
            	if(number != '')
        		{
            		$frmSms.find('input[name="number"]').val(number);
            		$.post("index.php?controller=pjBaseSms&action=pjActionTestSms", $frmSms.serialize(), function(data) {
        		        if(data.status == 'OK')
        	        	{
        		        	swal(data.title, data.text, "success");
        	        	}else{
        	        		swal(data.title, data.text, "warning");
        	        	}
        		    });
        		}
            });
			return false;
		}).on("click", ".btnVerify", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this);
			$.post("index.php?controller=pjBaseSms&action=pjActionVerify", $frmSms.serialize(), function(data) {
		        if(data.status == 'OK')
	        	{
		        	swal({
		                title: data.text,
		                type: "success"
		            });
	        	}else{
	        		swal({
		                title: data.text,
		                type: "warning"
		            });
	        	}
		    });
			return false;
		});
	});
})(jQuery_1_8_2);