/*!
 * jQuery UI :data 1.13.2
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery","./version"],e):e(jQuery)}(function(r){"use strict";return r.extend(r.expr.pseudos,{data:r.expr.createPseudo?r.expr.createPseudo(function(n){return function(e){return!!r.data(e,n)}}):function(e,n,t){return!!r.data(e,t[3])}})});;
/*!
 * jQuery UI Disable Selection 1.13.2
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery","./version"],e):e(jQuery)}(function(e){"use strict";return e.fn.extend({disableSelection:(n="onselectstart"in document.createElement("div")?"selectstart":"mousedown",function(){return this.on(n+".ui-disableSelection",function(e){e.preventDefault()})}),enableSelection:function(){return this.off(".ui-disableSelection")}});var n});;
!function(t){"use strict";"function"==typeof define&&define.amd?define(["jquery","./version"],t):t(jQuery)}(function(t){"use strict";return t.fn._form=function(){return"string"==typeof this[0].form?this.closest("form"):t(this[0].form)}});;
/*!
 * jQuery UI Labels 1.13.2
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
!function(t){"use strict";"function"==typeof define&&define.amd?define(["jquery","./version"],t):t(jQuery)}(function(i){"use strict";return i.fn.labels=function(){var t,e,s;return this.length?this[0].labels&&this[0].labels.length?this.pushStack(this[0].labels):(e=this.eq(0).parents("label"),(t=this.attr("id"))&&(s=(s=this.eq(0).parents().last()).add((s.length?s:this).siblings()),t="label[for='"+i.escapeSelector(t)+"']",e=e.add(s.find(t).addBack(t))),this.pushStack(e)):this.pushStack([])}});;
/*!
 * jQuery UI Scroll Parent 1.13.2
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
!function(t){"use strict";"function"==typeof define&&define.amd?define(["jquery","./version"],t):t(jQuery)}(function(o){"use strict";return o.fn.scrollParent=function(t){var e=this.css("position"),s="absolute"===e,n=t?/(auto|scroll|hidden)/:/(auto|scroll)/,t=this.parents().filter(function(){var t=o(this);return(!s||"static"!==t.css("position"))&&n.test(t.css("overflow")+t.css("overflow-y")+t.css("overflow-x"))}).eq(0);return"fixed"!==e&&t.length?t:o(this[0].ownerDocument||document)}});;
/*!
 * jQuery UI Tabbable 1.13.2
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery","./version","./focusable"],e):e(jQuery)}(function(u){"use strict";return u.extend(u.expr.pseudos,{tabbable:function(e){var n=u.attr(e,"tabindex"),t=null!=n;return(!t||0<=n)&&u.ui.focusable(e,t)}})});;
/*!
 * jQuery UI Unique ID 1.13.2
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
!function(i){"use strict";"function"==typeof define&&define.amd?define(["jquery","./version"],i):i(jQuery)}(function(i){"use strict";return i.fn.extend({uniqueId:(e=0,function(){return this.each(function(){this.id||(this.id="ui-id-"+ ++e)})}),removeUniqueId:function(){return this.each(function(){/^ui-id-\d+$/.test(this.id)&&i(this).removeAttr("id")})}});var e});;
!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery"],e):e(jQuery)}(function(e){"use strict";return e.ui=e.ui||{},e.ui.version="1.13.2"});;
/*!
 * jQuery UI Support for jQuery core 1.8.x and newer 1.13.2
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 *
 */
