var _=Object.defineProperty,F=Object.defineProperties;var d=Object.getOwnPropertyDescriptors;var f=Object.getOwnPropertySymbols;var g=Object.prototype.hasOwnProperty,b=Object.prototype.propertyIsEnumerable;var m=(t,s,e)=>s in t?_(t,s,{enumerable:!0,configurable:!0,writable:!0,value:e}):t[s]=e,r=(t,s)=>{for(var e in s||(s={}))g.call(s,e)&&m(t,e,s[e]);if(f)for(var e of f(s))b.call(s,e)&&m(t,e,s[e]);return t},i=(t,s)=>F(t,d(s));import{_ as l,c as h,d as n}from"./bi.738.82.js";const A=(t,s,e)=>{const u=r({},s),{name:a}=t.target;t.target.value!==""?u[a]=t.target.value:delete u[a],e(r({},u))},I=t=>{const s=t.filter(e=>e.required===!0);return s.length>0?s.map(e=>({formField:"",systemeIOFormField:e.key})):[{formField:"",systemeIOFormField:""}]},P=t=>!((t!=null&&t.field_map?t.field_map.filter(e=>!e.formField||!e.systemeIOFormField||e.formField==="custom"&&!e.customValue||e.systemeIOFormField==="customFieldKey"&&!e.customFieldKey):[]).length>0),q=(t,s,e,u,a,c)=>{if(!t.api_key){e({api_key:t.api_key?"":l("API Key can't be empty","bit-integrations")});return}e({}),c(i(r({},a),{auth:!0}));const y={api_key:t.api_key};h(y,"systemeIO_authentication").then(o=>{if(o&&o.success){u(!0),c(i(r({},a),{auth:!1})),n.success(l("Authorized successfully","bit-integrations"));return}c(i(r({},a),{auth:!1})),n.error(l("Authorized failed, Please enter valid Sub Domain & API Key","bit-integrations"))})},K=(t,s,e)=>{e(i(r({},e),{tag:!0}));const u={api_key:t.api_key};h(u,"systemeIO_fetch_all_tags").then(a=>{if(a&&a.success){if(a.data){s(c=>(c.tags=a.data,c)),e(i(r({},e),{tag:!1})),n.success(l("Tags fetched successfully","bit-integrations"));return}e(i(r({},e),{tag:!1})),n.error(l("Tags Not Found!","bit-integrations"));return}e(i(r({},e),{tag:!1})),n.error(l("Tags fetching failed","bit-integrations"))})};export{I as a,P as c,K as g,A as h,q as s};