import type { CactusService, SAProductDetails } from '@/services';

export type SDSOption = {
  id: string;
  name: string;
};

export type ChemicalForm = {
  id: number | null;
  name: string | null;
  iupac: string | null;
  synonym: string | null;
  brand_id: number | null;
  catalog_id: string | null;
  cas: string | null;
  pubchem: string | null;
  chemspider: string | null;
  mw: string | null;
  formula: string | null;
  description: string | null;
  structure: {
    inchi: string | null;
    inchikey: string | null;
    sdf: string | null;
    smiles: string | null;
  };
  signal_word: string | null;
  h: string[];
  p: string[];
  r: string[];
  s: string[];
  symbol: string[];
};

export type ChemicalSource = {
  id: string;
  name: string;
  hint: string;
};

export type ChemicalPropertyOptionSACallBack = (
  details: SAProductDetails
) => string | string[] | null;

export type ChemicalPropertyOption = {
  key: string;
  label: string;
  cactusCall?: keyof CactusService | null;
  saCall?: keyof SAProductDetails | null | ChemicalPropertyOptionSACallBack;
};

export type ChemicalPropertyResults = Record<string, { label: string; value: string | string[] }>;
