var D=Object.defineProperty;var g=Object.getOwnPropertySymbols;var _=Object.prototype.hasOwnProperty,q=Object.prototype.propertyIsEnumerable;var b=(a,t,s)=>t in a?D(a,t,{enumerable:!0,configurable:!0,writable:!0,value:s}):a[t]=s,x=(a,t)=>{for(var s in t||(t={}))_.call(t,s)&&b(a,s,t[s]);if(g)for(var s of g(t))q.call(t,s)&&b(a,s,t[s]);return a};import{u as w,k as I,r,j as o}from"./main-149.js";import{e as y,_ as c,I as N,s as P}from"./bi.738.82.js";import{S as A}from"./bi.384.918.js";import E from"./bi.922.301.js";import{h as L,c as T,a as M}from"./bi.7.852.js";import{F as R}from"./bi.275.853.js";import"./bi.452.742.js";import"./bi.653.689.js";import"./bi.96.690.js";function W({formFields:a,setFlow:t,flow:s,allIntegURL:S}){const F=w(),{formID:u}=I(),[m,n]=r.useState(!1),[l,p]=r.useState(1),[v,i]=r.useState({show:!1}),[h,j]=r.useState(0),[e,d]=r.useState({name:"FreshSales",type:"FreshSales",api_key:"",bundle_alias:"",default:{modules:{Account:{required:!0,requiredFields:[]},Deal:{required:!0,requiredFields:[]},Contact:{required:!0,requiredFields:[]},Product:{requiredFields:[]}}},moduleData:{module:""},field_map:[{formField:"",freshSalesFormField:""}],relatedlists:[],actions:{}}),C=()=>{P({flow:s,setFlow:t,allIntegURL:S,conf:e,navigate:F,setIsLoading:n,setSnackbar:i})},k=f=>{if(setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),!T(e)){i({show:!0,msg:c("Please map mandatory fields","bit-integrations")});return}if(!M(e)){["Deal","Contact"].includes(e.moduleData.module)&&i({show:!0,msg:c("Please select a account or a contact","bit-integrations")}),e.moduleData.module==="Contacts"&&i({show:!0,msg:c("Please select a account","bit-integrations")});return}e.moduleData.module&&e.field_map.length>0&&p(f)};return o.jsxs("div",{children:[o.jsx(y,{snack:v,setSnackbar:i}),o.jsx("div",{className:"txt-center mt-2",children:o.jsx(A,{step:3,active:l})}),o.jsx(E,{formID:u,freshSalesConf:e,setFreshSalesConf:d,step:l,setstep:p,isLoading:m,setIsLoading:n,setSnackbar:i}),o.jsxs("div",{className:"btcd-stp-page",style:x({},l===2&&{width:900,height:"auto",overflow:"visible"}),children:[o.jsx(R,{tab:h,settab:j,formID:u,formFields:a,handleInput:f=>L(f,h,e,d,u,n,i),freshSalesConf:e,setFreshSalesConf:d,isLoading:m,setIsLoading:n,setSnackbar:i}),o.jsxs("button",{onClick:()=>k(3),disabled:e.moduleData.module===""||e.field_map.length<1,className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",children:[c("Next","bit-integrations")," "," ",o.jsx("div",{className:"btcd-icn icn-arrow_back rev-icn d-in-b"})]})]}),o.jsx(N,{step:l,saveConfig:()=>C(),isLoading:m,dataConf:e,setDataConf:d,formFields:a})]})}export{W as default};
