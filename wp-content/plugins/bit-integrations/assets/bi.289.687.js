var m=Object.defineProperty,f=Object.defineProperties;var y=Object.getOwnPropertyDescriptors;var F=Object.getOwnPropertySymbols;var k=Object.prototype.hasOwnProperty,g=Object.prototype.propertyIsEnumerable;var _=(e,r,t)=>r in e?m(e,r,{enumerable:!0,configurable:!0,writable:!0,value:t}):e[r]=t,s=(e,r)=>{for(var t in r||(r={}))k.call(r,t)&&_(e,t,r[t]);if(F)for(var t of F(r))g.call(r,t)&&_(e,t,r[t]);return e},l=(e,r)=>f(e,y(r));import{_ as d,c as b,d as p}from"./bi.738.82.js";const q=(e,r,t,h,i,u,n,c)=>{const a=s({},r),{name:o}=e.target;e.target.value!==""?a[o]=e.target.value:delete a[o],t(s({},a))},w=e=>{const r=e==null?void 0:e.omniSend_fields.filter(t=>t.required===!0);return r.length>0?r.map(t=>({formField:"",omniSendFormField:t.key})):[{formField:"",omniSendFormField:""}]},v=e=>!((e!=null&&e.field_map?e.field_map.filter(t=>!t.formField||!t.omniSendFormField||!t.formField==="custom"&&!t.customValue):[]).length>0),M=(e,r,t,h,i,u)=>{if(!e.api_key){t({api_key:e.api_key?"":d("Api Key can't be empty","bit-integrations")});return}t({}),u(l(s({},i),{auth:!0}));const n={api_key:e.api_key};b(n,"Omnisend_authorization").then(c=>{if(c&&c.success){const a=s({},e);r(a),h(!0),u(l(s({},i),{auth:!1})),p.success(d("Authorized successfully","bit-integrations"));return}u(l(s({},i),{auth:!1})),p.error(d("Authorized failed","bit-integrations"))})};export{M as a,v as c,w as g,q as h};
