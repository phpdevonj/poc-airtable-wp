var k=Object.defineProperty;var h=Object.getOwnPropertySymbols;var C=Object.prototype.hasOwnProperty,_=Object.prototype.propertyIsEnumerable;var w=(s,t,e)=>t in s?k(s,t,{enumerable:!0,configurable:!0,writable:!0,value:e}):s[t]=e,v=(s,t)=>{for(var e in t||(t={}))C.call(t,e)&&w(s,e,t[e]);if(h)for(var e of h(t))_.call(t,e)&&w(s,e,t[e]);return s};import{u as I,r as c,j as i}from"./main-149.js";import{e as N,_ as F,I as B,F as q,d as m}from"./bi.738.82.js";import{S as E}from"./bi.384.918.js";import{h as L}from"./bi.30.705.js";import M from"./bi.887.266.js";import{T as P}from"./bi.111.706.js";import"./bi.452.742.js";function Q({formFields:s,setFlow:t,flow:e,allIntegURL:p}){const g=I(),[u,a]=c.useState(!1),[n,x]=c.useState(1),[j,f]=c.useState({show:!1}),y=[{key:"To",label:"To",required:!0},{key:"Body",label:"Message Body",required:!0}],[o,r]=c.useState({name:"Twilio",type:"Twilio",sid:"",token:"",body:"",to:"",from_num:"",field_map:[{formField:"",twilioField:"To"},{formField:"",twilioField:"Body"}],twilioFields:y}),T=()=>{a(!0),q(e,t,p,o,g,"","",a).then(d=>{var b;d.success?(m.success((b=d.data)==null?void 0:b.msg),g(p)):m.error(d.data||d)})},S=l=>{if(o.to===""&&o.body===""){m.error("Please select To and Body field , it is required");return}x(l)};return i.jsxs("div",{children:[i.jsx(N,{snack:j,setSnackbar:f}),i.jsx("div",{className:"txt-center mt-2",children:i.jsx(E,{step:3,active:n})}),i.jsx(M,{twilioConf:o,setTwilioConf:r,step:n,setstep:x,isLoading:u,setIsLoading:a,setSnackbar:f}),i.jsxs("div",{className:"btcd-stp-page",style:v({},n===2&&{width:900,height:"auto",overflow:"visible"}),children:[i.jsx(P,{formFields:s,handleInput:l=>L(l,o,r),twilioConf:o,setTwilioConf:r,isLoading:u,setIsLoading:a,setSnackbar:f}),i.jsxs("button",{onClick:()=>S(3),className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",children:[F("Next","bit-integrations")," "," ",i.jsx("div",{className:"btcd-icn icn-arrow_back rev-icn d-in-b"})]})]}),i.jsx(B,{step:n,saveConfig:()=>T(),isLoading:u,dataConf:o,setDataConf:r,formFields:s})]})}export{Q as default};
