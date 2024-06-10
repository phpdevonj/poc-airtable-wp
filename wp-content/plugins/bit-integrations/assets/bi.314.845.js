var $=Object.defineProperty;var y=Object.getOwnPropertySymbols;var I=Object.prototype.hasOwnProperty,L=Object.prototype.propertyIsEnumerable;var _=(c,i,e)=>i in c?$(c,i,{enumerable:!0,configurable:!0,writable:!0,value:e}):c[i]=e,x=(c,i)=>{for(var e in i||(i={}))I.call(i,e)&&_(c,e,i[e]);if(y)for(var e of y(i))L.call(i,e)&&_(c,e,i[e]);return c};import{d as M,j as t,L as R}from"./main-149.js";import{m as S,l as s,n as k,H as q,T as O,r as T}from"./bi.738.82.js";import{r as H,a as V}from"./bi.179.844.js";function E({i:c,formFields:i,field:e,sendPulseConf:l,setSendPulseConf:d}){var g,v,N,F;const p=e.required,j=((g=l==null?void 0:l.default)==null?void 0:g.fields)&&Object.values((v=l==null?void 0:l.default)==null?void 0:v.fields).filter(a=>!a.required),u=M(S),{isPro:h}=u,m=a=>{const r=x({},l);r.field_map.splice(a,0,{}),d(r)},b=a=>{const r=x({},l);r.field_map.length>1&&r.field_map.splice(a,1),d(r)},o=(a,r)=>{const n=x({},l);n.field_map[r][a.target.name]=a.target.value,a.target.value==="custom"&&(n.field_map[r].customValue=""),d(n)},w=(a,r)=>{const n=x({},l);n.field_map[r].customValue=a.target.value,d(n)};return t.jsxs("div",{className:"flx mt-2 mb-2 btcbi-field-map",children:[t.jsxs("div",{className:"flx integ-fld-wrp",children:[t.jsxs("select",{className:"btcd-paper-inp mr-2",name:"formField",value:e.formField||"",onChange:a=>o(a,c),children:[t.jsx("option",{value:"",children:s("Select Field","bit-integrations")}),t.jsx("optgroup",{label:"List Fields",children:i==null?void 0:i.map(a=>t.jsx("option",{value:a.name,children:a.label},`ff-rm-${a.name}`))}),t.jsx("option",{value:"custom",children:s("Custom...","bit-integrations")}),t.jsx("optgroup",{label:`General Smart Codes ${h?"":"(PRO)"}`,children:h&&((N=k)==null?void 0:N.map(a=>t.jsx("option",{value:a.name,children:a.label},`ff-rm-${a.name}`)))})]}),e.formField==="custom"&&t.jsx(q,{onChange:a=>w(a,c),label:s("Custom Value","bit-integrations"),className:"mr-2",type:"text",value:e.customValue,placeholder:s("Custom Value","bit-integrations")}),t.jsxs("select",{className:"btcd-paper-inp",name:"sendPulseField",value:e.sendPulseField||"",onChange:a=>o(a,c),disabled:p,children:[t.jsx("option",{value:"",children:s("Select Field","bit-integrations")}),p?((F=l==null?void 0:l.default)==null?void 0:F.fields)&&Object.values(l.default.fields).map(a=>t.jsx("option",{value:a.fieldValue,children:a.fieldName},`${a.fieldValue}`)):j&&j.map(a=>t.jsx("option",{value:a.fieldValue,children:a.fieldName},`${a.fieldValue}`))]})]}),!p&&t.jsxs(t.Fragment,{children:[t.jsx("button",{onClick:()=>m(c),className:"icn-btn sh-sm ml-2",type:"button",children:"+"}),t.jsx("button",{onClick:()=>b(c),className:"icn-btn sh-sm ml-2",type:"button","aria-label":"btn",children:t.jsx(O,{})})]})]})}function D({formFields:c,sendPulseConf:i,setSendPulseConf:e,isLoading:l,setIsLoading:d,setSnackbar:p}){var u,h;const j=m=>{const b=m.target.value,o=x({},i);b&&(o.listId=b),V(o,e,d,p)};return t.jsxs(t.Fragment,{children:[t.jsx("br",{}),t.jsx("b",{className:"wdt-200 d-in-b",children:s("List:","bit-integrations")}),t.jsxs("select",{value:i==null?void 0:i.listId,name:"listId",id:"",className:"btcd-paper-inp w-5",onChange:j,children:[t.jsx("option",{value:"",children:s("Select List","bit-integrations")}),((u=i==null?void 0:i.default)==null?void 0:u.sendPulseLists)&&Object.keys(i.default.sendPulseLists).map(m=>t.jsx("option",{value:i.default.sendPulseLists[m].listId,children:i.default.sendPulseLists[m].listName},`${m+1}`))]}),t.jsx("button",{onClick:()=>H(i,e,d,p),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":'"Refresh SendPulse list"'},type:"button",disabled:l,children:"↻"}),t.jsx("br",{}),t.jsx("br",{}),l&&t.jsx(R,{style:{display:"flex",justifyContent:"center",alignItems:"center",height:100,translist:"scale(0.7)"}}),t.jsxs("div",{className:"mt-4",children:[t.jsx("b",{className:"wdt-100",children:s("Map Fields","bit-integrations")}),t.jsx("button",{onClick:()=>V(i,e,d,p),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":`'${s("Refresh SendPulse Field","bit-integrations")}'`},type:"button",disabled:l,children:"↻"})]}),((i==null?void 0:i.listId)||((h=i==null?void 0:i.default)==null?void 0:h.fields))&&t.jsxs(t.Fragment,{children:[t.jsx("div",{className:"btcd-hr mt-1"}),t.jsxs("div",{className:"flx flx-around mt-2 mb-2 btcbi-field-map-label",children:[t.jsx("div",{className:"txt-dp",children:t.jsx("b",{children:s("List Fields","bit-integrations")})}),t.jsx("div",{className:"txt-dp",children:t.jsx("b",{children:s("SendPulse Fields","bit-integrations")})})]}),i.field_map.map((m,b)=>t.jsx(E,{i:b,field:m,sendPulseConf:i,formFields:c,setSendPulseConf:e},`SendPulse-m-${b+9}`)),t.jsx("div",{className:"txt-center btcbi-field-map-button mt-2",children:t.jsx("button",{onClick:()=>T(i.field_map.length,i,e),className:"icn-btn sh-sm",type:"button",children:"+"})}),t.jsx("br",{}),t.jsx("br",{})]})]})}export{D as S};
