require('./polyfills');
import ApiRequest from './utils/ApiRequest';

window.Vue = require('vue').default;
window.apiRequest = new ApiRequest();
window.ErrorProcessing = require('./utils/ErrorProcessing').default;

window.importJS = function(url, id) {
  id = 'dynamic-script-' + id;
  if (document.getElementById(id)) {
    return;
  }

  // создаем новый тег script
  const script = document.createElement('script');
  // получаем ссылку на тег head документа
  const head = document.getElementsByTagName('head')[0];
  // устанавливаем тип и uri
  script.type = 'text/javascript';
  script.src = url;
  script.id = id;
  // загружаем скрипт в тег head
  head.appendChild(script);
}

import router from './router/index';
import store from './store';
import App from './components/App';
require('./utils/filters');

Vue.prototype.$eventBus = new Vue();

document.addEventListener('DOMContentLoaded', function() {
  new Vue({
    router,
    store,
    render: h => h(App),
  }).$mount('#app');
});
