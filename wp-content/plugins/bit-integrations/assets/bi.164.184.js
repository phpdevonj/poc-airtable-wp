import{u as p,k as b,e as c,d as I,r as m,j as s}from"./main-149.js";import{h as _,$ as k,i as w,e as C,_ as l,j as x,E as v,k as y,I as E,s as L}from"./bi.738.82.js";import{h as f,M as S}from"./bi.866.858.js";function R({allIntegURL:g}){const u=p(),{formID:h}=b(),[t,a]=c(_),[n,N]=c(k),r=I(w),[o,d]=m.useState(!1),[j,e]=m.useState({show:!1});return s.jsxs("div",{style:{width:900},children:[s.jsx(C,{snack:j,setSnackbar:e}),s.jsxs("div",{className:"flx mt-3",children:[s.jsx("b",{className:"wdt-200 d-in-b",children:l("Integration Name:","bit-integrations")}),s.jsx("input",{className:"btcd-paper-inp w-5",onChange:i=>f(i,t,a),name:"name",value:t.name,type:"text",placeholder:l("Integration Name...","bit-integrations")})]}),s.jsx("br",{}),s.jsx("br",{}),!x(n.triggered_entity)&&s.jsx(v,{setSnackbar:e}),x(n.triggered_entity)&&s.jsx(y,{setSnackbar:e}),s.jsx(S,{formID:h,formFields:r,handleInput:i=>f(i,t,a),msLmsConf:t,setMsLmsConf:a,isLoading:o,setIsLoading:d,setSnackbar:e}),s.jsx(E,{edit:!0,saveConfig:()=>L({flow:n,allIntegURL:g,conf:t,navigate:u,edit:1,setIsLoading:d,setSnackbar:e}),disabled:t.mainAction===""||o,isLoading:o,dataConf:t,setDataConf:a,formFields:r}),s.jsx("br",{})]})}export{R as default};