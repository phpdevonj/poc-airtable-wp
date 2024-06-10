var S=Object.defineProperty;var F=Object.getOwnPropertySymbols;var b=Object.prototype.hasOwnProperty,y=Object.prototype.propertyIsEnumerable;var _=(i,t,n)=>t in i?S(i,t,{enumerable:!0,configurable:!0,writable:!0,value:n}):i[t]=n,g=(i,t)=>{for(var n in t||(t={}))b.call(t,n)&&_(i,n,t[n]);if(F)for(var n of F(t))y.call(t,n)&&_(i,n,t[n]);return i};import{_ as u,c as m,d as k}from"./bi.738.82.js";const R=(i,t,n,c,o,d,r,a,s)=>{const e=g({},t);if(r){const f=g({},a);f[i.target.name]="",s(g({},f))}e[i.target.name]=i.target.value,n(g({},e))},$=(i,t,n,c,o)=>{c(!0);const d={formID:i,clientId:t.clientId,clientSecret:t.clientSecret,tokenDetails:t.tokenDetails},r=m(d,"selesforce_campaign_list").then(a=>a&&a.success?(n(s=>{var f;const e=g({},s);return e.default||(e.default={}),(f=e.default)!=null&&f.campaignLists||(e.default.campaignLists={}),a.data.allCampaignLists&&(e.default.campaignLists=a.data.allCampaignLists),a.data.tokenDetails&&(e.tokenDetails=a.data.tokenDetails),e}),c(!1),"Campaign list refreshed"):(c(!1),"Campaign list refresh failed. please try again"));k.promise(r,{success:a=>a,error:u("Error Occurred","bit-integrations"),loading:u("Loading Campaign list...")})},C=(i,t,n,c,o)=>{c(!0);const d={formID:i,clientId:t.clientId,clientSecret:t.clientSecret,tokenDetails:t.tokenDetails};m(d,"selesforce_lead_list").then(r=>r&&r.success?(n(a=>{var e;const s=g({},a);return s.default||(s.default={}),(e=s.default)!=null&&e.leadLists||(s.default.leadLists={}),r.data.leadLists&&(s.default.leadLists=r.data.leadLists),r.data.tokenDetails&&(s.tokenDetails=r.data.tokenDetails),s}),c(!1),"Lead list refreshed"):(c(!1),"Lead list refresh failed. please try again")).catch(()=>c(!1))},P=(i,t,n,c,o)=>{c(!0);const d={formID:i,clientId:t.clientId,clientSecret:t.clientSecret,tokenDetails:t.tokenDetails},r=m(d,"selesforce_contact_list").then(a=>a&&a.success?(n(s=>{var f;const e=g({},s);return e.default||(e.default={}),(f=e.default)!=null&&f.contactLists||(e.default.contactLists={}),a.data.contactLists&&(e.default.contactLists=a.data.contactLists),a.data.tokenDetails&&(e.tokenDetails=a.data.tokenDetails),e}),c(!1),"Contact list refresh successfully."):(c(!1),"Contact list refresh failed. please try again"));k.promise(r,{success:a=>a,error:u("Error Occurred","bit-integrations"),loading:u("Loading Contact list...")})},v=(i,t,n,c,o,d)=>{o(!0);const r={formID:i,actionName:t,clientId:n.clientId,clientSecret:n.clientSecret,tokenDetails:n.tokenDetails},a=m(r,"selesforce_custom_field").then(s=>{var h,p;const e=s&&s.success?s==null?void 0:s.data:[],f=s&&s.success?"Custom field refresh successfully.":(h=s==null?void 0:s.data[0])!=null&&h.message?"Custom field: "+((p=s==null?void 0:s.data[0])==null?void 0:p.message):"Custom field refresh failed. please try again";return c(D=>{const l=D;return l.field_map=[{formField:"",salesmateFormField:""}],s!=null&&s.data&&(t==="contact-create"?l.selesforceFields=[...l.contactFields,...e]:t==="lead-create"?l.selesforceFields=[...l.leadFields,...e]:t==="account-create"?l.selesforceFields=[...l.accountFields,...e]:t==="campaign-create"?l.selesforceFields=[...l.campaignFields,...e]:t==="add-campaign-member"?l.selesforceFields=[...l.campaignMemberStatus,...e]:t==="opportunity-create"?l.selesforceFields=[...l.opportunityFields,...e]:t==="event-create"?l.selesforceFields=[...l.eventFields,...e]:t==="case-create"&&(l.selesforceFields=[...l.caseFields,...e])),l.field_map=L(l),l}),o(!1),f});k.promise(a,{success:s=>s,error:u("Error Occurred","bit-integrations"),loading:u(`Loading ${t} list...`)})},q=(i,t,n,c,o)=>{c(!0);const d={formID:i,clientId:t.clientId,clientSecret:t.clientSecret,tokenDetails:t.tokenDetails},r=m(d,"selesforce_account_list").then(a=>a&&a.success?(n(s=>{var f;const e=g({},s);return e.default||(e.default={}),(f=e.default)!=null&&f.accountLists||(e.default.accountLists={}),a.data.accountLists&&(e.default.accountLists=a.data.accountLists),a.data.tokenDetails&&(e.tokenDetails=a.data.tokenDetails),e}),c(!1),"Account list refreshed"):(c(!1),"Account list refresh failed. please try again"));k.promise(r,{success:a=>a,error:u("Error Occurred","bit-integrations"),loading:u("Loading Account list...")})},z=i=>!((i!=null&&i.field_map?i.field_map.filter(n=>!n.formField||!n.selesforceField||!n.formField==="custom"&&!n.customValue):[]).length>0),L=(i,t)=>{let n=[];n=(i==null?void 0:i.selesforceFields)||[];const c=n.filter(o=>o.required===!0);return c.length>0?c.map(o=>({formField:"",selesforceField:o.key})):[{formField:"",selesforceField:""}]},E=(i,t,n,c,o,d)=>{if(!i.clientId||!i.clientSecret){n({clientId:i.clientId?"":u("Client ID cann't be empty","bit-integrations"),clientSecret:i.clientSecret?"":u("Secret key cann't be empty","bit-integrations")});return}o(!0);const r=`https://login.salesforce.com/services/oauth2/authorize?response_type=code&client_id=${i.clientId}&prompt=login%20consent&redirect_uri=${encodeURIComponent(window.location.href)}/redirect`,a=window.open(r,"salesforce","width=400,height=609,toolbar=off"),s=setInterval(()=>{if(a.closed){clearInterval(s);let e={},f=!1;const h=localStorage.getItem("__salesforce");if(h&&(f=!0,e=JSON.parse(h),localStorage.removeItem("__salesforce")),console.log(e),!e.code||e.error||!e||!f){const p=e.error?`Cause: ${e.error}`:"";d({show:!0,msg:`${u("Authorization failed","bit-integrations")} ${p}. ${u("please try again","bit-integrations")}`}),o(!1)}else{const p=g({},i);p.accountServer=e["accounts-server"],w(e,p,t,c,o,d)}}},500)},w=(i,t,n,c,o,d)=>{const r=g({},i);r.clientId=t.clientId,r.clientSecret=t.clientSecret,r.redirectURI=`${encodeURIComponent(window.location.href)}/redirect`,m(r,"selesforce_generate_token").then(a=>{if(a&&a.success){const s=g({},t);s.tokenDetails=a.data,n(s),c(!0),d({show:!0,msg:u("Authorized Successfully","bit-integrations")})}else a&&a.data&&a.data.data||!a.success&&typeof a.data=="string"?d({show:!0,msg:`${u("Authorization failed Cause:","bit-integrations")}${a.data.data||a.data}. ${u("please try again","bit-integrations")}`}):d({show:!0,msg:u("Authorization failed. please try again","bit-integrations")});o(!1)})};export{q as a,P as b,z as c,C as d,v as e,E as f,$ as g,R as h};
