var q=Object.defineProperty;var O=Object.getOwnPropertySymbols;var P=Object.prototype.hasOwnProperty,D=Object.prototype.propertyIsEnumerable;var R=(t,s,i)=>s in t?q(t,s,{enumerable:!0,configurable:!0,writable:!0,value:i}):t[s]=i,g=(t,s)=>{for(var i in s||(s={}))P.call(s,i)&&R(t,i,s[i]);if(O)for(var i of O(s))D.call(s,i)&&R(t,i,s[i]);return t};import{r as E,j as e,L as u,d as W}from"./main-149.js";import{q as k,_ as a,f as _,p as S,H as B,m as G,n as Q}from"./bi.738.82.js";import{g as I,a as T,b as z}from"./bi.9.888.js";function J({companyHubConf:t,setCompanyHubConf:s,loading:i,setLoading:l}){var v,n,c,j,w,A;const[h,d]=E.useState({show:!1,action:()=>{}}),m=(r,F)=>{var M,$,p;const x=g({},t);F==="company"?(M=r.target)!=null&&M.checked?(x.companies===void 0&&(x.companies=I(t,s,l)),x.actions.company=!0):(d({show:!1}),delete x.actions.company):F==="source"?($=r.target)!=null&&$.checked?(x.sources===void 0&&(x.sources=["Web","Call","Referral","Other"]),x.actions.source=!0):(d({show:!1}),delete x.actions.source):F==="contact"&&((p=r.target)!=null&&p.checked?(x.contacts===void 0&&(x.contacts=T(t,s,l)),x.actions.contact=!0):(d({show:!1}),delete x.actions.contact)),d({show:F}),s(g({},x))},o=()=>{d({show:!1})},N=(r,F)=>{s(x=>(x[F]=r,x))};return e.jsxs("div",{className:"pos-rel d-flx flx-wrp",children:[(t.actionName==="contact"||t.actionName==="deal")&&e.jsx(k,{checked:((v=t==null?void 0:t.selectedCompany)==null?void 0:v.length)||!1,onChange:r=>m(r,"company"),className:"wdt-200 mt-4 mr-2",value:"company",title:a("Add Company","bit - integrations"),subTitle:a("Add Company")}),t.actionName==="contact"&&e.jsx(k,{checked:((n=t==null?void 0:t.selectedSource)==null?void 0:n.length)||!1,onChange:r=>m(r,"source"),className:"wdt-200 mt-4 mr-2",value:"source",title:a("Add Source","bit - integrations"),subTitle:a("Add Contact Source")}),t.actionName==="deal"&&e.jsx(k,{checked:((c=t==null?void 0:t.selectedContact)==null?void 0:c.length)||!1,onChange:r=>m(r,"contact"),className:"wdt-200 mt-4 mr-2",value:"contact",title:a("Add Contact","bit - integrations"),subTitle:a("Add Contact")}),e.jsxs(_,{className:"custom-conf-mdl",mainMdlCls:"o-v",btnClass:"blue",btnTxt:a("Ok","bit-integrations"),show:h.show==="company",close:o,action:o,title:a("company","bit-integrations"),children:[e.jsx("div",{className:"btcd-hr mt-2 mb-2"}),e.jsx("div",{className:"mt-2",children:a("Select Company","bit-integrations")}),i.companies?e.jsx(u,{style:{display:"flex",justifyContent:"center",alignItems:"center",height:45,transform:"scale(0.5)"}}):e.jsxs("div",{className:"flx flx-between mt-2",children:[e.jsx(S,{options:(j=t==null?void 0:t.companies)==null?void 0:j.map(r=>({label:r.name,value:`${r.id}`})),className:"msl-wrp-options",defaultValue:t==null?void 0:t.selectedCompany,onChange:r=>N(r,"selectedCompany"),singleSelect:!0,closeOnSelect:!0}),e.jsx("button",{onClick:()=>I(t,s,l),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":`${a("Refresh Companies","bit-integrations")}'`},type:"button",children:"↻"})]})]}),e.jsxs(_,{className:"custom-conf-mdl",mainMdlCls:"o-v",btnClass:"blue",btnTxt:a("Ok","bit-integrations"),show:h.show==="source",close:o,action:o,title:a("Source","bit-integrations"),children:[e.jsx("div",{className:"btcd-hr mt-2 mb-2"}),e.jsx("div",{className:"mt-2",children:a("Select Source","bit-integrations")}),e.jsx("div",{className:"flx flx-between mt-2",children:e.jsx(S,{options:(w=t==null?void 0:t.sources)==null?void 0:w.map(r=>({label:r,value:r})),className:"msl-wrp-options",defaultValue:t==null?void 0:t.selectedSource,onChange:r=>N(r,"selectedSource"),singleSelect:!0,closeOnSelect:!0})})]}),e.jsxs(_,{className:"custom-conf-mdl",mainMdlCls:"o-v",btnClass:"blue",btnTxt:a("Ok","bit-integrations"),show:h.show==="contact",close:o,action:o,title:a("Contact","bit-integrations"),children:[e.jsx("div",{className:"btcd-hr mt-2 mb-2"}),e.jsx("div",{className:"mt-2",children:a("Select Contact","bit-integrations")}),i.contact?e.jsx(u,{style:{display:"flex",justifyContent:"center",alignItems:"center",height:45,transform:"scale(0.5)"}}):e.jsxs("div",{className:"flx flx-between mt-2",children:[e.jsx(S,{options:(A=t==null?void 0:t.contacts)==null?void 0:A.map(r=>({label:r.name,value:`${r.id}`})),className:"msl-wrp-options",defaultValue:t==null?void 0:t.selectedContact,onChange:r=>N(r,"selectedContact"),singleSelect:!0,closeOnSelect:!0}),e.jsx("button",{onClick:()=>T(t,s,l),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":`${a("Refresh Contacts","bit-integrations")}'`},type:"button",children:"↻"})]})]})]})}const V=(t,s,i)=>{const l=g({},s);l.field_map.splice(t,0,{}),i(g({},l))},K=(t,s,i)=>{const l=g({},s);l.field_map.length>1&&l.field_map.splice(t,1),i(g({},l))},b=(t,s,i,l)=>{const h=g({},i);h.field_map[s][t.target.name]=t.target.value,t.target.value==="custom"&&(h.field_map[s].customValue=""),l(g({},h))},L=(t,s,i,l,h)=>{const d=g({},i);d.field_map[s][h]=t.target.value,l(g({},d))};function U({field:t,index:s,conf:i,setConf:l,fieldValue:h,fieldLabel:d,className:m}){return e.jsx(B,{onChange:o=>L(o,s,i,l,h),label:a(d,"bit-integrations"),className:m,type:"text",value:t[h],placeholder:a(d,"bit-integrations")})}function X({i:t,formFields:s,field:i,companyHubConf:l,setCompanyHubConf:h}){var n;let d=[];l.actionName==="contact"?d=l==null?void 0:l.contactFields:l.actionName==="company"?d=l==null?void 0:l.companyFields:l.actionName==="deal"&&(d=l==null?void 0:l.dealFields);const m=d.filter(c=>c.required===!0)||[],o=d.filter(c=>c.required===!1)||[],N=W(G),{isPro:v}=N;return e.jsx("div",{className:"flx mt-2 mb-2 btcbi-field-map",children:e.jsxs("div",{className:"pos-rel flx",children:[e.jsxs("div",{className:"flx integ-fld-wrp",children:[e.jsxs("select",{className:"btcd-paper-inp mr-2",name:"formField",value:i.formField||"",onChange:c=>b(c,t,l,h),children:[e.jsx("option",{value:"",children:a("Select Field","bit-integrations")}),e.jsx("optgroup",{label:"Form Fields",children:s==null?void 0:s.map(c=>e.jsx("option",{value:c.name,children:c.label},`ff-rm-${c.name}`))}),e.jsx("option",{value:"custom",children:a("Custom...","bit-integrations")}),e.jsx("optgroup",{label:`General Smart Codes ${v?"":"(PRO)"}`,children:v&&((n=Q)==null?void 0:n.map(c=>e.jsx("option",{value:c.name,children:c.label},`ff-rm-${c.name}`)))})]}),i.formField==="custom"&&e.jsx(U,{field:i,index:t,conf:l,setConf:h,fieldValue:"customValue",fieldLabel:"Custom Value",className:"mr-2"}),e.jsxs("select",{className:"btcd-paper-inp",disabled:t<m.length,name:"companyHubFormField",value:t<m.length?m[t].key||"":i.companyHubFormField||"",onChange:c=>b(c,t,l,h),children:[e.jsx("option",{value:"",children:a("Select Field","bit-integrations")}),t<m.length?e.jsx("option",{value:m[t].key,children:m[t].label},m[t].key):o.map(({key:c,label:j})=>e.jsx("option",{value:c,children:j},c))]})]}),t>=m.length&&e.jsxs(e.Fragment,{children:[e.jsx("button",{onClick:()=>V(t,l,h),className:"icn-btn sh-sm ml-2 mr-1",type:"button",children:"+"}),e.jsx("button",{onClick:()=>K(t,l,h),className:"icn-btn sh-sm ml-1",type:"button","aria-label":"btn",children:e.jsx("span",{className:"btcd-icn icn-trash-2"})})]})]})})}function y({formFields:t,companyHubConf:s,setCompanyHubConf:i,loading:l,setLoading:h,isLoading:d,setIsLoading:m,setSnackbar:o}){const N=n=>{const c=g({},s),{name:j}=n.target;if(n.target.value!==""){c[j]=n.target.value;let w=[];n.target.value==="contact"?w=s==null?void 0:s.contactFields:n.target.value==="company"?w=s==null?void 0:s.companyFields:n.target.value==="deal"&&(w=s==null?void 0:s.dealFields),c.field_map=z(w)}else delete c[j],delete c.actionId;i(c)},v=(n,c)=>{i(j=>(j[c]=n,j))};return e.jsxs(e.Fragment,{children:[e.jsx("br",{}),e.jsx("b",{className:"wdt-200 d-in-b",children:a("Select Action:","bit-integrations")}),e.jsxs("select",{onChange:N,name:"actionName",value:s.actionName,className:"btcd-paper-inp w-5",children:[e.jsx("option",{value:"",children:a("Select an action","bit-integrations")}),e.jsx("option",{value:"contact","data-action_name":"contact",children:a("Create Contact","bit-integrations")}),e.jsx("option",{value:"company","data-action_name":"company",children:a("Create Company","bit-integrations")}),e.jsx("option",{value:"deal","data-action_name":"deal",children:a("Create Deal","bit-integrations")})]}),d&&e.jsx(u,{style:{display:"flex",justifyContent:"center",alignItems:"center",height:100,transform:"scale(0.7)"}}),s.actionName==="deal"&&!d&&e.jsxs(e.Fragment,{children:[e.jsx("br",{}),e.jsx("br",{}),e.jsxs("div",{className:"flx",children:[e.jsx("b",{className:"wdt-200 d-in-b",children:a("Select Deal Stage:","bit-integrations")}),e.jsx(S,{options:["Prospecting","Qualification","Discussion","Proposal","Review","Closed Won","Closed Lost"].map(n=>({label:n,value:n})),className:"msl-wrp-options dropdown-custom-width",defaultValue:s==null?void 0:s.selectedStage,onChange:n=>v(n,"selectedStage"),singleSelect:!0,closeOnSelect:!0})]})]}),s.actionName&&!d&&e.jsxs("div",{children:[e.jsx("br",{}),e.jsxs("div",{className:"mt-5",children:[e.jsx("b",{className:"wdt-100",children:a("Field Map","bit-integrations")}),e.jsx("button",{className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":`'${a("Refresh Fields","bit-integrations")}'`},type:"button",children:"↻"})]}),e.jsx("br",{}),e.jsx("div",{className:"btcd-hr mt-1"}),e.jsxs("div",{className:"flx flx-around mt-2 mb-2 btcbi-field-map-label",children:[e.jsx("div",{className:"txt-dp",children:e.jsx("b",{children:a("Form Fields","bit-integrations")})}),e.jsx("div",{className:"txt-dp",children:e.jsx("b",{children:a("CompanyHub Fields","bit-integrations")})})]}),s==null?void 0:s.field_map.map((n,c)=>e.jsx(X,{i:c,field:n,companyHubConf:s,formFields:t,setCompanyHubConf:i,setSnackbar:o},`rp-m-${c+9}`)),e.jsx("div",{className:"txt-center btcbi-field-map-button mt-2",children:e.jsx("button",{onClick:()=>V(s.field_map.length,s,i),className:"icn-btn sh-sm",type:"button",children:"+"})}),e.jsx("br",{}),e.jsx("br",{}),e.jsx("div",{className:"mt-4",children:e.jsx("b",{className:"wdt-100",children:a("Actions","bit-integrations")})}),e.jsx("div",{className:"btcd-hr mt-1"}),e.jsx(J,{companyHubConf:s,setCompanyHubConf:i,formFields:t,loading:l,setLoading:h})]})]})}export{y as C};
