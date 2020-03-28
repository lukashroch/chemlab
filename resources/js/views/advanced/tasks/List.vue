<template>
  <div>
    <div v-for="(group, key) in tasks" :key="key" class="mb-4">
      <h4 class="mb-3">
        <span :class="group.icon"></span>
        {{ $t(`tasks.${key}._`) }}
      </h4>
      <task
        v-for="task in group.tasks"
        :key="task"
        :group="key"
        :task="task"
        @action="submitTask"
      ></task>
    </div>
  </div>
</template>

<script>
import HasLoading from '../../../mixins/HasLoading';
import Task from './Task';

export default {
  name: 'TaskList',

  components: { Task },

  mixins: [HasLoading],

  data() {
    return {
      tasks: {
        cache: {
          icon: 'fas fa-archive',
          tasks: ['data', 'sessions', 'views'],
        },
      },
    };
  },

  methods: {
    async submitTask({ group, task }) {
      await this.withLoading(this.$http.get(`${this.module}/${group}/${task}`, { withErr: true }));
      this.$toasted.success(this.$t(`${this.module}.${group}.${task}.done`));
    },
  },
};
</script>

<style lang="scss" scoped></style>
