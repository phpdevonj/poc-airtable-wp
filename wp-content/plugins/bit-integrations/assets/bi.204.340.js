var k=Object.defineProperty;var h=Object.getOwnPropertySymbols;var w=Object.prototype.hasOwnProperty,M=Object.prototype.propertyIsEnumerable;var g=(o,t,e)=>t in o?k(o,t,{enumerable:!0,configurable:!0,writable:!0,value:e}):o[t]=e,x=(o,t)=>{for(var e in t||(t={}))w.call(t,e)&&g(o,e,t[e]);if(h)for(var e of h(t))M.call(t,e)&&g(o,e,t[e]);return o};import{u as R,k as _,r as i,j as a}from"./main-149.js";import{a0 as N,e as Z,_ as b,I as E,s as T}from"./bi.738.82.js";import{S as z}from"./bi.384.918.js";import F from"./bi.708.226.js";import{h as L,c as P}from"./bi.722.699.js";import{Z as A}from"./bi.390.700.js";import"./bi.452.742.js";import"./bi.966.701.js";import"./bi.44.702.js";import"./bi.57.686.js";import"./bi.653.689.js";import"./bi.96.690.js";function Y({formFields:o,setFlow:t,flow:e,allIntegURL:C}){const v=R(),{formID:l}=_(),[d,r]=i.useState(!1),[c,u]=i.useState(1),[j,n]=i.useState({show:!1}),[f,S]=i.useState(0),[s,m]=i.useState({name:"Zoho CRM",type:"Zoho CRM",clientId:"",clientSecret:"",module:"",layout:"",field_map:[{formField:"",zohoFormField:""}],relatedlists:[],actions:{}});i.useEffect(()=>{window.opener&&N("zohoCRM")},[]);const y=()=>{T({flow:e,setFlow:t,allIntegURL:C,conf:s,navigate:v,setIsLoading:r,setSnackbar:n})},I=p=>{if(setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),!P(s)){n({show:!0,msg:b("Please map mandatory fields","bit-integrations")});return}s.module&&s.layout&&s.field_map.length>0&&u(p)};return a.jsxs("div",{children:[a.jsx(Z,{snack:j,setSnackbar:n}),a.jsx("div",{className:"txt-center mt-2",children:a.jsx(z,{step:3,active:c})}),a.jsx(F,{formID:l,crmConf:s,setCrmConf:m,step:c,setstep:u,isLoading:d,setIsLoading:r,setSnackbar:n}),a.jsxs("div",{className:"btcd-stp-page",style:x({},c===2&&{width:900,height:"auto",overflow:"visible"}),children:[a.jsx(A,{tab:f,settab:S,formID:l,formFields:o,handleInput:p=>L(p,f,s,m,l,r,n),crmConf:s,setCrmConf:m,isLoading:d,setIsLoading:r,setSnackbar:n}),a.jsxs("button",{onClick:()=>I(3),disabled:s.module===""||s.layout===""||s.field_map.length<1,className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",children:[b("Next","bit-integrations")," "," ",a.jsx("div",{className:"btcd-icn icn-arrow_back rev-icn d-in-b"})]})]}),a.jsx(E,{step:c,saveConfig:()=>y(),isLoading:d,dataConf:s,setDataConf:m,formFields:o})]})}export{Y as default};
