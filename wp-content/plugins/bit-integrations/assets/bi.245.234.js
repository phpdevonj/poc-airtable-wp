var Z=Object.defineProperty;var y=Object.getOwnPropertySymbols;var _=Object.prototype.hasOwnProperty,z=Object.prototype.propertyIsEnumerable;var g=(r,t,l)=>t in r?Z(r,t,{enumerable:!0,configurable:!0,writable:!0,value:l}):r[t]=l,h=(r,t)=>{for(var l in t||(t={}))_.call(t,l)&&g(r,l,t[l]);if(y)for(var l of y(t))z.call(t,l)&&g(r,l,t[l]);return r};import{r as k,d as I,j as e}from"./main-149.js";import{m as D,_ as n,Y as T,Z as P,L as $}from"./bi.738.82.js";import{r as B}from"./bi.690.697.js";import{B as U}from"./bi.150.726.js";import{T as w,t as O}from"./bi.452.742.js";function G({formID:r,campaignsConf:t,setCampaignsConf:l,step:b,setstep:A,isLoading:x,setIsLoading:u,setSnackbar:a,redirectLocation:E,isInfo:s}){const[d,L]=k.useState(!1),[c,j]=k.useState({dataCenter:"",clientId:"",clientSecret:""}),p=I(D),R="ZohoCampaigns.contact.READ,ZohoCampaigns.contact.CREATE,ZohoCampaigns.contact.UPDATE",{zohoCampaigns:i}=O,S=()=>{setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),A(2),B(r,t,l,u,a)},o=m=>{const v=h({},t),N=h({},c);N[m.target.name]="",v[m.target.name]=m.target.value,j(N),l(v)};return e.jsxs("div",{className:"btcd-stp-page",style:{width:b===1&&900,height:b===1&&"auto"},children:[(i==null?void 0:i.youTubeLink)&&e.jsx(w,{title:i==null?void 0:i.title,youTubeLink:i==null?void 0:i.youTubeLink}),(i==null?void 0:i.docLink)&&e.jsx(w,{title:i==null?void 0:i.title,docLink:i==null?void 0:i.docLink}),e.jsx("div",{className:"mt-3",children:e.jsx("b",{children:n("Integration Name:","bit-integrations")})}),e.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:o,name:"name",value:t.name,type:"text",placeholder:n("Integration Name...","bit-integrations"),disabled:s}),e.jsx("div",{className:"mt-3",children:e.jsx("b",{children:n("Data Center:","bit-integrations")})}),e.jsxs("select",{onChange:o,name:"dataCenter",value:t.dataCenter,className:"btcd-paper-inp w-6 mt-1",disabled:s,children:[e.jsx("option",{value:"",children:n("--Select a data center--","bit-integrations")}),e.jsx("option",{value:"com",children:"zoho.com"}),e.jsx("option",{value:"eu",children:"zoho.eu"}),e.jsx("option",{value:"com.cn",children:"zoho.com.cn"}),e.jsx("option",{value:"in",children:"zoho.in"}),e.jsx("option",{value:"com.au",children:"zoho.com.au"})]}),e.jsx("div",{style:{color:"red"},children:c.dataCenter}),e.jsx("div",{className:"mt-3",children:e.jsx("b",{children:n("Homepage URL:","bit-integrations")})}),e.jsx(T,{value:`${window.location.origin}`,className:"field-key-cpy w-6 ml-0",setSnackbar:a,readOnly:s}),e.jsx("div",{className:"mt-3",children:e.jsx("b",{children:n("Authorized Redirect URIs:","bit-integrations")})}),e.jsx(T,{value:E||`${p.api.base}/redirect`,className:"field-key-cpy w-6 ml-0",setSnackbar:a,readOnly:s}),e.jsxs("small",{className:"d-blk mt-5",children:[n("To get Client ID and SECRET , Please Visit","bit-integrations")," ",e.jsx("a",{className:"btcd-link",href:`https://api-console.zoho.${(t==null?void 0:t.dataCenter)||"com"}/`,target:"_blank",rel:"noreferrer",children:n("Zoho API Console","bit-integrations")})]}),e.jsx("div",{className:"mt-3",children:e.jsx("b",{children:n("Client id:","bit-integrations")})}),e.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:o,name:"clientId",value:t.clientId,type:"text",placeholder:n("Client id...","bit-integrations"),disabled:s}),e.jsx("div",{style:{color:"red"},children:c.clientId}),e.jsx("div",{className:"mt-3",children:e.jsx("b",{children:n("Client secret:","bit-integrations")})}),e.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:o,name:"clientSecret",value:t.clientSecret,type:"text",placeholder:n("Client secret...","bit-integrations"),disabled:s}),e.jsx("div",{style:{color:"red"},children:c.clientSecret}),!s&&e.jsxs(e.Fragment,{children:[e.jsxs("button",{onClick:()=>P("zohoCampaigns","zcampaigns",R,t,l,j,L,u,a,p),className:"btn btcd-btn-lg green sh-sm flx",type:"button",disabled:d||x,children:[d?n("Authorized ✔","bit-integrations"):n("Authorize","bit-integrations"),x&&e.jsx($,{size:20,clr:"#022217",className:"ml-2"})]}),e.jsx("br",{}),e.jsxs("button",{onClick:S,className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",disabled:!d,children:[n("Next","bit-integrations"),e.jsx(U,{className:"ml-1 rev-icn"})]})]})]})}export{G as default};
