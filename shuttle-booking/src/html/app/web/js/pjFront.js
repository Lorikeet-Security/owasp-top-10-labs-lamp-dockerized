(function (window, undefined){
	"use strict";
	pjQ.$.ajaxSetup({
		xhrFields: {
			withCredentials: true
		}
	});
	var document = window.document,
		validate = (pjQ.$.fn.validate !== undefined),
		routes = [
		          	{pattern: /^#!\/loadSearch$/, eventName: "loadSearch"},
		          	{pattern: /^#!\/loadLines$/, eventName: "loadLines"},
		          	{pattern: /^#!\/loadCheckout$/, eventName: "loadCheckout"},
		          	{pattern: /^#!\/loadPreview$/, eventName: "loadPreview"}
		         ];
	
	function log() {
		if (window.console && window.console.log) {
			for (var x in arguments) {
				if (arguments.hasOwnProperty(x)) {
					window.console.log(arguments[x]);
				}
			}
		}
	}
	
	function assert() {
		if (window && window.console && window.console.assert) {
			window.console.assert.apply(window.console, arguments);
		}
	}
	
	function hashBang(value) {
		if (value !== undefined && value.match(/^#!\//) !== null) {
			if (window.location.hash == value) {
				return false;
			}
			window.location.hash = value;
			return true;
		}
		
		return false;
	}
	
	function onHashChange() {
		var i, iCnt, m;
		for (i = 0, iCnt = routes.length; i < iCnt; i++) {
			m = window.location.hash.match(routes[i].pattern);
			if (m !== null) {
				pjQ.$(window).trigger(routes[i].eventName, m.slice(1));
				break;
			}
		}
		if (m === null) {
			pjQ.$(window).trigger("loadSearch");
		}
	}
	pjQ.$(window).on("hashchange", function (e) {
    	onHashChange.call(null);
    });
	
	function ShuttleBooking(opts) {
		if (!(this instanceof ShuttleBooking)) {
			return new ShuttleBooking(opts);
		}
				
		this.reset.call(this);
		this.init.call(this, opts);
		
		return this;
	}
	
	ShuttleBooking.inObject = function (val, obj) {
		var key;
		for (key in obj) {
			if (obj.hasOwnProperty(key)) {
				if (obj[key] == val) {
					return true;
				}
			}
		}
		return false;
	};
	
	ShuttleBooking.size = function(obj) {
		var key,
			size = 0;
		for (key in obj) {
			if (obj.hasOwnProperty(key)) {
				size += 1;
			}
		}
		return size;
	};
	
	ShuttleBooking.prototype = {
		reset: function () {
			this.$container = null;			
			this.container = null;
			this.opts = {};
			this.map = null;
			this.directionsDisplay = new google.maps.DirectionsRenderer();
			this.directionsService = new google.maps.DirectionsService();
			return this;
		},
		
		disableButtons: function () {
			this.$container.find(".btn").each(function (i, el) {
				pjQ.$(el).attr("disabled", "disabled");
			});
		},
		enableButtons: function () {
			this.$container.find(".btn").removeAttr("disabled");
		},
		
		init: function (opts) {
			var self = this;
			this.opts = opts;
			this.container = document.getElementById("pjSbsContainer_" + self.opts.index);
			
			self.$container = pjQ.$(self.container);
			pjQ.$("html").attr('dir',self.opts.direction);
			this.$container.on("change.sbs", ".pjSbsMenu", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var load = pjQ.$(this).val();
				if (!hashBang("#!/" + load)) 
				{
					pjQ.$(window).trigger(load);
				}
				return false;
			}).on("click.sbs", ".pjSbsStepLink", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var load = pjQ.$(this).attr('data-load');
				if (!hashBang("#!/" + load)) 
				{
					pjQ.$(window).trigger(load);
				}
				return false;
			}).on("click.sbs", ".pjSbsLocale", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}				
				self.opts.locale = pjQ.$(this).data("id");
				var dir = pjQ.$(this).data("dir");
				self.opts.direction = dir;
				var params = {};
				if(self.opts.session_id != '')
				{
					params.session_id = self.opts.session_id;
				}
				params.locale_id = self.opts.locale;
				params.index = self.opts.index;
				
				self.disableButtons.call(self);
				pjQ.$.get([self.opts.folder, "index.php?controller=pjFront&action=pjActionLocale"].join(""), params).done(function (data) {
					pjQ.$("html").attr('dir',dir);
					var i, iCnt, m;
					for (i = 0, iCnt = routes.length; i < iCnt; i++) {
						m = window.location.hash.match(routes[i].pattern);
						if (m !== null) {
							if (!hashBang("#!/" + routes[i].eventName)) {
								pjQ.$(window).trigger(routes[i].eventName, m.slice(1));
							}
							break;
						}
					}
					if (m === null) {
						if (!hashBang("#!/loadSearch")) {
							pjQ.$(window).trigger("loadSearch");
						}
					}
				}).fail(function () {
					self.enableButtons.call(self);
				});
				return false;
			}).on("click.sbs", ".pjSbs-action-radio", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				pjQ.$('.pjSbs-action-radio').removeClass('active');
				pjQ.$(this).addClass('active');
				pjQ.$(this).find('input').prop('checked', true);
				pjQ.$('.pjSbsLocationLabel').hide();
				var traveling = pjQ.$('input[name="traveling"]:checked').val();
				pjQ.$('.pjSbsLocation-' + traveling).show();
				return false;
			}).on("click.sbs", "#pjSbsHasReturn_" + self.opts.index, function (e) {
				if(pjQ.$(this).is(':checked'))
				{
					var currentDate = new Date();
					pjQ.$('#pjSbsReturnDatePick').datetimepicker({
						format: self.opts.momentDateFormat.toUpperCase(),
						locale: moment.locale('en'),
						allowInputToggle: true,
						minDate: new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()),
						ignoreReadonly: true
					});
					pjQ.$('#pjSbsReturnDatePick > .form-control').addClass('required').prop('disabled', false);
					pjQ.$('#pjSbsReturnDatePick').removeClass('return-date-pick-disabled').addClass('return-date-pick');
				}else{
					pjQ.$('#pjSbsReturnDatePick').datetimepicker('remove');
					pjQ.$('#pjSbsReturnDatePick > .form-control').removeClass('required').prop('disabled', true);
					
				}
			}).on("change.sbs", "#pjSbsLocationId_" + self.opts.index, function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var params = {};
				params.index = self.opts.index;
				params.location_id = pjQ.$(this).val();
				params.traveling = pjQ.$('input[name="traveling"]:checked').val();
				if(self.opts.session_id != '')
				{
					params.session_id = self.opts.session_id;
				}
				pjQ.$.get([self.opts.folder, "index.php?controller=pjFrontPublic&action=pjActionGetDropoffs"].join(""), params).done(function (data) {
					pjQ.$('#pjSbsDropoffWrapper_' + self.opts.index).html(data);
					self.initMap.call(self);
				}).fail(function () {
					
				});
				return false;
			}).on("change.sbs", "#pjSbsDropoffId_" + self.opts.index, function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				if(pjQ.$(this).val() != '')
				{
					self.calcRoute.call(self);
				}else{
					self.initMap.call(self);
				}
				return false;
			}).on("click.sbs", ".pjSbsAvailableTime", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var is_return = pjQ.$(this).attr('data-return');
				var line_id = pjQ.$(this).attr('data-line_id');
				var time = pjQ.$(this).attr('data-time');
				var duration = pjQ.$(this).attr('data-duration');
				var destination = pjQ.$(this).attr('data-dest');
				var params = {};
				
				if(is_return == '1')
				{
					pjQ.$('.pjSbsAvailbleReturnTime').removeClass('hour-booked').addClass('hour-available');
				}else{
					pjQ.$('.pjSbsAvailbleTime').removeClass('hour-booked').addClass('hour-available');
				}
				pjQ.$(this).parent().removeClass('hour-available').addClass('hour-booked');
				
				params.index = self.opts.index;
				params.is_return = is_return;
				params.line_id = line_id;
				params.time = time;
				params.duration = duration;
				params.destination = destination;
				if(self.opts.session_id != '')
				{
					params.session_id = self.opts.session_id;
				}
				pjQ.$.get([self.opts.folder, "index.php?controller=pjFrontEnd&action=pjActionSetTime"].join(""), params).done(function (data) {
					if(is_return == '1')
					{
						pjQ.$('.pjSbsReturnDestMessage').html("").hide();
						pjQ.$('.pjSbsReturnDestMessage-line-' + line_id).html(data.text).show();
					}else{
						pjQ.$('.pjSbsDestMessage').html("").hide();
						pjQ.$('.pjSbsDestMessage-line-' + line_id).html(data.text).show();
					}
				}).fail(function () {
					
				});
				return false;
			}).on('click.lbs', '.pjSbsUnavailableTime', function(e){
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				return false;
			}).on('click.lbs', '.pjCssLogin', function(e){
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var $loginForm = pjQ.$('#pjCssLoginForm_'+ self.opts.index);
				$loginForm.find('input[name="login_email"]').val("");
				$loginForm.find('input[name="login_password"]').val("");
				pjQ.$('#pjLoginMessage_'+ self.opts.index).html("").parent().parent().hide();
				pjQ.$('#pjCssLoginModal').modal('show');
				return false;
			}).on('click.lbs', '.pjCssLogout', function(e){
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var params = {};
				params.locale = self.opts.locale;
				params.index = self.opts.index;
				if(self.opts.session_id != '')
				{
					params.session_id = self.opts.session_id;
				}
				self.disableButtons.call(self);
				pjQ.$.get([self.opts.folder, "index.php?controller=pjFrontEnd&action=pjActionLogout"].join(""), params).done(function (data) {
					if (!hashBang("#!/loadCheckout")) 
					{
						self.loadCheckout.call(self);
					}
				}).fail(function () {
					
				});
				return false;
			}).on('click.lbs', '.pjSbsBtnStartOver', function(e){
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				if (!hashBang("#!/loadSearch")) 
				{
					self.loadSearch.call(self);
				}
				return false;
			});
			
			pjQ.$(window).on("loadSearch", this.$container, function (e) {
				self.loadSearch.call(self);
			}).on("loadLines", this.$container, function (e) {
				self.loadLines.call(self);
			}).on("loadCheckout", this.$container, function (e) {
				self.loadCheckout.call(self);
			}).on("loadPreview", this.$container, function (e) {
				self.loadPreview.call(self);
			});
			
			if (window.location.hash.length === 0) {
				this.loadSearch.call(this);
			} else {
				onHashChange.call(null);
			}
			
			pjQ.$(document).on("click.sbs", '.pjCssLinkForgotPassword', function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var $forgotForm = pjQ.$('#pjCssForgotForm_'+ self.opts.index);
				$forgotForm.find('input[name="email"]').val("");
				pjQ.$('#pjForgotMessage_'+ self.opts.index).removeClass('text-danger text-success').html("").parent().parent().hide();
				pjQ.$('#pjCssLoginModal').modal('hide');
				pjQ.$('#pjCssForgotModal').modal('show');
				return false;
			}).on("click.sbs", '.pjCssLinkLogin', function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var $loginForm = pjQ.$('#pjCssLoginForm_'+ self.opts.index);
				$loginForm.find('input[name="login_email"]').val("");
				$loginForm.find('input[name="login_password"]').val("");
				pjQ.$('#pjLoginMessage_'+ self.opts.index).html("").parent().parent().hide();
				pjQ.$('#pjCssForgotModal').modal('hide');
				pjQ.$('#pjCssLoginModal').modal('show');
				return false;
			}).on("change.sbs", "select[name='payment_method']", function () {
				self.$container.find(".pjSbsCcWrap").hide();
				self.$container.find(".pjSbsBankWrap").hide();
				switch (pjQ.$("option:selected", this).val()) {
				case 'creditcard':
					self.$container.find(".pjSbsCcWrap").show();
					break;
				case 'bank':
					self.$container.find(".pjSbsBankWrap").show();
					break;
				}
			}).on("click.sbs", "#pjSbsCaptchaImage_" + self.opts.index, function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var $captcha = pjQ.$(this);
				var $form = $captcha.closest("form");
				$captcha.attr("src", $captcha.attr("src").replace(/(&rand=)\d+/g, '\$1' + Math.ceil(Math.random() * 99999)));
				pjQ.$('#pjSbsCaptchaField_' + self.opts.index).val("").removeData("previousValue");
			}).on("click.sbs", 'button[data-dismiss="modal"]', function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var $modal = pjQ.$(this).closest('.modal');
				if ($modal !== undefined && $modal.length > 0) {
					$modal.modal('hide');
					pjQ.$('body').removeClass('modal-open');
				}
				return false;
			});
		},
		
		loopPrices: function() {
			var self = this;
			pjQ.$('.pjSbsServiceSelector').each(function(e){
				var service_id = pjQ.$(this).val();
				pjQ.$('#pjSbsPriceLabel_' + service_id).show();
			});
		},
		loadSearch: function () {
			var self = this,
				index = this.opts.index,
				params = {};
			params.locale = this.opts.locale;
			params.index = this.opts.index;
			if(self.opts.session_id != '')
			{
				params.session_id = self.opts.session_id;
			}
			pjQ.$.get([this.opts.folder, "index.php?controller=pjFrontPublic&action=pjActionSearch"].join(""), params).done(function (data) {
				self.$container.html(data);
				self.bindSearch.call(self);
			}).fail(function () {
				
			});
		},
		bindSearch: function(){
			var self = this,
				index = this.opts.index;
			pjQ.$('.modal-dialog').css("z-index", "9999"); 
			if(pjQ.$('#pjSbsMapCanvas').length > 0)
			{
				self.initMap.call(self);
			}
			if(pjQ.$('#pjSbsCalendarLocale').length > 0)
			{
				var fday = parseInt(pjQ.$('#pjSbsCalendarLocale').data('fday'), 10);
				moment.updateLocale('en', {
					months : pjQ.$('#pjSbsCalendarLocale').data('months').split("_"),
			        weekdaysMin : pjQ.$('#pjSbsCalendarLocale').data('days').split("_"),
			        week: { dow: fday }
				});
			}
			
			if(pjQ.$('.date-pick').length > 0)
			{
				var currentDate = new Date();
				pjQ.$('.date-pick').datetimepicker({
					format: self.opts.momentDateFormat.toUpperCase(),
					locale: moment.locale('en'),
					allowInputToggle: true,
					minDate: new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()),
					ignoreReadonly: true
				});
			}
			if(pjQ.$('#pjSbsReturnDatePick').length > 0)
			{
				if(pjQ.$('#pjSbsHasReturn_' + self.opts.index).is(':checked'))
				{
					var currentDate = new Date();
					pjQ.$('#pjSbsReturnDatePick').datetimepicker({
						format: self.opts.momentDateFormat.toUpperCase(),
						locale: moment.locale('en'),
						allowInputToggle: true,
						minDate: new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()),
						ignoreReadonly: true
					});
				}
			}
			if (pjQ.$('.pjSbs-spinner').length) {
		        var spinnerUpClass = 'pjSbs-spinner-up';
		        var spinnerDownClass = 'pjSbs-spinner-down';
		        var spinnerResult = '.pjSbs-spinner-result';

		        pjQ.$('.pjSbs-spinner').on('click', '.pjSbs-spinner', function(e) {
		            var $clickedSpinnerBtn = pjQ.$(this);
		            var $spinnerField = $clickedSpinnerBtn.siblings(spinnerResult);
		            var $spinnerValue = $spinnerField.val();
		            var $maxValue = parseInt($spinnerField.attr('data-max'), 10);
		           
		            if ($clickedSpinnerBtn.hasClass(spinnerUpClass)) {
		                $spinnerValue = $spinnerValue +++ 1;
		            } else if ($clickedSpinnerBtn.hasClass(spinnerDownClass)) {
		                $spinnerValue = $spinnerValue --- 1;
		            };
		            if($spinnerField.attr('name') == 'passengers')
		            {
		            	if ($spinnerValue <= 1) {
			                $spinnerValue = 1;
			            };
		            }else{
		            	if ($spinnerValue <= 0) {
			                $spinnerValue = '';
			            };
		            }
		            if ($spinnerValue >= $maxValue) {
		                $spinnerValue = $maxValue;
		            };
		            $spinnerField.val($spinnerValue);

		            e.preventDefault();
		        });
		    };
		    if (validate) 
			{
				var $form = pjQ.$('#pjSbsSearchForm_'+ self.opts.index);
				$form.validate({
					onkeyup: false,
					errorElement: 'li',
					ignore: '',
					errorPlacement: function (error, element) {
						if(element.attr('name') == 'booking_date' || element.attr('name') == 'return_date')
						{
							error.appendTo(element.parent().next().find('ul'));
						}else if(element.attr('name') == 'terms' || element.attr('name') == 'passengers'){
							error.appendTo(element.parent().parent().next().find('ul'));
						}else{
							error.appendTo(element.next().find('ul'));
						}
					},
		            highlight: function(ele, errorClass, validClass) {
		            	var element = pjQ.$(ele);
		            	if(element.attr('name') == 'booking_date' || element.attr('name') == 'return_date')
						{
							element.parent().parent().removeClass('has-success').addClass('has-error');
						}else if(element.attr('name') == 'terms' || element.attr('name') == 'passengers'){
							element.parent().parent().parent().removeClass('has-success').addClass('has-error');
						}else{
							element.parent().removeClass('has-success').addClass('has-error');
						}
		            },
		            unhighlight: function(ele, errorClass, validClass) {
		            	var element = pjQ.$(ele);
		            	if(element.attr('name') == 'booking_date' || element.attr('name') == 'return_date')
						{
							element.parent().parent().removeClass('has-error').addClass('has-success');
						}else if(element.attr('name') == 'terms' || element.attr('name') == 'passengers'){
							element.parent().parent().parent().removeClass('has-error').addClass('has-success');
						}else{
							element.parent().removeClass('has-error').addClass('has-success');
						}
		            },
					submitHandler: function (form) {
						self.disableButtons.call(self);
						var $form = pjQ.$(form);
						pjQ.$.post([self.opts.folder, "index.php?controller=pjFrontPublic&action=pjActionSearch", "&session_id=", self.opts.session_id].join(""), $form.serialize()).done(function (data) {
							if (data.status == "OK") {
								if (!hashBang("#!/loadLines")) 
								{
									self.loadLines.call(self);
								}
							}else{
								pjQ.$('.modal-dialog').css("z-index", "9999"); 
								var $dateMessage = pjQ.$('#pjInvalidDateMessage_'+ self.opts.index);
								$dateMessage.html(data.text);
								pjQ.$('#pjSbsInvalidDateModal').modal('show');
								self.enableButtons.call(self);
							}
						}).fail(function () {
							self.enableButtons.call(self);
						});
						return false;
					}
				});
			}
		},
		loadLines: function () {
			var self = this,
				index = this.opts.index,
				params = {};
			params.locale = this.opts.locale;
			params.index = this.opts.index;
			if(self.opts.session_id != '')
			{
				params.session_id = self.opts.session_id;
			}
			pjQ.$.get([this.opts.folder, "index.php?controller=pjFrontPublic&action=pjActionLines"].join(""), params).done(function (data) {
				if (data.code != undefined && data.status == 'ERR') {
					if (!hashBang("#!/loadSearch")) 
					{
						self.loadSearch.call(self);
					}
				}else{
					self.$container.html(data);
					self.bindLines.call(self);
					pjQ.$('html, body').animate({
				        scrollTop: self.$container.offset().top
				    }, 500);
				}
			}).fail(function () {
				
			});
		},
		bindLines: function(){
			var self = this,
				index = this.opts.index;
			
		    if (validate) 
			{
				var $form = pjQ.$('#pjSbsLinesForm_'+ self.opts.index);
				$form.validate({
					onkeyup: false,
					errorElement: 'li',
					ignore: '',
					submitHandler: function (form) {
						self.disableButtons.call(self);
						pjQ.$.get([self.opts.folder, "index.php?controller=pjFrontEnd&action=pjActionCheckTime", "&session_id=", self.opts.session_id].join("")).done(function (data) {
							if(data.status == 'OK')
							{
								if (!hashBang("#!/loadCheckout")) 
								{
									self.loadCheckout.call(self);
								}
							}else{
								pjQ.$('.modal-dialog').css("z-index", "9999"); 
								var $timeMessage = pjQ.$('#pjSelectTimeMessage_'+ self.opts.index);
								$timeMessage.html(data.text);
								pjQ.$('#pjSbsEarlierModal').modal('show');
								self.enableButtons.call(self);
							}
						}).fail(function () {
							self.enableButtons.call(self);
						});
						return false;
					}
				});
			}
		},
		loadCheckout: function () {
			var self = this,
				index = this.opts.index,
				params = {};
			params.locale = this.opts.locale;
			params.index = this.opts.index;
			if(self.opts.session_id != '')
			{
				params.session_id = self.opts.session_id;
			}
			pjQ.$.get([this.opts.folder, "index.php?controller=pjFrontPublic&action=pjActionCheckout"].join(""), params).done(function (data) {
				if (data.code != undefined && data.status == 'ERR') {
					if (!hashBang("#!/loadLines")) 
					{
						self.loadLines.call(self);
					}
				}else{
					self.$container.html(data);
					self.bindCheckout.call(self);
					pjQ.$('html, body').animate({
				        scrollTop: self.$container.offset().top
				    }, 500);
				}
			}).fail(function () {
				
			});
		},
		calcPrices: function(){
			var self = this;
			
			var $form = pjQ.$('#pjSbsCheckoutForm_'+ self.opts.index);
			
			var ajax_url = [self.opts.folder, "index.php?controller=pjFrontPublic&action=pjActionGetPrices"].join("");
			if(self.opts.session_id != '')
			{
				ajax_url = [self.opts.folder, "index.php?controller=pjFrontPublic&action=pjActionGetPrices", "&session_id=", self.opts.session_id].join("")
			}
			self.disableButtons.call(self);
			pjQ.$.post(ajax_url, $form.serialize()).done(function (data) {
				pjQ.$('#pjSbsPriceBox').html(data);
				self.enableButtons.call(self);
			}).fail(function () {
				self.enableButtons.call(self);
			});
		},
		initMap: function(){
			var self = this;
			
			var $fromSelector = pjQ.$('#pjSbsLocationId_' + self.opts.index);
			var $toSelector = pjQ.$('#pjSbsDropoffId_' + self.opts.index);
			
			if($fromSelector.val() != '' && $toSelector.find('option').length > 0)
			{
				var mapOptions = {
						zoom: self.opts.zoom,
						mapTypeId: google.maps.MapTypeId.ROADMAP
					};
				self.map = new google.maps.Map(document.getElementById("pjSbsMapCanvas"), mapOptions);
				
				var LatLngList = [];
				var previous_infoWindow = false
				var infowindow = new google.maps.InfoWindow();
				var geocoder = new google.maps.Geocoder();
				$toSelector.find('option').each(function(){
					var address = pjQ.$(this).attr('data-address');
					var lat = parseFloat(pjQ.$(this).attr('data-lat'));
					var lng = parseFloat(pjQ.$(this).attr('data-lng'));
					if(address != undefined && !isNaN(lat) && !isNaN(lng))
					{
						var location_id = pjQ.$(this).attr('value');
						var myLatlng = new google.maps.LatLng(lat, lng);
						var marker = new google.maps.Marker({
							map: self.map,
							position: myLatlng
						});
			        	var infoWindow = new google.maps.InfoWindow({
							content: address
						});
			        	self.map.setCenter(myLatlng);
			        	LatLngList.push(myLatlng);
						google.maps.event.addListener(marker, "click", function() {
							if(previous_infoWindow)
							{
								previous_infoWindow.close();
							}
							previous_infoWindow = infoWindow;
							infoWindow.open(self.map, marker);
							$toSelector.val(location_id);
							self.calcRoute.call(self);
						});
					}
				});
				var bounds = new google.maps.LatLngBounds();
				for (var j = 0, len = LatLngList.length; j < len; j++) {
					bounds.extend(LatLngList[j]);
				}
				self.map.fitBounds(bounds);
			}
		},
		calcRoute: function(){
			var self = this;
			var $fromSelector = pjQ.$('#pjSbsLocationId_' + self.opts.index);
			var $toSelector = pjQ.$('#pjSbsDropoffId_' + self.opts.index);
	        if($fromSelector.val() != '' && $toSelector.val() != '')
	        {
	        	var fromAddress = $fromSelector.find('option:selected').attr('data-address');
	        	var toAddress = $toSelector.find('option:selected').attr('data-address');
	        	if(fromAddress != '' && toAddress != '')
	        	{
	        		self.directionsDisplay.setMap(self.map);
		        	var request = {
			        		origin: fromAddress,
			        		destination: toAddress,
			        		travelMode: google.maps.DirectionsTravelMode.DRIVING
		              	};
			        self.directionsService.route(request, function(response, status) {
			        	if (status == google.maps.DirectionsStatus.OK) {
			        		var distanceinkm = parseInt(response.routes[0].legs[0].distance.value / 1000, 10);
			        		if(self.opts.mileage == 'km')
			        		{
			        			pjQ.$('#pjSbsDistanceField').val(distanceinkm);
			        		}else{
			        			var meters = distanceinkm * 1000;
			        			var distance_miles = parseInt(meters * 0.00062137, 10);
			        			pjQ.$('#pjSbsDistanceField').val(distance_miles);
			        		}
			            }
			         });
	        	}else{
	        		self.directionsDisplay.setMap(null);
		        	pjQ.$('#pjSbsDistanceField').val("");
	        	}
	        }else{
	        	self.directionsDisplay.setMap(null);
	        	pjQ.$('#pjSbsDistanceField').val("");
	        }
		},
		
		bindCheckout: function(){
			var self = this,
				index = this.opts.index;
		
			pjQ.$('.modal-dialog').css("z-index", "9999"); 
			pjQ.$('.time-pick').datetimepicker({
				format: self.opts.time_format,
				ignoreReadonly: true,
				allowInputToggle: true
			});
			if (validate) 
			{
				var $form = pjQ.$('#pjSbsCheckoutForm_'+ self.opts.index);
				var remote_url = self.opts.folder + "index.php?controller=pjFrontEnd&action=pjActionCheckCaptcha";
				if(self.opts.session_id != '')
				{
					remote_url += "&session_id=" + self.opts.session_id;
				}
				
				var $reCaptcha = self.$container.find('#g-recaptcha');
				if ($reCaptcha.length > 0)
	            {
	                grecaptcha.render($reCaptcha.attr('id'), {
	                    sitekey: $reCaptcha.data('sitekey'),
	                    callback: function(response) {
	                        var elem = pjQ.$("input[name='recaptcha']");
	                        elem.val(response);
	                        elem.valid();
	                    }
	                });
	            }
				$form.validate({
					rules: {
						"captcha": {
							remote: remote_url
						}
					},
					onkeyup: false,
					errorElement: 'li',
					errorPlacement: function (error, element) {
						if(element.attr('name') == 'c_flight_time')
						{
							error.appendTo(element.parent().next().find('ul'));
						}else if(element.attr('name') == 'terms'){
							error.appendTo(element.parent().parent().next().find('ul'));
						}else{
							error.appendTo(element.next().find('ul'));
						}
					},
		            highlight: function(ele, errorClass, validClass) {
		            	var element = pjQ.$(ele);
		            	if(element.attr('name') == 'c_flight_time')
						{
							element.parent().parent().removeClass('has-success').addClass('has-error');
						}else if(element.attr('name') == 'terms'){
							element.parent().parent().parent().removeClass('has-success').addClass('has-error');
						}else{
							element.parent().removeClass('has-success').addClass('has-error');
						}
		            },
		            unhighlight: function(ele, errorClass, validClass) {
		            	var element = pjQ.$(ele);
		            	if(element.attr('name') == 'c_flight_time')
						{
							element.parent().parent().removeClass('has-error').addClass('has-success');
						}else if(element.attr('name') == 'terms'){
							element.parent().parent().parent().removeClass('has-error').addClass('has-success');
						}else{
							element.parent().removeClass('has-error').addClass('has-success');
						}
		            },
					submitHandler: function (form) {
						self.disableButtons.call(self);
						var $form = pjQ.$(form);
						pjQ.$.post([self.opts.folder, "index.php?controller=pjFrontPublic&action=pjActionCheckout", "&session_id=", self.opts.session_id].join(""), $form.serialize()).done(function (data) {
							if (data.status == "OK") {
								if (!hashBang("#!/loadPreview")) 
								{
									self.loadPreview.call(self);
								}
							}
						}).fail(function () {
							self.enableButtons.call(self);
						});
						return false;
					}
				});
				
				var $form = pjQ.$('#pjCssLoginForm_'+ self.opts.index);
				$form.validate({
					onkeyup: false,
					errorElement: 'li',
					errorPlacement: function (error, element) {
						error.appendTo(element.next().find('ul'));
					},
		            highlight: function(ele, errorClass, validClass) {
		            	var element = pjQ.$(ele);
		            	element.parent().removeClass('has-success').addClass('has-error');
		            },
		            unhighlight: function(ele, errorClass, validClass) {
		            	var element = pjQ.$(ele);
		            	element.parent().removeClass('has-error').addClass('has-success');
		            },
					submitHandler: function (form) {
						self.disableButtons.call(self);
						var $form = pjQ.$(form);
						pjQ.$.post([self.opts.folder, "index.php?controller=pjFrontEnd&action=pjActionCheckLogin", "&session_id=", self.opts.session_id].join(""), $form.serialize()).done(function (data) {
							if(data.code == '200')
							{
								pjQ.$('#pjCssLoginModal').modal('hide');
								if (!hashBang("#!/loadCheckout")) 
								{
									self.loadCheckout.call(self);
								}
							}else{
								var $loginMessage = pjQ.$('#pjLoginMessage_'+ self.opts.index);
								$loginMessage.html(data.text);
								$loginMessage.parent().parent().show();
							}
						}).fail(function () {
							self.enableButtons.call(self);
						});
						return false;
					}
				});
				
				var $form = pjQ.$('#pjCssForgotForm_'+ self.opts.index);
				$form.validate({
					onkeyup: false,
					errorElement: 'li',
					errorPlacement: function (error, element) {
						if(element.attr('name') == 'terms')
						{
							error.appendTo(element.parent().next().find('ul'));
						}else{
							error.appendTo(element.next().find('ul'));
						}
					},
		            highlight: function(ele, errorClass, validClass) {
		            	var element = pjQ.$(ele);
		            	element.parent().removeClass('has-success').addClass('has-error');
		            },
		            unhighlight: function(ele, errorClass, validClass) {
		            	var element = pjQ.$(ele);
		            	element.parent().removeClass('has-error').addClass('has-success');
		            },
					submitHandler: function (form) {
						self.disableButtons.call(self);
						var $form = pjQ.$(form);
						pjQ.$.post([self.opts.folder, "index.php?controller=pjFrontEnd&action=pjActionSendPassword", "&session_id=", self.opts.session_id].join(""), $form.serialize()).done(function (data) {
							var $forgotMessage = pjQ.$('#pjForgotMessage_'+ self.opts.index);
							if(data.code == '200')
							{
								$forgotMessage.addClass('text-success');
							}else{
								$forgotMessage.addClass('text-danger');
							}
							$forgotMessage.html(data.text);
							$forgotMessage.parent().parent().show();
						}).fail(function () {
							self.enableButtons.call(self);
						});
						return false;
					}
				});
			}
		},
		loadPreview: function () {
			var self = this,
				index = this.opts.index,
				params = {};
			params.locale = this.opts.locale;
			params.index = this.opts.index;
			if(self.opts.session_id != '')
			{
				params.session_id = self.opts.session_id;
			}
			pjQ.$.get([this.opts.folder, "index.php?controller=pjFrontPublic&action=pjActionPreview"].join(""), params).done(function (data) {
				if (data.code != undefined && data.status == 'ERR') {
					if (!hashBang("#!/loadLines")) 
					{
						self.loadLines.call(self);
					}
				}else{
					self.$container.html(data);
					self.bindPreview.call(self);
					pjQ.$('html, body').animate({
				        scrollTop: self.$container.offset().top
				    }, 500);
				}
			}).fail(function () {
				
			});
		},
		bindPreview: function(){
			var self = this,
				index = this.opts.index;
		
			if (validate) 
			{
				var $form = pjQ.$('#pjSbsPreviewForm_'+ self.opts.index);
				$form.validate({
					submitHandler: function (form) {
						self.disableButtons.call(self);
						var $form = pjQ.$(form);
						pjQ.$.post([self.opts.folder, "index.php?controller=pjFrontEnd&action=pjActionSaveBooking", "&session_id=", self.opts.session_id].join(""), $form.serialize()).done(function (data) {
							if (data.code == "200") {
								self.getPaymentForm.call(self, data);
							} else if (data.code == "119") {
								self.enableButtons.call(self);
							}
						}).fail(function () {
							self.enableButtons.call(self);
						});
						return false;
					}
				});
			}
		},
		getPaymentForm: function(obj){
			var self = this,
				index = this.opts.index;
			var	params = {};
			params.locale = self.opts.locale;
			params.index = self.opts.index;
			params.booking_id =  obj.booking_id;
			params.payment_method = obj.payment;
			if(self.opts.session_id != '')
			{
				params.session_id = self.opts.session_id;
			}
			pjQ.$.get([this.opts.folder, "index.php?controller=pjFrontPublic&action=pjActionGetPaymentForm"].join(""), params).done(function (data) {
				self.$container.html(data);
				pjQ.$('html, body').animate({
			        scrollTop: self.$container.offset().top
			    }, 500);
				var $payment_form = self.$container.find("form[name='pjOnlinePaymentForm']").first();
				if ($payment_form.length > 0) {
					$payment_form.trigger('submit');
				}
			}).fail(function () {
				log("Deferred is rejected");
			});
		}
	};
	
	window.ShuttleBooking = ShuttleBooking;	
})(window);