import { defineStore } from 'pinia';

export type AppState = {
  lang: string;
  url: {
    host: string;
    admin: string;
    api: string;
  };
};

export const useApp = defineStore('app', {
  state: (): AppState => ({
    lang: document.documentElement.lang.slice(0, 2),
    url: {
      host: window.location.host,
      admin: import.meta.env.VITE_URL_ADMIN || '/admin',
      api: import.meta.env.VITE_URL_ADMIN_API || '/admin/api',
    },
  }),
});

export type AppStoreDef = typeof useApp;

export type AppStore = ReturnType<AppStoreDef>;
