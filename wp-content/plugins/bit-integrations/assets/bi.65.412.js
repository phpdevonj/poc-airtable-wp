var G=Object.defineProperty;var v=Object.getOwnPropertySymbols;var N=Object.prototype.hasOwnProperty,w=Object.prototype.propertyIsEnumerable;var j=(a,t,s)=>t in a?G(a,t,{enumerable:!0,configurable:!0,writable:!0,value:s}):a[t]=s,I=(a,t)=>{for(var s in t||(t={}))N.call(t,s)&&j(a,s,t[s]);if(v)for(var s of v(t))w.call(t,s)&&j(a,s,t[s]);return a};import{u as E,r as n,j as i}from"./main-149.js";import{e as T,_ as L,I as R,F as q,d as m}from"./bi.738.82.js";import{S as C}from"./bi.384.918.js";import M from"./bi.687.281.js";import{h as P,c as z}from"./bi.561.812.js";import{G as A}from"./bi.322.813.js";import"./bi.452.742.js";import"./bi.653.689.js";import"./bi.96.690.js";function Y({formFields:a,setFlow:t,flow:s,allIntegURL:p}){const u=E(),[S,g]=n.useState(!1),[f,h]=n.useState({list:!1,field:!1,auth:!1,tags:!1,customFields:!1}),[o,x]=n.useState(1),[k,d]=n.useState({show:!1}),y=[{key:"email",label:"Email",required:!0},{key:"name",label:"Name",required:!1}],[e,r]=n.useState({name:"GetResponse",type:"GetResponse",auth_token:"",field_map:[{formField:"",getResponseFormField:""}],contactsFields:y,campaignId:"",getResponseFields:[],campaigns:[],tags:[],selectedTags:[],actions:{}}),_=()=>{g(!0),q(s,t,p,e,u,"","",g).then(l=>{var b;l.success?(m.success((b=l.data)==null?void 0:b.msg),u(p)):m.error(l.data||l)})},F=c=>{if(setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),!z(e)){m.error("Please map mandatory fields");return}e.field_map.length>0&&x(c)};return i.jsxs("div",{children:[i.jsx(T,{snack:k,setSnackbar:d}),i.jsx("div",{className:"txt-center mt-2",children:i.jsx(C,{step:3,active:o})}),i.jsx(M,{getResponseConf:e,setGetResponseConf:r,step:o,setstep:x,loading:f,setLoading:h,setSnackbar:d}),i.jsxs("div",{className:"btcd-stp-page",style:I({},o===2&&{width:900,height:"auto",overflow:"visible"}),children:[i.jsx(A,{formFields:a,handleInput:c=>P(c,e,r),getResponseConf:e,setGetResponseConf:r,loading:f,setLoading:h,setSnackbar:d}),(e==null?void 0:e.campaignId)&&i.jsxs("button",{onClick:()=>F(3),disabled:!(e!=null&&e.campaignId),className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",children:[L("Next","bit-integrations")," "," ",i.jsx("div",{className:"btcd-icn icn-arrow_back rev-icn d-in-b"})]})]}),(e==null?void 0:e.campaignId)&&i.jsx(R,{step:o,saveConfig:()=>_(),isLoading:S,dataConf:e,setDataConf:r,formFields:a})]})}export{Y as default};
