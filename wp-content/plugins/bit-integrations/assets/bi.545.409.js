var j=Object.defineProperty,b=Object.defineProperties;var S=Object.getOwnPropertyDescriptors;var p=Object.getOwnPropertySymbols;var I=Object.prototype.hasOwnProperty,M=Object.prototype.propertyIsEnumerable;var m=(e,t,s)=>t in e?j(e,t,{enumerable:!0,configurable:!0,writable:!0,value:s}):e[t]=s,u=(e,t)=>{for(var s in t||(t={}))I.call(t,s)&&m(e,s,t[s]);if(p)for(var s of p(t))M.call(t,s)&&m(e,s,t[s]);return e},f=(e,t)=>b(e,S(t));import{u as y,r as d,j as i}from"./main-149.js";import{_ as N,I as _}from"./bi.738.82.js";import{S as C}from"./bi.600.917.js";import{S as L}from"./bi.384.918.js";import w from"./bi.712.278.js";import{n as k,d as E}from"./bi.944.806.js";import{M as F}from"./bi.979.807.js";import"./bi.452.742.js";import"./bi.236.799.js";import"./bi.653.689.js";import"./bi.96.690.js";function O({formFields:e,setFlow:t,flow:s,allIntegURL:g}){const x=y(),[o,c]=d.useState(1),[r,n]=d.useState({auth:!1,list:!1,page:!1}),[a,l]=d.useState({name:"Mailercloud",type:"Mailercloud",authKey:"",field_map:[{formFields:"",mailercloudFormField:""}],listId:"",contactType:"",actions:{}}),h=v=>{n(f(u({},r),{page:v}))};return i.jsxs("div",{children:[i.jsx("div",{className:"txt-center mt-2",children:i.jsx(L,{step:3,active:o})}),i.jsx(w,{mailercloudConf:a,setMailercloudConf:l,loading:r,setLoading:n,step:o,setStep:c}),i.jsxs(C,{step:o,stepNo:2,style:{width:900,height:"auto",overflow:"visible"},children:[i.jsx(F,{mailercloudConf:a,setMailercloudConf:l,formFields:e,loading:r,setLoading:n}),(a==null?void 0:a.listId)&&i.jsxs("button",{onClick:()=>k(a,c,3),disabled:!a.listId||a.field_map.length<1,className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",children:[N("Next")," ",i.jsx("div",{className:"btcd-icn icn-arrow_back rev-icn d-in-b"})]})]}),a.listId&&i.jsx(_,{step:o,saveConfig:()=>E(s,t,g,a,x,h),isLoading:r.page,dataConf:a,setDataConf:l,formFields:e})]})}export{O as default};
