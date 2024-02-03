// eslint-disable-next-line simple-import-sort/imports
import pinia from './stores/bootstrap';

import { createApp } from 'vue';
import { createVfm } from 'vue-final-modal';
import VueScrollTo from 'vue-scrollto';
import App from './App.vue';
import i18n from './i18n';
import router from './router';
import guards from './router/guards';
import { httpService, errorHandler, warnHandler } from './services';
import { auth, loading, module } from './mixins';

guards(router);

const app = createApp(App);

app.config.errorHandler = errorHandler;
app.config.warnHandler = warnHandler;

const vfm = createVfm();
app.use(vfm);

app.config.globalProperties.$http = httpService;

app.use(VueScrollTo, {
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

//@ts-expect-error vue mixin type issue
app.mixin(auth);
//@ts-expect-error vue mixin type issue
app.mixin(loading);
//@ts-expect-error vue mixin type issue
app.mixin(module);

app.use(router);
app.use(pinia);
app.use(i18n);

app.mount('#app');
