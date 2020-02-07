import resources from '../../router/resources';
import loading from './loading';
import user from './user';
import list from './generic/list';
import entry from './generic/entry';
import filter from './generic/filter';

const modules = { loading, user };

Object.values(resources).forEach(group =>
  group.items.reduce((acc, item) => {
    const { name } = item;
    acc[name] = {
      ...list(name),
      modules: {
        entry: entry(name),
        filter: filter(name)
      }
    };
    return acc;
  }, modules)
);

export default modules;
