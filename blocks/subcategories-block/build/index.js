!function(){"use strict";var e,n={253:function(){var e=window.wp.blocks,n=window.wp.element,t=(window.wp.i18n,window.wp.blockEditor,window.wp.data),r=JSON.parse('{"u2":"lvlup-dev/subcategories-block"}');(0,e.registerBlockType)(r.u2,{edit:function(e){const[r,o]=(0,n.useState)([]),i=(0,t.useSelect)((e=>{const{getCurrentPost:n}=e("core/editor"),t=n();return t&&t.categories&&t.categories.length>0?t.categories[0]:null}),[]);return(0,n.useEffect)((()=>{i&&fetch(`/wp-json/wp/v2/categories?parent=${i}`).then((e=>e.json())).then((e=>{o(e)}))}),[i]),(0,n.createElement)("div",{...e},(0,n.createElement)("div",null,"Sous-catégories :"),(0,n.createElement)("ul",null,r.map((e=>(0,n.createElement)("li",{key:e.id},(0,n.createElement)("a",{href:e.link},e.name))))))},save:function(){return null}})}},t={};function r(e){var o=t[e];if(void 0!==o)return o.exports;var i=t[e]={exports:{}};return n[e](i,i.exports,r),i.exports}r.m=n,e=[],r.O=function(n,t,o,i){if(!t){var u=1/0;for(s=0;s<e.length;s++){t=e[s][0],o=e[s][1],i=e[s][2];for(var c=!0,l=0;l<t.length;l++)(!1&i||u>=i)&&Object.keys(r.O).every((function(e){return r.O[e](t[l])}))?t.splice(l--,1):(c=!1,i<u&&(u=i));if(c){e.splice(s--,1);var a=o();void 0!==a&&(n=a)}}return n}i=i||0;for(var s=e.length;s>0&&e[s-1][2]>i;s--)e[s]=e[s-1];e[s]=[t,o,i]},r.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)},function(){var e={826:0,431:0};r.O.j=function(n){return 0===e[n]};var n=function(n,t){var o,i,u=t[0],c=t[1],l=t[2],a=0;if(u.some((function(n){return 0!==e[n]}))){for(o in c)r.o(c,o)&&(r.m[o]=c[o]);if(l)var s=l(r)}for(n&&n(t);a<u.length;a++)i=u[a],r.o(e,i)&&e[i]&&e[i][0](),e[i]=0;return r.O(s)},t=self.webpackChunksubcategories_block=self.webpackChunksubcategories_block||[];t.forEach(n.bind(null,0)),t.push=n.bind(null,t.push.bind(t))}();var o=r.O(void 0,[431],(function(){return r(253)}));o=r.O(o)}();