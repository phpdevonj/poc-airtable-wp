var v=Object.defineProperty,C=Object.defineProperties;var E=Object.getOwnPropertyDescriptors;var g=Object.getOwnPropertySymbols;var k=Object.prototype.hasOwnProperty,w=Object.prototype.propertyIsEnumerable;var p=(a,e,t)=>e in a?v(a,e,{enumerable:!0,configurable:!0,writable:!0,value:t}):a[e]=t,u=(a,e)=>{for(var t in e||(e={}))k.call(e,t)&&p(a,t,e[t]);if(g)for(var t of g(e))w.call(e,t)&&p(a,t,e[t]);return a},x=(a,e)=>C(a,E(e));import{u as y,r as c,d as h,e as S,j as s}from"./main-149.js";import{$ as F,h as L,i as $,e as R,_ as j,j as N,E as U,k as W,I as D}from"./bi.738.82.js";import{h as K,s as M}from"./bi.251.821.js";import{N as T}from"./bi.953.822.js";import"./bi.236.799.js";import"./bi.653.689.js";import"./bi.96.690.js";function P({allIntegURL:a}){const e=y(),[t,o]=c.useState({show:!1}),i=h(F),[n,r]=S(L),[_,b]=c.useState({name:"",authKey:""}),m=h($),[d,f]=c.useState({auth:!1,list:!1,page:!1,field:!1,update:!1}),I=l=>{f(x(u({},d),{update:l}))};return s.jsxs("div",{style:{width:900},children:[s.jsx(R,{snack:t,setSnackbar:o}),s.jsxs("div",{className:"flx mt-3",children:[s.jsx("b",{className:"wdt-200 d-in-b",children:j("Integration Name:","bit-integrations")}),s.jsx("input",{className:"btcd-paper-inp w-5",name:"name",onChange:l=>K(l,n,r,_,b),value:n.name,type:"text",placeholder:j("Integration Name...","bit-integrations")})]}),s.jsxs("div",{className:"my-3",children:[!N(i.triggered_entity)&&s.jsx(U,{setSnackbar:o}),N(i.triggered_entity)&&s.jsx(W,{setSnackbar:o})]}),s.jsx(T,{notionConf:n,setNotionConf:r,formFields:m,loading:d,setLoading:f}),s.jsx(D,{edit:!0,saveConfig:()=>{M(i,a,n,e,{edit:1},I)},isLoading:d.update,disabled:n.field_map.length<1,dataConf:n,setDataConf:r,formFields:m})]})}export{P as default};