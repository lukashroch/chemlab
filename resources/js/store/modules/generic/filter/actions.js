import Vue from 'vue';

export default {
  set({ commit, state, getters }, payload) {
    commit('set', payload);
    Vue.ls.set(getters.lsKey, state.data, 24 * 60 * 60 * 1000);
  },
  add({ commit, state, getters }, payload) {
    commit('add', payload);
    Vue.ls.set(getters.lsKey, state.data, 24 * 60 * 60 * 1000);
  },
  clear({ commit, getters }) {
    commit('clear');
    Vue.ls.remove(getters.lsKey);
  }
};
