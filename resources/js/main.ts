// eslint-disable-next-line simple-import-sort/imports
import './bootstrap';
import pinia from './stores/bootstrap';

import Vue from 'vue';

import App from './App.vue';
import i18n from './i18n';
import router from './router';
import guards from './router/guards';
import { errorHandler, httpService, warnHandler } from './services';

guards(router);

Vue.config.productionTip = false;
Vue.config.errorHandler = errorHandler;
// Vue.config.warnHandler = warnHandler;
Vue.prototype.$http = httpService;

new Vue({
  el: '#app',
  i18n,
  pinia,
  router,
  render: (h) => h(App),
});
