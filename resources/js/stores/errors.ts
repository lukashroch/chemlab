import type { AxiosError } from 'axios';
import type { ComponentPublicInstance } from 'vue';
import axios from 'axios';
import { defineStore } from 'pinia';

import { useMessages } from './messages';

export type VueError = {
  err: Error;
  info: string;
};

export type ErrorsState = {
  items: VueError[];
};

export const useErrors = defineStore('errors', {
  state: (): ErrorsState => ({ items: [] }),
  actions: {
    captureError(err: unknown, vm: ComponentPublicInstance | null, info: string) {
      this.processError(err, vm, info);
    },

    processError(err: unknown, vm: ComponentPublicInstance | null, info: string) {
      if (axios.isAxiosError(err)) {
        const { response } = err as AxiosError<any>;
        if (response) {
          if ([401, 422].includes(response.status)) return;

          const { data: { message } = {} } = response;
          useMessages().error(message ?? err.message);
        } else useMessages().error(err.message);

        return;
      }

      if (err instanceof Error) useMessages().error(err.message);

      console.error(err);
      console.error(vm);
      console.error(info);
    },

    captureWarn(msg: unknown, vm: ComponentPublicInstance | null, trace: string) {
      this.processWarn(msg, vm, trace);
    },

    processWarn(msg: unknown, vm: ComponentPublicInstance | null, trace: string) {
      console.warn(msg);
      console.warn(vm);
      console.warn(trace);
    },
  },
});

export type ErrorsStoreDef = typeof useErrors;

export type ErrorsStore = ReturnType<ErrorsStoreDef>;
