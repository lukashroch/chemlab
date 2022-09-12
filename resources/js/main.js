import Vue from 'vue';
import VueClipboard from 'vue-clipboard2';
import VueModal from 'vue-js-modal';
import Storage from 'vue-ls';
import VueScrollTo from 'vue-scrollto';
import SlideUpDown from 'vue-slide-up-down';
import Toasted from 'vue-toasted';
import {
  Vuetable,
  VuetableFieldCheckbox,
  VuetablePagination,
  VuetablePaginationInfo,
} from 'vuetable-2';

import App from './App.vue';
import i18n from './i18n';
import AuthMixin from './mixins/AuthMixin';
import ModuleMixin from './mixins/ModuleMixin';
import router from './router';
import apiService from './services/api.service';
import store from './store';

Vue.use(VueClipboard);
Vue.use(VueModal);
Vue.use(Storage);
Vue.use(Toasted, {
  duration: 10000,
  keepOnHover: true,
  iconPack: 'fontawesome',
});
Vue.use(VueScrollTo, {
  container: 'body',
  duration: 500,
  easing: 'ease',
  offset: 0,
  force: true,
  cancelable: true,
  onStart: false,
  onDone: false,
  onCancel: false,
  x: false,
  y: true,
});

Vue.component('Collapse', SlideUpDown);
Vue.component('Vuetable', Vuetable);
Vue.component('VuetablePagination', VuetablePagination);
Vue.component('VuetablePaginationInfo', VuetablePaginationInfo);
Vue.component('VuetableFieldCheckbox', VuetableFieldCheckbox);

Vue.mixin(AuthMixin);
Vue.mixin(ModuleMixin);

apiService.init(import.meta.env.VITE_URL_API);
Vue.prototype.$http = apiService;

new Vue({
  el: '#app',
  i18n,
  router,
  store,
  render: (h) => h(App),
});
