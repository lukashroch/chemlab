import type { ComponentPublicInstance } from 'vue';

import { useErrors } from '../stores';

export const errorHandler = (err: unknown, vm: ComponentPublicInstance | null, info: string) => {
  useErrors().captureError(err, vm, info);
};

export const warnHandler = (msg: string, vm: ComponentPublicInstance | null, trace: string) => {
  useErrors().captureWarn(msg, vm, trace);
};
