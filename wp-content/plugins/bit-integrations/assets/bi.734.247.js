var L=Object.defineProperty;var j=Object.getOwnPropertySymbols;var S=Object.prototype.hasOwnProperty,T=Object.prototype.propertyIsEnumerable;var k=(s,n,a)=>n in s?L(s,n,{enumerable:!0,configurable:!0,writable:!0,value:a}):s[n]=a,d=(s,n)=>{for(var a in n||(n={}))S.call(n,a)&&k(s,a,n[a]);if(j)for(var a of j(n))T.call(n,a)&&k(s,a,n[a]);return s};import{r as h,j as e}from"./main-149.js";import{B as w}from"./bi.150.726.js";import{_ as i,L as f,c as P}from"./bi.738.82.js";import{T as g,t as C}from"./bi.452.742.js";function M({getgistConf:s,setGetgistConf:n,step:a,setstep:N,isInfo:p}){const[l,A]=h.useState(!1),[b,u]=h.useState({name:"",api_key:""}),[_,z]=h.useState(!1),[c,x]=h.useState(!1),{getgist:t}=C,v=()=>{const r=d({},s);if(!r.name||!r.api_key){u({name:r.name?"":i("Integration name cann't be empty","bit-integrations"),api_key:r.api_key?"":i("API Key cann't be empty","bit-integrations")});return}x("auth");const m={api_key:r.api_key};P(m,"getgist_authorize").then(o=>{o!=null&&o.success&&A(!0),z(!0),x(!1)})},y=r=>{const m=d({},s),o=d({},b);o[r.target.name]="",m[r.target.name]=r.target.value,u(o),n(m)},I=()=>{setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),N(2)};return e.jsxs("div",{className:"btcd-stp-page",style:{width:a===1&&900,height:a===1&&"auto"},children:[(t==null?void 0:t.youTubeLink)&&e.jsx(g,{title:t==null?void 0:t.title,youTubeLink:t==null?void 0:t.youTubeLink}),(t==null?void 0:t.docLink)&&e.jsx(g,{title:t==null?void 0:t.title,docLink:t==null?void 0:t.docLink}),e.jsx("div",{className:"mt-3",children:e.jsx("b",{children:i("Integration Name:","bit-integrations")})}),e.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:y,name:"name",value:s.name,type:"text",placeholder:i("Integration Name...","bit-integrations"),disabled:p}),e.jsx("div",{style:{color:"red",fontSize:"15px"},children:b.name}),e.jsx("div",{className:"mt-3",children:e.jsx("b",{children:i("API Key:","bit-integrations")})}),e.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:y,name:"api_key",value:s.api_key,type:"text",placeholder:i("Integration Name...","bit-integrations"),disabled:p}),e.jsx("div",{style:{color:"red",fontSize:"15px"},children:b.api_key}),e.jsxs("small",{className:"d-blk mt-5",children:[i("To get API , Please Visit","bit-integrations")," ",e.jsx("a",{className:"btcd-link",href:"https://app.getgist.com/projects/jgmmrszy/settings/api-key",target:"_blank",rel:"noreferrer",children:i("Getgist API Console","bit-integrations")})]}),c==="auth"&&e.jsxs("div",{className:"flx mt-5",children:[e.jsx(f,{size:25,clr:"#022217",className:"mr-2"}),"Checking API Key!!!"]}),_&&!l&&!c&&e.jsxs("div",{className:"flx mt-5",style:{color:"red"},children:[e.jsx("span",{className:"btcd-icn mr-2",style:{fontSize:30,marginTop:-5},children:"×"}),"Sorry, API key is invalid"]}),!p&&e.jsxs(e.Fragment,{children:[e.jsxs("button",{onClick:v,className:"btn btcd-btn-lg green sh-sm flx",type:"button",disabled:l||c,children:[l?i("Authorized ✔","bit-integrations"):i("Authorize","bit-integrations"),c&&e.jsx(f,{size:20,clr:"#022217",className:"ml-2"})]}),e.jsx("br",{}),e.jsxs("button",{onClick:()=>I(),className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",disabled:!l,children:[i("Next","bit-integrations"),e.jsx(w,{className:"ml-1 rev-icn"})]})]})]})}export{M as default};
