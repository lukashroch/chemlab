import './bootstrap';

import Vue from 'vue';

import App from './App.vue';
import i18n from './i18n';
import router from './router';
import apiService from './services/api.service';
import store from './store';

apiService.init(import.meta.env.VITE_URL_API);
Vue.prototype.$http = apiService;

new Vue({
  el: '#app',
  i18n,
  router,
  store,
  render: (h) => h(App),
});