!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery","./version"],e):e(jQuery)}(function(e){"use strict";var n,t;e.expr.pseudos||(e.expr.pseudos=e.expr[":"]),e.uniqueSort||(e.uniqueSort=e.unique),e.escapeSelector||(n=/([\0-\x1f\x7f]|^-?\d)|^-$|[^\x80-\uFFFF\w-]/g,t=function(e,n){return n?"\0"===e?"�":e.slice(0,-1)+"\\"+e.charCodeAt(e.length-1).toString(16)+" ":"\\"+e},e.escapeSelector=function(e){return(e+"").replace(n,t)}),e.fn.even&&e.fn.odd||e.fn.extend({even:function(){return this.filter(function(e){return e%2==0})},odd:function(){return this.filter(function(e){return e%2==1})}})});;
/*!
 * jQuery UI Focusable 1.13.2
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery","./version"],e):e(jQuery)}(function(u){"use strict";return u.ui.focusable=function(e,i){var t,n,s,r=e.nodeName.toLowerCase();return"area"===r?(s=(t=e.parentNode).name,!(!e.href||!s||"map"!==t.nodeName.toLowerCase())&&(0<(t=u("img[usemap='#"+s+"']")).length&&t.is(":visible"))):(/^(input|select|textarea|button|object)$/.test(r)?(n=!e.disabled)&&(s=u(e).closest("fieldset")[0])&&(n=!s.disabled):n="a"===r&&e.href||i,n&&u(e).is(":visible")&&function(e){var i=e.css("visibility");for(;"inherit"===i;)e=e.parent(),i=e.css("visibility");return"visible"===i}(u(e)))},u.extend(u.expr.pseudos,{focusable:function(e){return u.ui.focusable(e,null!=u.attr(e,"tabindex"))}}),u.ui.focusable});;
/*!
 * jQuery UI Form Reset Mixin 1.13.2
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery","./form","./version"],e):e(jQuery)}(function(r){"use strict";return r.ui.formResetMixin={_formResetHandler:function(){var t=r(this);setTimeout(function(){var e=t.data("ui-form-reset-instances");r.each(e,function(){this.refresh()})})},_bindFormResetHandler:function(){var e;this.form=this.element._form(),this.form.length&&((e=this.form.data("ui-form-reset-instances")||[]).length||this.form.on("reset.ui-form-reset",this._formResetHandler),e.push(this),this.form.data("ui-form-reset-instances",e))},_unbindFormResetHandler:function(){var e;this.form.length&&((e=this.form.data("ui-form-reset-instances")).splice(r.inArray(this,e),1),e.length?this.form.data("ui-form-reset-instances",e):this.form.removeData("ui-form-reset-instances").off("reset.ui-form-reset"))}}});;
!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery","./version"],e):e(jQuery)}(function(e){"use strict";return e.ui.ie=!!/msie [\w.]+/.exec(navigator.userAgent.toLowerCase())});;
/*!
 * jQuery UI Keycode 1.13.2
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery","./version"],e):e(jQuery)}(function(e){"use strict";return e.ui.keyCode={BACKSPACE:8,COMMA:188,DELETE:46,DOWN:40,END:35,ENTER:13,ESCAPE:27,HOME:36,LEFT:37,PAGE_DOWN:34,PAGE_UP:33,PERIOD:190,RIGHT:39,SPACE:32,TAB:9,UP:38}});;
!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery","./version"],e):e(jQuery)}(function(o){"use strict";return o.ui.plugin={add:function(e,n,i){var t,u=o.ui[e].prototype;for(t in i)u.plugins[t]=u.plugins[t]||[],u.plugins[t].push([n,i[t]])},call:function(e,n,i,t){var u,o=e.plugins[n];if(o&&(t||e.element[0].parentNode&&11!==e.element[0].parentNode.nodeType))for(u=0;u<o.length;u++)e.options[o[u][0]]&&o[u][1].apply(e.element,i)}}});;
!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery","./version"],e):e(jQuery)}(function(e){"use strict";return e.ui.safeActiveElement=function(n){var t;try{t=n.activeElement}catch(e){t=n.body}return t=(t=t||n.body).nodeName?t:n.body}});;
!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery","./version"],e):e(jQuery)}(function(n){"use strict";return n.ui.safeBlur=function(e){e&&"body"!==e.nodeName.toLowerCase()&&n(e).trigger("blur")}});;
/*!
 * jQuery UI Widget 1.13.2
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
!function(t){"use strict";"function"==typeof define&&define.amd?define(["jquery","./version"],t):t(jQuery)}(function(u){"use strict";var n,i=0,a=Array.prototype.hasOwnProperty,r=Array.prototype.slice;return u.cleanData=(n=u.cleanData,function(t){for(var e,i,s=0;null!=(i=t[s]);s++)(e=u._data(i,"events"))&&e.remove&&u(i).triggerHandler("remove");n(t)}),u.widget=function(t,i,e){var s,n,o,a={},r=t.split(".")[0],l=r+"-"+(t=t.split(".")[1]);return e||(e=i,i=u.Widget),Array.isArray(e)&&(e=u.extend.apply(null,[{}].concat(e))),u.expr.pseudos[l.toLowerCase()]=function(t){return!!u.data(t,l)},u[r]=u[r]||{},s=u[r][t],n=u[r][t]=function(t,e){if(!this||!this._createWidget)return new n(t,e);arguments.length&&this._createWidget(t,e)},u.extend(n,s,{version:e.version,_proto:u.extend({},e),_childConstructors:[]}),(o=new i).options=u.widget.extend({},o.options),u.each(e,function(e,s){function n(){return i.prototype[e].apply(this,arguments)}function o(t){return i.prototype[e].apply(this,t)}a[e]="function"!=typeof s?s:function(){var t,e=this._super,i=this._superApply;return this._super=n,this._superApply=o,t=s.apply(this,arguments),this._super=e,this._superApply=i,t}}),n.prototype=u.widget.extend(o,{widgetEventPrefix:s&&o.widgetEventPrefix||t},a,{constructor:n,namespace:r,widgetName:t,widgetFullName:l}),s?(u.each(s._childConstructors,function(t,e){var i=e.prototype;u.widget(i.namespace+"."+i.widgetName,n,e._proto)}),delete s._childConstructors):i._childConstructors.push(n),u.widget.bridge(t,n),n},u.widget.extend=function(t){for(var e,i,s=r.call(arguments,1),n=0,o=s.length;n<o;n++)for(e in s[n])i=s[n][e],a.call(s[n],e)&&void 0!==i&&(u.isPlainObject(i)?t[e]=u.isPlainObject(t[e])?u.widget.extend({},t[e],i):u.widget.extend({},i):t[e]=i);return t},u.widget.bridge=function(o,e){var a=e.prototype.widgetFullName||o;u.fn[o]=function(i){var t="string"==typeof i,s=r.call(arguments,1),n=this;return t?this.length||"instance"!==i?this.each(function(){var t,e=u.data(this,a);return"instance"===i?(n=e,!1):e?"function"!=typeof e[i]||"_"===i.charAt(0)?u.error("no such method '"+i+"' for "+o+" widget instance"):(t=e[i].apply(e,s))!==e&&void 0!==t?(n=t&&t.jquery?n.pushStack(t.get()):t,!1):void 0:u.error("cannot call methods on "+o+" prior to initialization; attempted to call method '"+i+"'")}):n=void 0:(s.length&&(i=u.widget.extend.apply(null,[i].concat(s))),this.each(function(){var t=u.data(this,a);t?(t.option(i||{}),t._init&&t._init()):u.data(this,a,new e(i,this))})),n}},u.Widget=function(){},u.Widget._childConstructors=[],u.Widget.prototype={widgetName:"widget",widgetEventPrefix:"",defaultElement:"<div>",options:{classes:{},disabled:!1,create:null},_createWidget:function(t,e){e=u(e||this.defaultElement||this)[0],this.element=u(e),this.uuid=i++,this.eventNamespace="."+this.widgetName+this.uuid,this.bindings=u(),this.hoverable=u(),this.focusable=u(),this.classesElementLookup={},e!==this&&(u.data(e,this.widgetFullName,this),this._on(!0,this.element,{remove:function(t){t.target===e&&this.destroy()}}),this.document=u(e.style?e.ownerDocument:e.document||e),this.window=u(this.document[0].defaultView||this.document[0].parentWindow)),this.options=u.widget.extend({},this.options,this._getCreateOptions(),t),this._create(),this.options.disabled&&this._setOptionDisabled(this.options.disabled),this._trigger("create",null,this._getCreateEventData()),this._init()},_getCreateOptions:function(){return{}},_getCreateEventData:u.noop,_create:u.noop,_init:u.noop,destroy:function(){var i=this;this._destroy(),u.each(this.classesElementLookup,function(t,e){i._removeClass(e,t)}),this.element.off(this.eventNamespace).removeData(this.widgetFullName),this.widget().off(this.eventNamespace).removeAttr("aria-disabled"),this.bindings.off(this.eventNamespace)},_destroy:u.noop,widget:function(){return this.element},option:function(t,e){var i,s,n,o=t;if(0===arguments.length)return u.widget.extend({},this.options);if("string"==typeof t)if(o={},t=(i=t.split(".")).shift(),i.length){for(s=o[t]=u.widget.extend({},this.options[t]),n=0;n<i.length-1;n++)s[i[n]]=s[i[n]]||{},s=s[i[n]];if(t=i.pop(),1===arguments.length)return void 0===s[t]?null:s[t];s[t]=e}else{if(1===arguments.length)return void 0===this.options[t]?null:this.options[t];o[t]=e}return this._setOptions(o),this},_setOptions:function(t){for(var e in t)this._setOption(e,t[e]);return this},_setOption:function(t,e){return"classes"===t&&this._setOptionClasses(e),this.options[t]=e,"disabled"===t&&this._setOptionDisabled(e),this},_setOptionClasses:function(t){var e,i,s;for(e in t)s=this.classesElementLookup[e],t[e]!==this.options.classes[e]&&s&&s.length&&(i=u(s.get()),this._removeClass(s,e),i.addClass(this._classes({element:i,keys:e,classes:t,add:!0})))},_setOptionDisabled:function(t){this._toggleClass(this.widget(),this.widgetFullName+"-disabled",null,!!t),t&&(this._removeClass(this.hoverable,null,"ui-state-hover"),this._removeClass(this.focusable,null,"ui-state-focus"))},enable:function(){return this._setOptions({disabled:!1})},disable:function(){return this._setOptions({disabled:!0})},_classes:function(n){var o=[],a=this;function t(t,e){for(var i,s=0;s<t.length;s++)i=a.classesElementLookup[t[s]]||u(),i=n.add?(function(){var i=[];n.element.each(function(t,e){u.map(a.classesElementLookup,function(t){return t}).some(function(t){return t.is(e)})||i.push(e)}),a._on(u(i),{remove:"_untrackClassesElement"})}(),u(u.uniqueSort(i.get().concat(n.element.get())))):u(i.not(n.element).get()),a.classesElementLookup[t[s]]=i,o.push(t[s]),e&&n.classes[t[s]]&&o.push(n.classes[t[s]])}return(n=u.extend({element:this.element,classes:this.options.classes||{}},n)).keys&&t(n.keys.match(/\S+/g)||[],!0),n.extra&&t(n.extra.match(/\S+/g)||[]),o.join(" ")},_untrackClassesElement:function(i){var s=this;u.each(s.classesElementLookup,function(t,e){-1!==u.inArray(i.target,e)&&(s.classesElementLookup[t]=u(e.not(i.target).get()))}),this._off(u(i.target))},_removeClass:function(t,e,i){return this._toggleClass(t,e,i,!1)},_addClass:function(t,e,i){return this._toggleClass(t,e,i,!0)},_toggleClass:function(t,e,i,s){var n="string"==typeof t||null===t,e={extra:n?e:i,keys:n?t:e,element:n?this.element:t,add:s="boolean"==typeof s?s:i};return e.element.toggleClass(this._classes(e),s),this},_on:function(n,o,t){var a,r=this;"boolean"!=typeof n&&(t=o,o=n,n=!1),t?(o=a=u(o),this.bindings=this.bindings.add(o)):(t=o,o=this.element,a=this.widget()),u.each(t,function(t,e){function i(){if(n||!0!==r.options.disabled&&!u(this).hasClass("ui-state-disabled"))return("string"==typeof e?r[e]:e).apply(r,arguments)}"string"!=typeof e&&(i.guid=e.guid=e.guid||i.guid||u.guid++);var t=t.match(/^([\w:-]*)\s*(.*)$/),s=t[1]+r.eventNamespace,t=t[2];t?a.on(s,t,i):o.on(s,i)})},_off:function(t,e){e=(e||"").split(" ").join(this.eventNamespace+" ")+this.eventNamespace,t.off(e),this.bindings=u(this.bindings.not(t).get()),this.focusable=u(this.focusable.not(t).get()),this.hoverable=u(this.hoverable.not(t).get())},_delay:function(t,e){var i=this;return setTimeout(function(){return("string"==typeof t?i[t]:t).apply(i,arguments)},e||0)},_hoverable:function(t){this.hoverable=this.hoverable.add(t),this._on(t,{mouseenter:function(t){this._addClass(u(t.currentTarget),null,"ui-state-hover")},mouseleave:function(t){this._removeClass(u(t.currentTarget),null,"ui-state-hover")}})},_focusable:function(t){this.focusable=this.focusable.add(t),this._on(t,{focusin:function(t){this._addClass(u(t.currentTarget),null,"ui-state-focus")},focusout:function(t){this._removeClass(u(t.currentTarget),null,"ui-state-focus")}})},_trigger:function(t,e,i){var s,n,o=this.options[t];if(i=i||{},(e=u.Event(e)).type=(t===this.widgetEventPrefix?t:this.widgetEventPrefix+t).toLowerCase(),e.target=this.element[0],n=e.originalEvent)for(s in n)s in e||(e[s]=n[s]);return this.element.trigger(e,i),!("function"==typeof o&&!1===o.apply(this.element[0],[e].concat(i))||e.isDefaultPrevented())}},u.each({show:"fadeIn",hide:"fadeOut"},function(o,a){u.Widget.prototype["_"+o]=function(e,t,i){var s,n=(t="string"==typeof t?{effect:t}:t)?!0!==t&&"number"!=typeof t&&t.effect||a:o;"number"==typeof(t=t||{})?t={duration:t}:!0===t&&(t={}),s=!u.isEmptyObject(t),t.complete=i,t.delay&&e.delay(t.delay),s&&u.effects&&u.effects.effect[n]?e[o](t):n!==o&&e[n]?e[n](t.duration,t.easing,i):e.queue(function(t){u(this)[o](),i&&i.call(e[0]),t()})}}),u.widget});;
/*!
 * jQuery UI Button 1.13.2
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
!function(t){"use strict";"function"==typeof define&&define.amd?define(["jquery","./controlgroup","./checkboxradio","../keycode","../widget"],t):t(jQuery)}(function(e){"use strict";var h;return e.widget("ui.button",{version:"1.13.2",defaultElement:"<button>",options:{classes:{"ui-button":"ui-corner-all"},disabled:null,icon:null,iconPosition:"beginning",label:null,showLabel:!0},_getCreateOptions:function(){var t,i=this._super()||{};return this.isInput=this.element.is("input"),null!=(t=this.element[0].disabled)&&(i.disabled=t),this.originalLabel=this.isInput?this.element.val():this.element.html(),this.originalLabel&&(i.label=this.originalLabel),i},_create:function(){!this.option.showLabel&!this.options.icon&&(this.options.showLabel=!0),null==this.options.disabled&&(this.options.disabled=this.element[0].disabled||!1),this.hasTitle=!!this.element.attr("title"),this.options.label&&this.options.label!==this.originalLabel&&(this.isInput?this.element.val(this.options.label):this.element.html(this.options.label)),this._addClass("ui-button","ui-widget"),this._setOption("disabled",this.options.disabled),this._enhance(),this.element.is("a")&&this._on({keyup:function(t){t.keyCode===e.ui.keyCode.SPACE&&(t.preventDefault(),this.element[0].click?this.element[0].click():this.element.trigger("click"))}})},_enhance:function(){this.element.is("button")||this.element.attr("role","button"),this.options.icon&&(this._updateIcon("icon",this.options.icon),this._updateTooltip())},_updateTooltip:function(){this.title=this.element.attr("title"),this.options.showLabel||this.title||this.element.attr("title",this.options.label)},_updateIcon:function(t,i){var t="iconPosition"!==t,o=t?this.options.iconPosition:i,s="top"===o||"bottom"===o;this.icon?t&&this._removeClass(this.icon,null,this.options.icon):(this.icon=e("<span>"),this._addClass(this.icon,"ui-button-icon","ui-icon"),this.options.showLabel||this._addClass("ui-button-icon-only")),t&&this._addClass(this.icon,null,i),this._attachIcon(o),s?(this._addClass(this.icon,null,"ui-widget-icon-block"),this.iconSpace&&this.iconSpace.remove()):(this.iconSpace||(this.iconSpace=e("<span> </span>"),this._addClass(this.iconSpace,"ui-button-icon-space")),this._removeClass(this.icon,null,"ui-wiget-icon-block"),this._attachIconSpace(o))},_destroy:function(){this.element.removeAttr("role"),this.icon&&this.icon.remove(),this.iconSpace&&this.iconSpace.remove(),this.hasTitle||this.element.removeAttr("title")},_attachIconSpace:function(t){this.icon[/^(?:end|bottom)/.test(t)?"before":"after"](this.iconSpace)},_attachIcon:function(t){this.element[/^(?:end|bottom)/.test(t)?"append":"prepend"](this.icon)},_setOptions:function(t){var i=(void 0===t.showLabel?this.options:t).showLabel,o=(void 0===t.icon?this.options:t).icon;i||o||(t.showLabel=!0),this._super(t)},_setOption:function(t,i){"icon"===t&&(i?this._updateIcon(t,i):this.icon&&(this.icon.remove(),this.iconSpace&&this.iconSpace.remove())),"iconPosition"===t&&this._updateIcon(t,i),"showLabel"===t&&(this._toggleClass("ui-button-icon-only",null,!i),this._updateTooltip()),"label"===t&&(this.isInput?this.element.val(i):(this.element.html(i),this.icon&&(this._attachIcon(this.options.iconPosition),this._attachIconSpace(this.options.iconPosition)))),this._super(t,i),"disabled"===t&&(this._toggleClass(null,"ui-state-disabled",i),(this.element[0].disabled=i)&&this.element.trigger("blur"))},refresh:function(){var t=this.element.is("input, button")?this.element[0].disabled:this.element.hasClass("ui-button-disabled");t!==this.options.disabled&&this._setOptions({disabled:t}),this._updateTooltip()}}),!1!==e.uiBackCompat&&(e.widget("ui.button",e.ui.button,{options:{text:!0,icons:{primary:null,secondary:null}},_create:function(){this.options.showLabel&&!this.options.text&&(this.options.showLabel=this.options.text),!this.options.showLabel&&this.options.text&&(this.options.text=this.options.showLabel),this.options.icon||!this.options.icons.primary&&!this.options.icons.secondary?this.options.icon&&(this.options.icons.primary=this.options.icon):this.options.icons.primary?this.options.icon=this.options.icons.primary:(this.options.icon=this.options.icons.secondary,this.options.iconPosition="end"),this._super()},_setOption:function(t,i){"text"===t?this._super("showLabel",i):("showLabel"===t&&(this.options.text=i),"icon"===t&&(this.options.icons.primary=i),"icons"===t&&(i.primary?(this._super("icon",i.primary),this._super("iconPosition","beginning")):i.secondary&&(this._super("icon",i.secondary),this._super("iconPosition","end"))),this._superApply(arguments))}}),e.fn.button=(h=e.fn.button,function(o){var t="string"==typeof o,s=Array.prototype.slice.call(arguments,1),n=this;return t?this.length||"instance"!==o?this.each(function(){var t,i=e(this).attr("type"),i=e.data(this,"ui-"+("checkbox"!==i&&"radio"!==i?"button":"checkboxradio"));return"instance"===o?(n=i,!1):i?"function"!=typeof i[o]||"_"===o.charAt(0)?e.error("no such method '"+o+"' for button widget instance"):(t=i[o].apply(i,s))!==i&&void 0!==t?(n=t&&t.jquery?n.pushStack(t.get()):t,!1):void 0:e.error("cannot call methods on button prior to initialization; attempted to call method '"+o+"'")}):n=void 0:(s.length&&(o=e.widget.extend.apply(null,[o].concat(s))),this.each(function(){var t=e(this).attr("type"),t="checkbox"!==t&&"radio"!==t?"button":"checkboxradio",i=e.data(this,"ui-"+t);i?(i.option(o||{}),i._init&&i._init()):"button"==t?h.call(e(this),o):e(this).checkboxradio(e.extend({icon:!1},o))})),n}),e.fn.buttonset=function(){return e.ui.controlgroup||e.error("Controlgroup widget missing"),"option"===arguments[0]&&"items"===arguments[1]&&arguments[2]?this.controlgroup.apply(this,[arguments[0],"items.button",arguments[2]]):"option"===arguments[0]&&"items"===arguments[1]?this.controlgroup.apply(this,[arguments[0],"items.button"]):("object"==typeof arguments[0]&&arguments[0].items&&(arguments[0].items={button:arguments[0].items}),this.controlgroup.apply(this,arguments))}),e.ui.button});;
/*!
 * jQuery UI Mouse 1.13.2
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery","../ie","../version","../widget"],e):e(jQuery)}(function(o){"use strict";var n=!1;return o(document).on("mouseup",function(){n=!1}),o.widget("ui.mouse",{version:"1.13.2",options:{cancel:"input, textarea, button, select, option",distance:1,delay:0},_mouseInit:function(){var t=this;this.element.on("mousedown."+this.widgetName,function(e){return t._mouseDown(e)}).on("click."+this.widgetName,function(e){if(!0===o.data(e.target,t.widgetName+".preventClickEvent"))return o.removeData(e.target,t.widgetName+".preventClickEvent"),e.stopImmediatePropagation(),!1}),this.started=!1},_mouseDestroy:function(){this.element.off("."+this.widgetName),this._mouseMoveDelegate&&this.document.off("mousemove."+this.widgetName,this._mouseMoveDelegate).off("mouseup."+this.widgetName,this._mouseUpDelegate)},_mouseDown:function(e){var t,i,s;if(!n)return this._mouseMoved=!1,this._mouseStarted&&this._mouseUp(e),this._mouseDownEvent=e,t=this,i=1===e.which,s=!("string"!=typeof this.options.cancel||!e.target.nodeName)&&o(e.target).closest(this.options.cancel).length,i&&!s&&this._mouseCapture(e)&&(this.mouseDelayMet=!this.options.delay,this.mouseDelayMet||(this._mouseDelayTimer=setTimeout(function(){t.mouseDelayMet=!0},this.options.delay)),this._mouseDistanceMet(e)&&this._mouseDelayMet(e)&&(this._mouseStarted=!1!==this._mouseStart(e),!this._mouseStarted)?e.preventDefault():(!0===o.data(e.target,this.widgetName+".preventClickEvent")&&o.removeData(e.target,this.widgetName+".preventClickEvent"),this._mouseMoveDelegate=function(e){return t._mouseMove(e)},this._mouseUpDelegate=function(e){return t._mouseUp(e)},this.document.on("mousemove."+this.widgetName,this._mouseMoveDelegate).on("mouseup."+this.widgetName,this._mouseUpDelegate),e.preventDefault(),n=!0)),!0},_mouseMove:function(e){if(this._mouseMoved){if(o.ui.ie&&(!document.documentMode||document.documentMode<9)&&!e.button)return this._mouseUp(e);if(!e.which)if(e.originalEvent.altKey||e.originalEvent.ctrlKey||e.originalEvent.metaKey||e.originalEvent.shiftKey)this.ignoreMissingWhich=!0;else if(!this.ignoreMissingWhich)return this._mouseUp(e)}return(e.which||e.button)&&(this._mouseMoved=!0),this._mouseStarted?(this._mouseDrag(e),e.preventDefault()):(this._mouseDistanceMet(e)&&this._mouseDelayMet(e)&&(this._mouseStarted=!1!==this._mouseStart(this._mouseDownEvent,e),this._mouseStarted?this._mouseDrag(e):this._mouseUp(e)),!this._mouseStarted)},_mouseUp:function(e){this.document.off("mousemove."+this.widgetName,this._mouseMoveDelegate).off("mouseup."+this.widgetName,this._mouseUpDelegate),this._mouseStarted&&(this._mouseStarted=!1,e.target===this._mouseDownEvent.target&&o.data(e.target,this.widgetName+".preventClickEvent",!0),this._mouseStop(e)),this._mouseDelayTimer&&(clearTimeout(this._mouseDelayTimer),delete this._mouseDelayTimer),this.ignoreMissingWhich=!1,n=!1,e.preventDefault()},_mouseDistanceMet:function(e){return Math.max(Math.abs(this._mouseDownEvent.pageX-e.pageX),Math.abs(this._mouseDownEvent.pageY-e.pageY))>=this.options.distance},_mouseDelayMet:function(){return this.mouseDelayMet},_mouseStart:function(){},_mouseDrag:function(){},_mouseStop:function(){},_mouseCapture:function(){return!0}})});;
/*!
 * jQuery UI Touch Punch 1.0.9 as modified by RWAP Software
 * based on original touchpunch v0.2.3 which has not been updated since 2014
 *
 * Updates by RWAP Software to take account of various suggested changes on the original code issues
 *
 * Original: https://github.com/furf/jquery-ui-touch-punch
 * Copyright 2011–2014, Dave Furfero
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 * Fork: https://github.com/RWAP/jquery-ui-touch-punch
 *
 * Depends:
 * jquery.ui.widget.js
 * jquery.ui.mouse.js
 */

