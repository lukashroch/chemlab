<template>
  <layout v-if="entryLoaded" v-bind="{ id, entry }">
    <div class="tab-pane active" role="tabpanel">
      <table class="table table-hover">
        <tbody>
          <tr>
            <th>{{ $t('common.name') }}</th>
            <td>{{ entry.name }}</td>
          </tr>
          <tr>
            <th>{{ $t('common.surname') }}</th>
            <td>{{ entry.surname }}</td>
          </tr>
          <tr>
            <th>{{ $t('users.email') }}</th>
            <td>{{ entry.email }}</td>
          </tr>
        </tbody>
      </table>
      <!-- <div class="card-body">
      <h5>{{ $t('users.roles.assigned') }}</h5>
      <div class="row">
        <div v-for="(roles, team) in entry.roles" :key="team" class="col-md-4 px-3 mb-3">
          <div class="border rounded p-3">
            <h6>{{ team }}</h6>
            <ul>
              <li v-for="role in roles" :key="role" class="mb-2">
                {{ role }}
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div> -->
    </div>
  </layout>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import { showMixin } from '@/components/entry';

export default defineComponent({
  name: 'UserDetail',

  mixins: [showMixin],
});
</script>

<style lang="scss" scoped></style>
