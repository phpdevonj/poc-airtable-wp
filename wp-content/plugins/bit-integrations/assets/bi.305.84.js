import{u,k as b,e as d,d as I,r as l,j as e}from"./main-149.js";import{h as S,$ as _,i as k,e as w,_ as m,j as p,E as C,k as v,I as E,s as N}from"./bi.738.82.js";import{h as x,S as W}from"./bi.795.691.js";import"./bi.653.689.js";import"./bi.96.690.js";function D({allIntegURL:f}){const g=u(),{formID:h}=b(),[t,a]=d(S),[n,y]=d(_),r=I(k),[i,c]=l.useState(!1),[j,s]=l.useState({show:!1});return e.jsxs("div",{style:{width:900},children:[e.jsx(w,{snack:j,setSnackbar:s}),e.jsxs("div",{className:"flx mt-3",children:[e.jsx("b",{className:"wdt-200 d-in-b",children:m("Integration Name:","bit-integrations")}),e.jsx("input",{className:"btcd-paper-inp w-5",onChange:o=>x(o,t,a),name:"name",value:t.name,type:"text",placeholder:m("Integration Name...","bit-integrations")})]}),e.jsx("br",{}),e.jsx("br",{}),!p(n.triggered_entity)&&e.jsx(C,{setSnackbar:s}),p(n.triggered_entity)&&e.jsx(v,{setSnackbar:s}),e.jsx(W,{formID:h,formFields:r,handleInput:o=>x(o,t,a),sliceWpConf:t,setSliceWpConf:a,isLoading:i,setIsLoading:c,setSnackbar:s}),e.jsx(E,{edit:!0,saveConfig:()=>N({flow:n,allIntegURL:f,conf:t,navigate:g,edit:1,setIsLoading:c,setSnackbar:s}),disabled:!t.mainAction||i,isLoading:i,dataConf:t,setDataConf:a,formFields:r}),e.jsx("br",{})]})}export{D as default};
