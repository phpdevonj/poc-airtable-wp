var L=Object.defineProperty;var j=Object.getOwnPropertySymbols;var T=Object.prototype.hasOwnProperty,z=Object.prototype.propertyIsEnumerable;var k=(t,r,s)=>r in t?L(t,r,{enumerable:!0,configurable:!0,writable:!0,value:s}):t[r]=s,b=(t,r)=>{for(var s in r||(r={}))T.call(r,s)&&k(t,s,r[s]);if(j)for(var s of j(r))z.call(r,s)&&k(t,s,r[s]);return t};import{r as h,j as e}from"./main-149.js";import{_ as i,L as I}from"./bi.738.82.js";import{k as w}from"./bi.918.854.js";import{T as N,t as P}from"./bi.452.742.js";function B({insightlyConf:t,setInsightlyConf:r,step:s,setStep:_,loading:o,setLoading:v,isInfo:n}){const[c,g]=h.useState(!1),[l,u]=h.useState({api_key:"",api_url:""}),{insightly:a}=P,A=()=>{setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),t!=null&&t.default,_(2)},d=m=>{const p=b({},t),x=b({},l);x[m.target.name]="",p[m.target.name]=m.target.value,u(x),r(p)};return e.jsxs("div",{className:"btcd-stp-page",style:{width:s===1&&900,height:s===1&&"auto"},children:[(a==null?void 0:a.youTubeLink)&&e.jsx(N,{title:a==null?void 0:a.title,youTubeLink:a==null?void 0:a.youTubeLink}),(a==null?void 0:a.docLink)&&e.jsx(N,{title:a==null?void 0:a.title,docLink:a==null?void 0:a.docLink}),e.jsx("div",{className:"mt-3",children:e.jsx("b",{children:i("Integration Name:","bit-integrations")})}),e.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:d,name:"name",value:t.name,type:"text",placeholder:i("Integration Name...","bit-integrations"),disabled:n}),e.jsx("div",{className:"mt-3",children:e.jsx("b",{children:i("Your API URL:","bit-integrations")})}),e.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:d,name:"api_url",value:t.api_url,type:"text",placeholder:i("Your Organisation...","bit-integrations"),disabled:n}),e.jsx("div",{style:{color:"red",fontSize:"15px"},children:l.api_url}),e.jsx("small",{className:"d-blk mt-3",children:i("Example: {name}.insightly.com","bit-integrations")}),e.jsx("div",{className:"mt-3",children:e.jsx("b",{children:i("API Key:","bit-integrations")})}),e.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:d,name:"api_key",value:t.api_key,type:"text",placeholder:i("API Token...","bit-integrations"),disabled:n}),e.jsx("div",{style:{color:"red",fontSize:"15px"},children:l.api_key}),t.api_url&&e.jsxs("small",{className:"d-blk mt-3",children:[i("To Get API token, Please Visit","bit-integrations")," ",e.jsx("a",{className:"btcd-link",href:`https://crm.${t.api_url}/Users/UserSettings#`,target:"_blank",rel:"noreferrer",children:i("Insightly API Token","bit-integrations")})]}),e.jsx("br",{}),e.jsx("br",{}),!n&&e.jsxs("div",{children:[e.jsxs("button",{onClick:()=>w(t,r,u,g,o,v),className:"btn btcd-btn-lg green sh-sm flx",type:"button",disabled:c||o.auth,children:[c?i("Authorized ✔","bit-integrations"):i("Authorize","bit-integrations"),o.auth&&e.jsx(I,{size:"20",clr:"#022217",className:"ml-2"})]}),e.jsx("br",{}),e.jsxs("button",{onClick:A,className:"btn ml-auto btcd-btn-lg green sh-sm flx",type:"button",disabled:!c,children:[i("Next","bit-integrations"),e.jsx("div",{className:"btcd-icn icn-arrow_back rev-icn d-in-b"})]})]})]})}export{B as default};
