import Vue from 'vue';
import Vuex from 'vuex';
import modules from './modules';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

const state = {
  lang: document.documentElement.lang.substr(0, 2),
  url: {
    host: window.location.host,
    admin: process.env.MIX_URL_ADMIN ?? '/admin',
    api: process.env.MIX_URL_ADMIN_API ?? '/admin/api'
  },
  module: null
};

const getters = {
  module: state => state.module
};

const mutations = {
  setModule(state, module) {
    state.module = module;
  }
};

export default new Vuex.Store({
  modules,
  state,
  getters,
  mutations,
  strict: debug
});
