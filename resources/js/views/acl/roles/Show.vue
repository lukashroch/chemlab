<template>
  <div class="tab-pane active" role="tabpanel">
    <table class="table table-hover">
      <tbody>
        <tr>
          <th>{{ $t('common.title_internal') }}</th>
          <td>{{ entry.name }}</td>
        </tr>
        <tr>
          <th>{{ $t('common.title') }}</th>
          <td>{{ entry.display_name }}</td>
        </tr>
        <tr>
          <th>{{ $t('common.description') }}</th>
          <td>{{ entry.description }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import { showMixin } from '@/views/generic';

export default defineComponent({
  name: 'RoleDetail',

  mixins: [showMixin],
});
</script>

<style lang="scss" scoped></style>
