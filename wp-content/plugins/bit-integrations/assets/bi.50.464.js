import{u as h,k as j,r as o,j as e}from"./main-149.js";import{e as b,F as S}from"./bi.738.82.js";import{S as L}from"./bi.384.918.js";import I from"./bi.583.243.js";import{W as T}from"./bi.326.725.js";import{T as r,t as y}from"./bi.452.742.js";import"./bi.150.726.js";function C({formFields:i,setFlow:c,flow:d,allIntegURL:m}){const u=h(),{formID:p}=j(),[s,l]=o.useState(1),[g,n]=o.useState({show:!1}),[k,x]=o.useState(!1),[a,v]=o.useState({name:"AdvancedFormIntegration Web Hooks",type:"AdvancedFormIntegration",method:"POST",url:""}),{afi:t}=y;return e.jsxs("div",{children:[e.jsx(b,{snack:g,setSnackbar:n}),e.jsx("div",{className:"txt-center mt-2",children:e.jsx(L,{step:2,active:s})}),e.jsxs("div",{className:"btcd-stp-page",style:{width:s===1&&1100,height:s===1&&"auto"},children:[(t==null?void 0:t.youTubeLink)&&e.jsx(r,{title:t==null?void 0:t.title,youTubeLink:t==null?void 0:t.youTubeLink}),(t==null?void 0:t.docLink)&&e.jsx(r,{title:t==null?void 0:t.title,docLink:t==null?void 0:t.docLink}),e.jsx(I,{formID:p,formFields:i,webHooks:a,setWebHooks:v,step:s,setStep:l,setSnackbar:n,create:!0})]}),e.jsx("div",{className:"btcd-stp-page",style:{width:s===2&&"100%",height:s===2&&"auto"},children:e.jsx(T,{step:s,saveConfig:()=>S(d,c,m,a,u,"","",x),isLoading:k})})]})}export{C as default};