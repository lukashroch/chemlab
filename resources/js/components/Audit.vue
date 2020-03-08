<template>
  <div v-if="isAuditLoaded">
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
  </div>
</template>

<script>
import omit from 'lodash/omit';
import Pagination from './Pagination';
import hasEntry from '../views/generic/hasEntry';
import mapEntry from '../views/generic/mapEntry';

export default {
  name: 'Audit',

  components: { Pagination },

  mixins: [hasEntry, mapEntry],

  data() {
    return {
      audit: {},
      meta: {}
    };
  },

  computed: {
    isAuditLoaded() {
      return 'data' in this.audit;
    }
  },

  watch: {
    entry() {
      this.audit = this.entry.audit;
      this.meta = omit(this.audit, ['data']);
    }
  },

  methods: {
    async fetch(page = 1) {
      const { path } = this.$route;
      await this.$store.dispatch(`${this.module}/entry/request`, { path, query: { page } });
    }
  }
};
</script>
