var z=Object.defineProperty,K=Object.defineProperties;var L=Object.getOwnPropertyDescriptors;var x=Object.getOwnPropertySymbols;var E=Object.prototype.hasOwnProperty,N=Object.prototype.propertyIsEnumerable;var A=(t,e,n)=>e in t?z(t,e,{enumerable:!0,configurable:!0,writable:!0,value:n}):t[e]=n,k=(t,e)=>{for(var n in e||(e={}))E.call(e,n)&&A(t,n,e[n]);if(x)for(var n of x(e))N.call(e,n)&&A(t,n,e[n]);return t},I=(t,e)=>K(t,L(e));var b=(t,e,n)=>new Promise((l,u)=>{var r=o=>{try{p(n.next(o))}catch(i){u(i)}},h=o=>{try{p(n.throw(o))}catch(i){u(i)}},p=o=>o.done?l(o.value):Promise.resolve(o.value).then(r,h);p((n=n.apply(t,e)).next())});import{r as g,j as s}from"./main-149.js";import{S,I as j,E as d,G as v,A as w}from"./bi.600.917.js";import{N as G}from"./bi.738.82.js";import{h as m,c as B,a as F}from"./bi.944.806.js";import{T as f,t as R}from"./bi.452.742.js";function Q({mailercloudConf:t,setMailercloudConf:e,step:n,setStep:l,isInfo:u,loading:r,setLoading:h}){const[p,o]=g.useState(!1),[i,y]=g.useState({name:"",authKey:""}),{mailercloud:a}=R,P=()=>b(this,null,function*(){setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),l(2),h(I(k({},r),{page:!0})),(yield F(t,e))&&h(I(k({},r),{page:!1}))}),T=`
  <h4> Step of get API Key:</h4>
  <ul>
    <li>Goto Account and click on <a href="https://app.mailercloud.com/account/api-integrations" target='_blank'>Integration</a></li>
    <li>Click on API Integrations .</li>
    <li>Copy the <b>API Key</b> and paste into <b>API Key</b> field of your authorization form.</li>
    <li>Finally, click <b>Authorize</b> button.</li>
</ul>
`;return s.jsxs(S,{step:n,stepNo:1,style:{width:900,height:"auto"},children:[(a==null?void 0:a.youTubeLink)&&s.jsx(f,{title:a==null?void 0:a.title,youTubeLink:a==null?void 0:a.youTubeLink}),(a==null?void 0:a.docLink)&&s.jsx(f,{title:a==null?void 0:a.title,docLink:a==null?void 0:a.docLink}),s.jsxs("div",{className:"mt-2",children:[s.jsx(j,{label:"Integration Name",name:"name",placeholder:"Integration Name...",value:t.name,onchange:c=>m(c,t,e,i,y)}),s.jsx(j,{label:"API key",name:"authKey",placeholder:"API key...",value:t.authKey,onchange:c=>m(c,t,e,i,y)}),s.jsx(d,{error:i.authKey}),s.jsx(v,{url:"https://app.mailercloud.com/account/api-integrations",info:"To get API key, please visit"}),!u&&s.jsx(w,{onclick:()=>B(t,y,o,r,h),nextPage:P,auth:p,loading:r.auth})]}),s.jsx(G,{note:T})]})}export{Q as default};