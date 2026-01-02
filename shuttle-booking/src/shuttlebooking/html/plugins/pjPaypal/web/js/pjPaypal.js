var jQuery_1_8_2 = jQuery_1_8_2 || jQuery.noConflict();
(function ($, undefined) {
	$(function () {
		var $modalPaypalInfo = $("#modalPaypalInfo"),
			datagrid = ($.fn.datagrid !== undefined);

		function formatBtn(str, obj) {
			return ['<a href="#" data-id="', obj.id, '"', ' data-remote="false" data-toggle="modal" data-target="#modalPaypalInfo" class="btn btn-primary btn-outline"><i class="fa fa-eye"></i> ', myLabel.btn_view, '</a>'].join("");
		}
		
		if ($("#grid").length > 0 && datagrid) {
			var $grid = $("#grid").datagrid({
				buttons: [],
				columns: [
				    {text: myLabel.subscr_id, type: "text", sortable: true, editable: false},
				    {text: myLabel.txn_id, type: "text", sortable: true, editable: false},
				    {text: myLabel.txn_type, type: "text", sortable: true, editable: false},
				    {text: myLabel.email, type: "text", sortable: true, editable: false},
				    {text: myLabel.dt, type: "text", sortable: true, editable: false},
				    {text: "", type: "text", sortable: false, editable: false, renderer: formatBtn}
				],
				dataUrl: "index.php?controller=pjPaypal&action=pjActionGetPaypal",
				dataType: "json",
				fields: ['subscr_id', 'txn_id', 'txn_type', 'payer_email', 'dt', 'id'],
				paginator: {
					actions: [],
					gotoPage: true,
					paginate: true,
					total: true,
					rowCount: true
				},
				select: false
			});
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
			$grid.datagrid("load", "index.php?controller=pjPaypal&action=pjActionGetPaypal", "dt", "DESC", content.page, content.rowCount);
			return false;
		});
		
		if ($modalPaypalInfo.length > 0) {
            $modalPaypalInfo.on("show.bs.modal", function(e) {
                var link = $(e.relatedTarget);
                $(this).find(".modal-body").load('index.php?controller=pjPaypal&action=pjActionGetDetails&id=' + link.attr("data-id"), function (e) {

                });
            });
		}
	});
})(jQuery_1_8_2);