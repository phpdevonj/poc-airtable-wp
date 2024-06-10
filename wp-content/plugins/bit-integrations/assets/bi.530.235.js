var Z=Object.defineProperty;var y=Object.getOwnPropertySymbols;var _=Object.prototype.hasOwnProperty,z=Object.prototype.propertyIsEnumerable;var g=(a,t,l)=>t in a?Z(a,t,{enumerable:!0,configurable:!0,writable:!0,value:l}):a[t]=l,h=(a,t)=>{for(var l in t||(t={}))_.call(t,l)&&g(a,l,t[l]);if(y)for(var l of y(t))z.call(t,l)&&g(a,l,t[l]);return a};import{r as T,d as I,j as e}from"./main-149.js";import{m as D,_ as s,Y as w,Z as P,L as $}from"./bi.738.82.js";import{B}from"./bi.150.726.js";import{r as U}from"./bi.372.707.js";import{T as A,t as O}from"./bi.452.742.js";function K({formID:a,marketingHubConf:t,setMarketingHubConf:l,step:x,setstep:E,isLoading:p,setIsLoading:j,setSnackbar:c,redirectLocation:L,isInfo:n}){const[o,C]=T.useState(!1),[r,b]=T.useState({dataCenter:"",clientId:"",clientSecret:""}),u=I(D),R="ZohoMarketingHub.lead.READ,ZohoMarketingHub.lead.CREATE,ZohoMarketingHub.lead.UPDATE",{zohoMarketingHub:i}=O,S=()=>{setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),E(2),U(a,t,l,j,c)},d=m=>{const v=h({},t),N=h({},r);N[m.target.name]="",v[m.target.name]=m.target.value,b(N),l(v)};return e.jsxs("div",{className:"btcd-stp-page",style:{width:x===1&&900,height:x===1&&"auto"},children:[(i==null?void 0:i.youTubeLink)&&e.jsx(A,{title:i==null?void 0:i.title,youTubeLink:i==null?void 0:i.youTubeLink}),(i==null?void 0:i.docLink)&&e.jsx(A,{title:i==null?void 0:i.title,docLink:i==null?void 0:i.docLink}),e.jsx("div",{className:"mt-3",children:e.jsx("b",{children:s("Integration Name:","bit-integrations")})}),e.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:d,name:"name",value:t.name,type:"text",placeholder:s("Integration Name...","bit-integrations"),disabled:n}),e.jsx("div",{className:"mt-3",children:e.jsx("b",{children:s("Data Center:","bit-integrations")})}),e.jsxs("select",{onChange:d,name:"dataCenter",value:t.dataCenter,className:"btcd-paper-inp w-6 mt-1",disabled:n,children:[e.jsx("option",{value:"",children:s("--Select a data center--","bit-integrations")}),e.jsx("option",{value:"com",children:"zoho.com"}),e.jsx("option",{value:"eu",children:"zoho.eu"}),e.jsx("option",{value:"com.cn",children:"zoho.com.cn"}),e.jsx("option",{value:"in",children:"zoho.in"}),e.jsx("option",{value:"com.au",children:"zoho.com.au"})]}),e.jsx("div",{style:{color:"red"},children:r.dataCenter}),e.jsx("div",{className:"mt-3",children:e.jsx("b",{children:s("Homepage URL:","bit-integrations")})}),e.jsx(w,{value:`${window.location.origin}`,className:"field-key-cpy w-6 ml-0",readOnly:n,setSnackbar:c}),e.jsx("div",{className:"mt-3",children:e.jsx("b",{children:s("Authorized Redirect URIs:","bit-integrations")})}),e.jsx(w,{value:L||`${u.api.base}/redirect`,className:"field-key-cpy w-6 ml-0",setSnackbar:c,readOnly:n}),e.jsxs("small",{className:"d-blk mt-5",children:[s("To get Client ID and SECRET , Please Visit","bit-integrations")," ",e.jsx("a",{className:"btcd-link",href:`https://api-console.zoho.${(t==null?void 0:t.dataCenter)||"com"}/`,target:"_blank",rel:"noreferrer",children:s("Zoho API Console","bit-integrations")})]}),e.jsx("div",{className:"mt-3",children:e.jsx("b",{children:s("Client id:","bit-integrations")})}),e.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:d,name:"clientId",value:t.clientId,type:"text",placeholder:s("Client id...","bit-integrations"),disabled:n}),e.jsx("div",{style:{color:"red"},children:r.clientId}),e.jsx("div",{className:"mt-3",children:e.jsx("b",{children:s("Client secret:","bit-integrations")})}),e.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:d,name:"clientSecret",value:t.clientSecret,type:"text",placeholder:s("Client secret...","bit-integrations"),disabled:n}),e.jsx("div",{style:{color:"red"},children:r.clientSecret}),!n&&e.jsxs(e.Fragment,{children:[e.jsxs("button",{onClick:()=>P("zohoMarkatingHub","zmarketingHub",R,t,l,b,C,j,c,u),className:"btn btcd-btn-lg green sh-sm flx",type:"button",disabled:o||p,children:[o?s("Authorized ✔","bit-integrations"):s("Authorize","bit-integrations"),p&&e.jsx($,{size:20,clr:"#022217",className:"ml-2"})]}),e.jsx("br",{}),e.jsxs("button",{onClick:S,className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",disabled:!o,children:[s("Next","bit-integrations"),e.jsx(B,{className:"ml-1 rev-icn"})]})]})]})}export{K as default};
