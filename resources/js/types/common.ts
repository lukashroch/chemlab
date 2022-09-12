export type Dictionary<T = any> = { [key: string]: T };

export interface Permission {
  resource?: string;
  action?: string;
}
