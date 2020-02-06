import resDefs from '../../router/resources';
import loading from './loading';
import user from './user';
import list from './generic/list';
import entry from './generic/entry';
import filter from './generic/filter';

const modules = { loading, user };

const keys = [];
Object.keys(resDefs).forEach(group => resDefs[group].items.forEach(item => keys.push(item.name)));

keys.forEach(module => {
  modules[module] = {
    ...list(module),
    ...{
      modules: {
        entry,
        filter: filter(module)
      }
    }
  };
});

export default modules;
