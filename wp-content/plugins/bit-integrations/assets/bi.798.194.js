import{u,k as b,e as d,d as I,r as l,j as e}from"./main-149.js";import{h as _,$ as k,i as w,e as C,l as m,j as c,E as v,k as E,I as L,s as N}from"./bi.738.82.js";import{h as y}from"./bi.441.876.js";import{L as F}from"./bi.519.877.js";function A({allIntegURL:f}){const g=u(),{id:S,formID:x}=b(),[t,a]=d(_),[n,p]=d(k),i=I(w),[o,r]=l.useState(!1),[h,s]=l.useState({show:!1});return e.jsxs("div",{style:{width:900},children:[e.jsx(C,{snack:h,setSnackbar:s}),e.jsxs("div",{className:"flx mt-3",children:[e.jsx("b",{className:"wdt-200 d-in-b",children:m("Integration Name:","bit-integrations")}),e.jsx("input",{className:"btcd-paper-inp w-5",onChange:j=>y(j,t,a),name:"name",value:t.name,type:"text",placeholder:m("Integration Name...","bit-integrations")})]}),e.jsx("br",{}),!c(n.triggered_entity)&&e.jsx(v,{setSnackbar:s}),c(n.triggered_entity)&&e.jsx(E,{setSnackbar:s}),e.jsx(F,{formID:x,formFields:i,lemlistConf:t,setLemlistConf:a,isLoading:o,setIsLoading:r,setSnackbar:s}),e.jsx(L,{edit:!0,saveConfig:()=>N({flow:n,setFlow:p,allIntegURL:f,navigate:g,conf:t,edit:1,setIsLoading:r,setSnackbar:s}),disabled:t.field_map.length<1,isLoading:o,dataConf:t,setDataConf:a,formFields:i}),e.jsx("br",{})]})}export{A as default};