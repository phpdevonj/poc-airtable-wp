import{u as b,k as I,e as m,r as o,d as _,j as e}from"./main-149.js";import{$ as k,h as w,i as C,e as F,_ as r,j as c,E as L,k as v,I as y,s as E}from"./bi.738.82.js";import{h as f,c as M}from"./bi.677.780.js";import{M as N}from"./bi.283.781.js";import"./bi.653.689.js";import"./bi.96.690.js";function q({allIntegURL:g}){const p=b();I();const[a,S]=m(k),[t,i]=m(w),[u,$]=o.useState(!1),[x,d]=o.useState({list:!1,field:!1,auth:!1,group:!1}),[h,s]=o.useState({show:!1}),l=_(C),j=()=>{if(!M(t)){s({show:!0,msg:r("Please map mandatory fields","bit-integrations")});return}E({flow:a,allIntegURL:g,conf:t,navigate:p,edit:1,setLoading:d,setSnackbar:s})};return e.jsxs("div",{style:{width:900},children:[e.jsx(F,{snack:h,setSnackbar:s}),e.jsxs("div",{className:"flx mt-3",children:[e.jsx("b",{className:"wdt-200 d-in-b",children:r("Integration Name:","bit-integrations")}),e.jsx("input",{className:"btcd-paper-inp w-5",onChange:n=>f(n,t,i),name:"name",value:t.name,type:"text",placeholder:r("Integration Name...","bit-integrations")})]}),e.jsx("br",{}),!c(a.triggered_entity)&&e.jsx(L,{setSnackbar:s}),c(a.triggered_entity)&&e.jsx(v,{setSnackbar:s}),e.jsx(N,{formID:a.triggered_entity_id,formFields:l,handleInput:n=>f(n,t,i),mailerLiteConf:t,setMailerLiteConf:i,loading:x,setLoading:d,setSnackbar:s}),e.jsx(y,{edit:!0,saveConfig:j,disabled:t.field_map.length<1,isLoading:u,dataConf:t,setDataConf:i,formFields:l}),e.jsx("br",{})]})}export{q as default};
