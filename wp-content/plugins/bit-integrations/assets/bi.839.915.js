var c=Object.defineProperty;var d=Object.getOwnPropertySymbols;var m=Object.prototype.hasOwnProperty,p=Object.prototype.propertyIsEnumerable;var h=(a,s,e)=>s in a?c(a,s,{enumerable:!0,configurable:!0,writable:!0,value:e}):a[s]=e,l=(a,s)=>{for(var e in s||(s={}))m.call(s,e)&&h(a,e,s[e]);if(d)for(var e of d(s))p.call(s,e)&&h(a,e,s[e]);return a};import{c as n,l as f}from"./bi.738.82.js";const M=(a,s,e)=>{const t=l({},s);t.name=a.target.value,e(l({},t))},b=(a,s,e,t)=>{e(!0);const o={api_public_key:a.api_public_key};n(o,"zagoMail_lists").then(r=>{if(r&&r.success){const i=l({},a);r.data.zagoMailLists?(i.default||(i.default={}),i.default.zagoMailLists=r.data.zagoMailLists,t({show:!0,msg:f("ZagoMail lists refreshed","bit-integrations")})):t({show:!0,msg:f("No ZagoMail lists found. Try changing the header row number or try again","bit-integrations")}),s(l({},i))}else t({show:!0,msg:f("ZagoMail lists refresh failed. please try again","bit-integrations")});e(!1)}).catch(()=>e(!1))},y=(a,s,e,t)=>{e({tags:!0});const o={api_public_key:a.api_public_key};n(o,"zagoMail_tags").then(r=>{if(r&&r.success){const i=l({},a);r.data.zagoMailTags?(i.tags||(i.tags={}),i.tags=r.data.zagoMailTags,s(l({},i)),t({show:!0,msg:f("ZagoMail tags refreshed","bit-integrations")})):t({show:!0,msg:f("No ZagoMail tags found. Try changing the header row number or try again","bit-integrations")})}else t({show:!0,msg:f("ZagoMail tags refresh failed. please try again","bit-integrations")});e(!1)}).catch(()=>e(!1))},Z=(a,s,e,t)=>{e(!0);const o={api_public_key:a.api_public_key,listId:a.listId};n(o,"zagoMail_refresh_fields").then(r=>{if(r&&r.success){const i=l({},a);if(r.data.zagoMailField){i.default||(i.default={}),i.default.fields=r.data.zagoMailField;const{fields:u}=i.default;i.field_map=Object.values(u).filter(g=>g.required).map(g=>({formField:"",zagoMailField:g.fieldId,required:!0})),t({show:!0,msg:f("ZagoMail fields refreshed","bit-integrations")})}else t({show:!0,msg:f("No ZagoMail fields found. Try changing the header row number or try again","bit-integrations")});s(l({},i))}else t({show:!0,msg:f("ZagoMail fields refresh failed. please try again","bit-integrations")});e(!1)}).catch(()=>e(!1))},F=a=>!((a!=null&&a.field_map?a.field_map.filter(e=>!e.formField&&e.zagoMailField&&e.required):[]).length>0);export{b as a,Z as b,F as c,M as h,y as r};
