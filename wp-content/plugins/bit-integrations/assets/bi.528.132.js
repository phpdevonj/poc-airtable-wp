import{u as I,k as b,e as c,r as l,d as _,j as e}from"./main-149.js";import{h as k,$ as w,i as C,e as v,_ as m,j as f,E,k as N,I as S,s as y}from"./bi.738.82.js";import{h as g}from"./bi.286.762.js";import{K as F}from"./bi.602.763.js";import"./bi.653.689.js";import"./bi.96.690.js";function G({allIntegURL:p}){const x=I(),{id:$,formID:h}=b(),[t,a]=c(k),[n,u]=c(w),[i,r]=l.useState(!1),[j,s]=l.useState({show:!1}),d=_(C);return e.jsxs("div",{style:{width:900},children:[e.jsx(v,{snack:j,setSnackbar:s}),e.jsxs("div",{className:"flx mt-3",children:[e.jsx("b",{className:"wdt-200 d-in-b",children:m("Integration Name:","bit-integrations")}),e.jsx("input",{className:"btcd-paper-inp w-5",onChange:o=>g(o,t,a),name:"name",value:t.name,type:"text",placeholder:m("Integration Name...","bit-integrations")})]}),e.jsx("br",{}),!f(n.triggered_entity)&&e.jsx(E,{setSnackbar:s}),f(n.triggered_entity)&&e.jsx(N,{setSnackbar:s}),e.jsx(F,{formID:h,formFields:d,handleInput:o=>g(o,t,a),keapConf:t,setKeapConf:a,isLoading:i,setIsLoading:r,setSnackbar:s}),e.jsx(S,{edit:!0,saveConfig:()=>y({flow:n,setFlow:u,allIntegURL:p,conf:t,navigate:x,edit:1,setIsLoading:r,setSnackbar:s}),disabled:t.field_map.length<2,isLoading:i,dataConf:t,setDataConf:a,formFields:d}),e.jsx("br",{})]})}export{G as default};
