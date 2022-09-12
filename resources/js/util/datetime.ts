import { format as dfnsFormat } from 'date-fns';

export const formatDate = (date: Date | string | null, format = 'dd.MM.yyyy'): string | null => {
  if (!date) return date;

  const dt = typeof date === 'string' ? new Date(date) : date;
  return dfnsFormat(dt, format);
};

export const today = () => new Date().toISOString().slice(0, 10);
