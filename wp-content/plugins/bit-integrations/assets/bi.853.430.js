var I=Object.defineProperty;var v=Object.getOwnPropertySymbols;var y=Object.prototype.hasOwnProperty,N=Object.prototype.propertyIsEnumerable;var j=(s,e,t)=>e in s?I(s,e,{enumerable:!0,configurable:!0,writable:!0,value:t}):s[e]=t,S=(s,e)=>{for(var t in e||(e={}))y.call(e,t)&&j(s,t,e[t]);if(v)for(var t of v(e))N.call(e,t)&&j(s,t,e[t]);return s};import{u as T,r as n,j as i}from"./main-149.js";import{e as w,_ as E,I as L,F as B,d as m}from"./bi.738.82.js";import{S as M}from"./bi.384.918.js";import P from"./bi.900.299.js";import{h as z,c as F}from"./bi.122.847.js";import{A as D}from"./bi.49.848.js";import"./bi.452.742.js";import"./bi.653.689.js";import"./bi.96.690.js";function X({formFields:s,setFlow:e,flow:t,allIntegURL:p}){const f=T(),[A,u]=n.useState(!1),[o,g]=n.useState({auth:!1,customFields:!1,bases:!1,tables:!1,airtableFields:!1}),[r,h]=n.useState(1),[C,b]=n.useState({show:!1}),[a,l]=n.useState({name:"Airtable",type:"Airtable",auth_token:"",field_map:[{formField:"",airtableFormField:""}],airtableFields:[],bases:[],selectedBase:"",selectedTable:"",actions:{}}),_=()=>{u(!0),B(t,e,p,a,f,"","",u).then(d=>{var x;d.success?(m.success((x=d.data)==null?void 0:x.msg),f(p)):m.error(d.data||d)})},k=c=>{if(setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),!F(a)){m.error("Please map mandatory airtableFields");return}a.field_map.length>0&&h(c)};return i.jsxs("div",{children:[i.jsx(w,{snack:C,setSnackbar:b}),i.jsx("div",{className:"txt-center mt-2",children:i.jsx(M,{step:3,active:r})}),i.jsx(P,{airtableConf:a,setAirtableConf:l,step:r,setStep:h,loading:o,setLoading:g,setSnackbar:b}),i.jsxs("div",{className:"btcd-stp-page",style:S({},r===2&&{width:900,height:"auto",overflow:"visible"}),children:[i.jsx(D,{formFields:s,handleInput:c=>z(c,a,l),airtableConf:a,setAirtableConf:l,loading:o,setLoading:g,setSnackbar:b}),o.airtableFields&&a.selectedTable&&i.jsxs("button",{onClick:()=>k(3),disabled:!F(a),className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",children:[E("Next","bit-integrations")," "," ",i.jsx("div",{className:"btcd-icn icn-arrow_back rev-icn d-in-b"})]})]}),o.airtableFields&&a.selectedTable&&i.jsx(L,{step:r,saveConfig:()=>_(),isLoading:A,dataConf:a,setDataConf:l,formFields:s})]})}export{X as default};