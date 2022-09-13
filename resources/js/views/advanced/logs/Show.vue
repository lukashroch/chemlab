<template>
  <layout v-if="entryLoaded" v-bind="{ id, entry }">
    <div class="tab-pane active" role="tabpanel">
      <div class="card-body">
        <div v-for="(entry, idx) in content" :key="`h_${idx}`" class="card mb-2">
          <div class="card-header">
            <h5 class="mb-0">
              <button class="btn btn-link" @click="entry.active = !entry.active">
                <code>{{ entry.stack.substring(0, 50) }}</code>
              </button>
            </h5>
          </div>
          <collapse :active="entry.active" class="card-body">
            <code>
              {{ entry.stack }}
            </code>
          </collapse>
        </div>
      </div>
    </div>
  </layout>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import { showMixin } from '@/components/entry';

export default defineComponent({
  mixins: [showMixin],

  data() {
    return {
      content: [],
    };
  },

  watch: {
    entry(val) {
      if (!val.content) return [];

      this.content = val.content.map((stack) => ({ stack, active: false }));
    },
  },
});
</script>

<style lang="scss" scoped></style>
