import{u as _,k as F,e as l,r as o,d as k,j as e}from"./main-149.js";import{$ as w,h as C,i as v,e as y,_ as r,j as c,E,k as N,I as S,s as A}from"./bi.738.82.js";import{h as m,c as f}from"./bi.122.847.js";import{A as L}from"./bi.49.848.js";import"./bi.653.689.js";import"./bi.96.690.js";function q({allIntegURL:g}){const p=_();F();const[a,$]=l(w),[t,i]=l(C),[u,x]=o.useState(!1),[b,h]=o.useState({auth:!1,customFields:!1,bases:!1,tables:!1,airtableFields:!0}),[j,s]=o.useState({show:!1}),d=k(v),I=()=>{if(!f(t)){s({show:!0,msg:r("Please map mandatory fields","bit-integrations")});return}A({flow:a,allIntegURL:g,conf:t,navigate:p,edit:1,setIsLoading:x,setSnackbar:s})};return e.jsxs("div",{style:{width:900},children:[e.jsx(y,{snack:j,setSnackbar:s}),e.jsxs("div",{className:"flx mt-3",children:[e.jsx("b",{className:"wdt-200 d-in-b",children:r("Integration Name:","bit-integrations")}),e.jsx("input",{className:"btcd-paper-inp w-5",onChange:n=>m(n,t,i),name:"name",value:t.name,type:"text",placeholder:r("Integration Name...","bit-integrations")})]}),e.jsx("br",{}),!c(a.triggered_entity)&&e.jsx(E,{setSnackbar:s}),c(a.triggered_entity)&&e.jsx(N,{setSnackbar:s}),e.jsx(L,{formID:a.triggered_entity_id,formFields:d,handleInput:n=>m(n,t,i),airtableConf:t,setAirtableConf:i,loading:b,setLoading:h,setSnackbar:s}),e.jsx(S,{edit:!0,saveConfig:I,disabled:!f(t),isLoading:u,dataConf:t,setDataConf:i,formFields:d}),e.jsx("br",{})]})}export{q as default};
