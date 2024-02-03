import { formatDate as formatDateTime } from '@/util';

export const useDateTime = () => {
  const formatDate = (date: Date | string | null, format?: string) =>
    date ? formatDateTime(date, format) : date;

  return { formatDate };
};
