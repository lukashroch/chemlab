<template>
  <layout v-if="entryLoaded" v-bind="{ id, entry }">
    <div class="card-body">
      <h4>Metadata</h4>
      <div class="row">
        <div v-for="(value, key) in audit.data.meta" :key="key" class="col-md-6">
          <div class="row">
            <div class="col-md">
              <strong>{{ key }}</strong>
            </div>
            <div class="col-md">{{ value }}</div>
          </div>
        </div>
      </div>
    </div>
    <table class="table table-striped">
      <tr>
        <th>Attribute</th>
        <th>Old data</th>
        <th>New data</th>
      </tr>
      <tr v-for="(value, key) in audit.data.modified" :key="key">
        <td>{{ key }}</td>
        <td>{{ value.old }}</td>
        <td>{{ value.new }}</td>
      </tr>
    </table>

    <div class="card-body">
      <pagination :meta="meta" @paginate="fetch"></pagination>
    </div>
  </layout>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import type { Dictionary } from '@/types';
import { showMixin } from '@/components/entry';
import Pagination from '@/components/Pagination.vue';
import { useEntry } from '@/stores';

export default defineComponent({
  name: 'Audit',

  components: { Pagination },

  mixins: [showMixin],

  computed: {
    audit(): Dictionary {
      return this.entry.audit;
    },
    meta(): Dictionary {
      const { data, ...rest } = this.entry.audit;
      return rest;
    },
  },

  methods: {
    async fetch(page = 1) {
      const { path } = this.$route;
      await useEntry().request({ path, query: { page } });
    },
  },
});
</script>
