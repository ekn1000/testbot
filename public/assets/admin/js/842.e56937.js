/*! For license information please see 842.e56937.js.LICENSE.txt */
"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[842],{74067:(t,e,r)=>{function o(t){return o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},o(t)}function n(t,e){for(var r=0;r<e.length;r++){var n=e[r];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(t,(i=n.key,s=void 0,s=function(t,e){if("object"!==o(t)||null===t)return t;var r=t[Symbol.toPrimitive];if(void 0!==r){var n=r.call(t,e||"default");if("object"!==o(n))return n;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===e?String:Number)(t)}(i,"string"),"symbol"===o(s)?s:String(s)),n)}var i,s}r.d(e,{D:()=>i});var i=function(){function t(){!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,t),this.errors={}}var e,r,o;return e=t,(r=[{key:"has",value:function(t){return this.errors.hasOwnProperty(t)}},{key:"any",value:function(){return Object.keys(this.errors).length>0}},{key:"get",value:function(t){if(this.errors[t])return this.errors[t][0]}},{key:"getFlash",value:function(t){if(this.errors[t])return this.errors[t]}},{key:"record",value:function(t){this.errors=t}},{key:"clear",value:function(t){t?this.has(t)&&delete this.errors[t]:this.errors={}}}])&&n(e.prototype,r),o&&n(e,o),Object.defineProperty(e,"prototype",{writable:!1}),t}()},82842:(t,e,r)=>{r.r(e),r.d(e,{default:()=>b});var o=r(20629),n=r(74067);const i={props:{saveMsg:{default:"Группа проектов добавлена"},form:{type:Object},formAction:{type:Object}},data:function(){return{errors:new n.D}},methods:{closeModal:function(t){this.$emit("close",t)},save:function(){var t=this;axios({method:this.formAction.method,url:this.formAction.url,data:this.form}).then((function(e){t.$message({message:t.saveMsg,type:"success"}),t.closeModal()})).catch((function(e){t.errors.record(e.response.data.errors)}))}},mounted:function(){}};var s=r(51900);const a=(0,s.Z)(i,(function(){var t=this,e=t._self._c;return e("el-form",{ref:"form",attrs:{model:t.form,"label-position":"top"}},[e("el-form-item",{attrs:{prop:"name",label:"Название группы проектов",error:t.errors.get("name")}},[e("el-input",{attrs:{placeholder:"Название группы проектов"},model:{value:t.form.name,callback:function(e){t.$set(t.form,"name",e)},expression:"form.name"}})],1),t._v(" "),e("el-form-item",{attrs:{prop:"comment",label:"Комментарий",error:t.errors.get("comment")}},[e("el-input",{attrs:{type:"textarea",placeholder:"Комментарий"},model:{value:t.form.comment,callback:function(e){t.$set(t.form,"comment",e)},expression:"form.comment"}})],1),t._v(" "),e("div",{staticClass:"text-center"},[e("el-button",{attrs:{type:"success"},on:{click:function(e){return e.preventDefault(),t.save.apply(null,arguments)}}},[t._v("Сохранить")]),t._v(" "),e("el-button",{on:{click:function(e){return e.preventDefault(),t.closeModal.apply(null,arguments)}}},[t._v("Отменить")])],1)],1)}),[],!1,null,null,null).exports;function c(t){return c="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},c(t)}function l(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(t);e&&(o=o.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),r.push.apply(r,o)}return r}function u(t,e,r){return(e=function(t){var e=function(t,e){if("object"!==c(t)||null===t)return t;var r=t[Symbol.toPrimitive];if(void 0!==r){var o=r.call(t,e||"default");if("object"!==c(o))return o;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===e?String:Number)(t)}(t,"string");return"symbol"===c(e)?e:String(e)}(e))in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}const f={components:{GroupForm:a},computed:function(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?l(Object(r),!0).forEach((function(e){u(t,e,r[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):l(Object(r)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))}))}return t}({},(0,o.Se)(["userId"])),data:function(){return{formAction:{url:"/api/admin/project-groups",method:"post"},form:{name:"",comment:"",user_id:null}}},methods:{closeModal:function(t){this.$emit("close",t)}},mounted:function(){this.form.user_id=this.userId}};function p(t){return p="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},p(t)}function m(){m=function(){return e};var t,e={},r=Object.prototype,o=r.hasOwnProperty,n=Object.defineProperty||function(t,e,r){t[e]=r.value},i="function"==typeof Symbol?Symbol:{},s=i.iterator||"@@iterator",a=i.asyncIterator||"@@asyncIterator",c=i.toStringTag||"@@toStringTag";function l(t,e,r){return Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{l({},"")}catch(t){l=function(t,e,r){return t[e]=r}}function u(t,e,r,o){var i=e&&e.prototype instanceof g?e:g,s=Object.create(i.prototype),a=new D(o||[]);return n(s,"_invoke",{value:x(t,r,a)}),s}function f(t,e,r){try{return{type:"normal",arg:t.call(e,r)}}catch(t){return{type:"throw",arg:t}}}e.wrap=u;var d="suspendedStart",v="suspendedYield",h="executing",_="completed",y={};function g(){}function b(){}function w(){}var k={};l(k,s,(function(){return this}));var j=Object.getPrototypeOf,C=j&&j(j(A([])));C&&C!==r&&o.call(C,s)&&(k=C);var O=w.prototype=g.prototype=Object.create(k);function S(t){["next","throw","return"].forEach((function(e){l(t,e,(function(t){return this._invoke(e,t)}))}))}function P(t,e){function r(n,i,s,a){var c=f(t[n],t,i);if("throw"!==c.type){var l=c.arg,u=l.value;return u&&"object"==p(u)&&o.call(u,"__await")?e.resolve(u.__await).then((function(t){r("next",t,s,a)}),(function(t){r("throw",t,s,a)})):e.resolve(u).then((function(t){l.value=t,s(l)}),(function(t){return r("throw",t,s,a)}))}a(c.arg)}var i;n(this,"_invoke",{value:function(t,o){function n(){return new e((function(e,n){r(t,o,e,n)}))}return i=i?i.then(n,n):n()}})}function x(e,r,o){var n=d;return function(i,s){if(n===h)throw new Error("Generator is already running");if(n===_){if("throw"===i)throw s;return{value:t,done:!0}}for(o.method=i,o.arg=s;;){var a=o.delegate;if(a){var c=L(a,o);if(c){if(c===y)continue;return c}}if("next"===o.method)o.sent=o._sent=o.arg;else if("throw"===o.method){if(n===d)throw n=_,o.arg;o.dispatchException(o.arg)}else"return"===o.method&&o.abrupt("return",o.arg);n=h;var l=f(e,r,o);if("normal"===l.type){if(n=o.done?_:v,l.arg===y)continue;return{value:l.arg,done:o.done}}"throw"===l.type&&(n=_,o.method="throw",o.arg=l.arg)}}}function L(e,r){var o=r.method,n=e.iterator[o];if(n===t)return r.delegate=null,"throw"===o&&e.iterator.return&&(r.method="return",r.arg=t,L(e,r),"throw"===r.method)||"return"!==o&&(r.method="throw",r.arg=new TypeError("The iterator does not provide a '"+o+"' method")),y;var i=f(n,e.iterator,r.arg);if("throw"===i.type)return r.method="throw",r.arg=i.arg,r.delegate=null,y;var s=i.arg;return s?s.done?(r[e.resultName]=s.value,r.next=e.nextLoc,"return"!==r.method&&(r.method="next",r.arg=t),r.delegate=null,y):s:(r.method="throw",r.arg=new TypeError("iterator result is not an object"),r.delegate=null,y)}function E(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function T(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function D(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(E,this),this.reset(!0)}function A(e){if(e||""===e){var r=e[s];if(r)return r.call(e);if("function"==typeof e.next)return e;if(!isNaN(e.length)){var n=-1,i=function r(){for(;++n<e.length;)if(o.call(e,n))return r.value=e[n],r.done=!1,r;return r.value=t,r.done=!0,r};return i.next=i}}throw new TypeError(p(e)+" is not iterable")}return b.prototype=w,n(O,"constructor",{value:w,configurable:!0}),n(w,"constructor",{value:b,configurable:!0}),b.displayName=l(w,c,"GeneratorFunction"),e.isGeneratorFunction=function(t){var e="function"==typeof t&&t.constructor;return!!e&&(e===b||"GeneratorFunction"===(e.displayName||e.name))},e.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,w):(t.__proto__=w,l(t,c,"GeneratorFunction")),t.prototype=Object.create(O),t},e.awrap=function(t){return{__await:t}},S(P.prototype),l(P.prototype,a,(function(){return this})),e.AsyncIterator=P,e.async=function(t,r,o,n,i){void 0===i&&(i=Promise);var s=new P(u(t,r,o,n),i);return e.isGeneratorFunction(r)?s:s.next().then((function(t){return t.done?t.value:s.next()}))},S(O),l(O,c,"Generator"),l(O,s,(function(){return this})),l(O,"toString",(function(){return"[object Generator]"})),e.keys=function(t){var e=Object(t),r=[];for(var o in e)r.push(o);return r.reverse(),function t(){for(;r.length;){var o=r.pop();if(o in e)return t.value=o,t.done=!1,t}return t.done=!0,t}},e.values=A,D.prototype={constructor:D,reset:function(e){if(this.prev=0,this.next=0,this.sent=this._sent=t,this.done=!1,this.delegate=null,this.method="next",this.arg=t,this.tryEntries.forEach(T),!e)for(var r in this)"t"===r.charAt(0)&&o.call(this,r)&&!isNaN(+r.slice(1))&&(this[r]=t)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(e){if(this.done)throw e;var r=this;function n(o,n){return a.type="throw",a.arg=e,r.next=o,n&&(r.method="next",r.arg=t),!!n}for(var i=this.tryEntries.length-1;i>=0;--i){var s=this.tryEntries[i],a=s.completion;if("root"===s.tryLoc)return n("end");if(s.tryLoc<=this.prev){var c=o.call(s,"catchLoc"),l=o.call(s,"finallyLoc");if(c&&l){if(this.prev<s.catchLoc)return n(s.catchLoc,!0);if(this.prev<s.finallyLoc)return n(s.finallyLoc)}else if(c){if(this.prev<s.catchLoc)return n(s.catchLoc,!0)}else{if(!l)throw new Error("try statement without catch or finally");if(this.prev<s.finallyLoc)return n(s.finallyLoc)}}}},abrupt:function(t,e){for(var r=this.tryEntries.length-1;r>=0;--r){var n=this.tryEntries[r];if(n.tryLoc<=this.prev&&o.call(n,"finallyLoc")&&this.prev<n.finallyLoc){var i=n;break}}i&&("break"===t||"continue"===t)&&i.tryLoc<=e&&e<=i.finallyLoc&&(i=null);var s=i?i.completion:{};return s.type=t,s.arg=e,i?(this.method="next",this.next=i.finallyLoc,y):this.complete(s)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),y},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.finallyLoc===t)return this.complete(r.completion,r.afterLoc),T(r),y}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.tryLoc===t){var o=r.completion;if("throw"===o.type){var n=o.arg;T(r)}return n}}throw new Error("illegal catch attempt")},delegateYield:function(e,r,o){return this.delegate={iterator:A(e),resultName:r,nextLoc:o},"next"===this.method&&(this.arg=t),y}},e}function d(t,e,r,o,n,i,s){try{var a=t[i](s),c=a.value}catch(t){return void r(t)}a.done?e(c):Promise.resolve(c).then(o,n)}const v={components:{ModeratorForm:a},props:["id"],data:function(){return{loaded:!1,form:{},formAction:{url:"/api/admin/project-groups/"+this.id,method:"put"}}},methods:{closeModal:function(t){this.$emit("close",t)},getFormData:function(){var t=this;return this.$root.isLoading=!0,axios.get("/api/admin/project-groups/"+this.id).then((function(e){t.form=e.data,t.loaded=!0,t.$root.isLoading=!1}))}},mounted:function(){var t,e=this;return(t=m().mark((function t(){return m().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,e.getFormData();case 2:case"end":return t.stop()}}),t)})),function(){var e=this,r=arguments;return new Promise((function(o,n){var i=t.apply(e,r);function s(t){d(i,o,n,s,a,"next",t)}function a(t){d(i,o,n,s,a,"throw",t)}s(void 0)}))})()}};function h(t){return h="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},h(t)}function _(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(t);e&&(o=o.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),r.push.apply(r,o)}return r}function y(t,e,r){return(e=function(t){var e=function(t,e){if("object"!==h(t)||null===t)return t;var r=t[Symbol.toPrimitive];if(void 0!==r){var o=r.call(t,e||"default");if("object"!==h(o))return o;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===e?String:Number)(t)}(t,"string");return"symbol"===h(e)?e:String(e)}(e))in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}const g={components:{create:(0,s.Z)(f,(function(){var t=this;return(0,t._self._c)("group-form",{attrs:{form:t.form,formAction:t.formAction,closeMsg:"Группа проектов добавлена"},on:{close:t.closeModal}})}),[],!1,null,null,null).exports,edit:(0,s.Z)(v,(function(){var t=this,e=t._self._c;return e("section",[t.loaded?e("moderator-form",{attrs:{"save-msg":"Группа проектов обновлена",form:t.form,formAction:t.formAction},on:{close:t.closeModal}}):t._e()],1)}),[],!1,null,null,null).exports},data:function(){return{taskUrl:"",id:null,modalStatus:"",modalVisible:!1,search:"",project_groups:[],tasksColors:[{color:"#9b2d30",percentage:20},{color:"#f56c6c",percentage:40},{color:"#e6a23c",percentage:60},{color:"#409eff",percentage:80},{color:"#67c23a",percentage:100}],notFoundTasksColors:[{color:"#67c23a",percentage:20},{color:"#409eff",percentage:40},{color:"#e6a23c",percentage:60},{color:"#f56c6c",percentage:80},{color:"#9b2d30",percentage:100}]}},computed:function(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?_(Object(r),!0).forEach((function(e){y(t,e,r[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):_(Object(r)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))}))}return t}({filteredList:function(){var t=this;return this.project_groups.filter((function(e){return e.name.toLowerCase().includes(t.search.toLowerCase())}))},modalTitle:function(){return"create"===this.modalStatus?"Новая группа проектов":"edit"===this.modalStatus?"Редактировать группу проктов":void 0}},(0,o.Se)(["userId"])),methods:{getPercentage:function(t,e){return t?Math.round(e/t*100):0},tasksProgressBarColor:function(t){},getProjectGroups:function(){var t=this;axios.get("/api/admin/project-groups",{params:{user_id:this.userId}}).then((function(e){t.project_groups=e.data}))},modalOpen:function(t){this.modalStatus=t,this.modalVisible=!0},closeModal:function(t){this.modalVisible=!1,this.id=null,this.getProjectGroups()},handleEdit:function(t){this.id=t,this.modalStatus="edit",this.modalVisible=!0},handlePlayOrStop:function(t,e){var r=this,o=e?"Проекты в группе активированы":"Проекты в группе остановлены";axios.post("/api/admin/handle-batch-status",{parent_id:t,status:e,type:"project"}).then((function(t){r.getProjectGroups(),r.$message({type:"success",message:o})}))},handleDelete:function(t){var e=this;this.$confirm("Вы уверены что хотите удалить  Группу проектов","Удаление группы проектов",{confirmButtonText:"Удалить",cancelButtonText:"Отмена",type:"warning"}).then((function(){axios.delete("/api/admin/project-groups/"+t.id).then((function(t){var r=e.project_groups.findIndex((function(e){return e.id===t.data.id}));e.project_groups.splice(r,1),e.$message({type:"success",message:"Группа проектов удалена"})}))})).catch((function(){}))},copyTaskUrlFromProjectGroup:function(t){var e=this;t.api_key?this.copyTaskUrl(t.api_key):axios.post("/api/admin/project-groups-generate-api-key/"+t.id).then((function(t){e.copyTaskUrl(t.data),console.log(t.data)}))},copyTaskUrl:function(t){var e=window.location.protocol+"//"+window.location.host+"/api/gettaskfromprojectgroup/"+t+"?",r=document.querySelector("#task_url");r.setAttribute("type","text"),r.setAttribute("value",e),r.select();try{document.execCommand("copy");this.$message({type:"success",message:"Ссылка для выдачи задания скопирована"})}catch(t){}r.setAttribute("type","hidden"),window.getSelection().removeAllRanges()}},mounted:function(){this.getProjectGroups()}};const b=(0,s.Z)(g,(function(){var t=this,e=t._self._c;return e("section",{staticClass:"page"},[e("input",{attrs:{type:"hidden",id:"task_url"},domProps:{value:t.taskUrl}}),t._v(" "),e("h1",{staticClass:"page-title"},[t._v("Группы проектов")]),t._v(" "),e("div",{staticClass:"page-heading d-flex align-items-center justify-content-between mb-3",staticStyle:{gap:"20px"}},[e("el-input",{attrs:{size:"large",placeholder:"Поиск: Название"},model:{value:t.search,callback:function(e){t.search=e},expression:"search"}}),t._v(" "),e("el-button",{attrs:{type:"success",icon:"el-icon-plus"},on:{click:function(e){return t.modalOpen("create")}}},[t._v("Добавить группу проектов")])],1),t._v(" "),e("div",{staticClass:"row"},t._l(t.filteredList,(function(r){return e("div",{staticClass:"col-md-4 mb-3"},[e("el-card",{staticClass:"box-card"},[e("div",{staticClass:"d-flex justify-content-between align-items-center",staticStyle:{gap:"15px"},attrs:{slot:"header"},slot:"header"},[e("span",[t._v(t._s(r.name))]),t._v(" "),e("el-tooltip",{staticClass:"item",attrs:{effect:"dark",placement:"bottom"}},[e("div",{attrs:{slot:"content"},slot:"content"},[t._v("Открыть список проектов группы")]),t._v(" "),e("router-link",{attrs:{to:"/project-groups/"+r.id}},[e("el-button",{attrs:{size:"mini",type:"primary"}},[t._v("\n                                Перейти\n                            ")])],1)],1)],1),t._v(" "),e("ul",{staticClass:"inf-item-list"},[e("li",{staticClass:"inf-item-list__item"},[e("label",{staticClass:"inf-item-list__label"},[t._v("\n                                Проектов\n                            ")]),t._v(" "),e("div",{staticClass:"inf-item-list__values"},[e("span",{staticStyle:{color:"green"}},[t._v("\n                                    "+t._s(r.active_projects)+"\n                                ")]),t._v(" "),e("span",{staticStyle:{color:"darkred"}},[t._v("\n                                    "+t._s(r.stopped_projects)+"\n                                ")])])]),t._v(" "),e("li",{staticClass:"inf-item-list__item"},[e("label",{staticClass:"inf-item-list__label"},[t._v("\n                                Ключей\n                            ")]),t._v(" "),e("div",{staticClass:"inf-item-list__values"},[e("span",{staticStyle:{color:"green"}},[t._v("\n                                     "+t._s(r.active_keys)+"\n                                ")]),t._v(" "),e("span",{staticStyle:{color:"darkred"}},[t._v("\n                                     "+t._s(r.stopped_keys)+"\n                                ")])])]),t._v(" "),e("li",{staticClass:"inf-item-list__item"},[e("el-tooltip",{staticClass:"item",attrs:{effect:"dark",placement:"right-start"}},[e("div",{attrs:{slot:"content"},slot:"content"},[t._v("Суммарная частота — это частота всех ключей за месяц")]),t._v(" "),e("label",{staticClass:"inf-item-list__label"},[t._v("\n                                    Σ Частота "),e("i",{staticClass:"el-icon-question"})])]),t._v(" "),e("div",{staticClass:"inf-item-list__values"},[e("span",{staticStyle:{color:"green"}},[t._v("\n                                     "+t._s(r.active_frequency)+"\n                                ")]),t._v(" "),e("span",{staticStyle:{color:"darkred"}},[t._v("\n                                         "+t._s(r.stopped_frequency)+"\n                                ")])])],1),t._v(" "),e("li",{staticClass:"inf-item-list__item inf-item-list__item--progress-bar"},[e("el-tooltip",{staticClass:"item",attrs:{effect:"dark",placement:"right-start"}},[e("div",{attrs:{slot:"content"},slot:"content"},[t._v("Дневной объем заданий"),e("br"),t._v("\n                                    Считается как сумма значения 'ДОЗа' по всем активным ключам"),e("br"),t._v("\n                                    Где 'ДОЗа' - дневной объём заданий по каждому ключу"),e("br"),t._v("\n                                    'Частота' - статистика по ключу за месяц, например, из Вордстат"),e("br"),t._v("\n                                    'Коэффициент' - CTR ключа в % / 100"),e("br"),t._v("\n\t\t\t\t\t\t\t\t\t'ДОЗа' = 'Частота' * 'Коэффициент' / 30"),e("br")]),t._v(" "),e("label",{staticClass:"inf-item-list__label"},[t._v("\n                                    Заданий "),e("i",{staticClass:"el-icon-question"})])]),t._v(" "),e("div",{staticClass:"inf-item-list__values align-items-center"},[e("span",[t._v("\n                                      "+t._s(Math.round(r.projects_sum_daily_volume_of_keys))+"\n                                ")])])],1),t._v(" "),e("li",{staticClass:"inf-item-list__item inf-item-list__item--progress-bar"},[e("el-tooltip",{staticClass:"item",attrs:{effect:"dark",placement:"right-start"}},[e("div",{attrs:{slot:"content"},slot:"content"},[t._v("Софт получил от API задание с запросом")]),t._v(" "),e("label",{staticClass:"inf-item-list__label"},[t._v("\n                                received "),e("i",{staticClass:"el-icon-question"})])]),t._v(" "),e("div",{staticClass:"inf-item-list__progress-bar"},[e("el-progress",{attrs:{"stroke-width":15,color:"#409eff",percentage:t.getPercentage(r.projects_sum_daily_volume_of_keys,r.statistics_sum_received)}})],1)],1),t._v(" "),e("li",{staticClass:"inf-item-list__item inf-item-list__item--progress-bar"},[e("el-tooltip",{staticClass:"item",attrs:{effect:"dark",placement:"right-start"}},[e("div",{attrs:{slot:"content"},slot:"content"},[t._v("Запрос ввели в строку поиска ПС"),e("br"),t._v("или открыли ПС с параметром text=...")]),t._v(" "),e("label",{staticClass:"inf-item-list__label"},[t._v("\n                                    entered "),e("i",{staticClass:"el-icon-question"})])]),t._v(" "),e("div",{staticClass:"inf-item-list__progress-bar"},[e("el-progress",{attrs:{"stroke-width":15,color:"#409eff",percentage:t.getPercentage(r.projects_sum_daily_volume_of_keys,r.statistics_sum_entered)}})],1)],1),t._v(" "),e("li",{staticClass:"inf-item-list__item inf-item-list__item--progress-bar"},[e("el-tooltip",{staticClass:"item",attrs:{effect:"dark",placement:"right-start"}},[e("div",{attrs:{slot:"content"},slot:"content"},[t._v("По запросу нашли целевой сайт")]),t._v(" "),e("label",{staticClass:"inf-item-list__label"},[t._v("\n                                    found "),e("i",{staticClass:"el-icon-question"})])]),t._v(" "),e("div",{staticClass:"inf-item-list__progress-bar"},[e("el-progress",{attrs:{"stroke-width":15,color:t.tasksColors,percentage:t.getPercentage(r.projects_sum_daily_volume_of_keys,r.statistics_sum_found)}})],1)],1),t._v(" "),e("li",{staticClass:"inf-item-list__item inf-item-list__item--progress-bar"},[e("el-tooltip",{staticClass:"item",attrs:{effect:"dark",placement:"right-start"}},[e("div",{attrs:{slot:"content"},slot:"content"},[t._v("Сделали переход из ПС на целевой сайт")]),t._v(" "),e("label",{staticClass:"inf-item-list__label"},[t._v("\n                                    visited "),e("i",{staticClass:"el-icon-question"})])]),t._v(" "),e("div",{staticClass:"inf-item-list__progress-bar"},[e("el-progress",{attrs:{"stroke-width":15,color:t.tasksColors,percentage:t.getPercentage(r.projects_sum_daily_volume_of_keys,r.statistics_sum_visited)}})],1)],1),t._v(" "),e("li",{staticClass:"inf-item-list__item inf-item-list__item--progress-bar"},[e("el-tooltip",{staticClass:"item",attrs:{effect:"dark",placement:"right-start"}},[e("div",{attrs:{slot:"content"},slot:"content"},[t._v("По запросу не нашли целевой сайт"),e("br"),t._v("с указанной в настройках глубиной")]),t._v(" "),e("label",{staticClass:"inf-item-list__label"},[t._v("\n                                    notfound "),e("i",{staticClass:"el-icon-question"})])]),t._v(" "),e("div",{staticClass:"inf-item-list__progress-bar"},[e("el-progress",{attrs:{"stroke-width":15,color:t.notFoundTasksColors,percentage:t.getPercentage(r.projects_sum_daily_volume_of_keys,r.statistics_sum_notfound)}})],1)],1)]),t._v(" "),r.comment?e("div",[e("label",{staticClass:"project-group-card__label"},[t._v("\n                            Комментарий\n                        ")]),t._v(" "),e("div",{staticClass:"project-group-card__comment"},[t._v("\n                            "+t._s(r.comment)+"\n                        ")])]):t._e(),t._v(" "),e("div",{staticClass:"project-group-card__actions"},[e("el-tooltip",{staticClass:"item",attrs:{effect:"dark",content:"Копировать API url группы проектов",placement:"bottom"}},[e("el-button",{attrs:{type:"info",icon:"el-icon-copy-document"},on:{click:function(e){return e.preventDefault(),t.copyTaskUrlFromProjectGroup(r)}}})],1),t._v(" "),e("el-tooltip",{staticClass:"item",attrs:{effect:"dark",content:"Остановить все проекты в группе",placement:"bottom"}},[e("el-button",{attrs:{type:"warning",icon:"el-icon-video-pause"},on:{click:function(e){return e.preventDefault(),t.handlePlayOrStop(r.id,!1)}}})],1),t._v(" "),e("el-tooltip",{staticClass:"item",attrs:{effect:"dark",content:"Запустить все проекты в группе",placement:"bottom"}},[e("el-button",{attrs:{type:"success",icon:"el-icon-video-play"},on:{click:function(e){return e.preventDefault(),t.handlePlayOrStop(r.id,!0)}}})],1),t._v(" "),e("el-tooltip",{staticClass:"item",attrs:{effect:"dark",content:"Редактировать группу проектов",placement:"bottom"}},[e("el-button",{attrs:{type:"primary",icon:"el-icon-edit"},on:{click:function(e){return e.preventDefault(),t.handleEdit(r.id)}}})],1),t._v(" "),e("el-tooltip",{staticClass:"item",attrs:{effect:"dark",content:"Удалить группу проектов",placement:"bottom"}},[e("el-button",{attrs:{type:"danger",icon:"el-icon-delete"},on:{click:function(e){return e.preventDefault(),t.handleDelete(r)}}})],1)],1)])],1)})),0),t._v(" "),e("el-dialog",{attrs:{visible:t.modalVisible,width:"60%",title:t.modalTitle},on:{"update:visible":function(e){t.modalVisible=e}}},[t.modalVisible&&"create"===t.modalStatus?e("create",{on:{close:t.closeModal}}):t._e(),t._v(" "),t.modalVisible&&"edit"===t.modalStatus?e("edit",{attrs:{id:t.id},on:{close:t.closeModal}}):t._e()],1)],1)}),[],!1,null,null,null).exports}}]);
//# sourceMappingURL=842.e56937.js.map