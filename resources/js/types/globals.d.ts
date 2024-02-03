import type { Permission } from '.';
import type { HttpClient } from './http';

declare module 'vue' {
  interface ComponentCustomProperties {
    $http: HttpClient;

    $http: HttpClient;

    // auth mixin
    can: (perm: string | Permission) => boolean;

    // loading mixin
    isAppLoading: () => boolean;

    // module mixin
    module: string;

    // vue-scrollto
    $scrollTo: (target: string | number | HTMLElement, duration?: number) => void;
  }
}
