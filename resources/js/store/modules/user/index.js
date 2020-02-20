import ApiService from '../../../services/api.service';

const state = { profile: {}, permissions: [], status: '' };

const getters = {
  can: (state, getters, rootState) => perm => {
    if (typeof perm === 'string') return getters.permissions.includes(perm);

    const { module, action } = perm;
    return getters.permissions.includes(`${module ?? rootState.module}-${action}`);
  },
  loaded: state => !!Object.keys(state.profile).length,
  name: state => state.profile.name ?? null,
  permissions: state => state.permissions ?? [],
  settings: state => state.profile.settings ?? {},
  socials: state => state.profile.socials ?? []
};

const actions = {
  async request({ commit }) {
    return new Promise(resolve => {
      commit('request');
      commit('loading/add', 'profile', { root: true });

      ApiService.get('profile', { withErr: true })
        .then(res => commit('load', { status: 'profile', ...res.data.data }))
        .catch(() => commit('clear', { status: 'error' }))
        .finally(() => {
          commit('loading/remove', 'profile', { root: true });
          resolve();
        });
    });
  },

  async logout({ commit }) {
    commit('loading/clear', null, { root: true });
    commit('clear', { status: 'logout' });
  }
};

const mutations = {
  request(state) {
    state.status = 'loading';
  },
  load(state, { status, profile, permissions }) {
    state.status = status;
    state.profile = profile;
    state.permissions = permissions;
  },
  clear(state, { status }) {
    state.status = status;
    state.profile = {};
    state.permissions = [];
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
