var T=Object.defineProperty;var y=Object.getOwnPropertySymbols;var f=Object.prototype.hasOwnProperty,I=Object.prototype.propertyIsEnumerable;var N=(r,n,s)=>n in r?T(r,n,{enumerable:!0,configurable:!0,writable:!0,value:s}):r[n]=s,h=(r,n)=>{for(var s in n||(n={}))f.call(n,s)&&N(r,s,n[s]);if(y)for(var s of y(n))I.call(n,s)&&N(r,s,n[s]);return r};import{r as v,j as t}from"./main-149.js";import{B as S}from"./bi.150.726.js";import{_ as i,Y as C,L as E}from"./bi.738.82.js";import{b as B,a as R}from"./bi.50.820.js";import{T as k,t as _}from"./bi.452.742.js";function $({formID:r,mailupConf:n,setMailupConf:s,step:m,setStep:z,isLoading:x,setIsLoading:g,setSnackbar:c,redirectLocation:w,isInfo:a}){const[l,L]=v.useState(!1),[o,j]=v.useState({dataCenter:"",clientId:""}),{mailup:e}=_,A=()=>{setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),z(2),R(n,s,g,c)},d=b=>{const u=h({},n),p=h({},o);p[b.target.name]="",u[b.target.name]=b.target.value,j(p),s(u)};return t.jsxs("div",{className:"btcd-stp-page",style:{width:m===1&&900,height:m===1&&"auto"},children:[(e==null?void 0:e.youTubeLink)&&t.jsx(k,{title:e==null?void 0:e.title,youTubeLink:e==null?void 0:e.youTubeLink}),(e==null?void 0:e.docLink)&&t.jsx(k,{title:e==null?void 0:e.title,docLink:e==null?void 0:e.docLink}),t.jsx("div",{className:"mt-3",children:t.jsx("b",{children:i("Integration Name:","bit-integrations")})}),t.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:d,name:"name",value:n.name,type:"text",placeholder:i("Integration Name...","bit-integrations"),disabled:a}),t.jsx("div",{className:"mt-3",children:t.jsx("b",{children:i("Authorized Redirect URIs:","bit-integrations")})}),t.jsx(C,{value:w||`${window.location.href}`,className:"field-key-cpy w-6 ml-0",readOnly:a,setSnackbar:c}),t.jsx("div",{className:"mt-3",children:t.jsx("b",{children:i("Client id:","bit-integrations")})}),t.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:d,name:"clientId",value:n.clientId,type:"text",placeholder:i("Client id...","bit-integrations"),disabled:a}),t.jsx("div",{style:{color:"red",fontSize:"15px"},children:o.clientId}),t.jsx("div",{className:"mt-3",children:t.jsx("b",{children:i("Client secret:","bit-integrations")})}),t.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:d,name:"clientSecret",value:n.clientSecret,type:"text",placeholder:i("Client secret...","bit-integrations"),disabled:a}),t.jsx("div",{style:{color:"red",fontSize:"15px"},children:o.clientSecret}),!a&&t.jsxs(t.Fragment,{children:[t.jsxs("button",{onClick:()=>B("mailup",n,s,j,L,g,c),className:"btn btcd-btn-lg green sh-sm flx",type:"button",disabled:l||x,children:[l?i("Authorized ✔","bit-integrations"):i("Authorize","bit-integrations"),x&&t.jsx(E,{size:20,clr:"#022217",className:"ml-2"})]}),t.jsx("br",{}),t.jsxs("button",{onClick:A,className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",disabled:!l,children:[i("Next","bit-integrations"),t.jsx(S,{className:"ml-1 rev-icn"})]})]})]})}export{$ as default};
