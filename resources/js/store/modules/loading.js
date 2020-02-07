const state = { items: [] };

const getters = {
  isLoading: state => !!state.items.length
};

const mutations = {
  add: (state, item) => state.items.push(item),
  remove: (state, item) => (state.items = state.items.filter(i => i !== item)),
  clear: state => (state.items = [])
};

export default {
  namespaced: true,
  state,
  getters,
  mutations
};
