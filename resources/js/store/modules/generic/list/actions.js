import api from '../../../../services/api.service';

export default {
  async request({ commit, state }) {
    commit('request');
    commit('loading/add', 'refs', { root: true });

    api
      .get(`${state.name}/refs`, { withErr: true })
      .then(res => commit('success', res))
      .catch(err => commit('error', err))
      .finally(() => commit('loading/remove', 'refs', { root: true }));
  }
};
