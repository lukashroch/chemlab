<template>
  <div class="tab-pane active" role="tabpanel">
    <div class="card-body">
      <div v-for="(entry, idx) in content" :key="`h_${idx}`" class="card">
        <div class="card-header">
          <h5 class="mb-0">
            <button class="btn btn-link" @click="entry.active = !entry.active">
              <code>{{ entry.stack.substring(0, 50) }}</code>
            </button>
          </h5>
        </div>
        <slide-up-down class="card-body" :active="entry.active">
          <code>
            {{ entry.stack }}
          </code>
        </slide-up-down>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import ShowMixin from '../../generic/ShowMixin';

export default {
  mixins: [ShowMixin],

  data() {
    return {
      content: []
    };
  },

  computed: mapState(['url']),

  watch: {
    entry(val) {
      if (!val.content) return [];

      this.content = val.content.map(stack => ({ stack, active: false }));
    }
  }
};
</script>

<style scoped></style>
