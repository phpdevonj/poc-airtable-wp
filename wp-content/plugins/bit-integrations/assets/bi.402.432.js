var w=Object.defineProperty;var j=Object.getOwnPropertySymbols;var C=Object.prototype.hasOwnProperty,A=Object.prototype.propertyIsEnumerable;var v=(i,n,a)=>n in i?w(i,n,{enumerable:!0,configurable:!0,writable:!0,value:a}):i[n]=a,y=(i,n)=>{for(var a in n||(n={}))C.call(n,a)&&v(i,a,n[a]);if(j)for(var a of j(n))A.call(n,a)&&v(i,a,n[a]);return i};import{r as u,j as e,u as T,k as z}from"./main-149.js";import{_ as m,L as _,c as B,B as E,e as D,I as F,s as M}from"./bi.738.82.js";import{S as P}from"./bi.384.918.js";import{L as H,h as U,c as q}from"./bi.653.851.js";import{B as G}from"./bi.150.726.js";import{T as L,t as J}from"./bi.452.742.js";function K({formID:i,lifterLmsConf:n,setLifterLmsConf:a,step:d,setStep:g,isLoading:b,setIsLoading:p,setSnackbar:x}){const[o,h]=u.useState(!1),[l,f]=u.useState(!1),{lifterLms:s}=J,c=()=>{p("auth"),B({},"lifterLms_authorize").then(t=>{t!=null&&t.success&&(h(!0),x({show:!0,msg:m("Connected with LifterLms Successfully","bit-integrations")})),p(!1),f(!0)})},k=t=>{const r=E(n);r[t.target.name]=t.target.value,a(r)};return e.jsxs("div",{className:"btcd-stp-page",style:{width:d===1&&900,height:d===1&&"auto"},children:[(s==null?void 0:s.youTubeLink)&&e.jsx(L,{title:s==null?void 0:s.title,youTubeLink:s==null?void 0:s.youTubeLink}),(s==null?void 0:s.docLink)&&e.jsx(L,{title:s==null?void 0:s.title,docLink:s==null?void 0:s.docLink}),e.jsx("div",{className:"mt-3",children:e.jsx("b",{children:m("Integration Name:","bit-integrations")})}),e.jsx("input",{className:"btcd-paper-inp w-6 mt-1",onChange:k,name:"name",value:n.name,type:"text",placeholder:m("Integration Name...","bit-integrations")}),b==="auth"&&e.jsxs("div",{className:"flx mt-5",children:[e.jsx(_,{size:25,clr:"#022217",className:"mr-2"}),"Checking if LifterLms is active!!!"]}),l&&!o&&!b&&e.jsxs("div",{className:"flx mt-5",style:{color:"red"},children:[e.jsx("span",{className:"btcd-icn mr-2",style:{fontSize:30,marginTop:-5},children:"×"}),"LifterLms plugin must be activated to integrate with Bit Integrations."]}),!o&&e.jsx("button",{onClick:c,className:"btn btcd-btn-lg green sh-sm flx mt-5",type:"button",children:m("Connect","bit-integrations")}),o&&e.jsxs("button",{onClick:()=>g(2),className:"btn btcd-btn-lg green sh-sm flx mt-5",type:"button",disabled:!o,children:[m("Next","bit-integrations"),e.jsx(G,{className:"ml-1 rev-icn"})]})]})}function Z({formFields:i,setFlow:n,flow:a,allIntegURL:d,isInfo:g,edit:b}){const p=T(),{formID:x}=z(),[o,h]=u.useState(!1),[l,f]=u.useState(1),[s,c]=u.useState({show:!1}),k=[{key:"1",label:"Lesson complete for the user"},{key:"2",label:"Section complete for the user"},{key:"3",label:"Enroll user in a course"},{key:"4",label:"Enroll user in a membership"},{key:"5",label:"Course complete for the user"},{key:"6",label:"Unenroll user from a course"},{key:"7",label:"Unenroll user from a membership"}],[t,r]=u.useState({name:"LifterLms",type:"LifterLms",mainAction:"",field_map:[{formField:"",lifterLmsFormField:""}],allActions:k,actions:{}}),N=()=>{if(setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),t.mainAction==="11"&&!q(t)){c({show:!0,msg:"Please map fields to continue."});return}t.mainAction!==""&&f(3)};function S(){switch(t.mainAction){case"1":return t.lessonId===void 0;case"2":return t.sectionId===void 0;case"3":case"5":case"6":return t.courseId===void 0;case"4":case"7":return t.membershipId===void 0;default:return!1}}return e.jsxs("div",{children:[e.jsx(D,{snack:s,setSnackbar:c}),e.jsx("div",{className:"txt-center mt-2",children:e.jsx(P,{step:3,active:l})}),e.jsx(K,{formID:x,lifterLmsConf:t,setLifterLmsConf:r,step:l,setStep:f,isLoading:o,setIsLoading:h,setSnackbar:c}),e.jsxs("div",{className:"btcd-stp-page",style:y({},l===2&&{width:900,height:"auto",overflow:"visible"}),children:[e.jsx(H,{formFields:i,handleInput:I=>U(I,t,r),lifterLmsConf:t,setLifterLmsConf:r,isLoading:o,setIsLoading:h,setSnackbar:c,allIntegURL:d,isInfo:g,edit:b}),e.jsxs("button",{onClick:()=>N(),disabled:!t.mainAction||o||S(),className:"btn f-right btcd-btn-lg green sh-sm flx",type:"button",children:[m("Next","bit-integrations")," ",e.jsx("div",{className:"btcd-icn icn-arrow_back rev-icn d-in-b"})]})]}),e.jsx(F,{step:l,saveConfig:()=>M({flow:a,setFlow:n,allIntegURL:d,navigate:p,conf:t,setIsLoading:h,setSnackbar:c}),isLoading:o,dataConf:t,setDataConf:r,formFields:i})]})}export{Z as default};