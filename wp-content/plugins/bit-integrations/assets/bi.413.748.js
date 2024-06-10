var F=Object.defineProperty;var h=Object.getOwnPropertySymbols;var v=Object.prototype.hasOwnProperty,_=Object.prototype.propertyIsEnumerable;var j=(s,r,t)=>r in s?F(s,r,{enumerable:!0,configurable:!0,writable:!0,value:t}):s[r]=t,p=(s,r)=>{for(var t in r||(r={}))v.call(r,t)&&j(s,t,r[t]);if(h)for(var t of h(r))_.call(r,t)&&j(s,t,r[t]);return s};import{d as w,j as e}from"./main-149.js";import{m as y,_ as c,n as M,o as V,p as $}from"./bi.738.82.js";import{g as k,a as R}from"./bi.675.747.js";import{T as S}from"./bi.653.689.js";const N=(s,r,t)=>{const n=p({},r);n.field_map.splice(s,0,{}),t(p({},n))},q=(s,r,t)=>{const n=p({},r);n.field_map.length>1&&n.field_map.splice(s,1),t(p({},n))},g=(s,r,t,n)=>{const l=p({},t);l.field_map[r][s.target.name]=s.target.value,s.target.value==="custom"&&(l.field_map[r].customValue=""),n(p({},l))};function L({i:s,formFields:r,field:t,elasticEmailConf:n,setElasticEmailConf:l}){var a,b;if(((a=n==null?void 0:n.field_map)==null?void 0:a.length)===1&&t.elasticEmailField===""){const d=p({},n),x=k(d);d.field_map=x,l(d)}const i=(n==null?void 0:n.elasticEmailFields.filter(d=>d.required===!0))||[],o=(n==null?void 0:n.elasticEmailFields.filter(d=>d.required===!1))||[],m=w(y),{isPro:u}=m;return e.jsx("div",{className:"flx mt-2 mb-2 btcbi-field-map",children:e.jsxs("div",{className:"pos-rel flx",children:[e.jsxs("div",{className:"flx integ-fld-wrp",children:[e.jsxs("select",{className:"btcd-paper-inp mr-2",name:"formField",value:t.formField||"",onChange:d=>g(d,s,n,l),children:[e.jsx("option",{value:"",children:c("Select Field","bit-integrations")}),e.jsx("optgroup",{label:"Form Fields",children:r==null?void 0:r.map(d=>e.jsx("option",{value:d.name,children:d.label},`ff-rm-${d.name}`))}),e.jsx("option",{value:"custom",children:c("Custom...","bit-integrations")}),e.jsx("optgroup",{label:`General Smart Codes ${u?"":"(PRO)"}`,children:u&&((b=M)==null?void 0:b.map(d=>e.jsx("option",{value:d.name,children:d.label},`ff-rm-${d.name}`)))})]}),t.formField==="custom"&&e.jsx(S,{onChange:d=>V(d,s,n,l),label:c("Custom Value","bit-integrations"),className:"mr-2",type:"text",value:t.customValue,placeholder:c("Custom Value","bit-integrations"),formFields:r}),e.jsxs("select",{className:"btcd-paper-inp",disabled:s<i.length,name:"elasticEmailField",value:s<i.length?i[s].label||"":t.elasticEmailField||"",onChange:d=>g(d,s,n,l),children:[e.jsx("option",{value:"",children:c("Select Field","bit-integrations")}),s<i.length?e.jsx("option",{value:i[s].key,children:i[s].label},i[s].key):o.map(({key:d,label:x})=>e.jsx("option",{value:d,children:x},d))]})]}),s>=i.length&&e.jsxs(e.Fragment,{children:[e.jsx("button",{onClick:()=>N(s,n,l),className:"icn-btn sh-sm ml-2 mr-1",type:"button",children:"+"}),e.jsx("button",{onClick:()=>q(s,n,l),className:"icn-btn sh-sm ml-1",type:"button","aria-label":"btn",children:e.jsx("span",{className:"btcd-icn icn-trash-2"})})]})]})})}function O({formFields:s,handleInput:r,elasticEmailConf:t,setElasticEmailConf:n,isLoading:l,setIsLoading:i,setSnackbar:o}){var u;const m=a=>{const b=p({},t);b.list_id=a?a.split(","):[],n(p({},b))};return e.jsxs(e.Fragment,{children:[e.jsx("br",{}),e.jsxs("div",{className:"flx",children:[e.jsx("b",{className:"wdt-200 d-in-b",children:c("Lists:","bit-integrations")}),e.jsx($,{defaultValue:t.list_id,className:"btcd-paper-drpdwn w-5",options:((u=t==null?void 0:t.default)==null?void 0:u.lists)&&t.default.lists.map(a=>({label:a.listName,value:a.listName.toString()})),onChange:a=>m(a)}),e.jsx("button",{onClick:()=>R(t,n,i),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":`'${c("Fetch All Recipients","bit-integrations")}'`},type:"button",disabled:l,children:"↻"})]}),e.jsx("br",{}),e.jsx("div",{className:"mt-5",children:e.jsx("b",{className:"wdt-100",children:c("Field Map","bit-integrations")})}),e.jsx("div",{className:"btcd-hr mt-1"}),e.jsxs("div",{className:"flx flx-around mt-2 mb-2 btcbi-field-map-label",children:[e.jsx("div",{className:"txt-dp",children:e.jsx("b",{children:c("Form Fields","bit-integrations")})}),e.jsx("div",{className:"txt-dp",children:e.jsx("b",{children:c("Elastic Email Fields","bit-integrations")})})]}),t.list_id&&(t==null?void 0:t.field_map.map((a,b)=>e.jsx(L,{i:b,field:a,elasticEmailConf:t,formFields:s,setElasticEmailConf:n,setSnackbar:o},`rp-m-${b+9}`))),e.jsx("div",{className:"txt-center btcbi-field-map-button mt-2",children:e.jsx("button",{onClick:()=>N(t.field_map.length,t,n),className:"icn-btn sh-sm",type:"button",children:"+"})}),e.jsx("br",{}),e.jsx("br",{})]})}export{O as E};
