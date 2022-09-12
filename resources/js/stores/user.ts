import { defineStore } from 'pinia';

import type { Dictionary, Permission } from '@/types';
import { httpService } from '@/services';

import { useLoading } from '.';
import { useResource } from './resource';

export interface UserState {
  username: string;
  settings: Dictionary;
  permissions: string[];
}

export const useUser = defineStore('user', {
  state: (): UserState => ({ username: '', permissions: [], settings: {} }),
  getters: {
    loaded: (state) => state.username.length > 0,
  },
  actions: {
    can(perm: Permission | string) {
      if (typeof perm === 'string') return this.permissions.includes(perm);

      const { resource, action } = perm;
      return this.permissions.includes(`${resource ? resource : useResource().name}-${action}`);
    },

    async request() {
      const loading = useLoading();
      loading.addItem('user');

      try {
        const {
          data: { username, permissions, settings },
        } = await httpService.get('profile');

        this.username = username;
        this.permissions = permissions;
        this.settings = settings;
      } finally {
        loading.removeItem('user');
      }
    },
  },
});

export type UserStoreDef = typeof useUser;

export type UserStore = ReturnType<UserStoreDef>;
