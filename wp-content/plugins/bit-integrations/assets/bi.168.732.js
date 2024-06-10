var k=Object.defineProperty,q=Object.defineProperties;var O=Object.getOwnPropertyDescriptors;var y=Object.getOwnPropertySymbols;var A=Object.prototype.hasOwnProperty,V=Object.prototype.propertyIsEnumerable;var M=(l,d,e)=>d in l?k(l,d,{enumerable:!0,configurable:!0,writable:!0,value:e}):l[d]=e,o=(l,d)=>{for(var e in d||(d={}))A.call(d,e)&&M(l,e,d[e]);if(y)for(var e of y(d))V.call(d,e)&&M(l,e,d[e]);return l},g=(l,d)=>q(l,O(d));import{j as s,d as I,L as R}from"./main-149.js";import{c as _,J as N,_ as r,q as T,m as E,n as H,o as L,T as P,p as B,r as D}from"./bi.738.82.js";import{T as G}from"./bi.653.689.js";const w=(l,d,e,i,n,b)=>{n(g(o({},i),{fluentCrmList:!0})),_({},"refresh_fluent_crm_lists").then(a=>{a&&a.success?(e(h=>N(h,p=>{p.fluentCrmList=a.data.fluentCrmList,p.fluentCrmTags=a.data.fluentCrmTags})),b({show:!0,msg:r("FluentCRM list refreshed","bit-integrations")})):a&&a.data&&a.data.data||!a.success&&typeof a.data=="string"?b({show:!0,msg:`${r("FluentCRM list refresh failed Cause:","bit-integrations")}${a.data.data||a.data}. ${r("please try again","bit-integrations")}`}):b({show:!0,msg:r("FluentCRM list refresh failed. please try again","bit-integrations")}),n(g(o({},i),{fluentCrmList:!1}))}).catch(()=>n(g(o({},i),{fluentCrmTags:!0})))},$=(l,d,e,i,n,b)=>{n(g(o({},i),{fluentCrmTags:!0})),_({},"refresh_fluent_crm_tags").then(a=>{a&&a.success?(e(h=>N(h,p=>{p.default||(p.default={}),a.data.fluentCrmTags&&(p.fluentCrmTags=a.data.fluentCrmTags)})),b({show:!0,msg:r("FluentCRM Tags refreshed","bit-integrations")})):a&&a.data&&a.data.data||!a.success&&typeof a.data=="string"?b({show:!0,msg:`${r("FluentCRM tags refresh failed Cause:","bit-integrations")}${a.data.data||a.data}. ${r("please try again","bit-integrations")}`}):b({show:!0,msg:r("FluentCRM tags refresh failed. please try again","bit-integrations")}),n(g(o({},i),{fluentCrmTags:!1}))}).catch(()=>n(g(o({},i),{fluentCrmTags:!1})))},J=(l,d,e,i)=>{e(!0),_({},"fluent_crm_headers").then(n=>{n&&n.success?n.data.fluentCrmFlelds?(d(b=>N(b,a=>{a.fluentCrmFlelds=n.data.fluentCrmFlelds,a.field_map=z(a)})),i({show:!0,msg:r("Fluent CRM fields refreshed","bit-integrations")})):i({show:!0,msg:r("No Fluent CRM fields found. Try changing the header row number or try again","bit-integrations")}):i({show:!0,msg:r("Fluent CRM fields refresh failed. please try again","bit-integrations")}),e(!1)}).catch(()=>e(!1))},z=l=>{const{field_map:d}=l,{fluentCrmFlelds:e}=l,n=Object.values(e).filter(h=>h.required).map(h=>({formField:"",fluentCRMField:h.key,required:!0})).filter(h=>!d.find(p=>p.fluentCRMField===h.fluentCRMField)),a=d.filter(h=>h.fluentCRMField||h.formField).map(h=>{const p=e[h.fluentCRMField];return p?g(o({},h),{formField:p.label}):h});return[...n,...a]},Z=(l,d,e)=>{const i=o({},d);i.name=l.target.value,e(o({},i))},S=l=>!((l!=null&&l.field_map?l.field_map.filter(e=>!e.formField&&e.fluentCRMField&&e.required):[]).length>0);function K({fluentCrmConf:l,setFluentCrmConf:d,formFields:e}){var n,b;const i=(a,h)=>{const p=o({},l);h==="exists"&&(a.target.checked?p.actions.skip_if_exists=!0:delete p.actions.skip_if_exists),h==="doubleOpIn"&&(a.target.checked?p.actions.double_opt_in=!0:delete p.actions.double_opt_in),d(o({},p))};return s.jsxs("div",{className:"pos-rel d-flx w-8",children:[s.jsx(T,{checked:((n=l.actions)==null?void 0:n.skip_if_exists)||!1,onChange:a=>i(a,"exists"),className:"wdt-200 mt-4 mr-2",value:"skip_if_exists",title:r("Skip exist Contact","bit-integrations"),subTitle:r("Skip if contact already exist in FluentCRM","bit-integrations")}),s.jsx(T,{checked:((b=l.actions)==null?void 0:b.double_opt_in)||!1,onChange:a=>i(a,"doubleOpIn"),className:"wdt-200 mt-4 mr-2",value:"double_opt_in",title:r("Double Opt-in","bit-integrations"),subTitle:r("Enable Double Option for new contacts","bit-integrations")})]})}function Q({i:l,formFields:d,field:e,fluentCrmConf:i,setFluentCrmConf:n}){var u;const b=e.required,a=(i==null?void 0:i.fluentCrmFlelds)&&Object.values(i==null?void 0:i.fluentCrmFlelds).filter(t=>!t.required),h=I(E),{isPro:p}=h,j=t=>{const c=o({},i);c.field_map.splice(t,0,{}),n(c)},F=t=>{const c=o({},i);c.field_map.length>1&&c.field_map.splice(t,1),n(c)},x=(t,c)=>{const m=o({},i);m.field_map[c][t.target.name]=t.target.value,t.target.value==="custom"&&(m.field_map[c].customValue=""),n(m)};return s.jsxs("div",{className:"flx mt-2 mb-2 btcbi-field-map",children:[s.jsxs("div",{className:"flx integ-fld-wrp",children:[s.jsxs("select",{className:"btcd-paper-inp mr-2",name:"formField",value:e.formField||"",onChange:t=>x(t,l),children:[s.jsx("option",{value:"",children:r("Select Field","bit-integrations")}),s.jsx("optgroup",{label:"Form Fields",children:d==null?void 0:d.map(t=>s.jsx("option",{value:t.name,children:t.label},`ff-rm-${t.name}`))}),s.jsx("option",{value:"custom",children:r("Custom...","bit-integrations")}),s.jsx("optgroup",{label:`General Smart Codes ${p?"":"(PRO)"}`,children:p&&((u=H)==null?void 0:u.map(t=>s.jsx("option",{value:t.name,children:t.label},`ff-rm-${t.name}`)))})]}),e.formField==="custom"&&s.jsx(G,{onChange:t=>L(t,l,i,n),label:r("Custom Value","bit-integrations"),className:"mr-2",type:"text",value:e.customValue,placeholder:r("Custom Value","bit-integrations"),formFields:d}),s.jsxs("select",{className:"btcd-paper-inp",name:"fluentCRMField",value:e.fluentCRMField,onChange:t=>x(t,l),disabled:b,children:[s.jsx("option",{value:"",children:r("Select Field","bit-integrations")}),b?i.fluentCrmFlelds&&Object.values(i.fluentCrmFlelds).map(t=>s.jsx("option",{value:t.key,children:t.label},`${t.key}-1`)):a&&a.map(t=>s.jsx("option",{value:t.key,children:t.label},`${t.key}-1`))]})]}),!b&&s.jsxs(s.Fragment,{children:[s.jsx("button",{onClick:()=>j(l),className:"icn-btn sh-sm ml-2 mr-1",type:"button",children:"+"}),s.jsx("button",{onClick:()=>F(l),className:"icn-btn sh-sm ml-2",type:"button","aria-label":"btn",children:s.jsx(P,{})})]})]})}function f({formID:l,formFields:d,fluentCrmConf:e,setFluentCrmConf:i,isLoading:n,setIsLoading:b,loading:a,setLoading:h,setSnackbar:p}){const j=t=>{const c=o({},e);t?c.tags=t?t.split(","):[]:delete c.tags,i(o({},c))},F=[{value:"add-tag",label:"Add tag to a user"},{value:"remove-tag",label:"Remove tag from a user"},{value:"add-user",label:"Add user to a list"},{value:"remove-user",label:"Remove user from a list"}],x=t=>{const c=o({},e);c.list_id=t.target.value,i(o({},c))},u=t=>{const c=o({},e),{name:m,value:v}=t.target;c==null||delete c.fluentCrmList,c==null||delete c.fluentCrmTags,t.target.value!==""?(c[m]=v,J(c,i,b,p),v==="add-user"||v==="remove-user"?w(l,c,i,a,h,p):$(l,c,i,a,h,p)):delete c[m],i(c)};return s.jsxs(s.Fragment,{children:[s.jsx("br",{}),s.jsxs("div",{className:"flx",children:[s.jsx("b",{className:"wdt-200 d-in-b",children:r("Action:","bit-integrations")}),s.jsxs("select",{onChange:u,name:"actionName",value:e==null?void 0:e.actionName,className:"btcd-paper-inp w-5",children:[s.jsx("option",{value:"",children:r("Select Action","bit-integrations")}),F.map(({label:t,value:c})=>s.jsx("option",{value:c,children:t},t))]})]}),s.jsx("br",{}),(a.fluentCrmList||a.fluentCrmTags)&&s.jsx(R,{style:{display:"flex",justifyContent:"center",alignItems:"center",height:100,transform:"scale(0.7)"}}),((e==null?void 0:e.actionName)==="add-user"||(e==null?void 0:e.actionName)==="remove-user")&&(e==null?void 0:e.fluentCrmList)&&!a.fluentCrmList&&s.jsxs("div",{className:"flx",children:[s.jsx("b",{className:"wdt-200 d-in-b",children:r("Fluent CRM List:","bit-integrations")}),s.jsxs("select",{onChange:t=>x(t),name:"list_id",value:e.list_id,className:"btcd-paper-inp w-5",children:[s.jsx("option",{value:"",children:r("Select Fluent CRM list","bit-integrations")}),(e==null?void 0:e.fluentCrmList)&&Object.keys(e.fluentCrmList).map(t=>s.jsx("option",{value:e.fluentCrmList[t].id,children:e.fluentCrmList[t].title},t))]}),s.jsx("button",{onClick:()=>w(l,e,i,a,h,p),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":`'${r("Refresh List, Tag & Field","bit-integrations")}'`},type:"button",disabled:n,children:"↻"})]}),(e==null?void 0:e.actionName)&&(e==null?void 0:e.actionName)!=="remove-user"&&(e==null?void 0:e.fluentCrmTags)&&!a.fluentCrmTags&&s.jsxs("div",{className:"flx mt-5",children:[s.jsx("b",{className:"wdt-200 d-in-b",children:r("Fluent CRM Tags: ","bit-integrations")}),s.jsx(B,{defaultValue:e==null?void 0:e.tags,className:"btcd-paper-drpdwn w-5",options:(e==null?void 0:e.fluentCrmTags)&&Object.keys(e.fluentCrmTags).map(t=>({label:e.fluentCrmTags[t].title,value:e.fluentCrmTags[t].id.toString()})),onChange:t=>j(t)}),s.jsx("button",{onClick:()=>$(l,e,i,a,h,p),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":`'${r("Refresh Tag & Field","bit-integrations")}'`},type:"button",disabled:n,children:"↻"})]}),n&&s.jsx(R,{style:{display:"flex",justifyContent:"center",alignItems:"center",height:100,transform:"scale(0.7)"}}),(e==null?void 0:e.actionName)&&!n&&s.jsxs(s.Fragment,{children:[s.jsx("div",{className:"mt-4",children:s.jsx("b",{className:"wdt-100",children:r("Map Fields","bit-integrations")})}),s.jsx("div",{className:"btcd-hr mt-1"}),s.jsxs("div",{className:"flx flx-around mt-2 mb-2 btcbi-field-map-label",children:[s.jsx("div",{className:"txt-dp",children:s.jsx("b",{children:r("Form Fields","bit-integrations")})}),s.jsx("div",{className:"txt-dp",children:s.jsx("b",{children:r("Fluent CRM Fields","bit-integrations")})})]}),e.field_map.map((t,c)=>s.jsx(Q,{i:c,field:t,fluentCrmConf:e,formFields:d,setFluentCrmConf:i},`fluentcrm-m-${c+9}`)),s.jsx("div",{className:"txt-center btcbi-field-map-button mt-2",style:{marginRight:85},children:s.jsx("button",{onClick:()=>D(e.field_map.length,e,i),className:"icn-btn sh-sm",type:"button",children:"+"})})]}),(e==null?void 0:e.actionName)==="add-user"&&s.jsxs(s.Fragment,{children:[s.jsx("br",{}),s.jsx("div",{className:"mt-4",children:s.jsx("b",{className:"wdt-100",children:r("Actions","bit-integrations")})}),s.jsx("div",{className:"btcd-hr mt-1"}),s.jsx(K,{fluentCrmConf:e,setFluentCrmConf:i,setIsLoading:b,setSnackbar:p})]})]})}export{f as F,S as c,Z as h};
