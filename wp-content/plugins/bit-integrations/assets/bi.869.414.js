var F=Object.defineProperty;var x=Object.getOwnPropertySymbols;var I=Object.prototype.hasOwnProperty,N=Object.prototype.propertyIsEnumerable;var k=(a,t,s)=>t in a?F(a,t,{enumerable:!0,configurable:!0,writable:!0,value:s}):a[t]=s,v=(a,t)=>{for(var s in t||(t={}))I.call(t,s)&&k(a,s,t[s]);if(x)for(var s of x(t))N.call(t,s)&&k(a,s,t[s]);return a};import{u as w,r,j as i}from"./main-149.js";import{e as C,_ as E,I as L,F as T,d as u}from"./bi.738.82.js";import{S as z}from"./bi.384.918.js";import A from"./bi.486.283.js";import{h as B,c as P}from"./bi.479.817.js";import{M as R}from"./bi.696.818.js";import"./bi.452.742.js";import"./bi.653.689.js";import"./bi.96.690.js";function X({formFields:a,setFlow:t,flow:s,allIntegURL:m}){const p=w(),[j,f]=r.useState(!1),[b,g]=r.useState({auth:!1,groups:!1,customFields:!1}),[l,y]=r.useState(1),[S,c]=r.useState({show:!1}),q=[{key:"email",label:"Email",required:!0},{key:"name",label:"Name",required:!1},{key:"address",label:"Address",required:!1},{key:"city",label:"City",required:!1},{key:"state",label:"State",required:!1},{key:"country",label:"Country",required:!1},{key:"birthday",label:"Birthday",required:!1},{key:"website",label:"Website",required:!1},{key:"locale",label:"Locale",required:!1},{key:"time_zone",label:"Time Zone",required:!1}],[e,o]=r.useState({name:"MailRelay",type:"MailRelay",auth_token:"",domain:"",field_map:[{formField:"",mailRelayFormField:""}],staticFields:q,status:"",customFields:[],groups:[],selectedGroups:[],actions:{}}),M=()=>{f(!0),T(s,t,m,e,p,"","",f).then(d=>{var h;d.success?(u.success((h=d.data)==null?void 0:h.msg),p(m)):u.error(d.data||d)})},_=n=>{if(setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),!P(e)){u.error("Please map mandatory fields");return}e.field_map.length>0&&y(n)};return i.jsxs("div",{children:[i.jsx(C,{snack:S,setSnackbar:c}),i.jsx("div",{className:"txt-center mt-2",children:i.jsx(z,{step:3,active:l})}),i.jsx(A,{mailRelayConf:e,setMailRelayConf:o,step:l,setStep:y,loading:b,setLoading:g,setSnackbar:c}),i.jsxs("div",{className:"btcd-stp-page",style:v({},l===2&&{width:900,height:"auto",overflow:"visible"}),children:[i.jsx(R,{formFields:a,handleInput:n=>B(n,e,o),mailRelayConf:e,setMailRelayConf:o,loading:b,setLoading:g,setSnackbar:c}),(e==null?void 0:e.status)&&i.jsxs("button",{onClick:()=>_(3),disabled:!(e!=null&&e.status),className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",children:[E("Next","bit-integrations")," "," ",i.jsx("div",{className:"btcd-icn icn-arrow_back rev-icn d-in-b"})]})]}),(e==null?void 0:e.status)&&i.jsx(L,{step:l,saveConfig:()=>M(),isLoading:j,dataConf:e,setDataConf:o,formFields:a})]})}export{X as default};
