var y=Object.defineProperty;var x=Object.getOwnPropertySymbols;var I=Object.prototype.hasOwnProperty,N=Object.prototype.propertyIsEnumerable;var b=(s,e,t)=>e in s?y(s,e,{enumerable:!0,configurable:!0,writable:!0,value:t}):s[e]=t,w=(s,e)=>{for(var t in e||(e={}))I.call(e,t)&&b(s,t,e[t]);if(x)for(var t of x(e))N.call(e,t)&&b(s,t,e[t]);return s};import{u as H,r,j as o}from"./main-149.js";import{e as z,_ as E,I as F,F as T,d as h}from"./bi.738.82.js";import{S as W}from"./bi.384.918.js";import L from"./bi.293.300.js";import{s as M,c as v}from"./bi.328.849.js";import{Z as P}from"./bi.604.850.js";import"./bi.452.742.js";import"./bi.653.689.js";import"./bi.96.690.js";function V({formFields:s,setFlow:e,flow:t,allIntegURL:l}){const m=H(),[j,p]=r.useState(!1),[n,f]=r.useState({auth:!1,header:!1,workbooks:!1,worksheets:!1,workSheetHeaders:!1}),[i,S]=r.useState(1),[C,u]=r.useState({show:!1}),[a,d]=r.useState({name:"Zoho Sheet",type:"Zoho Sheet",dataCenter:"",clientId:"",clientSecret:"",field_map:[{formField:"",zohoSheetFormField:""}],workbooks:[],worksheets:[],workSheetHeaders:[],selectedWorkbook:"",selectedWorksheet:"",headerRow:1,actions:{}});r.useEffect(()=>{window.opener&&M("zohoSheet")},[]);const Z=()=>{p(!0),T(t,e,l,a,m,"","",p).then(c=>{var k;c.success?(h.success((k=c.data)==null?void 0:k.msg),m(l)):h.error(c.data||c)})},_=g=>{if(setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),!v(a)){h.error("Please map mandatory workSheetHeaders");return}a.field_map.length>0&&S(g)};return o.jsxs("div",{children:[o.jsx(z,{snack:C,setSnackbar:u}),o.jsx("div",{className:"txt-center mt-2",children:o.jsx(W,{step:3,active:i})}),o.jsx(L,{zohoSheetConf:a,setZohoSheetConf:d,step:i,setStep:S,loading:n,setLoading:f,setSnackbar:u}),o.jsxs("div",{className:"btcd-stp-page",style:w({},i===2&&{width:900,height:"auto",overflow:"visible"}),children:[o.jsx(P,{formFields:s,zohoSheetConf:a,setZohoSheetConf:d,loading:n,setLoading:f}),n.workSheetHeaders&&a.selectedWorksheet&&o.jsxs("button",{onClick:()=>_(3),disabled:!v(a),className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",children:[E("Next","bit-integrations")," "," ",o.jsx("div",{className:"btcd-icn icn-arrow_back rev-icn d-in-b"})]})]}),n.workSheetHeaders&&a.selectedWorksheet&&o.jsx(F,{step:i,saveConfig:()=>Z(),isLoading:j,dataConf:a,setDataConf:d,formFields:s})]})}export{V as default};