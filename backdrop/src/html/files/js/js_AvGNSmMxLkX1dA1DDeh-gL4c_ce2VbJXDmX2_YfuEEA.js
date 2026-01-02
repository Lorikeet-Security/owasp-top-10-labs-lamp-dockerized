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
/**
 * @file layout.admin.js
 *
 * Behaviors for editing a layout.
 */

(function ($) {

"use strict";

/**
 * Behavior for showing a list of layouts.
 *
 * Detect flexbox support for displaying our list of layouts with vertical
 * height matching for each row of layout template icons.
 */
Backdrop.behaviors.gridFloatFallback = {
  attach: function() {
    var $body = $('body');
    if (!$body.hasClass('grid-float-fallback-processed') && !Backdrop.featureDetect.flexbox()) {
      $('head').append('<link rel="stylesheet" type="text/css" href="/core/modules/layout/css/grid-float.css">');
      $body.addClass('grid-float-fallback-processed');
    }
  }
};

})(jQuery);
;
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
 * jQuery UI Droppable 1.13.2
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery","./draggable","./mouse","../version","../widget"],e):e(jQuery)}(function(a){"use strict";function h(e,t,i){return t<=e&&e<t+i}return a.widget("ui.droppable",{version:"1.13.2",widgetEventPrefix:"drop",options:{accept:"*",addClasses:!0,greedy:!1,scope:"default",tolerance:"intersect",activate:null,deactivate:null,drop:null,out:null,over:null},_create:function(){var e,t=this.options,i=t.accept;this.isover=!1,this.isout=!0,this.accept="function"==typeof i?i:function(e){return e.is(i)},this.proportions=function(){if(!arguments.length)return e=e||{width:this.element[0].offsetWidth,height:this.element[0].offsetHeight};e=arguments[0]},this._addToManager(t.scope),t.addClasses&&this._addClass("ui-droppable")},_addToManager:function(e){a.ui.ddmanager.droppables[e]=a.ui.ddmanager.droppables[e]||[],a.ui.ddmanager.droppables[e].push(this)},_splice:function(e){for(var t=0;t<e.length;t++)e[t]===this&&e.splice(t,1)},_destroy:function(){var e=a.ui.ddmanager.droppables[this.options.scope];this._splice(e)},_setOption:function(e,t){var i;"accept"===e?this.accept="function"==typeof t?t:function(e){return e.is(t)}:"scope"===e&&(i=a.ui.ddmanager.droppables[this.options.scope],this._splice(i),this._addToManager(t)),this._super(e,t)},_activate:function(e){var t=a.ui.ddmanager.current;this._addActiveClass(),t&&this._trigger("activate",e,this.ui(t))},_deactivate:function(e){var t=a.ui.ddmanager.current;this._removeActiveClass(),t&&this._trigger("deactivate",e,this.ui(t))},_over:function(e){var t=a.ui.ddmanager.current;t&&(t.currentItem||t.element)[0]!==this.element[0]&&this.accept.call(this.element[0],t.currentItem||t.element)&&(this._addHoverClass(),this._trigger("over",e,this.ui(t)))},_out:function(e){var t=a.ui.ddmanager.current;t&&(t.currentItem||t.element)[0]!==this.element[0]&&this.accept.call(this.element[0],t.currentItem||t.element)&&(this._removeHoverClass(),this._trigger("out",e,this.ui(t)))},_drop:function(t,e){var i=e||a.ui.ddmanager.current,s=!1;return!(!i||(i.currentItem||i.element)[0]===this.element[0])&&(this.element.find(":data(ui-droppable)").not(".ui-draggable-dragging").each(function(){var e=a(this).droppable("instance");if(e.options.greedy&&!e.options.disabled&&e.options.scope===i.options.scope&&e.accept.call(e.element[0],i.currentItem||i.element)&&a.ui.intersect(i,a.extend(e,{offset:e.element.offset()}),e.options.tolerance,t))return!(s=!0)}),!s&&(!!this.accept.call(this.element[0],i.currentItem||i.element)&&(this._removeActiveClass(),this._removeHoverClass(),this._trigger("drop",t,this.ui(i)),this.element)))},ui:function(e){return{draggable:e.currentItem||e.element,helper:e.helper,position:e.position,offset:e.positionAbs}},_addHoverClass:function(){this._addClass("ui-droppable-hover")},_removeHoverClass:function(){this._removeClass("ui-droppable-hover")},_addActiveClass:function(){this._addClass("ui-droppable-active")},_removeActiveClass:function(){this._removeClass("ui-droppable-active")}}),a.ui.intersect=function(e,t,i,s){if(!t.offset)return!1;var o=(e.positionAbs||e.position.absolute).left+e.margins.left,r=(e.positionAbs||e.position.absolute).top+e.margins.top,n=o+e.helperProportions.width,a=r+e.helperProportions.height,l=t.offset.left,p=t.offset.top,c=l+t.proportions().width,d=p+t.proportions().height;switch(i){case"fit":return l<=o&&n<=c&&p<=r&&a<=d;case"intersect":return l<o+e.helperProportions.width/2&&n-e.helperProportions.width/2<c&&p<r+e.helperProportions.height/2&&a-e.helperProportions.height/2<d;case"pointer":return h(s.pageY,p,t.proportions().height)&&h(s.pageX,l,t.proportions().width);case"touch":return(p<=r&&r<=d||p<=a&&a<=d||r<p&&d<a)&&(l<=o&&o<=c||l<=n&&n<=c||o<l&&c<n);default:return!1}},!(a.ui.ddmanager={current:null,droppables:{default:[]},prepareOffsets:function(e,t){var i,s,o=a.ui.ddmanager.droppables[e.options.scope]||[],r=t?t.type:null,n=(e.currentItem||e.element).find(":data(ui-droppable)").addBack();e:for(i=0;i<o.length;i++)if(!(o[i].options.disabled||e&&!o[i].accept.call(o[i].element[0],e.currentItem||e.element))){for(s=0;s<n.length;s++)if(n[s]===o[i].element[0]){o[i].proportions().height=0;continue e}o[i].visible="none"!==o[i].element.css("display"),o[i].visible&&("mousedown"===r&&o[i]._activate.call(o[i],t),o[i].offset=o[i].element.offset(),o[i].proportions({width:o[i].element[0].offsetWidth,height:o[i].element[0].offsetHeight}))}},drop:function(e,t){var i=!1;return a.each((a.ui.ddmanager.droppables[e.options.scope]||[]).slice(),function(){this.options&&(!this.options.disabled&&this.visible&&a.ui.intersect(e,this,this.options.tolerance,t)&&(i=this._drop.call(this,t)||i),!this.options.disabled&&this.visible&&this.accept.call(this.element[0],e.currentItem||e.element)&&(this.isout=!0,this.isover=!1,this._deactivate.call(this,t)))}),i},dragStart:function(e,t){e.element.parentsUntil("body").on("scroll.droppable",function(){e.options.refreshPositions||a.ui.ddmanager.prepareOffsets(e,t)})},drag:function(o,r){o.options.refreshPositions&&a.ui.ddmanager.prepareOffsets(o,r),a.each(a.ui.ddmanager.droppables[o.options.scope]||[],function(){var e,t,i,s;this.options.disabled||this.greedyChild||!this.visible||(s=!(s=a.ui.intersect(o,this,this.options.tolerance,r))&&this.isover?"isout":s&&!this.isover?"isover":null)&&(this.options.greedy&&(t=this.options.scope,(i=this.element.parents(":data(ui-droppable)").filter(function(){return a(this).droppable("instance").options.scope===t})).length&&((e=a(i[0]).droppable("instance")).greedyChild="isover"===s)),e&&"isover"===s&&(e.isover=!1,e.isout=!0,e._out.call(e,r)),this[s]=!0,this["isout"===s?"isover":"isout"]=!1,this["isover"===s?"_over":"_out"].call(this,r),e&&"isout"===s&&(e.isout=!1,e.isover=!0,e._over.call(e,r)))})},dragStop:function(e,t){e.element.parentsUntil("body").off("scroll.droppable"),e.options.refreshPositions||a.ui.ddmanager.prepareOffsets(e,t)}})!==a.uiBackCompat&&a.widget("ui.droppable",a.ui.droppable,{options:{hoverClass:!1,activeClass:!1},_addActiveClass:function(){this._super(),this.options.activeClass&&this.element.addClass(this.options.activeClass)},_removeActiveClass:function(){this._super(),this.options.activeClass&&this.element.removeClass(this.options.activeClass)},_addHoverClass:function(){this._super(),this.options.hoverClass&&this.element.addClass(this.options.hoverClass)},_removeHoverClass:function(){this._super(),this.options.hoverClass&&this.element.removeClass(this.options.hoverClass)}}),a.ui.droppable});;
/*!
 * jQuery UI Sortable 1.13.2
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
!function(t){"use strict";"function"==typeof define&&define.amd?define(["jquery","./mouse","../data","../ie","../scroll-parent","../version","../widget"],t):t(jQuery)}(function(u){"use strict";return u.widget("ui.sortable",u.ui.mouse,{version:"1.13.2",widgetEventPrefix:"sort",ready:!1,options:{appendTo:"parent",axis:!1,connectWith:!1,containment:!1,cursor:"auto",cursorAt:!1,dropOnEmpty:!0,forcePlaceholderSize:!1,forceHelperSize:!1,grid:!1,handle:!1,helper:"original",items:"> *",opacity:!1,placeholder:!1,revert:!1,scroll:!0,scrollSensitivity:20,scrollSpeed:20,scope:"default",tolerance:"intersect",zIndex:1e3,activate:null,beforeStop:null,change:null,deactivate:null,out:null,over:null,receive:null,remove:null,sort:null,start:null,stop:null,update:null},_isOverAxis:function(t,e,i){return e<=t&&t<e+i},_isFloating:function(t){return/left|right/.test(t.css("float"))||/inline|table-cell/.test(t.css("display"))},_create:function(){this.containerCache={},this._addClass("ui-sortable"),this.refresh(),this.offset=this.element.offset(),this._mouseInit(),this._setHandleClassName(),this.ready=!0},_setOption:function(t,e){this._super(t,e),"handle"===t&&this._setHandleClassName()},_setHandleClassName:function(){var t=this;this._removeClass(this.element.find(".ui-sortable-handle"),"ui-sortable-handle"),u.each(this.items,function(){t._addClass(this.instance.options.handle?this.item.find(this.instance.options.handle):this.item,"ui-sortable-handle")})},_destroy:function(){this._mouseDestroy();for(var t=this.items.length-1;0<=t;t--)this.items[t].item.removeData(this.widgetName+"-item");return this},_mouseCapture:function(t,e){var i=null,s=!1,o=this;return!this.reverting&&(!this.options.disabled&&"static"!==this.options.type&&(this._refreshItems(t),u(t.target).parents().each(function(){if(u.data(this,o.widgetName+"-item")===o)return i=u(this),!1}),!!(i=u.data(t.target,o.widgetName+"-item")===o?u(t.target):i)&&(!(this.options.handle&&!e&&(u(this.options.handle,i).find("*").addBack().each(function(){this===t.target&&(s=!0)}),!s))&&(this.currentItem=i,this._removeCurrentsFromItems(),!0))))},_mouseStart:function(t,e,i){var s,o,r=this.options;if((this.currentContainer=this).refreshPositions(),this.appendTo=u("parent"!==r.appendTo?r.appendTo:this.currentItem.parent()),this.helper=this._createHelper(t),this._cacheHelperProportions(),this._cacheMargins(),this.offset=this.currentItem.offset(),this.offset={top:this.offset.top-this.margins.top,left:this.offset.left-this.margins.left},u.extend(this.offset,{click:{left:t.pageX-this.offset.left,top:t.pageY-this.offset.top},relative:this._getRelativeOffset()}),this.helper.css("position","absolute"),this.cssPosition=this.helper.css("position"),r.cursorAt&&this._adjustOffsetFromHelper(r.cursorAt),this.domPosition={prev:this.currentItem.prev()[0],parent:this.currentItem.parent()[0]},this.helper[0]!==this.currentItem[0]&&this.currentItem.hide(),this._createPlaceholder(),this.scrollParent=this.placeholder.scrollParent(),u.extend(this.offset,{parent:this._getParentOffset()}),r.containment&&this._setContainment(),r.cursor&&"auto"!==r.cursor&&(o=this.document.find("body"),this.storedCursor=o.css("cursor"),o.css("cursor",r.cursor),this.storedStylesheet=u("<style>*{ cursor: "+r.cursor+" !important; }</style>").appendTo(o)),r.zIndex&&(this.helper.css("zIndex")&&(this._storedZIndex=this.helper.css("zIndex")),this.helper.css("zIndex",r.zIndex)),r.opacity&&(this.helper.css("opacity")&&(this._storedOpacity=this.helper.css("opacity")),this.helper.css("opacity",r.opacity)),this.scrollParent[0]!==this.document[0]&&"HTML"!==this.scrollParent[0].tagName&&(this.overflowOffset=this.scrollParent.offset()),this._trigger("start",t,this._uiHash()),this._preserveHelperProportions||this._cacheHelperProportions(),!i)for(s=this.containers.length-1;0<=s;s--)this.containers[s]._trigger("activate",t,this._uiHash(this));return u.ui.ddmanager&&(u.ui.ddmanager.current=this),u.ui.ddmanager&&!r.dropBehaviour&&u.ui.ddmanager.prepareOffsets(this,t),this.dragging=!0,this._addClass(this.helper,"ui-sortable-helper"),this.helper.parent().is(this.appendTo)||(this.helper.detach().appendTo(this.appendTo),this.offset.parent=this._getParentOffset()),this.position=this.originalPosition=this._generatePosition(t),this.originalPageX=t.pageX,this.originalPageY=t.pageY,this.lastPositionAbs=this.positionAbs=this._convertPositionTo("absolute"),this._mouseDrag(t),!0},_scroll:function(t){var e=this.options,i=!1;return this.scrollParent[0]!==this.document[0]&&"HTML"!==this.scrollParent[0].tagName?(this.overflowOffset.top+this.scrollParent[0].offsetHeight-t.pageY<e.scrollSensitivity?this.scrollParent[0].scrollTop=i=this.scrollParent[0].scrollTop+e.scrollSpeed:t.pageY-this.overflowOffset.top<e.scrollSensitivity&&(this.scrollParent[0].scrollTop=i=this.scrollParent[0].scrollTop-e.scrollSpeed),this.overflowOffset.left+this.scrollParent[0].offsetWidth-t.pageX<e.scrollSensitivity?this.scrollParent[0].scrollLeft=i=this.scrollParent[0].scrollLeft+e.scrollSpeed:t.pageX-this.overflowOffset.left<e.scrollSensitivity&&(this.scrollParent[0].scrollLeft=i=this.scrollParent[0].scrollLeft-e.scrollSpeed)):(t.pageY-this.document.scrollTop()<e.scrollSensitivity?i=this.document.scrollTop(this.document.scrollTop()-e.scrollSpeed):this.window.height()-(t.pageY-this.document.scrollTop())<e.scrollSensitivity&&(i=this.document.scrollTop(this.document.scrollTop()+e.scrollSpeed)),t.pageX-this.document.scrollLeft()<e.scrollSensitivity?i=this.document.scrollLeft(this.document.scrollLeft()-e.scrollSpeed):this.window.width()-(t.pageX-this.document.scrollLeft())<e.scrollSensitivity&&(i=this.document.scrollLeft(this.document.scrollLeft()+e.scrollSpeed))),i},_mouseDrag:function(t){var e,i,s,o,r=this.options;for(this.position=this._generatePosition(t),this.positionAbs=this._convertPositionTo("absolute"),this.options.axis&&"y"===this.options.axis||(this.helper[0].style.left=this.position.left+"px"),this.options.axis&&"x"===this.options.axis||(this.helper[0].style.top=this.position.top+"px"),r.scroll&&!1!==this._scroll(t)&&(this._refreshItemPositions(!0),u.ui.ddmanager&&!r.dropBehaviour&&u.ui.ddmanager.prepareOffsets(this,t)),this.dragDirection={vertical:this._getDragVerticalDirection(),horizontal:this._getDragHorizontalDirection()},e=this.items.length-1;0<=e;e--)if(s=(i=this.items[e]).item[0],(o=this._intersectsWithPointer(i))&&i.instance===this.currentContainer&&!(s===this.currentItem[0]||this.placeholder[1===o?"next":"prev"]()[0]===s||u.contains(this.placeholder[0],s)||"semi-dynamic"===this.options.type&&u.contains(this.element[0],s))){if(this.direction=1===o?"down":"up","pointer"!==this.options.tolerance&&!this._intersectsWithSides(i))break;this._rearrange(t,i),this._trigger("change",t,this._uiHash());break}return this._contactContainers(t),u.ui.ddmanager&&u.ui.ddmanager.drag(this,t),this._trigger("sort",t,this._uiHash()),this.lastPositionAbs=this.positionAbs,!1},_mouseStop:function(t,e){var i,s,o,r;if(t)return u.ui.ddmanager&&!this.options.dropBehaviour&&u.ui.ddmanager.drop(this,t),this.options.revert?(s=(i=this).placeholder.offset(),r={},(o=this.options.axis)&&"x"!==o||(r.left=s.left-this.offset.parent.left-this.margins.left+(this.offsetParent[0]===this.document[0].body?0:this.offsetParent[0].scrollLeft)),o&&"y"!==o||(r.top=s.top-this.offset.parent.top-this.margins.top+(this.offsetParent[0]===this.document[0].body?0:this.offsetParent[0].scrollTop)),this.reverting=!0,u(this.helper).animate(r,parseInt(this.options.revert,10)||500,function(){i._clear(t)})):this._clear(t,e),!1},cancel:function(){if(this.dragging){this._mouseUp(new u.Event("mouseup",{target:null})),"original"===this.options.helper?(this.currentItem.css(this._storedCSS),this._removeClass(this.currentItem,"ui-sortable-helper")):this.currentItem.show();for(var t=this.containers.length-1;0<=t;t--)this.containers[t]._trigger("deactivate",null,this._uiHash(this)),this.containers[t].containerCache.over&&(this.containers[t]._trigger("out",null,this._uiHash(this)),this.containers[t].containerCache.over=0)}return this.placeholder&&(this.placeholder[0].parentNode&&this.placeholder[0].parentNode.removeChild(this.placeholder[0]),"original"!==this.options.helper&&this.helper&&this.helper[0].parentNode&&this.helper.remove(),u.extend(this,{helper:null,dragging:!1,reverting:!1,_noFinalSort:null}),this.domPosition.prev?u(this.domPosition.prev).after(this.currentItem):u(this.domPosition.parent).prepend(this.currentItem)),this},serialize:function(e){var t=this._getItemsAsjQuery(e&&e.connected),i=[];return e=e||{},u(t).each(function(){var t=(u(e.item||this).attr(e.attribute||"id")||"").match(e.expression||/(.+)[\-=_](.+)/);t&&i.push((e.key||t[1]+"[]")+"="+(e.key&&e.expression?t[1]:t[2]))}),!i.length&&e.key&&i.push(e.key+"="),i.join("&")},toArray:function(t){var e=this._getItemsAsjQuery(t&&t.connected),i=[];return t=t||{},e.each(function(){i.push(u(t.item||this).attr(t.attribute||"id")||"")}),i},_intersectsWith:function(t){var e=this.positionAbs.left,i=e+this.helperProportions.width,s=this.positionAbs.top,o=s+this.helperProportions.height,r=t.left,n=r+t.width,h=t.top,a=h+t.height,l=this.offset.click.top,c=this.offset.click.left,l="x"===this.options.axis||h<s+l&&s+l<a,c="y"===this.options.axis||r<e+c&&e+c<n;return"pointer"===this.options.tolerance||this.options.forcePointerForContainers||"pointer"!==this.options.tolerance&&this.helperProportions[this.floating?"width":"height"]>t[this.floating?"width":"height"]?l&&c:r<e+this.helperProportions.width/2&&i-this.helperProportions.width/2<n&&h<s+this.helperProportions.height/2&&o-this.helperProportions.height/2<a},_intersectsWithPointer:function(t){var e="x"===this.options.axis||this._isOverAxis(this.positionAbs.top+this.offset.click.top,t.top,t.height),t="y"===this.options.axis||this._isOverAxis(this.positionAbs.left+this.offset.click.left,t.left,t.width);return!(!e||!t)&&(e=this.dragDirection.vertical,t=this.dragDirection.horizontal,this.floating?"right"===t||"down"===e?2:1:e&&("down"===e?2:1))},_intersectsWithSides:function(t){var e=this._isOverAxis(this.positionAbs.top+this.offset.click.top,t.top+t.height/2,t.height),t=this._isOverAxis(this.positionAbs.left+this.offset.click.left,t.left+t.width/2,t.width),i=this.dragDirection.vertical,s=this.dragDirection.horizontal;return this.floating&&s?"right"===s&&t||"left"===s&&!t:i&&("down"===i&&e||"up"===i&&!e)},_getDragVerticalDirection:function(){var t=this.positionAbs.top-this.lastPositionAbs.top;return 0!=t&&(0<t?"down":"up")},_getDragHorizontalDirection:function(){var t=this.positionAbs.left-this.lastPositionAbs.left;return 0!=t&&(0<t?"right":"left")},refresh:function(t){return this._refreshItems(t),this._setHandleClassName(),this.refreshPositions(),this},_connectWith:function(){var t=this.options;return t.connectWith.constructor===String?[t.connectWith]:t.connectWith},_getItemsAsjQuery:function(t){var e,i,s,o,r=[],n=[],h=this._connectWith();if(h&&t)for(e=h.length-1;0<=e;e--)for(i=(s=u(h[e],this.document[0])).length-1;0<=i;i--)(o=u.data(s[i],this.widgetFullName))&&o!==this&&!o.options.disabled&&n.push(["function"==typeof o.options.items?o.options.items.call(o.element):u(o.options.items,o.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"),o]);function a(){r.push(this)}for(n.push(["function"==typeof this.options.items?this.options.items.call(this.element,null,{options:this.options,item:this.currentItem}):u(this.options.items,this.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"),this]),e=n.length-1;0<=e;e--)n[e][0].each(a);return u(r)},_removeCurrentsFromItems:function(){var i=this.currentItem.find(":data("+this.widgetName+"-item)");this.items=u.grep(this.items,function(t){for(var e=0;e<i.length;e++)if(i[e]===t.item[0])return!1;return!0})},_refreshItems:function(t){this.items=[],this.containers=[this];var e,i,s,o,r,n,h,a,l=this.items,c=[["function"==typeof this.options.items?this.options.items.call(this.element[0],t,{item:this.currentItem}):u(this.options.items,this.element),this]],p=this._connectWith();if(p&&this.ready)for(e=p.length-1;0<=e;e--)for(i=(s=u(p[e],this.document[0])).length-1;0<=i;i--)(o=u.data(s[i],this.widgetFullName))&&o!==this&&!o.options.disabled&&(c.push(["function"==typeof o.options.items?o.options.items.call(o.element[0],t,{item:this.currentItem}):u(o.options.items,o.element),o]),this.containers.push(o));for(e=c.length-1;0<=e;e--)for(r=c[e][1],a=(n=c[e][i=0]).length;i<a;i++)(h=u(n[i])).data(this.widgetName+"-item",r),l.push({item:h,instance:r,width:0,height:0,left:0,top:0})},_refreshItemPositions:function(t){for(var e,i,s=this.items.length-1;0<=s;s--)e=this.items[s],this.currentContainer&&e.instance!==this.currentContainer&&e.item[0]!==this.currentItem[0]||(i=this.options.toleranceElement?u(this.options.toleranceElement,e.item):e.item,t||(e.width=i.outerWidth(),e.height=i.outerHeight()),i=i.offset(),e.left=i.left,e.top=i.top)},refreshPositions:function(t){var e,i;if(this.floating=!!this.items.length&&("x"===this.options.axis||this._isFloating(this.items[0].item)),this.offsetParent&&this.helper&&(this.offset.parent=this._getParentOffset()),this._refreshItemPositions(t),this.options.custom&&this.options.custom.refreshContainers)this.options.custom.refreshContainers.call(this);else for(e=this.containers.length-1;0<=e;e--)i=this.containers[e].element.offset(),this.containers[e].containerCache.left=i.left,this.containers[e].containerCache.top=i.top,this.containers[e].containerCache.width=this.containers[e].element.outerWidth(),this.containers[e].containerCache.height=this.containers[e].element.outerHeight();return this},_createPlaceholder:function(i){var s,o,r=(i=i||this).options;r.placeholder&&r.placeholder.constructor!==String||(s=r.placeholder,o=i.currentItem[0].nodeName.toLowerCase(),r.placeholder={element:function(){var t=u("<"+o+">",i.document[0]);return i._addClass(t,"ui-sortable-placeholder",s||i.currentItem[0].className)._removeClass(t,"ui-sortable-helper"),"tbody"===o?i._createTrPlaceholder(i.currentItem.find("tr").eq(0),u("<tr>",i.document[0]).appendTo(t)):"tr"===o?i._createTrPlaceholder(i.currentItem,t):"img"===o&&t.attr("src",i.currentItem.attr("src")),s||t.css("visibility","hidden"),t},update:function(t,e){s&&!r.forcePlaceholderSize||(e.height()&&(!r.forcePlaceholderSize||"tbody"!==o&&"tr"!==o)||e.height(i.currentItem.innerHeight()-parseInt(i.currentItem.css("paddingTop")||0,10)-parseInt(i.currentItem.css("paddingBottom")||0,10)),e.width()||e.width(i.currentItem.innerWidth()-parseInt(i.currentItem.css("paddingLeft")||0,10)-parseInt(i.currentItem.css("paddingRight")||0,10)))}}),i.placeholder=u(r.placeholder.element.call(i.element,i.currentItem)),i.currentItem.after(i.placeholder),r.placeholder.update(i,i.placeholder)},_createTrPlaceholder:function(t,e){var i=this;t.children().each(function(){u("<td>&#160;</td>",i.document[0]).attr("colspan",u(this).attr("colspan")||1).appendTo(e)})},_contactContainers:function(t){for(var e,i,s,o,r,n,h,a,l,c=null,p=null,f=this.containers.length-1;0<=f;f--)u.contains(this.currentItem[0],this.containers[f].element[0])||(this._intersectsWith(this.containers[f].containerCache)?c&&u.contains(this.containers[f].element[0],c.element[0])||(c=this.containers[f],p=f):this.containers[f].containerCache.over&&(this.containers[f]._trigger("out",t,this._uiHash(this)),this.containers[f].containerCache.over=0));if(c)if(1===this.containers.length)this.containers[p].containerCache.over||(this.containers[p]._trigger("over",t,this._uiHash(this)),this.containers[p].containerCache.over=1);else{for(i=1e4,s=null,o=(a=c.floating||this._isFloating(this.currentItem))?"left":"top",r=a?"width":"height",l=a?"pageX":"pageY",e=this.items.length-1;0<=e;e--)u.contains(this.containers[p].element[0],this.items[e].item[0])&&this.items[e].item[0]!==this.currentItem[0]&&(n=this.items[e].item.offset()[o],h=!1,t[l]-n>this.items[e][r]/2&&(h=!0),Math.abs(t[l]-n)<i&&(i=Math.abs(t[l]-n),s=this.items[e],this.direction=h?"up":"down"));(s||this.options.dropOnEmpty)&&(this.currentContainer===this.containers[p]?this.currentContainer.containerCache.over||(this.containers[p]._trigger("over",t,this._uiHash()),this.currentContainer.containerCache.over=1):(s?this._rearrange(t,s,null,!0):this._rearrange(t,null,this.containers[p].element,!0),this._trigger("change",t,this._uiHash()),this.containers[p]._trigger("change",t,this._uiHash(this)),this.currentContainer=this.containers[p],this.options.placeholder.update(this.currentContainer,this.placeholder),this.scrollParent=this.placeholder.scrollParent(),this.scrollParent[0]!==this.document[0]&&"HTML"!==this.scrollParent[0].tagName&&(this.overflowOffset=this.scrollParent.offset()),this.containers[p]._trigger("over",t,this._uiHash(this)),this.containers[p].containerCache.over=1))}},_createHelper:function(t){var e=this.options,t="function"==typeof e.helper?u(e.helper.apply(this.element[0],[t,this.currentItem])):"clone"===e.helper?this.currentItem.clone():this.currentItem;return t.parents("body").length||this.appendTo[0].appendChild(t[0]),t[0]===this.currentItem[0]&&(this._storedCSS={width:this.currentItem[0].style.width,height:this.currentItem[0].style.height,position:this.currentItem.css("position"),top:this.currentItem.css("top"),left:this.currentItem.css("left")}),t[0].style.width&&!e.forceHelperSize||t.width(this.currentItem.width()),t[0].style.height&&!e.forceHelperSize||t.height(this.currentItem.height()),t},_adjustOffsetFromHelper:function(t){"string"==typeof t&&(t=t.split(" ")),"left"in(t=Array.isArray(t)?{left:+t[0],top:+t[1]||0}:t)&&(this.offset.click.left=t.left+this.margins.left),"right"in t&&(this.offset.click.left=this.helperProportions.width-t.right+this.margins.left),"top"in t&&(this.offset.click.top=t.top+this.margins.top),"bottom"in t&&(this.offset.click.top=this.helperProportions.height-t.bottom+this.margins.top)},_getParentOffset:function(){this.offsetParent=this.helper.offsetParent();var t=this.offsetParent.offset();return"absolute"===this.cssPosition&&this.scrollParent[0]!==this.document[0]&&u.contains(this.scrollParent[0],this.offsetParent[0])&&(t.left+=this.scrollParent.scrollLeft(),t.top+=this.scrollParent.scrollTop()),{top:(t=this.offsetParent[0]===this.document[0].body||this.offsetParent[0].tagName&&"html"===this.offsetParent[0].tagName.toLowerCase()&&u.ui.ie?{top:0,left:0}:t).top+(parseInt(this.offsetParent.css("borderTopWidth"),10)||0),left:t.left+(parseInt(this.offsetParent.css("borderLeftWidth"),10)||0)}},_getRelativeOffset:function(){var t;return"relative"===this.cssPosition?{top:(t=this.currentItem.position()).top-(parseInt(this.helper.css("top"),10)||0)+this.scrollParent.scrollTop(),left:t.left-(parseInt(this.helper.css("left"),10)||0)+this.scrollParent.scrollLeft()}:{top:0,left:0}},_cacheMargins:function(){this.margins={left:parseInt(this.currentItem.css("marginLeft"),10)||0,top:parseInt(this.currentItem.css("marginTop"),10)||0}},_cacheHelperProportions:function(){this.helperProportions={width:this.helper.outerWidth(),height:this.helper.outerHeight()}},_setContainment:function(){var t,e,i=this.options;"parent"===i.containment&&(i.containment=this.helper[0].parentNode),"document"!==i.containment&&"window"!==i.containment||(this.containment=[0-this.offset.relative.left-this.offset.parent.left,0-this.offset.relative.top-this.offset.parent.top,"document"===i.containment?this.document.width():this.window.width()-this.helperProportions.width-this.margins.left,("document"===i.containment?this.document.height()||document.body.parentNode.scrollHeight:this.window.height()||this.document[0].body.parentNode.scrollHeight)-this.helperProportions.height-this.margins.top]),/^(document|window|parent)$/.test(i.containment)||(t=u(i.containment)[0],i=u(i.containment).offset(),e="hidden"!==u(t).css("overflow"),this.containment=[i.left+(parseInt(u(t).css("borderLeftWidth"),10)||0)+(parseInt(u(t).css("paddingLeft"),10)||0)-this.margins.left,i.top+(parseInt(u(t).css("borderTopWidth"),10)||0)+(parseInt(u(t).css("paddingTop"),10)||0)-this.margins.top,i.left+(e?Math.max(t.scrollWidth,t.offsetWidth):t.offsetWidth)-(parseInt(u(t).css("borderLeftWidth"),10)||0)-(parseInt(u(t).css("paddingRight"),10)||0)-this.helperProportions.width-this.margins.left,i.top+(e?Math.max(t.scrollHeight,t.offsetHeight):t.offsetHeight)-(parseInt(u(t).css("borderTopWidth"),10)||0)-(parseInt(u(t).css("paddingBottom"),10)||0)-this.helperProportions.height-this.margins.top])},_convertPositionTo:function(t,e){e=e||this.position;var t="absolute"===t?1:-1,i="absolute"!==this.cssPosition||this.scrollParent[0]!==this.document[0]&&u.contains(this.scrollParent[0],this.offsetParent[0])?this.scrollParent:this.offsetParent,s=/(html|body)/i.test(i[0].tagName);return{top:e.top+this.offset.relative.top*t+this.offset.parent.top*t-("fixed"===this.cssPosition?-this.scrollParent.scrollTop():s?0:i.scrollTop())*t,left:e.left+this.offset.relative.left*t+this.offset.parent.left*t-("fixed"===this.cssPosition?-this.scrollParent.scrollLeft():s?0:i.scrollLeft())*t}},_generatePosition:function(t){var e=this.options,i=t.pageX,s=t.pageY,o="absolute"!==this.cssPosition||this.scrollParent[0]!==this.document[0]&&u.contains(this.scrollParent[0],this.offsetParent[0])?this.scrollParent:this.offsetParent,r=/(html|body)/i.test(o[0].tagName);return"relative"!==this.cssPosition||this.scrollParent[0]!==this.document[0]&&this.scrollParent[0]!==this.offsetParent[0]||(this.offset.relative=this._getRelativeOffset()),this.originalPosition&&(this.containment&&(t.pageX-this.offset.click.left<this.containment[0]&&(i=this.containment[0]+this.offset.click.left),t.pageY-this.offset.click.top<this.containment[1]&&(s=this.containment[1]+this.offset.click.top),t.pageX-this.offset.click.left>this.containment[2]&&(i=this.containment[2]+this.offset.click.left),t.pageY-this.offset.click.top>this.containment[3]&&(s=this.containment[3]+this.offset.click.top)),e.grid&&(t=this.originalPageY+Math.round((s-this.originalPageY)/e.grid[1])*e.grid[1],s=!this.containment||t-this.offset.click.top>=this.containment[1]&&t-this.offset.click.top<=this.containment[3]?t:t-this.offset.click.top>=this.containment[1]?t-e.grid[1]:t+e.grid[1],t=this.originalPageX+Math.round((i-this.originalPageX)/e.grid[0])*e.grid[0],i=!this.containment||t-this.offset.click.left>=this.containment[0]&&t-this.offset.click.left<=this.containment[2]?t:t-this.offset.click.left>=this.containment[0]?t-e.grid[0]:t+e.grid[0])),{top:s-this.offset.click.top-this.offset.relative.top-this.offset.parent.top+("fixed"===this.cssPosition?-this.scrollParent.scrollTop():r?0:o.scrollTop()),left:i-this.offset.click.left-this.offset.relative.left-this.offset.parent.left+("fixed"===this.cssPosition?-this.scrollParent.scrollLeft():r?0:o.scrollLeft())}},_rearrange:function(t,e,i,s){i?i[0].appendChild(this.placeholder[0]):e.item[0].parentNode.insertBefore(this.placeholder[0],"down"===this.direction?e.item[0]:e.item[0].nextSibling),this.counter=this.counter?++this.counter:1;var o=this.counter;this._delay(function(){o===this.counter&&this.refreshPositions(!s)})},_clear:function(t,e){this.reverting=!1;var i,s=[];if(!this._noFinalSort&&this.currentItem.parent().length&&this.placeholder.before(this.currentItem),this._noFinalSort=null,this.helper[0]===this.currentItem[0]){for(i in this._storedCSS)"auto"!==this._storedCSS[i]&&"static"!==this._storedCSS[i]||(this._storedCSS[i]="");this.currentItem.css(this._storedCSS),this._removeClass(this.currentItem,"ui-sortable-helper")}else this.currentItem.show();function o(e,i,s){return function(t){s._trigger(e,t,i._uiHash(i))}}for(this.fromOutside&&!e&&s.push(function(t){this._trigger("receive",t,this._uiHash(this.fromOutside))}),!this.fromOutside&&this.domPosition.prev===this.currentItem.prev().not(".ui-sortable-helper")[0]&&this.domPosition.parent===this.currentItem.parent()[0]||e||s.push(function(t){this._trigger("update",t,this._uiHash())}),this===this.currentContainer||e||(s.push(function(t){this._trigger("remove",t,this._uiHash())}),s.push(function(e){return function(t){e._trigger("receive",t,this._uiHash(this))}}.call(this,this.currentContainer)),s.push(function(e){return function(t){e._trigger("update",t,this._uiHash(this))}}.call(this,this.currentContainer))),i=this.containers.length-1;0<=i;i--)e||s.push(o("deactivate",this,this.containers[i])),this.containers[i].containerCache.over&&(s.push(o("out",this,this.containers[i])),this.containers[i].containerCache.over=0);if(this.storedCursor&&(this.document.find("body").css("cursor",this.storedCursor),this.storedStylesheet.remove()),this._storedOpacity&&this.helper.css("opacity",this._storedOpacity),this._storedZIndex&&this.helper.css("zIndex","auto"===this._storedZIndex?"":this._storedZIndex),this.dragging=!1,e||this._trigger("beforeStop",t,this._uiHash()),this.placeholder[0].parentNode.removeChild(this.placeholder[0]),this.cancelHelperRemoval||(this.helper[0]!==this.currentItem[0]&&this.helper.remove(),this.helper=null),!e){for(i=0;i<s.length;i++)s[i].call(this,t);this._trigger("stop",t,this._uiHash())}return this.fromOutside=!1,!this.cancelHelperRemoval},_trigger:function(){!1===u.Widget.prototype._trigger.apply(this,arguments)&&this.cancel()},_uiHash:function(t){var e=t||this;return{helper:e.helper,placeholder:e.placeholder||u([]),position:e.position,originalPosition:e.originalPosition,offset:e.positionAbs,item:e.currentItem,sender:t?t.element:null}}})});;
(function ($) {

"use strict";

/**
 * Process elements with the .dropbutton class on page load.
 */
