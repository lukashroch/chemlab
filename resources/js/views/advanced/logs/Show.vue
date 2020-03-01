<template>
  <div class="tab-pane active" role="tabpanel">
    <div class="card-body">
      <div v-for="(entry, idx) in content" class="card mb-2" :key="`h_${idx}`">
        <div class="card-header">
          <h5 class="mb-0">
            <button class="btn btn-link" @click="entry.active = !entry.active">
              <code>{{ entry.stack.substring(0, 50) }}</code>
            </button>
          </h5>
        </div>
        <collapse class="card-body" :active="entry.active">
          <code>
            {{ entry.stack }}
          </code>
        </collapse>
      </div>
    </div>
  </div>
</template>

<script>
import ShowMixin from '../../generic/ShowMixin';

export default {
  mixins: [ShowMixin],

  data() {
    return {
      content: []
    };
  },

  watch: {
    entry(val) {
      if (!val.content) return [];

      this.content = val.content.map(stack => ({ stack, active: false }));
    }
  }
};
</script>

<style lang="scss" scoped></style>
