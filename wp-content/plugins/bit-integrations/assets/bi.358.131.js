import{u as j,k as b,e as c,r as m,d as I,j as e}from"./main-149.js";import{$ as _,h as y,i as k,e as w,_ as o,j as f,E as S,k as C,I as F,s as v}from"./bi.738.82.js";import{h as g,S as E,c as N}from"./bi.269.761.js";import"./bi.653.689.js";import"./bi.96.690.js";function W({allIntegURL:p}){const x=j();b();const[a,$]=c(_),[t,n]=c(y),[r,d]=m.useState(!1),[h,s]=m.useState({show:!1}),l=I(k),u=()=>{if(!N(t)){s({show:!0,msg:o("Please map mandatory fields","bit-integrations")});return}v({flow:a,allIntegURL:p,conf:t,navigate:x,edit:1,setIsLoading:d,setSnackbar:s})};return e.jsxs("div",{style:{width:900},children:[e.jsx(w,{snack:h,setSnackbar:s}),e.jsxs("div",{className:"flx mt-3",children:[e.jsx("b",{className:"wdt-200 d-in-b",children:o("Integration Name:","bit-integrations")}),e.jsx("input",{className:"btcd-paper-inp w-5",onChange:i=>g(i,t,n),name:"name",value:t.name,type:"text",placeholder:o("Integration Name...","bit-integrations")})]}),e.jsx("br",{}),!f(a.triggered_entity)&&e.jsx(S,{setSnackbar:s}),f(a.triggered_entity)&&e.jsx(C,{setSnackbar:s}),e.jsx(E,{formID:a.triggered_entity_id,formFields:l,handleInput:i=>g(i,t,n),sendyConf:t,setSendyConf:n,isLoading:r,setIsLoading:d,setSnackbar:s}),e.jsx(F,{edit:!0,saveConfig:u,disabled:t.field_map.length<1,isLoading:r,dataConf:t,setDataConf:n,formFields:l}),e.jsx("br",{})]})}export{W as default};
