import { defineStore } from 'pinia';

import type { Dictionary } from '@/types';
import { httpService } from '@/services';

export type Option = {
  data: string;
  title: string;
};

export type UpdateField = {
  name: string;
  type: string;
  options: Option[];
};

export interface Filter {
  text?: string;
  pubchem?: string | null;
  chemspider?: string | null;
  formula?: string | null;
  inchikey?: string | null;
  [key: string]: any;
}

export type FilterRefs = Record<string, Option[]>;

export type ListState = {
  name: string;
  data: Dictionary[];
  refs: {
    actions: {
      table: string[];
      toolbar: string[];
    };
    columns: Option[];
    update?: UpdateField[];
    filter?: FilterRefs;
    [key: string]: any;
  };
  filter: Filter;
};

export const useResource = defineStore('resource', {
  state: (): ListState => ({
    name: 'dashboard',
    data: [],
    refs: {
      actions: {
        table: [],
        toolbar: [],
      },
      columns: [],
    },
    filter: {},
  }),
  persist: {
    key: `${import.meta.env.VITE_APP_PREFIX ?? ''}resource`,
    paths: ['filter'],
  },
  getters: {
    dataLoaded: (state) => !!Object.keys(state.data).length,
    refsLoaded: (state) => !!Object.keys(state.refs).length,
    getFilter: (state) => {
      const { name } = state;
      return (name && state.filter[name]) || {};
    },
  },
  actions: {
    update(name: string) {
      this.name = name;
    },

    async request() {
      const { name } = this;
      const { data } = await httpService.get(`${name}/refs`, { withLoading: true });
      this.refs = data;
    },

    async setFilter(filter: Dictionary) {
      this.filter = {
        ...this.filter,
        [this.name]: filter,
      };
    },

    async resetFilter() {
      const { [this.name]: remove, ...rest } = this.filter;

      this.filter = { ...rest };
    },
  },
});

export type ResourceStoreDef = typeof useResource;

export type ResourceStore = ReturnType<ResourceStoreDef>;
