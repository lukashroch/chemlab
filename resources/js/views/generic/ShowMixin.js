import hasEntry from './hasEntry';
import mapEntry from './mapEntry';
import mapRefs from './mapRefs';

export default {
  name: 'Show',

  mixins: [hasEntry, mapEntry, mapRefs]
};
