import axios from 'axios';
import Vue from 'vue';
import router from '../router';
import store from '../store';

export default {
  axios,

  init(baseURL) {
    axios.defaults.baseURL = baseURL;
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    this.mount401Interceptor();
  },

  async get(url, config = {}) {
    return this.request(url, 'get', {}, config);
  },

  async post(url, data = {}, config = {}) {
    return this.request(url, 'post', data, config);
  },

  async put(url, data = {}, config = {}) {
    return this.request(url, 'put', data, config);
  },

  async patch(url, data = {}, config = {}) {
    return this.request(url, 'patch', data, config);
  },

  async delete(url, config = {}) {
    return this.request(url, 'delete', {}, config);
  },

  async request(url, method, data = {}, config = {}) {
    const { withErr = false, ...rest } = config;

    return new Promise((resolve, reject) => {
      axios
        .request({ url, method, data, ...rest })
        .then(res => resolve(res))
        .catch(err => {
          const { response } = err;
          // Show message for anything except 401, 422
          // 401 is intercepted | 422 handled by Form
          if (response && ![401, 422].includes(response.status)) {
            const {
              data: { message }
            } = response;
            Vue.toasted.error(message ?? err.message);
          }

          if (withErr) reject(err);
        });
    });
  },

  mount401Interceptor() {
    axios.interceptors.response.use(
      response => response,
      async err => {
        // Logout the user
        if (err.response.status === 401) {
          store.dispatch('user/logout');
          if (router.currentRoute.name !== 'index') router.push({ name: 'index' });
        }

        throw err;
      }
    );
  }
};
