import{u as b,k as v,e as r,d as I,r as c,j as e}from"./main-149.js";import{h as w,$ as _,i as k,e as E,_ as d,j as l,E as C,k as N,I as y,s as D}from"./bi.738.82.js";import{h as F}from"./bi.87.695.js";import{O as S}from"./bi.507.696.js";function W({allIntegURL:m}){const x=b(),{id:f}=v(),[s,n]=r(w),[a,g]=r(_),h=I(k),[i,o]=c.useState(!1),[j,t]=c.useState({show:!1}),p=()=>{D({flow:a,setFlow:g,allIntegURL:m,conf:s,navigate:x,edit:1,setIsLoading:o,setSnackbar:t})};return e.jsxs("div",{style:{width:900},children:[e.jsx(E,{snack:j,setSnackbar:t}),e.jsxs("div",{className:"flx mt-3",children:[e.jsx("b",{className:"wdt-200 d-in-b",children:d("Integration Name:","bit-integrations")}),e.jsx("input",{className:"btcd-paper-inp w-5",onChange:u=>F(u,s,n),name:"name",value:s.name,type:"text",placeholder:d("Integration Name...","bit-integrations")})]}),e.jsx("br",{}),e.jsx("br",{}),!l(a.triggered_entity)&&e.jsx(C,{setSnackbar:t}),l(a.triggered_entity)&&e.jsx(N,{setSnackbar:t}),e.jsx(S,{flowID:f,formFields:h,oneDriveConf:s,setOneDriveConf:n,isLoading:i,setIsLoading:o,setSnackbar:t}),e.jsx(y,{edit:!0,saveConfig:p,disabled:!s.actions.attachments||!s.folder,isLoading:i}),e.jsx("br",{})]})}export{W as default};