var d=Object.defineProperty,m=Object.defineProperties;var F=Object.getOwnPropertyDescriptors;var h=Object.getOwnPropertySymbols;var b=Object.prototype.hasOwnProperty,p=Object.prototype.propertyIsEnumerable;var y=(t,s,e)=>s in t?d(t,s,{enumerable:!0,configurable:!0,writable:!0,value:e}):t[s]=e,r=(t,s)=>{for(var e in s||(s={}))b.call(s,e)&&y(t,e,s[e]);if(h)for(var e of h(s))p.call(s,e)&&y(t,e,s[e]);return t},n=(t,s)=>m(t,F(s));import{_ as u,c as _,d as l}from"./bi.738.82.js";const A=(t,s,e)=>{const i=r({},s),{name:a}=t.target;t.target.value!==""?i[a]=t.target.value:delete i[a],e(r({},i))},P=t=>{const s=t.filter(e=>e.required===!0);return s.length>0?s.map(e=>({formField:"",demioFormField:e.key})):[{formField:"",demioFormField:""}]},S=t=>!((t!=null&&t.field_map?t.field_map.filter(e=>!e.formField||!e.demioFormField||e.formField==="custom"&&!e.customValue||e.demioFormField==="customFieldKey"&&!e.customFieldKey):[]).length>0),q=(t,s,e,i,a,c)=>{if(!t.api_key||!t.api_secret){e({api_key:t.api_key?"":u("API Key can't be empty","bit-integrations"),api_secret:t.api_secret?"":u("API Secret can't be empty","bit-integrations")});return}e({}),c(n(r({},a),{auth:!0}));const o={api_key:t.api_key,api_secret:t.api_secret};_(o,"demio_authentication").then(f=>{if(f&&f.success){i(!0),c(n(r({},a),{auth:!1})),l.success(u("Authorized successfully","bit-integrations"));return}c(n(r({},a),{auth:!1})),l.error(u("Authorized failed, Please enter valid Sub Domain & API Key","bit-integrations"))})},I=(t,s,e)=>{e(n(r({},e),{event:!0}));const i={api_key:t.api_key,api_secret:t.api_secret};_(i,"demio_fetch_all_events").then(a=>{if(a&&a.success){if(a.data){s(c=>(c.events=a.data,c)),e(n(r({},e),{event:!1})),l.success(u("Events fetched successfully","bit-integrations"));return}e(n(r({},e),{event:!1})),l.error(u("Events Not Found!","bit-integrations"));return}e(n(r({},e),{event:!1})),l.error(u("Events fetching failed","bit-integrations"))})},K=(t,s,e,i)=>{i(n(r({},i),{session:!0}));const a={api_key:t.api_key,api_secret:t.api_secret,event_id:e};_(a,"demio_fetch_all_sessions").then(c=>{if(c&&c.success){if(c.data){s(o=>(o.sessions=c.data,o)),i(n(r({},i),{session:!1})),l.success(u("Sessions fetched successfully","bit-integrations"));return}i(n(r({},i),{session:!1})),l.error(u("Sessions Not Found!","bit-integrations"));return}i(n(r({},i),{session:!1})),l.error(u("Sessions fetching failed","bit-integrations"))})};export{K as a,P as b,S as c,q as d,I as g,A as h};
