import api from '../../../../services/api.service';

export default {
  async request({ commit, state }) {
    const { name } = state;
    commit('request');
    commit('loading/add', `${name}/refs`, { root: true });

    api
      .get(`${name}/refs`, { withErr: true })
      .then(res => commit('success', res))
      .catch(err => commit('error', err))
      .finally(() => commit('loading/remove', `${name}/refs`, { root: true }));
  }
};
