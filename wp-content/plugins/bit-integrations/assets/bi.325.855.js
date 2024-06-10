var J=Object.defineProperty;var V=Object.getOwnPropertySymbols;var Q=Object.prototype.hasOwnProperty,W=Object.prototype.propertyIsEnumerable;var $=(a,d,t)=>d in a?J(a,d,{enumerable:!0,configurable:!0,writable:!0,value:t}):a[d]=t,p=(a,d)=>{for(var t in d||(d={}))Q.call(d,t)&&$(a,t,d[t]);if(V)for(var t of V(d))W.call(d,t)&&$(a,t,d[t]);return a};import{r as X,j as e,L as R,d as Z}from"./main-149.js";import{q as L,_ as l,f as k,p as S,H as I,m as h,n as g}from"./bi.738.82.js";import{g as q,a as B,b as K,d as f,e as U,f as E,i as H,j as G}from"./bi.918.854.js";function C({insightlyConf:a,setInsightlyConf:d,loading:t,setLoading:s}){var F,i,c,n,N;const[r,o]=X.useState({show:!1,action:()=>{}}),u=[{label:"Yes",value:"yes"},{label:"No",value:"no"}],v=[{label:"New Business",value:"New Business"},{label:"Existing Business",value:"Existing Business"}],w=(m,M)=>{var O,P,_,A,T;const x=p({},a);M==="organisation"?(O=m.target)!=null&&O.checked?(q(a,d,s),x.actions.organisation=!0):(o({show:!1}),delete x.actions.organisation):M==="category"?(P=m.target)!=null&&P.checked?(B(a,d,s),x.actions.category=!0):(o({show:!1}),delete x.actions.category):M==="status"?(_=m.target)!=null&&_.checked?(K(a,d,s),x.actions.status=!0):(o({show:!1}),delete x.actions.status):M==="followUp"?(A=m.target)!=null&&A.checked?x.actions.followUp=!0:(o({show:!1}),delete x.actions.followUp):M==="opportunityType"&&((T=m.target)!=null&&T.checked?x.actions.opportunityType=!0:(o({show:!1}),delete x.actions.opportunityType)),o({show:M}),d(p({},x))},b=()=>{o({show:!1})},j=(m,M)=>{const x=p({},a);x[M]=m,d(p({},x))};return e.jsxs("div",{className:"pos-rel d-flx flx-wrp",children:[(a.actionName==="contact"||a.actionName==="opportunity")&&e.jsx(L,{checked:((F=a==null?void 0:a.selectedOrganisation)==null?void 0:F.length)||!1,onChange:m=>w(m,"organisation"),className:"wdt-200 mt-4 mr-2",value:"organisation",title:l("Add Organisation","bit - integrations"),subTitle:l("Add an organisation")}),(a.actionName==="opportunity"||a.actionName==="project"||a.actionName==="task")&&e.jsx(L,{checked:((i=a==null?void 0:a.selectedCategory)==null?void 0:i.length)||!1,onChange:m=>w(m,"category"),className:"wdt-200 mt-4 mr-2",value:"category",title:l("Add Category","bit - integrations"),subTitle:l("Add a category")}),e.jsxs(k,{className:"custom-conf-mdl",mainMdlCls:"o-v",btnClass:"blue",btnTxt:l("Ok","bit-integrations"),show:r.show==="organisation",close:b,action:b,title:l("Organisations","bit-integrations"),children:[e.jsx("div",{className:"btcd-hr mt-2 mb-2"}),e.jsx("div",{className:"mt-2",children:l("Select Organisation","bit-integrations")}),t.organisations?e.jsx(R,{style:{display:"flex",justifyContent:"center",alignItems:"center",height:45,transform:"scale(0.5)"}}):e.jsxs("div",{className:"flx flx-between mt-2",children:[e.jsx(S,{options:(c=a==null?void 0:a.organisations)==null?void 0:c.map(m=>({label:m.name,value:m.id})),className:"msl-wrp-options",defaultValue:a==null?void 0:a.selectedOrganisation,onChange:m=>j(m,"selectedOrganisation"),singleSelect:!0}),e.jsx("button",{onClick:()=>q(a,d,s),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":`${l("Refresh Organisations","bit-integrations")}'`},type:"button",children:"↻"})]})]}),e.jsxs(k,{className:"custom-conf-mdl",mainMdlCls:"o-v",btnClass:"blue",btnTxt:l("Ok","bit-integrations"),show:r.show==="category",close:b,action:b,title:l("Categories","bit-integrations"),children:[e.jsx("div",{className:"btcd-hr mt-2 mb-2"}),e.jsx("div",{className:"mt-2",children:l("Select Category","bit-integrations")}),t.categories?e.jsx(R,{style:{display:"flex",justifyContent:"center",alignItems:"center",height:45,transform:"scale(0.5)"}}):e.jsxs("div",{className:"flx flx-between mt-2",children:[e.jsx(S,{options:(n=a==null?void 0:a.categories)==null?void 0:n.map(m=>({label:m.name,value:m.id})),className:"msl-wrp-options",defaultValue:a==null?void 0:a.selectedCategory,onChange:m=>j(m,"selectedCategory"),singleSelect:!0}),e.jsx("button",{onClick:()=>B(a,d,s),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":`${l("Refresh Categories","bit-integrations")}'`},type:"button",children:"↻"})]})]}),e.jsxs(k,{className:"custom-conf-mdl",mainMdlCls:"o-v",btnClass:"blue",btnTxt:l("Ok","bit-integrations"),show:r.show==="status",close:b,action:b,title:l("Statuses","bit-integrations"),children:[e.jsx("div",{className:"btcd-hr mt-2 mb-2"}),e.jsx("div",{className:"mt-2",children:l("Select Status","bit-integrations")}),t.statuses?e.jsx(R,{style:{display:"flex",justifyContent:"center",alignItems:"center",height:45,transform:"scale(0.5)"}}):e.jsxs("div",{className:"flx flx-between mt-2",children:[e.jsx(S,{options:(N=a==null?void 0:a.statuses)==null?void 0:N.map(m=>({label:m.name,value:m.id})),className:"msl-wrp-options",defaultValue:a==null?void 0:a.selectedStatus,onChange:m=>j(m,"selectedStatus"),singleSelect:!0}),e.jsx("button",{onClick:()=>K(a,d,s),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":`${l("Refresh statuses","bit-integrations")}'`},type:"button",children:"↻"})]})]}),e.jsxs(k,{className:"custom-conf-mdl",mainMdlCls:"o-v",btnClass:"blue",btnTxt:l("Ok","bit-integrations"),show:r.show==="followUp",close:b,action:b,title:l("Follow Up","bit-integrations"),children:[e.jsx("div",{className:"btcd-hr mt-2 mb-2"}),e.jsx("div",{className:"flx flx-center mt-2",children:e.jsx(S,{options:u==null?void 0:u.map(m=>({label:m.label,value:m.value})),className:"msl-wrp-options",defaultValue:a==null?void 0:a.selectedFollowUp,onChange:m=>j(m,"selectedFollowUp"),singleSelect:!0})})]}),e.jsxs(k,{className:"custom-conf-mdl",mainMdlCls:"o-v",btnClass:"blue",btnTxt:l("Ok","bit-integrations"),show:r.show==="opportunityType",close:b,action:b,title:l("Opportunity types","bit-integrations"),children:[e.jsx("div",{className:"btcd-hr mt-2 mb-2"}),e.jsx("div",{className:"flx flx-center mt-2",children:e.jsx(S,{options:v==null?void 0:v.map(m=>({label:m.label,value:m.value})),className:"msl-wrp-options",defaultValue:a==null?void 0:a.selectedOpportunityType,onChange:m=>j(m,"selectedOpportunityType"),singleSelect:!0})})]})]})}const D=(a,d,t)=>{const s=p({},d);s.field_map.splice(a,0,{}),t(p({},s))},y=(a,d,t)=>{const s=p({},d);s.field_map.length>1&&s.field_map.splice(a,1),t(p({},s))},Y=(a,d,t,s)=>{const r=p({},t);r.field_map[d][a.target.name]=a.target.value,a.target.value==="custom"&&(r.field_map[d].customValue=""),a.target.value==="customFieldKey"&&(r.field_map[d].customFieldKey=""),s(p({},r))},ee=(a,d,t,s,r)=>{const o=p({},t);o.field_map[d][r]=a.target.value,s(p({},o))};function z({field:a,index:d,conf:t,setConf:s,fieldValue:r,fieldLabel:o,className:u}){return e.jsx(I,{onChange:v=>ee(v,d,t,s,r),label:l(o,"bit-integrations"),className:u,type:"text",value:a[r],placeholder:l(o,"bit-integrations")})}function ae({i:a,formFields:d,field:t,insightlyConf:s,setInsightlyConf:r}){var j,F;let o=[];s.actionName==="organisation"?o=s==null?void 0:s.organisationFields:s.actionName==="contact"?o=s==null?void 0:s.contactFields:s.actionName==="opportunity"?o=s==null?void 0:s.opportunityFields:s.actionName==="project"?o=s==null?void 0:s.projectFields:s.actionName==="task"?o=s==null?void 0:s.taskFields:s.actionName==="lead"&&(o=s==null?void 0:s.leadFields);const u=o.filter(i=>i.required===!0)||[],v=o.filter(i=>i.required===!1)||[];if(((j=s==null?void 0:s.field_map)==null?void 0:j.length)===1&&t.insightlyFormField===""){const i=p({},s),c=f(i);i.field_map=c,r(i)}const w=Z(h),{isPro:b}=w;return e.jsx("div",{className:"flx mt-2 mb-2 btcbi-field-map",children:e.jsxs("div",{className:"pos-rel flx",children:[e.jsxs("div",{className:"flx integ-fld-wrp",children:[e.jsxs("select",{className:"btcd-paper-inp mr-2",name:"formField",value:t.formField||"",onChange:i=>Y(i,a,s,r),children:[e.jsx("option",{value:"",children:l("Select Field","bit-integrations")}),e.jsx("optgroup",{label:"Form Fields",children:d==null?void 0:d.map(i=>e.jsx("option",{value:i.name,children:i.label},`ff-rm-${i.name}`))}),e.jsx("option",{value:"custom",children:l("Custom...","bit-integrations")}),e.jsx("optgroup",{label:`General Smart Codes ${b?"":"(PRO)"}`,children:b&&((F=g)==null?void 0:F.map(i=>e.jsx("option",{value:i.name,children:i.label},`ff-rm-${i.name}`)))})]}),t.formField==="custom"&&e.jsx(z,{field:t,index:a,conf:s,setConf:r,fieldValue:"customValue",fieldLabel:"Custom Value",className:"mr-2"}),e.jsxs("select",{className:"btcd-paper-inp",disabled:a<u.length,name:"insightlyFormField",value:a<u?u[a].label||"":t.insightlyFormField||"",onChange:i=>Y(i,a,s,r),children:[e.jsx("option",{value:"",children:l("Select Field","bit-integrations")}),a<u.length?e.jsx("option",{value:u[a].key,children:u[a].label},u[a].key):v.map(({key:i,label:c})=>e.jsx("option",{value:i,children:c},i))]}),t.insightlyFormField==="customFieldKey"&&e.jsx(z,{field:t,index:a,conf:s,setConf:r,fieldValue:"customFieldKey",fieldLabel:"Custom Field Key",className:"ml-2"})]}),a>=u.length&&e.jsxs(e.Fragment,{children:[e.jsx("button",{onClick:()=>D(a,s,r),className:"icn-btn sh-sm ml-2 mr-1",type:"button",children:"+"}),e.jsx("button",{onClick:()=>y(a,s,r),className:"icn-btn sh-sm ml-1",type:"button","aria-label":"btn",children:e.jsx("span",{className:"btcd-icn icn-trash-2"})})]})]})})}function re({formFields:a,handleInput:d,insightlyConf:t,setInsightlyConf:s,loading:r,setLoading:o,setSnackbar:u}){var b,j,F,i;const v=c=>{const n=p({},t);n.field_map=[{formField:"",insightlyFormField:""}];const{name:N}=c.target;c.target.value!==""?(n[N]=c.target.value,c.target.value==="opportunity"||c.target.value==="project"?H(n,s,o):c.target.value==="lead"&&(U(n,s,o),E(n,s,o))):delete n[N],s(p({},n))},w=(c,n)=>{const N=p({},t);N[n]=c,n==="selectedCRMPipeline"&&c!==""&&(N.selectedCRMPipelineStages="",G(N,s,o)),s(p({},N))};return e.jsxs(e.Fragment,{children:[e.jsx("br",{}),e.jsx("b",{className:"wdt-200 d-in-b",children:l("Select Action:","bit-integrations")}),e.jsxs("select",{onChange:v,name:"actionName",value:t.actionName,className:"btcd-paper-inp w-5",children:[e.jsx("option",{value:"",children:l("Select an action","bit-integrations")}),e.jsx("option",{value:"organisation",children:l("Create Organisation","bit-integrations")}),e.jsx("option",{value:"contact",children:l("Create Contact","bit-integrations")}),e.jsx("option",{value:"opportunity",children:l("Create Opportunity","bit-integrations")}),e.jsx("option",{value:"task",children:l("Create Task","bit-integrations")}),e.jsx("option",{value:"lead",children:l("Create Lead","bit-integrations")})]}),(r.CRMPipelines||r.CRMPipelineStages||r.LeadStatuses||r.LeadSources)&&e.jsx(R,{style:{display:"flex",justifyContent:"center",alignItems:"center",height:100,transform:"scale(0.7)"}}),t.actionName==="lead"&&e.jsxs(e.Fragment,{children:[e.jsx("br",{}),e.jsx("br",{}),e.jsxs("div",{className:"flx",children:[e.jsx("b",{className:"wdt-200 d-in-b",children:l("Select Lead Status:","bit-integrations")}),e.jsx(S,{options:(b=t==null?void 0:t.LeadStatuses)==null?void 0:b.map(c=>({label:c.name,value:c.id})),className:"msl-wrp-options dropdown-custom-width",defaultValue:t==null?void 0:t.selectedLeadStatus,onChange:c=>w(c,"selectedLeadStatus"),disabled:r.LeadStatuses,singleSelect:!0}),e.jsx("button",{onClick:()=>U(t,s,o),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":`'${l("Refresh lead status","bit-integrations")}'`},type:"button",disabled:r.LeadStatuses,children:"↻"})]}),e.jsx("br",{}),e.jsx("br",{}),e.jsxs("div",{className:"flx",children:[e.jsx("b",{className:"wdt-200 d-in-b",children:l("Select Lead Source:","bit-integrations")}),e.jsx(S,{options:(j=t==null?void 0:t.LeadSources)==null?void 0:j.map(c=>({label:c.name,value:c.id})),className:"msl-wrp-options dropdown-custom-width",defaultValue:t==null?void 0:t.selectedLeadSource,onChange:c=>w(c,"selectedLeadSource"),disabled:r.LeadSources,singleSelect:!0}),e.jsx("button",{onClick:()=>E(t,s,o),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":`'${l("Refresh lead source","bit-integrations")}'`},type:"button",disabled:r.LeadSources,children:"↻"})]})]}),(t.actionName==="opportunity"||t.actionName==="project")&&e.jsxs(e.Fragment,{children:[e.jsx("br",{}),e.jsx("br",{}),e.jsxs("div",{className:"flx",children:[e.jsx("b",{className:"wdt-200 d-in-b",children:l("Select Pipeline:","bit-integrations")}),e.jsx(S,{options:(F=t==null?void 0:t.CRMPipelines)==null?void 0:F.map(c=>({label:c.name,value:c.id})),className:"msl-wrp-options dropdown-custom-width",defaultValue:t==null?void 0:t.selectedCRMPipeline,onChange:c=>w(c,"selectedCRMPipeline"),disabled:r.CRMPipelines,singleSelect:!0}),e.jsx("button",{onClick:()=>H(t,s,o),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":`'${l("Refresh pipelines","bit-integrations")}'`},type:"button",disabled:r.CRMPipelines,children:"↻"})]})]}),(t.actionName==="opportunity"||t.actionName==="project")&&t.selectedCRMPipeline&&e.jsxs(e.Fragment,{children:[e.jsx("br",{}),e.jsx("br",{}),e.jsxs("div",{className:"flx",children:[e.jsx("b",{className:"wdt-200 d-in-b",children:l("Select Stage:","bit-integrations")}),e.jsx(S,{options:(i=t==null?void 0:t.CRMPipelineStages)==null?void 0:i.filter(c=>c.pipeline_id==t.selectedCRMPipeline).map(c=>({label:c.name,value:c.id})),className:"msl-wrp-options dropdown-custom-width",defaultValue:t==null?void 0:t.selectedCRMPipelineStages,onChange:c=>w(c,"selectedCRMPipelineStages"),disabled:r.CRMPipelineStages,singleSelect:!0}),e.jsx("button",{onClick:()=>G(t,s,o),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":`'${l("Refresh pipeline stages","bit-integrations")}'`},type:"button",disabled:r.CRMPipelineStages,children:"↻"})]})]}),r.customFields&&e.jsx(R,{style:{display:"flex",justifyContent:"center",alignItems:"center",height:100,transform:"scale(0.7)"}}),t.actionName&&e.jsxs("div",{children:[e.jsx("br",{}),e.jsx("div",{className:"mt-5",children:e.jsx("b",{className:"wdt-100",children:l("Field Map","bit-integrations")})}),e.jsx("br",{}),e.jsx("div",{className:"btcd-hr mt-1"}),e.jsxs("div",{className:"flx flx-around mt-2 mb-2 btcbi-field-map-label",children:[e.jsx("div",{className:"txt-dp",children:e.jsx("b",{children:l("Form Fields","bit-integrations")})}),e.jsx("div",{className:"txt-dp",children:e.jsx("b",{children:l("Insightly Fields","bit-integrations")})})]}),t==null?void 0:t.field_map.map((c,n)=>e.jsx(ae,{i:n,field:c,insightlyConf:t,formFields:a,setInsightlyConf:s,setSnackbar:u},`rp-m-${n+9}`)),e.jsx("div",{className:"txt-center btcbi-field-map-button mt-2",children:e.jsx("button",{onClick:()=>D(t.field_map.length,t,s),className:"icn-btn sh-sm",type:"button",children:"+"})}),e.jsx("br",{}),e.jsx("br",{}),e.jsx("div",{className:"mt-4",children:e.jsx("b",{className:"wdt-100",children:l("Actions","bit-integrations")})}),e.jsx("div",{className:"btcd-hr mt-1"}),e.jsx(C,{insightlyConf:t,setInsightlyConf:s,formFields:a,loading:r,setLoading:o})]})]})}export{re as I};
