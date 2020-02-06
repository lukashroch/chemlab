import Vue from 'vue';
import VueClipboard from 'vue-clipboard2';
import VueI18n from 'vue-i18n';
import VueModal from 'vue-js-modal';
import Storage from 'vue-ls';
import VueScrollTo from 'vue-scrollto';
import SlideUpDown from 'vue-slide-up-down';
import Toasted from 'vue-toasted';
import {
  Vuetable,
  VuetableFieldCheckbox,
  VuetablePagination,
  VuetablePaginationInfo
} from 'vuetable-2';
import Locale from './vue-i18n-locales';

import AuthMixin from './mixins/AuthMixin';
import ModuleMixin from './mixins/ModuleMixin';

import router from './router';
import store from './store';
import App from './App.vue';
import apiService from './services/api.service';

Vue.use(VueClipboard);
Vue.use(VueModal);
Vue.use(Storage);
Vue.use(Toasted, {
  duration: 10000,
  keepOnHover: true,
  iconPack: 'fontawesome'
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
  y: true
});

Vue.component('collapse', SlideUpDown);
Vue.component('vuetable', Vuetable);
Vue.component('vuetable-pagination', VuetablePagination);
Vue.component('vuetable-pagination-info', VuetablePaginationInfo);
Vue.component('vuetable-field-checkbox', VuetableFieldCheckbox);

Vue.mixin(AuthMixin);
Vue.mixin(ModuleMixin);

apiService.init(process.env.MIX_URL_ADMIN_API);
Vue.prototype.$http = apiService;
// Vue.prototype.$toasted = messageService;

Vue.use(VueI18n);

const dateTimeFormats = {
  cs: {
    short: {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric'
    },
    long: {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric',
      hour: 'numeric',
      minute: 'numeric'
    }
  }
};

const i18n = new VueI18n({
  locale: store.state.lang,
  fallbackLocale: store.state.lang,
  dateTimeFormats,
  messages: Locale
});

// eslint-disable-next-line no-new
new Vue({
  el: '#app',
  i18n,
  router,
  store,
  render: h => h(App)
});
