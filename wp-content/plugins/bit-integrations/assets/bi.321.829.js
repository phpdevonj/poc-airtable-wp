var k=Object.defineProperty,b=Object.defineProperties;var g=Object.getOwnPropertyDescriptors;var F=Object.getOwnPropertySymbols;var A=Object.prototype.hasOwnProperty,q=Object.prototype.propertyIsEnumerable;var _=(t,s,e)=>s in t?k(t,s,{enumerable:!0,configurable:!0,writable:!0,value:e}):t[s]=e,i=(t,s)=>{for(var e in s||(s={}))A.call(s,e)&&_(t,e,s[e]);if(F)for(var e of F(s))q.call(s,e)&&_(t,e,s[e]);return t},r=(t,s)=>b(t,g(s));import{_ as u,c as o,d as n}from"./bi.738.82.js";const p=(t,s,e)=>{const c=i({},s),{name:a}=t.target;t.target.value!==""?c[a]=t.target.value:delete c[a],e(i({},c))},w=t=>{const s=t==null?void 0:t.emailOctopusFields.filter(e=>e.required===!0);return s.length>0?s.map(e=>({formField:"",emailOctopusFormField:e.key})):[{formField:"",emailOctopusFormField:""}]},I=t=>!((t!=null&&t.field_map?t.field_map.filter(e=>!e.formField||!e.emailOctopusFormField||!e.formField==="custom"&&!e.customValue):[]).length>0),O=(t,s,e,c,a,l,h)=>{if(!t.auth_token){e({auth_token:t.auth_token?"":u("Api Key can't be empty","bit-integrations")});return}e({}),h==="authentication"&&l(r(i({},a),{auth:!0})),h==="refreshLists"&&l(r(i({},a),{lists:!0}));const m={auth_token:t.auth_token};o(m,"emailOctopus_authentication").then(f=>{if(f&&f.success){const d=i({},t);c(!0),h==="authentication"?(f.data&&(d.lists=f.data),l(r(i({},a),{auth:!1})),n.success(u("Authorized successfully","bit-integrations"))):h==="refreshLists"&&(f.data&&(d.lists=f.data),l(r(i({},a),{lists:!1})),n.success(u("All lists fectched successfully","bit-integrations"))),s(d);return}l(r(i({},a),{auth:!1})),n.error(u("Authorized failed, Please enter valid domain name & API key","bit-integrations"))})},v=(t,s,e)=>{e(r(i({},e),{customFields:!0}));const c={auth_token:t.auth_token,listId:t.selectedList};o(c,"emailOctopus_fetch_all_fields").then(a=>{if(a&&a.success){const l=i({},t);a.data&&(l.emailOctopusFields=a.data),s(l),e(r(i({},e),{customFields:!1})),e(r(i({},e),{emailOctopusFields:!0})),n.success(u("Fields fetched successfully","bit-integrations"));return}e(r(i({},e),{customFields:!1})),n.error(u("Fields fetching failed","bit-integrations"))})},z=(t,s,e)=>{e({tags:!0,emailOctopusFields:!0});const c={auth_token:t.auth_token,listId:t.selectedList};o(c,"emailOctopus_fetch_all_tags").then(a=>{if(a&&a.success){const l=i({},t);a.data&&(l.tags=a.data),s(l),e({tags:!1,emailOctopusFields:!0}),n.success(u("Tags fetched successfully","bit-integrations"));return}e({tags:!1,emailOctopusFields:!0}),n.error(u("Tags fetching failed","bit-integrations"))})};export{w as a,v as b,I as c,O as e,z as g,p as h};
