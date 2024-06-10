var _=Object.defineProperty;var g=Object.getOwnPropertySymbols;var I=Object.prototype.hasOwnProperty,R=Object.prototype.propertyIsEnumerable;var v=(e,n,s)=>n in e?_(e,n,{enumerable:!0,configurable:!0,writable:!0,value:s}):e[n]=s,o=(e,n)=>{for(var s in n||(n={}))I.call(n,s)&&v(e,s,n[s]);if(g)for(var s of g(n))R.call(n,s)&&v(e,s,n[s]);return e};import{r as N,d as C,j as t}from"./main-149.js";import{m as $,_ as a,Y as y,L as P}from"./bi.738.82.js";import{d as D}from"./bi.328.849.js";import{T as k,t as O}from"./bi.452.742.js";function Z({zohoSheetConf:e,setZohoSheetConf:n,step:s,setStep:w,loading:d,setLoading:L,isInfo:l,setSnackbar:x,redirectLocation:T}){const[m,h]=N.useState(!1),[r,u]=N.useState({dataCenter:"",clientId:"",clientSecret:""}),A=C($),{zohoSheet:i}=O,E=()=>{setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),e!=null&&e.default,w(2)},c=b=>{const p=o({},e),j=o({},r);j[b.target.name]="",p[b.target.name]=b.target.value,u(j),n(p)};return t.jsxs("div",{className:"btcd-stp-page",style:{width:s===1&&900,height:s===1&&"auto"},children:[(i==null?void 0:i.youTubeLink)&&t.jsx(k,{title:i==null?void 0:i.title,youTubeLink:i==null?void 0:i.youTubeLink}),(i==null?void 0:i.docLink)&&t.jsx(k,{title:i==null?void 0:i.title,docLink:i==null?void 0:i.docLink}),t.jsx("div",{className:"mt-3",children:t.jsx("b",{children:a("Integration Name:","bit-integrations")})}),t.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:c,name:"name",value:e.name,type:"text",placeholder:a("Integration Name...","bit-integrations"),disabled:l}),t.jsx("div",{className:"mt-3",children:t.jsx("b",{children:a("Data Center:","bit-integrations")})}),t.jsxs("select",{onChange:c,name:"dataCenter",value:e.dataCenter,className:"btcd-paper-inp w-6 mt-1",disabled:l,children:[t.jsx("option",{value:"",children:a("Select a data center")}),t.jsx("option",{value:"com",children:"zoho.com"}),t.jsx("option",{value:"eu",children:"zoho.eu"}),t.jsx("option",{value:"com.cn",children:"zoho.com.cn"}),t.jsx("option",{value:"in",children:"zoho.in"}),t.jsx("option",{value:"com.au",children:"zoho.com.au"})]}),t.jsx("div",{style:{color:"red",fontSize:"15px"},children:r.dataCenter}),t.jsx("div",{className:"mt-3",children:t.jsx("b",{children:a("Homepage URL:","bit-integrations")})}),t.jsx(y,{value:`${window.location.origin}`,className:"field-key-cpy w-6 ml-0",readOnly:l,setSnackbar:x}),t.jsx("div",{className:"mt-3",children:t.jsx("b",{children:a("Authorized Redirect URIs:","bit-integrations")})}),t.jsx(y,{value:T||`${A.api.base}/redirect`,className:"field-key-cpy w-6 ml-0",readOnly:l,setSnackbar:x}),t.jsxs("small",{className:"d-blk mt-5",children:[a("To get Client ID and SECRET , Please Visit","bit-integrations")," ",t.jsx("a",{className:"btcd-link",href:`https://api-console.zoho.${(e==null?void 0:e.dataCenter)||"com"}/`,target:"_blank",rel:"noreferrer",children:a("Zoho API Console","bit-integrations")})]}),t.jsx("div",{className:"mt-3",children:t.jsx("b",{children:a("Client id:","bit-integrations")})}),t.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:c,name:"clientId",value:e.clientId,type:"text",placeholder:a("Client id...","bit-integrations"),disabled:l}),t.jsx("div",{style:{color:"red",fontSize:"15px"},children:r.clientId}),t.jsx("div",{className:"mt-3",children:t.jsx("b",{children:a("Client secret:","bit-integrations")})}),t.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:c,name:"clientSecret",value:e.clientSecret,type:"text",placeholder:a("Client secret...","bit-integrations"),disabled:l}),t.jsx("div",{style:{color:"red",fontSize:"15px"},children:r.clientSecret}),t.jsx("br",{}),t.jsx("br",{}),!l&&t.jsxs("div",{children:[t.jsxs("button",{onClick:()=>D(e,n,u,h,d,L),className:"btn btcd-btn-lg green sh-sm flx",type:"button",disabled:m||d.auth,children:[m?a("Authorized ✔","bit-integrations"):a("Authorize","bit-integrations"),d.auth&&t.jsx(P,{size:"20",clr:"#022217",className:"ml-2"})]}),t.jsx("br",{}),t.jsxs("button",{onClick:E,className:"btn ml-auto btcd-btn-lg green sh-sm flx",type:"button",disabled:!m,children:[a("Next","bit-integrations"),t.jsx("div",{className:"btcd-icn icn-arrow_back rev-icn d-in-b"})]})]})]})}export{Z as default};