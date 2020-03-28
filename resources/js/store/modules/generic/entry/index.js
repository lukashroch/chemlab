import actions from './actions';
import getters from './getters';
import mutations from './mutations';
import state from './state';

export default (name) => ({
  namespaced: true,
  state: state(name),
  getters,
  mutations,
  actions,
});
