import{u as b,k as I,e as r,d as _,r as c,j as s}from"./main-149.js";import{h as k,$ as w,i as C,e as v,_ as d,j as l,E,k as N,I as F,s as y}from"./bi.738.82.js";import{h as S,c as G}from"./bi.330.790.js";import{G as $}from"./bi.350.791.js";import"./bi.653.689.js";import"./bi.96.690.js";function P({allIntegURL:m}){const g=b(),{id:p}=I(),[t,a]=r(k),[n,x]=r(w),o=_(C),[i,f]=c.useState(!1),[h,e]=c.useState({show:!1}),j=()=>{y({flow:n,setFlow:x,allIntegURL:m,conf:t,navigate:g,edit:1,setIsLoading:f,setSnackbar:e})};return s.jsxs("div",{style:{width:900},className:"p-2",children:[s.jsx(v,{snack:h,setSnackbar:e}),s.jsxs("div",{className:"flx mt-3",children:[s.jsx("b",{className:"wdt-200 d-in-b",children:d("Integration Name:","bit-integrations")}),s.jsx("input",{className:"btcd-paper-inp w-5",onChange:u=>S(u,t,a),name:"name",value:t.name,type:"text",placeholder:d("Integration Name...","bit-integrations")})]}),s.jsx("br",{}),s.jsx("br",{}),!l(n.triggered_entity)&&s.jsx(E,{setSnackbar:e}),l(n.triggered_entity)&&s.jsx(N,{setSnackbar:e}),s.jsx($,{flowID:p,formFields:o,googleContactsConf:t,setGoogleContactsConf:a}),s.jsx(F,{edit:!0,saveConfig:j,disabled:!G(t==null?void 0:t.field_map)||t.mainAction===""||i,isLoading:i,dataConf:t,setDataConf:a,formFields:o}),s.jsx("br",{})]})}export{P as default};