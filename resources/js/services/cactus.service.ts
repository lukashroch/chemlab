import axios from 'axios';

const toArray = (data: string) => data.split('\n');

export const cactus = axios.create({
  baseURL: 'https://cactus.nci.nih.gov/chemical/structure',
  headers: {
    'Content-Type': 'text/plain; charset=UTF-8',
  },
});

export const get = async (url: string, params = {}, callback?: (data: string) => string[]) => {
  const { data } = await cactus.get(url, { params });
  return callback ? callback(data) : data;
};

export const inchi = async (search: string) => get(`${search}/stdinchi`);

export const inchikey = async (search: string) => get(`${search}/stdinchikey`);

export const smiles = async (search: string) => get(`${search}/smiles`);

export const ficts = async (search: string) => get(`${search}/ficts`);

export const ficus = async (search: string) => get(`${search}/ficus`);

export const uuuuu = async (search: string) => get(`${search}/uuuuu`);

export const hashisy = async (search: string) => get(`${search}/hashisy`);

export const sdf = async (search: string, query = {}) => {
  const params = { ...{ format: 'sdf', operator: 'remove_hydrogens' }, ...query };
  return get(`${search}/file`, params);
};

export const names = async (search: string) => get(`${search}/names`, {}, toArray);

export const iupac = async (search: string) => get(`${search}/iupac`);

export const cas = async (search: string) => get(`${search}/cas`, {}, toArray);

export const image = async (search: string, query = {}) => {
  const params = { ...{ format: 'png' }, ...query };
  return get(`${search}/image`, params);
};

export const twirl = async (search: string) => get(`${search}/twirl`);

export const mw = async (search: string) => get(`${search}/mw`);

export const formula = async (search: string) => get(`${search}/formula`);
