import{u as j,k,r as n,j as e}from"./main-149.js";import{e as B,l as I,I as v,F as S}from"./bi.738.82.js";import{B as b}from"./bi.150.726.js";import{S as M}from"./bi.384.918.js";import N from"./bi.883.295.js";import{c as _}from"./bi.956.840.js";import{B as w}from"./bi.95.841.js";import"./bi.452.742.js";function q({formFields:c,setFlow:d,flow:p,allIntegURL:u}){const f=j(),{formID:l}=k(),[i,o]=n.useState(!1),[s,m]=n.useState(1),[g,a]=n.useState({show:!1}),[t,r]=n.useState({name:"BenchMark",type:"BenchMark",api_secret:"",field_map:[{formField:"",benchMarkField:""}],actions:{}}),h=x=>{if(setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),x===3){if(!_(t)){a({show:!0,msg:"Please map all required fields to continue."});return}if(!(t!=null&&t.listId)){a({show:!0,msg:"Please select list to continue."});return}t.name!==""&&t.field_map.length>0&&m(3)}};return e.jsxs("div",{children:[e.jsx(B,{snack:g,setSnackbar:a}),e.jsx("div",{className:"txt-center mt-2",children:e.jsx(M,{step:3,active:s})}),e.jsx(N,{formID:l,benchMarkConf:t,setBenchMarkConf:r,step:s,setstep:m,isLoading:i,setIsLoading:o,setSnackbar:a}),e.jsxs("div",{className:"btcd-stp-page",style:{width:s===2&&900,height:s===2&&"auto"},children:[e.jsx(w,{formID:l,formFields:c,benchMarkConf:t,setBenchMarkConf:r,isLoading:i,setIsLoading:o,setSnackbar:a}),e.jsxs("button",{onClick:()=>h(3),disabled:!(t!=null&&t.listId)||t.field_map.length<1,className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",children:[I("Next","bit-integrations")," "," ",e.jsx(b,{className:"ml-1 rev-icn"})]})]}),e.jsx(v,{step:s,saveConfig:()=>S(p,d,u,t,f,"","",o),isLoading:i,dataConf:t,setDataConf:r,formFields:c})]})}export{q as default};
