import{u as h,k as j,e as a,d as w,r as i,j as s}from"./main-149.js";import{h as u,$ as p,i as b,e as F,j as n,E,k as v,s as I}from"./bi.738.82.js";import W from"./bi.583.243.js";import{W as _}from"./bi.326.725.js";import"./bi.150.726.js";function L({allIntegURL:r}){const c=h(),{id:S,formID:d}=j(),[t,l]=a(u),[e,m]=a(p),f=w(b),[x,o]=i.useState({show:!1}),[g,k]=i.useState(!1);return s.jsxs("div",{style:{width:900},children:[s.jsx(F,{snack:x,setSnackbar:o}),!n(e.triggered_entity)&&s.jsx(E,{setSnackbar:o}),n(e.triggered_entity)&&s.jsx(v,{setSnackbar:o}),s.jsx("div",{className:"mt-3",children:s.jsx(W,{formID:d,formFields:f,webHooks:t,setWebHooks:l,setSnackbar:o})}),s.jsx(_,{edit:!0,saveConfig:()=>I({flow:e,setFlow:m,allIntegURL:r,conf:t,navigate:c,edit:1,setIsLoading:k,setSnackbar:o}),isLoading:g}),s.jsx("br",{})]})}export{L as default};