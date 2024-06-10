var u=Object.defineProperty,_=Object.defineProperties;var I=Object.getOwnPropertyDescriptors;var p=Object.getOwnPropertySymbols;var z=Object.prototype.hasOwnProperty,y=Object.prototype.propertyIsEnumerable;var w=(a,t,d)=>t in a?u(a,t,{enumerable:!0,configurable:!0,writable:!0,value:d}):a[t]=d,l=(a,t)=>{for(var d in t||(t={}))z.call(t,d)&&w(a,d,t[d]);if(p)for(var d of p(t))y.call(t,d)&&w(a,d,t[d]);return a},D=(a,t)=>_(a,I(t));import{c as g,_ as c,t as P}from"./bi.738.82.js";const x=(a,t,d,s,n,i,e,r,f)=>{let o=l({},t);if(e){const m=l({},r);m[a.target.name]="",f(l({},m))}switch(o[a.target.name]=a.target.value,a.target.name){case"orgId":o=$(o,s,d,n,i);break;case"department":o=b(o,s,d,n,i);break}d(l({},o))},$=(a,t,d,s,n)=>{var e,r,f,o;const i=l({},a);return i.department="",i.field_map=[{formField:"",zohoFormField:""}],i.actions={},(r=(e=i==null?void 0:i.default)==null?void 0:e.departments)!=null&&r[i.orgId]?((o=(f=i==null?void 0:i.default)==null?void 0:f.departments)==null?void 0:o[i.orgId].length)===1&&(i.field_map=h(i)):q(t,i,d,s,n),i},b=(a,t,d,s,n)=>{var e,r;const i=l({},a);return i.field_map=[{formField:"",zohoFormField:""}],i.actions={},(r=(e=i==null?void 0:i.default)==null?void 0:e.fields)!=null&&r[i.orgId]?i.field_map=h(i):F(t,i,d,s,n),i},M=(a,t,d,s,n)=>{s(!0);const i={formID:a,id:t.id,dataCenter:t.dataCenter,clientId:t.clientId,clientSecret:t.clientSecret,tokenDetails:t.tokenDetails};g(i,"zdesk_refresh_organizations").then(e=>{if(e&&e.success){const r=l({},t);e.data.organizations&&(r.default=D(l({},r.default),{organizations:e.data.organizations})),e.data.tokenDetails&&(r.tokenDetails=e.data.tokenDetails),n({show:!0,msg:c("Portals refreshed","bit-integrations")}),d(l({},r))}else e&&e.data&&e.data.data||!e.success&&typeof e.data=="string"?n({show:!0,msg:`${c("Portals refresh failed Cause:","bit-integrations")}${e.data.data||e.data}. ${c("please try again","bit-integrations")}`}):n({show:!0,msg:c("Portals refresh failed. please try again","bit-integrations")});s(!1)}).catch(()=>s(!1))},q=(a,t,d,s,n)=>{s(!0);const i={formID:a,id:t.id,dataCenter:t.dataCenter,clientId:t.clientId,clientSecret:t.clientSecret,tokenDetails:t.tokenDetails,orgId:t.orgId};g(i,"zdesk_refresh_departments").then(e=>{var r,f;if(e&&e.success){const o=l({},t);o.default.departments||(o.default.departments={}),e.data.departments&&(o.default.departments[o.orgId]=e.data.departments),e.data.departments.length===1&&(o.department=e.data.departments[o.orgId][0].departmentName,!((f=(r=o.default)==null?void 0:r.fields)!=null&&f[o.orgId])&&F(a,o,d,s,n)),e.data.tokenDetails&&(o.tokenDetails=e.data.tokenDetails),n({show:!0,msg:c("Departments refreshed","bit-integrations")}),d(l({},o))}else e&&e.data&&e.data.data||!e.success&&typeof e.data=="string"?n({show:!0,msg:P(c("Departments refresh failed Cause: %s. please try again","bit-integrations"),e.data.data||e.data)}):n({show:!0,msg:c("Departments refresh failed. please try again","bit-integrations")});s(!1)}).catch(()=>s(!1))},F=(a,t,d,s,n)=>{s(!0);const i={formID:a,dataCenter:t.dataCenter,clientId:t.clientId,clientSecret:t.clientSecret,tokenDetails:t.tokenDetails,orgId:t.orgId};g(i,"zdesk_refresh_fields").then(e=>{if(e&&e.success){const r=l({},t);e.data.fields?(r.default.fields||(r.default.fields={}),r.default.fields[r.orgId]=l({},e.data),r.field_map=h(r),e.data.tokenDetails&&(r.tokenDetails=e.data.tokenDetails),n({show:!0,msg:c("Fields refreshed","bit-integrations")})):n({show:!0,msg:`${c("Fields refresh failed Cause:","bit-integrations")}${e.data.data||e.data}. ${c("please try again","bit-integrations")}`}),e.data.tokenDetails&&(r.tokenDetails=e.data.tokenDetails),d(l({},r))}else n({show:!0,msg:c("Fields refresh failed. please try again","bit-integrations")});s(!1)}).catch(()=>s(!1))},v=(a,t,d,s,n)=>{s(!0);const i={formID:a,id:t.id,dataCenter:t.dataCenter,clientId:t.clientId,clientSecret:t.clientSecret,tokenDetails:t.tokenDetails,orgId:t.orgId};g(i,"zdesk_refresh_owners").then(e=>{if(e&&e.success){const r=l({},t);r.default.owners||(r.default.owners={}),e.data.owners&&(r.default.owners[r.orgId]=e.data.owners),e.data.tokenDetails&&(r.tokenDetails=e.data.tokenDetails),n({show:!0,msg:c("Owners refreshed","bit-integrations")}),d(l({},r))}else e&&e.data&&e.data.data||!e.success&&typeof e.data=="string"?n({show:!0,msg:`${c("Owners refresh failed Cause:","bit-integrations")}${e.data.data||e.data}. ${c("please try again","bit-integrations")}`}):n({show:!0,msg:c("Owners refresh failed. please try again","bit-integrations")});s(!1)}).catch(()=>s(!1))},E=(a,t,d,s,n)=>{s(!0);const i={formID:a,id:t.id,dataCenter:t.dataCenter,clientId:t.clientId,clientSecret:t.clientSecret,tokenDetails:t.tokenDetails,orgId:t.orgId,departmentId:t.department};g(i,"zdesk_refresh_products").then(e=>{if(e&&e.success){const r=l({},t);r.default.products||(r.default.products={}),e.data.products&&(r.default.products[r.department]=e.data.products),e.data.tokenDetails&&(r.tokenDetails=e.data.tokenDetails),n({show:!0,msg:c("Products refreshed","bit-integrations")}),d(l({},r))}else e&&e.data&&e.data.data||!e.success&&typeof e.data=="string"?n({show:!0,msg:`${c("Products refresh failed Cause:","bit-integrations")}${e.data.data||e.data}. ${c("please try again","bit-integrations")}`}):n({show:!0,msg:c("Products refresh failed. please try again","bit-integrations")});s(!1)}).catch(()=>s(!1))},h=a=>{var t;return a.default.fields[a.orgId].required.length>0?(t=a.default.fields[a.orgId].required)==null?void 0:t.map(d=>({formField:"",zohoFormField:d})):[{formField:"",zohoFormField:""}]},N=a=>!((a!=null&&a.field_map?a.field_map.filter(d=>{var s,n,i;return!d.formField&&d.zohoFormField&&((i=(n=(s=a==null?void 0:a.default)==null?void 0:s.fields)==null?void 0:n[a.orgId])==null?void 0:i.required.indexOf(d.zohoFormField))!==-1}):[]).length>0);export{E as a,M as b,N as c,q as d,F as e,x as h,v as r};