Backdrop.behaviors.dropButton = {
  attach: function (context, settings) {
    var $dropbuttons = $(context).find('.dropbutton-wrapper').once('dropbutton');
    if ($dropbuttons.length) {
      // Adds the delegated handler that will toggle dropdowns on click.
      var $body = $('body').once('dropbutton-click');
      if ($body.length) {
        $body.on('click', '.dropbutton-toggle', dropbuttonClickHandler);
      }
      // Initialize all buttons.
      for (var i = 0, il = $dropbuttons.length; i < il; i++) {
        DropButton.dropbuttons.push(new DropButton($dropbuttons[i], settings.dropbutton));
      }
    }
  }
};

/**
 * Set the min-width of dropbuttons (and their parent) to handle all of the
 * link widths.
 */
Backdrop.behaviors.dropButtonWidths = {
  attach: function(context, settings) {
    function adjustDropButtonWidths() {
      var $dropbutton = $(this);

      // Get widest item width.
      var widestItem = 0, $item;
      $dropbutton.find('li:hidden').each(function() {
        // Use a clone element to avoid altering element CSS properties.
        $item = $(this).clone().insertAfter($(this)).show().css('visibility', 'hidden');
        widestItem = Math.max($item.outerWidth(), widestItem);
        $item.remove();
      });

      // Set dropbutton list (<ul>) as wide as its widest child.
      $dropbutton.find('.dropbutton').css('min-width', widestItem + 'px');

      // Set parent element min-width, like <td class="operations"> to prevent
      // overflow issue (See #2806).
      $dropbutton.parent().css('min-width', $dropbutton.find('.dropbutton-widget').outerWidth() + 'px');
    }

    // Get the font size and family for an element in a dropbutton if one
    // exists. If none exist, then we don't need to do any processing.
    var $link = $('.dropbutton li a').first();
    if ($link.length == 0) {
      return;
    }
    var fontSize = $link.css('font-size');
    var fontList = $link.css('font-family').split(', ');
    var actualFont = fontList.find(font => document.fonts.check(fontSize + ` ${font}`));

    // Calculate dropbutton elements width once the font is loaded.
    Backdrop.isFontLoaded(actualFont, function() {
      $(context).find('.dropbutton-wrapper').once('dropbutton-width', adjustDropButtonWidths);
    });

  }
};

