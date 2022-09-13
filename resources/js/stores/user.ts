import { defineStore } from 'pinia';

import type { Permission } from '@/types';
import { httpService } from '@/services';

import { useResource } from './resource';

export interface UserState {
  profile: {
    name: string;
    email: string;
    settings: {
      lang: string;
      listing: number;
      socials: { provider: string }[];
    };
  } | null;
  permissions: string[];
}

export const useUser = defineStore('user', {
  state: (): UserState => ({
    permissions: [],
    profile: null,
  }),
  getters: {
    loaded: (state) => !!state.profile,
  },
  actions: {
    can(perm: Permission | string) {
      if (typeof perm === 'string') return this.permissions.includes(perm);

      const { resource, action } = perm;
      return this.permissions.includes(`${resource ? resource : useResource().name}-${action}`);
    },

    async request() {
      const {
        data: {
          data: { permissions, profile },
        },
      } = await httpService.get('profile', { withLoading: true });

      this.permissions = permissions;
      this.profile = profile;
    },

    async update(key: string, value: any) {
      const {
        data: {
          data: { permissions, profile },
        },
      } = await httpService.put('profile', { key, value }, { withLoading: true });

      this.permissions = permissions;
      this.profile = profile;
    },

    logout() {
      this.$reset();
    },
  },
});

export type UserStoreDef = typeof useUser;

export type UserStore = ReturnType<UserStoreDef>;
