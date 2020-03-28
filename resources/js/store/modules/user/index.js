import ApiService from '../../../services/api.service';

const defaultState = () => ({ profile: {}, permissions: [], status: '' });

const state = defaultState();

const getters = {
  can: (state, getters, rootState) => (perm) => {
    if (typeof perm === 'string') return getters.permissions.includes(perm);

    const { module, action } = perm;
    return getters.permissions.includes(`${module ?? rootState.module}-${action}`);
  },
  loggedIn: (state) => !!Object.keys(state.profile).length,
  name: (state) => state.profile.name ?? null,
  permissions: (state) => state.permissions,
  profile: (state) => state.profile,
  settings: (state) => state.profile.settings ?? {},
  socials: (state) => state.profile.socials ?? [],
};

const actions = {
  async request({ commit }, payload = {}) {
    return new Promise((resolve) => {
      const name = 'profile';
      commit('request');
      commit('loading/add', name, { root: true });
      const opt = { withErr: true };

      const call = Object.keys(payload).length
        ? ApiService.put(name, payload, opt)
        : ApiService.get(name, opt);

      call
        .then((res) => commit('success', res.data.data))
        .catch(() => commit('reset'))
        .finally(() => {
          commit('loading/remove', name, { root: true });
          resolve();
        });
    });
  },

  async logout({ commit }) {
    commit('loading/reset', null, { root: true });
    commit('reset');
  },
};

const mutations = {
  request(state) {
    state.status = 'loading';
  },
  success(state, { profile, permissions }) {
    state.status = 'success';
    state.profile = profile;
    state.permissions = permissions;
  },
  reset(state) {
    Object.assign(state, defaultState());
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
