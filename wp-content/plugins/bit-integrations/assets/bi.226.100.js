import{u,k as C,e as c,d as b,r as d,j as t}from"./main-149.js";import{h as v,$ as I,i as _,e as k,l as m,j as l,E as w,k as E,I as N,s as y}from"./bi.738.82.js";import{h as A}from"./bi.473.723.js";import{A as F}from"./bi.206.724.js";import"./bi.653.689.js";import"./bi.96.690.js";function P({allIntegURL:g}){const f=u(),{id:S,formID:p}=C(),[e,s]=c(v),[n,x]=c(I),i=b(_),[o,r]=d.useState(!1),[h,a]=d.useState({show:!1});return t.jsxs("div",{style:{width:900},children:[t.jsx(k,{snack:h,setSnackbar:a}),t.jsxs("div",{className:"flx mt-3",children:[t.jsx("b",{className:"wdt-200 d-in-b",children:m("Integration Name:","bit-integrations")}),t.jsx("input",{className:"btcd-paper-inp w-5",onChange:j=>A(j,e,s),name:"name",value:e.name,type:"text",placeholder:m("Integration Name...","bit-integrations")})]}),t.jsx("br",{}),!l(n.triggered_entity)&&t.jsx(w,{setSnackbar:a}),l(n.triggered_entity)&&t.jsx(E,{setSnackbar:a}),t.jsx(F,{formID:p,formFields:i,activeCampaingConf:e,setActiveCampaingConf:s,isLoading:o,setIsLoading:r,setSnackbar:a}),t.jsx(N,{edit:!0,saveConfig:()=>y({flow:n,setFlow:x,allIntegURL:g,navigate:f,conf:e,edit:1,setIsLoading:r,setSnackbar:a}),disabled:e.field_map.length<1,isLoading:o,dataConf:e,setDataConf:s,formFields:i}),t.jsx("br",{})]})}export{P as default};