(function( factory ) {
    if ( typeof define === "function" && define.amd ) {

        // AMD. Register as an anonymous module.
        define([ "jquery", "jquery-ui" ], factory );
    } else {

        // Browser globals
        factory( jQuery );
    }
}(function ($) {

  // Detect touch support - Windows Surface devices and other touch devices
  $.mspointer = window.navigator.msPointerEnabled;		
  $.touch = ( 'ontouchstart' in document
   	|| 'ontouchstart' in window
   	|| window.TouchEvent
   	|| (window.DocumentTouch && document instanceof DocumentTouch)
   	|| navigator.maxTouchPoints > 0
   	|| navigator.msMaxTouchPoints > 0
  );

  // Ignore browsers without touch or mouse support
  if ((!$.touch && !$.mspointer) || !$.ui.mouse) {
	return;
  }

  let mouseProto = $.ui.mouse.prototype,
      _mouseInit = mouseProto._mouseInit,
      _mouseDestroy = mouseProto._mouseDestroy,
      touchHandled;

    /**
    * Get the x,y position of a touch event
    * @param {Object} event A touch event
    */
    function getTouchCoords (event) {
        return {
            x: event.originalEvent.changedTouches[0].pageX,
            y: event.originalEvent.changedTouches[0].pageY
        };
    }

  /**
   * Simulate a mouse event based on a corresponding touch event
   * @param {Object} event A touch event
   * @param {String} simulatedType The corresponding mouse event
   */
  function simulateMouseEvent (event, simulatedType) {

    // Ignore multi-touch events
    if (event.originalEvent.touches.length > 1) {
      return;
    }

    //Ignore input or textarea elements so user can still enter text
    if ($(event.target).is("input") || $(event.target).is("textarea")) {
      return;
    }

    // Prevent "Ignored attempt to cancel a touchmove event with cancelable=false" errors
    if (event.cancelable) {
      event.preventDefault();
    }

    let touch = event.originalEvent.changedTouches[0],
        simulatedEvent = document.createEvent('MouseEvents');

    // Initialize the simulated mouse event using the touch event's coordinates
    simulatedEvent.initMouseEvent(
      simulatedType,    // type
      true,             // bubbles
      true,             // cancelable
      window,           // view
      1,                // detail
      touch.screenX,    // screenX
      touch.screenY,    // screenY
      touch.clientX,    // clientX
      touch.clientY,    // clientY
      false,            // ctrlKey
      false,            // altKey
      false,            // shiftKey
      false,            // metaKey
      0,                // button
      null              // relatedTarget
    );

    // Dispatch the simulated event to the target element
    event.target.dispatchEvent(simulatedEvent);
  }

  /**
   * Handle the jQuery UI widget's touchstart events
   * @param {Object} event The widget element's touchstart event
   */
  mouseProto._touchStart = function (event) {

    let self = this;

    // Interaction time
    this._startedMove = event.timeStamp;

    // Track movement to determine if interaction was a click
    self._startPos = getTouchCoords(event);

    // Ignore the event if another widget is already being handled
    if (touchHandled || !self._mouseCapture(event.originalEvent.changedTouches[0])) {
      return;
    }

    // Set the flag to prevent other widgets from inheriting the touch event
    touchHandled = true;

    // Track movement to determine if interaction was a click
    self._touchMoved = false;

    // Simulate the mouseover event
    simulateMouseEvent(event, 'mouseover');

    // Simulate the mousemove event
    simulateMouseEvent(event, 'mousemove');

    // Simulate the mousedown event
    simulateMouseEvent(event, 'mousedown');
  };

  /**
   * Handle the jQuery UI widget's touchmove events
   * @param {Object} event The document's touchmove event
   */
  mouseProto._touchMove = function (event) {

    // Ignore event if not handled
    if (!touchHandled) {
      return;
    }

    // Interaction was moved
    this._touchMoved = true;

    // Simulate the mousemove event
    simulateMouseEvent(event, 'mousemove');
  };

  /**
   * Handle the jQuery UI widget's touchend events
   * @param {Object} event The document's touchend event
   */
  mouseProto._touchEnd = function (event) {

    // Ignore event if not handled
    if (!touchHandled) {
      return;
    }

    // Simulate the mouseup event
    simulateMouseEvent(event, 'mouseup');

    // Simulate the mouseout event
    simulateMouseEvent(event, 'mouseout');

    // If the touch interaction did not move, it should trigger a click
    // Check for this in two ways - length of time of simulation and distance moved
    // Allow for Apple Stylus to be used also
    let timeMoving = event.timeStamp - this._startedMove;
    if (!this._touchMoved || timeMoving < 500) {
        // Simulate the click event
        simulateMouseEvent(event, 'click');
    } else {
      let endPos = getTouchCoords(event);
      if ((Math.abs(endPos.x - this._startPos.x) < 10) && (Math.abs(endPos.y - this._startPos.y) < 10)) {

          // If the touch interaction did not move, it should trigger a click
          if (!this._touchMoved || event.originalEvent.changedTouches[0].touchType === 'stylus') {
              // Simulate the click event
              simulateMouseEvent(event, 'click');
          }
      }
    }

    // Unset the flag to determine the touch movement stopped
    this._touchMoved = false;

    // Unset the flag to allow other widgets to inherit the touch event
    touchHandled = false;
  };

  /**
   * A duck punch of the $.ui.mouse _mouseInit method to support touch events.
   * This method extends the widget with bound touch event handlers that
   * translate touch events to mouse events and pass them to the widget's
   * original mouse event handling methods.
   */
  mouseProto._mouseInit = function () {

    let self = this;
	  
    // Microsoft Surface Support = remove original touch Action
    if ($.support.mspointer) {
      self.element[0].style.msTouchAction = 'none';
    }	  

    // Delegate the touch handlers to the widget's element
    self.element.on({
      touchstart: $.proxy(self, '_touchStart'),
      touchmove: $.proxy(self, '_touchMove'),
      touchend: $.proxy(self, '_touchEnd')
    });

    // Call the original $.ui.mouse init method
    _mouseInit.call(self);
  };

  /**
   * Remove the touch event handlers
   */
  mouseProto._mouseDestroy = function () {

    let self = this;

    // Delegate the touch handlers to the widget's element
    self.element.off({
      touchstart: $.proxy(self, '_touchStart'),
      touchmove: $.proxy(self, '_touchMove'),
      touchend: $.proxy(self, '_touchEnd')
    });

    // Call the original $.ui.mouse destroy method
    _mouseDestroy.call(self);
  };

}));
;
/*!
 * jQuery UI Draggable 1.13.2
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
!function(t){"use strict";"function"==typeof define&&define.amd?define(["jquery","./mouse","../data","../plugin","../safe-active-element","../safe-blur","../scroll-parent","../version","../widget"],t):t(jQuery)}(function(P){"use strict";return P.widget("ui.draggable",P.ui.mouse,{version:"1.13.2",widgetEventPrefix:"drag",options:{addClasses:!0,appendTo:"parent",axis:!1,connectToSortable:!1,containment:!1,cursor:"auto",cursorAt:!1,grid:!1,handle:!1,helper:"original",iframeFix:!1,opacity:!1,refreshPositions:!1,revert:!1,revertDuration:500,scope:"default",scroll:!0,scrollSensitivity:20,scrollSpeed:20,snap:!1,snapMode:"both",snapTolerance:20,stack:!1,zIndex:!1,drag:null,start:null,stop:null},_create:function(){"original"===this.options.helper&&this._setPositionRelative(),this.options.addClasses&&this._addClass("ui-draggable"),this._setHandleClassName(),this._mouseInit()},_setOption:function(t,e){this._super(t,e),"handle"===t&&(this._removeHandleClassName(),this._setHandleClassName())},_destroy:function(){(this.helper||this.element).is(".ui-draggable-dragging")?this.destroyOnClear=!0:(this._removeHandleClassName(),this._mouseDestroy())},_mouseCapture:function(t){var e=this.options;return!(this.helper||e.disabled||0<P(t.target).closest(".ui-resizable-handle").length)&&(this.handle=this._getHandle(t),!!this.handle&&(this._blurActiveElement(t),this._blockFrames(!0===e.iframeFix?"iframe":e.iframeFix),!0))},_blockFrames:function(t){this.iframeBlocks=this.document.find(t).map(function(){var t=P(this);return P("<div>").css("position","absolute").appendTo(t.parent()).outerWidth(t.outerWidth()).outerHeight(t.outerHeight()).offset(t.offset())[0]})},_unblockFrames:function(){this.iframeBlocks&&(this.iframeBlocks.remove(),delete this.iframeBlocks)},_blurActiveElement:function(t){var e=P.ui.safeActiveElement(this.document[0]);P(t.target).closest(e).length||P.ui.safeBlur(e)},_mouseStart:function(t){var e=this.options;return this.helper=this._createHelper(t),this._addClass(this.helper,"ui-draggable-dragging"),this._cacheHelperProportions(),P.ui.ddmanager&&(P.ui.ddmanager.current=this),this._cacheMargins(),this.cssPosition=this.helper.css("position"),this.scrollParent=this.helper.scrollParent(!0),this.offsetParent=this.helper.offsetParent(),this.hasFixedAncestor=0<this.helper.parents().filter(function(){return"fixed"===P(this).css("position")}).length,this.positionAbs=this.element.offset(),this._refreshOffsets(t),this.originalPosition=this.position=this._generatePosition(t,!1),this.originalPageX=t.pageX,this.originalPageY=t.pageY,e.cursorAt&&this._adjustOffsetFromHelper(e.cursorAt),this._setContainment(),!1===this._trigger("start",t)?(this._clear(),!1):(this._cacheHelperProportions(),P.ui.ddmanager&&!e.dropBehaviour&&P.ui.ddmanager.prepareOffsets(this,t),this._mouseDrag(t,!0),P.ui.ddmanager&&P.ui.ddmanager.dragStart(this,t),!0)},_refreshOffsets:function(t){this.offset={top:this.positionAbs.top-this.margins.top,left:this.positionAbs.left-this.margins.left,scroll:!1,parent:this._getParentOffset(),relative:this._getRelativeOffset()},this.offset.click={left:t.pageX-this.offset.left,top:t.pageY-this.offset.top}},_mouseDrag:function(t,e){if(this.hasFixedAncestor&&(this.offset.parent=this._getParentOffset()),this.position=this._generatePosition(t,!0),this.positionAbs=this._convertPositionTo("absolute"),!e){e=this._uiHash();if(!1===this._trigger("drag",t,e))return this._mouseUp(new P.Event("mouseup",t)),!1;this.position=e.position}return this.helper[0].style.left=this.position.left+"px",this.helper[0].style.top=this.position.top+"px",P.ui.ddmanager&&P.ui.ddmanager.drag(this,t),!1},_mouseStop:function(t){var e=this,s=!1;return P.ui.ddmanager&&!this.options.dropBehaviour&&(s=P.ui.ddmanager.drop(this,t)),this.dropped&&(s=this.dropped,this.dropped=!1),"invalid"===this.options.revert&&!s||"valid"===this.options.revert&&s||!0===this.options.revert||"function"==typeof this.options.revert&&this.options.revert.call(this.element,s)?P(this.helper).animate(this.originalPosition,parseInt(this.options.revertDuration,10),function(){!1!==e._trigger("stop",t)&&e._clear()}):!1!==this._trigger("stop",t)&&this._clear(),!1},_mouseUp:function(t){return this._unblockFrames(),P.ui.ddmanager&&P.ui.ddmanager.dragStop(this,t),this.handleElement.is(t.target)&&this.element.trigger("focus"),P.ui.mouse.prototype._mouseUp.call(this,t)},cancel:function(){return this.helper.is(".ui-draggable-dragging")?this._mouseUp(new P.Event("mouseup",{target:this.element[0]})):this._clear(),this},_getHandle:function(t){return!this.options.handle||!!P(t.target).closest(this.element.find(this.options.handle)).length},_setHandleClassName:function(){this.handleElement=this.options.handle?this.element.find(this.options.handle):this.element,this._addClass(this.handleElement,"ui-draggable-handle")},_removeHandleClassName:function(){this._removeClass(this.handleElement,"ui-draggable-handle")},_createHelper:function(t){var e=this.options,s="function"==typeof e.helper,t=s?P(e.helper.apply(this.element[0],[t])):"clone"===e.helper?this.element.clone().removeAttr("id"):this.element;return t.parents("body").length||t.appendTo("parent"===e.appendTo?this.element[0].parentNode:e.appendTo),s&&t[0]===this.element[0]&&this._setPositionRelative(),t[0]===this.element[0]||/(fixed|absolute)/.test(t.css("position"))||t.css("position","absolute"),t},_setPositionRelative:function(){/^(?:r|a|f)/.test(this.element.css("position"))||(this.element[0].style.position="relative")},_adjustOffsetFromHelper:function(t){"string"==typeof t&&(t=t.split(" ")),"left"in(t=Array.isArray(t)?{left:+t[0],top:+t[1]||0}:t)&&(this.offset.click.left=t.left+this.margins.left),"right"in t&&(this.offset.click.left=this.helperProportions.width-t.right+this.margins.left),"top"in t&&(this.offset.click.top=t.top+this.margins.top),"bottom"in t&&(this.offset.click.top=this.helperProportions.height-t.bottom+this.margins.top)},_isRootNode:function(t){return/(html|body)/i.test(t.tagName)||t===this.document[0]},_getParentOffset:function(){var t=this.offsetParent.offset(),e=this.document[0];return"absolute"===this.cssPosition&&this.scrollParent[0]!==e&&P.contains(this.scrollParent[0],this.offsetParent[0])&&(t.left+=this.scrollParent.scrollLeft(),t.top+=this.scrollParent.scrollTop()),{top:(t=this._isRootNode(this.offsetParent[0])?{top:0,left:0}:t).top+(parseInt(this.offsetParent.css("borderTopWidth"),10)||0),left:t.left+(parseInt(this.offsetParent.css("borderLeftWidth"),10)||0)}},_getRelativeOffset:function(){if("relative"!==this.cssPosition)return{top:0,left:0};var t=this.element.position(),e=this._isRootNode(this.scrollParent[0]);return{top:t.top-(parseInt(this.helper.css("top"),10)||0)+(e?0:this.scrollParent.scrollTop()),left:t.left-(parseInt(this.helper.css("left"),10)||0)+(e?0:this.scrollParent.scrollLeft())}},_cacheMargins:function(){this.margins={left:parseInt(this.element.css("marginLeft"),10)||0,top:parseInt(this.element.css("marginTop"),10)||0,right:parseInt(this.element.css("marginRight"),10)||0,bottom:parseInt(this.element.css("marginBottom"),10)||0}},_cacheHelperProportions:function(){this.helperProportions={width:this.helper.outerWidth(),height:this.helper.outerHeight()}},_setContainment:function(){var t,e=this.options,s=this.document[0];this.relativeContainer=null,e.containment?"window"===e.containment?this.containment=[P(window).scrollLeft()-this.offset.relative.left-this.offset.parent.left,P(window).scrollTop()-this.offset.relative.top-this.offset.parent.top,P(window).scrollLeft()+P(window).width()-this.helperProportions.width-this.margins.left,P(window).scrollTop()+(P(window).height()||s.body.parentNode.scrollHeight)-this.helperProportions.height-this.margins.top]:"document"===e.containment?this.containment=[0,0,P(s).width()-this.helperProportions.width-this.margins.left,(P(s).height()||s.body.parentNode.scrollHeight)-this.helperProportions.height-this.margins.top]:e.containment.constructor===Array?this.containment=e.containment:("parent"===e.containment&&(e.containment=this.helper[0].parentNode),(e=(s=P(e.containment))[0])&&(t=/(scroll|auto)/.test(s.css("overflow")),this.containment=[(parseInt(s.css("borderLeftWidth"),10)||0)+(parseInt(s.css("paddingLeft"),10)||0),(parseInt(s.css("borderTopWidth"),10)||0)+(parseInt(s.css("paddingTop"),10)||0),(t?Math.max(e.scrollWidth,e.offsetWidth):e.offsetWidth)-(parseInt(s.css("borderRightWidth"),10)||0)-(parseInt(s.css("paddingRight"),10)||0)-this.helperProportions.width-this.margins.left-this.margins.right,(t?Math.max(e.scrollHeight,e.offsetHeight):e.offsetHeight)-(parseInt(s.css("borderBottomWidth"),10)||0)-(parseInt(s.css("paddingBottom"),10)||0)-this.helperProportions.height-this.margins.top-this.margins.bottom],this.relativeContainer=s)):this.containment=null},_convertPositionTo:function(t,e){e=e||this.position;var t="absolute"===t?1:-1,s=this._isRootNode(this.scrollParent[0]);return{top:e.top+this.offset.relative.top*t+this.offset.parent.top*t-("fixed"===this.cssPosition?-this.offset.scroll.top:s?0:this.offset.scroll.top)*t,left:e.left+this.offset.relative.left*t+this.offset.parent.left*t-("fixed"===this.cssPosition?-this.offset.scroll.left:s?0:this.offset.scroll.left)*t}},_generatePosition:function(t,e){var s,i=this.options,o=this._isRootNode(this.scrollParent[0]),n=t.pageX,r=t.pageY;return o&&this.offset.scroll||(this.offset.scroll={top:this.scrollParent.scrollTop(),left:this.scrollParent.scrollLeft()}),e&&(this.containment&&(s=this.relativeContainer?(e=this.relativeContainer.offset(),[this.containment[0]+e.left,this.containment[1]+e.top,this.containment[2]+e.left,this.containment[3]+e.top]):this.containment,t.pageX-this.offset.click.left<s[0]&&(n=s[0]+this.offset.click.left),t.pageY-this.offset.click.top<s[1]&&(r=s[1]+this.offset.click.top),t.pageX-this.offset.click.left>s[2]&&(n=s[2]+this.offset.click.left),t.pageY-this.offset.click.top>s[3]&&(r=s[3]+this.offset.click.top)),i.grid&&(e=i.grid[1]?this.originalPageY+Math.round((r-this.originalPageY)/i.grid[1])*i.grid[1]:this.originalPageY,r=!s||e-this.offset.click.top>=s[1]||e-this.offset.click.top>s[3]?e:e-this.offset.click.top>=s[1]?e-i.grid[1]:e+i.grid[1],t=i.grid[0]?this.originalPageX+Math.round((n-this.originalPageX)/i.grid[0])*i.grid[0]:this.originalPageX,n=!s||t-this.offset.click.left>=s[0]||t-this.offset.click.left>s[2]?t:t-this.offset.click.left>=s[0]?t-i.grid[0]:t+i.grid[0]),"y"===i.axis&&(n=this.originalPageX),"x"===i.axis&&(r=this.originalPageY)),{top:r-this.offset.click.top-this.offset.relative.top-this.offset.parent.top+("fixed"===this.cssPosition?-this.offset.scroll.top:o?0:this.offset.scroll.top),left:n-this.offset.click.left-this.offset.relative.left-this.offset.parent.left+("fixed"===this.cssPosition?-this.offset.scroll.left:o?0:this.offset.scroll.left)}},_clear:function(){this._removeClass(this.helper,"ui-draggable-dragging"),this.helper[0]===this.element[0]||this.cancelHelperRemoval||this.helper.remove(),this.helper=null,this.cancelHelperRemoval=!1,this.destroyOnClear&&this.destroy()},_trigger:function(t,e,s){return s=s||this._uiHash(),P.ui.plugin.call(this,t,[e,s,this],!0),/^(drag|start|stop)/.test(t)&&(this.positionAbs=this._convertPositionTo("absolute"),s.offset=this.positionAbs),P.Widget.prototype._trigger.call(this,t,e,s)},plugins:{},_uiHash:function(){return{helper:this.helper,position:this.position,originalPosition:this.originalPosition,offset:this.positionAbs}}}),P.ui.plugin.add("draggable","connectToSortable",{start:function(e,t,s){var i=P.extend({},t,{item:s.element});s.sortables=[],P(s.options.connectToSortable).each(function(){var t=P(this).sortable("instance");t&&!t.options.disabled&&(s.sortables.push(t),t.refreshPositions(),t._trigger("activate",e,i))})},stop:function(e,t,s){var i=P.extend({},t,{item:s.element});s.cancelHelperRemoval=!1,P.each(s.sortables,function(){var t=this;t.isOver?(t.isOver=0,s.cancelHelperRemoval=!0,t.cancelHelperRemoval=!1,t._storedCSS={position:t.placeholder.css("position"),top:t.placeholder.css("top"),left:t.placeholder.css("left")},t._mouseStop(e),t.options.helper=t.options._helper):(t.cancelHelperRemoval=!0,t._trigger("deactivate",e,i))})},drag:function(s,i,o){P.each(o.sortables,function(){var t=!1,e=this;e.positionAbs=o.positionAbs,e.helperProportions=o.helperProportions,e.offset.click=o.offset.click,e._intersectsWith(e.containerCache)&&(t=!0,P.each(o.sortables,function(){return this.positionAbs=o.positionAbs,this.helperProportions=o.helperProportions,this.offset.click=o.offset.click,t=this!==e&&this._intersectsWith(this.containerCache)&&P.contains(e.element[0],this.element[0])?!1:t})),t?(e.isOver||(e.isOver=1,o._parent=i.helper.parent(),e.currentItem=i.helper.appendTo(e.element).data("ui-sortable-item",!0),e.options._helper=e.options.helper,e.options.helper=function(){return i.helper[0]},s.target=e.currentItem[0],e._mouseCapture(s,!0),e._mouseStart(s,!0,!0),e.offset.click.top=o.offset.click.top,e.offset.click.left=o.offset.click.left,e.offset.parent.left-=o.offset.parent.left-e.offset.parent.left,e.offset.parent.top-=o.offset.parent.top-e.offset.parent.top,o._trigger("toSortable",s),o.dropped=e.element,P.each(o.sortables,function(){this.refreshPositions()}),o.currentItem=o.element,e.fromOutside=o),e.currentItem&&(e._mouseDrag(s),i.position=e.position)):e.isOver&&(e.isOver=0,e.cancelHelperRemoval=!0,e.options._revert=e.options.revert,e.options.revert=!1,e._trigger("out",s,e._uiHash(e)),e._mouseStop(s,!0),e.options.revert=e.options._revert,e.options.helper=e.options._helper,e.placeholder&&e.placeholder.remove(),i.helper.appendTo(o._parent),o._refreshOffsets(s),i.position=o._generatePosition(s,!0),o._trigger("fromSortable",s),o.dropped=!1,P.each(o.sortables,function(){this.refreshPositions()}))})}}),P.ui.plugin.add("draggable","cursor",{start:function(t,e,s){var i=P("body"),s=s.options;i.css("cursor")&&(s._cursor=i.css("cursor")),i.css("cursor",s.cursor)},stop:function(t,e,s){s=s.options;s._cursor&&P("body").css("cursor",s._cursor)}}),P.ui.plugin.add("draggable","opacity",{start:function(t,e,s){e=P(e.helper),s=s.options;e.css("opacity")&&(s._opacity=e.css("opacity")),e.css("opacity",s.opacity)},stop:function(t,e,s){s=s.options;s._opacity&&P(e.helper).css("opacity",s._opacity)}}),P.ui.plugin.add("draggable","scroll",{start:function(t,e,s){s.scrollParentNotHidden||(s.scrollParentNotHidden=s.helper.scrollParent(!1)),s.scrollParentNotHidden[0]!==s.document[0]&&"HTML"!==s.scrollParentNotHidden[0].tagName&&(s.overflowOffset=s.scrollParentNotHidden.offset())},drag:function(t,e,s){var i=s.options,o=!1,n=s.scrollParentNotHidden[0],r=s.document[0];n!==r&&"HTML"!==n.tagName?(i.axis&&"x"===i.axis||(s.overflowOffset.top+n.offsetHeight-t.pageY<i.scrollSensitivity?n.scrollTop=o=n.scrollTop+i.scrollSpeed:t.pageY-s.overflowOffset.top<i.scrollSensitivity&&(n.scrollTop=o=n.scrollTop-i.scrollSpeed)),i.axis&&"y"===i.axis||(s.overflowOffset.left+n.offsetWidth-t.pageX<i.scrollSensitivity?n.scrollLeft=o=n.scrollLeft+i.scrollSpeed:t.pageX-s.overflowOffset.left<i.scrollSensitivity&&(n.scrollLeft=o=n.scrollLeft-i.scrollSpeed))):(i.axis&&"x"===i.axis||(t.pageY-P(r).scrollTop()<i.scrollSensitivity?o=P(r).scrollTop(P(r).scrollTop()-i.scrollSpeed):P(window).height()-(t.pageY-P(r).scrollTop())<i.scrollSensitivity&&(o=P(r).scrollTop(P(r).scrollTop()+i.scrollSpeed))),i.axis&&"y"===i.axis||(t.pageX-P(r).scrollLeft()<i.scrollSensitivity?o=P(r).scrollLeft(P(r).scrollLeft()-i.scrollSpeed):P(window).width()-(t.pageX-P(r).scrollLeft())<i.scrollSensitivity&&(o=P(r).scrollLeft(P(r).scrollLeft()+i.scrollSpeed)))),!1!==o&&P.ui.ddmanager&&!i.dropBehaviour&&P.ui.ddmanager.prepareOffsets(s,t)}}),P.ui.plugin.add("draggable","snap",{start:function(t,e,s){var i=s.options;s.snapElements=[],P(i.snap.constructor!==String?i.snap.items||":data(ui-draggable)":i.snap).each(function(){var t=P(this),e=t.offset();this!==s.element[0]&&s.snapElements.push({item:this,width:t.outerWidth(),height:t.outerHeight(),top:e.top,left:e.left})})},drag:function(t,e,s){for(var i,o,n,r,l,a,h,p,c,f=s.options,d=f.snapTolerance,g=e.offset.left,u=g+s.helperProportions.width,m=e.offset.top,v=m+s.helperProportions.height,_=s.snapElements.length-1;0<=_;_--)a=(l=s.snapElements[_].left-s.margins.left)+s.snapElements[_].width,p=(h=s.snapElements[_].top-s.margins.top)+s.snapElements[_].height,u<l-d||a+d<g||v<h-d||p+d<m||!P.contains(s.snapElements[_].item.ownerDocument,s.snapElements[_].item)?(s.snapElements[_].snapping&&s.options.snap.release&&s.options.snap.release.call(s.element,t,P.extend(s._uiHash(),{snapItem:s.snapElements[_].item})),s.snapElements[_].snapping=!1):("inner"!==f.snapMode&&(i=Math.abs(h-v)<=d,o=Math.abs(p-m)<=d,n=Math.abs(l-u)<=d,r=Math.abs(a-g)<=d,i&&(e.position.top=s._convertPositionTo("relative",{top:h-s.helperProportions.height,left:0}).top),o&&(e.position.top=s._convertPositionTo("relative",{top:p,left:0}).top),n&&(e.position.left=s._convertPositionTo("relative",{top:0,left:l-s.helperProportions.width}).left),r&&(e.position.left=s._convertPositionTo("relative",{top:0,left:a}).left)),c=i||o||n||r,"outer"!==f.snapMode&&(i=Math.abs(h-m)<=d,o=Math.abs(p-v)<=d,n=Math.abs(l-g)<=d,r=Math.abs(a-u)<=d,i&&(e.position.top=s._convertPositionTo("relative",{top:h,left:0}).top),o&&(e.position.top=s._convertPositionTo("relative",{top:p-s.helperProportions.height,left:0}).top),n&&(e.position.left=s._convertPositionTo("relative",{top:0,left:l}).left),r&&(e.position.left=s._convertPositionTo("relative",{top:0,left:a-s.helperProportions.width}).left)),!s.snapElements[_].snapping&&(i||o||n||r||c)&&s.options.snap.snap&&s.options.snap.snap.call(s.element,t,P.extend(s._uiHash(),{snapItem:s.snapElements[_].item})),s.snapElements[_].snapping=i||o||n||r||c)}}),P.ui.plugin.add("draggable","stack",{start:function(t,e,s){var i,s=s.options,s=P.makeArray(P(s.stack)).sort(function(t,e){return(parseInt(P(t).css("zIndex"),10)||0)-(parseInt(P(e).css("zIndex"),10)||0)});s.length&&(i=parseInt(P(s[0]).css("zIndex"),10)||0,P(s).each(function(t){P(this).css("zIndex",i+t)}),this.css("zIndex",i+s.length))}}),P.ui.plugin.add("draggable","zIndex",{start:function(t,e,s){e=P(e.helper),s=s.options;e.css("zIndex")&&(s._zIndex=e.css("zIndex")),e.css("zIndex",s.zIndex)},stop:function(t,e,s){s=s.options;s._zIndex&&P(e.helper).css("zIndex",s._zIndex)}}),P.ui.draggable});;
/*!
 * jQuery UI Position 1.13.2
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 *
 * http://api.jqueryui.com/position/
 */
