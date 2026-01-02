/*!
 * @author Dimitar Ivanov
 * @version 2.0
 * @last_modified 2017-06-19
 */
(function ($, undefined) {
	"use strict";
	var PROP_NAME = 'datagrid',
		FALSE = false,
		TRUE = true;

	function Datagrid() {
		this._defaults = {
			buttons: [], //Array of objects; Object keys: type String, url String, beforeShow Function, title String, target String
			buttonsText: null,
			buttonsCellClass: null,
			columns: [], //Array of objects; Object keys: text String, type String, sortable Boolean(false), editable Boolean(false), width Interger, align String, editableWidth Integer
			content: {
				data: [], //data Array
				total: 0, //total Integer
				rowCount: 10, //rowCount Integer
				pages: 1, //pages Integer
				page: 1 //page Integer
			},
			dataUrl: null, //String
			dataType: "json", //String; 'json', 'xml'-TODO
			fields: [], //Array
			paginator: {
				actions: [], //Array of objects; Object keys: text String, url String, render Boolean, confirmation String
				gotoPage: true, //Boolean
				paginate: true, //Boolean
				total: true, //Boolean
				rowCount: true //Boolean
			},
			rowCountItems: [10, 20, 50, 100, 200, 500], //Array
			saveUrl: null, //String
			select: false, //Boolean or Object {field: "id", name: "record[]", cellClass: "col-md-1"}
			sortable: false, //Boolean
			sortableUrl: null, //String
			width: null,
			// Callbacks
			onRender: null, //Function
			// Private
			regex: {
				params: /\{:(\w+)\}/g
			},
			cache: {}
		};

		this.messages = {
			empty_result: "No records found",
			choose_action: "Choose Action",
			goto_page: "Go to page:",
			total_prefix: "of ",
			total_suffix: " total",
			show: "Show",
			items_per_page: "Items per page",
			prev_page: "Prev page",
			prev: "&laquo; Prev",
			next_page: "Next page",
			next: "Next &raquo;",
			month_names: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
			day_names: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
			delete_title: "Delete confirmation",
			delete_text: "Are you sure you want to delete selected record?",
			action_title: "Action confirmation",
			action_empty_title: "No records selected",
			action_empty_body: "You need to select at least a single record",
			btn_ok: "OK",
			btn_cancel: "Cancel",
			btn_delete: "Delete",
			empty_date: "(empty date)",
			invalid_date: "(invalid date)"
		};
	}

	Datagrid._formatDate = function (isoDate, format) {
		var d = new Datagrid();
		
		if (isoDate === null || isoDate.length === 0) {
			return d.messages.empty_date;
		}
		
		if (isoDate === '0000-00-00') {
			return d.messages.invalid_date;
		}
		
		return Datagrid.formatDate(Datagrid.getDate(isoDate), format);
	};
	
	Datagrid.getDate = function (dt) {
		var _dt = dt.split("-"),
			iFormat = "yyyy-MM-dd".split("-");
		iFormat = Datagrid.arrayFlip(iFormat);
		return new Date(_dt[iFormat['yyyy']], parseInt(_dt[iFormat['MM']], 10) - 1, _dt[iFormat['dd']]);
	};
	
	Datagrid.arrayFlip = function (trans) {
		var key, tmp_ar = {};
		for (key in trans) {
			if (trans.hasOwnProperty(key)) {
				tmp_ar[trans[key]] = key;
			}
		}
		return tmp_ar;
	};
	
	Datagrid.formatDate = function (date, format) {
	    var _monthNames = $.datagrid.messages.month_names,
		    _dayNames = $.datagrid.messages.day_names,
		    _year = date.getFullYear(),
		    _month = date.getMonth(),
		    _day = date.getDay(),
		    _date = date.getDate(),
		    _hours = date.getHours(),
		    _minutes = date.getMinutes(),
		    _seconds = date.getSeconds();

	    if (pjGrid !== undefined && pjGrid.monthNames !== undefined) {
	    	_monthNames = pjGrid.monthNames;
	    }
	    if (pjGrid !== undefined && pjGrid.dayNames !== undefined) {
	    	_dayNames = pjGrid.dayNames;
	    }
	    
	    if (!format) {
	        format = "MM/dd/yyyy";
	    }

	    format = format.replace("yyyy", "{0}").replace("yy", "{1}").replace("y", "{2}")
	            .replace("MMMM", "{3}").replace("MMM", "{4}").replace("MM", "{5}").replace("M", "{6}")
	            .replace("dddd", "{7}").replace("ddd", "{8}").replace("dd", "{9}").replace("d", "{10}")
	            .replace("hh", "{11}").replace("h", "{12}").replace("HH", "{13}").replace("H", "{14}")
	            .replace("mm", "{15}").replace("m", "{16}")
	            .replace("ss", "{17}").replace("s", "{18}")
	            .replace("tt", "{19}").replace("t", "{20}");

	    if (format.indexOf("{0}") > -1) {
	        format = format.replace("{0}", _year.toString());
	    }
	    if (format.indexOf("{1}") > -1) {
	        format = format.replace("{1}", _year.toString().substr(2, 2));
	    }
	    if (format.indexOf("{2}") > -1) {
	        format = format.replace("{2}", parseInt(_year.toString().substr(2, 2)).toString());
	    }
	    if (format.indexOf("{3}") > -1) {
	        format = format.replace("{3}", _monthNames[_month]);
	    }
	    if (format.indexOf("{4}") > -1) {
	        format = format.replace("{4}", _monthNames[_month].substr(0, 3));
	    }
	    if (format.indexOf("{5}") > -1) {
	        format = format.replace("{5}", (_month + 1).toString().padL(2, "0"));
	    }
	    if (format.indexOf("{6}") > -1) {
	        format = format.replace("{6}", (_month + 1).toString());
	    }
	    if (format.indexOf("{7}") > -1) {
	        format = format.replace("{7}", _dayNames[_day]);
	    }
	    if (format.indexOf("{8}") > -1) {
	        format = format.replace("{8}", _dayNames[_day].substr(0, 3));
	    }
	    if (format.indexOf("{9}") > -1) {
	        format = format.replace("{9}", _date.toString().padL(2, "0"));
	    }
	    if (format.indexOf("{10}") > -1) {
	        format = format.replace("{10}", _date.toString());
	    }
	    if (format.indexOf("{11}") > -1) {
	        var _h = _hours;
	        if (_hours > 12) {
	        	_h -= 12;
	        }
	        if (_hours == 0) {
	        	_h = 12;
	        }
	        format = format.replace("{11}", _h.toString().padL(2, "0"));
	    }
	    if (format.indexOf("{12}") > -1) {
	        var _h = _hours;
	        if (_hours > 12) {
	        	_h -= 12;
	        }
	        if (_hours == 0) {
	        	_h = 12;
	        }
	        format = format.replace("{12}", _h.toString());
	    }
	    if (format.indexOf("{13}") > -1) {
	        format = format.replace("{13}", _hours.toString().padL(2, "0"));
	    }
	    if (format.indexOf("{14}") > -1) {
	        format = format.replace("{14}", _hours.toString());
	    }
	    if (format.indexOf("{15}") > -1) {
	        format = format.replace("{15}", _minutes.toString().padL(2, "0"));
	    }
	    if (format.indexOf("{16}") > -1) {
	        format = format.replace("{16}", _minutes.toString());
	    }
	    if (format.indexOf("{17}") > -1) {
	        format = format.replace("{17}", _seconds.toString().padL(2, "0"));
	    }
	    if (format.indexOf("{18}") > -1) {
	        format = format.replace("{18}", _seconds.toString());
	    }
	    if (format.indexOf("{19}") > -1) {
	        if (_hours > 11) {
	            format = format.replace("{19}", "pm")
	        } else {
	            format = format.replace("{19}", "am");
	        }
	    }
	    if (format.indexOf("{20}") > -1) {
	        if (_hours > 11) {
	            format = format.replace("{20}", "p")
	        } else {
	            format = format.replace("{20}", "a");
	        }
	    }
	    return format;
	};
	
	Datagrid.wordwrap = function (str, width, brk, cut) {
	    brk = brk || '\n';
	    width = width || 75;
	    cut = cut || false;
	 
	    if (!str) { return str; }
	 
	    var regex = '.{1,' +width+ '}(\\s|$)' + (cut ? '|.{' +width+ '}|.+$' : '|\\S+?(\\s|$)');
	 
	    return str.match( RegExp(regex, 'g') ).join( brk );
	}
	
	String.repeat = function(chr,count) {
		var str = ""; 
		for (var x = 0; x < count; x++) {
			str += chr
		}; 
		return str;
	};

	String.prototype.padL = function(width, pad) {
		if (!width || width < 1) {
	    	return this;
	    }
		if (!pad) {
			pad = " ";
		}
		var length = width - this.length;
		if (length < 1) {
			return this.substr(0, width);
		}
		return (String.repeat(pad, length) + this).substr(0, width);    
	};
	
	String.prototype.padR = function(width, pad) {
		if (!width || width < 1) {
			return this;
		}
	    if (!pad) {
	    	pad = " ";
	    }
	    var length = width - this.length;
	    if (length < 1) {
	    	this.substr(0, width);
	    }
	    return (this + String.repeat(pad, length)).substr(0, width);
	};
	
	Datagrid.prototype = {
		_attachDatagrid: function (target, settings) {
			if (this._getInst(target)) {
				return FALSE;
			}
			var buttons,
				$target = $(target),
				self = this,
				inst = self._newInst($target);
			
			$.extend(inst.settings, self._defaults, settings);
			
			function gotoPage (page, e) {
				if (e !== undefined && 13 != (e.keyCode ? e.keyCode : e.which)) {
					return;
				}
				
				page = Number(page);
					
				if (page > 0 && page != inst.settings.content.page) {
					if (page > inst.settings.content.pages) {
						page = inst.settings.content.pages;
					}
					$.extend(inst.settings.cache, {
						page: page
					});
					self._loadDatagrid.call(self, target, inst.settings.dataUrl, inst.settings.content.column, inst.settings.content.direction, page, inst.settings.content.rowCount);
				}
			}
			
			$target.addClass("pj-grid").on("mouseenter.dg", ".pj-table tbody tr", function () {
				$(this).addClass("pj-table-row-hover");
			}).on("mouseleave.dg", ".pj-table tbody tr", function () {
				$(this).removeClass("pj-table-row-hover");
			}).on("click.dg", ".pj-table-sort-up, .pj-table-sort-down", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var $this = $(this);
				$.extend(inst.settings.cache, {
					column: $this.data("column"),
					direction: $this.hasClass("pj-table-sort-up") ? "ASC" : "DESC"
				});
				self._loadDatagrid.call(self, target, inst.settings.dataUrl, $this.data("column"), $this.hasClass("pj-table-sort-up") ? "ASC" : "DESC", inst.settings.content.page, inst.settings.content.rowCount);
				return FALSE;
			}).on("click.dg", ".pj-table-icon-delete", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var $this = $(this),
					$tr = $this.closest("tr");
				
				swal({
					title: self.messages.delete_title,
					text: self.messages.delete_text,
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: self.messages.btn_delete,
					cancelButtonText: self.messages.btn_cancel,
					closeOnConfirm: false,
					showLoaderOnConfirm: true
				}, function () {
					$.post($this.attr("href")).done(function (data) {
						if (!(data && data.status)) {
							swal("Error!", '', "error");
						}
						switch (data.status) {
						case "OK":
							$tr.css("backgroundColor", "#FFB4B4").fadeOut("slow", function () {
								self._loadDatagrid.call(self, target, inst.settings.dataUrl, inst.settings.content.column, inst.settings.content.direction, inst.settings.content.page, inst.settings.content.rowCount);
								swal.close();
							});
							break;
                            case "ERR":
                                swal("Error!", data.text, "error");
                                break;
						}
					});
				});

				return FALSE;
			}).on("click.dg", ".pj-table-icon-menu", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var diff, lf,
					$this = $(this),
					$list = $this.siblings(".pj-menu-list-wrap");
				diff = Math.ceil( ($list.outerWidth() - $this.outerWidth()) / 2 );
				if (diff > 0) {
					lf = $this.offset().left - diff;
					if (lf < 0) {
						lf = 0;
					}
				} else {
					lf  = $this.offset().left + diff;
				}
				$list.css({
					"top": $this.offset().top + $this.outerHeight() + 2,
					"left": lf
				});
			
				$list.toggle();
				$(".pj-menu-list-wrap").not($list).hide();
				return FALSE;
			}).on("click.dg", ".pj-paginator-list-paginate", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var p = $(this).data("page");
				$.extend(inst.settings.cache, {
					page: p
				});
				self._loadDatagrid.call(self, target, inst.settings.dataUrl, inst.settings.content.column, inst.settings.content.direction, p, inst.settings.content.rowCount);
				return FALSE;
			}).on("click.dg", ".pj-paginator-list-prev, .pj-paginator-list-next", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var $this = $(this),
					p = $this.hasClass("pj-paginator-list-prev") ? inst.settings.content.page - 1 : inst.settings.content.page + 1;
				$.extend(inst.settings.cache, {
					page: p
				});
				self._loadDatagrid.call(self, target, inst.settings.dataUrl, inst.settings.content.column, inst.settings.content.direction, p, inst.settings.content.rowCount);
				return FALSE;
			}).on("change.dg", ".pj-selector-row-count", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var rowCount = Number($(this).find("option:selected").val()),
					total = Number(inst.settings.content.total);
				inst.settings.cache.rowCount = rowCount;
				if (inst.settings.content.page * rowCount > total) {
					inst.settings.cache.page = Math.ceil(total / rowCount);
				}
				self._loadDatagrid.call(self, target, inst.settings.dataUrl, inst.settings.content.column, inst.settings.content.direction, inst.settings.content.page, rowCount);
				return FALSE;
			}).on("keypress.dg", ".pj-selector-goto", function (e) {
				gotoPage.call(null, this.value, e);
			}).on("click.dg", ".pj-table-cell-editable", function (e) {
				var $this = $(this),
					$td = $this.closest("td");
				if ($td.data("type") === "toggle") {
					var $btn = $td.find('[role="button"]');
					if ($btn.length && ($btn.hasClass('disabled') || $btn.attr('aria-disabled') === 'true')) {
						return;
					}
					$td.find(".pj-selector-editable").trigger("save");
				} else {
					$(".pj-table-cell-label", $this).hide();
					$(".form-control", $this).show().focus();
				}
			}).on("keypress.dg", ".pj-table-cell-editable > .pj-selector-editable", function (e) {
				switch (e.keyCode ? e.keyCode : e.which) {
					case 13: //Enter
						$(this).trigger("save");
						break;
				}
			}).on("keyup.dg", ".pj-table-cell-editable > .pj-selector-editable", function (e) {
				switch (e.keyCode ? e.keyCode : e.which) {
					case 27: //Escape
						$(this).hide().siblings(".pj-table-cell-label").show();
						break;
				}
			}).on("save.dg", ".pj-selector-editable", function (e) {
				var $this = $(this),
					saveUrl = $this.data("saveurl"),
					url = inst.settings.saveUrl.replace(/\{:(\w+)\}/, function () {
						return $this.closest("tr").data("object")[arguments[1]];
					});
				if (saveUrl !== undefined) {
					url = saveUrl;
				}
				$.post(url, {
					column: $this.data("name"),
					value: $this.val()
				}).done(function (data) {
					self._loadDatagrid.call(self, target, inst.settings.dataUrl, inst.settings.content.column, inst.settings.content.direction, inst.settings.content.page, inst.settings.content.rowCount);
					if (data && data.status && data.status !== "OK" && data.text) {
                        swal('Error', data.text, 'error');
                    }
				});
			}).on("click.dg", ".pj-paginator-action", function (e) {
				var i, $form,
					$this = $(this),
					$data = $this.data("object"),
					records = $(".pj-table-select-row", $target).serializeArray(),
					iCnt = records.length;
				
				if (iCnt > 0) {
					if ($data.confirmation !== undefined) {
						if (e && e.preventDefault) {
							e.preventDefault();
						}
						
						swal({
							title: self.messages.action_title, 
							text: $data.confirmation,
							type: "warning",
							showCancelButton: true,
							confirmButtonColor: "#DD6B55",
							confirmButtonText: self.messages.btn_ok,
							cancelButtonText: self.messages.btn_cancel,
							closeOnConfirm: false,
							showLoaderOnConfirm: true
						},
						(function (my_data) {
							return function () {
								$.post(my_data.url, $(".pj-table-select-row", $target).serialize()).done(function (data) {
								    if (!(data && data.status)) {
                                        swal("Error!", '', "error");
                                    }
                                    switch (data.status) {
                                        case "OK":
									swal.close();
									if (my_data.render) {
										self._loadDatagrid.call(self, target, inst.settings.dataUrl);
									}
                                            break;
                                        case "ERR":
                                            swal("Error!", data.text, "error");
                                            break;
                                    }
								});
							};
						})($data));
						
						return FALSE;
					} else if ($data.ajax !== undefined && $data.ajax === false) {
						if (e && e.preventDefault) {
							e.preventDefault();
						}
						$form = $("<form>", {
							"method": "POST",
							"action": $this.attr("href")		
						});
						for (i = 0; i < iCnt; i++) {
							$("<input>", {
								"type": "hidden",
								"name": records[i].name,
								"value": records[i].value
							}).appendTo($form);
						}
						$("body").append($form);
						$form.get(0).submit();
						$form.remove();
						$this.closest(".dropdown-menu").dropdown('toggle');
						
						return FALSE;
					} else {
						if (e && e.preventDefault) {
							e.preventDefault();
						}
						$.post($this.attr("href"), $(".pj-table-select-row", $target).serialize()).done(function (data) {
							$this.closest(".pj-menu-list-wrap").hide();
							if (!(data && data.status)) {
                                swal("Error!", '', "error");
                            }
                            switch (data.status) {
                                case "OK":
							if ($data.render) {
								self._loadDatagrid.call(self, target, inst.settings.dataUrl);
							}
                                    break;
                                case "ERR":
                                    swal("Error!", data.text, "error");
                                    break;
                            }
						});
						
						return FALSE;
					}
				} else {
					if (e && e.preventDefault) {
						e.preventDefault();
					}
					
					swal({
						title: self.messages.action_empty_title,
						text: self.messages.action_empty_body,
						type: "warning",
						confirmButtonText: self.messages.btn_ok
					});
					
					return FALSE;
				}
			});
			
			var $div = $("<div>").addClass("sk-spinner sk-spinner-double-bounce");
			$("<div>").addClass("sk-double-bounce1").appendTo($div);
			$("<div>").addClass("sk-double-bounce2").appendTo($div);
			$div.insertBefore($target);

			var wrapper = ".ibox-content";
			if ($target.data("wrapper")) {
				wrapper = $target.data("wrapper");
			}
			$(document).bind("ajaxStart.dg", function(e) {
				$target.closest(wrapper).addClass("sk-loading");
			}).bind("ajaxStop.dg", function(e) {
				$target.closest(wrapper).removeClass("sk-loading");
			});
			
			$(document).on("click.dg", "*", function (e) {
				if ($target.is(":visible")) {
					if (!$(e.target).closest(".pj-menu-list-wrap").length) {
						$(".pj-menu-list-wrap").hide();
					}
					if (!$(e.target).closest(".pj-table-cell-editable:visible").length) {
						if ($(e.target).closest(".ui-datepicker").length || $(e.target).closest(".ui-datepicker-header").length) {
							e.stopPropagation();
							return;
						}
						if ($(".pj-selector-editable:visible").length) {
							e.stopPropagation();
							$(".pj-selector-editable:visible").trigger("save");
						}
					}
				}
			});
			
			$.data(target, PROP_NAME, inst);
			
			$.get(inst.settings.dataUrl, inst.settings.cache).done(function (data) {
				inst.settings.content = data;
				self._renderDatagrid.call(self, target);
			});
		},
		_loadDatagrid: function (target, url, column, direction, page, rowCount) {
			var inst = this._getInst(target);
			if (!inst) {
				return FALSE;
			}
			var self = this,
				obj = {
					column: column,
					direction: direction,
					page: page,
					rowCount: rowCount
			};
			$.get(url, $.extend(obj, inst.settings.cache)).done(function (data) {
				inst.settings.content = data;
				$.data(target, PROP_NAME, inst);
				self._renderDatagrid.call(self, target);
			});
		},
		_renderDatagrid: function (target) {
			var inst = this._getInst(target);
			if (!inst) {
				return FALSE;
			}
			if (inst.settings.content.redirect) {
				window.location.href = inst.settings.content.redirect;
				return;
			}
			var i, iCnt, j, jCnt, k, kCnt, bCnt, upClass, downClass, buttons, isDisabled,
				$tableWrap, isSortBy, $sortEl, iconDir, $group, $button, $wrap, $select, $label,
				$table, $thead, $tbody, $tr, $th, $td, $checkbox, $input, $option, $a, $ul, $li, $div, $span, $tmp,
				$target = $(target),
				self = this;
			
			bCnt = inst.settings.buttons.length;
			
			$tableWrap = $("<div>").addClass("table-responsive table-responsive-secondary");
			$table = $("<table>").addClass("table table-striped table-hover");
			if (inst.settings.sortable) {
				$table.addClass("table-sortable");
			}
			
			// THEAD ----------------
			$thead = $("<thead>");
			$tr = $("<tr>");
			if (inst.settings.select !== FALSE) {
				$th = $("<th>").append($("<input>", {
					"type": "checkbox",
					"class": "pj-table-toggle-rows"
				})).appendTo($tr);
				if (inst.settings.select.cellClass) {
					$th.addClass(inst.settings.select.cellClass);
				}
			}
			for (i = 0, iCnt = inst.settings.columns.length; i < iCnt; i++) {
				$th = $("<th>");
				if (inst.settings.columns[i].sortable && inst.settings.content.data && inst.settings.content.data.length) {
					
					iconDir = 'fa fa-sort-amount-asc';
					isSortBy = false;
					if (inst.settings.content.column == inst.settings.fields[i]) {
						isSortBy = true;
						if (inst.settings.content.direction == "DESC") {
							iconDir = 'fa fa-sort-amount-desc';
						}
					}
					
					$sortEl = $("<a>", {
						"href": "#"
					}).addClass("m-r-xs pj-table-sort-" + (iconDir === 'fa fa-sort-amount-desc' || !isSortBy ? "up" : "down")).data("column", inst.settings.fields[i]);
					if (!isSortBy) {
						$sortEl.addClass("text-muted");
					}
					$("<i>").addClass(iconDir).appendTo($sortEl);
					$sortEl.appendTo($th);
					$th.append(inst.settings.columns[i].text);
						
											
				} else {
					$th.html(inst.settings.columns[i].text);
				}
				if (inst.settings.columns[i].width !== undefined) {
					$th.css("width", inst.settings.columns[i].width + "px");
				}
				if (inst.settings.columns[i].cellClass) {
					$th.addClass(inst.settings.columns[i].cellClass);
				}
				$th.appendTo($tr);
			}
			if (bCnt > 0) {
				$th = $("<th>")
					.html(inst.settings.buttonsText ? inst.settings.buttonsText : "&nbsp;")
					.addClass('text-right')
					.appendTo($tr);
				if (inst.settings.buttonsCellClass) {
					$th.addClass(inst.settings.buttonsCellClass);
				}
			}
			$tr.appendTo($thead);
			$thead.appendTo($table);

			// TBODY ----------------
			$tbody = $("<tbody>");
			if (inst.settings.content.data && inst.settings.content.data.length === 0) {
				i = inst.settings.columns.length;
				if (bCnt > 0) {
					i += 1;
				}
				if (inst.settings.select !== FALSE) {
					i += 1;
				}
				$tr = $("<tr>");
				$td = $("<td>").attr("colspan", i).html(self.messages.empty_result);
				$td.appendTo($tr);
				$tr.appendTo($tbody);
			}
			if (inst.settings.content.data) {
				for (i = 0, iCnt = inst.settings.content.data.length; i < iCnt; i++) {
					if (i >= inst.settings.content.rowCount) {
						break;
					}
					$tr = $("<tr>").data("object", inst.settings.content.data[i])
						.attr("data-id", "id_" + inst.settings.content.data[i].id);
					if (inst.settings.sortable) {
						$tr.addClass("pj-table-row-sortable");
					}
					if (inst.settings.select !== FALSE) {
						$td = $("<td>");
						if (inst.settings.select.beforeShow === undefined || inst.settings.select.beforeShow.call(null, inst.settings.content.data[i])) {
							$checkbox = $("<input>", {
								"type": "checkbox",
								"name": inst.settings.select.name,
								"value": inst.settings.content.data[i][inst.settings.select.field]
							}).addClass("pj-table-select-row");
							$checkbox.appendTo($td);
						}
						if (inst.settings.select.cellClass) {
							$td.addClass(inst.settings.select.cellClass);
						}
						$td.appendTo($tr);
					}
					for (j = 0, jCnt = inst.settings.fields.length; j < jCnt; j++) {
						$td = $("<td>")
							.data("type", inst.settings.columns[j].type)
							.data("field", inst.settings.fields[j])
							.data("value", inst.settings.content.data[i][inst.settings.fields[j]]);
						if (inst.settings.columns[j].align !== undefined) {
							$td.css("text-align", inst.settings.columns[j].align);
						}
						$span = $("<span>").addClass("pj-table-cell-label");
						if (inst.settings.columns[j].applyClass !== undefined) {
							$span.addClass(inst.settings.columns[j].applyClass + "-" + inst.settings.content.data[i][inst.settings.fields[j]]);
						}
						switch (inst.settings.columns[j].type) {
							case "text":
							case "spinner":
								if (inst.settings.columns[j].renderer === undefined) {
									$span.html(inst.settings.content.data[i][inst.settings.fields[j]]);
								} else {
									$span.html(inst.settings.columns[j].renderer.call(null, inst.settings.content.data[i][inst.settings.fields[j]], inst.settings.content.data[i]));
								}
								break;
							case "date":
								if (inst.settings.columns[j].renderer === undefined) {
									$span.html(inst.settings.content.data[i][inst.settings.fields[j]]);
								} else {
									$span.html(inst.settings.columns[j].renderer.call(null, inst.settings.content.data[i][inst.settings.fields[j]], inst.settings.columns[j].dateFormat));
								}
								break;
							case "select":
								for (k = 0, kCnt = inst.settings.columns[j].options.length; k < kCnt; k++) {
									if (inst.settings.content.data[i][inst.settings.fields[j]] == inst.settings.columns[j].options[k].value) {
										if (inst.settings.columns[j].renderer === undefined) {
											$span.html(inst.settings.columns[j].options[k].label);
										} else {
											$span.html(inst.settings.columns[j].renderer.call(null, inst.settings.columns[j].options[k].label, inst.settings.content.data[i]));
										}
										break;
									}
								}
								break;
							case "toggle":
								isDisabled = (inst.settings.columns[j].beforeShow !== undefined && !inst.settings.columns[j].beforeShow.call(null, inst.settings.content.data[i]));
								
								if (inst.settings.columns[j].renderer === undefined) {
									switch (true) {
									case inst.settings.content.data[i][inst.settings.fields[j]] == inst.settings.columns[j].positiveValue:
										$span.html(['<div role="button" tabindex="0" aria-disabled="', (isDisabled ? 'true' : 'false'), '" class="', (inst.settings.columns[j].positiveClass ? inst.settings.columns[j].positiveClass : 'btn btn-primary btn-xs no-margins'), (isDisabled ? ' disabled' : ''), '"><i class="', (inst.settings.columns[j].positiveIcon ? inst.settings.columns[j].positiveIcon : 'fa fa-check'), '"></i> ', inst.settings.columns[j].positiveLabel, '</div>'].join(''));
										break;
									case inst.settings.content.data[i][inst.settings.fields[j]] == inst.settings.columns[j].negativeValue:
										$span.html(['<div role="button" tabindex="0" aria-disabled="', (isDisabled ? 'true' : 'false'), '" class="', (inst.settings.columns[j].negativeClass ? inst.settings.columns[j].negativeClass : 'btn btn-default btn-xs no-margins'), (isDisabled ? ' disabled' : ''), '"><i class="', (inst.settings.columns[j].negativeIcon ? inst.settings.columns[j].negativeIcon : 'fa fa-times'), '"></i> ', inst.settings.columns[j].negativeLabel, '</div>'].join(''));
										break;
									}
								} else {
									$span.html(inst.settings.columns[j].renderer.call(null, inst.settings.content.data[i][inst.settings.fields[j]], inst.settings.content.data[i]));
								}
								break;
						}
						$td.append($span);
						if (inst.settings.columns[j].editable) {
							$td.addClass("pj-table-cell-editable");
							switch (inst.settings.columns[j].type) {
								case "text":
								case "spinner":
								case "date":
									$input = $("<input>", {
										"type": "text",
										"data-name": inst.settings.fields[j]
									}).hide().addClass("form-control pj-selector-editable");
									if (inst.settings.columns[j].editableRenderer === undefined) {
										$input.attr("value", inst.settings.content.data[i][inst.settings.fields[j]]);
									} else {
										if (inst.settings.columns[j].type == "date") {
											$input.attr("value", inst.settings.columns[j].editableRenderer.call(null, inst.settings.content.data[i][inst.settings.fields[j]], inst.settings.columns[j].dateFormat));
										} else {
											$input.attr("value", inst.settings.columns[j].editableRenderer.call(null, inst.settings.content.data[i][inst.settings.fields[j]]));
										}
									}
									if (inst.settings.columns[j].saveUrl !== undefined) {
										$input.attr("data-saveurl", inst.settings.columns[j].saveUrl.replace(inst.settings.regex.params, function () {
											return inst.settings.content.data[i][arguments[1]];
										}));
									}
									if (inst.settings.columns[j].type == 'date') {
										$input.datepicker({
											dateFormat: inst.settings.columns[j].jqDateFormat
										});
									}
									if (inst.settings.columns[j].editableWidth !== undefined) {
										$input.css("width", inst.settings.columns[j].editableWidth + "px");
									}
									$input.appendTo($td);
									if (inst.settings.columns[j].type == 'spinner') {
										$input.attr("readonly", "readonly").spinner({
											"min": inst.settings.columns[j].min,
											"max": inst.settings.columns[j].max,
											"step": inst.settings.columns[j].step
										});
									}
									break;
								case "select":
									$input = $("<select>", {
										"data-name": inst.settings.fields[j]
									}).hide().addClass("form-control pj-selector-editable");
									if (inst.settings.columns[j].saveUrl !== undefined) {
										$input.attr("data-saveurl", inst.settings.columns[j].saveUrl.replace(inst.settings.regex.params, function () {
											return inst.settings.content.data[i][arguments[1]];
										}));
									}
									for (k = 0, kCnt = inst.settings.columns[j].options.length; k < kCnt; k++) {
										$option = $("<option>", {
											"value": inst.settings.columns[j].options[k].value
										}).html(inst.settings.columns[j].options[k].label);
										if (inst.settings.content.data[i][inst.settings.fields[j]] == inst.settings.columns[j].options[k].value) {
											$option.prop("selected", TRUE);
										}
										$option.appendTo($input)
									}
									if (inst.settings.columns[j].editableWidth !== undefined) {
										$input.css("width", inst.settings.columns[j].editableWidth + "px");
									}
									$input.appendTo($td);
									break;
								case "toggle":
									$input = $("<input>", {
										"type": "hidden",
										"data-name": inst.settings.fields[j]
									}).addClass("pj-selector-editable");
									if (inst.settings.columns[j].editableRenderer === undefined) {
										$input.attr("value", inst.settings.content.data[i][inst.settings.fields[j]] == inst.settings.columns[j].positiveValue ? inst.settings.columns[j].negativeValue : inst.settings.columns[j].positiveValue);
									} else {
										$input.attr("value", inst.settings.columns[j].editableRenderer.call(null, inst.settings.content.data[i][inst.settings.fields[j]]));
									}
									if (inst.settings.columns[j].saveUrl !== undefined) {
										$input.attr("data-saveurl", inst.settings.columns[j].saveUrl.replace(inst.settings.regex.params, function () {
											return inst.settings.content.data[i][arguments[1]];
										}));
									}
									$input.appendTo($td);
									break;
							}
						}
						if (inst.settings.columns[j].css) {
							$td.css(inst.settings.columns[j].css);
						}
						if (inst.settings.columns[j].cellClass) {
							$td.addClass(inst.settings.columns[j].cellClass);
						}
						$td.appendTo($tr);
					}
					if (bCnt > 0) {
						$td = $("<td>");
						if (inst.settings.buttonsCellClass) {
							$td.addClass(inst.settings.buttonsCellClass);
						}
						$div = $("<div>").addClass("m-t-xs text-right").appendTo($td);
						
						for (j = 0; j < bCnt; j++) {
							if (inst.settings.buttons[j].beforeShow !== undefined) {
								if (!inst.settings.buttons[j].beforeShow.call(null, inst.settings.content.data[i])) {
									continue;
								}
							}
							$a = $("<a>", {
								"href": inst.settings.buttons[j].url.replace(inst.settings.regex.params, function () {
									return inst.settings.content.data[i][arguments[1]];
								})
							}).data("id", inst.settings.content.data[i]).addClass("btn");
							
							if (inst.settings.buttons[j].title !== undefined) {
								$a.attr("title", inst.settings.buttons[j].title);
							}
							if (inst.settings.buttons[j].target !== undefined) {
								$a.attr("target", inst.settings.buttons[j].target);
							}
							
							switch (inst.settings.buttons[j].type) {
							case "edit":
								$a.addClass("btn-primary btn-outline btn-sm m-l-xs pj-table-icon-" + inst.settings.buttons[j].type);
								$("<i>").addClass("fa fa-pencil").appendTo($a);
								break;
							case "delete":
								$a.addClass("btn-danger btn-outline btn-sm m-l-xs pj-table-icon-delete");
								$("<i>").addClass("fa fa-trash").appendTo($a);
								break;
							default:
								$a.addClass("btn-primary btn-outline btn-sm m-l-xs pj-table-icon-" + inst.settings.buttons[j].type);
								$("<i>").addClass("fa fa-" + inst.settings.buttons[j].type).appendTo($a);
							}
							
							if (inst.settings.buttons[j].type == "menu" && inst.settings.buttons[j].items !== undefined) {
								
								$group = $("<div>").addClass("btn-group m-l-xs").appendTo($div);
								$button = $("<button>").attr("data-toggle", "dropdown").addClass("btn btn-primary btn-outline btn-sm dropdown-toggle").appendTo($group);
								if (inst.settings.buttons[j].text) {
									$button.append(inst.settings.buttons[j].text + " ");
								}
								$("<i>").addClass("fa fa-caret-down").appendTo($button);
								
								$ul = $("<ul>").addClass("dropdown-menu");
								for (k = 0, kCnt = inst.settings.buttons[j].items.length; k < kCnt; k++) {
									if (inst.settings.buttons[j].items[k].beforeShow !== undefined) {
										if (!inst.settings.buttons[j].items[k].beforeShow.call(null, inst.settings.content.data[i])) {
											continue;
										}
									}
									$tmp = $("<a>", {
										"href": inst.settings.buttons[j].items[k].url.replace(inst.settings.regex.params, function () {
											return inst.settings.content.data[i][arguments[1]];
										}),
										"class": inst.settings.buttons[j].items[k].linkClass,
										"target": inst.settings.buttons[j].items[k].linkTarget
									}).html(inst.settings.buttons[j].items[k].text);
									if (inst.settings.buttons[j].items[k].title !== undefined) {
										$tmp.attr("title", inst.settings.buttons[j].items[k].title);
									}
									if (inst.settings.buttons[j].items[k].target !== undefined) {
										$tmp.attr("target", inst.settings.buttons[j].items[k].target);
									}
									if (inst.settings.buttons[j].items[k].ajax === true) {
										$tmp.bind("click.dg", function (render) {
											return function (e) {
												if (e && e.preventDefault) {
													e.preventDefault();
												}
												$.post($(this).attr("href")).done(function (data) {
													if (render === true) {
														self._loadDatagrid.call(self, target, inst.settings.dataUrl, inst.settings.content.column, inst.settings.content.direction, inst.settings.content.page, inst.settings.content.rowCount);
													}
												});
												return false;
											};
										}(inst.settings.buttons[j].items[k].render));
									}
									$li = $("<li>", {
										"class": inst.settings.buttons[j].items[k].listClass
									}).append( $tmp );
									$li.appendTo($ul);
								}
								$ul.appendTo($group);
							} else {
								if (inst.settings.buttons[j].text) {
									$a.append(inst.settings.buttons[j].text);
								}
								$a.appendTo($div);
							}
						}
						$td.appendTo($tr);
					}
					
					$tr.appendTo($tbody);
				}
			}
			
			$tbody.appendTo($table);
			$target.empty();
			
			$table.appendTo($tableWrap);
			$tableWrap.appendTo($target);
			
			if (inst.settings.select !== FALSE && $.fn.iCheck !== undefined) {
				
				$table.find(".pj-table-toggle-rows").iCheck({
					checkboxClass: 'icheckbox_square-green',
					radioClass: 'iradio_square-green',
				}).on("ifToggled", function (e) {
					var $this = $(this),
						$checkboxes = $this.closest("thead").siblings("tbody").find(".pj-table-select-row");
					if ($this.is(":checked")) {
						$checkboxes.iCheck("check").closest("tr").addClass("pj-table-row-active");
					} else {
						$checkboxes.iCheck("uncheck").closest("tr").removeClass("pj-table-row-active");
					}
				});
				
				$table.find(".pj-table-select-row").iCheck({
					checkboxClass: 'icheckbox_square-green',
					radioClass: 'iradio_square-green'
				}).on("ifToggled", function (e) {
					var $this = $(this);
					if ($this.is(":checked")) {
						$this.closest("tr").addClass("pj-table-row-active");
					} else {
						$this.closest("tr").removeClass("pj-table-row-active");
					}
				});
			}
			
			// Paginator
			if (inst.settings.paginator) {
				$div = $("<div>").addClass("row table-responsive-actions");
				
				var $pagin1 = $('<div>').addClass('row').appendTo($div);
				var $pagin2 = $('<div>').addClass('col-lg-7 col-md-5 col-sm-5').appendTo($div);
				//var $pagin1row = $('<div>').addClass('row')
				
				if (inst.settings.paginator.actions && inst.settings.paginator.actions.length) {
					
					var $actionsWrap = $("<div>").addClass("btn-group btn-block").appendTo($pagin1);
					var $btnActions = $("<button>")
						.attr("data-toggle", "dropdown")
						.addClass("btn btn-primary btn-outline dropdown-toggle btn-block")
						.append(self.messages.choose_action + " ")
						.append( $('<span>').addClass("caret") )
						.appendTo($actionsWrap);
					
					$ul = $("<ul>").addClass("dropdown-menu");
					for (i = 0, kCnt = 0, iCnt = inst.settings.paginator.actions.length; i < iCnt; i++) {
						$a = $("<a>", {
							"href": inst.settings.paginator.actions[i].url
						})
							.addClass("pj-paginator-action")
							.data("object", inst.settings.paginator.actions[i])
							.html(inst.settings.paginator.actions[i].text);
						if (inst.settings.paginator.actions[i].confirmation !== undefined) {
							kCnt += 1;
						}
						$("<li>").append($a).appendTo($ul);
					}
					$ul.appendTo($actionsWrap);
					
					$actionsWrap.wrap('<div class="col-md-6 col-sm-7" />');
				}
				
				if (inst.settings.paginator.paginate) {
	                
	                var $paginateWrap = $("<div>").addClass("input-group");
	                
	                var $group1 = $('<span>').addClass('input-group-btn').appendTo($paginateWrap);
	                $("<button>", {"type": "button"})
		                .addClass("btn btn-white pj-paginator-list-prev")
		                .prop("disabled", !(inst.settings.content.pages > 1 && inst.settings.content.page > 1))
		                .append( $('<span>').addClass("hidden-sm").html(self.messages.prev) )
		                .append( $('<i>').addClass("fa fa-step-backward visible-sm-inline-block") )
		                .appendTo($group1);
	                
	                $("<input>", {
						type: "text",
						name: "page",
						value: inst.settings.content.page
					}).addClass('form-control pj-selector-goto').appendTo($paginateWrap);
	                
	                var $group2 = $('<span>').addClass('input-group-btn').appendTo($paginateWrap);
	                $("<button>", {"type": "button"})
		                .addClass("btn btn-white pj-paginator-list-next")
		                .prop("disabled", !(inst.settings.content.pages > 1 && inst.settings.content.page != inst.settings.content.pages))
		                .append( $('<span>').addClass("hidden-sm").html(self.messages.next) )
		                .append( $('<i>').addClass("fa fa-step-forward visible-sm-inline-block") )
		                .appendTo($group2);
	                
	                $paginateWrap.appendTo($pagin1);
	                $paginateWrap.wrap('<div class="col-md-6 col-sm-5" />');
				}
				
				if (inst.settings.paginator.rowCount || inst.settings.paginator.total) {
					$wrap = $("<div>").addClass("form-inline show-total mobile-text-right").appendTo($pagin2);
				}
				if (inst.settings.paginator.rowCount) {
					
					$("<div>").addClass("form-group").append($("<label>").text(self.messages.show)).appendTo($wrap);
					
					$tmp = $("<div>").addClass("form-group m-l-xs");
					$select = $("<select>").addClass("form-control pj-selector-row-count");
					for (i = 0, iCnt = inst.settings.rowCountItems.length; i < iCnt; i += 1) {
						$option = $("<option>")
							.val(inst.settings.rowCountItems[i])
							.text(inst.settings.rowCountItems[i]);
						if (inst.settings.rowCountItems[i] == inst.settings.content.rowCount) {
							$option.prop("selected", true);
						}
						$option.appendTo($select);
					}
					$select.appendTo($tmp);
					$tmp.appendTo($wrap);
				}
				
				if (inst.settings.paginator.total) {
					$tmp = $("<div>").addClass("form-group m-l-xs");
					
					$label = $("<label>");
					if (inst.settings.paginator.rowCount) {
						$label.append(self.messages.total_prefix);
					}
					$("<strong>").text(inst.settings.content.total).appendTo($label);
					$label.append(self.messages.total_suffix)
						
					$label.appendTo($tmp);
					$tmp.appendTo($wrap);
				}
				
				$pagin1.appendTo($div);
				$pagin2.appendTo($div);
				$div.appendTo($target);
				
				$pagin1.wrap('<div class="col-lg-5 col-md-7 col-sm-7" />');
				
				$('.dropdown-toggle').each(function () {
					var $this = $(this),
						$win = $(window);
					if ($this.offset().top > ($win.scrollTop() + $win.height() - 220)) {
						$this.parent().toggleClass('dropup');
					}
				});
			}
			
			if (inst.settings.sortable) {
				self.bindSortable.call(self, target);
			}
			
			if (inst.settings.onRender !== null) {
				inst.settings.onRender.call(null);
			}
			
			$.data(target, PROP_NAME, inst);
		},
		bindSortable: function (target) {
			if ($.fn.sortable === undefined) {
				throw new Error("jQuery Sortable widget not found");
			}
			var inst = this._getInst(target);
			if (!inst) {
				return FALSE;
			}
			
			var $target = $(target),
				self = this,
				fixHelper = function(e, ui) {
					ui.children().each(function() {
						$(this).width($(this).width());
					});
					return ui;
				};
				
			$target.find(".table-sortable tbody").sortable({
				cursor: "move",
				helper: fixHelper,
				placeholder: "pj-table-row-highlight",
				update: function (event, ui) {
					var sorted = $(this).sortable("serialize", {
						key: "sort[]", 
						attribute: "data-id"
					});
					$.post(inst.settings.sortableUrl, sorted).done(function (data) {
						self._loadDatagrid.call(self, target, inst.settings.dataUrl, inst.settings.content.column, inst.settings.content.direction, inst.settings.content.page, inst.settings.content.rowCount);
					});
				}
	        });
		},
		_destroyDatagrid: function (target) {
			var inst = this._getInst(target);
			if (!inst) {
				return FALSE;
			}
			$(target).removeClass("pj-grid").off(".dg").html("");
			$(document).off(".dg");
			
			$.data(target, PROP_NAME, FALSE);
		},
		_optionDatagrid: function (target, optName, optValue) {
			var inst = this._getInst(target);
			if (!inst) {
				return FALSE;
			}
			
			if (typeof optName === 'string') {
				if (arguments.length === 2) {
					return inst.settings[optName];
				} else if (arguments.length === 3) {
					inst.settings[optName] = optValue;
				}
			} else if (typeof optName === 'object') {
				$.extend(inst.settings, optName);
			}
			$.data(target, PROP_NAME, inst);
		},
		_newInst: function(target) {
			var id = target[0].id.replace(/([^A-Za-z0-9_-])/g, '\\\\$1');
			return {
				id: id, 
				input: target, 
				uid: Math.floor(Math.random() * 99999999),
				settings: {}
			}; 
		},
		_getInst: function(target) {
			try {
				return $.data(target, PROP_NAME);
			}
			catch (err) {
				throw 'Missing instance data for this datagrid';
			}
		}
	};

	$.fn.datagrid = function (options) {
		
		var otherArgs = Array.prototype.slice.call(arguments, 1);
		if (typeof options == 'string' && options == 'isDisabled') {
			return $.datagrid['_' + options + 'Datagrid'].apply($.datagrid, [this[0]].concat(otherArgs));
		}
		
		if (options == 'option' && arguments.length == 2 && typeof arguments[1] == 'string') {
			return $.datagrid['_' + options + 'Datagrid'].apply($.datagrid, [this[0]].concat(otherArgs));
		}
		
		return this.each(function() {
			typeof options == 'string' ?
				$.datagrid['_' + options + 'Datagrid'].apply($.datagrid, [this].concat(otherArgs)) :
				$.datagrid._attachDatagrid(this, options);
		});
	};
	
	$.datagrid = new Datagrid(); // singleton instance
	$.datagrid.version = "2.0";
	$.datagrid._formatDate = Datagrid._formatDate;
	$.datagrid.formatDate = Datagrid.formatDate;
	$.datagrid.wordwrap = Datagrid.wordwrap;
})(jQuery);