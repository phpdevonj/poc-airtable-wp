var _=Object.defineProperty;var F=Object.getOwnPropertySymbols;var k=Object.prototype.hasOwnProperty,I=Object.prototype.propertyIsEnumerable;var g=(e,i,n)=>i in e?_(e,i,{enumerable:!0,configurable:!0,writable:!0,value:n}):e[i]=n,r=(e,i)=>{for(var n in i||(i={}))k.call(i,n)&&g(e,n,i[n]);if(F)for(var n of F(i))I.call(i,n)&&g(e,n,i[n]);return e};import{d as L,j as s,L as T}from"./main-149.js";import{m as S,_ as l,n as $,o as R,L as q}from"./bi.738.82.js";import{h as y,a as w,d as V}from"./bi.236.799.js";import{T as A}from"./bi.653.689.js";import{g as M,a as P,b as u}from"./bi.944.806.js";function z({i:e,field:i,formFields:n,mailercloudConf:t,setMailercloudConf:d}){var c,h,b,N;const j=L(S),{isPro:x}=j;if(((c=t==null?void 0:t.field_map)==null?void 0:c.length)===1&&i.mailercloudFormField===""){const a=r({},t),v=M(a);a.field_map=v,d(a)}const m=((h=t==null?void 0:t.default)==null?void 0:h.fields.filter(a=>a.required===!0))||[],p=((b=t==null?void 0:t.default)==null?void 0:b.fields.filter(a=>a.required===!1))||[];return s.jsx("div",{className:"flx mt-2 mb-2 btcbi-field-map",children:s.jsxs("div",{className:"pos-rel flx",children:[s.jsxs("div",{className:"flx integ-fld-wrp",children:[s.jsxs("select",{className:"btcd-paper-inp mr-2",name:"formField",onChange:a=>{y(a,e,t,d)},value:i.formField||"",children:[s.jsx("option",{value:"",children:l("Select Field")}),s.jsx("optgroup",{label:"Form Fields",children:n==null?void 0:n.map(a=>s.jsx("option",{value:a.name,children:a.label},`ff-rm-${a.name}`))}),s.jsx("option",{value:"custom",children:l("Custom...")}),s.jsx("optgroup",{label:`General Smart Codes ${x?"":"(PRO)"}`,children:x&&((N=$)==null?void 0:N.map(a=>s.jsx("option",{value:a.name,children:a.label},`ff-rm-${a.name}`)))})]}),i.formField==="custom"&&s.jsx(A,{onChange:a=>R(a,e,t,d),label:l("Custom Value","bit-integrations"),className:"mr-2",type:"text",value:i.customValue,placeholder:l("Custom Value","bit-integrations"),formFields:n}),s.jsxs("select",{className:"btcd-paper-inp",disabled:e<m.length,name:"mailercloudFormField",onChange:a=>{y(a,e,t,d)},value:e<m.length?m[e].key||"":i.mailercloudFormField||"",children:[s.jsx("option",{value:"",children:l("Select Field")}),e<m.length?s.jsx("option",{value:m[e].key,children:m[e].label},m[e].key):p.map(({key:a,label:v})=>s.jsx("option",{value:a,children:v},a))]})]}),s.jsx("button",{onClick:()=>w(e,t,d),className:"icn-btn sh-sm ml-2 mr-1",type:"button",children:"+"}),s.jsx("button",{onClick:()=>V(e,t,d),className:"icn-btn sh-sm ml-1",type:"button","aria-label":"btn",children:s.jsx("span",{className:"btcd-icn icn-trash-2"})})]})})}function H({mailercloudConf:e,setMailercloudConf:i,formFields:n,loading:t,setLoading:d}){var m;const j=["active","bounce","abuse","unsubscribe","suppressed","spam complaints"],x=p=>{const c=r({},e),{name:h,value:b}=p.target;switch(b!==""?c[h]=b:delete c[h],h){case"listId":c.field_map=[{formField:"",mailercloudFormField:""}],c.contactType="";break}u(c,i,t,d),i(r({},c))};return s.jsxs("div",{className:"mt-2",children:[!t.page&&s.jsxs("div",{className:"flx mt-2",children:[s.jsx("b",{className:"wdt-200 d-in-b ",children:l("List:")}),s.jsxs("select",{onChange:x,name:"listId",value:e==null?void 0:e.listId,className:"btcd-paper-inp w-5 mx-0",children:[s.jsx("option",{value:"",children:l("Select List")}),((m=e==null?void 0:e.default)==null?void 0:m.lists)&&e.default.lists.map(p=>s.jsx("option",{value:p.id,children:p.name},p.id))]}),s.jsx("button",{onClick:()=>P(e,i,t,d),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":'"Refresh list"'},type:"button",disabled:t.list,children:"↻"}),t.list&&s.jsx(q,{size:"20",clr:"#022217",className:"ml-2"})]}),e.listId&&s.jsxs("div",{className:"flx mt-2",children:[s.jsx("b",{className:"wdt-200 d-in-b ",children:l("Contact type:")}),s.jsxs("select",{onChange:x,name:"contactType",value:e==null?void 0:e.contactType,className:"btcd-paper-inp w-5 mx-0",children:[s.jsx("option",{value:"",children:l("Select Type")}),j.map(p=>s.jsx("option",{value:p,children:p.toUpperCase()},p))]})]}),s.jsxs("div",{className:"mt-4",children:[s.jsx("b",{className:"wdt-100",children:l("Map Fields","bit-integrations")}),s.jsx("button",{onClick:()=>u(e,i,t,d),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":`'${l("Refresh Mailer Cloud Field","bit-integrations")}'`},type:"button",disabled:t.field,children:"↻"})]}),(t.page||t.field)&&s.jsx(T,{style:{display:"flex",justifyContent:"center",alignItems:"center",height:100,transform:"scale(0.7)"}}),(e==null?void 0:e.listId)&&e.default.fields&&s.jsxs("div",{className:"mt-5",children:[s.jsx("b",{className:"wdt-100",children:l("Field Map")}),s.jsx("div",{className:"btcd-hr mt-2 mb-4"}),s.jsxs("div",{className:"flx flx-around mt-2 mb-2 btcbi-field-map-label",children:[s.jsx("div",{className:"txt-dp",children:s.jsx("b",{children:l("Form Fields")})}),s.jsx("div",{className:"txt-dp",children:s.jsx("b",{children:l("Mailercloud Fields")})})]}),e==null?void 0:e.field_map.map((p,c)=>s.jsx(z,{i:c,field:p,formFields:n,mailercloudConf:e,setMailercloudConf:i},`ko-m-${c+8}`)),s.jsx("div",{className:"txt-center btcbi-field-map-button mt-2",children:s.jsx("button",{onClick:()=>w(e.field_map.length,e,i),className:"icn-btn sh-sm",type:"button",children:"+"})})]})]})}export{H as M};
