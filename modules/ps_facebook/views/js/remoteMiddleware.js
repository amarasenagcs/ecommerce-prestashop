(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["remoteMiddleware"],{"2ece":function(e,t,r){"use strict";r.r(t),r.d(t,"remoteMiddlewares",(function(){return o}));var n=r("3b03"),a=r("7a72"),c=r("26fd"),i=r("a7e1");function o(e,t,r){var o;return Object(n["b"])(this,void 0,void 0,(function(){var s,u,d,l,b,w=this;return Object(n["d"])(this,(function(f){switch(f.label){case 0:return Object(a["b"])()?[2,[]]:(s=Object(i["b"])(),u=null!==(o=t.enabledMiddleware)&&void 0!==o?o:{},d=Object.entries(u).filter((function(e){e[0];var t=e[1];return t})).map((function(e){var t=e[0];return t})),l=d.map((function(t){return Object(n["b"])(w,void 0,void 0,(function(){var a,i,o,u;return Object(n["d"])(this,(function(n){switch(n.label){case 0:a=t.replace("@segment/",""),i=a,r&&(i=btoa(a).replace(/=/g,"")),o="".concat(s,"/middleware/").concat(i,"/latest/").concat(i,".js.gz"),n.label=1;case 1:return n.trys.push([1,3,,4]),[4,Object(c["a"])(o)];case 2:return n.sent(),[2,window["".concat(a,"Middleware")]];case 3:return u=n.sent(),e.log("error",u),e.stats.increment("failed_remote_middleware"),[3,4];case 4:return[2]}}))}))})),[4,Promise.all(l)]);case 1:return b=f.sent(),b=b.filter(Boolean),[2,b]}}))}))}}}]);