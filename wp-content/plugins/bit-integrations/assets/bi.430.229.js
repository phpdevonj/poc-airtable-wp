var _=Object.defineProperty;var N=Object.getOwnPropertySymbols;var C=Object.prototype.hasOwnProperty,E=Object.prototype.propertyIsEnumerable;var y=(a,s,i)=>s in a?_(a,s,{enumerable:!0,configurable:!0,writable:!0,value:i}):a[s]=i,o=(a,s)=>{for(var i in s||(s={}))C.call(s,i)&&y(a,i,s[i]);if(N)for(var i of N(s))E.call(s,i)&&y(a,i,s[i]);return a};import{r as k,d as R,j as t}from"./main-149.js";import{m as G,_ as n,Y as w,L as f}from"./bi.738.82.js";import{a as v,g as P}from"./bi.153.738.js";import{T as L,t as $}from"./bi.452.742.js";function V({flowID:a,googleDriveConf:s,setGoogleDriveConf:i,step:b,setStep:g,isLoading:h,setIsLoading:A,setSnackbar:x,redirectLocation:I,isInfo:l}){const[r,S]=k.useState(!1),[c,p]=k.useState({clientId:"",clientSecret:""}),T=R(G),{googleDrive:e}=$,z=()=>{setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),P(a,s,i),g(2)},d=m=>{const u=o({},s),j=o({},c);j[m.target.name]="",u[m.target.name]=m.target.value,p(j),i(u)};return t.jsxs("div",{className:"btcd-stp-page",style:{width:b===1&&900,height:b===1&&"auto"},children:[(e==null?void 0:e.youTubeLink)&&t.jsx(L,{title:e==null?void 0:e.title,youTubeLink:e==null?void 0:e.youTubeLink}),(e==null?void 0:e.docLink)&&t.jsx(L,{title:e==null?void 0:e.title,docLink:e==null?void 0:e.docLink}),t.jsx("div",{className:"mt-3",children:t.jsx("b",{children:n("Integration Name:","bit-integrations")})}),t.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:d,name:"name",value:s.name,type:"text",placeholder:n("Integration Name...","bit-integrations"),disabled:l}),t.jsx("div",{className:"mt-3",children:t.jsx("b",{children:n("Homepage URL:","bit-integrations")})}),t.jsx(w,{value:`${window.location.origin}`,className:"field-key-cpy w-6 ml-0",readOnly:l,setSnackbar:x}),t.jsx("div",{className:"mt-3",children:t.jsx("b",{children:n("Authorized Redirect URIs:","bit-integrations")})}),t.jsx(w,{value:I||`${T.api.base}/redirect`,className:"field-key-cpy w-6 ml-0",readOnly:l,setSnackbar:x}),t.jsxs("small",{className:"d-blk mt-3",children:[n("To Get Client Id & Secret, Please Visit","bit-integrations")," ",t.jsx("a",{className:"btcd-link",href:"https://console.developers.google.com/apis/credentials",target:"_blank",rel:"noreferrer",children:n("Google API Console","bit-integrations")})]}),t.jsx("div",{className:"mt-3",children:t.jsx("b",{children:n("GoogleDrive Client Id:","bit-integrations")})}),t.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:d,name:"clientId",value:s.clientId,type:"text",placeholder:n("Client Id...","bit-integrations"),disabled:l}),t.jsx("div",{style:{color:"red"},children:c.clientId}),t.jsx("div",{className:"mt-3",children:t.jsx("b",{children:n("GoogleDrive Client Secret:","bit-integrations")})}),t.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:d,name:"clientSecret",value:s.clientSecret,type:"text",placeholder:n("Client Secret...","bit-integrations"),disabled:l}),t.jsx("div",{style:{color:"red"},children:c.clientSecret}),!l&&t.jsxs(t.Fragment,{children:[t.jsxs("button",{onClick:()=>v(s,i,S,A,p),className:"btn btcd-btn-lg green sh-sm flx",type:"button",disabled:r||h,children:[r?n("Authorized ✔","bit-integrations"):n("Authorize","bit-integrations"),h&&t.jsx(f,{size:"20",clr:"#022217",className:"ml-2"})]}),t.jsx("br",{}),t.jsxs("button",{onClick:z,className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",disabled:!r,children:[n("Next","bit-integrations"),t.jsx("div",{className:"btcd-icn icn-arrow_back rev-icn d-in-b"})]})]})]})}export{V as default};
