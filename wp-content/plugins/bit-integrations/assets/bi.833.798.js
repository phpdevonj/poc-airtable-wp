var _=Object.defineProperty;var j=Object.getOwnPropertySymbols;var o=Object.prototype.hasOwnProperty,w=Object.prototype.propertyIsEnumerable;var g=(e,l,r)=>l in e?_(e,l,{enumerable:!0,configurable:!0,writable:!0,value:r}):e[l]=r,b=(e,l)=>{for(var r in l||(l={}))o.call(l,r)&&g(e,r,l[r]);if(j)for(var r of j(l))w.call(l,r)&&g(e,r,l[r]);return e};import{d as I,j as t,L}from"./main-149.js";import{m as M,_ as n,n as S,o as $}from"./bi.738.82.js";import{h as F,a as N,d as q}from"./bi.236.799.js";import{g as R,a as V}from"./bi.794.797.js";import{T}from"./bi.653.689.js";function P({i:e,field:l,formFields:r,klaviyoConf:i,setKlaviyoConf:c}){var p,x;const h=I(M),{isPro:m}=h;if(((p=i==null?void 0:i.field_map)==null?void 0:p.length)===1&&l.klaviyoFormField===""){const s=b({},i),u=R(s);s.field_map=u,c(s)}const a=(i==null?void 0:i.klaviyoFields.filter(s=>s.required===!0))||[],d=(i==null?void 0:i.klaviyoFields.filter(s=>s.required===!1))||[];return t.jsx("div",{className:"flx mt-2 mb-2 btcbi-field-map",children:t.jsxs("div",{className:"pos-rel flx",children:[t.jsxs("div",{className:"flx integ-fld-wrp",children:[t.jsxs("select",{className:"btcd-paper-inp mr-2",name:"formField",onChange:s=>{F(s,e,i,c)},value:l.formField||"",children:[t.jsx("option",{value:"",children:n("Select Field","bit-integrations")}),t.jsx("optgroup",{label:"Form Fields",children:r==null?void 0:r.map(s=>t.jsx("option",{value:s.name,children:s.label},`ff-rm-${s.name}`))}),t.jsx("option",{value:"custom",children:n("Custom...","bit-integrations")}),t.jsx("optgroup",{label:`General Smart Codes ${m?"":"(PRO)"}`,children:m&&((x=S)==null?void 0:x.map(s=>t.jsx("option",{value:s.name,children:s.label},`ff-rm-${s.name}`)))})]}),l.formField==="custom"&&t.jsx(T,{onChange:s=>$(s,e,i,c),label:n("Custom Value","bit-integrations"),className:"mr-2",type:"text",value:l.customValue,placeholder:n("Custom Value","bit-integrations"),formFields:r}),t.jsxs("select",{className:"btcd-paper-inp",disabled:e<a.length,name:"klaviyoFormField",onChange:s=>{F(s,e,i,c)},value:e<a.length?a[e].key||"":l.klaviyoFormField||"",children:[t.jsx("option",{value:"",children:n("Select Field","bit-integrations")}),e<a.length?t.jsx("option",{value:a[e].key,children:a[e].label},a[e].key):d.map(({key:s,label:u})=>t.jsx("option",{value:s,children:u},s))]})]}),t.jsx("button",{onClick:()=>N(e,i,c),className:"icn-btn sh-sm ml-2 mr-1",type:"button",children:"+"}),t.jsx("button",{onClick:()=>q(e,i,c),className:"icn-btn sh-sm ml-1",type:"button","aria-label":"btn",children:t.jsx("span",{className:"btcd-icn icn-trash-2"})})]})})}function D({klaviyoConf:e,setKlaviyoConf:l,formFields:r,loading:i,setLoading:c}){var m;const h=a=>{const d=b({},e),{name:p}=a.target;switch(a.target.value!==""?d[p]=a.target.value:delete d[p],d[a.target.name]=a.target.value,a.target.name){case"listId":d.field_map=[{formField:"",klaviyoFormField:""}];break}l(b({},d))};return t.jsxs("div",{children:[t.jsx("b",{className:"wdt-200 d-in-b mt-2",children:n("List:","bit-integrations")}),t.jsxs("select",{name:"listId",value:e.listId,onChange:h,className:"btcd-paper-inp w-5",children:[t.jsx("option",{value:"",children:n("Select List","bit-integrations")}),((m=e==null?void 0:e.default)==null?void 0:m.lists)&&e.default.lists.map(a=>t.jsx("option",{value:a.list_id,children:a.list_name},a.list_id))]}),t.jsx("button",{onClick:()=>V(e,l,i,c),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":'"Refresh list"'},type:"button",disabled:i.list,children:"↻"}),i.list&&t.jsx(L,{style:{display:"flex",justifyContent:"center",alignItems:"center",height:100,transform:"scale(0.7)"}}),(e==null?void 0:e.listId)&&t.jsxs("div",{className:"mt-5",children:[t.jsx("b",{className:"wdt-100",children:n("Field Map","bit-integrations")}),t.jsx("div",{className:"btcd-hr mt-2 mb-4"}),t.jsxs("div",{className:"flx flx-around mt-2 mb-2 btcbi-field-map-label",children:[t.jsx("div",{className:"txt-dp",children:t.jsx("b",{children:n("Form Fields","bit-integrations")})}),t.jsx("div",{className:"txt-dp",children:t.jsx("b",{children:n("Klaviyo Fields","bit-integrations")})})]}),e==null?void 0:e.field_map.map((a,d)=>t.jsx(P,{i:d,field:a,formFields:r,klaviyoConf:e,setKlaviyoConf:l},`ko-m-${d+8}`)),t.jsx("div",{className:"txt-center btcbi-field-map-button mt-2",children:t.jsx("button",{onClick:()=>N(e.field_map.length,e,l),className:"icn-btn sh-sm",type:"button",children:"+"})})]})]})}export{D as K};
