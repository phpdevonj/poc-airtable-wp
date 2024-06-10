var N=Object.defineProperty;var j=Object.getOwnPropertySymbols;var T=Object.prototype.hasOwnProperty,k=Object.prototype.propertyIsEnumerable;var L=(a,n,s)=>n in a?N(a,n,{enumerable:!0,configurable:!0,writable:!0,value:s}):a[n]=s,v=(a,n)=>{for(var s in n||(n={}))T.call(n,s)&&L(a,s,n[s]);if(j)for(var s of j(n))k.call(n,s)&&L(a,s,n[s]);return a};import{r as d,j as e,u as y}from"./main-149.js";import{_ as h,L as C,c as w,B as I,e as z,I as M,s as A}from"./bi.738.82.js";import{S as _}from"./bi.384.918.js";import{B}from"./bi.150.726.js";import{T as S,t as E}from"./bi.452.742.js";import{T as D,h as F}from"./bi.445.731.js";function H({tutorlmsConf:a,setTutorlmsConf:n,step:s,setStep:p,setSnackbar:b}){const[i,r]=d.useState(!1),[o,g]=d.useState(!1),[x,l]=d.useState(!1),{tutorlms:t}=E,u=()=>{g("auth"),w({},"tutor_authorize").then(c=>{c!=null&&c.success&&(r(!0),b({show:!0,msg:h("Connected with Tutor LMS Successfully","bit-integrations")})),g(!1),l(!0)})},f=c=>{const m=I(a);m[c.target.name]=c.target.value,n(m)};return e.jsxs("div",{className:"btcd-stp-page",style:{width:s===1&&900,height:s===1&&"auto"},children:[(t==null?void 0:t.youTubeLink)&&e.jsx(S,{title:t==null?void 0:t.title,youTubeLink:t==null?void 0:t.youTubeLink}),(t==null?void 0:t.docLink)&&e.jsx(S,{title:t==null?void 0:t.title,docLink:t==null?void 0:t.docLink}),e.jsx("div",{className:"mt-3",children:e.jsx("b",{children:h("Integration Name:","bit-integrations")})}),e.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:f,name:"name",value:a.name,type:"text",placeholder:h("Integration Name...","bit-integrations")}),o==="auth"&&e.jsxs("div",{className:"flx mt-5",children:[e.jsx(C,{size:25,clr:"#022217",className:"mr-2"}),"Checking if Tutor LMS is active!!!"]}),x&&!i&&!o&&e.jsxs("div",{className:"flx mt-5",style:{color:"red"},children:[e.jsx("span",{className:"btcd-icn mr-2",style:{fontSize:30,marginTop:-5},children:"×"}),"Tutor LMS plugin must be activated to integrate with Bit Integrations."]}),!i&&e.jsx("button",{onClick:u,className:"btn btcd-btn-lg green sh-sm flx mt-5",type:"button",children:h("Connect","bit-integrations")}),i&&e.jsxs("button",{onClick:()=>p(2),className:"btn btcd-btn-lg green sh-sm flx mt-5",type:"button",disabled:!i,children:[h("Next","bit-integrations"),e.jsx(B,{className:"ml-1 rev-icn"})]})]})}function O({formFields:a,setFlow:n,flow:s,allIntegURL:p}){const b=y(),[i,r]=d.useState(!1),[o,g]=d.useState(1),[x,l]=d.useState({show:!1}),[t,u]=d.useState({name:"Tutor LMS",type:"Tutor Lms",field_map:[{formField:"",tutorField:""}],actions:{},actionData:{}}),f=()=>{r(!0),A({flow:s,setFlow:n,allIntegURL:p,conf:t,navigate:b,setIsLoading:r,setSnackbar:l})},c=m=>{setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),g(m)};return e.jsxs("div",{children:[e.jsx(z,{snack:x,setSnackbar:l}),e.jsx("div",{className:"txt-center mt-2",children:e.jsx(_,{step:3,active:o})}),e.jsx(H,{tutorlmsConf:t,setTutorlmsConf:u,step:o,setStep:g,isLoading:i,setIsLoading:r,setSnackbar:l}),e.jsxs("div",{className:"btcd-stp-page",style:v({},o===2&&{width:900,height:"auto",minHeight:o===2&&"260px",overflow:"visible"}),children:[e.jsx(D,{formFields:a,handleInput:m=>F(m,t,u,r,l),tutorlmsConf:t,setTutorlmsConf:u,isLoading:i,setIsLoading:r,setSnackbar:l}),e.jsxs("button",{onClick:()=>c(3),className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",children:[h("Next","bit-integrations")," "," ",e.jsx("div",{className:"btcd-icn icn-arrow_back rev-icn d-in-b"})]})]}),e.jsx(M,{step:o,saveConfig:()=>f(),isLoading:i,dataConf:t,setDataConf:u,formFields:a})]})}export{O as default};
