<template>
  <div class="card mb-3">
    <div class="card-body">
      <div class="row justify-content-center align-items-center">
        <div class="col">
          <h5>{{ $t(`tasks.${group}.${task}._`) }}</h5>
          <span class="text-muted">{{ $t(`tasks.${group}.${task}.description`) }}</span>
        </div>
        <div class="col-auto">
          <button
            class="btn btn-outline-primary"
            :title="actionTitle ?? $t('common.delete')"
            @click.prevent="$emit('action', { group, task })"
          >
            <span class="fas fa-sync"></span>
            {{ actionTitle ?? $t('common.delete') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'Task',

  props: {
    group: {
      type: String,
      required: true,
    },
    task: {
      type: String,
      required: true,
    },
    actionTitle: {
      type: String,
    },
  },

  emits: ['action'],
});
</script>
