import api from '../../../../services/api.service';

export default {
  async request({ commit }, { path, query }) {
    return new Promise(resolve => {
      commit('request');
      commit('loading/add', 'entry', { root: true });

      api
        .get(path, { params: query, withErr: true })
        .then(res => commit('success', res))
        .catch(err => commit('error', err))
        .finally(() => {
          commit('loading/remove', 'entry', { root: true });
          resolve();
        });
    });
  }
};
