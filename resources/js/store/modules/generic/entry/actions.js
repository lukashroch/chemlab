import api from '@/services/api.service';

export default {
  async request({ commit, state }, { path, query }) {
    const { name } = state;
    commit('request');
    commit('loading/add', `${name}/entry`, { root: true });

    api
      .get(path, { params: query, withErr: true })
      .then((res) => commit('success', res))
      .catch((err) => commit('error', err))
      .finally(() => commit('loading/remove', `${name}/entry`, { root: true }));
  },
};
