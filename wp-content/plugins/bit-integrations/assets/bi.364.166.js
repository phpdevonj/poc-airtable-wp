import{u as I,e as c,r as o,d as _,j as e}from"./main-149.js";import{$ as S,h as w,i as k,e as C,_ as r,j as f,E as F,k as v,I as y,s as E}from"./bi.738.82.js";import{h as m,c as g}from"./bi.483.825.js";import{S as N}from"./bi.723.826.js";import"./bi.653.689.js";import"./bi.96.690.js";function P({allIntegURL:p}){const x=I(),[a,G]=c(S),[t,n]=c(w),[h,L]=o.useState(!1),[u,d]=o.useState({list:!1,field:!1,auth:!1,tags:!1}),[j,s]=o.useState({show:!1}),l=_(k),b=()=>{if(!g(t)){s({show:!0,msg:r("Please map mandatory fields","bit-integrations")});return}E({flow:a,allIntegURL:p,conf:t,navigate:x,edit:1,setLoading:d,setSnackbar:s})};return e.jsxs("div",{style:{width:900},children:[e.jsx(C,{snack:j,setSnackbar:s}),e.jsxs("div",{className:"flx mt-3",children:[e.jsx("b",{className:"wdt-200 d-in-b",children:r("Integration Name:","bit-integrations")}),e.jsx("input",{className:"btcd-paper-inp w-5",onChange:i=>m(i,t,n),name:"name",value:t.name,type:"text",placeholder:r("Integration Name...","bit-integrations")})]}),e.jsx("br",{}),!f(a.triggered_entity)&&e.jsx(F,{setSnackbar:s}),f(a.triggered_entity)&&e.jsx(v,{setSnackbar:s}),e.jsx(N,{formID:a.triggered_entity_id,formFields:l,handleInput:i=>m(i,t,n),sendGridConf:t,setSendGridConf:n,loading:u,setLoading:d,setSnackbar:s}),e.jsx(y,{edit:!0,saveConfig:b,disabled:!g(t),isLoading:h,dataConf:t,setDataConf:n,formFields:l}),e.jsx("br",{})]})}export{P as default};
