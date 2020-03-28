import Vue from 'vue';
import Vuex from 'vuex';
import modules from './modules';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

const defaultState = () => ({
  lang: document.documentElement.lang.substr(0, 2),
  module: null,
  url: {
    host: window.location.host,
    base: process.env.MIX_URL_BASE ?? '/',
    api: process.env.MIX_URL_API ?? '/api',
  },
});

const state = defaultState();

const getters = {
  lang: (state) => state.lang,
  module: (state) => state.module,
  url: (state) => state.url,
};

const actions = {
  module: async ({ commit }, val) => commit('module', val),
};

const mutations = {
  lang: (state, val) => (state.lang = val),
  module: (state, val) => (state.module = val),
};

export default new Vuex.Store({
  modules,
  state,
  getters,
  actions,
  mutations,
  strict: debug,
});
