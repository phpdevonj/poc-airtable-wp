var m=Object.defineProperty,y=Object.defineProperties;var F=Object.getOwnPropertyDescriptors;var _=Object.getOwnPropertySymbols;var k=Object.prototype.hasOwnProperty,P=Object.prototype.propertyIsEnumerable;var h=(t,s,e)=>s in t?m(t,s,{enumerable:!0,configurable:!0,writable:!0,value:e}):t[s]=e,c=(t,s)=>{for(var e in s||(s={}))k.call(s,e)&&h(t,e,s[e]);if(_)for(var e of _(s))P.call(s,e)&&h(t,e,s[e]);return t},r=(t,s)=>y(t,F(s));import{_ as u,c as f,d as n}from"./bi.738.82.js";const p=(t,s,e)=>{const a=c({},s),{name:i}=t.target;t.target.value!==""?a[i]=t.target.value:delete a[i],e(c({},a))},S=t=>{let s=[];t.actionName==="task"&&(s=t==null?void 0:t.taskFields);const e=s==null?void 0:s.filter(a=>a.required===!0);return e.length>0?e.map(a=>({formField:"",asanaFormField:a.key})):[{formField:"",asanaFormField:""}]},A=t=>!((t!=null&&t.field_map?t.field_map.filter(e=>!e.formField||!e.asanaFormField||e.formField==="custom"&&!e.customValue||e.asanaFormField==="customFieldKey"&&!e.customFieldKey):[]).length>0),N=(t,s,e,a,i,o)=>{if(!t.api_key){e({api_key:t.api_key?"":u("Api Key can't be empty","bit-integrations")});return}e({}),o(r(c({},i),{auth:!0}));const l={api_key:t.api_key};f(l,"asana_authentication").then(d=>{if(d&&d.success){a(!0),o(r(c({},i),{auth:!1})),n.success(u("Authorized successfully","bit-integrations"));return}o(r(c({},i),{auth:!1})),n.error(u("Authorized failed, Please enter valid API key","bit-integrations"))})},q=(t,s,e)=>{e(r(c({},e),{customFields:!0}));const a={api_key:t.api_key,action:t.actionName,project_id:t.selectedProject};f(a,"asana_fetch_custom_fields").then(i=>{if(i&&i.success){s(o=>{const l=c({},o);return l.default||(l.default={}),i.data&&(l.customFields=i.data),l}),e(r(c({},e),{customFields:!1})),i.data?n.success(u("Custom fields also fetched successfully","bit-integrations")):n.error(u("No custom fields found","bit-integrations"));return}e(r(c({},e),{customFields:!1})),n.error(u("Custom fields fetching failed","bit-integrations"))})},g=(t,s,e)=>{e(r(c({},e),{Projects:!0}));const a={api_key:t.api_key,action_name:t.actionName};f(a,"asana_fetch_all_Projects").then(i=>{if(i&&i.success){const o=c({},t);i.data&&(o.Projects=i.data),s(o),e(r(c({},e),{Projects:!1})),t.actionName==="task"&&n.success(u("Projects fetched successfully","bit-integrations"));return}e(r(c({},e),{Projects:!1})),t.actionName==="task"&&n.error(u("Projects fetching failed","bit-integrations"))})},w=(t,s,e)=>{e(r(c({},e),{Sections:!0}));const a={api_key:t.api_key,selected_project:t.selectedProject};f(a,"asana_fetch_all_Sections").then(i=>{if(i&&i.success){s(o=>{const l=c({},o);return l.default||(l.default={}),i.data&&(l.Sections=i.data),l}),e(r(c({},e),{Sections:!1})),n.success(u("Sections fetched successfully","bit-integrations"));return}e(r(c({},e),{Sections:!1})),n.error(u("Sections fetching failed","bit-integrations"))})};export{g as a,w as b,A as c,q as d,N as e,S as g,p as h};