/**
 * Delegated callback for opening and closing dropbutton secondary actions.
 */
function dropbuttonClickHandler (e) {
  e.preventDefault();
  $(e.target).closest('.dropbutton-wrapper').toggleClass('open');
}

/**
 * A DropButton presents an HTML list as a button with a primary action.
 *
 * All secondary actions beyond the first in the list are presented in a
 * dropdown list accessible through a toggle arrow associated with the button.
 *
 * @param DOMElement dropbutton
 *   A DOM element.
 *
 * @param {Object} settings
 *   A list of options including:
 *    - {String} title: The text inside the toggle link element. This text is
 *      hidden from visual UAs.
 */
function DropButton (dropbutton, settings) {
  // Merge defaults with settings.
  var options = $.extend({'title': Backdrop.t('List additional actions')}, settings);
  var $dropbutton = $(dropbutton);
  this.$dropbutton = $dropbutton;
  this.$list = $dropbutton.find('.dropbutton');
  // Find actions and mark them.
  this.$actions = this.$list.find('li').addClass('dropbutton-action');

  // Add the special dropdown only if there are hidden actions.
  if (this.$actions.length > 1) {
    // Identify the first element of the collection.
    var $primary = this.$actions.slice(0,1);
    // Identify the secondary actions.
    var $secondary = this.$actions.slice(1);
    $secondary.addClass('secondary-action');
    // Add toggle link.
    $primary.after(Backdrop.theme('dropbuttonToggle', options));
    // Bind mouse events.
    this.$dropbutton
      .addClass('dropbutton-multiple')
      .on({
        /**
         * Adds a timeout to close the dropdown on mouseleave.
         */
        'mouseleave.dropbutton': $.proxy(this.hoverOut, this),
        /**
         * Clears timeout when mouseout of the dropdown.
         */
        'mouseenter.dropbutton': $.proxy(this.hoverIn, this),
        /**
         * Similar to mouseleave/mouseenter, but for keyboard navigation.
         */
        'focusout.dropbutton': $.proxy(this.focusOut, this),
        'focusin.dropbutton': $.proxy(this.focusIn, this)
      });
  }
  else {
    this.$dropbutton.addClass('dropbutton-single');
  }
}

