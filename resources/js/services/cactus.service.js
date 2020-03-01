import axios from 'axios';

const toArray = data => data.split('\n');

export const cactus = axios.create({
  baseURL: 'https://cactus.nci.nih.gov/chemical/structure',
  headers: {
    'Content-Type': 'text/plain; charset=UTF-8'
  }
});

export const get = async (url, params = {}, callback = null) => {
  const { data } = await cactus.get(url, { params });
  return callback ? callback(data) : data;
};

export const inchi = async search => get(`${search}/stdinchi`);

export const inchikey = async search => get(`${search}/stdinchikey`);

export const smiles = async search => get(`${search}/smiles`);

export const ficts = async search => get(`${search}/ficts`);

export const ficus = async search => get(`${search}/ficus`);

export const uuuuu = async search => get(`${search}/uuuuu`);

export const hashisy = async search => get(`${search}/hashisy`);

export const sdf = async (search, query = {}) => {
  const params = { ...{ format: 'sdf', operator: 'remove_hydrogens' }, ...query };
  return get(`${search}/file`, params);
};

export const names = async search => get(`${search}/names`, {}, toArray);

export const iupac = async search => get(`${search}/iupac`);

export const cas = async search => get(`${search}/cas`, {}, toArray);

export const image = async (search, query = {}) => {
  const params = { ...{ format: 'png' }, ...query };
  return get(`${search}/image`, params);
};

export const twirl = async search => get(`${search}/twirl`);

export const mw = async search => get(`${search}/mw`);

export const formula = async search => get(`${search}/formula`);
