var $=Object.defineProperty,S=Object.defineProperties;var v=Object.getOwnPropertyDescriptors;var I=Object.getOwnPropertySymbols;var z=Object.prototype.hasOwnProperty,A=Object.prototype.propertyIsEnumerable;var k=(e,s,t)=>s in e?$(e,s,{enumerable:!0,configurable:!0,writable:!0,value:t}):e[s]=t,l=(e,s)=>{for(var t in s||(s={}))z.call(s,t)&&k(e,t,s[t]);if(I)for(var t of I(s))A.call(s,t)&&k(e,t,s[t]);return e},p=(e,s)=>S(e,v(s));var y=(e,s,t)=>new Promise((i,n)=>{var r=c=>{try{a(t.next(c))}catch(m){n(m)}},o=c=>{try{a(t.throw(c))}catch(m){n(m)}},a=c=>c.done?i(c.value):Promise.resolve(c.value).then(r,o);a((t=t.apply(e,s)).next())});import{_ as d,d as u,c as F,F as R,s as q}from"./bi.738.82.js";const T=(e,s,t,i,n)=>{const r=l({},s),o=l({},i),{name:a,value:c}=e.target;o[a]="",r[a]=c,n(o),t(r)},D=(e,s,t,i,n,r,o)=>{if(!e.clientId||!e.clientSecret){i({clientId:e.clientId?"":d("Client Id can't be empty"),clientSecret:e.clientSecret?"":d("Client Secret can't be empty")});return}i({}),o(p(l({},r),{auth:!0}));const a=`https://api.notion.com/v1/oauth/authorize?client_id=${e.clientId}&response_type=code&owner=user&state=${encodeURIComponent(window.location.href)}/redirect&redirect_uri=${encodeURIComponent(`${btcbi.api.base}`)}/redirect`,c=window.open(a,"Notion","width=400,height=609,toolbar=off"),m=setInterval(()=>{if(c.closed){clearInterval(m);let f={},h=!1;const _=localStorage.getItem("__notion");if(_&&(h=!0,f=JSON.parse(_),localStorage.removeItem("__notion")),!f.code||f.error||!f||!h){const b=f.error?`Cause: ${f.error}`:"";u.error(`${d("Authorization failed","bit-integrations")} ${b}. ${d("please try again","bit-integrations")}`),o(p(l({},r),{auth:!1}))}else C(f,e,s,n,r,o)}},500)},C=(e,s,t,i,n,r)=>{const o=l({},e);o.clientId=s.clientId,o.clientSecret=s.clientSecret,o.redirectURI=`${btcbi.api.base}/redirect`,F(o,"notion_authorization").then(a=>{if(a&&a.success){const c=l({},s);c.tokenDetails=a.data,t(c),i(!0),u.success(d("Authorized Successfully"))}else a&&a.data&&a.data.data||!a.success&&typeof a.data=="string"?u.error(`${d("Authorization failed Cause:")}${a.data.data||a.data}. ${d("please try again")}`):u.error(d("Authorization failed. please try again"));r(p(l({},n),{auth:!1}))})},U=(e,s,t,i)=>y(void 0,null,function*(){i&&i(p(l({},t),{list:!0}));const n={accessToken:e.tokenDetails.access_token},r=yield F(n,"notion_database_lists");if(r.success&&r.data.results){const o=r==null?void 0:r.data.results.filter(c=>c.object==="database").map(c=>({id:c.id,name:c.title[0].text.content})),a=l({},e);return o&&(a.default||(a.default={}),a.default.databaseLists=o,s(a),i&&(i(p(l({},t),{list:!1})),u.success(d("List refresh successfully")))),!0}return i&&(i(p(l({},t),{list:!1})),u.success(d("List refresh failed"))),!1}),x=(e,s,t,i)=>y(void 0,null,function*(){i&&i(p(l({},t),{field:!0}));const n={accessToken:e.tokenDetails.access_token,databaseId:e.databaseId},r=yield F(n,"notion_database_properties");if(r.success&&r.data.properties){const o=r==null?void 0:r.data.properties,a=[],c=["formula","people","Rollup","Relation","created_by","created_time","last_edited_by","last_edited_time"];for(const f in o){const h={},b=o[f].type;c.includes(b)||(h.label=f,h.key=b,b=="title"?h.required=!0:h.required=!1,a.push(h))}const m=l({},e);return o&&(m.notionFields=a,s(l({},m)),i&&(i(p(l({},t),{field:!1})),u.success(d("field refresh successfully")))),a}return i&&(i(p(l({},t),{field:!1})),u.success(d("field refresh failed"))),!1}),N=e=>{const s=e==null?void 0:e.notionFields.filter(t=>t.required===!0);return s.length>0?s.map(t=>({formFields:"",notionFormFields:t.label})):[{formFields:"",notionFormFields:""}]},w=e=>!((e!=null&&e.field_map?e.field_map.filter(t=>!t.formFields||!t.notionFormFields||!t.formFields==="custom"&&!t.customValue):[]).length>0),E=(e,s,t)=>{if(setTimeout(()=>{document.getElementById("btcd-settings-wrp").scrollTop=0},300),!w(e)){u.error("Please map mandatory fields");return}e.field_map.length>0&&s(t)},M=(e,s,t,i,n,r)=>{r(!0),R(e,s,t,i,n,"","",r).then(a=>{var c;a.success?(u.success((c=a.data)==null?void 0:c.msg),n(t)):u.error(a.data||a)})},V=(e,s,t,i,n,r)=>{if(!w(t)){u.error("Please map mandatory fields");return}q({flow:e,allIntegURL:s,conf:t,navigate:i,edit:n,setIsLoading:r})};export{U as a,x as b,D as c,M as d,N as g,T as h,E as n,V as s};
