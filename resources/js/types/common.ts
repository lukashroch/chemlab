export type Dictionary<T = any> = { [key: string]: T };

export type PaginationLink = {
  active: boolean;
  label: string;
  url: string | null;
};

export interface PaginationMeta {
  current_page: number;
  from: number;
  last_page: number;
  links: PaginationLink[];
  path: string;
  per_page: number;
  to: number;
  total: number;
}

export interface Pagination<R = Dictionary> {
  data: R[];
  meta: PaginationMeta;
}

export interface Permission {
  resource?: string;
  action?: string;
}
