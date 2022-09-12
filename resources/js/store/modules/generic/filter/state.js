import Vue from 'vue';
import Storage from 'vue-ls';

Vue.use(Storage);

export default (name) => ({
  name,
  data: Vue.ls.get(`chemlab-filter-${name}`, {}),
  key: `chemlab-filter-${name}`,
});
