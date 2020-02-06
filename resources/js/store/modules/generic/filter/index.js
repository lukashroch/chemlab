import actions from './actions';
import getters from './getters';
import state from './state';
import mutations from './mutations';

export default name => ({
  namespaced: true,
  state: state(name),
  getters,
  mutations,
  actions
});
