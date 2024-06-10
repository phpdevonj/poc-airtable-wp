var q=Object.defineProperty;var _=Object.getOwnPropertySymbols;var $=Object.prototype.hasOwnProperty,I=Object.prototype.propertyIsEnumerable;var y=(l,n,d)=>n in l?q(l,n,{enumerable:!0,configurable:!0,writable:!0,value:d}):l[n]=d,j=(l,n)=>{for(var d in n||(n={}))$.call(n,d)&&y(l,d,n[d]);if(_)for(var d of _(n))I.call(n,d)&&y(l,d,n[d]);return l};import{j as a,d as O,L as R}from"./main-149.js";import{_ as t,T as w,q as g,m as V,n as f,o as z,p as L}from"./bi.738.82.js";import{h as M,d as P,a as T,b as k,c as U,e as B}from"./bi.298.716.js";import{r as D,a as E}from"./bi.913.714.js";import{T as G}from"./bi.653.689.js";function H({i:l,formFields:n,field:d,sheetConf:e,setSheetConf:r,addressField:p}){const u=d.required,b=p.filter(i=>!i.required);return a.jsxs("div",{className:"flx mt-2 mb-2 btcbi-field-map",children:[a.jsxs("select",{className:"btcd-paper-inp mr-2",name:"formField",value:d.formField||"",onChange:i=>M(i,l,e,r),children:[a.jsx("option",{value:"",children:t("Select Field","bit-integrations")}),n.map(i=>i.type!=="file"&&a.jsx("option",{value:i.name,children:i.label},`ff-zhcrm-${i.name}`))]}),a.jsxs("select",{className:"btcd-paper-inp",name:"mailChimpAddressField",value:d.mailChimpAddressField||"",onChange:i=>M(i,l,e,r),disabled:u,children:[a.jsx("option",{value:"",children:t("Select Field","bit-integrations")}),u?Object.values(p).map((i,m)=>a.jsx("option",{value:i.tag,children:i.name},`add-${m*2}`)):Object.values(b).map((i,m)=>a.jsx("option",{value:i.tag,children:i.name},`add-${m*2}`))]}),!u&&a.jsx("button",{onClick:()=>P(l,e,r),className:"icn-btn sh-sm ml-1",type:"button","aria-label":"btn",children:a.jsx(w,{})})]})}function Z({sheetConf:l,setSheetConf:n,formFields:d,address:e}){var p,u,b;const r=(i,m)=>{const s=j({},l);m==="update"&&(i.target.checked?s.actions.update=!0:delete s.actions.update),m==="double_opt_in"&&(i.target.checked?s.actions.double_opt_in=!0:delete s.actions.double_opt_in),m==="address"&&(i.target.checked?(s.actions.address=!0,s.address_field=e.filter(x=>x.required).map(x=>({formField:"",mailChimpAddressField:x.tag,required:!0}))):(delete s.actions.address,s.address_field="")),n(j({},s))};return a.jsxs("div",{className:"pos-rel d-flx w-8",children:[a.jsx(g,{checked:((p=l.actions)==null?void 0:p.address)||!1,onChange:i=>r(i,"address"),className:"wdt-200 mt-4 mr-2",value:"address",title:t("Add Address Field","bit-integrations"),subTitle:t("Add Address Field","bit-integrations")}),a.jsx(g,{checked:((u=l.actions)==null?void 0:u.double_opt_in)||!1,onChange:i=>r(i,"double_opt_in"),className:"wdt-200 mt-4 mr-2",value:"double_opt_in",title:t("Double Opt-in","bit-integrations"),subTitle:t("Add Double Opt-in","bit-integrations")}),a.jsx(g,{checked:((b=l.actions)==null?void 0:b.update)||!1,onChange:i=>r(i,"update"),className:"wdt-200 mt-4 mr-2",value:"user_share",title:t("Update Mail Chimp","bit-integrations"),subTitle:t("Update Responses with MailChimp exist Aduience?","bit-integrations")})]})}function J({i:l,formFields:n,field:d,sheetConf:e,setSheetConf:r}){var b,i,m;const p=O(V),{isPro:u}=p;return a.jsxs("div",{className:"flx mt-2 mb-2 btcbi-field-map",children:[a.jsxs("div",{className:"flx integ-fld-wrp",children:[a.jsxs("select",{className:"btcd-paper-inp mr-2",name:"formField",value:d.formField||"",onChange:s=>T(s,l,e,r),children:[a.jsx("option",{value:"",children:t("Select Field","bit-integrations")}),a.jsx("optgroup",{label:"Form Fields",children:n.map(s=>s.type!=="file"&&a.jsx("option",{value:s.name,children:s.label},`ff-zhcrm-${s.name}`))}),a.jsx("option",{value:"custom",children:t("Custom...","bit-integrations")}),a.jsx("optgroup",{label:`General Smart Codes ${u?"":"(PRO)"}`,children:u&&((b=f)==null?void 0:b.map(s=>a.jsx("option",{value:s.name,children:s.label},`ff-rm-${s.name}`)))})]}),d.formField==="custom"&&a.jsx(G,{onChange:s=>z(s,l,e,r),label:t("Custom Value","bit-integrations"),className:"mr-2",type:"text",value:d.customValue,placeholder:t("Custom Value","bit-integrations"),formFields:n}),a.jsxs("select",{className:"btcd-paper-inp",name:"mailChimpField",value:d.mailChimpField||"",onChange:s=>T(s,l,e,r),children:[a.jsx("option",{value:"",children:t("Select Field","bit-integrations")}),((m=(i=e.default)==null?void 0:i.fields)==null?void 0:m[e.listId])&&Object.values(e.default.fields[e.listId]).map((s,x)=>a.jsx("option",{value:s.tag,children:s.name},`mchimp-${x*2}`))]})]}),a.jsx("button",{onClick:()=>k(l,e,r),className:"icn-btn sh-sm ml-2 mr-1",type:"button",children:"+"}),a.jsx("button",{onClick:()=>U(l,e,r),className:"icn-btn sh-sm ml-1",type:"button","aria-label":"btn",children:a.jsx(w,{})})]})}function C({formID:l,formFields:n,handleInput:d,sheetConf:e,setSheetConf:r,isLoading:p,setIsLoading:u,setSnackbar:b,a:i}){var x,h,v,N,F,A;const m=[{tag:"addr1",name:"Address 1",required:!0},{tag:"addr2",name:"Address 2",required:!1},{tag:"city",name:"City",required:!0},{tag:"zip",name:"Zip",required:!0},{tag:"state",name:"State",required:!0},{tag:"country",name:"Country",required:!1}],s=c=>{const o=j({},e);c?o.tags=c?c.split(","):[]:delete o.tags,r(j({},o))};return a.jsxs(a.Fragment,{children:[a.jsx("br",{}),a.jsx("b",{className:"wdt-200 d-in-b",children:t("Audience List:","bit-integrations")}),a.jsxs("select",{onChange:d,name:"listId",value:e.listId,className:"btcd-paper-inp w-5",children:[a.jsx("option",{value:"",children:t("Select Audience List","bit-integrations")}),((x=e==null?void 0:e.default)==null?void 0:x.audiencelist)&&Object.keys(e.default.audiencelist).map(c=>a.jsx("option",{value:e.default.audiencelist[c].listId,children:e.default.audiencelist[c].listName},c))]}),a.jsx("button",{onClick:()=>D(l,e,r,u,b),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":'"Refresh Audience list"'},type:"button",disabled:p,children:"↻"}),a.jsx("br",{}),a.jsx("br",{}),a.jsxs("div",{className:"d-flx",children:[a.jsx("b",{style:{marginTop:"15px"},className:"wdt-200 d-in-b",children:t("Tags: ","bit-integrations")}),a.jsx(L,{defaultValue:e==null?void 0:e.tags,className:"btcd-paper-drpdwn w-5",options:((h=e==null?void 0:e.default)==null?void 0:h.audienceTags)&&Object.keys(e.default.audienceTags).map(c=>({label:e.default.audienceTags[c].tagName,value:e.default.audienceTags[c].tagName})),onChange:c=>s(c)}),a.jsx("button",{onClick:()=>E(l,e,r,u,b),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":`'${t("Refresh MailChimp Tags","bit-integrations")}'`},type:"button",disabled:p,children:"↻"})]}),p&&a.jsx(R,{style:{display:"flex",justifyContent:"center",alignItems:"center",height:100,transform:"scale(0.7)"}}),((N=(v=e.default)==null?void 0:v.fields)==null?void 0:N[e.listId])&&a.jsxs(a.Fragment,{children:[a.jsx("div",{className:"mt-4",children:a.jsx("b",{className:"wdt-100",children:t("Map Fields","bit-integrations")})}),a.jsx("div",{className:"btcd-hr mt-1"}),a.jsxs("div",{className:"flx flx-around mt-2 mb-2 btcbi-field-map-label",children:[a.jsx("div",{className:"txt-dp",children:a.jsx("b",{children:t("Form Fields","bit-integrations")})}),a.jsx("div",{className:"txt-dp",children:a.jsx("b",{children:t("Mail Chimp Fields","bit-integrations")})})]}),e.field_map.map((c,o)=>a.jsx(J,{i:o,field:c,sheetConf:e,formFields:n,setSheetConf:r},`sheet-m-${o+9}`)),a.jsx("div",{className:"txt-center btcbi-field-map-button mt-2",children:a.jsx("button",{onClick:()=>k(e.field_map.length,e,r),className:"icn-btn sh-sm",type:"button",children:"+"})}),a.jsx("br",{}),a.jsx("br",{}),((F=e.actions)==null?void 0:F.address)&&a.jsxs(a.Fragment,{children:[a.jsx("div",{className:"mt-4",children:a.jsx("b",{className:"wdt-100",children:t("Address Field Map","bit-integrations")})}),a.jsx("div",{className:"btcd-hr mt-1"}),a.jsxs("div",{className:"flx flx-around mt-2 mb-2 btcbi-field-map-label",children:[a.jsx("div",{className:"txt-dp",children:a.jsx("b",{children:t("Form Address Fields","bit-integrations")})}),a.jsx("div",{className:"txt-dp",children:a.jsx("b",{children:t("Mail Chimp Address Fields","bit-integrations")})})]}),(A=e==null?void 0:e.address_field)==null?void 0:A.map((c,o)=>a.jsx(H,{i:o,field:c,sheetConf:e,formFields:n,setSheetConf:r,addressField:m},`sheet-m-${o+9}`)),a.jsx("div",{className:"txt-center btcbi-field-map-button mt-2",children:a.jsx("button",{onClick:()=>B(e.address_field.length,e,r),className:"icn-btn sh-sm",type:"button",children:"+"})})]}),a.jsx("br",{}),a.jsx("br",{})]}),e.listId&&a.jsxs(a.Fragment,{children:[a.jsx("div",{className:"mt-4",children:a.jsx("b",{className:"wdt-100",children:t("Actions","bit-integrations")})}),a.jsx("div",{className:"btcd-hr mt-1"}),a.jsx(Z,{sheetConf:e,setSheetConf:r,formFields:n,address:m})]})]})}export{C as M};
