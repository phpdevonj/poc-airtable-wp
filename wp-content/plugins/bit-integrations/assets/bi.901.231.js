var C=Object.defineProperty;var x=Object.getOwnPropertySymbols;var T=Object.prototype.hasOwnProperty,E=Object.prototype.propertyIsEnumerable;var f=(i,s,n)=>s in i?C(i,s,{enumerable:!0,configurable:!0,writable:!0,value:n}):i[s]=n,d=(i,s)=>{for(var n in s||(s={}))T.call(s,n)&&f(i,n,s[n]);if(x)for(var n of x(s))E.call(s,n)&&f(i,n,s[n]);return i};import{r as a,j as e}from"./main-149.js";import{_ as o,L as F,c as M}from"./bi.738.82.js";import{B as _}from"./bi.150.726.js";import{T as p,t as P}from"./bi.452.742.js";function H({formID:i,autonamiConf:s,setAutonamiConf:n,step:m,nextPage:j,setSnackbar:N,isInfo:u}){const[c,L]=a.useState(!1),[k,y]=a.useState({integrationName:""}),[A,S]=a.useState(!1),{autonami:t}=P,[l,h]=a.useState(!1),[v,z]=a.useState(!0);a.useEffect(()=>()=>{z(!1)},[]);const I=()=>{h("auth"),M({},"autonami_authorize").then(r=>{v&&(r!=null&&r.success&&(L(!0),N({show:!0,msg:o("Connect Successfully","bit-integrations")})),S(!0),h(!1))})},w=r=>{const g=d({},s),b=d({},k);b[r.target.name]="",g[r.target.name]=r.target.value,y(b),n(g)};return e.jsx(e.Fragment,{children:e.jsxs("div",{className:"btcd-stp-page",style:{width:m===1&&900,height:m===1&&"auto"},children:[(t==null?void 0:t.youTubeLink)&&e.jsx(p,{title:t==null?void 0:t.title,youTubeLink:t==null?void 0:t.youTubeLink}),(t==null?void 0:t.docLink)&&e.jsx(p,{title:t==null?void 0:t.title,docLink:t==null?void 0:t.docLink}),e.jsx("div",{className:"mt-3",children:e.jsx("b",{children:o("Integration Name:","bit-integrations")})}),e.jsx("input",{className:"btcd-paper-inp w-5 mt-1",onChange:w,name:"name",value:s.name,type:"text",placeholder:o("Integration Name...","bit-integrations"),disabled:u}),A&&!c&&!l&&e.jsxs("div",{className:"flx mt-4",style:{color:"red"},children:[e.jsx("span",{className:"btcd-icn mr-2",style:{fontSize:30,marginTop:-5},children:"×"}),"Please! First Install or Active Autonami Pro Plugin"]}),!u&&e.jsxs(e.Fragment,{children:[e.jsxs("button",{onClick:I,className:"btn btcd-btn-lg green sh-sm flx",type:"button",disabled:c||l,children:[c?o("Connected ✔","bit-integrations"):o("Connect to Autonami","bit-integrations"),l&&e.jsx(F,{size:20,clr:"#022217",className:"ml-2"})]}),e.jsx("br",{}),e.jsxs("button",{onClick:()=>j(2),className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",disabled:!c,children:[o("Next","bit-integrations"),e.jsx(_,{className:"ml-1 rev-icn"})]})]})]})})}export{H as default};
