/*!
 * jQuery Form Plugin
 * version: 4.3.0
 * Requires jQuery v1.7.2 or later
 * Project repository: https://github.com/jquery-form/form

 * Copyright 2017 Kevin Morris
 * Copyright 2006 M. Alsup

 * Dual licensed under the LGPL-2.1+ or MIT licenses
 * https://github.com/jquery-form/form#license

 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 */
!function(r){"function"==typeof define&&define.amd?define(["jquery"],r):"object"==typeof module&&module.exports?module.exports=function(e,t){return void 0===t&&(t="undefined"!=typeof window?require("jquery"):require("jquery")(e)),r(t),t}:r(jQuery)}(function(q){"use strict";var m=/\r?\n/g,S={};S.fileapi=void 0!==q('<input type="file">').get(0).files,S.formdata=void 0!==window.FormData;var _=!!q.fn.prop;function o(e){var t=e.data;e.isDefaultPrevented()||(e.preventDefault(),q(e.target).closest("form").ajaxSubmit(t))}function i(e){var t=e.target,r=q(t);if(!r.is("[type=submit],[type=image]")){var a=r.closest("[type=submit]");if(0===a.length)return;t=a[0]}var n,o=t.form;"image"===(o.clk=t).type&&(void 0!==e.offsetX?(o.clk_x=e.offsetX,o.clk_y=e.offsetY):"function"==typeof q.fn.offset?(n=r.offset(),o.clk_x=e.pageX-n.left,o.clk_y=e.pageY-n.top):(o.clk_x=e.pageX-t.offsetLeft,o.clk_y=e.pageY-t.offsetTop)),setTimeout(function(){o.clk=o.clk_x=o.clk_y=null},100)}function N(){var e;q.fn.ajaxSubmit.debug&&(e="[jquery.form] "+Array.prototype.join.call(arguments,""),window.console&&window.console.log?window.console.log(e):window.opera&&window.opera.postError&&window.opera.postError(e))}q.fn.attr2=function(){if(!_)return this.attr.apply(this,arguments);var e=this.prop.apply(this,arguments);return e&&e.jquery||"string"==typeof e?e:this.attr.apply(this,arguments)},q.fn.ajaxSubmit=function(M,e,t,r){if(!this.length)return N("ajaxSubmit: skipping submit process - no element selected"),this;var O,a,n,o,X=this;"function"==typeof M?M={success:M}:"string"==typeof M||!1===M&&0<arguments.length?(M={url:M,data:e,dataType:t},"function"==typeof r&&(M.success=r)):void 0===M&&(M={}),O=M.method||M.type||this.attr2("method"),n=(n=(n="string"==typeof(a=M.url||this.attr2("action"))?q.trim(a):"")||window.location.href||"")&&(n.match(/^([^#]+)/)||[])[1],o=/(MSIE|Trident)/.test(navigator.userAgent||"")&&/^https/i.test(window.location.href||"")?"javascript:false":"about:blank",M=q.extend(!0,{url:n,success:q.ajaxSettings.success,type:O||q.ajaxSettings.type,iframeSrc:o},M);var i={};if(this.trigger("form-pre-serialize",[this,M,i]),i.veto)return N("ajaxSubmit: submit vetoed via form-pre-serialize trigger"),this;if(M.beforeSerialize&&!1===M.beforeSerialize(this,M))return N("ajaxSubmit: submit aborted via beforeSerialize callback"),this;var s=M.traditional;void 0===s&&(s=q.ajaxSettings.traditional);var u,c,C=[],l=this.formToArray(M.semantic,C,M.filtering);if(M.data&&(c=q.isFunction(M.data)?M.data(l):M.data,M.extraData=c,u=q.param(c,s)),M.beforeSubmit&&!1===M.beforeSubmit(l,this,M))return N("ajaxSubmit: submit aborted via beforeSubmit callback"),this;if(this.trigger("form-submit-validate",[l,this,M,i]),i.veto)return N("ajaxSubmit: submit vetoed via form-submit-validate trigger"),this;var f=q.param(l,s);u&&(f=f?f+"&"+u:u),"GET"===M.type.toUpperCase()?(M.url+=(0<=M.url.indexOf("?")?"&":"?")+f,M.data=null):M.data=f;var d,m,p,h=[];M.resetForm&&h.push(function(){X.resetForm()}),M.clearForm&&h.push(function(){X.clearForm(M.includeHidden)}),!M.dataType&&M.target?(d=M.success||function(){},h.push(function(e,t,r){var a=arguments,n=M.replaceTarget?"replaceWith":"html";q(M.target)[n](e).each(function(){d.apply(this,a)})})):M.success&&(q.isArray(M.success)?q.merge(h,M.success):h.push(M.success)),M.success=function(e,t,r){for(var a=M.context||this,n=0,o=h.length;n<o;n++)h[n].apply(a,[e,t,r||X,X])},M.error&&(m=M.error,M.error=function(e,t,r){var a=M.context||this;m.apply(a,[e,t,r,X])}),M.complete&&(p=M.complete,M.complete=function(e,t){var r=M.context||this;p.apply(r,[e,t,X])});var v=0<q("input[type=file]:enabled",this).filter(function(){return""!==q(this).val()}).length,g="multipart/form-data",x=X.attr("enctype")===g||X.attr("encoding")===g,y=S.fileapi&&S.formdata;N("fileAPI :"+y);var b,T=(v||x)&&!y;!1!==M.iframe&&(M.iframe||T)?M.closeKeepAlive?q.get(M.closeKeepAlive,function(){b=w(l)}):b=w(l):b=(v||x)&&y?function(e){for(var r=new FormData,t=0;t<e.length;t++)r.append(e[t].name,e[t].value);if(M.extraData){var a=function(e){var t,r,a=q.param(e,M.traditional).split("&"),n=a.length,o=[];for(t=0;t<n;t++)a[t]=a[t].replace(/\+/g," "),r=a[t].split("="),o.push([decodeURIComponent(r[0]),decodeURIComponent(r[1])]);return o}(M.extraData);for(t=0;t<a.length;t++)a[t]&&r.append(a[t][0],a[t][1])}M.data=null;var n=q.extend(!0,{},q.ajaxSettings,M,{contentType:!1,processData:!1,cache:!1,type:O||"POST"});M.uploadProgress&&(n.xhr=function(){var e=q.ajaxSettings.xhr();return e.upload&&e.upload.addEventListener("progress",function(e){var t=0,r=e.loaded||e.position,a=e.total;e.lengthComputable&&(t=Math.ceil(r/a*100)),M.uploadProgress(e,r,a,t)},!1),e});n.data=null;var o=n.beforeSend;return n.beforeSend=function(e,t){M.formData?t.data=M.formData:t.data=r,o&&o.call(this,e,t)},q.ajax(n)}(l):q.ajax(M),X.removeData("jqxhr").data("jqxhr",b);for(var j=0;j<C.length;j++)C[j]=null;return this.trigger("form-submit-notify",[this,M]),this;function w(e){var t,r,l,f,o,d,m,p,a,n,h,v,i=X[0],g=q.Deferred();if(g.abort=function(e){p.abort(e)},e)for(r=0;r<C.length;r++)t=q(C[r]),_?t.prop("disabled",!1):t.removeAttr("disabled");(l=q.extend(!0,{},q.ajaxSettings,M)).context=l.context||l,o="jqFormIO"+(new Date).getTime();var s=i.ownerDocument,u=X.closest("body");if(l.iframeTarget?(n=(d=q(l.iframeTarget,s)).attr2("name"))?o=n:d.attr2("name",o):(d=q('<iframe name="'+o+'" src="'+l.iframeSrc+'" />',s)).css({position:"absolute",top:"-1000px",left:"-1000px"}),m=d[0],p={aborted:0,responseText:null,responseXML:null,status:0,statusText:"n/a",getAllResponseHeaders:function(){},getResponseHeader:function(){},setRequestHeader:function(){},abort:function(e){var t="timeout"===e?"timeout":"aborted";N("aborting upload... "+t),this.aborted=1;try{m.contentWindow.document.execCommand&&m.contentWindow.document.execCommand("Stop")}catch(e){}d.attr("src",l.iframeSrc),p.error=t,l.error&&l.error.call(l.context,p,t,e),f&&q.event.trigger("ajaxError",[p,l,t]),l.complete&&l.complete.call(l.context,p,t)}},(f=l.global)&&0==q.active++&&q.event.trigger("ajaxStart"),f&&q.event.trigger("ajaxSend",[p,l]),l.beforeSend&&!1===l.beforeSend.call(l.context,p,l))return l.global&&q.active--,g.reject(),g;if(p.aborted)return g.reject(),g;(a=i.clk)&&(n=a.name)&&!a.disabled&&(l.extraData=l.extraData||{},l.extraData[n]=a.value,"image"===a.type&&(l.extraData[n+".x"]=i.clk_x,l.extraData[n+".y"]=i.clk_y));var x=1,y=2;function b(t){var r=null;try{t.contentWindow&&(r=t.contentWindow.document)}catch(e){N("cannot get iframe.contentWindow document: "+e)}if(r)return r;try{r=t.contentDocument?t.contentDocument:t.document}catch(e){N("cannot get iframe.contentDocument: "+e),r=t.document}return r}var c=q("meta[name=csrf-token]").attr("content"),T=q("meta[name=csrf-param]").attr("content");function j(){var e=X.attr2("target"),t=X.attr2("action"),r=X.attr("enctype")||X.attr("encoding")||"multipart/form-data";i.setAttribute("target",o),O&&!/post/i.test(O)||i.setAttribute("method","POST"),t!==l.url&&i.setAttribute("action",l.url),l.skipEncodingOverride||O&&!/post/i.test(O)||X.attr({encoding:"multipart/form-data",enctype:"multipart/form-data"}),l.timeout&&(v=setTimeout(function(){h=!0,A(x)},l.timeout));var a=[];try{if(l.extraData)for(var n in l.extraData)l.extraData.hasOwnProperty(n)&&(q.isPlainObject(l.extraData[n])&&l.extraData[n].hasOwnProperty("name")&&l.extraData[n].hasOwnProperty("value")?a.push(q('<input type="hidden" name="'+l.extraData[n].name+'">',s).val(l.extraData[n].value).appendTo(i)[0]):a.push(q('<input type="hidden" name="'+n+'">',s).val(l.extraData[n]).appendTo(i)[0]));l.iframeTarget||d.appendTo(u),m.attachEvent?m.attachEvent("onload",A):m.addEventListener("load",A,!1),setTimeout(function e(){try{var t=b(m).readyState;N("state = "+t),t&&"uninitialized"===t.toLowerCase()&&setTimeout(e,50)}catch(e){N("Server abort: ",e," (",e.name,")"),A(y),v&&clearTimeout(v),v=void 0}},15);try{i.submit()}catch(e){document.createElement("form").submit.apply(i)}}finally{i.setAttribute("action",t),i.setAttribute("enctype",r),e?i.setAttribute("target",e):X.removeAttr("target"),q(a).remove()}}T&&c&&(l.extraData=l.extraData||{},l.extraData[T]=c),l.forceSync?j():setTimeout(j,10);var w,S,k,D=50;function A(e){if(!p.aborted&&!k){if((S=b(m))||(N("cannot access response document"),e=y),e===x&&p)return p.abort("timeout"),void g.reject(p,"timeout");if(e===y&&p)return p.abort("server abort"),void g.reject(p,"error","server abort");if(S&&S.location.href!==l.iframeSrc||h){m.detachEvent?m.detachEvent("onload",A):m.removeEventListener("load",A,!1);var t,r="success";try{if(h)throw"timeout";var a="xml"===l.dataType||S.XMLDocument||q.isXMLDoc(S);if(N("isXml="+a),!a&&window.opera&&(null===S.body||!S.body.innerHTML)&&--D)return N("requeing onLoad callback, DOM not available"),void setTimeout(A,250);var n=S.body?S.body:S.documentElement;p.responseText=n?n.innerHTML:null,p.responseXML=S.XMLDocument?S.XMLDocument:S,a&&(l.dataType="xml"),p.getResponseHeader=function(e){return{"content-type":l.dataType}[e.toLowerCase()]},n&&(p.status=Number(n.getAttribute("status"))||p.status,p.statusText=n.getAttribute("statusText")||p.statusText);var o,i,s,u=(l.dataType||"").toLowerCase(),c=/(json|script|text)/.test(u);c||l.textarea?(o=S.getElementsByTagName("textarea")[0])?(p.responseText=o.value,p.status=Number(o.getAttribute("status"))||p.status,p.statusText=o.getAttribute("statusText")||p.statusText):c&&(i=S.getElementsByTagName("pre")[0],s=S.getElementsByTagName("body")[0],i?p.responseText=i.textContent?i.textContent:i.innerText:s&&(p.responseText=s.textContent?s.textContent:s.innerText)):"xml"===u&&!p.responseXML&&p.responseText&&(p.responseXML=F(p.responseText));try{w=E(p,u,l)}catch(e){r="parsererror",p.error=t=e||r}}catch(e){N("error caught: ",e),r="error",p.error=t=e||r}p.aborted&&(N("upload aborted"),r=null),p.status&&(r=200<=p.status&&p.status<300||304===p.status?"success":"error"),"success"===r?(l.success&&l.success.call(l.context,w,"success",p),g.resolve(p.responseText,"success",p),f&&q.event.trigger("ajaxSuccess",[p,l])):r&&(void 0===t&&(t=p.statusText),l.error&&l.error.call(l.context,p,r,t),g.reject(p,"error",t),f&&q.event.trigger("ajaxError",[p,l,t])),f&&q.event.trigger("ajaxComplete",[p,l]),f&&!--q.active&&q.event.trigger("ajaxStop"),l.complete&&l.complete.call(l.context,p,r),k=!0,l.timeout&&clearTimeout(v),setTimeout(function(){l.iframeTarget?d.attr("src",l.iframeSrc):d.remove(),p.responseXML=null},100)}}}var F=q.parseXML||function(e,t){return window.ActiveXObject?((t=new ActiveXObject("Microsoft.XMLDOM")).async="false",t.loadXML(e)):t=(new DOMParser).parseFromString(e,"text/xml"),t&&t.documentElement&&"parsererror"!==t.documentElement.nodeName?t:null},L=q.parseJSON||function(e){return window.eval("("+e+")")},E=function(e,t,r){var a=e.getResponseHeader("content-type")||"",n=("xml"===t||!t)&&0<=a.indexOf("xml"),o=n?e.responseXML:e.responseText;return n&&"parsererror"===o.documentElement.nodeName&&q.error&&q.error("parsererror"),r&&r.dataFilter&&(o=r.dataFilter(o,t)),"string"==typeof o&&(("json"===t||!t)&&0<=a.indexOf("json")?o=L(o):("script"===t||!t)&&0<=a.indexOf("javascript")&&q.globalEval(o)),o};return g}},q.fn.ajaxForm=function(e,t,r,a){if(("string"==typeof e||!1===e&&0<arguments.length)&&(e={url:e,data:t,dataType:r},"function"==typeof a&&(e.success=a)),(e=e||{}).delegation=e.delegation&&q.isFunction(q.fn.on),e.delegation||0!==this.length)return e.delegation?(q(document).off("submit.form-plugin",this.selector,o).off("click.form-plugin",this.selector,i).on("submit.form-plugin",this.selector,e,o).on("click.form-plugin",this.selector,e,i),this):(e.beforeFormUnbind&&e.beforeFormUnbind(this,e),this.ajaxFormUnbind().on("submit.form-plugin",e,o).on("click.form-plugin",e,i));var n={s:this.selector,c:this.context};return!q.isReady&&n.s?(N("DOM not ready, queuing ajaxForm"),q(function(){q(n.s,n.c).ajaxForm(e)})):N("terminating; zero elements found by selector"+(q.isReady?"":" (DOM not ready)")),this},q.fn.ajaxFormUnbind=function(){return this.off("submit.form-plugin click.form-plugin")},q.fn.formToArray=function(e,t,r){var a=[];if(0===this.length)return a;var n,o,i,s,u,c,l,f,d,m,p=this[0],h=this.attr("id"),v=(v=e||void 0===p.elements?p.getElementsByTagName("*"):p.elements)&&q.makeArray(v);if(h&&(e||/(Edge|Trident)\//.test(navigator.userAgent))&&(n=q(':input[form="'+h+'"]').get()).length&&(v=(v||[]).concat(n)),!v||!v.length)return a;for(q.isFunction(r)&&(v=q.map(v,r)),o=0,c=v.length;o<c;o++)if((m=(u=v[o]).name)&&!u.disabled)if(e&&p.clk&&"image"===u.type)p.clk===u&&(a.push({name:m,value:q(u).val(),type:u.type}),a.push({name:m+".x",value:p.clk_x},{name:m+".y",value:p.clk_y}));else if((s=q.fieldValue(u,!0))&&s.constructor===Array)for(t&&t.push(u),i=0,l=s.length;i<l;i++)a.push({name:m,value:s[i]});else if(S.fileapi&&"file"===u.type){t&&t.push(u);var g=u.files;if(g.length)for(i=0;i<g.length;i++)a.push({name:m,value:g[i],type:u.type});else a.push({name:m,value:"",type:u.type})}else null!=s&&(t&&t.push(u),a.push({name:m,value:s,type:u.type,required:u.required}));return e||!p.clk||(m=(d=(f=q(p.clk))[0]).name)&&!d.disabled&&"image"===d.type&&(a.push({name:m,value:f.val()}),a.push({name:m+".x",value:p.clk_x},{name:m+".y",value:p.clk_y})),a},q.fn.formSerialize=function(e){return q.param(this.formToArray(e))},q.fn.fieldSerialize=function(n){var o=[];return this.each(function(){var e=this.name;if(e){var t=q.fieldValue(this,n);if(t&&t.constructor===Array)for(var r=0,a=t.length;r<a;r++)o.push({name:e,value:t[r]});else null!=t&&o.push({name:this.name,value:t})}}),q.param(o)},q.fn.fieldValue=function(e){for(var t=[],r=0,a=this.length;r<a;r++){var n=this[r],o=q.fieldValue(n,e);null==o||o.constructor===Array&&!o.length||(o.constructor===Array?q.merge(t,o):t.push(o))}return t},q.fieldValue=function(e,t){var r=e.name,a=e.type,n=e.tagName.toLowerCase();if(void 0===t&&(t=!0),t&&(!r||e.disabled||"reset"===a||"button"===a||("checkbox"===a||"radio"===a)&&!e.checked||("submit"===a||"image"===a)&&e.form&&e.form.clk!==e||"select"===n&&-1===e.selectedIndex))return null;if("select"!==n)return q(e).val().replace(m,"\r\n");var o=e.selectedIndex;if(o<0)return null;for(var i=[],s=e.options,u="select-one"===a,c=u?o+1:s.length,l=u?o:0;l<c;l++){var f=s[l];if(f.selected&&!f.disabled){var d=(d=f.value)||(f.attributes&&f.attributes.value&&!f.attributes.value.specified?f.text:f.value);if(u)return d;i.push(d)}}return i},q.fn.clearForm=function(e){return this.each(function(){q("input,select,textarea",this).clearFields(e)})},q.fn.clearFields=q.fn.clearInputs=function(r){var a=/^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i;return this.each(function(){var e=this.type,t=this.tagName.toLowerCase();a.test(e)||"textarea"===t?this.value="":"checkbox"===e||"radio"===e?this.checked=!1:"select"===t?this.selectedIndex=-1:"file"===e?/MSIE/.test(navigator.userAgent)?q(this).replaceWith(q(this).clone(!0)):q(this).val(""):r&&(!0===r&&/hidden/.test(e)||"string"==typeof r&&q(this).is(r))&&(this.value="")})},q.fn.resetForm=function(){return this.each(function(){var t=q(this),e=this.tagName.toLowerCase();switch(e){case"input":this.checked=this.defaultChecked;case"textarea":return this.value=this.defaultValue,!0;case"option":case"optgroup":var r=t.parents("select");return r.length&&r[0].multiple?"option"===e?this.selected=this.defaultSelected:t.find("option").resetForm():r.resetForm(),!0;case"select":return t.find("option").each(function(e){if(this.selected=this.defaultSelected,this.defaultSelected&&!t[0].multiple)return t[0].selectedIndex=e,!1}),!0;case"label":var a=q(t.attr("for")),n=t.find("input,select,textarea");return a[0]&&n.unshift(a[0]),n.resetForm(),!0;case"form":return"function"!=typeof this.reset&&("object"!=typeof this.reset||this.reset.nodeType)||this.reset(),!0;default:return t.find("form,input,label,select,textarea").resetForm(),!0}})},q.fn.enable=function(e){return void 0===e&&(e=!0),this.each(function(){this.disabled=!e})},q.fn.selected=function(r){return void 0===r&&(r=!0),this.each(function(){var e,t=this.type;"checkbox"===t||"radio"===t?this.checked=r:"option"===this.tagName.toLowerCase()&&(e=q(this).parent("select"),r&&e[0]&&"select-one"===e[0].type&&e.find("option").selected(!1),this.selected=r)})},q.fn.ajaxSubmit.debug=!1});
;
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
(function ($) {

/**
 * The base States namespace.
 *
 * Having the local states variable allows us to use the States namespace
 * without having to always declare "Backdrop.states".
 */
var states = Backdrop.states = {
  // An array of functions that should be postponed.
  postponed: []
};

/**
 * Attaches the states.
 */
Backdrop.behaviors.states = {
  attach: function (context, settings) {
    var $context = $(context);
    for (var selector in settings.states) {
      if (settings.states.hasOwnProperty(selector)) {
        for (var state in settings.states[selector]) {
          if (settings.states[selector].hasOwnProperty(state)) {
            new states.Dependent({
              element: $context.find(selector),
              state: states.State.sanitize(state),
              constraints: settings.states[selector][state]
            });
          }
        }
      }
    }

    // Execute all postponed functions now.
    while (states.postponed.length) {
      (states.postponed.shift())();
    }
  }
};

/**
 * Object representing an element that depends on other elements.
 *
 * @param args
 *   Object with the following keys (all of which are required):
 *   - element: A jQuery object of the dependent element
 *   - state: A State object describing the state that is dependent
 *   - constraints: An object with dependency specifications. Lists all elements
 *     that this element depends on. It can be nested and can contain arbitrary
 *     AND and OR clauses.
 */
states.Dependent = function (args) {
  $.extend(this, { values: {}, oldValue: null }, args);

  this.dependees = this.getDependees();
  for (var selector in this.dependees) {
    if (this.dependees.hasOwnProperty(selector)) {
      this.initializeDependee(selector, this.dependees[selector]);
    }
  }
};

/**
 * Comparison functions for comparing the value of an element with the
 * specification from the dependency settings. If the object type can't be
 * found in this list, the === operator is used by default.
 */
states.Dependent.comparisons = {
  'RegExp': function (reference, value) {
    return reference.test(value);
  },
  'Function': function (reference, value) {
    // The "reference" variable is a comparison function.
    return reference(value);
  },
  'Number': function (reference, value) {
    // If "reference" is a number and "value" is a string, then cast reference
    // as a string before applying the strict comparison in compare(). Otherwise
    // numeric keys in the form's #states array fail to match string values
    // returned from jQuery's val().
    return (typeof value === 'string') ? compare(reference.toString(), value) : compare(reference, value);
  }
};

states.Dependent.prototype = {
  /**
   * Initializes one of the elements this dependent depends on.
   *
   * @param selector
   *   The CSS selector describing the dependee.
   * @param dependeeStates
   *   The list of states that have to be monitored for tracking the
   *   dependee's compliance status.
   */
  initializeDependee: function (selector, dependeeStates) {
    var state, self = this;

    function stateEventHandler(e) {
      self.update(e.data.selector, e.data.state, e.value);
    }

    // Cache for the states of this dependee.
    this.values[selector] = {};

    for (var i in dependeeStates) {
      if (dependeeStates.hasOwnProperty(i)) {
        state = dependeeStates[i];
        // Make sure we're not initializing this selector/state combination twice.
        if ($.inArray(state, dependeeStates) === -1) {
          continue;
        }

        state = states.State.sanitize(state);

        // Initialize the value of this state.
        this.values[selector][state.name] = null;

        // Monitor state changes of the specified state for this dependee.
        $(selector).on('state:' + state, {selector: selector, state: state}, stateEventHandler);

        // Make sure the event we just bound ourselves to is actually fired.
        new states.Trigger({ selector: selector, state: state });
      }
    }
  },

  /**
   * Compares a value with a reference value.
   *
   * @param reference
   *   The value used for reference.
   * @param selector
   *   CSS selector describing the dependee.
   * @param state
   *   A State object describing the dependee's updated state.
   *
   * @return
   *   true or false.
   */
  compare: function (reference, selector, state) {
    var value = this.values[selector][state.name];
    if (reference.constructor.name in states.Dependent.comparisons) {
      // Use a custom compare function for certain reference value types.
      return states.Dependent.comparisons[reference.constructor.name](reference, value);
    }
    else {
      // Do a plain comparison otherwise.
      return compare(reference, value);
    }
  },

  /**
   * Update the value of a dependee's state.
   *
   * @param selector
   *   CSS selector describing the dependee.
   * @param state
   *   A State object describing the dependee's updated state.
   * @param value
   *   The new value for the dependee's updated state.
   */
  update: function (selector, state, value) {
    // Only act when the 'new' value is actually new.
    if (value !== this.values[selector][state.name]) {
      this.values[selector][state.name] = value;
      this.reevaluate();
    }
  },

  /**
   * Triggers change events in case a state changed.
   */
  reevaluate: function () {
    // Check whether any constraint for this dependent state is satisfied.
    var value = this.verifyConstraints(this.constraints);

    // Only invoke a state change event when the value actually changed.
    if (value !== this.oldValue) {
      // Store the new value so that we can compare later whether the value
      // actually changed.
      this.oldValue = value;

      // Normalize the value to match the normalized state name.
      value = invert(value, this.state.invert);

      // By adding "trigger: true", we ensure that state changes don't go into
      // infinite loops.
      this.element.trigger({ type: 'state:' + this.state, value: value, trigger: true });
    }
  },

  /**
   * Evaluates child constraints to determine if a constraint is satisfied.
   *
   * @param constraints
   *   A constraint object or an array of constraints.
   * @param selector
   *   The selector for these constraints. If undefined, there isn't yet a
   *   selector that these constraints apply to. In that case, the keys of the
   *   object are interpreted as the selector if encountered.
   *
   * @return
   *   true or false, depending on whether these constraints are satisfied.
   */
  verifyConstraints: function(constraints, selector) {
    var result;
    if (Array.isArray(constraints)) {
      // This constraint is an array (OR or XOR).
      var hasXor = $.inArray('xor', constraints) === -1;
      for (var i = 0, len = constraints.length; i < len; i++) {
        if (constraints[i] != 'xor') {
          var constraint = this.checkConstraints(constraints[i], selector, i);
          // Return if this is OR and we have a satisfied constraint or if this
          // is XOR and we have a second satisfied constraint.
          if (constraint && (hasXor || result)) {
            return hasXor;
          }
          result = result || constraint;
        }
      }
    }
    // Make sure we don't try to iterate over things other than objects. This
    // shouldn't normally occur, but in case the condition definition is bogus,
    // we don't want to end up with an infinite loop.
    else if ($.isPlainObject(constraints)) {
      // This constraint is an object (AND).
      for (var n in constraints) {
        if (constraints.hasOwnProperty(n)) {
          result = ternary(result, this.checkConstraints(constraints[n], selector, n));
          // False and anything else will evaluate to false, so return when any
          // false condition is found.
          if (result === false) { return false; }
        }
      }
    }
    return result;
  },

  /**
   * Checks whether the value matches the requirements for this constraint.
   *
   * @param value
   *   Either the value of a state or an array/object of constraints. In the
   *   latter case, resolving the constraint continues.
   * @param selector
   *   The selector for this constraint. If undefined, there isn't yet a
   *   selector that this constraint applies to. In that case, the state key is
   *   propagates to a selector and resolving continues.
   * @param state
   *   The state to check for this constraint. If undefined, resolving
   *   continues.
   *   If both selector and state aren't undefined and valid non-numeric
   *   strings, a lookup for the actual value of that selector's state is
   *   performed. This parameter is not a State object but a pristine state
   *   string.
   *
   * @return
   *   true or false, depending on whether this constraint is satisfied.
   */
  checkConstraints: function(value, selector, state) {
    // Normalize the last parameter. If it's non-numeric, we treat it either as
    // a selector (in case there isn't one yet) or as a trigger/state.
    if (typeof state !== 'string' || (/[0-9]/).test(state[0])) {
      state = null;
    }
    else if (typeof selector === 'undefined') {
      // Propagate the state to the selector when there isn't one yet.
      selector = state;
      state = null;
    }

    if (state !== null) {
      // constraints is the actual constraints of an element to check for.
      state = states.State.sanitize(state);
      return invert(this.compare(value, selector, state), state.invert);
    }
    else {
      // Resolve this constraint as an AND/OR operator.
      return this.verifyConstraints(value, selector);
    }
  },

  /**
   * Gathers information about all required triggers.
   */
  getDependees: function() {
    var cache = {};
    // Swivel the lookup function so that we can record all available selector-
    // state combinations for initialization.
    var _compare = this.compare;
    this.compare = function(reference, selector, state) {
      (cache[selector] || (cache[selector] = [])).push(state.name);
      // Return nothing (=== undefined) so that the constraint loops are not
      // broken.
    };

    // This call doesn't actually verify anything but uses the resolving
    // mechanism to go through the constraints array, trying to look up each
    // value. Since we swivelled the compare function, this comparison returns
    // undefined and lookup continues until the very end. Instead of lookup up
    // the value, we record that combination of selector and state so that we
    // can initialize all triggers.
    this.verifyConstraints(this.constraints);
    // Restore the original function.
    this.compare = _compare;

    return cache;
  }
};

states.Trigger = function (args) {
  $.extend(this, args);

  if (this.state in states.Trigger.states) {
    this.element = $(this.selector);

    // Only call the trigger initializer when it wasn't yet attached to this
    // element. Otherwise we'd end up with duplicate events.
    if (!this.element.data('trigger:' + this.state)) {
      this.initialize();
    }
  }
};

states.Trigger.prototype = {
  initialize: function () {
    var trigger = states.Trigger.states[this.state];

    if (typeof trigger == 'function') {
      // We have a custom trigger initialization function.
      trigger.call(window, this.element);
    }
    else {
      for (var event in trigger) {
        if (trigger.hasOwnProperty(event)) {
          this.defaultTrigger(event, trigger[event]);
        }
      }
    }

    // Mark this trigger as initialized for this element.
    this.element.data('trigger:' + this.state, true);
  },

  defaultTrigger: function (event, valueFn) {
    var oldValue = valueFn.call(this.element);

    // Attach the event callback.
    this.element.on(event, $.proxy(function (e) {
      var value = valueFn.call(this.element, e);
      // Only trigger the event if the value has actually changed.
      if (oldValue !== value) {
        this.element.trigger({ type: 'state:' + this.state, value: value, oldValue: oldValue });
        oldValue = value;
      }
    }, this));

    states.postponed.push($.proxy(function () {
      // Trigger the event once for initialization purposes.
      this.element.trigger({ type: 'state:' + this.state, value: oldValue, oldValue: null });
    }, this));
  }
};

/**
 * This list of states contains functions that are used to monitor the state
 * of an element. Whenever an element depends on the state of another element,
 * one of these trigger functions is added to the dependee so that the
 * dependent element can be updated.
 */
states.Trigger.states = {
  // 'empty' describes the state to be monitored
  empty: {
    // 'keyup' is the (native DOM) event that we watch for.
    'keyup': function () {
      // The function associated to that trigger returns the new value for the
      // state.
      return this.val() == '';
    }
  },

  checked: {
    'change': function () {
      // prop() and attr() only takes the first element into account. To support
      // selectors matching multiple checkboxes, iterate over all and return
      // whether any is checked.
      var checked = false;
      this.each(function () {
        // Use prop() here as we want a boolean of the checkbox state.
        // @see http://api.jquery.com/prop/
        checked = $(this).prop('checked');
        // Break the each() loop if this is checked.
        return !checked;
      });
      return checked;
    }
  },

  // For radio buttons, only return the value if the radio button is selected.
  value: {
    'keyup': function () {
      // Radio buttons share the same :input[name="key"] selector.
      if (this.length > 1) {
        // Initial checked value of radios is undefined, so we return false.
        return this.filter(':checked').val() || false;
      }
      return this.val();
    },
    'change': function () {
      // Radio buttons share the same :input[name="key"] selector.
      if (this.length > 1) {
        // Initial checked value of radios is undefined, so we return false.
        return this.filter(':checked').val() || false;
      }
      return this.val();
    }
  },

  collapsed: {
    'collapsed': function(e) {
      return (typeof e !== 'undefined' && 'value' in e) ? e.value : this.is('.collapsed');
    }
  }
};


/**
 * A state object is used for describing the state and performing aliasing.
 */
states.State = function(state) {
  // We may need the original unresolved name later.
  this.pristine = this.name = state;

  // Normalize the state name.
  while (true) {
    // Iteratively remove exclamation marks and invert the value.
    while (this.name.charAt(0) == '!') {
      this.name = this.name.substring(1);
      this.invert = !this.invert;
    }

    // Replace the state with its normalized name.
    if (this.name in states.State.aliases) {
      this.name = states.State.aliases[this.name];
    }
    else {
      break;
    }
  }
};

/**
 * Creates a new State object by sanitizing the passed value.
 */
states.State.sanitize = function (state) {
  if (state instanceof states.State) {
    return state;
  }
  else {
    return new states.State(state);
  }
};

/**
 * This list of aliases is used to normalize states and associates negated names
 * with their respective inverse state.
 */
states.State.aliases = {
  'enabled': '!disabled',
  'invisible': '!visible',
  'invalid': '!valid',
  'untouched': '!touched',
  'optional': '!required',
  'filled': '!empty',
  'unchecked': '!checked',
  'irrelevant': '!relevant',
  'expanded': '!collapsed',
  'readwrite': '!readonly'
};

states.State.prototype = {
  invert: false,

  /**
   * Ensures that just using the state object returns the name.
   */
  toString: function() {
    return this.name;
  }
};

/**
 * Global state change handlers. These are bound to "document" to cover all
 * elements whose state changes. Events sent to elements within the page
 * bubble up to these handlers. We use this system so that themes and modules
 * can override these state change handlers for particular parts of a page.
 */

$(document).on('state:disabled', function(e) {
  // Only act when this change was triggered by a dependency and not by the
  // element monitoring itself.
  if (e.trigger) {
    $(e.target)
      .prop('disabled', e.value)
        .closest('.form-item, .form-submit, .form-wrapper').toggleClass('form-disabled', e.value)
        .find('select, input, textarea').prop('disabled', e.value);

    // Note: WebKit nightlies don't reflect that change correctly.
    // See https://bugs.webkit.org/show_bug.cgi?id=23789
  }
});

$(document).on('state:required', function(e) {
  if (e.trigger) {
    if (e.value) {
      var $label = $(e.target).closest('.form-item, .form-wrapper').find('label');
      // Avoids duplicate required markers on initialization.
      if (!$label.find('.form-required').length) {
        $label.append('<abbr class="form-required" title="' + Backdrop.t('This field is required.') + '">*</abbr>');
      }
    }
    else {
      $(e.target).closest('.form-item, .form-wrapper').find('label .form-required').remove();
    }
  }
});

$(document).on('state:visible', function(e) {
  if (e.trigger) {
    $(e.target).closest('.form-item, .form-submit, .form-wrapper').toggle(e.value);
  }
});

$(document).on('state:checked', function(e) {
  if (e.trigger) {
    $(e.target).prop('checked', e.value);
  }
});

$(document).on('state:collapsed', function(e) {
  if (e.trigger) {
    if ($(e.target).is('.collapsed') !== e.value) {
      $('> legend a', e.target).trigger('click');
    }
  }
});


/**
 * These are helper functions implementing addition "operators" and don't
 * implement any logic that is particular to states.
 */

// Bitwise AND with a third undefined state.
function ternary (a, b) {
  return typeof a === 'undefined' ? b : (typeof b === 'undefined' ? a : a && b);
}

// Inverts a (if it's not undefined) when invertState is true.
function invert (a, invertState) {
  return (invertState && typeof a !== 'undefined') ? !a : a;
}

// Compares two values while ignoring undefined values.
function compare (a, b) {
  return (a === b) ? (typeof a === 'undefined' ? a : true) : (typeof a === 'undefined' || typeof b === 'undefined');
}

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
