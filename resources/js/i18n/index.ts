import { createI18n } from 'vue-i18n';

import messages from './messages.json';

type MessageSchema = typeof messages.cs;

export default createI18n<[MessageSchema], 'cs' | 'en'>({
  locale: 'cs',
  fallbackLocale: 'cs',
  messages,
  datetimeFormats: {
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
    en: {
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
  },
});