!function(t){"use strict";"function"==typeof define&&define.amd?define(["jquery","./version"],t):t(jQuery)}(function(b){"use strict";function x(t,i,o){return[parseFloat(t[0])*(r.test(t[0])?i/100:1),parseFloat(t[1])*(r.test(t[1])?o/100:1)]}function T(t,i){return parseInt(b.css(t,i),10)||0}function n(t){return null!=t&&t===t.window}var e,L,P,l,f,s,h,r,o;return L=Math.max,P=Math.abs,l=/left|center|right/,f=/top|center|bottom/,s=/[\+\-]\d+(\.[\d]+)?%?/,h=/^\w+/,r=/%$/,o=b.fn.position,b.position={scrollbarWidth:function(){if(void 0!==e)return e;var t,i=b("<div style='display:block;position:absolute;width:200px;height:200px;overflow:hidden;'><div style='height:300px;width:auto;'></div></div>"),o=i.children()[0];return b("body").append(i),t=o.offsetWidth,i.css("overflow","scroll"),t===(o=o.offsetWidth)&&(o=i[0].clientWidth),i.remove(),e=t-o},getScrollInfo:function(t){var i=t.isWindow||t.isDocument?"":t.element.css("overflow-x"),o=t.isWindow||t.isDocument?"":t.element.css("overflow-y"),i="scroll"===i||"auto"===i&&t.width<t.element[0].scrollWidth;return{width:"scroll"===o||"auto"===o&&t.height<t.element[0].scrollHeight?b.position.scrollbarWidth():0,height:i?b.position.scrollbarWidth():0}},getWithinInfo:function(t){var i=b(t||window),o=n(i[0]),e=!!i[0]&&9===i[0].nodeType;return{element:i,isWindow:o,isDocument:e,offset:!o&&!e?b(t).offset():{left:0,top:0},scrollLeft:i.scrollLeft(),scrollTop:i.scrollTop(),width:i.outerWidth(),height:i.outerHeight()}}},b.fn.position=function(c){if(!c||!c.of)return o.apply(this,arguments);var a,d,g,u,m,t,w="string"==typeof(c=b.extend({},c)).of?b(document).find(c.of):b(c.of),W=b.position.getWithinInfo(c.within),v=b.position.getScrollInfo(W),y=(c.collision||"flip").split(" "),H={},i=9===(i=(t=w)[0]).nodeType?{width:t.width(),height:t.height(),offset:{top:0,left:0}}:n(i)?{width:t.width(),height:t.height(),offset:{top:t.scrollTop(),left:t.scrollLeft()}}:i.preventDefault?{width:0,height:0,offset:{top:i.pageY,left:i.pageX}}:{width:t.outerWidth(),height:t.outerHeight(),offset:t.offset()};return w[0].preventDefault&&(c.at="left top"),d=i.width,g=i.height,m=b.extend({},u=i.offset),b.each(["my","at"],function(){var t,i,o=(c[this]||"").split(" ");(o=1===o.length?l.test(o[0])?o.concat(["center"]):f.test(o[0])?["center"].concat(o):["center","center"]:o)[0]=l.test(o[0])?o[0]:"center",o[1]=f.test(o[1])?o[1]:"center",t=s.exec(o[0]),i=s.exec(o[1]),H[this]=[t?t[0]:0,i?i[0]:0],c[this]=[h.exec(o[0])[0],h.exec(o[1])[0]]}),1===y.length&&(y[1]=y[0]),"right"===c.at[0]?m.left+=d:"center"===c.at[0]&&(m.left+=d/2),"bottom"===c.at[1]?m.top+=g:"center"===c.at[1]&&(m.top+=g/2),a=x(H.at,d,g),m.left+=a[0],m.top+=a[1],this.each(function(){var o,t,f=b(this),s=f.outerWidth(),h=f.outerHeight(),i=T(this,"marginLeft"),e=T(this,"marginTop"),n=s+i+T(this,"marginRight")+v.width,l=h+e+T(this,"marginBottom")+v.height,r=b.extend({},m),p=x(H.my,f.outerWidth(),f.outerHeight());"right"===c.my[0]?r.left-=s:"center"===c.my[0]&&(r.left-=s/2),"bottom"===c.my[1]?r.top-=h:"center"===c.my[1]&&(r.top-=h/2),r.left+=p[0],r.top+=p[1],o={marginLeft:i,marginTop:e},b.each(["left","top"],function(t,i){b.ui.position[y[t]]&&b.ui.position[y[t]][i](r,{targetWidth:d,targetHeight:g,elemWidth:s,elemHeight:h,collisionPosition:o,collisionWidth:n,collisionHeight:l,offset:[a[0]+p[0],a[1]+p[1]],my:c.my,at:c.at,within:W,elem:f})}),c.using&&(t=function(t){var i=u.left-r.left,o=i+d-s,e=u.top-r.top,n=e+g-h,l={target:{element:w,left:u.left,top:u.top,width:d,height:g},element:{element:f,left:r.left,top:r.top,width:s,height:h},horizontal:o<0?"left":0<i?"right":"center",vertical:n<0?"top":0<e?"bottom":"middle"};d<s&&P(i+o)<d&&(l.horizontal="center"),g<h&&P(e+n)<g&&(l.vertical="middle"),L(P(i),P(o))>L(P(e),P(n))?l.important="horizontal":l.important="vertical",c.using.call(this,t,l)}),f.offset(b.extend(r,{using:t}))})},b.ui.position={fit:{left:function(t,i){var o,e=i.within,n=e.isWindow?e.scrollLeft:e.offset.left,e=e.width,l=t.left-i.collisionPosition.marginLeft,f=n-l,s=l+i.collisionWidth-e-n;i.collisionWidth>e?0<f&&s<=0?(o=t.left+f+i.collisionWidth-e-n,t.left+=f-o):t.left=!(0<s&&f<=0)&&s<f?n+e-i.collisionWidth:n:0<f?t.left+=f:0<s?t.left-=s:t.left=L(t.left-l,t.left)},top:function(t,i){var o,e=i.within,e=e.isWindow?e.scrollTop:e.offset.top,n=i.within.height,l=t.top-i.collisionPosition.marginTop,f=e-l,s=l+i.collisionHeight-n-e;i.collisionHeight>n?0<f&&s<=0?(o=t.top+f+i.collisionHeight-n-e,t.top+=f-o):t.top=!(0<s&&f<=0)&&s<f?e+n-i.collisionHeight:e:0<f?t.top+=f:0<s?t.top-=s:t.top=L(t.top-l,t.top)}},flip:{left:function(t,i){var o=i.within,e=o.offset.left+o.scrollLeft,n=o.width,o=o.isWindow?o.scrollLeft:o.offset.left,l=t.left-i.collisionPosition.marginLeft,f=l-o,l=l+i.collisionWidth-n-o,s="left"===i.my[0]?-i.elemWidth:"right"===i.my[0]?i.elemWidth:0,h="left"===i.at[0]?i.targetWidth:"right"===i.at[0]?-i.targetWidth:0,r=-2*i.offset[0];f<0?((n=t.left+s+h+r+i.collisionWidth-n-e)<0||n<P(f))&&(t.left+=s+h+r):0<l&&(0<(e=t.left-i.collisionPosition.marginLeft+s+h+r-o)||P(e)<l)&&(t.left+=s+h+r)},top:function(t,i){var o=i.within,e=o.offset.top+o.scrollTop,n=o.height,o=o.isWindow?o.scrollTop:o.offset.top,l=t.top-i.collisionPosition.marginTop,f=l-o,l=l+i.collisionHeight-n-o,s="top"===i.my[1]?-i.elemHeight:"bottom"===i.my[1]?i.elemHeight:0,h="top"===i.at[1]?i.targetHeight:"bottom"===i.at[1]?-i.targetHeight:0,r=-2*i.offset[1];f<0?((n=t.top+s+h+r+i.collisionHeight-n-e)<0||n<P(f))&&(t.top+=s+h+r):0<l&&(0<(e=t.top-i.collisionPosition.marginTop+s+h+r-o)||P(e)<l)&&(t.top+=s+h+r)}},flipfit:{left:function(){b.ui.position.flip.left.apply(this,arguments),b.ui.position.fit.left.apply(this,arguments)},top:function(){b.ui.position.flip.top.apply(this,arguments),b.ui.position.fit.top.apply(this,arguments)}}},b.ui.position});;
/*!
 * jQuery UI Resizable 1.13.2
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
!function(t){"use strict";"function"==typeof define&&define.amd?define(["jquery","./mouse","../disable-selection","../plugin","../version","../widget"],t):t(jQuery)}(function(z){"use strict";return z.widget("ui.resizable",z.ui.mouse,{version:"1.13.2",widgetEventPrefix:"resize",options:{alsoResize:!1,animate:!1,animateDuration:"slow",animateEasing:"swing",aspectRatio:!1,autoHide:!1,classes:{"ui-resizable-se":"ui-icon ui-icon-gripsmall-diagonal-se"},containment:!1,ghost:!1,grid:!1,handles:"e,s,se",helper:!1,maxHeight:null,maxWidth:null,minHeight:10,minWidth:10,zIndex:90,resize:null,start:null,stop:null},_num:function(t){return parseFloat(t)||0},_isNumber:function(t){return!isNaN(parseFloat(t))},_hasScroll:function(t,i){if("hidden"===z(t).css("overflow"))return!1;var i=i&&"left"===i?"scrollLeft":"scrollTop",e=!1;if(0<t[i])return!0;try{t[i]=1,e=0<t[i],t[i]=0}catch(t){}return e},_create:function(){var t,i=this.options,e=this;this._addClass("ui-resizable"),z.extend(this,{_aspectRatio:!!i.aspectRatio,aspectRatio:i.aspectRatio,originalElement:this.element,_proportionallyResizeElements:[],_helper:i.helper||i.ghost||i.animate?i.helper||"ui-resizable-helper":null}),this.element[0].nodeName.match(/^(canvas|textarea|input|select|button|img)$/i)&&(this.element.wrap(z("<div class='ui-wrapper'></div>").css({overflow:"hidden",position:this.element.css("position"),width:this.element.outerWidth(),height:this.element.outerHeight(),top:this.element.css("top"),left:this.element.css("left")})),this.element=this.element.parent().data("ui-resizable",this.element.resizable("instance")),this.elementIsWrapper=!0,t={marginTop:this.originalElement.css("marginTop"),marginRight:this.originalElement.css("marginRight"),marginBottom:this.originalElement.css("marginBottom"),marginLeft:this.originalElement.css("marginLeft")},this.element.css(t),this.originalElement.css("margin",0),this.originalResizeStyle=this.originalElement.css("resize"),this.originalElement.css("resize","none"),this._proportionallyResizeElements.push(this.originalElement.css({position:"static",zoom:1,display:"block"})),this.originalElement.css(t),this._proportionallyResize()),this._setupHandles(),i.autoHide&&z(this.element).on("mouseenter",function(){i.disabled||(e._removeClass("ui-resizable-autohide"),e._handles.show())}).on("mouseleave",function(){i.disabled||e.resizing||(e._addClass("ui-resizable-autohide"),e._handles.hide())}),this._mouseInit()},_destroy:function(){this._mouseDestroy(),this._addedHandles.remove();function t(t){z(t).removeData("resizable").removeData("ui-resizable").off(".resizable")}var i;return this.elementIsWrapper&&(t(this.element),i=this.element,this.originalElement.css({position:i.css("position"),width:i.outerWidth(),height:i.outerHeight(),top:i.css("top"),left:i.css("left")}).insertAfter(i),i.remove()),this.originalElement.css("resize",this.originalResizeStyle),t(this.originalElement),this},_setOption:function(t,i){switch(this._super(t,i),t){case"handles":this._removeHandles(),this._setupHandles();break;case"aspectRatio":this._aspectRatio=!!i}},_setupHandles:function(){var t,i,e,s,h,n=this.options,o=this;if(this.handles=n.handles||(z(".ui-resizable-handle",this.element).length?{n:".ui-resizable-n",e:".ui-resizable-e",s:".ui-resizable-s",w:".ui-resizable-w",se:".ui-resizable-se",sw:".ui-resizable-sw",ne:".ui-resizable-ne",nw:".ui-resizable-nw"}:"e,s,se"),this._handles=z(),this._addedHandles=z(),this.handles.constructor===String)for("all"===this.handles&&(this.handles="n,e,s,w,se,sw,ne,nw"),e=this.handles.split(","),this.handles={},i=0;i<e.length;i++)s="ui-resizable-"+(t=String.prototype.trim.call(e[i])),h=z("<div>"),this._addClass(h,"ui-resizable-handle "+s),h.css({zIndex:n.zIndex}),this.handles[t]=".ui-resizable-"+t,this.element.children(this.handles[t]).length||(this.element.append(h),this._addedHandles=this._addedHandles.add(h));this._renderAxis=function(t){var i,e,s;for(i in t=t||this.element,this.handles)this.handles[i].constructor===String?this.handles[i]=this.element.children(this.handles[i]).first().show():(this.handles[i].jquery||this.handles[i].nodeType)&&(this.handles[i]=z(this.handles[i]),this._on(this.handles[i],{mousedown:o._mouseDown})),this.elementIsWrapper&&this.originalElement[0].nodeName.match(/^(textarea|input|select|button)$/i)&&(s=z(this.handles[i],this.element),s=/sw|ne|nw|se|n|s/.test(i)?s.outerHeight():s.outerWidth(),e=["padding",/ne|nw|n/.test(i)?"Top":/se|sw|s/.test(i)?"Bottom":/^e$/.test(i)?"Right":"Left"].join(""),t.css(e,s),this._proportionallyResize()),this._handles=this._handles.add(this.handles[i])},this._renderAxis(this.element),this._handles=this._handles.add(this.element.find(".ui-resizable-handle")),this._handles.disableSelection(),this._handles.on("mouseover",function(){o.resizing||(this.className&&(h=this.className.match(/ui-resizable-(se|sw|ne|nw|n|e|s|w)/i)),o.axis=h&&h[1]?h[1]:"se")}),n.autoHide&&(this._handles.hide(),this._addClass("ui-resizable-autohide"))},_removeHandles:function(){this._addedHandles.remove()},_mouseCapture:function(t){var i,e,s=!1;for(i in this.handles)(e=z(this.handles[i])[0])!==t.target&&!z.contains(e,t.target)||(s=!0);return!this.options.disabled&&s},_mouseStart:function(t){var i,e,s=this.options,h=this.element;return this.resizing=!0,this._renderProxy(),i=this._num(this.helper.css("left")),e=this._num(this.helper.css("top")),s.containment&&(i+=z(s.containment).scrollLeft()||0,e+=z(s.containment).scrollTop()||0),this.offset=this.helper.offset(),this.position={left:i,top:e},this.size=this._helper?{width:this.helper.width(),height:this.helper.height()}:{width:h.width(),height:h.height()},this.originalSize=this._helper?{width:h.outerWidth(),height:h.outerHeight()}:{width:h.width(),height:h.height()},this.sizeDiff={width:h.outerWidth()-h.width(),height:h.outerHeight()-h.height()},this.originalPosition={left:i,top:e},this.originalMousePosition={left:t.pageX,top:t.pageY},this.aspectRatio="number"==typeof s.aspectRatio?s.aspectRatio:this.originalSize.width/this.originalSize.height||1,h=z(".ui-resizable-"+this.axis).css("cursor"),z("body").css("cursor","auto"===h?this.axis+"-resize":h),this._addClass("ui-resizable-resizing"),this._propagate("start",t),!0},_mouseDrag:function(t){var i=this.originalMousePosition,e=this.axis,s=t.pageX-i.left||0,i=t.pageY-i.top||0,e=this._change[e];return this._updatePrevProperties(),e&&(e=e.apply(this,[t,s,i]),this._updateVirtualBoundaries(t.shiftKey),(this._aspectRatio||t.shiftKey)&&(e=this._updateRatio(e,t)),e=this._respectSize(e,t),this._updateCache(e),this._propagate("resize",t),s=this._applyChanges(),!this._helper&&this._proportionallyResizeElements.length&&this._proportionallyResize(),z.isEmptyObject(s)||(this._updatePrevProperties(),this._trigger("resize",t,this.ui()),this._applyChanges())),!1},_mouseStop:function(t){this.resizing=!1;var i,e,s,h=this.options,n=this;return this._helper&&(e=(i=(e=this._proportionallyResizeElements).length&&/textarea/i.test(e[0].nodeName))&&this._hasScroll(e[0],"left")?0:n.sizeDiff.height,i=i?0:n.sizeDiff.width,i={width:n.helper.width()-i,height:n.helper.height()-e},e=parseFloat(n.element.css("left"))+(n.position.left-n.originalPosition.left)||null,s=parseFloat(n.element.css("top"))+(n.position.top-n.originalPosition.top)||null,h.animate||this.element.css(z.extend(i,{top:s,left:e})),n.helper.height(n.size.height),n.helper.width(n.size.width),this._helper&&!h.animate&&this._proportionallyResize()),z("body").css("cursor","auto"),this._removeClass("ui-resizable-resizing"),this._propagate("stop",t),this._helper&&this.helper.remove(),!1},_updatePrevProperties:function(){this.prevPosition={top:this.position.top,left:this.position.left},this.prevSize={width:this.size.width,height:this.size.height}},_applyChanges:function(){var t={};return this.position.top!==this.prevPosition.top&&(t.top=this.position.top+"px"),this.position.left!==this.prevPosition.left&&(t.left=this.position.left+"px"),this.size.width!==this.prevSize.width&&(t.width=this.size.width+"px"),this.size.height!==this.prevSize.height&&(t.height=this.size.height+"px"),this.helper.css(t),t},_updateVirtualBoundaries:function(t){var i,e,s,h=this.options,h={minWidth:this._isNumber(h.minWidth)?h.minWidth:0,maxWidth:this._isNumber(h.maxWidth)?h.maxWidth:1/0,minHeight:this._isNumber(h.minHeight)?h.minHeight:0,maxHeight:this._isNumber(h.maxHeight)?h.maxHeight:1/0};(this._aspectRatio||t)&&(t=h.minHeight*this.aspectRatio,e=h.minWidth/this.aspectRatio,i=h.maxHeight*this.aspectRatio,s=h.maxWidth/this.aspectRatio,t>h.minWidth&&(h.minWidth=t),e>h.minHeight&&(h.minHeight=e),i<h.maxWidth&&(h.maxWidth=i),s<h.maxHeight&&(h.maxHeight=s)),this._vBoundaries=h},_updateCache:function(t){this.offset=this.helper.offset(),this._isNumber(t.left)&&(this.position.left=t.left),this._isNumber(t.top)&&(this.position.top=t.top),this._isNumber(t.height)&&(this.size.height=t.height),this._isNumber(t.width)&&(this.size.width=t.width)},_updateRatio:function(t){var i=this.position,e=this.size,s=this.axis;return this._isNumber(t.height)?t.width=t.height*this.aspectRatio:this._isNumber(t.width)&&(t.height=t.width/this.aspectRatio),"sw"===s&&(t.left=i.left+(e.width-t.width),t.top=null),"nw"===s&&(t.top=i.top+(e.height-t.height),t.left=i.left+(e.width-t.width)),t},_respectSize:function(t){var i=this._vBoundaries,e=this.axis,s=this._isNumber(t.width)&&i.maxWidth&&i.maxWidth<t.width,h=this._isNumber(t.height)&&i.maxHeight&&i.maxHeight<t.height,n=this._isNumber(t.width)&&i.minWidth&&i.minWidth>t.width,o=this._isNumber(t.height)&&i.minHeight&&i.minHeight>t.height,a=this.originalPosition.left+this.originalSize.width,l=this.originalPosition.top+this.originalSize.height,r=/sw|nw|w/.test(e),e=/nw|ne|n/.test(e);return n&&(t.width=i.minWidth),o&&(t.height=i.minHeight),s&&(t.width=i.maxWidth),h&&(t.height=i.maxHeight),n&&r&&(t.left=a-i.minWidth),s&&r&&(t.left=a-i.maxWidth),o&&e&&(t.top=l-i.minHeight),h&&e&&(t.top=l-i.maxHeight),t.width||t.height||t.left||!t.top?t.width||t.height||t.top||!t.left||(t.left=null):t.top=null,t},_getPaddingPlusBorderDimensions:function(t){for(var i=0,e=[],s=[t.css("borderTopWidth"),t.css("borderRightWidth"),t.css("borderBottomWidth"),t.css("borderLeftWidth")],h=[t.css("paddingTop"),t.css("paddingRight"),t.css("paddingBottom"),t.css("paddingLeft")];i<4;i++)e[i]=parseFloat(s[i])||0,e[i]+=parseFloat(h[i])||0;return{height:e[0]+e[2],width:e[1]+e[3]}},_proportionallyResize:function(){if(this._proportionallyResizeElements.length)for(var t,i=0,e=this.helper||this.element;i<this._proportionallyResizeElements.length;i++)t=this._proportionallyResizeElements[i],this.outerDimensions||(this.outerDimensions=this._getPaddingPlusBorderDimensions(t)),t.css({height:e.height()-this.outerDimensions.height||0,width:e.width()-this.outerDimensions.width||0})},_renderProxy:function(){var t=this.element,i=this.options;this.elementOffset=t.offset(),this._helper?(this.helper=this.helper||z("<div></div>").css({overflow:"hidden"}),this._addClass(this.helper,this._helper),this.helper.css({width:this.element.outerWidth(),height:this.element.outerHeight(),position:"absolute",left:this.elementOffset.left+"px",top:this.elementOffset.top+"px",zIndex:++i.zIndex}),this.helper.appendTo("body").disableSelection()):this.helper=this.element},_change:{e:function(t,i){return{width:this.originalSize.width+i}},w:function(t,i){var e=this.originalSize;return{left:this.originalPosition.left+i,width:e.width-i}},n:function(t,i,e){var s=this.originalSize;return{top:this.originalPosition.top+e,height:s.height-e}},s:function(t,i,e){return{height:this.originalSize.height+e}},se:function(t,i,e){return z.extend(this._change.s.apply(this,arguments),this._change.e.apply(this,[t,i,e]))},sw:function(t,i,e){return z.extend(this._change.s.apply(this,arguments),this._change.w.apply(this,[t,i,e]))},ne:function(t,i,e){return z.extend(this._change.n.apply(this,arguments),this._change.e.apply(this,[t,i,e]))},nw:function(t,i,e){return z.extend(this._change.n.apply(this,arguments),this._change.w.apply(this,[t,i,e]))}},_propagate:function(t,i){z.ui.plugin.call(this,t,[i,this.ui()]),"resize"!==t&&this._trigger(t,i,this.ui())},plugins:{},ui:function(){return{originalElement:this.originalElement,element:this.element,helper:this.helper,position:this.position,size:this.size,originalSize:this.originalSize,originalPosition:this.originalPosition}}}),z.ui.plugin.add("resizable","animate",{stop:function(i){var e=z(this).resizable("instance"),t=e.options,s=e._proportionallyResizeElements,h=s.length&&/textarea/i.test(s[0].nodeName),n=h&&e._hasScroll(s[0],"left")?0:e.sizeDiff.height,h=h?0:e.sizeDiff.width,h={width:e.size.width-h,height:e.size.height-n},n=parseFloat(e.element.css("left"))+(e.position.left-e.originalPosition.left)||null,o=parseFloat(e.element.css("top"))+(e.position.top-e.originalPosition.top)||null;e.element.animate(z.extend(h,o&&n?{top:o,left:n}:{}),{duration:t.animateDuration,easing:t.animateEasing,step:function(){var t={width:parseFloat(e.element.css("width")),height:parseFloat(e.element.css("height")),top:parseFloat(e.element.css("top")),left:parseFloat(e.element.css("left"))};s&&s.length&&z(s[0]).css({width:t.width,height:t.height}),e._updateCache(t),e._propagate("resize",i)}})}}),z.ui.plugin.add("resizable","containment",{start:function(){var e,s,t,i,h=z(this).resizable("instance"),n=h.options,o=h.element,n=n.containment,o=n instanceof z?n.get(0):/parent/.test(n)?o.parent().get(0):n;o&&(h.containerElement=z(o),/document/.test(n)||n===document?(h.containerOffset={left:0,top:0},h.containerPosition={left:0,top:0},h.parentData={element:z(document),left:0,top:0,width:z(document).width(),height:z(document).height()||document.body.parentNode.scrollHeight}):(e=z(o),s=[],z(["Top","Right","Left","Bottom"]).each(function(t,i){s[t]=h._num(e.css("padding"+i))}),h.containerOffset=e.offset(),h.containerPosition=e.position(),h.containerSize={height:e.innerHeight()-s[3],width:e.innerWidth()-s[1]},n=h.containerOffset,i=h.containerSize.height,t=h.containerSize.width,t=h._hasScroll(o,"left")?o.scrollWidth:t,i=h._hasScroll(o)?o.scrollHeight:i,h.parentData={element:o,left:n.left,top:n.top,width:t,height:i}))},resize:function(t){var i=z(this).resizable("instance"),e=i.options,s=i.containerOffset,h=i.position,t=i._aspectRatio||t.shiftKey,n={top:0,left:0},o=i.containerElement,a=!0;o[0]!==document&&/static/.test(o.css("position"))&&(n=s),h.left<(i._helper?s.left:0)&&(i.size.width=i.size.width+(i._helper?i.position.left-s.left:i.position.left-n.left),t&&(i.size.height=i.size.width/i.aspectRatio,a=!1),i.position.left=e.helper?s.left:0),h.top<(i._helper?s.top:0)&&(i.size.height=i.size.height+(i._helper?i.position.top-s.top:i.position.top),t&&(i.size.width=i.size.height*i.aspectRatio,a=!1),i.position.top=i._helper?s.top:0),o=i.containerElement.get(0)===i.element.parent().get(0),e=/relative|absolute/.test(i.containerElement.css("position")),o&&e?(i.offset.left=i.parentData.left+i.position.left,i.offset.top=i.parentData.top+i.position.top):(i.offset.left=i.element.offset().left,i.offset.top=i.element.offset().top),h=Math.abs(i.sizeDiff.width+(i._helper?i.offset.left-n.left:i.offset.left-s.left)),o=Math.abs(i.sizeDiff.height+(i._helper?i.offset.top-n.top:i.offset.top-s.top)),h+i.size.width>=i.parentData.width&&(i.size.width=i.parentData.width-h,t&&(i.size.height=i.size.width/i.aspectRatio,a=!1)),o+i.size.height>=i.parentData.height&&(i.size.height=i.parentData.height-o,t&&(i.size.width=i.size.height*i.aspectRatio,a=!1)),a||(i.position.left=i.prevPosition.left,i.position.top=i.prevPosition.top,i.size.width=i.prevSize.width,i.size.height=i.prevSize.height)},stop:function(){var t=z(this).resizable("instance"),i=t.options,e=t.containerOffset,s=t.containerPosition,h=t.containerElement,n=z(t.helper),o=n.offset(),a=n.outerWidth()-t.sizeDiff.width,n=n.outerHeight()-t.sizeDiff.height;t._helper&&!i.animate&&/relative/.test(h.css("position"))&&z(this).css({left:o.left-s.left-e.left,width:a,height:n}),t._helper&&!i.animate&&/static/.test(h.css("position"))&&z(this).css({left:o.left-s.left-e.left,width:a,height:n})}}),z.ui.plugin.add("resizable","alsoResize",{start:function(){var t=z(this).resizable("instance").options;z(t.alsoResize).each(function(){var t=z(this);t.data("ui-resizable-alsoresize",{width:parseFloat(t.width()),height:parseFloat(t.height()),left:parseFloat(t.css("left")),top:parseFloat(t.css("top"))})})},resize:function(t,e){var i=z(this).resizable("instance"),s=i.options,h=i.originalSize,n=i.originalPosition,o={height:i.size.height-h.height||0,width:i.size.width-h.width||0,top:i.position.top-n.top||0,left:i.position.left-n.left||0};z(s.alsoResize).each(function(){var t=z(this),s=z(this).data("ui-resizable-alsoresize"),h={},i=t.parents(e.originalElement[0]).length?["width","height"]:["width","height","top","left"];z.each(i,function(t,i){var e=(s[i]||0)+(o[i]||0);e&&0<=e&&(h[i]=e||null)}),t.css(h)})},stop:function(){z(this).removeData("ui-resizable-alsoresize")}}),z.ui.plugin.add("resizable","ghost",{start:function(){var t=z(this).resizable("instance"),i=t.size;t.ghost=t.originalElement.clone(),t.ghost.css({opacity:.25,display:"block",position:"relative",height:i.height,width:i.width,margin:0,left:0,top:0}),t._addClass(t.ghost,"ui-resizable-ghost"),!1!==z.uiBackCompat&&"string"==typeof t.options.ghost&&t.ghost.addClass(this.options.ghost),t.ghost.appendTo(t.helper)},resize:function(){var t=z(this).resizable("instance");t.ghost&&t.ghost.css({position:"relative",height:t.size.height,width:t.size.width})},stop:function(){var t=z(this).resizable("instance");t.ghost&&t.helper&&t.helper.get(0).removeChild(t.ghost.get(0))}}),z.ui.plugin.add("resizable","grid",{resize:function(){var t,i=z(this).resizable("instance"),e=i.options,s=i.size,h=i.originalSize,n=i.originalPosition,o=i.axis,a="number"==typeof e.grid?[e.grid,e.grid]:e.grid,l=a[0]||1,r=a[1]||1,p=Math.round((s.width-h.width)/l)*l,s=Math.round((s.height-h.height)/r)*r,d=h.width+p,g=h.height+s,u=e.maxWidth&&e.maxWidth<d,c=e.maxHeight&&e.maxHeight<g,f=e.minWidth&&e.minWidth>d,m=e.minHeight&&e.minHeight>g;e.grid=a,f&&(d+=l),m&&(g+=r),u&&(d-=l),c&&(g-=r),/^(se|s|e)$/.test(o)?(i.size.width=d,i.size.height=g):/^(ne)$/.test(o)?(i.size.width=d,i.size.height=g,i.position.top=n.top-s):/^(sw)$/.test(o)?(i.size.width=d,i.size.height=g,i.position.left=n.left-p):((g-r<=0||d-l<=0)&&(t=i._getPaddingPlusBorderDimensions(this)),0<g-r?(i.size.height=g,i.position.top=n.top-s):(g=r-t.height,i.size.height=g,i.position.top=n.top+h.height-g),0<d-l?(i.size.width=d,i.position.left=n.left-p):(d=l-t.width,i.size.width=d,i.position.left=n.left+h.width-d))}}),z.ui.resizable});;
/*!
 * jQuery UI Dialog 1.13.2
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
!function(i){"use strict";"function"==typeof define&&define.amd?define(["jquery","./button","./draggable","./mouse","./resizable","../focusable","../keycode","../position","../safe-active-element","../safe-blur","../tabbable","../unique-id","../version","../widget"],i):i(jQuery)}(function(l){"use strict";return l.widget("ui.dialog",{version:"1.13.2",options:{appendTo:"body",autoOpen:!0,buttons:[],classes:{"ui-dialog":"ui-corner-all","ui-dialog-titlebar":"ui-corner-all"},closeOnEscape:!0,closeText:"Close",draggable:!0,hide:null,height:"auto",maxHeight:null,maxWidth:null,minHeight:150,minWidth:150,modal:!1,position:{my:"center",at:"center",of:window,collision:"fit",using:function(i){var t=l(this).css(i).offset().top;t<0&&l(this).css("top",i.top-t)}},resizable:!0,show:null,title:null,width:300,beforeClose:null,close:null,drag:null,dragStart:null,dragStop:null,focus:null,open:null,resize:null,resizeStart:null,resizeStop:null},sizeRelatedOptions:{buttons:!0,height:!0,maxHeight:!0,maxWidth:!0,minHeight:!0,minWidth:!0,width:!0},resizableRelatedOptions:{maxHeight:!0,maxWidth:!0,minHeight:!0,minWidth:!0},_create:function(){this.originalCss={display:this.element[0].style.display,width:this.element[0].style.width,minHeight:this.element[0].style.minHeight,maxHeight:this.element[0].style.maxHeight,height:this.element[0].style.height},this.originalPosition={parent:this.element.parent(),index:this.element.parent().children().index(this.element)},this.originalTitle=this.element.attr("title"),null==this.options.title&&null!=this.originalTitle&&(this.options.title=this.originalTitle),this.options.disabled&&(this.options.disabled=!1),this._createWrapper(),this.element.show().removeAttr("title").appendTo(this.uiDialog),this._addClass("ui-dialog-content","ui-widget-content"),this._createTitlebar(),this._createButtonPane(),this.options.draggable&&l.fn.draggable&&this._makeDraggable(),this.options.resizable&&l.fn.resizable&&this._makeResizable(),this._isOpen=!1,this._trackFocus()},_init:function(){this.options.autoOpen&&this.open()},_appendTo:function(){var i=this.options.appendTo;return i&&(i.jquery||i.nodeType)?l(i):this.document.find(i||"body").eq(0)},_destroy:function(){var i,t=this.originalPosition;this._untrackInstance(),this._destroyOverlay(),this.element.removeUniqueId().css(this.originalCss).detach(),this.uiDialog.remove(),this.originalTitle&&this.element.attr("title",this.originalTitle),(i=t.parent.children().eq(t.index)).length&&i[0]!==this.element[0]?i.before(this.element):t.parent.append(this.element)},widget:function(){return this.uiDialog},disable:l.noop,enable:l.noop,close:function(i){var t=this;this._isOpen&&!1!==this._trigger("beforeClose",i)&&(this._isOpen=!1,this._focusedElement=null,this._destroyOverlay(),this._untrackInstance(),this.opener.filter(":focusable").trigger("focus").length||l.ui.safeBlur(l.ui.safeActiveElement(this.document[0])),this._hide(this.uiDialog,this.options.hide,function(){t._trigger("close",i)}))},isOpen:function(){return this._isOpen},moveToTop:function(){this._moveToTop()},_moveToTop:function(i,t){var e=!1,o=this.uiDialog.siblings(".ui-front:visible").map(function(){return+l(this).css("z-index")}).get(),o=Math.max.apply(null,o);return o>=+this.uiDialog.css("z-index")&&(this.uiDialog.css("z-index",o+1),e=!0),e&&!t&&this._trigger("focus",i),e},open:function(){var i=this;this._isOpen?this._moveToTop()&&this._focusTabbable():(this._isOpen=!0,this.opener=l(l.ui.safeActiveElement(this.document[0])),this._size(),this._position(),this._createOverlay(),this._moveToTop(null,!0),this.overlay&&this.overlay.css("z-index",this.uiDialog.css("z-index")-1),this._show(this.uiDialog,this.options.show,function(){i._focusTabbable(),i._trigger("focus")}),this._makeFocusTarget(),this._trigger("open"))},_focusTabbable:function(){var i=this._focusedElement;(i=(i=(i=(i=(i=i||this.element.find("[autofocus]")).length?i:this.element.find(":tabbable")).length?i:this.uiDialogButtonPane.find(":tabbable")).length?i:this.uiDialogTitlebarClose.filter(":tabbable")).length?i:this.uiDialog).eq(0).trigger("focus")},_restoreTabbableFocus:function(){var i=l.ui.safeActiveElement(this.document[0]);this.uiDialog[0]===i||l.contains(this.uiDialog[0],i)||this._focusTabbable()},_keepFocus:function(i){i.preventDefault(),this._restoreTabbableFocus(),this._delay(this._restoreTabbableFocus)},_createWrapper:function(){this.uiDialog=l("<div>").hide().attr({tabIndex:-1,role:"dialog"}).appendTo(this._appendTo()),this._addClass(this.uiDialog,"ui-dialog","ui-widget ui-widget-content ui-front"),this._on(this.uiDialog,{keydown:function(i){var t,e,o;this.options.closeOnEscape&&!i.isDefaultPrevented()&&i.keyCode&&i.keyCode===l.ui.keyCode.ESCAPE?(i.preventDefault(),this.close(i)):i.keyCode!==l.ui.keyCode.TAB||i.isDefaultPrevented()||(t=this.uiDialog.find(":tabbable"),e=t.first(),o=t.last(),i.target!==o[0]&&i.target!==this.uiDialog[0]||i.shiftKey?i.target!==e[0]&&i.target!==this.uiDialog[0]||!i.shiftKey||(this._delay(function(){o.trigger("focus")}),i.preventDefault()):(this._delay(function(){e.trigger("focus")}),i.preventDefault()))},mousedown:function(i){this._moveToTop(i)&&this._focusTabbable()}}),this.element.find("[aria-describedby]").length||this.uiDialog.attr({"aria-describedby":this.element.uniqueId().attr("id")})},_createTitlebar:function(){var i;this.uiDialogTitlebar=l("<div>"),this._addClass(this.uiDialogTitlebar,"ui-dialog-titlebar","ui-widget-header ui-helper-clearfix"),this._on(this.uiDialogTitlebar,{mousedown:function(i){l(i.target).closest(".ui-dialog-titlebar-close")||this.uiDialog.trigger("focus")}}),this.uiDialogTitlebarClose=l("<button type='button'></button>").button({label:l("<a>").text(this.options.closeText).html(),icon:"ui-icon-closethick",showLabel:!1}).appendTo(this.uiDialogTitlebar),this._addClass(this.uiDialogTitlebarClose,"ui-dialog-titlebar-close"),this._on(this.uiDialogTitlebarClose,{click:function(i){i.preventDefault(),this.close(i)}}),i=l("<span>").uniqueId().prependTo(this.uiDialogTitlebar),this._addClass(i,"ui-dialog-title"),this._title(i),this.uiDialogTitlebar.prependTo(this.uiDialog),this.uiDialog.attr({"aria-labelledby":i.attr("id")})},_title:function(i){this.options.title?i.text(this.options.title):i.html("&#160;")},_createButtonPane:function(){this.uiDialogButtonPane=l("<div>"),this._addClass(this.uiDialogButtonPane,"ui-dialog-buttonpane","ui-widget-content ui-helper-clearfix"),this.uiButtonSet=l("<div>").appendTo(this.uiDialogButtonPane),this._addClass(this.uiButtonSet,"ui-dialog-buttonset"),this._createButtons()},_createButtons:function(){var o=this,i=this.options.buttons;this.uiDialogButtonPane.remove(),this.uiButtonSet.empty(),l.isEmptyObject(i)||Array.isArray(i)&&!i.length?this._removeClass(this.uiDialog,"ui-dialog-buttons"):(l.each(i,function(i,t){var e;t=l.extend({type:"button"},t="function"==typeof t?{click:t,text:i}:t),e=t.click,i={icon:t.icon,iconPosition:t.iconPosition,showLabel:t.showLabel,icons:t.icons,text:t.text},delete t.click,delete t.icon,delete t.iconPosition,delete t.showLabel,delete t.icons,"boolean"==typeof t.text&&delete t.text,l("<button></button>",t).button(i).appendTo(o.uiButtonSet).on("click",function(){e.apply(o.element[0],arguments)})}),this._addClass(this.uiDialog,"ui-dialog-buttons"),this.uiDialogButtonPane.appendTo(this.uiDialog))},_makeDraggable:function(){var s=this,n=this.options;function a(i){return{position:i.position,offset:i.offset}}this.uiDialog.draggable({cancel:".ui-dialog-content, .ui-dialog-titlebar-close",handle:".ui-dialog-titlebar",containment:"document",start:function(i,t){s._addClass(l(this),"ui-dialog-dragging"),s._blockFrames(),s._trigger("dragStart",i,a(t))},drag:function(i,t){s._trigger("drag",i,a(t))},stop:function(i,t){var e=t.offset.left-s.document.scrollLeft(),o=t.offset.top-s.document.scrollTop();n.position={my:"left top",at:"left"+(0<=e?"+":"")+e+" top"+(0<=o?"+":"")+o,of:s.window},s._removeClass(l(this),"ui-dialog-dragging"),s._unblockFrames(),s._trigger("dragStop",i,a(t))}})},_makeResizable:function(){var s=this,n=this.options,i=n.resizable,t=this.uiDialog.css("position"),i="string"==typeof i?i:"n,e,s,w,se,sw,ne,nw";function a(i){return{originalPosition:i.originalPosition,originalSize:i.originalSize,position:i.position,size:i.size}}this.uiDialog.resizable({cancel:".ui-dialog-content",containment:"document",alsoResize:this.element,maxWidth:n.maxWidth,maxHeight:n.maxHeight,minWidth:n.minWidth,minHeight:this._minHeight(),handles:i,start:function(i,t){s._addClass(l(this),"ui-dialog-resizing"),s._blockFrames(),s._trigger("resizeStart",i,a(t))},resize:function(i,t){s._trigger("resize",i,a(t))},stop:function(i,t){var e=s.uiDialog.offset(),o=e.left-s.document.scrollLeft(),e=e.top-s.document.scrollTop();n.height=s.uiDialog.height(),n.width=s.uiDialog.width(),n.position={my:"left top",at:"left"+(0<=o?"+":"")+o+" top"+(0<=e?"+":"")+e,of:s.window},s._removeClass(l(this),"ui-dialog-resizing"),s._unblockFrames(),s._trigger("resizeStop",i,a(t))}}).css("position",t)},_trackFocus:function(){this._on(this.widget(),{focusin:function(i){this._makeFocusTarget(),this._focusedElement=l(i.target)}})},_makeFocusTarget:function(){this._untrackInstance(),this._trackingInstances().unshift(this)},_untrackInstance:function(){var i=this._trackingInstances(),t=l.inArray(this,i);-1!==t&&i.splice(t,1)},_trackingInstances:function(){var i=this.document.data("ui-dialog-instances");return i||this.document.data("ui-dialog-instances",i=[]),i},_minHeight:function(){var i=this.options;return"auto"===i.height?i.minHeight:Math.min(i.minHeight,i.height)},_position:function(){var i=this.uiDialog.is(":visible");i||this.uiDialog.show(),this.uiDialog.position(this.options.position),i||this.uiDialog.hide()},_setOptions:function(i){var e=this,o=!1,s={};l.each(i,function(i,t){e._setOption(i,t),i in e.sizeRelatedOptions&&(o=!0),i in e.resizableRelatedOptions&&(s[i]=t)}),o&&(this._size(),this._position()),this.uiDialog.is(":data(ui-resizable)")&&this.uiDialog.resizable("option",s)},_setOption:function(i,t){var e,o=this.uiDialog;"disabled"!==i&&(this._super(i,t),"appendTo"===i&&this.uiDialog.appendTo(this._appendTo()),"buttons"===i&&this._createButtons(),"closeText"===i&&this.uiDialogTitlebarClose.button({label:l("<a>").text(""+this.options.closeText).html()}),"draggable"===i&&((e=o.is(":data(ui-draggable)"))&&!t&&o.draggable("destroy"),!e&&t&&this._makeDraggable()),"position"===i&&this._position(),"resizable"===i&&((e=o.is(":data(ui-resizable)"))&&!t&&o.resizable("destroy"),e&&"string"==typeof t&&o.resizable("option","handles",t),e||!1===t||this._makeResizable()),"title"===i&&this._title(this.uiDialogTitlebar.find(".ui-dialog-title")))},_size:function(){var i,t,e,o=this.options;this.element.show().css({width:"auto",minHeight:0,maxHeight:"none",height:0}),o.minWidth>o.width&&(o.width=o.minWidth),i=this.uiDialog.css({height:"auto",width:o.width}).outerHeight(),t=Math.max(0,o.minHeight-i),e="number"==typeof o.maxHeight?Math.max(0,o.maxHeight-i):"none","auto"===o.height?this.element.css({minHeight:t,maxHeight:e,height:"auto"}):this.element.height(Math.max(0,o.height-i)),this.uiDialog.is(":data(ui-resizable)")&&this.uiDialog.resizable("option","minHeight",this._minHeight())},_blockFrames:function(){this.iframeBlocks=this.document.find("iframe").map(function(){var i=l(this);return l("<div>").css({position:"absolute",width:i.outerWidth(),height:i.outerHeight()}).appendTo(i.parent()).offset(i.offset())[0]})},_unblockFrames:function(){this.iframeBlocks&&(this.iframeBlocks.remove(),delete this.iframeBlocks)},_allowInteraction:function(i){return!!l(i.target).closest(".ui-dialog").length||!!l(i.target).closest(".ui-datepicker").length},_createOverlay:function(){var e,o;this.options.modal&&(e=l.fn.jquery.substring(0,4),o=!0,this._delay(function(){o=!1}),this.document.data("ui-dialog-overlays")||this.document.on("focusin.ui-dialog",function(i){var t;o||((t=this._trackingInstances()[0])._allowInteraction(i)||(i.preventDefault(),t._focusTabbable(),"3.4."!==e&&"3.5."!==e||t._delay(t._restoreTabbableFocus)))}.bind(this)),this.overlay=l("<div>").appendTo(this._appendTo()),this._addClass(this.overlay,null,"ui-widget-overlay ui-front"),this._on(this.overlay,{mousedown:"_keepFocus"}),this.document.data("ui-dialog-overlays",(this.document.data("ui-dialog-overlays")||0)+1))},_destroyOverlay:function(){var i;this.options.modal&&this.overlay&&((i=this.document.data("ui-dialog-overlays")-1)?this.document.data("ui-dialog-overlays",i):(this.document.off("focusin.ui-dialog"),this.document.removeData("ui-dialog-overlays")),this.overlay.remove(),this.overlay=null)}}),!1!==l.uiBackCompat&&l.widget("ui.dialog",l.ui.dialog,{options:{dialogClass:""},_createWrapper:function(){this._super(),this.uiDialog.addClass(this.options.dialogClass)},_setOption:function(i,t){"dialogClass"===i&&this.uiDialog.removeClass(this.options.dialogClass).addClass(t),this._superApply(arguments)}}),l.ui.dialog});;
/**
 * @file
 * Fix conflict with jquery.ui focusin event handling in dialogs.
 */
