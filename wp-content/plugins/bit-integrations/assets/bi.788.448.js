import{u as j,k,r as i,j as t}from"./main-149.js";import{e as C,l as I,I as v,F as S}from"./bi.738.82.js";import{B as y}from"./bi.150.726.js";import{S as N}from"./bi.384.918.js";import _ from"./bi.456.316.js";import{c as M}from"./bi.852.880.js";import{C as w}from"./bi.326.881.js";import"./bi.452.742.js";function D({formFields:l,setFlow:d,flow:p,allIntegURL:u}){const g=j(),{formID:m}=k(),[n,o]=i.useState(!1),[s,c]=i.useState(1),[f,a]=i.useState({show:!1}),x=[{key:"Name",label:"Name",required:!1},{key:"EmailAddress",label:"Email Address",required:!0}],[e,r]=i.useState({name:"CampaignMonitor",type:"CampaignMonitor",client_id:"",api_key:"",field_map:[{formField:"",campaignMonitorField:""}],subscriberFields:x,actions:{}}),h=b=>{if(setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),b===3){if(!M(e)){a({show:!0,msg:"Please map all required fields to continue."});return}if(!(e!=null&&e.listId)){a({show:!0,msg:"Please select list to continue."});return}e.name!==""&&e.field_map.length>0&&c(3)}};return t.jsxs("div",{children:[t.jsx(C,{snack:f,setSnackbar:a}),t.jsx("div",{className:"txt-center mt-2",children:t.jsx(N,{step:3,active:s})}),t.jsx(_,{formID:m,campaignMonitorConf:e,setCampaignMonitorConf:r,step:s,setstep:c,isLoading:n,setIsLoading:o,setSnackbar:a}),t.jsxs("div",{className:"btcd-stp-page",style:{width:s===2&&900,height:s===2&&"auto"},children:[t.jsx(w,{formID:m,formFields:l,campaignMonitorConf:e,setCampaignMonitorConf:r,isLoading:n,setIsLoading:o,setSnackbar:a}),t.jsxs("button",{onClick:()=>h(3),disabled:!(e!=null&&e.listId)||e.field_map.length<1,className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",children:[I("Next","bit-integrations")," "," ",t.jsx(y,{className:"ml-1 rev-icn"})]})]}),t.jsx(v,{step:s,saveConfig:()=>S(p,d,u,e,g,"","",o),isLoading:n,dataConf:e,setDataConf:r,formFields:l})]})}export{D as default};
