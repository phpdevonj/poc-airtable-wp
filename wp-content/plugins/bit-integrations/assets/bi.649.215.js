import{u as _,k,e as l,r as i,d as w,j as t}from"./main-149.js";import{$ as y,h as F,i as N,e as S,_ as r,j as m,E as v,k as E,I as R,X as f,s as L}from"./bi.738.82.js";import{h as g,c as u}from"./bi.784.900.js";import{O as M}from"./bi.666.901.js";function D({allIntegURL:h}){const p=_();k();const[a,H]=l(y),[e,n]=l(F),[x,d]=i.useState(!1),[j,C]=i.useState({}),[b,s]=i.useState({show:!1}),c=w(N),I=()=>{if(!u(e)){s({show:!0,msg:r("Please map mandatory fields","bit-integrations")});return}if(e.actionName==="customer"&&!e.selectedCustomerType){f.error("Please select Customer Type");return}if(e.actionName==="lead"&&!e.selectedLeadStatus){f.error("Please select Lead Status");return}L({flow:a,allIntegURL:h,conf:e,navigate:p,edit:1,setIsLoading:d,setSnackbar:s})};return t.jsxs("div",{style:{width:900},children:[t.jsx(S,{snack:b,setSnackbar:s}),t.jsxs("div",{className:"flx mt-3",children:[t.jsx("b",{className:"wdt-200 d-in-b",children:r("Integration Name:","bit-integrations")}),t.jsx("input",{className:"btcd-paper-inp w-5",onChange:o=>g(o,e,n),name:"name",value:e.name,type:"text",placeholder:r("Integration Name...","bit-integrations")})]}),t.jsx("br",{}),!m(a.triggered_entity)&&t.jsx(v,{setSnackbar:s}),m(a.triggered_entity)&&t.jsx(E,{setSnackbar:s}),t.jsx(M,{formID:a.triggered_entity_id,formFields:c,handleInput:o=>g(o,e,n),oneHashCRMConf:e,setOneHashCRMConf:n,loading:j,setLoading:C,setIsLoading:d,setSnackbar:s}),t.jsx(R,{edit:!0,saveConfig:I,disabled:!u(e),isLoading:x,dataConf:e,setDataConf:n,formFields:c}),t.jsx("br",{})]})}export{D as default};
