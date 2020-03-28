const defaultState = () => ({ items: [] });

const state = defaultState();

const getters = {
  isLoading: (state) => !!state.items.length,
};

const actions = {
  add: async ({ commit }, item) => commit('add', item),
  remove: async ({ commit }, item) => commit('remove', item),
  reset: async ({ commit }) => commit('reset'),
};

const mutations = {
  add: (state, item) => state.items.push(item),
  remove: (state, item) => (state.items = state.items.filter((i) => i !== item)),
  reset: (state) => Object.assign(state, defaultState()),
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
