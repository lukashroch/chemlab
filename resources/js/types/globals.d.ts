import type { Toasted } from 'vue-toasted';

import type { Permission } from '.';

declare module 'vue/types/vue' {
  interface Vue {
    $http: HttpClient;

    $toasted: Toasted;

    // auth mixin
    can: (perm: string | Permission) => boolean;

    // loading mixin
    isAppLoading: () => boolean;

    // module mixin
    module: string;
  }
}
