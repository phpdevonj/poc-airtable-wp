var T=Object.defineProperty;var h=Object.getOwnPropertySymbols;var I=Object.prototype.hasOwnProperty,R=Object.prototype.propertyIsEnumerable;var P=(a,t,r)=>t in a?T(a,t,{enumerable:!0,configurable:!0,writable:!0,value:r}):a[t]=r,C=(a,t)=>{for(var r in t||(t={}))I.call(t,r)&&P(a,r,t[r]);if(h)for(var r of h(t))R.call(t,r)&&P(a,r,t[r]);return a};import{u as B,r as i,j as l}from"./main-149.js";import{e as A,_ as D,I as E,F as M,d as s}from"./bi.738.82.js";import{S as z}from"./bi.384.918.js";import L from"./bi.182.325.js";import{h as Z,c as S}from"./bi.265.898.js";import{P as H}from"./bi.419.899.js";import"./bi.452.742.js";function Y({formFields:a,setFlow:t,flow:r,allIntegURL:p}){const y=B(),[f,c]=i.useState(!1),[m,k]=i.useState({}),[n,g]=i.useState(1),[_,b]=i.useState({show:!1}),x=[{key:"company",label:"Company",required:!0},{key:"vat",label:"VAT Number",required:!1},{key:"phonenumber",label:"Phone Number",required:!1},{key:"website",label:"Website",required:!1},{key:"address",label:"Address",required:!1},{key:"city",label:"City",required:!1},{key:"state",label:"State",required:!1},{key:"zip",label:"Zip",required:!1},{key:"country",label:"Country",required:!1},{key:"billing_street",label:"Billing Street",required:!1},{key:"billing_city",label:"Billing City",required:!1},{key:"billing_state",label:"Billing State",required:!1},{key:"billing_zip",label:"Billing Zip",required:!1},{key:"billing_country",label:"Billing Country",required:!1},{key:"shipping_street",label:"Shipping Street",required:!1},{key:"shipping_city",label:"Shipping City",required:!1},{key:"shipping_state",label:"Shipping State",required:!1},{key:"shipping_zip",label:"Shipping Zip",required:!1},{key:"shipping_country",label:"Shipping Country",required:!1}],j=[{key:"firstname",label:"First Name",required:!0},{key:"lastname",label:"Last Name",required:!0},{key:"email",label:"Email Address",required:!0},{key:"title",label:"Position",required:!1},{key:"phonenumber",label:"Phone Number",required:!1},{key:"password",label:"Password",required:!1}],N=[{key:"name",label:"Name",required:!0},{key:"title",label:"Position",required:!1},{key:"email",label:"Email Address",required:!1},{key:"website",label:"Website",required:!1},{key:"phonenumber",label:"Phone Number",required:!1},{key:"company",label:"Company",required:!1},{key:"address",label:"Address",required:!1},{key:"city",label:"City",required:!1},{key:"state",label:"State",required:!1},{key:"zip",label:"Zip",required:!1},{key:"country",label:"Country",required:!1},{key:"description",label:"Description",required:!1},{key:"custom_contact_date",label:"Date Contacted",required:!1}],v=[{key:"name",label:"Name",required:!0},{key:"start_date",label:"Start Date",required:!0},{key:"deadline",label:"Dead Line",required:!1},{key:"project_cost ",label:"project Cost",required:!1},{key:"estimated_hours",label:"Estimated Hours",required:!1},{key:"description",label:"Project Description",required:!1}],[e,o]=i.useState({name:"PerfexCRM",type:"PerfexCRM",api_token:"",domain:"",field_map:[{formField:"",perfexCRMFormField:""}],actionName:"",actionId:"",customerFields:x,contactFields:j,leadFields:N,projectFields:v,actions:{}}),w=()=>{c(!0),M(r,t,p,e,y,"","",c).then(u=>{var q;u.success?(s.success((q=u.data)==null?void 0:q.msg),y(p)):s.error(u.data||u)})},F=d=>{if(setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),!S(e)){s.error("Please map mandatory fields");return}if(e.actionName==="contact"&&!e.selectedCustomer){s.error("Please select a Customer");return}if(e.actionName==="project"){if(!e.selectedProjectStatus){s.error("Please select Project status");return}if(!e.selectedProjectType){s.error("Please select Project Related With...");return}if(!e.selectedbillingType){s.error("Please select a Billing type");return}if(!e.selectedCustomer){s.error("Please select a Customer");return}if(Number(e.selectedbillingType)===1&&!e.totalRate){s.error("Please select a Total Rate");return}if(Number(e.selectedbillingType)===2&&!e.ratePerHour){s.error("Please select a Rate Per Hour");return}}e.field_map.length>0&&g(d)};return l.jsxs("div",{children:[l.jsx(A,{snack:_,setSnackbar:b}),l.jsx("div",{className:"txt-center mt-2",children:l.jsx(z,{step:3,active:n})}),l.jsx(L,{perfexCRMConf:e,setPerfexCRMConf:o,step:n,setStep:g,loading:m,setLoading:k,setSnackbar:b}),l.jsxs("div",{className:"btcd-stp-page",style:C({},n===2&&{width:900,height:"auto",overflow:"visible"}),children:[l.jsx(H,{formFields:a,handleInput:d=>Z(d,e,o),perfexCRMConf:e,setPerfexCRMConf:o,loading:m,setLoading:k,isLoading:f,setIsLoading:c,setSnackbar:b}),(e==null?void 0:e.actionName)&&l.jsxs("button",{onClick:()=>F(3),disabled:!S(e),className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",children:[D("Next","bit-integrations")," "," ",l.jsx("div",{className:"btcd-icn icn-arrow_back rev-icn d-in-b"})]})]}),(e==null?void 0:e.actionName)&&l.jsx(E,{step:n,saveConfig:()=>w(),isLoading:f,dataConf:e,setDataConf:o,formFields:a})]})}export{Y as default};