import{u as I,k as b,e as m,r as c,d as _,j as e}from"./main-149.js";import{h as k,$ as w,i as C,e as S,_ as g,j as f,E as v,k as E,I as N,s as y}from"./bi.738.82.js";import{h}from"./bi.354.711.js";import{G as F}from"./bi.424.712.js";import"./bi.270.713.js";import"./bi.653.689.js";import"./bi.96.690.js";function P({allIntegURL:p}){const x=I(),{id:$,formID:r}=b(),[t,a]=m(k),[n,u]=m(w),[d,o]=c.useState(!1),[j,s]=c.useState({show:!1}),l=_(C);return e.jsxs("div",{style:{width:900},children:[e.jsx(S,{snack:j,setSnackbar:s}),e.jsxs("div",{className:"flx mt-3",children:[e.jsx("b",{className:"wdt-200 d-in-b",children:g("Integration Name:","bit-integrations")}),e.jsx("input",{className:"btcd-paper-inp w-5",onChange:i=>h(i,t,a),name:"name",value:t.name,type:"text",placeholder:g("Integration Name...","bit-integrations")})]}),e.jsx("br",{}),!f(n.triggered_entity)&&e.jsx(v,{setSnackbar:s}),f(n.triggered_entity)&&e.jsx(E,{setSnackbar:s}),e.jsx(F,{formID:r,formFields:l,handleInput:i=>h(i,t,a,r,o,s),sheetConf:t,setSheetConf:a,isLoading:d,setIsLoading:o,setSnackbar:s}),e.jsx(N,{edit:!0,saveConfig:()=>y({flow:n,setFlow:u,allIntegURL:p,conf:t,navigate:x,edit:1,setIsLoading:o,setSnackbar:s}),disabled:t.spreadsheetId===""||t.worksheetName===""||t.field_map.length<1,isLoading:d,dataConf:t,setDataConf:a,formFields:l}),e.jsx("br",{})]})}export{P as default};