(function ($) {

  'use strict';

  /**
   * Override the _allowInteraction() extension point.
   *
   * @see https://api.jqueryui.com/dialog/#method-_allowInteraction
   * @see https://bugs.jqueryui.com/ticket/9087/
   */
  $.widget('ui.dialog', $.ui.dialog, {
    _allowInteraction: function _allowInteraction(event) {
      // The CKEditor 5 balloon toolbar is outside the modal container, by
      // specifying CKEditor elements as allowed-interaction outside the modal,
      // the balloon buttons can be clicked. All editor form elements, like
      // buttons in balloon toolbars get the "ck" class.
      if ($(event.target).hasClass('ck')) {
        return true;
      }
      return this._super(event);
    }
  });

})(jQuery);
;
/**
 * @file
 *
 * Dialog API inspired by HTML5 dialog element:
 * http://www.whatwg.org/specs/web-apps/current-work/multipage/commands.html#the-dialog-element
 */
(function ($) {

"use strict";

Backdrop.settings.dialog = {
  // This option will turn off resizable and draggable.
  autoResize: true,
  // jQuery UI does not support percentage heights, but we convert this property
  // in the resetPosition() function.
  maxHeight: '95%',
  // jQuery UI defaults to 300px, use 100% width to allow for responsive
  // dialogs. CSS can override by specifying a max-width.
  width: '100%',
  position: { my: "center", at: "center", of: window },
  close: function (e) {
    Backdrop.detachBehaviors(e.target, null, 'unload');
  }
};

Backdrop.dialog = function (element, options) {

  function openDialog (settings) {
    settings = $.extend({}, Backdrop.settings.dialog, options, settings);
    settings.beforeClose = beforeClose;

    // Add class to the page to modify overall page display.
    $('html').addClass('dialog-open');

    // Trigger a global event to allow scripts to bind events to the dialog.
    $(window).trigger('dialog:beforecreate', [dialog, $element, settings]);
    $element.dialog(settings);

    if (settings.autoResize === true || settings.autoResize === 'true') {
      // Add a class specifically to help to lock scrolling.
      $('html').addClass('dialog-auto-resize');

      // Callback function for positioning the dialog on resize/scroll.
      var resetPosition = function() {
        var positionOptions = ['width', 'height', 'minWidth', 'minHeight', 'maxHeight', 'maxWidth', 'position'];
        var windowHeight = $(window).height();
        var adjustedOptions = {};
        var option, optionValue, adjustedValue;
        for (var n = 0; n < positionOptions.length; n++) {
          option = positionOptions[n];
          optionValue = settings[option];
          if (optionValue) {
            // jQuery UI does not support percentages on heights, convert to pixels.
            if (typeof optionValue === 'string' && /%$/.test(optionValue) && /height/i.test(option)) {
              adjustedValue = parseInt(0.01 * parseInt(optionValue, 10) * windowHeight, 10);
              // Don't force the dialog to be bigger vertically than needed.
              if (option === 'height' && $element.parent().outerHeight() < adjustedValue) {
                adjustedValue = 'auto';
              }
              adjustedOptions[option] = adjustedValue;
            }
            else {
              adjustedOptions[option] = optionValue;
            }
          }
        }
        $element.dialog('option', adjustedOptions);
      };

      // If auto-resized, it can't be manually resized or moved.
      $element
        .dialog('option', {
            resizable: false,
            draggable: false
        })
        .dialog('widget').css('position', 'fixed');
      Backdrop.optimizedResize.add(resetPosition, 'dialogResize.' + dialogId);

      // Because of Chromium's behavior, we must wait until the ajax-loaded
      // jquery.ui.dialog.css is applied.
      var computedStyle = getComputedStyle($element[0]);
      var waitForCss = function(counter) {
        var cssOverflowProperty = computedStyle.getPropertyValue('overflow');
        // If the overflow is not 'auto' or 'hidden' yet, schedule this function
        // again, but prevent infinite loops for dialogs that use a different
        // overflow. 
        if (cssOverflowProperty != 'auto' && cssOverflowProperty != 'hidden' && counter < 10) {
          setTimeout(waitForCss, 10, ++counter);
        }
        else {
          resetPosition();
        }
      }
      setTimeout(waitForCss, 0, 0);
    }
    dialog.open = true;
    $(window).trigger('dialog:aftercreate', [dialog, $element, settings]);
  }

  function closeDialog (value) {
    $(window).trigger('dialog:beforeclose', [dialog, $element]);
    $element.dialog('close');
    dialog.returnValue = value;
    dialog.open = false;
    $(window).trigger('dialog:afterclose', [dialog, $element]);
  }

  /**
   * jQuery UI callback fired just before closing the dialog.
   *
   * This callback fires in all situations where the modal is closed, rather
   * than only through the Backdrop dialog API. For example hitting the escape
   * key or using the close button, which are triggered by jQuery UI directly.
   */
  function beforeClose (event, ui) {
    $('html').removeClass('dialog-open dialog-auto-resize');
    Backdrop.optimizedResize.remove('dialogResize.' + dialogId);
  }

  var undef;
  var $element = $(element);

  // Generate a dialog ID based on the microsecond the dialog was created.
  // When binding and unbinding window resize events, we use this ID to track
  // each individual dialog.
  var dialogId = Date.now().toString();

  var dialog = {
    open: false,
    returnValue: undef,
    show: function () {
      openDialog({modal: false});
    },
    showModal: function () {
      openDialog({modal: true});
    },
    close: closeDialog
  };

  return dialog;
};

})(jQuery);
;
/**
 * @file
 * Extends the Backdrop AJAX functionality to integrate the dialog API.
 */

