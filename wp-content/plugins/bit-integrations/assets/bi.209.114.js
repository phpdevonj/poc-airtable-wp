import{u as p,k as j,r as a,e as i,d as u,j as s}from"./main-149.js";import{$ as b,i as h,h as w,e as E,j as n,E as v,k as I,s as W}from"./bi.738.82.js";import _ from"./bi.583.243.js";import{W as F}from"./bi.326.725.js";import"./bi.150.726.js";function L({allIntegURL:r}){const c=p(),{id:S,formID:d}=j(),[m,f]=a.useState(!1),[t,x]=i(b),g=u(h),[o,l]=i(w),[k,e]=a.useState({show:!1});return s.jsxs("div",{style:{width:900},children:[s.jsx(E,{snack:k,setSnackbar:e}),!n(t.triggered_entity)&&s.jsx(v,{setSnackbar:e}),n(t.triggered_entity)&&s.jsx(I,{setSnackbar:e}),s.jsx("div",{className:"mt-3",children:s.jsx(_,{formID:d,formFields:g,webHooks:o,setWebHooks:l,setSnackbar:e})}),s.jsx(F,{edit:!0,saveConfig:()=>W({flow:t,setFlow:x,allIntegURL:r,conf:o,navigate:c,edit:1,setIsLoading:f,setSnackbar:e}),isLoading:m}),s.jsx("br",{})]})}export{L as default};
