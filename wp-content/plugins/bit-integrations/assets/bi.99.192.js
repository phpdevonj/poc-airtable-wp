import{u,k as b,e as d,d as I,r as c,j as e}from"./main-149.js";import{h as _,$ as k,i as w,e as C,l,j as m,E as v,k as E,I as D,s as N}from"./bi.738.82.js";import{h as y}from"./bi.217.872.js";import{D as F}from"./bi.986.873.js";function A({allIntegURL:f}){const g=u(),{id:S,formID:p}=b(),[t,a]=d(_),[n,x]=d(k),i=I(w),[o,r]=c.useState(!1),[h,s]=c.useState({show:!1});return e.jsxs("div",{style:{width:900},children:[e.jsx(C,{snack:h,setSnackbar:s}),e.jsxs("div",{className:"flx mt-3",children:[e.jsx("b",{className:"wdt-200 d-in-b",children:l("Integration Name:","bit-integrations")}),e.jsx("input",{className:"btcd-paper-inp w-5",onChange:j=>y(j,t,a),name:"name",value:t.name,type:"text",placeholder:l("Integration Name...","bit-integrations")})]}),e.jsx("br",{}),!m(n.triggered_entity)&&e.jsx(v,{setSnackbar:s}),m(n.triggered_entity)&&e.jsx(E,{setSnackbar:s}),e.jsx(F,{formID:p,formFields:i,dripConf:t,setDripConf:a,isLoading:o,setIsLoading:r,setSnackbar:s}),e.jsx(D,{edit:!0,saveConfig:()=>N({flow:n,setFlow:x,allIntegURL:f,navigate:g,conf:t,edit:1,setIsLoading:r,setSnackbar:s}),disabled:t.field_map.length<1,isLoading:o,dataConf:t,setDataConf:a,formFields:i}),e.jsx("br",{})]})}export{A as default};