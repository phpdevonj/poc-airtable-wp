var k=Object.defineProperty;var v=Object.getOwnPropertySymbols;var y=Object.prototype.hasOwnProperty,I=Object.prototype.propertyIsEnumerable;var j=(s,e,t)=>e in s?k(s,e,{enumerable:!0,configurable:!0,writable:!0,value:t}):s[e]=t,L=(s,e)=>{for(var t in e||(e={}))y.call(e,t)&&j(s,t,e[t]);if(v)for(var t of v(e))I.call(e,t)&&j(s,t,e[t]);return s};import{u as N,r as o,j as a}from"./main-149.js";import{e as w,_ as F,I as E,F as T,d as m}from"./bi.738.82.js";import{S as P}from"./bi.384.918.js";import z from"./bi.948.267.js";import{h as A,c as B}from"./bi.677.780.js";import{M as D}from"./bi.283.781.js";import"./bi.452.742.js";import"./bi.653.689.js";import"./bi.96.690.js";function X({formFields:s,setFlow:e,flow:t,allIntegURL:p}){const f=N(),[_,u]=o.useState(!1),[g,h]=o.useState({list:!1,field:!1,auth:!1,group:!1}),[n,x]=o.useState(1),[S,d]=o.useState({show:!1}),[i,r]=o.useState({name:"MailerLite",type:"MailerLite",auth_token:"",field_map:[{formField:"",mailerLiteFormField:"email"}],mailer_lite_type:"",mailerLiteFields:[],groups:[],group_ids:[],actions:{}}),M=()=>{u(!0),T(t,e,p,i,f,"","",u).then(c=>{var b;c.success?(m.success((b=c.data)==null?void 0:b.msg),f(p)):m.error(c.data||c)})},C=l=>{if(setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),!B(i)){m.error("Please map mandatory fields");return}i.field_map.length>0&&x(l)};return a.jsxs("div",{children:[a.jsx(w,{snack:S,setSnackbar:d}),a.jsx("div",{className:"txt-center mt-2",children:a.jsx(P,{step:3,active:n})}),a.jsx(z,{mailerLiteConf:i,setMailerLiteConf:r,step:n,setstep:x,loading:g,setLoading:h,setSnackbar:d}),a.jsxs("div",{className:"btcd-stp-page",style:L({},n===2&&{width:900,height:"auto",overflow:"visible"}),children:[a.jsx(D,{formFields:s,handleInput:l=>A(l,i,r),mailerLiteConf:i,setMailerLiteConf:r,loading:g,setLoading:h,setSnackbar:d}),a.jsxs("button",{onClick:()=>C(3),className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",children:[F("Next","bit-integrations")," "," ",a.jsx("div",{className:"btcd-icn icn-arrow_back rev-icn d-in-b"})]})]}),a.jsx(E,{step:n,saveConfig:()=>M(),isLoading:_,dataConf:i,setDataConf:r,formFields:s})]})}export{X as default};
