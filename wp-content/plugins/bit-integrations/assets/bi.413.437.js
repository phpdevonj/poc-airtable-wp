var I=Object.defineProperty;var g=Object.getOwnPropertySymbols;var L=Object.prototype.hasOwnProperty,M=Object.prototype.propertyIsEnumerable;var h=(t,a,l)=>a in t?I(t,a,{enumerable:!0,configurable:!0,writable:!0,value:l}):t[a]=l,x=(t,a)=>{for(var l in a||(a={}))L.call(a,l)&&h(t,l,a[l]);if(g)for(var l of g(a))M.call(a,l)&&h(t,l,a[l]);return t};import{u as T,r as i,j as r}from"./main-149.js";import{e as E,_ as Z,I as D,F as R,d as s}from"./bi.738.82.js";import{S as A}from"./bi.384.918.js";import O from"./bi.448.305.js";import{h as B,c as S}from"./bi.203.859.js";import{Z as V}from"./bi.203.860.js";import"./bi.452.742.js";function Y({formFields:t,setFlow:a,flow:l,allIntegURL:f}){const k=T(),[_,b]=i.useState(!1),[y,m]=i.useState({}),[d,q]=i.useState(1),[C,c]=i.useState({show:!1}),N=[{key:"name",label:"Name",required:!0},{key:"phone",label:"Phone",required:!1},{key:"mobile",label:"Mobile",required:!1},{key:"email",label:"Email",required:!1},{key:"description",label:"Description",required:!1},{key:"line1",label:"Street",required:!1},{key:"city",label:"City",required:!1},{key:"state",label:"State",required:!1},{key:"postal_code",label:"Postal Code",required:!1},{key:"country",label:"Country",required:!1},{key:"fax",label:"Fax",required:!1},{key:"facebook",label:"Facebook",required:!1},{key:"skype",label:"Skype",required:!1},{key:"linkedin",label:"LinkedIn",required:!1},{key:"twitter",label:"Twitter",required:!1}],F=[{key:"first_name",label:"First Name",required:!1},{key:"last_name",label:"Last Name",required:!0},{key:"title",label:"Title",required:!1},{key:"phone",label:"Phone",required:!1},{key:"mobile",label:"Mobile",required:!1},{key:"email",label:"Email",required:!1},{key:"description",label:"Description",required:!1},{key:"line1",label:"Street",required:!1},{key:"city",label:"City",required:!1},{key:"state",label:"State",required:!1},{key:"postal_code",label:"Postal Code",required:!1},{key:"country",label:"Country",required:!1},{key:"fax",label:"Fax",required:!1},{key:"facebook",label:"Facebook",required:!1},{key:"skype",label:"Skype",required:!1},{key:"linkedin",label:"LinkedIn",required:!1},{key:"twitter",label:"Twitter",required:!1}],v=[{key:"first_name",label:"First Name",required:!1},{key:"last_name",label:"Last Name",required:!0},{key:"title",label:"Title",required:!1},{key:"phone",label:"Phone",required:!1},{key:"mobile",label:"Mobile",required:!1},{key:"fax",label:"Fax",required:!1},{key:"website",label:"Website",required:!1},{key:"email",label:"Email",required:!1},{key:"description",label:"Description",required:!1},{key:"line1",label:"Street",required:!1},{key:"city",label:"City",required:!1},{key:"state",label:"State",required:!1},{key:"postal_code",label:"Postal Code",required:!1},{key:"country",label:"Country",required:!1},{key:"facebook",label:"Facebook",required:!1},{key:"skype",label:"Skype",required:!1},{key:"linkedin",label:"LinkedIn",required:!1},{key:"twitter",label:"Twitter",required:!1}],j=[{key:"name",label:"Deal Name",required:!0},{key:"value",label:"Value",required:!1},{key:"estimated_close_date",label:"Estimated Close Date",required:!1},{key:"added_at",label:"Added On",required:!1},{key:"last_stage_change_at",label:"Last Moved Stage On",required:!1}],[e,o]=i.useState({name:"Zendesk",type:"Zendesk",api_key:"",field_map:[{formField:"",zendeskFormField:""}],actionName:"",organizationFields:N,contactFields:F,leadFields:v,dealFields:j,actions:{}}),w=()=>{b(!0),R(l,a,f,e,k,"","",b).then(u=>{var p;u.success?(s.success((p=u.data)==null?void 0:p.msg),k(f)):s.error(u.data||u)})},P=n=>{if(setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),!S(e)){s.error("Please map mandatory fields");return}if(e.actionName==="lead"||e.actionName==="deal"){if(!e.selectedCRMCompany){s.error("Please select a company");return}if(!e.selectedCRMContact){s.error("Please select a contact");return}if(!e.selectedCRMSources&&e.actionName==="lead"){s.error("Please select a Source");return}}e.field_map.length>0&&q(n)};return r.jsxs("div",{children:[r.jsx(E,{snack:C,setSnackbar:c}),r.jsx("div",{className:"txt-center mt-2",children:r.jsx(A,{step:3,active:d})}),r.jsx(O,{zendeskConf:e,setZendeskConf:o,step:d,setStep:q,loading:y,setLoading:m,setSnackbar:c}),r.jsxs("div",{className:"btcd-stp-page",style:x({},d===2&&{width:900,height:"auto",overflow:"visible"}),children:[r.jsx(V,{formFields:t,handleInput:n=>B(n,e,o),zendeskConf:e,setZendeskConf:o,loading:y,setLoading:m,setSnackbar:c}),(e==null?void 0:e.actionName)&&r.jsxs("button",{onClick:()=>P(3),disabled:!S(e),className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",children:[Z("Next","bit-integrations")," "," ",r.jsx("div",{className:"btcd-icn icn-arrow_back rev-icn d-in-b"})]})]}),(e==null?void 0:e.actionName)&&r.jsx(D,{step:d,saveConfig:()=>w(),isLoading:_,dataConf:e,setDataConf:o,formFields:t})]})}export{Y as default};