/**
 * Extend the DropButton constructor.
 */
$.extend(DropButton, {
  /**
   * Store all processed DropButtons.
   *
   * @type {Array}
   */
  dropbuttons: []
});

/**
 * Extend the DropButton prototype.
 */
$.extend(DropButton.prototype, {
  /**
   * Toggle the dropbutton open and closed.
   *
   * @param {Boolean} show
   *   (optional) Force the dropbutton to open by passing true or to close by
   *   passing false.
   */
  toggle: function (show) {
    var isBool = typeof show === 'boolean';
    show = isBool ? show : !this.$dropbutton.hasClass('open');
    this.$dropbutton.toggleClass('open', show);
  },

  hoverIn: function () {
    // Clear any previous timer we were using.
    if (this.timerID) {
      window.clearTimeout(this.timerID);
    }
  },

  hoverOut: function () {
    // Wait half a second before closing.
    this.timerID = window.setTimeout($.proxy(this, 'close'), 500);
  },

  open: function () {
    this.toggle(true);
  },

  close: function () {
    this.toggle(false);
  },

  focusOut: function(e) {
    this.hoverOut.call(this, e);
  },

  focusIn: function(e) {
    this.hoverIn.call(this, e);
  }
});

/**
 * A toggle is an interactive element often bound to a click handler.
 *
 * @param {Object} options
 *   - {String} title: (optional) The HTML anchor title attribute and
 *     text for the inner span element.
 *
 * @return {String}
 *   A string representing a DOM fragment.
 */
