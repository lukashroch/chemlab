import type { AxiosError, AxiosResponse } from 'axios';
import axios from 'axios';
import { nanoid } from 'nanoid';

import type { HttpClient, HttpRequestConfig } from '../types';
import { useLoading } from '../stores';

const httpClient: HttpClient = {
  axios,

  init(baseURL: string) {
    axios.defaults.baseURL = baseURL;
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

    return this;
  },

  mount401Interceptor() {
    this.axios.interceptors.response.use(
      (response) => response,
      async (err: AxiosError) => {
        const { response: { status } = {} } = err;

        // 401 => signed out, go to home
        if (status === 401) {
          window.location.replace('/');
          return;
        }

        // 419 => session exp, refresh
        /* if (status === 419) {
          window.location.reload();
          return;
        } */

        return Promise.reject(err);
      }
    );

    return this;
  },

  async get(url, config) {
    return this.request({ url, method: 'get', ...config });
  },

  async post(url, data, config) {
    return this.request({ url, method: 'post', data, ...config });
  },

  async put(url, data, config) {
    return this.request({ url, method: 'put', data, ...config });
  },

  async patch(url, data, config) {
    return this.request({ url, method: 'patch', data, ...config });
  },

  async delete(url, config) {
    return this.request({ url, method: 'delete', ...config });
  },

  async request<T = any, R = AxiosResponse<T>, D = any>(config: HttpRequestConfig<D>): Promise<R> {
    const { withLoading, ...rest } = config;

    let loading, loadingId;
    if (withLoading) {
      loading = useLoading();
      loadingId = `request-${nanoid(6)}`;
      loading.addItem(loadingId);
    }

    try {
      return await this.axios.request<T, R, D>(rest);
    } finally {
      if (loading && loadingId) loading.removeItem(loadingId);
    }
  },
};

export default httpClient;
