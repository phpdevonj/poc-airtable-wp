import{u as j,k as u,e as c,d as b,r as d,j as s}from"./main-149.js";import{h as k,$ as I,i as _,e as S,_ as l,j as m,E as w,k as C,I as v,s as E}from"./bi.738.82.js";import{S as N}from"./bi.279.745.js";import{h as y}from"./bi.273.746.js";/* empty css          */function A({allIntegURL:f}){const x=j(),{formID:g}=u(),[e,a]=c(k),[n,F]=c(I),i=b(_),[o,r]=d.useState(!1),[p,t]=d.useState({show:!1});return s.jsxs("div",{style:{width:900},children:[s.jsx(S,{snack:p,setSnackbar:t}),s.jsxs("div",{className:"flx mt-3",children:[s.jsx("b",{className:"wdt-200 d-in-b",children:l("Integration Name:","bit-integrations")}),s.jsx("input",{className:"btcd-paper-inp w-5",onChange:h=>y(h,e,a),name:"name",value:e.name,type:"text",placeholder:l("Integration Name...","bit-integrations")})]}),s.jsx("br",{}),s.jsx("br",{}),!m(n.triggered_entity)&&s.jsx(w,{setSnackbar:t}),m(n.triggered_entity)&&s.jsx(C,{setSnackbar:t}),s.jsx(N,{formID:g,formFields:i,slackConf:e,setSlackConf:a,isLoading:o,setIsLoading:r,setSnackbar:t}),s.jsx(v,{edit:!0,saveConfig:()=>E({flow:n,allIntegURL:f,conf:e,navigate:x,edit:1,setIsLoading:r,setSnackbar:t}),disabled:e.channel_id===""||o,isLoading:o,dataConf:e,setDataConf:a,formFields:i}),s.jsx("br",{})]})}export{A as default};
