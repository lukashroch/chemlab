import Vue from 'vue';
import VueClipboard from 'vue-clipboard2';
import VueModal from 'vue-js-modal';
import Storage from 'vue-ls';
import VueScrollTo from 'vue-scrollto';
//@ts-expect-error missing types
import SlideUpDown from 'vue-slide-up-down';
import Toasted from 'vue-toasted';
import {
  Vuetable,
  VuetableFieldCheckbox,
  VuetablePagination,
  VuetablePaginationInfo,
  //@ts-expect-error missing types
} from 'vuetable-2';

import { auth, loading, module } from './mixins';

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

//@ts-expect-error Vue 2.7 types issue
Vue.mixin(auth);
//@ts-expect-error Vue 2.7 types issue
Vue.mixin(loading);
//@ts-expect-error Vue 2.7 types issue
Vue.mixin(module);
