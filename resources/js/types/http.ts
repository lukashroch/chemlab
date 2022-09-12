import type { AxiosError, AxiosInstance, AxiosRequestConfig, AxiosResponse } from 'axios';
import type Router from 'vue-router';

import type { ValidationErrors } from '../util';
import type { UserStoreDef } from './../stores/user';

export interface HttpRequestConfig<D = any> extends AxiosRequestConfig<D> {
  withLoading?: boolean;
}

export interface HttpResponseData {
  message?: string;
  errors?: ValidationErrors;
  [key: string]: any;
}

export type HttpError = AxiosError<HttpResponseData>;
export type HttpResponse = AxiosResponse<HttpResponseData>;

export interface HttpClient {
  axios: AxiosInstance;
  init(router: Router, userStoreDef: UserStoreDef): HttpClient;
  mount401Interceptor(router: Router, userStoreDef: UserStoreDef): void;
  get<T = any, R = AxiosResponse<T>, D = any>(
    url: string,
    config?: HttpRequestConfig<D>
  ): Promise<R>;
  post<T = any, R = AxiosResponse<T>, D = any>(
    url: string,
    data?: D,
    config?: HttpRequestConfig<D>
  ): Promise<R>;
  put<T = any, R = AxiosResponse<T>, D = any>(
    url: string,
    data?: D,
    config?: HttpRequestConfig<D>
  ): Promise<R>;
  patch<T = any, R = AxiosResponse<T>, D = any>(
    url: string,
    data?: D,
    config?: HttpRequestConfig<D>
  ): Promise<R>;
  delete<T = any, R = AxiosResponse<T>, D = any>(
    url: string,
    config?: HttpRequestConfig<D>
  ): Promise<R>;
  request<T = any, R = AxiosResponse<T>, D = any>(config: HttpRequestConfig<D>): Promise<R>;
}
