var jQuery_1_8_2 = jQuery_1_8_2 || jQuery.noConflict();
(function ($, undefined) {
	$(function () {
		var datagrid = ($.fn.datagrid !== undefined),
			dialog = ($.fn.dialog !== undefined),
			$grid,
			$gridFrontend = $("#grid-frontend"),
			$gridBackend = $("#grid-backend"),
			$gridLocales = $("#grid-locales"),
			urlLocales = "index.php?controller=pjBaseLocale&action=pjActionGetLocale",
			urlFrontend = "index.php?controller=pjBaseLocale&action=pjActionGetLabels&type=frontend",
			urlBackend = "index.php?controller=pjBaseLocale&action=pjActionGetLabels&type=backend",
			$frmUpdateShowID = $("#frmUpdateShowID"),
			$dialogShowID = $("#dialogShowID");
		
	    if ($dialogShowID.length && dialog) {
	    	$dialogShowID.dialog({
				modal: true,
				autoOpen: false,
				resizable: false,
				draggable: false,
				width: 400,
				buttons: (function () {
					var buttons = {};
					buttons[myLabel.btnConfirm] = function () {
						$frmUpdateShowID.submit();
					};
					buttons[myLabel.btnCancel] = function () {
						$('#show_id').attr('checked', false);
						$dialogShowID.dialog("close");
					};
					return buttons;
				})()
			});
		}
	    
	    $("#show_id").on('change', function () {
	    	var $this = $(this);
	    	if ($this.is(":checked")) {
	    		swal({
	    			  title: $frmUpdateShowID.data("title"),
	    			  text: $frmUpdateShowID.data("text"),
	    			  type: "warning",
	    			  showCancelButton: true,
	    			  confirmButtonText: $frmUpdateShowID.data("confirm"),
	    			  cancelButtonText: $frmUpdateShowID.data("cancel"),
	    			  closeOnConfirm: false
	    		}, function (confirm) {
	    			if (confirm) {
	    				swal.close();
	    				$frmUpdateShowID.trigger("submit");
	    			} else {
	    				$this.prop("checked", false);
	    			}
	    		});
	    	} else {
	    		$frmUpdateShowID.trigger("submit");
	    	}
	    });
				
		if ($gridLocales.length && datagrid) {
			
			function formatImage (str, obj) {
				var custom = (obj.flag != null && obj.flag !== ""),
					src = custom ? obj.flag : obj.file;
				
				if (str && str.length) {
					return ['<img src="', src, '?', Math.floor(Math.random() * 99999), '" alt="" class="img-locale-flag" />'].join('');
				}
				
				return;
			}
			
			function onBeforeShow(obj) {
				if (parseInt(obj.is_default, 10) === 1) {
					return false;
				}
				return true;
			}
			var x, dOpts = [];
			for (x in myLabel.directions) {
				if (myLabel.directions.hasOwnProperty(x)) {
					dOpts.push({label: myLabel.directions[x], value: x});
				}
			}
			
			$grid = $gridLocales.datagrid({
				buttons: [{type: "delete", url: "index.php?controller=pjBaseLocale&action=pjActionDeleteLocale&id={:id}", beforeShow: onBeforeShow}],
				columns: [{text: myLabel.language, type: "select", sortable: true, editable: true, options: pjGrid.languages},
				          {text: myLabel.name, type: "text", sortable: true, editable: true},
				          {text: myLabel.flag, type: "text", cellClass: "text-center", renderer: formatImage},
				          {text: myLabel.dir, type: "select", sortable: true, editable: true, options: dOpts},
				          {text: myLabel.is_default, type: "toggle", sortable: true, editable: true, 
				        	  editableRenderer: function () {
				        		  return 1;
				        	  },
				        	  saveUrl: "index.php?controller=pjBaseLocale&action=pjActionSaveDefault&id={:id}",
				        	  positiveLabel: myLabel.yes, positiveValue: "1", negativeLabel: myLabel.no, negativeValue: "0", 
				        	  cellClass: "text-center"},
				          {text: myLabel.order, type: "text", sortable: true, cellClass: "text-center", css: {
				        	  cursor: "move"
				          }}],
				dataUrl: urlLocales,
				dataType: "json",
				fields: ['language_iso', 'name', 'file', 'dir', 'is_default', 'sort'],
				paginator: false,
				saveUrl: "index.php?controller=pjBaseLocale&action=pjActionSaveLocale&id={:id}",
				sortable: true,
				sortableUrl: "index.php?controller=pjBaseLocale&action=pjActionSortLocale"
			});
			
			$(document).on("click", ".btn-add", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				$.post("index.php?controller=pjBaseLocale&action=pjActionSaveLocale").done(function (data) {
					if (data && data.status && data.status === "OK" && data.id) {
						$grid.datagrid("option", "onRender", function () {
							var $td = $("tr[data-id='id_" + data.id + "']").find(".pj-table-cell-editable").filter(":first");
							$td.trigger("click");
							$td.find("select option:not([disabled])").first().attr("selected", "selected");
							$grid.datagrid("option", "onRender", null);
						});
						$grid.datagrid("load", urlLocales);
					}
					else
                    {
                        swal('Error', data.text, 'error')
                    }
				});
				return false;
			}).on("focus", "select[data-name='language_iso']", function (e) {
				var $this = $(this), values = [];
				if (!$this.data('focused')) {
					$this.closest("tbody").find("select[data-name='language_iso']").not(this).each(function (i) {
						values.push($(this).find("option:selected").val());
					});
					$this.find("option").prop("disabled", false).filter(function (index) {
						return $.inArray(this.value, values) != -1;
					}).prop("disabled", true);
					$this.blur();
				}
				$this.data('focused', true);
			});
		}
		
		function formatLanguage (str, obj) {
			if (Number(obj.expand) === 1) {
				return ['<input type="hidden" name="foreign_id" value="', obj.id, '"><textarea name="i18n[', obj.locale, '][title]" class="form-control editable-label" rows="5">', str, '</textarea>'].join('');
			}
			
			return ['<div class="textarea-expandable-holder"><input type="hidden" name="foreign_id" value="', obj.id, '"><textarea name="i18n[', obj.locale, '][title]" class="form-control editable-label">', str, '</textarea><i class="fa fa-caret-down"></i></div>'].join('');
		}
		
		if ($gridFrontend.length && datagrid) {
			var m,
				$tmpL = $("#tmplLanguage > .row").clone(),
				columns = [{text: myLabel.id, type: "text"},
					       {text: myLabel.default_language, type: "text"},
					       {text: myLabel.language, type: "text", renderer: formatLanguage},
					       {text: myLabel.filter, type: "text"},
					       {text: myLabel.field_type, type: "text"}],
				fields = ['did', 'default_language', 'content', 'pages', 'field_type'],
				lang_selector = 'thead th:eq(2)',
				page_selector = 'thead th:eq(3)',
				cache = {
					locale_id: $tmpL.find("select option:eq(0)").val()
				};
			
			if (!myLabel.showId) {
				columns = columns.slice(1);
				fields = fields.slice(1);
				lang_selector = 'thead th:eq(1)';
				page_selector = 'thead th:eq(2)';
			}
			
			$grid = $gridFrontend.on("focusin", ".textarea-expandable-holder", function (e) {
				//show btn
			}).on("focusout", ".editable-label", function (e) {
				if (this.value === this.defaultValue) {
					return;
				}
				
				var $this = $(this),
					that = this,
					qs = $this.siblings(':hidden').addBack().serialize();

				$this.prop('disabled', true);
				$.post("index.php?controller=pjBaseLocale&action=pjActionSaveLabel", qs).done(function (data) {
					if (data && data.status && data.status === "OK") {
						that.defaultValue = that.value;
					}
					$this.prop('disabled', false);
				});
			}).on("change", "#locale_id", function () {
				
				var content = $grid.datagrid("option", "content"),
					cache = $grid.datagrid("option", "cache");
				cache.locale_id = $(this).find("option:selected").val();
				$grid.datagrid("option", "cache", cache);
				$grid.datagrid("load", urlFrontend, content.column, content.direction, 1, content.rowCount);
				
			}).datagrid({
				buttons: [],
				columns: columns,
				dataUrl: urlFrontend,
				dataType: "json",
				fields: fields,
				cache: cache,
				onRender: function () {
					var cache = $grid.datagrid("option", "cache");
					
					if ('locale_id' in cache) {
						$tmpL.find('select option[value="' + cache.locale + '"]').prop("selected", true);
					} else {
						$tmpL.find('select option:eq(0)').prop("selected", true);
					}
					$grid.find(lang_selector).empty().append($tmpL);
				}
			});
		}
		
		if($('#frmImportConfirm').length > 0)
		{
			$('#frmImportConfirm').validate({
				errorPlacement: function(error, element) {
					if (element.hasClass('fileinput')) {
						error.insertAfter(element.parent());
                    }  else {
						error.insertAfter(element);
					}
			    },
			});
		}
		
		$(document).on("submit", ".frm-filter", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this),
				content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache"),
				url;
			
			switch ($this.data("variant")) {
			case 'locales':
				url = urlLocales;
				break;
			case 'frontend':
				url = urlFrontend;
				break;
			case 'backend':
				url = urlBackend;
				break;
			}
			
			$.extend(cache, {
				q: $this.find("input[name='q']").val(),
				page: 1
			});
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", url, content.column, content.direction, 1, content.rowCount);
			return false;
		}).on('mouseup', function(e) {
			if (!$gridFrontend && !$gridBackend) {
				return;
			}
            var container = $(".textarea-expandable-holder");
            if (!container.is(e.target) && container.has(e.target).length === 0) 
            {
                container.find('i').removeClass('active');
                $(".textarea-expandable-holder").find('textarea').removeClass('expanded');
            }
        }).on('click', '.textarea-expandable-holder', function(){
            $('.textarea-expandable-holder i').removeClass('active');

            $(this).find('i').addClass('active');
        }).on('click', '.textarea-expandable-holder i', function(){
            $(this).prev().toggleClass('expanded');
        });
	});
})(jQuery_1_8_2);