import Vue from 'vue';
import VueI18n from 'vue-i18n';

import messages from './messages';

Vue.use(VueI18n);

const dateTimeFormats = {
  cs: {
    short: {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric',
    },
    long: {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric',
      hour: 'numeric',
      minute: 'numeric',
    },
  },
};

const lang = document.documentElement.lang.substr(0, 2);

export default new VueI18n({
  locale: lang,
  fallbackLocale: lang,
  dateTimeFormats,
  messages,
});
