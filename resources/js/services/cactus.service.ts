import axios from 'axios';

const toArray = (data: string) => data.split('\n');

export const createCactusService = () => {
  const client = axios.create({
    baseURL: 'https://cactus.nci.nih.gov/chemical/structure',
    headers: { 'Content-Type': 'text/plain; charset=UTF-8' },
  });

  const get = async (url: string, params = {}, callback?: (data: string) => string[]) => {
    try {
      const { data } = await client.get(url, { params });
      return callback ? callback(data) : data;
    } catch (err) {
      return null;
    }
  };

  const inchi = async (search: string) => get(`${search}/stdinchi`);

  const inchikey = async (search: string) => get(`${search}/stdinchikey`);

  const smiles = async (search: string) => get(`${search}/smiles`);

  const ficts = async (search: string) => get(`${search}/ficts`);

  const ficus = async (search: string) => get(`${search}/ficus`);

  const uuuuu = async (search: string) => get(`${search}/uuuuu`);

  const hashisy = async (search: string) => get(`${search}/hashisy`);

  const sdf = async (search: string, query = {}) => {
    const params = { ...{ format: 'sdf', operator: 'remove_hydrogens' }, ...query };
    return get(`${search}/file`, params);
  };

  const names = async (search: string) => get(`${search}/names`, {}, toArray);

  const iupac = async (search: string) => get(`${search}/iupac`);

  const cas = async (search: string) => get(`${search}/cas` /*, {}, toArray */);

  const image = async (search: string, query = {}) => {
    const params = { ...{ format: 'png' }, ...query };
    return get(`${search}/image`, params);
  };

  const twirl = async (search: string) => get(`${search}/twirl`);

  const mw = async (search: string) => get(`${search}/mw`);

  const formula = async (search: string) => get(`${search}/formula`);

  return {
    client,
    get,
    inchi,
    inchikey,
    smiles,
    ficts,
    ficus,
    uuuuu,
    hashisy,
    sdf,
    names,
    iupac,
    cas,
    image,
    twirl,
    mw,
    formula,
  };
};

export type CactusService = ReturnType<typeof createCactusService>;

export default createCactusService();
