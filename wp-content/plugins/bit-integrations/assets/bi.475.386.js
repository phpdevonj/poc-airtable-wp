var C=Object.defineProperty;var y=Object.getOwnPropertySymbols;var I=Object.prototype.hasOwnProperty,N=Object.prototype.propertyIsEnumerable;var b=(s,e,t)=>e in s?C(s,e,{enumerable:!0,configurable:!0,writable:!0,value:t}):s[e]=t,S=(s,e)=>{for(var t in e||(e={}))I.call(e,t)&&b(s,t,e[t]);if(y)for(var t of y(e))N.call(e,t)&&b(s,t,e[t]);return s};import{u as w,r as l,j as a}from"./main-149.js";import{e as E,_ as F,I as T,F as q,d as u}from"./bi.738.82.js";import{S as L}from"./bi.384.918.js";import M from"./bi.726.257.js";import{S as P,h as z,c as A}from"./bi.269.761.js";import"./bi.150.726.js";import"./bi.452.742.js";import"./bi.653.689.js";import"./bi.96.690.js";function W({formFields:s,setFlow:e,flow:t,allIntegURL:f}){const g=w(),[m,i]=l.useState(!1),[o,h]=l.useState(1),[v,p]=l.useState({show:!1}),j=[{key:"email",label:"Email",required:!0},{key:"name",label:"Name",required:!1}],[n,r]=l.useState({name:"Sendy",type:"Sendy",api_key:"",sendy_url:"",field_map:[{formField:"",sendyField:""}],subscriberFields:j,actions:{}}),k=()=>{i(!0),q(t,e,f,n,g,"","",i).then(d=>{var x;d.success?(u.success((x=d.data)==null?void 0:x.msg),g(f)):u.error(d.data||d)})},_=c=>{if(setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),!A(n)){u.error("Please map mandatory fields");return}n.field_map.length>0&&h(c)};return a.jsxs("div",{children:[a.jsx(E,{snack:v,setSnackbar:p}),a.jsx("div",{className:"txt-center mt-2",children:a.jsx(L,{step:3,active:o})}),a.jsx(M,{sendyConf:n,setSendyConf:r,step:o,setstep:h,isLoading:m,setIsLoading:i,setSnackbar:p}),a.jsxs("div",{className:"btcd-stp-page",style:S({},o===2&&{width:900,height:"auto",overflow:"visible"}),children:[a.jsx(P,{formFields:s,handleInput:c=>z(c,n,r),sendyConf:n,setSendyConf:r,isLoading:m,setIsLoading:i,setSnackbar:p}),a.jsxs("button",{onClick:()=>_(3),className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",children:[F("Next","bit-integrations")," "," ",a.jsx("div",{className:"btcd-icn icn-arrow_back rev-icn d-in-b"})]})]}),a.jsx(T,{step:o,saveConfig:()=>k(),isLoading:m,dataConf:n,setDataConf:r,formFields:s})]})}export{W as default};
