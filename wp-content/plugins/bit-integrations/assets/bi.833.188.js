import{u,k as b,e as c,d as I,r as l,j as t}from"./main-149.js";import{h as M,$ as _,i as k,e as w,_ as m,j as f,E as C,k as v,I as E,s as N}from"./bi.738.82.js";import{M as y}from"./bi.466.864.js";import{h as x}from"./bi.385.865.js";import"./bi.653.689.js";import"./bi.96.690.js";function W({allIntegURL:g}){const p=u(),{formID:h}=b(),[e,a]=c(M),[n,F]=c(_),d=I(k),[i,o]=l.useState(!1),[j,s]=l.useState({show:!1});return t.jsxs("div",{style:{width:900},children:[t.jsx(w,{snack:j,setSnackbar:s}),t.jsxs("div",{className:"flx mt-3",children:[t.jsx("b",{className:"wdt-200 d-in-b",children:m("Integration Name:","bit-integrations")}),t.jsx("input",{className:"btcd-paper-inp w-5",onChange:r=>x(r,e,a),name:"name",value:e.name,type:"text",placeholder:m("Integration Name...","bit-integrations")})]}),t.jsx("br",{}),t.jsx("br",{}),!f(n.triggered_entity)&&t.jsx(C,{setSnackbar:s}),f(n.triggered_entity)&&t.jsx(v,{setSnackbar:s}),t.jsx(y,{formID:h,formFields:d,handleInput:r=>x(r,e,a,o),mailMintConf:e,setMailMintConf:a,isLoading:i,setIsLoading:o,setSnackbar:s}),t.jsx(E,{edit:!0,saveConfig:()=>N({flow:n,allIntegURL:g,conf:e,navigate:p,edit:1,setIsLoading:o,setSnackbar:s}),disabled:!e.mainAction||i,isLoading:i,dataConf:e,setDataConf:a,formFields:d}),t.jsx("br",{})]})}export{W as default};
