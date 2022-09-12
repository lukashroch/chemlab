import { defineStore } from 'pinia';

import type { Dictionary } from '@/types';
import { httpService } from '@/services';

import { useLoading } from '.';
import { useResource } from './resource';

export type EntryState = {
  data: Dictionary;
  refs: Dictionary;
  addons: Dictionary;
};

export const useEntry = defineStore('entry', {
  state: (): EntryState => ({
    data: {},
    refs: {},
    addons: {},
  }),
  getters: {
    getEntry: <T>(state: EntryState): T => state.data as T,
    dataLoaded: (state) => !!Object.keys(state.data).length,
    getRefs: (state: EntryState) => state.refs,
    refsLoaded: (state) => !!Object.keys(state.refs).length,
  },
  actions: {
    async request({ path, query }: { path: string; query?: Dictionary }) {
      const { name } = useResource();
      const loading = useLoading();

      this.clearEntry();
      loading.addItem(`${name}/entry`);

      try {
        const { data } = await httpService.get(path, { params: query });
        this.update(data);
      } finally {
        loading.removeItem(`${name}/entry`);
      }
    },

    clearEntry() {
      this.data = {};
      this.refs = {};
      this.addons = {};
    },

    update(entryRes: Dictionary) {
      const { data = {}, refs = {}, ...addons } = entryRes;
      this.data = { ...data };
      this.refs = { ...refs };
      this.addons = { ...addons };
    },

    setEntry(data: Dictionary) {
      this.data = { ...data };
    },
  },
});

export type EntryStoreDef = typeof useEntry;

export type EntryStore = ReturnType<EntryStoreDef>;
