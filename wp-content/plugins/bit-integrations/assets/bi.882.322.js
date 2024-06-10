var L=Object.defineProperty;var g=Object.getOwnPropertySymbols;var S=Object.prototype.hasOwnProperty,P=Object.prototype.propertyIsEnumerable;var u=(e,n,s)=>n in e?L(e,n,{enumerable:!0,configurable:!0,writable:!0,value:s}):e[n]=s,p=(e,n)=>{for(var s in n||(n={}))S.call(n,s)&&u(e,s,n[s]);if(g)for(var s of g(n))P.call(n,s)&&u(e,s,n[s]);return e};import{r as j,j as t}from"./main-149.js";import{_ as a,L as z,N as I,X as E}from"./bi.738.82.js";import{n as K}from"./bi.265.892.js";import{T as y,t as F}from"./bi.452.742.js";function M({flowluConf:e,setFlowluConf:n,step:s,setStep:k,loading:c,setLoading:N,isInfo:r}){const[o,v]=j.useState(!1),[d,b]=j.useState({api_key:"",company_name:""}),{flowlu:i}=F,_=()=>{setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),e!=null&&e.default,k(2)},m=l=>{const h=p({},e),x=p({},d);x[l.target.name]="",h[l.target.name]=l.target.value,b(x),n(h)},T=()=>{e.company_name?window.open(`https://${e.company_name}.flowlu.com/cabinet/all_settings?section=api`,"_blank","noreferrer"):E.error(a("Company Name is required!","bit-integrations"))},A=`
            <h4>Get the API Key</h4>
            <ul>
                <li>First go to your Flowlu dashboard.</li>
                <li>Click go to your "Profile" from Right top corner</li>
                <li>Then Click "Portal Settings"</li>
                <li>Click go to "API Settings" from "Main Settings"</li>
                <li>Then click "create", Then Copy</li>
            </ul>`;return t.jsxs("div",{className:"btcd-stp-page",style:{width:s===1&&900,height:s===1&&"auto"},children:[(i==null?void 0:i.youTubeLink)&&t.jsx(y,{title:i==null?void 0:i.title,youTubeLink:i==null?void 0:i.youTubeLink}),(i==null?void 0:i.docLink)&&t.jsx(y,{title:i==null?void 0:i.title,docLink:i==null?void 0:i.docLink}),t.jsx("div",{className:"mt-3",children:t.jsx("b",{children:a("Integration Name:","bit-integrations")})}),t.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:m,name:"name",value:e.name,type:"text",placeholder:a("Integration Name...","bit-integrations"),disabled:r}),t.jsx("div",{className:"mt-3",children:t.jsx("b",{children:a("API Key:","bit-integrations")})}),t.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:m,name:"api_key",value:e.api_key,type:"text",placeholder:a("Session Token...","bit-integrations"),disabled:r}),t.jsx("div",{style:{color:"red",fontSize:"15px"},children:d.api_key}),t.jsx("div",{className:"mt-3",children:t.jsx("b",{children:a("Company Name:","bit-integrations")})}),t.jsxs("div",{className:"btcd-input-group w-6 mt-1",children:[t.jsx("div",{className:"btcd-input-group-icon",children:"https://"}),t.jsx("div",{className:"btcd-input-group-area",children:t.jsx("input",{className:"btcd-paper-inp",onChange:m,name:"company_name",value:e.company_name,type:"text",placeholder:a("Link Name...","bit-integrations"),disabled:r})}),t.jsx("div",{className:"btcd-input-group-icon",children:".flowlu.com"})]}),t.jsx("div",{style:{color:"red",fontSize:"15px"},children:d.company_name}),t.jsxs("small",{className:"d-blk mt-3",children:[a("To Get API Key, Please Visit","bit-integrations")," ",t.jsx("a",{className:"btcd-link",onClick:T,children:a("Flowlu API Key","bit-integrations")})]}),t.jsx("br",{}),t.jsx("br",{}),!r&&t.jsxs("div",{children:[t.jsxs("button",{onClick:()=>K(e,n,b,v,c,N),className:"btn btcd-btn-lg green sh-sm flx",type:"button",disabled:o||c.auth,children:[o?a("Authorized ✔","bit-integrations"):a("Authorize","bit-integrations"),c.auth&&t.jsx(z,{size:"20",clr:"#022217",className:"ml-2"})]}),t.jsx("br",{}),t.jsxs("button",{onClick:_,className:"btn ml-auto btcd-btn-lg green sh-sm flx",type:"button",disabled:!o,children:[a("Next","bit-integrations"),t.jsx("div",{className:"btcd-icn icn-arrow_back rev-icn d-in-b"})]})]}),t.jsx(I,{note:A})]})}export{M as default};
