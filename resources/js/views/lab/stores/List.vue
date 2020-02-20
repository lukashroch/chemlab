<template>
  <div>
    <div class="card mb-4">
      <div v-if="loaded" class="card-body">
        <div class="row">
          <div class="col-auto toolbar-group">
            <create v-if="can({ action: 'create' })"></create>
          </div>
        </div>
      </div>
    </div>
    <ul v-if="stores.length" class="tree">
      <node v-for="store in stores" :key="store.id" :node="store"></node>
    </ul>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import Create from '../../../components/toolbar/Create';
import Node from './Node';

export default {
  name: 'List',

  components: { Create, Node },

  data() {
    return {
      stores: []
    };
  },

  computed: {
    ...mapState({
      loaded(state) {
        return !!Object.keys(state[this.module].refs).length;
      }
    })
  },

  watch: {
    $route(to) {
      const { module } = to.meta;
      this.$store.dispatch(`${module}/request`);
    }
  },

  async created() {
    this.$store.dispatch(`${this.module}/request`);
    const {
      data: { data }
    } = await this.$http.get(this.module);
    this.stores = data;
  }
};
</script>
