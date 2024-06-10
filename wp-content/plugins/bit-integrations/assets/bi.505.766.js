var F=Object.defineProperty;var g=Object.getOwnPropertySymbols;var N=Object.prototype.hasOwnProperty,_=Object.prototype.propertyIsEnumerable;var j=(l,a,t)=>a in l?F(l,a,{enumerable:!0,configurable:!0,writable:!0,value:t}):l[a]=t,h=(l,a)=>{for(var t in a||(a={}))N.call(a,t)&&j(l,t,a[t]);if(g)for(var t of g(a))_.call(a,t)&&j(l,t,a[t]);return l};import{d as M,j as e}from"./main-149.js";import{m as y,_ as n,n as w,o as A,r as $}from"./bi.738.82.js";import{g as k,z as R}from"./bi.309.767.js";import{T as S}from"./bi.653.689.js";const V=(l,a,t)=>{const s=h({},a);s.field_map.splice(l,0,{}),t(h({},s))},q=(l,a,t)=>{const s=h({},a);s.field_map.length>1&&s.field_map.splice(l,1),t(h({},s))},v=(l,a,t,s)=>{const c=h({},t);c.field_map[a][l.target.name]=l.target.value,l.target.value==="custom"&&(c.field_map[a].customValue=""),s(h({},c))};function T({i:l,formFields:a,field:t,zoomConf:s,setZoomConf:c}){var d,m;if(((d=s==null?void 0:s.field_map)==null?void 0:d.length)===1&&t.zoomField===""){const i=h({},s),u=k(i);i.field_map=u,c(i)}const r=(s==null?void 0:s.zoomFields.filter(i=>i.required===!0))||[],x=(s==null?void 0:s.zoomFields.filter(i=>i.required===!1))||[],b=M(y),{isPro:p}=b;return e.jsx("div",{className:"flx mt-2 mr-1",children:e.jsxs("div",{className:"pos-rel flx",children:[e.jsxs("div",{className:"flx integ-fld-wrp",children:[e.jsxs("select",{className:"btcd-paper-inp mr-2",name:"formField",value:t.formField||"",onChange:i=>v(i,l,s,c),children:[e.jsx("option",{value:"",children:n("Select Field","bit-integrations")}),e.jsx("optgroup",{label:"Form Fields",children:a==null?void 0:a.map(i=>e.jsx("option",{value:i.name,children:i.label},`ff-rm-${i.name}`))}),e.jsx("option",{value:"custom",children:n("Custom...","bit-integrations")}),e.jsx("optgroup",{label:`General Smart Codes ${p?"":"(PRO)"}`,children:p&&((m=w)==null?void 0:m.map(i=>e.jsx("option",{value:i.name,children:i.label},`ff-rm-${i.name}`)))})]}),t.formField==="custom"&&e.jsx(S,{onChange:i=>A(i,l,s,c),label:n("Custom Value","bit-integrations"),className:"mr-2",type:"text",value:t.customValue,placeholder:n("Custom Value","bit-integrations"),formFields:a}),e.jsxs("select",{className:"btcd-paper-inp",disabled:l<r.length,name:"zoomField",value:l<r.length?r[l].key||"":t.zoomField||"",onChange:i=>v(i,l,s,c),children:[e.jsx("option",{value:"",children:n("Select Field","bit-integrations")}),l<r.length?e.jsx("option",{value:r[l].key,children:r[l].label},r[l].key):x.map(({key:i,label:u})=>e.jsx("option",{value:i,children:u},i))]})]}),l>=r.length&&e.jsxs(e.Fragment,{children:[e.jsx("button",{onClick:()=>V(l,s,c),className:"icn-btn sh-sm ml-2 mr-1",type:"button",children:"+"}),e.jsx("button",{onClick:()=>q(l,s,c),className:"icn-btn sh-sm ml-1",type:"button","aria-label":"btn",children:e.jsx("span",{className:"btcd-icn icn-trash-2"})})]})]})})}function O({formFields:l,handleInput:a,zoomConf:t,setZoomConf:s,isLoading:c,setIsLoading:r,setSnackbar:x}){var b;return e.jsxs(e.Fragment,{children:[e.jsx("br",{}),e.jsx("b",{className:"wdt-200 d-in-b",children:n("All Meetings:","bit-integrations")}),e.jsxs("select",{onChange:a,name:"id",value:t.id,className:"btcd-paper-inp w-5",children:[e.jsx("option",{value:"",children:n("Select Meeting","bit-integrations")}),((b=t==null?void 0:t.default)==null?void 0:b.allMeeting)&&t.default.allMeeting.map(({id:p,topic:d})=>e.jsx("option",{value:p,children:d},p))]}),e.jsx("button",{onClick:()=>R(null,t,s,r,x),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":`'${n("Fetch All Meeting","bit-integrations")}'`},type:"button",disabled:c,children:"↻"}),e.jsx("br",{}),e.jsx("br",{}),e.jsx("b",{className:"wdt-200 d-in-b",children:n("Action:","bit-integrations")}),e.jsxs("select",{onChange:a,name:"selectedActions",value:t.selectedActions,className:"btcd-paper-inp w-5",children:[e.jsx("option",{value:"",children:n("Select Action","bit-integrations")}),(t==null?void 0:t.allActions)&&t.allActions.map(({key:p,value:d})=>e.jsx("option",{value:d,children:d},p))]}),e.jsx("div",{className:"mt-5",children:e.jsx("b",{className:"wdt-100",children:n("Field Map","bit-integrations")})}),e.jsx("div",{className:"btcd-hr mt-1"}),e.jsxs("div",{className:"flx flx-around mt-2 mb-1",children:[e.jsx("div",{className:"txt-dp",children:e.jsx("b",{children:n("Form Fields","bit-integrations")})}),e.jsx("div",{className:"txt-dp",children:e.jsx("b",{children:n("Zoom Fields","bit-integrations")})})]}),t==null?void 0:t.field_map.map((p,d)=>e.jsx(T,{i:d,field:p,zoomConf:t,formFields:l,setZoomConf:s,setSnackbar:x},`rp-m-${d+9}`)),e.jsx("div",{className:"txt-center  mt-2",style:{marginRight:85},children:e.jsx("button",{onClick:()=>$(t.field_map.length,t,s,!1),className:"icn-btn sh-sm",type:"button",children:"+"})}),e.jsx("br",{}),e.jsx("br",{})]})}export{O as Z};