(function ($) {

"use strict";

Backdrop.behaviors.dialog = {
  attach: function (context) {
    // Provide a known 'backdrop-modal' DOM element for Backdrop-based modal
    // dialogs. Non-modal dialogs are responsible for creating their own
    // elements, since there can be multiple non-modal dialogs at a time.
    if (!$('#backdrop-modal').length) {
      $('<div id="backdrop-modal" />').hide().appendTo('body');
    }

    // Special behaviors specific when attaching content within a dialog.
    // These behaviors usually fire after a validation error inside a dialog.
    var $dialog = $(context).closest('.ui-dialog-content');
    if ($dialog.length) {
      // Remove and replace the dialog buttons with those from the new form.
      if ($dialog.dialog('option', 'backdropAutoButtons')) {
        // Trigger an event to detect/sync changes to buttons.
        $dialog.trigger('dialogButtonsChange');
      }

      // Force focus on the modal when the behavior is run.
      $dialog.dialog('widget').trigger('focus');
    }
  },

  /**
   * Scan a dialog for any primary buttons and move them to the button area.
   *
   * @param $dialog
   *   An jQuery object containing the element that is the dialog target.
   * @return
   *   An array of buttons that need to be added to the button area.
   */
  prepareDialogButtons: function ($dialog) {
    var buttons = [];
    var $buttons = $dialog.find('.form-actions input[type=submit], .form-actions a.button');
    $buttons.each(function () {
      // Hidden form buttons need special attention. For browser consistency,
      // the button needs to be "visible" in order to have the enter key fire
      // the form submit event. So instead of a simple "hide" or
      // "display: none", we set its dimensions to zero.
      // See http://mattsnider.com/how-forms-submit-when-pressing-enter/
      var $originalButton = $(this).css({
        width: 0,
        height: 0,
        padding: 0,
        border: 0,
        overflow: 'hidden'
      });
      buttons.push({
        'text': $originalButton.html() || $originalButton.attr('value'),
        'class': $originalButton.attr('class'),
        'click': function (e) {
          $originalButton.trigger('mousedown').trigger('click').trigger('mouseup');
          e.preventDefault();
        }
      });
    });
    return buttons;
  }
};

/**
 * Command to open a dialog.
 */
Backdrop.ajax.prototype.commands.openDialog = function (ajax, response, status) {
  if (!response.selector) {
    return false;
  }
  var $dialog = $(response.selector);
  if (!$dialog.length) {
    // Create the element if needed.
    $dialog = $('<div id="' + response.selector.replace(/^#/, '') + '"/>').appendTo('body');
  }
  // Set up the wrapper, if there isn't one.
  if (!ajax.wrapper) {
    ajax.wrapper = $dialog.attr('id');
  }

  // Use the ajax.js insert command to populate the dialog contents.
  response.command = 'insert';
  response.method = 'html';
  ajax.commands.insert(ajax, response, status);

  // Move the buttons to the jQuery UI dialog buttons area.
  if (!response.dialogOptions.buttons) {
    response.dialogOptions.backdropAutoButtons = true;
    response.dialogOptions.buttons = Backdrop.behaviors.dialog.prepareDialogButtons($dialog);
  }

  // Bind dialogButtonsChange
  $dialog.on('dialogButtonsChange', function () {
    var buttons = Backdrop.behaviors.dialog.prepareDialogButtons($dialog);
    $dialog.dialog('option', 'buttons', buttons);
  });

  // Open the dialog itself.
  response.dialogOptions = response.dialogOptions || {};
  var dialog = Backdrop.dialog($dialog, response.dialogOptions);
  if (response.dialogOptions.modal) {
    dialog.showModal();
  }
  else {
    dialog.show();
  }

  // Add the standard Backdrop class for buttons for style consistency.
  $dialog.parent().find('.ui-dialog-buttonset').addClass('form-actions');
};

/**
 * Command to close a dialog.
 *
 * If no selector is given, it defaults to trying to close the modal.
 */
Backdrop.ajax.prototype.commands.closeDialog = function (ajax, response, status) {
  var $dialog = $(response.selector);
  if ($dialog.length) {
    Backdrop.dialog($dialog).close();
  }

  // Unbind dialogButtonsChange
  $dialog.off('dialogButtonsChange');
};

/**
 * Command to set a dialog property.
 *
 * jQuery UI specific way of setting dialog options.
 */
Backdrop.ajax.prototype.commands.setDialogOption = function (ajax, response, status) {
  var $dialog = $(response.selector);
  if ($dialog.length) {
    $dialog.dialog('option', response.optionName, response.optionValue);
  }
};

/**
 * Binds a listener on dialog creation to handle the cancel link.
 */
$(window).on('dialog:aftercreate', function (e, dialog, $element, settings) {
  $element.on('click.dialog', '.dialog-cancel', function (e) {
    dialog.close('cancel');
    e.preventDefault();
    e.stopPropagation();
  });
});

/**
 * Removes all 'dialog' listeners.
 */
$(window).on('dialog:beforeclose', function (e, dialog, $element) {
  $element.off('.dialog');
});

})(jQuery);;
