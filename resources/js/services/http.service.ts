import type { AxiosError, AxiosResponse } from 'axios';
import axios from 'axios';
import axiosRetry from 'axios-retry';
import { nanoid } from 'nanoid';

import type { HttpClient, HttpRequestConfig } from '../types';
import { useLoading } from '../stores';

const httpClient: HttpClient = {
  axios: axios.create({
    baseURL: import.meta.env.VITE_URL_API ?? '/api',
    headers: { common: { 'X-Requested-With': 'XMLHttpRequest' } },
  }),

  init(router, userStore) {
    this.mount401Interceptor(router, userStore);

    return this;
  },

  mount401Interceptor(router, userStore) {
    this.axios.interceptors.response.use(
      (response) => response,
      async (err: AxiosError) => {
        const { response: { status } = {} } = err;

        // 401 => signed out, go to home
        if (status === 401) {
          userStore().logout();
          if (router.currentRoute.name !== 'index') router.push({ name: 'index' });
        }

        throw err;
      }
    );
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

axiosRetry(httpClient.axios, { retries: 5, retryDelay: (retryCount) => retryCount * 400 });

export default httpClient;

export const useHttp = () => httpClient;
