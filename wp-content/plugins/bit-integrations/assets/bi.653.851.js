var M=Object.defineProperty;var N=Object.getOwnPropertySymbols;var D=Object.prototype.hasOwnProperty,V=Object.prototype.propertyIsEnumerable;var m=(c,n,e)=>n in c?M(c,n,{enumerable:!0,configurable:!0,writable:!0,value:e}):c[n]=e,u=(c,n)=>{for(var e in n||(n={}))D.call(n,e)&&m(c,e,n[e]);if(N)for(var e of N(n))V.call(n,e)&&m(c,e,n[e]);return c};import{r as $,j as a,L as E}from"./main-149.js";import{c as x,d as o,_ as i,p,N as R}from"./bi.738.82.js";const B=(c,n,e,d,l,t)=>{const h=u({},n),{name:j}=c.target;c.target.value!==""?h[j]=c.target.value:delete h[j],h[c.target.name]=c.target.value,e(u({},h))},G=c=>!((c.field_map?c.field_map.filter(e=>!e.formField&&!e.lifterLmsFormField):[]).length>0),w=(c,n,e,d)=>{e(!0),x({},"lifterLms_fetch_all_lesson").then(l=>{if(l&&l.success){const t=u({},c);t.default||(t.default={}),l.data&&(t.default.allLesson=l.data),n(u({},t)),e(!1),o.success(i("Lesson fetched successfully","bit-integrations"));return}e(!1),o.error(i("Lesson fetch failed. please try again","bit-integrations"))}).catch(()=>e(!1))},v=(c,n,e,d)=>{e(!0),x({},"lifterLms_fetch_all_section").then(l=>{if(l&&l.success){const t=u({},c);t.default||(t.default={}),l.data&&(t.default.allSection=l.data),n(u({},t)),e(!1),o.success(i("Section fetched successfully","bit-integrations"));return}e(!1),o.error(i("Section fetch failed. please try again","bit-integrations"))}).catch(()=>e(!1))},F=(c,n,e,d)=>{e(!0),x({},"lifterLms_fetch_all_course").then(l=>{if(l&&l.success){const t=u({},c);t.default||(t.default={}),l.data&&(t.default.allCourse=l.data),n(u({},t)),e(!1),o.success(i("Course fetched successfully","bit-integrations"));return}e(!1),o.error(i("Course fetch failed. please try again","bit-integrations"))}).catch(()=>e(!1))},k=(c,n,e,d)=>{e(!0),x({},"lifterLms_fetch_all_membership").then(l=>{if(l&&l.success){const t=u({},c);if(t.default||(t.default={}),l.data)if(t.mainAction==="7"){const h={ID:"All",post_title:"All membership"};t.default.allMembership=[h,...l.data]}else t.default.allMembership=l.data;n(u({},t)),e(!1),o.success(i("Membership fetched successfully","bit-integrations"));return}e(!1),o.error(i("Membership fetch failed. please try again","bit-integrations"))}).catch(()=>e(!1))};function J({formFields:c,handleInput:n,lifterLmsConf:e,setLifterLmsConf:d,isLoading:l,setIsLoading:t,setSnackbar:h,allIntegURL:j,isInfo:H,edit:T}){var S,_,A,y;$.useEffect(()=>{e.mainAction==="1"?w(e,d,t):e.mainAction==="2"?v(e,d,t):["3","5","6"].includes(e.mainAction)?F(e,d,t):["4","7"].includes(e.mainAction)&&k(e,d,t)},[e.mainAction]);const b=(s,r)=>{const g=u({},e);s!==""?g[r]=s:delete g[r],d(u({},g))};return a.jsxs(a.Fragment,{children:[a.jsx("br",{}),a.jsx("b",{className:"wdt-200 d-in-b",children:i("Actions:","bit-integrations")}),a.jsxs("select",{onChange:n,name:"mainAction",value:e.mainAction,className:"btcd-paper-inp w-5",children:[a.jsx("option",{value:"",children:i("Select Actions","bit-integrations")}),e.allActions&&e.allActions.map(({key:s,label:r})=>a.jsx("option",{value:s,children:r},s))]}),a.jsx("br",{}),a.jsx("br",{}),e.mainAction==="1"&&a.jsxs("div",{className:"flx mt-4",children:[a.jsx("b",{className:"wdt-200 d-in-b",children:i("Select lesson: ","bit-integrations")}),a.jsx(p,{className:"w-5",singleSelect:!0,defaultValue:e==null?void 0:e.lessonId,options:((S=e==null?void 0:e.default)==null?void 0:S.allLesson)&&e.default.allLesson.map(s=>({label:s.lesson_title,value:s.lesson_id.toString()})),onChange:s=>b(s,"lessonId")}),a.jsx("button",{onClick:()=>w(e,d,t),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":`'${i("Fetch lesson list","bit-integrations")}'`},type:"button",disabled:l,children:"↻"})]}),e.mainAction==="2"&&a.jsxs("div",{className:"flx mt-4",children:[a.jsx("b",{className:"wdt-200 d-in-b",children:i("Select a Section: ","bit-integrations")}),a.jsx(p,{className:"w-5",singleSelect:!0,defaultValue:e==null?void 0:e.sectionId,options:((_=e==null?void 0:e.default)==null?void 0:_.allSection)&&e.default.allSection.map(s=>({label:s.section_title,value:s.section_id.toString()})),onChange:s=>b(s,"sectionId")}),a.jsx("button",{onClick:()=>v(e,d,t),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":`'${i("Fetch section list","bit-integrations")}'`},type:"button",disabled:l,children:"↻"})]}),["3","5","6"].includes(e.mainAction)&&a.jsxs("div",{className:"flx mt-4",children:[a.jsx("b",{className:"wdt-200 d-in-b",children:i("Select a Course: ","bit-integrations")}),a.jsx(p,{className:"w-5",singleSelect:!0,defaultValue:e==null?void 0:e.courseId,options:((A=e==null?void 0:e.default)==null?void 0:A.allCourse)&&e.default.allCourse.map(s=>({label:s.post_title,value:s.ID.toString()})),onChange:s=>b(s,"courseId")}),a.jsx("button",{onClick:()=>F(e,d,t),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":`'${i("Fetch course list","bit-integrations")}'`},type:"button",disabled:l,children:"↻"})]}),["4","7"].includes(e.mainAction)&&a.jsxs("div",{className:"flx mt-4",children:[a.jsx("b",{className:"wdt-200 d-in-b",children:i("Select a membership: ","bit-integrations")}),a.jsx(p,{className:"w-5",singleSelect:!0,defaultValue:e==null?void 0:e.membershipId,options:((y=e==null?void 0:e.default)==null?void 0:y.allMembership)&&e.default.allMembership.map(s=>({label:s.post_title,value:s.ID.toString()})),onChange:s=>b(s,"membershipId")}),a.jsx("button",{onClick:()=>k(e,d,t),className:"icn-btn sh-sm ml-2 mr-2 tooltip",style:{"--tooltip-txt":`'${i("Fetch membership list","bit-integrations")}'`},type:"button",disabled:l,children:"↻"})]}),a.jsx("br",{}),a.jsx("br",{}),l&&a.jsx(E,{style:{display:"flex",justifyContent:"center",alignItems:"center",height:100,transform:"scale(0.7)"}}),a.jsx(R,{note:"This integration will only work for logged-in users."})]})}export{J as L,G as c,B as h};
