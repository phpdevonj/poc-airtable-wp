var I=Object.defineProperty;var y=Object.getOwnPropertySymbols;var w=Object.prototype.hasOwnProperty,E=Object.prototype.propertyIsEnumerable;var x=(t,a,s)=>a in t?I(t,a,{enumerable:!0,configurable:!0,writable:!0,value:s}):t[a]=s,v=(t,a)=>{for(var s in a||(a={}))w.call(a,s)&&x(t,s,a[s]);if(y)for(var s of y(a))E.call(a,s)&&x(t,s,a[s]);return t};import{u as z,r as n,j as i}from"./main-149.js";import{e as A,_ as L,I as M,F as T,d as c}from"./bi.738.82.js";import{S as D}from"./bi.384.918.js";import B from"./bi.950.310.js";import{h as R,c as N}from"./bi.711.868.js";import{C as W}from"./bi.803.869.js";import"./bi.452.742.js";function Y({formFields:t,setFlow:a,flow:s,allIntegURL:u}){const p=z(),[j,f]=n.useState(!1),[b,g]=n.useState({}),[r,h]=n.useState(1),[q,m]=n.useState({show:!1}),C=[{key:"name",label:"Name",required:!0},{key:"phone",label:"Phone",required:!1},{key:"email",label:"Email",required:!1},{key:"website",label:"Website",required:!1},{key:"address",label:"Address",required:!1}],S=[{key:"name",label:"Name",required:!0},{key:"designation",label:"Designation",required:!1},{key:"phone",label:"Phone",required:!1},{key:"email",label:"Email",required:!1},{key:"address",label:"Address",required:!1}],P=[{key:"name",label:"Name",required:!0},{key:"size",label:"Size",required:!1}],[e,l]=n.useState({name:"ClinchPad",type:"ClinchPad",api_key:"",field_map:[{formField:"",clinchPadFormField:""}],actionName:"",organizationFields:C,contactFields:S,leadFields:P,actions:{}}),_=()=>{f(!0),T(s,a,u,e,p,"","",f).then(d=>{var k;d.success?(c.success((k=d.data)==null?void 0:k.msg),p(u)):c.error(d.data||d)})},F=o=>{if(setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),!N(e)){c.error("Please map mandatory fields");return}if(e.actionName==="lead"&&!e.selectedCRMPipeline){c.error("Please select a pipeline");return}e.field_map.length>0&&h(o)};return i.jsxs("div",{children:[i.jsx(A,{snack:q,setSnackbar:m}),i.jsx("div",{className:"txt-center mt-2",children:i.jsx(D,{step:3,active:r})}),i.jsx(B,{clinchPadConf:e,setClinchPadConf:l,step:r,setStep:h,loading:b,setLoading:g,setSnackbar:m}),i.jsxs("div",{className:"btcd-stp-page",style:v({},r===2&&{width:900,height:"auto",overflow:"visible"}),children:[i.jsx(W,{formFields:t,handleInput:o=>R(o,e,l),clinchPadConf:e,setClinchPadConf:l,loading:b,setLoading:g,setSnackbar:m}),(e==null?void 0:e.actionName)&&i.jsxs("button",{onClick:()=>F(3),disabled:!N(e),className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",children:[L("Next","bit-integrations")," "," ",i.jsx("div",{className:"btcd-icn icn-arrow_back rev-icn d-in-b"})]})]}),(e==null?void 0:e.actionName)&&i.jsx(M,{step:r,saveConfig:()=>_(),isLoading:j,dataConf:e,setDataConf:l,formFields:t})]})}export{Y as default};