Backdrop.theme.prototype.dropbuttonToggle = function (options) {
  return '<li class="dropbutton-toggle"><button type="button" role="button"><span class="dropbutton-arrow"><span class="visually-hidden">' + options.title + '</span></span></button></li>';
};

// Expose constructor in the public space.
Backdrop.DropButton = DropButton;

})(jQuery);
;
(function ($, window) {

/**
 * Provides Ajax page updating via jQuery $.ajax (Asynchronous JavaScript and XML).
 *
 * Ajax is a method of making a request via JavaScript while viewing an HTML
 * page. The request returns an array of commands encoded in JSON, which is
 * then executed to make any changes that are necessary to the page.
 *
 * Backdrop uses this file to enhance form elements with #ajax['path'] and
 * #ajax['wrapper'] properties. If set, this file will automatically be included
 * to provide Ajax capabilities.
 */

Backdrop.ajax = Backdrop.ajax || {};

Backdrop.settings.urlIsAjaxTrusted = Backdrop.settings.urlIsAjaxTrusted || {};

/**
 * Attaches the Ajax behavior to each Ajax form element.
 */
Backdrop.behaviors.AJAX = {
  attach: function (context, settings) {

     function loadAjaxBehaviour(base) {
      if (!$('#' + base + '.ajax-processed').length) {
        var element_settings = settings.ajax[base];

        if (typeof element_settings.selector == 'undefined') {
          element_settings.selector = '#' + base;
        }
        $(element_settings.selector).each(function () {
          element_settings.element = this;
          Backdrop.ajax[base] = new Backdrop.ajax(base, this, element_settings);
        });

        $('#' + base).addClass('ajax-processed');
      }
    }

    // Load all Ajax behaviors specified in the settings.
    for (var base in settings.ajax) {
      if (settings.ajax.hasOwnProperty(base)) {
        loadAjaxBehaviour(base);
      }
    }

    // Bind Ajax behaviors to all items showing the class.
    $('.use-ajax:not(.ajax-processed)').addClass('ajax-processed').each(function () {
      var element_settings = {};
      // Clicked links look better with the throbber than the progress bar.
      element_settings.progress = { 'type': 'throbber' };

      // For anchor tags, these will go to the target of the anchor rather
      // than the usual location.
      if ($(this).attr('href')) {
        element_settings.url = $(this).attr('href');
        element_settings.event = 'click';
      }
      // Allow any AJAX link to set the HTTP "Accept" header.
      element_settings.accepts = $(this).data('accepts');

      // Special handling if the data-dialog attribute is TRUE.
      if ($(this).data('dialog')) {
        element_settings.dialog = $(this).data('dialog-options') || {};
        element_settings.accepts = 'application/vnd.backdrop-dialog';
      }

      var base = $(this).attr('id');
      Backdrop.ajax[base] = new Backdrop.ajax(base, this, element_settings);
    });

    // This class means to submit the form to the action using Ajax.
    $('.use-ajax-submit:not(.ajax-processed)').addClass('ajax-processed').each(function () {
      var element_settings = {};

      // Ajax submits specified in this manner automatically submit to the
      // normal form action.
      element_settings.url = $(this.form).attr('action');
      // Form submit button clicks need to tell the form what was clicked so
      // it gets passed in the POST request.
      element_settings.setClick = true;
      // Form buttons use the 'click' event rather than mousedown.
      element_settings.event = 'click';
      // Clicked form buttons look better with the throbber than the progress bar.
      element_settings.progress = { 'type': 'throbber' };

      var base = $(this).attr('id');
      Backdrop.ajax[base] = new Backdrop.ajax(base, this, element_settings);
    });
  }
};

/**
 * Ajax object.
 *
 * All Ajax objects on a page are accessible through the global Backdrop.ajax
 * object and are keyed by the submit button's ID. You can access them from
 * your module's JavaScript file to override properties or functions.
 *
 * For example, if your Ajax enabled button has the ID 'edit-submit', you can
 * redefine the function that is called to insert the new content like this
 * (inside a Backdrop.behaviors attach block):
 * @code
 *    Backdrop.behaviors.myCustomAJAXStuff = {
 *      attach: function (context, settings) {
 *        Backdrop.ajax['edit-submit'].commands.insert = function (ajax, response, status) {
 *          new_content = $(response.data);
 *          $('#my-wrapper').append(new_content);
 *          alert('New content was appended to #my-wrapper');
 *        }
 *      }
 *    };
 * @endcode
 *
 * @param string base
 *   The unique identifier for this AJAX object. Usually this is the ID of the
 *   HTML element receiving the newly generated HTML content.
 * @param DOMElement element
 *   The HTML DOM element that triggers the AJAX behavior. Usually this is an
 *   anchor tag or submit button, but it may be any type of DOM element.
 * @param object element_settings
 *   An object containing configuration for the AJAX behavior.
 */
Backdrop.ajax = function (base, element, element_settings) {
  var defaults = {
    event: 'mousedown',
    keypress: true,
    selector: '#' + base,
    effect: 'none',
    speed: 'none',
    method: 'replaceWith',
    progress: {
      type: 'throbber',
      message: Backdrop.t('Please wait...'),
      object: null,
      element: null
    },
    submit: {
      'js': true
    },
    currentRequests: []
  };

  $.extend(this, defaults, element_settings);

  // @todo Remove this after refactoring the PHP code to:
  //   - Call this 'selector'.
  //   - Include the '#' for ID-based selectors.
  //   - Support non-ID-based selectors.
  if (this.wrapper) {
    this.wrapper = '#' + this.wrapper;
  }

  // Ensure element is a DOM element (and not a jQuery object).
  if (element instanceof jQuery) {
    element = element.get(0);
  }

  this.element = element;
  this.element_settings = element_settings;

  // If there isn't a form, jQuery.ajax() will be used instead, allowing us to
  // bind Ajax to links as well.
  if (this.element && this.element.form) {
    this.form = $(this.element.form);
  }

  // If no Ajax callback URL was given, use the link href or form action.
  if (!this.url) {
    if ($(element).is('a')) {
      this.url = $(element).attr('href');
    }
    else if (element.form) {
      this.url = this.form.attr('action');
    }
  }

  // Replacing 'nojs' with 'ajax' in the URL allows for an easy method to let
  // the server detect when it needs to degrade gracefully.
  // There are five scenarios to check for:
  // 1. /nojs/
  // 2. /nojs$ - The end of a URL string.
  // 3. /nojs? - Followed by a query (e.g. path/nojs?destination=foobar).
  // 4. /nojs# - Followed by a fragment (e.g.: path/nojs#myfragment).
  this.url = this.url.replace(/\/nojs(\/|$|\?|#)/g, '/ajax$1');

  // If the 'nojs' version of the URL is trusted, also trust the 'ajax' version.
  if (Backdrop.settings.urlIsAjaxTrusted[element_settings.url]) {
    Backdrop.settings.urlIsAjaxTrusted[this.url] = true;
  }

  // Set the options for the ajaxSubmit function.
  // The 'this' variable will not persist inside of the options object.
  var currentAjaxRequestNumber = 0;
  var ajax = this;
  ajax.options = {
    url: Backdrop.sanitizeAjaxUrl(ajax.url),
    data: ajax.submit,
    beforeSerialize: function (element_settings, options) {
      return ajax.beforeSerialize(element_settings, options);
    },
    beforeSubmit: function (form_values, element_settings, options) {
      return ajax.beforeSubmit(form_values, element_settings, options);
    },
    beforeSend: function (jqXHR, options) {
      jqXHR.ajaxRequestNumber = ++currentAjaxRequestNumber;
      return ajax.beforeSend(jqXHR, options);
    },
    uploadProgress: function (event, position, total, percentComplete) {
      ajax.uploadProgress(event, position, total, percentComplete);
    },
    success: function (response, status, jqXHR) {
      // Skip success if this request has been superseded by a later request.
      if (jqXHR.ajaxRequestNumber < currentAjaxRequestNumber) {
        return false;
      }
      // Sanity check for browser support (object expected).
      // When using iFrame uploads, responses must be returned as a string.
      if (typeof response == 'string') {
        response = $.parseJSON(response);

        // Prior to invoking the response's commands, verify that they can be
        // trusted by checking for a response header. See
        // ajax_set_verification_header() for details.
        // - Empty responses are harmless so can bypass verification. This avoids
        //   an alert message for server-generated no-op responses that skip Ajax
        //   rendering.
        // - Ajax objects with trusted URLs (e.g., ones defined server-side via
        //   #ajax) can bypass header verification. This is especially useful for
        //   Ajax with multipart forms. Because IFRAME transport is used, the
        //   response headers cannot be accessed for verification.
        if (response !== null && !Backdrop.settings.urlIsAjaxTrusted[ajax.url]) {
          if (jqXHR.getResponseHeader('X-Backdrop-Ajax-Token') !== '1') {
            var customMessage = Backdrop.t("The response failed verification so will not be processed.");
            return ajax.error(jqXHR, ajax.url, customMessage);
          }
        }

      }
      return ajax.success(response, status, jqXHR);
    },
    complete: function (jqXHR, status) {
      ajax.cleanUp(jqXHR);
      if (status == 'error' || status == 'parsererror') {
        return ajax.error(jqXHR, ajax.url);
      }
    },
    dataType: 'json',
    jsonp: false,
    accepts: {
      json: element_settings.accepts || 'application/vnd.backdrop-ajax'
    },
    type: 'POST'
  };
  if (element_settings.dialog) {
    ajax.options.data.dialogOptions = element_settings.dialog;
  }

  // Bind the ajaxSubmit function to the element event.
  $(ajax.element).on(element_settings.event, function (event) {
    if (!Backdrop.settings.urlIsAjaxTrusted[ajax.url] && !Backdrop.urlIsLocal(ajax.url)) {
      throw new Error(Backdrop.t('The callback URL is not local and not trusted: !url', {'!url': ajax.url}));
    }
    return ajax.eventResponse(this, event);
  });

  // If necessary, enable keyboard submission so that Ajax behaviors
  // can be triggered through keyboard input as well as e.g. a mousedown
  // action.
  if (element_settings.keypress) {
    $(ajax.element).on('keypress', function (event) {
      return ajax.keypressResponse(this, event);
    });
  }

  // If necessary, prevent the browser default action of an additional event.
  // For example, prevent the browser default action of a click, even if the
  // AJAX behavior binds to mousedown.
  if (element_settings.prevent) {
    $(ajax.element).on(element_settings.prevent, false);
  }
};

/**
 * Handle a key press.
 *
 * The Ajax object will, if instructed, bind to a key press response. This
 * will test to see if the key press is valid to trigger this event and
 * if it is, trigger it for us and prevent other keypresses from triggering.
 * In this case we're handling RETURN and SPACEBAR keypresses (event codes 13
 * and 32. RETURN is often used to submit a form when in a textfield, and
 * SPACE is often used to activate an element without submitting.
 */
Backdrop.ajax.prototype.keypressResponse = function (element, event) {
  // Create a synonym for this to reduce code confusion.
  var ajax = this;

  // Detect enter key and space bar and allow the standard response for them,
  // except for form elements of type 'text' and 'textarea', where the
  // spacebar activation causes inappropriate activation if #ajax['keypress'] is
  // TRUE. On a text-type widget a space should always be a space.
  if (event.which == 13 || (event.which == 32 && element.type != 'text' && element.type != 'textarea')) {
    $(ajax.element_settings.element).trigger(ajax.element_settings.event);
    return false;
  }
};

/**
 * Handle an event that triggers an Ajax response.
 *
 * When an event that triggers an Ajax response happens, this method will
 * perform the actual Ajax call. It is bound to the event using
 * bind() in the constructor, and it uses the options specified on the
 * ajax object.
 */
Backdrop.ajax.prototype.eventResponse = function (element, event) {
  // Create a synonym for this to reduce code confusion.
  var ajax = this;

  try {
    if (ajax.form) {
      // If setClick is set, we must set this to ensure that the button's
      // value is passed.
      if (ajax.setClick) {
        // Mark the clicked button. 'form.clk' is a special variable for
        // ajaxSubmit that tells the system which element got clicked to
        // trigger the submit. Without it there would be no 'op' or
        // equivalent.
        element.form.clk = element;
      }

      ajax.form.ajaxSubmit(ajax.options);
    }
    else {
      ajax.beforeSerialize(ajax.element, ajax.options);
      $.ajax(ajax.options);
    }
  }
  catch (e) {
    $.error("An error occurred while attempting to process " + ajax.options.url + ": " + e.message);
  }

  // For radio/checkbox, allow the default event. On IE, this means letting
  // it actually check the box.
  if (typeof element.type != 'undefined' && (element.type == 'checkbox' || element.type == 'radio')) {
    return true;
  }
  else {
    return false;
  }

};

/**
 * Handler for the form serialization.
 *
 * Runs before the beforeSend() handler (see below), and unlike that one, runs
 * before field data is collected.
 */
Backdrop.ajax.prototype.beforeSerialize = function (element, options) {
  // Allow detaching behaviors to update field values before collecting them.
  // This is only needed when field values are added to the POST data, so only
  // when there is a form such that this.form.ajaxSubmit() is used instead of
  // $.ajax(). When there is no form and $.ajax() is used, beforeSerialize()
  // isn't called, but don't rely on that: explicitly check this.form.
  if (this.form) {
    var settings = this.settings || Backdrop.settings;
    Backdrop.detachBehaviors(this.form, settings, 'serialize');

    // Ensure Backdrop isn't vulnerable to the bugs disclosed in the unmerged
    // pull request: https://github.com/jquery-form/form/pull/586.
    // - Under normal circumstances, the first if statement doesn't evaluate
    //   to true, because options.dataType is initialized in the Drupal.ajax()
    //   constructor.
    // - Under normal circumstances, the second if statement doesn't evaluate
    //   to true, because $.parseJSON is initialized by jQuery.
    if (!options.dataType && options.target) {
      delete options.target;
    }
    if (!$.parseJSON) {
      $.parseJSON = JSON.parse;
    }
  }

  // Prevent duplicate HTML ids in the returned markup.
  // @see backdrop_html_id()
  options.data['ajax_html_ids[]'] = [];
  $('[id]').each(function () {
    options.data['ajax_html_ids[]'].push(this.id);
  });

  // Allow Backdrop to return new JavaScript and CSS files to load without
  // returning the ones already loaded.
  // @see ajax_base_page_theme()
  // @see backdrop_get_css()
  // @see backdrop_get_js()
  var pageState = Backdrop.settings.ajaxPageState;
  options.data['ajax_page_state[theme]'] = pageState.theme;
  options.data['ajax_page_state[theme_token]'] = pageState.theme_token;
  for (var cssFile in pageState.css) {
    if (pageState.css.hasOwnProperty(cssFile)) {
      options.data['ajax_page_state[css][' + cssFile + ']'] = 1;
    }
  }
  for (var jsFile in pageState.js) {
    if (pageState.js.hasOwnProperty(jsFile)) {
      options.data['ajax_page_state[js][' + jsFile + ']'] = 1;
    }
  }

  // Provide an error if the dialog options can't be parsed.
  if (this.options.data.dialogOptions && typeof this.options.data.dialogOptions !== 'object') {
    $.error(Backdrop.t('The data-dialog-options property on this link is not valid JSON.'));
  }
};

/**
 * Modify form values prior to form submission.
 */
Backdrop.ajax.prototype.beforeSubmit = function (form_values, element, options) {
  // This function is left empty to make it simple to override for modules
  // that wish to add functionality here.
};

/**
 * Prepare the Ajax request before it is sent.
 */
Backdrop.ajax.prototype.beforeSend = function (jqXHR, options) {
  // For forms without file inputs, the jQuery Form plugin serializes the form
  // values, and then calls jQuery's $.ajax() function, which invokes this
  // handler. In this circumstance, options.extraData is never used. For forms
  // with file inputs, the jQuery Form plugin uses the browser's normal form
  // submission mechanism, but captures the response in a hidden IFRAME. In this
  // circumstance, it calls this handler first, and then appends hidden fields
  // to the form to submit the values in options.extraData. There is no simple
  // way to know which submission mechanism will be used, so we add to extraData
  // regardless, and allow it to be ignored in the former case.
  if (this.form) {
    options.extraData = options.extraData || {};

    // Let the server know when the IFRAME submission mechanism is used. The
    // server can use this information to wrap the JSON response in a TEXTAREA,
    // as per http://jquery.malsup.com/form/#file-upload.
    options.extraData.ajax_iframe_upload = '1';

    // The triggering element is about to be disabled (see below), but if it
    // contains a value (e.g., a checkbox, textfield, select, etc.), ensure that
    // value is included in the submission. As per above, submissions that use
    // $.ajax() are already serialized prior to the element being disabled, so
    // this is only needed for IFRAME submissions.
    var v = $.fieldValue(this.element);
    if (v !== null) {
      options.extraData[this.element.name] = Backdrop.checkPlain(v);
    }
  }

  // Disable the element that received the change to prevent user interface
  // interaction while the Ajax request is in progress.
  if (this.disable !== false) {
    $(this.element).addClass('progress-disabled').prop('disabled', true);
  }

  // Insert progressbar or throbber.
  if (this.progress.type == 'bar') {
    var progressBar = new Backdrop.progressBar('ajax-progress-' + this.element.id, $.noop, this.progress.method, $.noop);
    if (this.progress.message) {
      progressBar.setProgress(-1, this.progress.message);
    }
    if (this.progress.url) {
      progressBar.startMonitoring(this.progress.url, this.progress.interval || 1500);
    }
    this.progress.element = $(progressBar.element).addClass('ajax-progress ajax-progress-bar');
    this.progress.object = progressBar;
    $(this.element).after(this.progress.element);
  }
  else if (this.progress.type == 'throbber') {
    this.progress.element = $('<div class="ajax-progress ajax-progress-throbber"><div class="throbber">&nbsp;</div></div>');
    if (this.progress.message) {
      $('.throbber', this.progress.element).after('<div class="message">' + this.progress.message + '</div>');
    }
    $(this.element).after(this.progress.element);
  }

  // Register the AJAX request so it can be cancelled if needed.
  this.currentRequests.push(jqXHR);
};

/**
 * Handler for the updateProgress form event.
 */
Backdrop.ajax.prototype.uploadProgress = function (jqXHR, position, total, percentComplete) {
  if (this.progress.object) {
    var message = Backdrop.t('Uploading... (@current of @total)', {
      '@current': Backdrop.formatSize(position),
      '@total': Backdrop.formatSize(total)
    });
    this.progress.object.setProgress(percentComplete, message);
  }
};

/**
 * Handler for the form redirection completion.
 */
Backdrop.ajax.prototype.success = function (response, status, jqXHR) {
  // Remove the throbber and progress elements.
  this.cleanUp(jqXHR);

  // Process the response.
  Backdrop.freezeHeight();
  for (var i in response) {
    if (response.hasOwnProperty(i) && response[i].command && this.commands[response[i].command]) {
       this.commands[response[i].command](this, response[i], status);
    }
  }

  // Reattach behaviors, if they were detached in beforeSerialize(). The
  // attachBehaviors() called on the new content from processing the response
  // commands is not sufficient, because behaviors from the entire form need
  // to be reattached.
  if (this.form) {
    var settings = this.settings || Backdrop.settings;
    Backdrop.attachBehaviors(this.form, settings);
  }

  Backdrop.unfreezeHeight();

  // Remove any response-specific settings so they don't get used on the next
  // call by mistake.
  this.settings = null;
};

/**
 * Clean up after an AJAX response, success or failure.
 */
Backdrop.ajax.prototype.cleanUp = function (jqXHR) {
  // Remove the AJAX request from the current list.
  var index = this.currentRequests.indexOf(jqXHR);
  if (index > -1) {
    this.currentRequests.splice(index, 1);
  }

  // Remove the progress element (bar or throbber).
  if (this.progress.element) {
    $(this.progress.element).remove();
  }
  // Stop monitoring of the progress bar if present (bar only).
  if (this.progress.object) {
    this.progress.object.stopMonitoring();
    this.progress.object = null;
  }

  // Reactivate the triggering element.
  if (this.disable !== false) {
    $(this.element).removeClass('progress-disabled').prop('disabled', false);
  }
};

/**
 * Build an effect object which tells us how to apply the effect when adding new HTML.
 */
Backdrop.ajax.prototype.getEffect = function (response) {
  var type = response.effect || this.effect;
  var speed = response.speed || this.speed;

  var effect = {};
  if (type == 'none') {
    effect.showEffect = 'show';
    effect.hideEffect = 'hide';
    effect.showSpeed = '';
  }
  else if (type == 'fade') {
    effect.showEffect = 'fadeIn';
    effect.hideEffect = 'fadeOut';
    effect.showSpeed = speed;
  }
  else {
    effect.showEffect = type + 'Toggle';
    effect.hideEffect = type + 'Toggle';
    effect.showSpeed = speed;
  }

  return effect;
};

/**
 * Handler for the form redirection error.
 */
Backdrop.ajax.prototype.error = function (jqXHR, uri) {
  this.cleanUp(jqXHR);

  // Reattach behaviors, if they were detached in beforeSerialize().
  if (this.form) {
    var settings = this.settings || Backdrop.settings;
    Backdrop.attachBehaviors(this.form, settings);
  }
};

/**
 * Provide a series of commands that the server can request the client perform.
 */
Backdrop.ajax.prototype.commands = {
  /**
   * Command to insert new content into the DOM.
   */
  insert: function (ajax, response, status) {
    // Get information from the response. If it is not there, default to
    // our presets.
    var wrapper = response.selector ? $(response.selector) : $(ajax.wrapper);
    var method = response.method || ajax.method;
    var effect = ajax.getEffect(response);
    var settings;

    // We don't know what response.data contains: it might be a string of text
    // without HTML, so don't rely on jQuery correctly interpreting
    // $(response.data) as new HTML rather than a CSS selector. Also, if
    // response.data contains top-level text nodes, they get lost with either
    // $(response.data) or $('<div></div>').replaceWith(response.data).
    var new_content_wrapped = $('<div></div>').html(response.data.replace(/^\s+|\s+$/g, ''));
    var new_content = new_content_wrapped.children();

    // For legacy reasons, the effects processing code assumes that new_content
    // consists of a single top-level element. Also, it has not been
    // sufficiently tested whether attachBehaviors() can be successfully called
    // with a context object that includes top-level text nodes. However, to
    // give developers full control of the HTML appearing in the page, and to
    // enable Ajax content to be inserted in places where DIV elements are not
    // allowed (e.g., within TABLE, TR, and SPAN parents), we check if the new
    // content satisfies the requirement of a single top-level element, and
    // only use the container DIV created above when it doesn't. For more
    // information, please see http://drupal.org/node/736066.
    if (new_content.length != 1 || new_content.get(0).nodeType != 1) {
      new_content = new_content_wrapped;
    }

    // If removing content from the wrapper, detach behaviors first.
    switch (method) {
      case 'html':
      case 'replaceWith':
      case 'replaceAll':
      case 'empty':
      case 'remove':
        settings = response.settings || ajax.settings || Backdrop.settings;
        Backdrop.detachBehaviors(wrapper, settings);
    }

    // Add the new content to the page.
    wrapper[method](new_content);

    // Immediately hide the new content if we're using any effects.
    if (effect.showEffect != 'show') {
      new_content.hide();
    }

    // Determine which effect to use and what content will receive the
    // effect, then show the new content.
    if ($('.ajax-new-content', new_content).length > 0) {
      $('.ajax-new-content', new_content).hide();
      new_content.show();
      $('.ajax-new-content', new_content)[effect.showEffect](effect.showSpeed);
    }
    else if (effect.showEffect != 'show') {
      new_content[effect.showEffect](effect.showSpeed);
    }

    // Attach all JavaScript behaviors to the new content, if it was
    // successfully added to the page and the elements not part of a larger form
    // (in which case they'll be processed all at once in
    // Drupal.ajax.prototype.success). The body parent check allows
    // #ajax['wrapper'] to be optional.
    var alreadyAttached = ajax.form && ajax.form.has(new_content).length > 0;
    if (!alreadyAttached && new_content.parents('body').length > 0) {
      // Apply any settings from the returned JSON if available.
      settings = response.settings || ajax.settings || Backdrop.settings;
      Backdrop.attachBehaviors(new_content, settings);
    }
  },

  /**
   * Command to remove a chunk from the page.
   */
  remove: function (ajax, response, status) {
    var settings = response.settings || ajax.settings || Backdrop.settings;
    Backdrop.detachBehaviors($(response.selector), settings);
    $(response.selector).remove();
  },

  /**
   * Command to mark a chunk changed.
   */
  changed: function (ajax, response, status) {
    if (!$(response.selector).hasClass('ajax-changed')) {
      $(response.selector).addClass('ajax-changed');
      if (response.asterisk) {
        $(response.selector).find(response.asterisk).append(' <abbr class="ajax-changed" title="' + Backdrop.t('Changed') + '">*</abbr> ');
      }
    }
  },

  /**
   * Command to provide an alert.
   */
  alert: function (ajax, response, status) {
    window.alert(response.text, response.title);
  },

  /**
   * Command to set the window.location, redirecting the browser.
   */
  redirect: function (ajax, response, status) {
    window.location = response.url;
  },

  /**
   * Command to provide the jQuery css() function.
   */
  css: function (ajax, response, status) {
    $(response.selector).css(response.argument);
  },

  /**
   * Command to set the settings that will be used for other commands in this response.
   */
  settings: function (ajax, response, status) {
    if (response.merge) {
      $.extend(true, Backdrop.settings, response.settings);
    }
    else {
      ajax.settings = response.settings;
    }
  },

  /**
   * Command to attach data using jQuery's data API.
   */
  data: function (ajax, response, status) {
    $(response.selector).data(response.name, response.value);
  },

  /**
   * Command to apply a jQuery method.
   */
  invoke: function (ajax, response, status) {
    var $element = $(response.selector);
    $element[response.method].apply($element, response.args);
  },

  /**
   * Command to restripe a table.
   */
  restripe: function (ajax, response, status) {
    // :even and :odd are reversed because jQuery counts from 0 and
    // we count from 1, so we're out of sync.
    // Match immediate children of the parent element to allow nesting.
    $('> tbody > tr:visible, > tr:visible', $(response.selector))
      .removeClass('odd even')
      .filter(':even').addClass('odd').end()
      .filter(':odd').addClass('even');
  },

  /**
   * Command to add css.
   *
   * Uses the proprietary addImport method if available as browsers which
   * support that method ignore @import statements in dynamically added
   * stylesheets.
   */
  addCss: function (ajax, response, status) {
    // Add the styles in the normal way.
    $('head').prepend(response.data);
    // Add imports in the styles using the addImport method if available.
    var match, importMatch = /^@import url\("(.*)"\);$/igm;
    if (document.styleSheets[0].addImport && importMatch.test(response.data)) {
      importMatch.lastIndex = 0;
      while (match = importMatch.exec(response.data)) {
        document.styleSheets[0].addImport(match[1]);
      }
    }
  },

  /**
   * Command to update a form's build ID.
   */
  updateBuildId: function(ajax, response, status) {
    $('input[name="form_build_id"][value="' + response['old'] + '"]').val(response['new']);
  }
};

})(jQuery, this);
;
/**
 * @file
 * Attaches behaviors for the Contextual module.
 */

(function ($) {

Backdrop.contextualLinks = Backdrop.contextualLinks || {};

/**
 * Attaches outline behavior for regions associated with contextual links.
 */
Backdrop.behaviors.contextualLinks = {
  attach: function (context) {
    $('.contextual-links-wrapper', context).once('contextual-links', function () {
      var $wrapper = $(this);
      var $region = $wrapper.closest('.contextual-links-region');
      var $links = $wrapper.find('ul.contextual-links');
      var $trigger = $('<a class="contextual-links-trigger" href="#" />').text(Backdrop.t('Configure')).on('click',
        function () {
          $links.stop(true, true).slideToggle(100);
          $wrapper.toggleClass('contextual-links-active');
          return false;
        }
      );

      // Attach hover behavior to trigger and ul.contextual-links.
      $trigger.add($links).on('mouseenter', function () {
        $region.addClass('contextual-links-region-active');
      });
      $trigger.add($links).on('mouseleave', function () {
        $region.removeClass('contextual-links-region-active');
      });

      // Hide the contextual links when user clicks a link or rolls out of the
      // .contextual-links-region.
      $region.on('mouseleave click', Backdrop.contextualLinks.mouseleave);
      $region.on('mouseenter', function() {
        $trigger.addClass('contextual-links-trigger-active');
      });
      $region.on('mouseleave', function() {
        $trigger.removeClass('contextual-links-trigger-active');
      });

      // Prepend the trigger.
      $wrapper.prepend($trigger);
    });

    /**
     * Adjusts trigger positions in contextual links to avoid overlaps.
     */
    function adjustContextualLinks() {
      // Get all wrappers anywhere on the page and some info about each.
      var allWrappers = [];
      $('.contextual-links-wrapper', context).each(function() {
        allWrappers.push({
          '$wrapper': $(this),
          'regionOffsetBottom': $(this).parent().offset().top + $(this).parent().height(),
          'hShift': 0,
          'vShift': 0
        });
      });

      // Reset margins on all wrappers.
      allWrappers.forEach(function(info) {
        info.$wrapper.css('margin', '0');
      });

      // Recalculate margins to avoid collisions.
      var dir = $('html').attr('dir');
      const hSize = 28; // width of trigger wrapper
      const vSize = 19; // height of trigger wrapper
      var n = allWrappers.length;
      for (let i = 0; i < n; i++) {
        var follower = allWrappers[i];
        // Compare follower against all of its predecessors in the list (any of
        // which may have already been adjusted).
        for (let j = 0; j < i; j++) {
          var leader = allWrappers[j];
          // Adjust the position of follower if necessary to avoid collision
          // with leader.
          var leaderOffset = leader.$wrapper.offset();
          var followerOffset = follower.$wrapper.offset();
          // Check vertical overlap.
          if (!(followerOffset.top >= leaderOffset.top && followerOffset.top < leaderOffset.top + vSize)) {
            continue;
          }
          if (dir == 'ltr') {
            // Check horizontal overlap.
            if (followerOffset.left >= leaderOffset.left - hSize && followerOffset.left < leaderOffset.left + hSize) {
              // We have a collision; shift the follower down if there's room,
              // otherwise left.
              if (followerOffset.top + 2 * vSize <= follower.regionOffsetBottom) {
                // Shift down
                follower.vShift += vSize;
                follower.$wrapper.css('margin-top', follower.vShift);
              }
              else {
                // Shift left and start a new column.
                follower.vShift = 0;
                follower.hShift += hSize;
                follower.$wrapper.css('margin-top', follower.vShift);
                follower.$wrapper.css('margin-right', follower.hShift);
              }
            }
          }
          else { // rtl
            // Check horizontal overlap.
            if (followerOffset.left > leaderOffset.left - hSize && followerOffset.left <= leaderOffset.left + hSize) {
              // We have a collision; shift the follower down if there's room,
              // otherwise right.
              if (followerOffset.top + 2 * vSize <= follower.regionOffsetBottom) {
                // Shift down
                follower.vShift += vSize;
                follower.$wrapper.css('margin-top', follower.vShift);
              }
              else {
                // Shift right and start a new column.
                follower.vShift = 0;
                follower.hShift += hSize;
                follower.$wrapper.css('margin-top', follower.vShift);
                follower.$wrapper.css('margin-left', follower.hShift);
              }
            }
          }
        }
      }
    }
    $(document).ready(adjustContextualLinks);

    // Usually Backdrop.optimizedResize() would be used for a window resize
    // event, but this potentially expensive operation should be limited to
    // firing infrequently, so Backdrop.debounce() is used here instead.
    $(window).on('resize', Backdrop.debounce(adjustContextualLinks, 500));
  }
};

/**
 * Disables outline for the region contextual links are associated with.
 */
Backdrop.contextualLinks.mouseleave = function () {
  $(this)
    .find('.contextual-links-active').removeClass('contextual-links-active')
    .find('ul.contextual-links').hide();
};

})(jQuery);
;
(function ($) {

/**
 * Retrieves the summary for the first element.
 */
$.fn.backdropGetSummary = function () {
  var callback = this.data('summaryCallback');
  var returnValue = (this[0] && callback) ? callback(this[0]) : '';
  return typeof returnValue === 'string' ? returnValue.trim() : '';
};

/**
 * Sets the summary for all matched elements.
 *
 * @param callback
 *   Either a function that will be called each time the summary is
 *   retrieved or a string (which is returned each time).
 */
$.fn.backdropSetSummary = function (callback) {
  var self = this;

  // To facilitate things, the callback should always be a function. If it's
  // not, we wrap it into an anonymous function which just returns the value.
  if (typeof callback != 'function') {
    var val = callback;
    callback = function () { return val; };
  }

  return this
    .data('summaryCallback', callback)
    // To prevent duplicate events, the handlers are first removed and then
    // (re-)added.
    .off('formUpdated.summary')
    .on('formUpdated.summary', function () {
      self.trigger('summaryUpdated');
    })
    // The actual summaryUpdated handler doesn't fire when the callback is
    // changed, so we have to do this manually.
    .trigger('summaryUpdated');
};

/**
 * Sends a 'formUpdated' event each time a form element is modified.
 */
Backdrop.behaviors.formUpdated = {
  attach: function (context) {
    // These events are namespaced so that we can remove them later.
    var events = 'change.formUpdated click.formUpdated blur.formUpdated keyup.formUpdated';
    $(context)
      // Since context could be an input element itself, it's added back to
      // the jQuery object and filtered again.
      .find(':input').addBack().filter(':input')
      // To prevent duplicate events, the handlers are first removed and then
      // (re-)added.
      .off(events).on(events, function () {
        $(this).trigger('formUpdated');
      });
  }
};

/**
 * Prevents consecutive form submissions of identical form values.
 *
 * Repetitive form submissions that would submit the identical form values are
 * prevented, unless the form values are different from the previously
 * submitted values.
 *
 * This is a simplified re-implementation of a user-agent behavior that should
 * be natively supported by major web browsers, but at this time, only Firefox
 * has a built-in protection.
 *
 * A form value-based approach ensures that the constraint is triggered for
 * consecutive, identical form submissions only. Compared to that, a form
 * button-based approach would (1) rely on [visible] buttons to exist where
 * technically not required and (2) require more complex state management if
 * there are multiple buttons in a form.
 *
 * This implementation is based on form-level submit events only, and relies on
 * jQuery's serialize() method to determine submitted form values. As such, the
 * following limitations exist:
 *
 * - Event handlers on form buttons that preventDefault() do not receive a
 *   double-submit protection. That is deemed to be fine, since such button
 *   events typically trigger reversible client-side or server-side operations
 *   that are local to the context of a form only.
 * - Changed values in advanced form controls, such as file inputs, are not part
 *   of the form values being compared between consecutive form submits (due to
 *   limitations of jQuery.serialize()). That is deemed to be acceptable,
 *   because if the user forgot to attach a file, then the size of HTTP payload
 *   will most likely be small enough to be fully passed to the server endpoint
 *   within (milli)seconds. If a user mistakenly attached a wrong file and is
 *   technically versed enough to cancel the form submission (and HTTP payload)
 *   in order to attach a different file, then that edge-case is not supported
 *   here.
 *
 * Lastly, all forms submitted via HTTP GET are idempotent by definition of HTTP
 * standards, so excluded in this implementation.
 */
Backdrop.behaviors.formSingleSubmit = {
  attach: function () {
    function onFormSubmit (e) {
      // Prevent this from firing multiple times per request.
      e.stopImmediatePropagation();
      if (e.isDefaultPrevented()) {
        // Don't act on form submissions that have been prevented by other JS.
        return;
      }
      var $form = $(e.currentTarget);
      var formValues = $form.serialize();
      var previousValues = $form.attr('data-backdrop-form-submit-last');
      if (previousValues === formValues) {
        e.preventDefault();
      }
      else {
        $form.attr('data-backdrop-form-submit-last', formValues);
      }
    }

    $('body').once('form-single-submit')
      .on('submit.singleSubmit', 'form:not([method~="GET"])', onFormSubmit);

  }
};

/**
 * Prepopulate form fields with information from the visitor cookie.
 */
Backdrop.behaviors.fillUserInfoFromCookie = {
  attach: function (context, settings) {
    $('form.user-info-from-cookie').once('user-info-from-cookie', function () {
      var formContext = this;
      $.each(['name', 'mail', 'homepage'], function () {
        var $element = $('[name=' + this + ']', formContext);
        var cookie = $.cookie('Backdrop.visitor.' + this);
        if ($element.length && cookie) {
          $element.val(cookie);
        }
      });
    });
  }
};

})(jQuery);
;
