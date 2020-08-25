// if (!window.$) {
//   window.$ = jQuery.noConflict();
// }
// console.log($)
import 'core-js/stable';
import 'regenerator-runtime/runtime';

if (module && module.hot) {
  module.hot.accept();
}

import './scss/style.scss';
import './js/main';
