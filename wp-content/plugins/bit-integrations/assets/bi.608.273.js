var K=Object.defineProperty;var x=Object.getOwnPropertySymbols;var P=Object.prototype.hasOwnProperty,I=Object.prototype.propertyIsEnumerable;var g=(i,s,a)=>s in i?K(i,s,{enumerable:!0,configurable:!0,writable:!0,value:a}):i[s]=a,m=(i,s)=>{for(var a in s||(s={}))P.call(s,a)&&g(i,a,s[a]);if(x)for(var a of x(s))I.call(s,a)&&g(i,a,s[a]);return i};import{r as j,j as t}from"./main-149.js";import{_ as n,L,N as z}from"./bi.738.82.js";import{h as T}from"./bi.794.797.js";import{T as y,t as _}from"./bi.452.742.js";function F({klaviyoConf:i,setKlaviyoConf:s,step:a,setStep:N,isInfo:r,loading:o,setLoading:A}){const[c,w]=j.useState(!1),[l,b]=j.useState({name:"",authKey:""}),{klaviyo:e}=_,u=d=>{const h=m({},i),p=m({},l);p[d.target.name]="",h[d.target.name]=d.target.value,b(p),s(h)},f=()=>{setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),N(2)},k=`
  <h4> Step of get API Key:</h4>
  <ul>
    <li>Goto Settings and click on <a href="https://www.klaviyo.com/account#api-keys-tab" target='_blank'>API Keys.</a></li>
    <li>Click on Create Private API key.</li>
    <li>Copy the <b>Private API Key</b> and paste into <b>API Key</b> field of your authorization form.</li>
    <li>Finally, click <b>Authorize</b> button.</li>
</ul>
`;return t.jsxs("div",{className:"btcd-stp-page",style:{width:a===1&&900,height:a===1&&"auto"},children:[(e==null?void 0:e.youTubeLink)&&t.jsx(y,{title:e==null?void 0:e.title,youTubeLink:e==null?void 0:e.youTubeLink}),(e==null?void 0:e.docLink)&&t.jsx(y,{title:e==null?void 0:e.title,docLink:e==null?void 0:e.docLink}),t.jsxs("div",{className:"mt-2",children:[t.jsx("div",{className:"my-1",children:t.jsx("b",{children:n("Integration Name:","bit-integrations")})}),t.jsx("input",{className:"btcd-paper-inp w-6 my-1 mx-0",onChange:u,name:"name",value:i.name,type:"text",placeholder:n("Integration Name...","bit-integrations"),disabled:r}),t.jsx("div",{className:"my-1",children:t.jsx("b",{children:n("API Key:","bit-integrations")})}),t.jsx("input",{className:"btcd-paper-inp w-6 my-1 mx-0",onChange:u,name:"authKey",value:i.authKey,type:"text",placeholder:n("API Key...","bit-integrations"),disabled:r}),l.authKey&&t.jsx("div",{className:"mt-1 mb-2 error-msg",children:l.authKey}),t.jsxs("small",{className:"d-blk mt-1",children:[n("To get API key, please visit","bit-integrations"),t.jsx("a",{className:"btcd-link",href:"https://www.klaviyo.com/account#api-keys-tab",target:"_blank",rel:"noreferrer",children:n(" here.","bit-integrations")})]}),!r&&t.jsxs("div",{className:"w-6 d-flx flx-between ",children:[t.jsxs("button",{onClick:()=>T(i,s,b,w,o,A),className:"btn btcd-btn-lg green sh-sm",type:"button",disabled:c||o.auth,children:[c?n("Authorized ✔","bit-integrations"):n("Authorize","bit-integrations"),o.auth&&t.jsx(L,{size:"20",clr:"#022217",className:"ml-2"})]}),t.jsx("br",{}),t.jsxs("button",{onClick:f,className:"btn btcd-btn-lg green sh-sm",type:"button",disabled:!c,children:[n("Next","bit-integrations"),t.jsx("div",{className:"btcd-icn icn-arrow_back rev-icn d-in-b"})]})]}),t.jsx(z,{note:k})]})]})}export{F as default};
