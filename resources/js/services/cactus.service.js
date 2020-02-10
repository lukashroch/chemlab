import axios from 'axios';

const toArray = data => data.split('\n');

export const cactus = axios.create({
  baseURL: 'https://cactus.nci.nih.gov/chemical/structure',
  headers: {
    'Content-Type': 'text/plain; charset=UTF-8'
  }
});

export const query = async (url, params = {}, callback = null) => {
  const { data } = await cactus.get(url, { params });
  return callback ? callback(data) : data;
};

export const inchi = async search => query(`${search}/stdinchi`);

export const inchikey = async search => query(`${search}/stdinchikey`);

export const smiles = async search => query(`${search}/smiles`);

export const ficts = async search => query(`${search}/ficts`);

export const ficus = async search => query(`${search}/ficus`);

export const uuuuu = async search => query(`${search}/uuuuu`);

export const hashisy = async search => query(`${search}/hashisy`);

export const sdf = async (search, query = {}) => {
  const params = { ...{ format: 'sdf', operator: 'remove_hydrogens' }, ...query };
  return query(`${search}/file`, params);
};

export const names = async search => query(`${search}/names`, {}, toArray);

export const iupac = async search => query(`${search}/iupac_name`);

export const cas = async search => query(`${search}/cas`, {}, toArray);

export const image = async (search, query = {}) => {
  const params = { ...{ format: 'png' }, ...query };
  return query(`${search}/image`, params);
};

export const twirl = async search => query(`${search}/twirl`);

export const mw = async search => query(`${search}/mw`);

export const formula = async search => query(`${search}/formula`);
