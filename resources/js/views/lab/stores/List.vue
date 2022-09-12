<template>
  <div>
    <div class="card mb-4">
      <div v-if="refsLoaded" class="card-body">
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

<script lang="ts">
import { mapActions, mapState } from 'pinia';
import { defineComponent } from 'vue';

import Create from '@/components/toolbar/Create.vue';
import { useResource } from '@/stores';

import Node from './Node.vue';

export type Store = {
  id: number;
  name: string;
  nodes: Store[];
  parent_id: number | null;
  team_id: number | null;
};

export default defineComponent({
  name: 'StoreList',

  components: { Create, Node },

  data() {
    return {
      stores: [] as Store[],
    };
  },

  computed: {
    ...mapState(useResource, ['refsLoaded']),
  },

  watch: {
    async $route() {
      await this.request();
    },
  },

  async created() {
    await this.request();
    const {
      data: { data },
    } = await this.$http.get(this.module);
    this.stores = data;
  },

  methods: {
    ...mapActions(useResource, ['request']),
  },
});
</script>
