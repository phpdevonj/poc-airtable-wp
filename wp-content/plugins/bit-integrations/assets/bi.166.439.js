var j=Object.defineProperty;var u=Object.getOwnPropertySymbols;var I=Object.prototype.hasOwnProperty,P=Object.prototype.propertyIsEnumerable;var f=(s,e,t)=>e in s?j(s,e,{enumerable:!0,configurable:!0,writable:!0,value:t}):s[e]=t,g=(s,e)=>{for(var t in e||(e={}))I.call(e,t)&&f(s,t,e[t]);if(u)for(var t of u(e))P.call(e,t)&&f(s,t,e[t]);return s};import{u as S,k as q,r as l,j as a}from"./main-149.js";import{e as N,_,I as F,s as w}from"./bi.738.82.js";import{S as A}from"./bi.384.918.js";import{P as B,h as E,c as M}from"./bi.658.863.js";import{B as D}from"./bi.150.726.js";import L from"./bi.291.307.js";import"./bi.236.799.js";import"./bi.653.689.js";import"./bi.96.690.js";import"./bi.452.742.js";function W({formFields:s,setFlow:e,flow:t,allIntegURL:b}){const v=S(),{formID:x}=q(),[c,m]=l.useState(!1),[r,d]=l.useState(1),[k,i]=l.useState({show:!1}),y=[{key:"first_name",label:"First Name",required:!0},{key:"email",label:"Email",required:!0},{key:"org_name",label:"Org Name",required:!1},{key:"person_id",label:"Person Id ",required:!1},{key:"org_id",label:"Org Id",required:!1},{key:"budget",label:"Budget",required:!1},{key:"currency",label:"Currency",required:!1},{key:"desc",label:"Desc",required:!1},{key:"note",label:"Note",required:!1}],C=[{key:"1",label:"Create lead"}],[o,n]=l.useState({name:"Propovoice CRM",type:"Propovoice CRM",mainAction:"",field_map:[{formField:"",propovoiceCrmFormField:""}],leadFields:y,allActions:C,actions:{}}),h=p=>{setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),d(3)};return a.jsxs("div",{children:[a.jsx(N,{snack:k,setSnackbar:i}),a.jsx("div",{className:"txt-center mt-2",children:a.jsx(A,{step:3,active:r})}),a.jsx(L,{formID:x,propovoiceCrmConf:o,setPropovoiceCrmConf:n,step:r,setStep:d,isLoading:c,setIsLoading:m,setSnackbar:i}),a.jsxs("div",{className:"btcd-stp-page",style:g({},r===2&&{width:900,height:"auto",overflow:"visible"}),children:[a.jsx(B,{formFields:s,handleInput:p=>E(p,o,n),propovoiceCrmConf:o,setPropovoiceCrmConf:n,isLoading:c,setIsLoading:m,setSnackbar:i}),a.jsxs("button",{onClick:()=>h(),disabled:!M(o),className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",children:[_("Next","bit-integrations"),a.jsx(D,{className:"ml-1 rev-icn"})]})]}),a.jsx(F,{step:r,saveConfig:()=>w({flow:t,setFlow:e,allIntegURL:b,conf:o,navigate:v,setIsLoading:m,setSnackbar:i}),isLoading:c,dataConf:o,setDataConf:n,formFields:s})]})}export{W as default};
